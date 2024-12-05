<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DeclarationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use App\Models\Child;
use App\Models\Adopter;
use App\Models\Assistant;

/**
 * Class DeclarationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DeclarationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Declaration::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/declaration');
        CRUD::setEntityNameStrings('declaration', 'Deklaracje');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
         Widget::add()->type('script')->content('js/select2.min.js');
         Widget::add()->type('script')->content('js/select2_list_blade.js');
         Widget::add()->type('style')->content('css/select2.css');

        CRUD::column([
            'name' => 'evidenceNumber',
            'label' => 'Nr ewidencji',
            'type' => 'text',
        ]);
        CRUD::column([
            'name' => 'child_id',
            'label' => 'Dziecko',
            'type' => 'text',
        ]);
        CRUD::column([
            'name' => 'adopter_id',                // Field in the database for the selected Adopter
            'label' => 'Opiekun',                  // Label for the field
            'type' => 'text',            // Field type
            'wrapper' => [
                'href' =>function($crud, $column, $entry){
                    return backpack_url('adopter/'.$entry->adopter_id.'/show');
                }
            ]
        ]);
        CRUD::column([
            'name' => 'assistant_id',
            'label' => 'Asystent',
            'type' => 'text',
        ]);
        CRUD::column([
            'name' => 'commandory_id',
            'label' => 'Komandoria',
            'type' => 'text',
        ]);
        CRUD::column([
            'name' => 'typeOfAdoption',
            'label' => 'Rodzaj adopcji',
            'type' => 'text',
        ]);
        CRUD::column([
            'name' => 'length_of_adoption',
            'label' => 'Długość adopcji',
            'type' => 'text',
            'suffix' => ' lat',
            'value' => function($entry){
                $days = $entry ->length_of_adoption;
                return intval($days/365);
            },
            'wrapper' => [
                //'class' => 'fs-3'
            ],
        ]);
        CRUD::column([
            'name' => 'adoptionStartDate',
            'label' => 'Data rozpoczęcia adopcji',
            'type' => 'date',
        ]);
        CRUD::column([
            'name' => 'adoptionEndDate',
            'label' => 'Data zakończenia adopcji',
            'type' => 'date',
        ]);
        
        CRUD::addColumn([
            'name' => 'remaining_days_of_adoption',
            'label' => 'Pozostało',
            'type' => 'view',
            'view' => 'vendor.backpack.crud.columns.remaining_days',
        ]);

        CRUD::column([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'text',
        ]);
        CRUD::field([
            'name'  => 'payments_section',
            'label' => 'Manage Payments',
            'type'  => 'custom_payment_field', // You will create this as a custom field in Step 2
        ])->tab('Wpłaty'); 
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        // Widget::add()->type('script')->content('js/fields.js');
        Widget::add()->type('script')->content('js/age_calculation.js');
        //Widget::add()->type('script')->content('js/end_date.js');
        Widget::add()->type('script')->content('js/select2.min.js');
        Widget::add()->type('script')->content('js/select2_createDeclaration_blade.js');
        Widget::add()->type('style')->content('css/select2.css');

        CRUD::setValidation(DeclarationRequest::class);
        
        CRUD::field([
            'name' => 'evidenceNumber',
            'label' => 'Nr ewidencji',
            'type' => 'text',
            'wrapper' => [
                'class' => 'col-md-2'
            ],  
        ])->tab('Dane');

        CRUD::field([
            'name' => 'child_id',
            'label' => '<i class="la la-child">&nbsp;</i><strong>Dziecko</strong>',
            'type' => 'select',
            'entity' => 'child',  // The relationship method in the model
            'model' => 'App\Models\Child',  // The related model
            'attribute' => 'ChildFullName',  // The attribute to display (Commandory name)
            'attributes'=> ['id'=>'ChildNameSelect'],
            'options'   => (function ($query) {
                return $query->orderBy('first_name', 'ASC')->get();  // Sort by name, optional
            }),
            'wrapper' => [
                'class' => 'col-md-4',
            ]
        ])->tab('Dane');
        
        CRUD::field([
            'name' => 'adopter_id',                // Field in the database for the selected Adopter
            'label' => '<i class="la la-user-alt">&nbsp;</i><strong>Opiekun</strong>',                  // Label for the field
            'type' => 'select_grouped',            // Field type
            'entity' => 'adopter',                 // Relationship method in the Child model
            'model' => 'App\Models\Adopter',       // Model for the select options
            'attribute' => 'AdopterFullName',         // Attribute to display as the option label
            'attributes'=> [
                'id'=>'AdopterSelect',
            ],
            'group_by' => 'adopterType',           // Group by the `adopterType` relationship on the Adopter model
            'group_by_attribute' => 'type_name',        // Display attribute in the AdopterType model
            'group_by_relationship_back' => 'adopter',        // Display attribute in the AdopterType model
            /* 'options' => (function ($query) {
                return $query->orderBy('type_name')->get(); // Sort adopters within each group
            }), */
            'wrapper' => [
                'class' => 'col-md-8 my-5',
            ]
        ])->tab('Dane');
        CRUD::field([
            'name' => 'assistant_id',
            'label' => '<i class="la la-user-tie">&nbsp;</i><strong>Asystent</strong>',
            'type' => 'select',
            'entity' => 'assistant',  // The relationship method in the model
            'model' => 'App\Models\Assistant',  // The related model
            'attribute' => 'AssistantFullName',  // The attribute to display (Commandory name)
            'attributes'=> ['id'=>'AssistantNameSelect'],
            'options'   => (function ($query) {
                return $query->orderBy('assistant_first_name', 'ASC')->get();  // Sort by name, optional
            }),
            'wrapper' => [
                'class' => 'col-md-4',
            ]
        ])->tab('Dane');
