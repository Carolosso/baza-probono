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
            'name' => 'adopter_type',
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
            'name' => 'adopter_type',
            'label' => 'Rodzaj opiekuna',
            'type' => 'select_from_array',
            'options' => [
                'Chorągiew' => 'Chorągiew',
                'Komandoria' => 'Komandoria',
                'Rycerz' => 'Rycerz',
                'Firma' => 'Firma',
                'Schola' => 'Schola',
                'Rada Rodziców' => 'Rada Rodziców',
                'Osoba świecka' => 'Osoba świecka',
                'Ksiądz' => 'Ksiądz',
                'Siostra zakonna' => 'Siostra zakonna',
                'Ojciec zakonny' => 'Ojciec zakonny',
                'Wspólnota parafialna' => 'Wspólnota parafialna',
                'Szkoła' => 'Szkoła',
                'Urząd' => 'Urząd',
            ],
            'wrapper' => [
                'class' => 'col-md-4'
            ], 
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

    protected function setupShowOperation()
    {
        //$this->checkPermissions();

        $adopter = $this->crud->getCurrentEntry();
        $this->crud->setTitle('Podgląd '. $adopter->adopter_first_name,'show');
        $this->crud->setHeading($adopter->adopter_first_name . ' ' . $adopter->adopter_last_name,'show');
        $this->crud->setSubHeading('Pogląd informacji','show'); 

        //CRUD::setFromDb();
        CRUD::column([
            'name' => 'adopter_type',
            'label' => 'Rodzaj',
        ]);
        CRUD::column([
            'name' => 'adopter_type_name',
            'label' => 'Pełna nazwa',
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
}
