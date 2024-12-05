<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdopterRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Backpack\CRUD\app\Library\Widget;

/**
 * Class AdopterCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AdopterCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Adopter::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/adopter');
        CRUD::setEntityNameStrings('adopter', 'Opiekunowie');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
         $this->crud->removeButton('create');
        // Add your custom button
        $this->crud->addButtonFromView('top', 'custom_create_adopter', 'custom_create_adopter', 'beginning');
        
        CRUD::column([
            'name' => 'adopterType_type_name',
            'label' => 'Rodzaj',
        ]);
        CRUD::column([
            'name' => 'adopter_type_name',
            'label' => 'Nazwa',
        ]);
        CRUD::column([
            'name' => 'adopter_first_name',
            'label' => 'Imię',
        ]);
        CRUD::column([
            'name' => 'adopter_last_name',
            'label' => 'Nazwisko',
        ]);
        CRUD::column([
            'name' => 'adopter_email',
            'label' => 'Email',
        ]);
        CRUD::column([
            'name' => 'adopter_phone',
            'label' => 'Telefon',
        ]);
        CRUD::column([
            'name' => 'adopter_address',
            'label' => 'Adres',
        ]);
    }

    protected function setupShowOperation()
    {
        CRUD::column([
            'name' => 'adopterType_type_name',
            'label' => 'Rodzaj',
        ]);
        CRUD::column([
            'name' => 'adopter_type_name',
            'label' => 'Nazwa',
        ]);
        CRUD::column([
            'name' => 'adopter_first_name',
            'label' => 'Imię',
        ]);
        CRUD::column([
            'name' => 'adopter_last_name',
            'label' => 'Nazwisko',
        ]);
        CRUD::column([
            'name' => 'adopter_email',
            'label' => 'Email',
        ]);
        CRUD::column([
            'name' => 'adopter_phone',
            'label' => 'Telefon',
        ]);
        CRUD::column([
            'name' => 'adopter_address',
            'label' => 'Adres',
        ]);
        CRUD::column([
            'name' => 'updated_at',
            'label' => 'Zaktualizowano',
        ]);
        CRUD::column([
            'name' => 'created_at',
            'label' => 'Utworzono',
        ]);
    }
    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(AdopterRequest::class);
        Widget::add()->type('script')->content('js/fields.js');
        // Widget::add()->type('script')->content('js/select2.min.js');
        // Widget::add()->type('script')->content('js/select2_createAdopter_blade.js');
        // Widget::add()->type('style')->content('css/select2.css');

        CRUD::field([
            'name' => 'commandory_id',
            'label' => '<i class="la la-flag">&nbsp;</i><strong>Komandoria</strong>',
            'type' => 'select',
            'entity' => 'commandory',  // The relationship method in the model
            'model' => 'App\Models\Commandory',  // The related model
            'attribute' => 'CommandoryFullName',  // The attribute to display (Commandory name)
            'attributes'=> ['id'=>'CommandoryNameSelect'],
            'options'   => (function ($query) {
                return $query->orderBy('commandory_name', 'ASC')->get();  // Sort by name, optional
            }),
            'wrapper' => [
                'class' => 'col-md-4',
            ]
        ]);
        
         CRUD::field([
            'name' => 'adopter_first_name',
            'label' => 'Imię opiekuna',
            'type' => 'text',
            'wrapper' => [
                'class' => 'col-md-4'
            ], 
        ]);

        CRUD::field([
            'name' => 'adopter_last_name',
            'label' => 'Nazwisko opiekuna',
            'type' => 'text',
            'wrapper' => [
                'class' => 'col-md-4'
            ], 
        ]);

        CRUD::field([
            'name' => 'adopter_type_id',
            'label' => 'Rodzaj opiekuna',
            'type' => 'select',
            'entity' => 'adopterType',  // The relationship method in the model
            'model' => 'App\Models\AdopterType',  // The related model
            'attribute' => 'type_name',  // The attribute to display (Commandory name)
            'attributes'=> ['id'=>'AdopterTypeSelect'],
            'options'   => (function ($query) {
                return $query->orderBy('type_name', 'ASC')->get();  // Sort by name, optional
            }),
            'wrapper' => [
                'class' => 'col-md-4',
            ]
        ]);

        CRUD::field([
            'name' => 'adopter_type_name',
            'label' => 'Pełna nazwa',
            'type' => 'text',
            'wrapper' => [
                'class' => 'col-md-4'
            ], 
        ]);

        CRUD::field([
            'name' => 'adopter_email',
            'label' => 'Adres email opiekuna',
            'type' => 'email',
            'wrapper' => [
                'class' => 'col-md-4'
            ], 
        ]);

        CRUD::field([
            'name' => 'adopter_phone',
            'label' => 'Numer telefonu opiekuna',
            'type' => 'text',
            'wrapper' => [
                'class' => 'col-md-4'
            ], 
        ]);

        CRUD::field([
            'name' => 'adopter_address',
            'label' => 'Adres opiekuna',
            'type' => 'text',
            'wrapper' => [
                'class' => 'col-md-4'
            ], 
        ]);

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {    
        //CRUD::setValidation();
        $adopter = $this->crud->getCurrentEntry();
        $this->crud->setTitle('Edycja '. $adopter->adopter_first_name,'edit');
        $this->crud->setHeading($adopter->adopter_first_name . ' ' . $adopter->adopter_last_name,'edit');
        $this->crud->setSubHeading('Edytowanie informacji','edit'); 

        $this->setupCreateOperation();
        CRUD::setValidation();
    }


   /*  protected function checkPermissions(){
            // Define the CRUD operations and their corresponding permissions
        $permissions = [
            'list'   => 'Listowanie opiekunów', // 'view child' permission
            'create' => 'Dodawanie opiekunów',   // 'create child' permission
            'update' => 'Edytowanie opiekunów', // 'update child' permission
            'delete' => 'Usuwanie opiekunów',     // 'delete child' permission
            'show' => 'Przeglądanie opiekunów',     // 'delete child' permission
        ];
        // Check permissions for each operation
        foreach ($permissions as $operation => $permission) {
            if (!backpack_user()->can($permission)) {
                // Deny access to the operation if the user doesn't have the permission
                $this->crud->denyAccess($operation);
            } else {
                // Allow access to the operation if the user has the permission
                $this->crud->allowAccess($operation);
            }
        }
    }  */
     public function calculateRemainingDays($child)
    {
        $currentDate = Carbon::now();
        $adoptionStartDate = Carbon::parse($child->adoption_start_date);
        $lengthOfAdoption = (int)$child->length_of_adoption;
        //Log::info('lengthOfAdoption: ' . $lengthOfAdoption);

        // Calculate the adoption end date
        $adoptionEndDate = $adoptionStartDate->addDays($lengthOfAdoption);

        // Calculate remaining days
        $remainingDays = intval($currentDate->diffInDays($adoptionEndDate, false))+1;

        $child->update([
            'remaining_days_of_adoption'=> $remainingDays,
        ]);
    }
}