/*         CRUD::field([
            'name' => 'commandory_id',
            'label' => 'Komandoria',
            'type' => 'select',
            'entity' => 'commandory',  // The relationship method in the model
            'model' => 'App\Models\Commandory',  // The related model
            'attribute' => 'commandory_name',  // The attribute to display (Commandory name)
            'attributes'=> ['id'=>'CommandoryNameSelect'],
            'options'   => (function ($query) {
                return $query->orderBy('commandory_name', 'ASC')->get();  // Sort by name, optional
            }),
            'wrapper' => [
                'class' => 'col-md-4',
            ]
         ]); */
        CRUD::column([
            'name' => 'length_of_adoption',
            'label' => 'Długość adopcji',
            'type' => 'text',
            'suffix' => ' lat',
            'value' => function($entry){
                $days = $entry ->length_of_adoption;
                return intval($days/365);
            },
            'wrapper' => [
                'class' => 'col-md-2'
            ],  
        ])->tab('Dane');

        CRUD::field([
            'name' => 'child.age',
            'label' => 'wiek',
            'type' => 'number',
            'wrapper' => [
                'class' => 'col-md-2'
            ],  
        ])->tab('Dane');

        CRUD::field([
            'name' => 'adoption_start_date',
            'label' => 'Data rozpoczęcia adopcji',
            'type' => 'date',
            'wrapper' => [
                'class' => 'col-md-2'
            ],  
        ])->tab('Dane');
        
        CRUD::field([ 
            'name' => 'type_of_adoption',
            'label' => 'Okres adopcji',
            'type' => 'select_from_array',
            'options' => [
                'niestandardowy' => 'niestandardowy',
                'do uzyskania pełnoletności' => 'do uzyskania pełnoletności',
                //'do ukończenia szkoły' => 'do ukończenia szkoły',
            ],
            'allows_null' => false,
            'wrapper' => [
                'class' => 'col-md-3'
            ],  
        ])->tab('Dane');

        CRUD::field([
            'name' => 'length_of_adoption',
            'type' => 'hidden',
        ]);

        CRUD::field([
            'name' => 'length_of_adoption_years',
            'label' => 'Długość adopcji',
            'type' => 'number',
            'attributes' => ["step" => "1"],
            'wrapper' => [
                'class' => 'col-md-2'
            ],

        ])->suffix("lat")->tab('Dane');

        CRUD::field([
            'name' => 'adoption_end_date',
            'label' => 'Data zakończenia adopcji',
            'type' => 'date',
            'attributes' => [
                'readonly'    => 'readonly',
            ],
            'wrapper' => [
                'class' => 'col-md-2'
            ],  
        ])->tab('Dane');

        CRUD::field([
            'name'  => 'payments_section',
            'label' => 'Manage Payments',
            'type'  => 'custom_payment_field'
        ])->tab('Wpłaty');

        CRUD::field([
            'name'  => 'attachements',
            'label' => 'Pliki',
            'type'  => 'upload_multiple', 
        ])->tab('Załączniki');

    }
     // Optionally, you can customize how payments are stored by overriding the store and update methods
    public function store()
    {
        $response = $this->traitStore();  // Save the child data first

        // After saving the child, handle the related payments
        $this->savePayments($this->crud->entry);
        //$this->calculateRemainingDays($this->crud->entry);
        return $response;
    }

    public function update()
    {
        $response = $this->traitUpdate();  // Save the child data first

        // After updating the child, handle the related payments
        $this->savePayments($this->crud->entry);
        //$this->calculateRemainingDays($this->crud->entry);


        return $response;
    }
    protected function savePayments($child)
    {
        // Clear existing payments if needed (optional)
        $child->payments()->delete();

        // Loop through the submitted payments
        $payments = request()->input('payments', []);
        foreach ($payments as $paymentData) {
            $child->payments()->create([
                'payment_amount' => $paymentData['payment_amount'],
                'payment_date' => $paymentData['payment_date'],
                'payment_description' => $paymentData['payment_description'],
            ]);
        }
    }

    protected function setupShowOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.
    }
    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
