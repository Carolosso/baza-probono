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
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
   // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

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
        $this->checkPermissions();
        
        // Add a custom button or override the existing button
        $this->crud->removeButton('create');
    
        // Add your custom button
        $this->crud->addButtonFromView('top', 'custom_create_commandory', 'custom_create_commandory', 'beginning');
        //CRUD::setFromDb(); // set columns from db columns.
        CRUD::column([
            'name' => 'commandory_name',
            'label' => 'Nazwa komandorii'
        ]);

        // Eager load the children count for the list view
        $this->crud->query->withCount('child'); // This will add the count of 'child' to each Commandory record
        // Add a column for displaying the number of children
        
        CRUD::Column([
            'name' => 'child_count',  // Custom name for the column
            'label' => 'Dzieci', // Column title
            'type' => 'number', // Column type
            'function' => function ($entry) {
                // Return the count of children for this Commandory entry
                return $entry->child_count; // Access the 'child_count' loaded by withCount()
            },
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
        $this->checkPermissions();
        
        $this->crud->setTitle('Dodaj','create');
        $this->crud->setHeading('Tworzenie komandorii','create');
        $this->crud->setSubHeading('Wprowadź informacje','create');

        $this->crud->setValidation(CommandoryRequest::class);
        
        CRUD::field([
            'name' => 'commandory_name',
            'label' => 'Nazwa komandorii',
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
        $this->checkPermissions();

        $this->setupCreateOperation();
    }

    protected function checkPermissions(){
        // Define the CRUD operations and their corresponding permissions
        $permissions = [
            'list'   => 'Listowanie komandorii', // 'view child' permission
            'create' => 'Dodawanie komandorii',   // 'create child' permission
            'update' => 'Edytowanie komandorii', // 'update child' permission
            'delete' => 'Usuwanie komandorii',     // 'delete child' permission
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
    }
}
