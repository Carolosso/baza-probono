<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ChildRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


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


        CRUD::column([
            'name' => 'image_url',
            'label' => 'Zdjęcie',
            'type' => 'image',
            'prefix' => '/storage/',
            'height' => 'auto',
            'width' => '10rem',  
            'wrapper' => [
                'class' => 'd-flex justify-content-center'
            ],       
        ]);
        CRUD::column([
            'name' => 'first_name',
            'label' => 'Imię dziecka',
            'type' => 'text',
            'wrapper' => [
                //'class' => 'fs-3'
            ],
        ]);
        CRUD::column([
            'name' => 'last_name',
            'label' => 'Nazwisko dziecka',
            'type' => 'text',
            'wrapper' => [
                //'class' => 'fs-3'
            ],
        ]);
       
        CRUD::column([
            'name' => 'flag',
            'label' => 'Chorągiew',
            'type' => 'text',
            'wrapper' => [
                //'class' => 'fs-3'
            ],
        ]);
        CRUD::column([
            'name' => 'flag_comandory',
            'label' => 'Komandoria',
            'type' => 'text',
            'wrapper' => [
                //'class' => 'fs-3'
            ],
        ]);
         CRUD::column([
            'name' => 'adoption_start_date',
            'label' => 'Data adopcji',
            'type' => 'date',
            'wrapper' => [
                //'class' => 'fs-3'
            ],
        ]);
        CRUD::column([
            'name' => 'length_of_adoption',
            'label' => 'Okres adopcji',
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
    
        CRUD::Column([
            'name' => 'remaining_time',
            'label' => 'Pozostało',
            'type' => 'custom_html',
            'orderable'  => false, // use custom_html
            'value' => function($entry) {
                $remainingDays = $entry->getRemainingTime(); // Call your method to get remaining days
                
                if ($remainingDays < 1) {
                    return '<div class="d-flex justify-content-center"><span class="badge bg-red text-red-fg badge-notification badge-blink">Wygasło</span>'; 
                }
                else if($remainingDays >= 1 && $remainingDays < 30){
                    return '<div class="d-flex justify-content-center"><span class="badge bg-orange text-orange-fg">'.$remainingDays.' dni</span></div>';
                }
                else if($remainingDays >= 30 && $remainingDays <= 90){
                    return '<div class="d-flex justify-content-center"><span class="badge bg-yellow text-yellow-fg">'.$remainingDays.' dni</span></div>';
                }
                else {
                    return '<div class="d-flex justify-content-center"><span class="badge bg-green text-green-fg position-relative">'.$remainingDays.' dni</span></div>';
                }
            }
        ]);

        // // Add the remaining time column dynamically calculated
        // CRUD::addColumn([
        //     'name' => 'remaining_time',
        //     'label' => 'Remaining Time (days)',
        //     'type' => 'model_function',
        //     'function_name' => 'getRemainingTime', // Will call a model function
        //     'escaped' => false, // If you don't want the HTML to be escaped
        // ]);

        //CRUD::setFromDb(); // set columns from db columns.
       
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
        $this->crud->setTitle('Dodaj','create');
        $this->crud->setHeading('Tworzenie profil dziecka','create');
        $this->crud->setSubHeading('Wprowadź informacje','create');
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
            'name' => 'adoption_start_date',
            'label' => 'Data adopcji',
            'type' => 'date'
        ])->tab('Dane dziecka');

        $child_age = 0; // Default to 0 for new entries
        $this->addAdoptionField($child_age);

       /*  CRUD::field([
            'name' => 'remaining_days_of_adoption',
            'label' => 'Pozostało dni',
            'type' => 'number',
            'attributes' => [
            //'placeholder' => 'Some text when empty',
            //'class' => 'form-control some-class',
            'readonly'  => 'readonly',
            //'disabled'  => 'disabled',
            ]           
        ])->tab('Dane dziecka');
 */

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
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $child = $this->crud->getCurrentEntry();
        $this->crud->setTitle('Edycja '. $child->first_name,'edit');
        $this->crud->setHeading('Edycja profilu '. $child->first_name . ' ' . $child->last_name,'edit');
        $this->crud->setSubHeading('Edytuj informacje','edit');
        $this->setupCreateOperation();
        
    }

    protected function setupShowOperation(){
            //$this->crud->setShowView('vendor.backpack.crud.show');

        CRUD::column([
            'name' => 'image_url',
            'label' => 'Zdjęcie',
            'type' => 'image',
            'prefix' => '/storage/',
            'height' => '40%',
            'width' => '30%',
        ]);
        CRUD::column([
            'name' => 'first_name',
            'label' => 'Imię dziecka',
            'type' => 'text',
            'wrapper' => [
                //'class' => 'fs-3'
            ],
        ]);
        CRUD::column([
            'name' => 'last_name',
            'label' => 'Nazwisko dziecka',
            'type' => 'text',
            'wrapper' => [
                //'class' => 'fs-3'
            ],
        ]);
       CRUD::column([
            'name' => 'age',
            'label' => 'Wiek dziecka',
            'type' => 'number',
            'wrapper' => [
                //'class' => 'fs-3'
            ],
        ])->suffix(" lat");

        CRUD::column([
            'name' => 'birth_place',
            'label' => 'Miejscowość pochodzenia',
            'type' => 'text',
            'wrapper' => [
                //'class' => 'fs-3'
            ],
        ]);

        CRUD::column([
            'name' => 'country',
            'label' => 'Kraj pochodzenia',
            'type' => 'text',
            'wrapper' => [
                //'class' => 'fs-3'
            ],
        ]);

        
        CRUD::column([
            'name' => 'adoption_start_date',
            'label' => 'Data adopcji',
            'type' => 'date',
            'wrapper' => [
                //'class' => 'fs-3'
            ],
        ]);

        CRUD::column([
            'name' => 'length_of_adoption',
            'label' => 'Okres adopcji',
            'type' => 'text',
            'suffix' => ' lat',
            'value' => function($entry){
                $days = $entry->length_of_adoption;
                return intval($days/365);
            },
            'wrapper' => [
                //'class' => 'fs-3'
            ],
        ]);

        CRUD::Column([
            'name' => 'remaining_time',
            'label' => 'Pozostało',
            'type' => 'custom_html',
            'orderable'  => false, // use custom_html
            'value' => function($entry) {
                $remainingDays = $entry->getRemainingTime(); // Call your method to get remaining days
                
                if ($remainingDays < 1) {
                    return '<span class="badge bg-red text-red-fg">Wygasło</span>'; 
                }
                else if($remainingDays >= 1 && $remainingDays < 30){
                    return '<span class="badge bg-orange text-orange-fg">'.$remainingDays.' dni</span>';
                }
                else if($remainingDays >= 30 && $remainingDays <= 90){
                    return '<span class="badge bg-yellow text-yellow-fg">'.$remainingDays.' dni</span>';
                }
                else {
                    return '<span class="badge bg-green text-green-fg ">'.$remainingDays.' dni</span>';
                }
            }
        ]);
        CRUD::column([
            'name' => 'adopter_first_name',
            'label' => 'Imię opiekuna',
            'type' => 'text',
            'wrapper' => [
                //'class' => 'fs-3'
            ],
        ])->tab('Dane opiekuna');

        CRUD::column([
            'name' => 'adopter_last_name',
            'label' => 'Nazwisko opiekuna',
            'type' => 'text',
            'wrapper' => [
                //'class' => 'fs-3'
            ],
        ])->tab('Dane opiekuna');

        CRUD::column([
            'name' => 'flag',
            'label' => 'Chorągiew',
            'type' => 'text',
            'wrapper' => [
                //'class' => 'fs-3'
            ],
        ]);
        CRUD::column([
            'name' => 'flag_comandory',
            'label' => 'Komandoria',
            'type' => 'text',
            'wrapper' => [
                //'class' => 'fs-3'
            ],
        ]);

        CRUD::column([
            'name' => 'one_time_pay',
            'label' => 'Data wpłaty jednorazowej',
            'type' => 'date'
        ]);
        CRUD::column([
            'name' => 'first_pay',
            'label' => 'Data wpłaty I raty',
            'type' => 'date'
        ]);
        CRUD::column([
            'name' => 'second_pay',
            'label' => 'Data wpłaty II raty',
            'type' => 'date'
        ]);
        CRUD::column([
            'name' => 'third_pay',
            'label' => 'Data wpłaty III raty',
            'type' => 'date'
        ]);
         CRUD::column([
            'name' => 'forth_pay',
            'label' => 'Data wpłaty IV raty',
            'type' => 'date'
        ]);
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
        ])->tab('Dane dziecka');
    }

    
}
