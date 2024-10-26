<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CommandoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CommandoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CommandoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
   // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Commandory::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/commandory');
        CRUD::setEntityNameStrings('commandory', 'komandorie');
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
        $this->crud->addButtonFromView('top', 'custom_create_commandory', 'custom_create_commandory', 'beginning');
        //CRUD::setFromDb(); // set columns from db columns.
        CRUD::column([
            'name' => 'commandory_name',
            'label' => 'Nazwa komandorii'
        ]);
        CRUD::column([
            'name' => 'created_at',
            'label' => 'Utworzono'
        ]);
        CRUD::column([
            'name' => 'updated_at',
            'label' => 'Ostatnia modyfikacja'
        ]);
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
        $this->crud->setTitle('Dodaj','create');
        $this->crud->setHeading('Tworzenie komandorii','create');
        $this->crud->setSubHeading('Wprowadź informacje','create');

        CRUD::setValidation(); //CommandoryRequest::class
        //CRUD::setFromDb(); // set fields from db columns.
        CRUD::field([
            'name' => 'commandory_name',
            'label' => 'Nazwa nowej komandorii',
            'type' => 'text',
            'wrapper' => [
                'class' => 'col-md-4'
            ], 
        ]);
        /**
         * Fields can be defined using the fluent syntax:
         * - 
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
        $this->setupCreateOperation();
    }
}
