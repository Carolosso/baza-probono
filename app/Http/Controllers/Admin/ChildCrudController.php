<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ChildRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ChildCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ChildCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Child::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/child');
        CRUD::setEntityNameStrings('child', 'Dzieci');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // Add a custom button or override the existing button
        $this->crud->removeButton('create');
    
        // Add your custom button
        $this->crud->addButtonFromView('top', 'custom_create', 'custom_create', 'beginning');
        $this->crud->addColumn([
        'name' => 'remaining_days', // A unique name for the column
        'label' => 'Pozostało dni', // The label displayed in the table
        'type' => 'closure',         // Type: closure
        'function' => function($entry) {
            // Get the current date
            $currentDate = \Carbon\Carbon::now();
            
            // Calculate the adoption end date
            $adoptionStartDate = \Carbon\Carbon::parse($entry->adoption_date); // The start date
            $adoptionEndDate = $adoptionStartDate->addDays($entry->length_of_adoption); // Add the adoption length
            
            // Calculate the remaining days
            $remainingDays = $adoptionEndDate->diffInDays($currentDate, false); // false to get negative days if it's passed
            
            // If the adoption period has already ended, display "0"
            return $remainingDays > 0 ? $remainingDays : 0;
        },
        'searchLogic' => false,  // Disable search on this column
    ]);
        //CRUD::setFromDb(); // set columns from db columns.
        
        CRUD::column([
            'name' => 'image_url',
            'label' => 'Zdjęcie',
            'type' => 'image',
            'prefix' => '/storage/',
            'height' => '20%',
            'width' => '20%',
        ]);
        CRUD::column('Pozostały_czas')->type('remaining_time_column');
        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ChildRequest::class);
        //CRUD::setFromDb(); // set fields from db columns.
        CRUD::field([
            'name' => 'first_name',
            'label' => 'Imię dziecka',
            'type' => 'text'
        ])->tab('Dane dziecka');

        CRUD::field([
            'name' => 'last_name',
            'label' => 'Nazwisko dziecka',
            'type' => 'text'
        ])->tab('Dane dziecka');

        CRUD::field([
            'name' => 'age',
            'label' => 'Wiek',
            'type' => 'number'
        ])->suffix("lat")->tab('Dane dziecka');

        CRUD::field([
            'name' => 'birth_place',
            'label' => 'Miejscowość pochodzenia',
            'type' => 'text'
        ])->tab('Dane dziecka');

        CRUD::field([
            'name' => 'country',
            'label' => 'Kraj pochodzenia',
            'type' => 'text'
        ])->tab('Dane dziecka');


        CRUD::field([
            'name' => 'image_url',
            'type' => 'upload',
            'label' => 'Zdjęcie'          
        ])->withFiles([
        'disk' => 'public', // the disk where file will be stored
        'path' => 'photos'
        ])->tab('Dane dziecka');
        
        CRUD::field([
            'name' => 'adopter_first_name',
            'label' => 'Imię opiekuna',
            'type' => 'text'
        ])->tab('Dane opiekuna');

        CRUD::field([
            'name' => 'adopter_last_name',
            'label' => 'Nazwisko opiekuna',
            'type' => 'text'
        ])->tab('Dane opiekuna');
        
        CRUD::field([
            'name' => 'adopter_last_name',
            'label' => 'Nazwisko opiekuna',
            'type' => 'text'
        ])->tab('Dane opiekuna');

        CRUD::field([
            'name' => 'flag',
            'label' => 'Nazwa chorągwi koordynującej adopcję',
            'type' => 'text'
        ])->tab('Dane opiekuna');

        CRUD::field([
            'name' => 'flag_comandory',
            'label' => 'Nazwa komandorii',
            'type' => 'text'
        ])->tab('Dane opiekuna');
    
        CRUD::field([
            'name' => 'one_time_pay',
            'label' => 'Data wpłaty jednorazowej',
            'type' => 'date'
        ])->tab('Wpłaty');
        
        CRUD::field([
            'name' => 'first_pay',
            'label' => 'Data wpłaty I raty',
            'type' => 'date'
        ])->tab('Wpłaty');
        
        CRUD::field([
            'name' => 'second_pay',
            'label' => 'Data wpłaty II raty',
            'type' => 'date'
        ])->tab('Wpłaty');

        CRUD::field([
            'name' => 'third_pay',
            'label' => 'Data wpłaty III raty',
            'type' => 'date'
        ])->tab('Wpłaty');
        
        CRUD::field([
            'name' => 'forth_pay',
            'label' => 'Data wpłaty IV raty',
            'type' => 'date'
        ])->tab('Wpłaty');
        
        CRUD::field([
            'name' => 'adoption_date',
            'label' => 'Data adopcji',
            'type' => 'date'
        ]);
        


        $child_age = 0; // Default to 0 for new entries
        $this->addAdoptionField($child_age);

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

    protected function setupDeleteOperation()
    {
        CRUD::field('image_url')->type('upload')->withFiles();

        // Alternatively, if you are not doing much more than defining fields in your create operation:
        // $this->setupCreateOperation();
    }



   private function addAdoptionField($child_age)
    {
        // Add a hidden field to store the child's age
        CRUD::field([
            'name' => 'child_age',
            'label' => 'Child Age',
            'type' => 'hidden',
            'value' => $child_age,
        ]);

        // Add the select field
        CRUD::field([ 
            'name' => 'length_of_adoption',
            'label' => 'Czas adopcji',
            'type' => 'select_from_array',
            'options' => [
                365 => '1 rok',
                365*2 => '2 lata',
                365*3 => '3 lata',
                'to_be_calculated' => 'do uzyskania pełnoletności',
            ],
            'allows_null' => false,
            'default' => 365,  // default to 1 year if none selected
        ]);
    }
}
