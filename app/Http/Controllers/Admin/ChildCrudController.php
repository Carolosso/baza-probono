<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ChildRequest;
use App\Models\Child;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Support\Facades\Response;
use Spatie\Permission\Exceptions\UnauthorizedException;
//use Illuminate\Support\Facades\Log; // Add logging

/**
 * Class ChildCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ChildCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation; //{ show as traitShow; }


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
        $this->checkPermissions();

         Widget::add()->type('script')->content('js/select2.min.js');
         Widget::add()->type('script')->content('js/select2_list_blade.js');
         Widget::add()->type('style')->content('css/select2.css');
        // Add a custom button or override the existing button
        $this->crud->removeButton('create');
    
        // Add your custom button
        $this->crud->addButtonFromView('top', 'custom_create_child', 'custom_create_child', 'beginning');


        if (request()->has('group') && request()->input('group') != '') {
            $this->crud->addClause('where', 'group', request()->input('group'));
        } 
        if (request()->has('commandory_id') && request()->input('commandory_id') != '') {
            $this->crud->addClause('where', 'commandory_id', request()->input('commandory_id'));
        } 
        if (request()->has('sex') && request()->input('sex') != '') {
            $this->crud->addClause('where', 'sex', request()->input('sex'));
        }

        CRUD::column([
            'name' => 'image_url',
            'label' => 'Zdjęcie',
            'type' => 'image',
            'attributes'=> [
                'style' => 'width: 100%; height: 100%; object-fit: cover; max-height: 100%;', // Override default Backpack styles
            ],
            'wrapper' => [
                //'class' => 'd-flex justify-content-center',
                'style' => 'width: 75px; height: 75px; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 50%; border:.5px',
            ],
            'value' =>   function ($entry) {
                return $entry->image_url 
                    ? asset('storage/' . $entry->image_url) 
                    : asset('img/Blank-profile.png');
            } 
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
            'name' => 'evidence_number',
            'label' => 'Numer ewidencji',
            'wrapper' => [
                //'class' => 'fs-3'
            ],
        ]);

       CRUD::column([
            'name' => 'group',
            'label' => 'Zgromadzenie',
            'type' => 'text',
            'wrapper' => [
                //'class' => 'fs-3'
            ],
        ]);

        CRUD::column([
            'name' => 'commandory_name',
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

        CRUD::addColumn([
            'name' => 'remaining_days_of_adoption',
            'label' => 'Pozostało',
            'type' => 'view',
            'view' => 'vendor.backpack.crud.columns.remaining_days',
        ]);

         CRUD::column([
            'name' => 'created_at',
            'label' => 'Data utworzenia',
            'wrapper' => [
                //'class' => 'fs-3'
            ],
        ]);



     /*    CRUD::Column([
            'name' => 'remaining_time',
            'label' => 'Pozostało',
            'type' => 'custom_html',
            'orderable'  => true, // use custom_html
            'value' => function($entry) {
                $remainingDays = $entry->getRemainingTime(); // Call your method to get remaining days
                //return $remainingDays;
                if ($remainingDays < 1) {
                    return '<div class="d-flex justify-content-center"><span class="badge bg-red text-red-fg">Wygasło</span>'; 
                }
                else if($remainingDays >= 1 && $remainingDays < 30){
                    return '<div class="d-flex justify-content-center"><span class="badge bg-orange text-orange-fg">'.$remainingDays.' dni</span></div>';
                }
                else if($remainingDays >= 30 && $remainingDays <= 90){
                    return '<div class="d-flex justify-content-center"><span class="badge bg-yellow text-yellow-fg">'.$remainingDays.' dni</span></div>';
                }
                else {
                    return '<div class="d-flex justify-content-center"><span class="badge bg-green text-green-fg">'.$remainingDays.' dni</span></div>';
                }
            }
        ]); */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        //$this->authorize('Admin', Model::class);
        $this->checkPermissions();
        CRUD::setValidation(ChildRequest::class);

       // Widget::add()->type('script')->content('js/fields.js');
        Widget::add()->type('script')->content('js/age_calculation.js');
        //Widget::add()->type('script')->content('js/end_date.js');
        Widget::add()->type('script')->content('js/select2.min.js');
        Widget::add()->type('script')->content('js/select2_createChild_blade.js');
        Widget::add()->type('style')->content('css/select2.css');

        $this->crud->setTitle('Dodaj','create');
        $this->crud->setHeading('Tworzenie profil dziecka','create');
        $this->crud->setSubHeading('Wprowadź informacje','create');
        //CRUD::setFromDb(); // set fields from db columns.
        CRUD::field([
            'name' => 'first_name',
            'label' => 'Imię dziecka',
            'type' => 'text',
            'wrapper' => [
                'class' => 'col-md-4'
            ],  
        ])->tab('Dane dziecka');

        CRUD::field([
            'name' => 'last_name',
            'label' => 'Nazwisko dziecka',
            'type' => 'text',
            'wrapper' => [
                'class' => 'col-md-4'
            ],  
        ])->tab('Dane dziecka');

        CRUD::field([
            'name' => 'age',
            'label' => 'Wiek',
            'type' => 'number',
            'wrapper' => [
                'class' => 'col-md-2'
            ],  
        ])->suffix("lat")->tab('Dane dziecka');

        CRUD::field([
            'name' => 'evidence_number',
            'label' => 'Numer ewidencji',
            'type' => 'text',
            'wrapper' => [
                'class' => 'col-md-2'
            ],  
        ])->tab('Dane dziecka');


        CRUD::field([
            'name' => 'sex',
            'label' => 'Płeć',
            'type' => 'radio',
            'options' => [
                'kobieta' => "Kobieta",
                'mężczyzna' => "Mężczyzna",
            ],
            'inline' => true,
            'wrapper' => [
                'class' => 'col-md-12'
            ],  
        ])->tab('Dane dziecka');

        CRUD::field([
            'name' => 'birth_place',
            'label' => 'Miejscowość pochodzenia',
            'type' => 'text',
            'wrapper' => [
                'class' => 'col-md-4'
            ],  
        ])->tab('Dane dziecka');

        CRUD::field([
            'name' => 'country',
            'label' => 'Kraj pochodzenia',
            'type' => 'select_from_array',
            'options' => [
                'Afganistan' => 'Afganistan',
                'Albania' => 'Albania',
                'Algieria' => 'Algieria',
                'Andora' => 'Andora',
                'Angola' => 'Angola',
                'Antigua i Barbuda' => 'Antigua i Barbuda',
                'Arabia Saudyjska' => 'Arabia Saudyjska',
                'Argentyna' => 'Argentyna',
                'Armenia' => 'Armenia',
                'Australia' => 'Australia',
                'Austria' => 'Austria',
                'Azerbejdżan' => 'Azerbejdżan',
                'Bahamy' => 'Bahamy',
                'Bahrajn' => 'Bahrajn',
                'Bangladesz' => 'Bangladesz',
                'Barbados' => 'Barbados',
                'Belgia' => 'Belgia',
                'Belize' => 'Belize',
                'Benin' => 'Benin',
                'Bhutan' => 'Bhutan',
                'Białoruś' => 'Białoruś',
                'Boliwia' => 'Boliwia',
                'Bośnia i Hercegowina' => 'Bośnia i Hercegowina',
                'Botswana' => 'Botswana',
                'Brazylia' => 'Brazylia',
                'Brunei' => 'Brunei',
                'Bułgaria' => 'Bułgaria',
                'Burkina Faso' => 'Burkina Faso',
                'Burundi' => 'Burundi',
                'Czad' => 'Czad',
                'Chile' => 'Chile',
                'Chiny' => 'Chiny',
                'Chorwacja' => 'Chorwacja',
                'Cypr' => 'Cypr',
                'Czarnogóra' => 'Czarnogóra',
                'Czechy' => 'Czechy',
                'Dania' => 'Dania',
                'Djibouti' => 'Dżibuti',
                'Dominika' => 'Dominika',
                'Dominikana' => 'Dominikana',
                'Dżibuti' => 'Dżibuti',
                'Egipt' => 'Egipt',
                'Ekwador' => 'Ekwador',
                'Erytrea' => 'Erytrea',
                'Estonia' => 'Estonia',
                'Eswatini' => 'Eswatini',
                'Etiopia' => 'Etiopia',
                'Fidżi' => 'Fidżi',
                'Filipiny' => 'Filipiny',
                'Finlandia' => 'Finlandia',
                'Francja' => 'Francja',
                'Gabon' => 'Gabon',
                'Gambia' => 'Gambia',
                'Ghana' => 'Ghana',
                'Grecja' => 'Grecja',
                'Grenada' => 'Grenada',
                'Gruzja' => 'Gruzja',
                'Gujana' => 'Gujana',
                'Gwatemala' => 'Gwatemala',
                'Gwinea' => 'Gwinea',
                'Gwinea Bissau' => 'Gwinea Bissau',
                'Gwinea Równikowa' => 'Gwinea Równikowa',
                'Haiti' => 'Haiti',
                'Hiszpania' => 'Hiszpania',
                'Holandia' => 'Holandia',
                'Honduras' => 'Honduras',
                'Indie' => 'Indie',
                'Indonezja' => 'Indonezja',
                'Irak' => 'Irak',
                'Iran' => 'Iran',
                'Irlandia' => 'Irlandia',
                'Islandia' => 'Islandia',
                'Izrael' => 'Izrael',
                'Jamajka' => 'Jamajka',
                'Japonia' => 'Japonia',
                'Jemen' => 'Jemen',
                'Jordania' => 'Jordania',
                'Kambodża' => 'Kambodża',
                'Kamerun' => 'Kamerun',
                'Kanada' => 'Kanada',
                'Katar' => 'Katar',
                'Kazachstan' => 'Kazachstan',
                'Kenia' => 'Kenia',
                'Kirgistan' => 'Kirgistan',
                'Kiribati' => 'Kiribati',
                'Kolumbia' => 'Kolumbia',
                'Komory' => 'Komory',
                'Kongo' => 'Kongo',
                'Korea Południowa' => 'Korea Południowa',
                'Korea Północna' => 'Korea Północna',
                'Kostaryka' => 'Kostaryka',
                'Kuba' => 'Kuba',
                'Kuwejt' => 'Kuwejt',
                'Laos' => 'Laos',
                'Lesotho' => 'Lesotho',
                'Liban' => 'Liban',
                'Liberia' => 'Liberia',
                'Libia' => 'Libia',
                'Liechtenstein' => 'Liechtenstein',
                'Litwa' => 'Litwa',
                'Luksemburg' => 'Luksemburg',
                'Łotwa' => 'Łotwa',
                'Macedonia' => 'Macedonia',
                'Madagaskar' => 'Madagaskar',
                'Malawi' => 'Malawi',
                'Malediwy' => 'Malediwy',
                'Malezja' => 'Malezja',
                'Mali' => 'Mali',
                'Malta' => 'Malta',
                'Maroko' => 'Maroko',
                'Mauritius' => 'Mauritius',
                'Meksyk' => 'Meksyk',
                'Mikronezja' => 'Mikronezja',
                'Mjanma' => 'Mjanma',
                'Mołdawia' => 'Mołdawia',
                'Monako' => 'Monako',
                'Mongolia' => 'Mongolia',
                'Mozambik' => 'Mozambik',
                'Namibia' => 'Namibia',
                'Nauru' => 'Nauru',
                'Nepal' => 'Nepal',
                'Niemcy' => 'Niemcy',
                'Niger' => 'Niger',
                'Nigeria' => 'Nigeria',
                'Nikaragua' => 'Nikaragua',
                'Norwegia' => 'Norwegia',
                'Nowa Zelandia' => 'Nowa Zelandia',
                'Oman' => 'Oman',
                'Pakistan' => 'Pakistan',
                'Panama' => 'Panama',
                'Papua Nowa Gwinea' => 'Papua Nowa Gwinea',
                'Paragwaj' => 'Paragwaj',
                'Peru' => 'Peru',
                'Polska' => 'Polska',
                'Portugalia' => 'Portugalia',
                'Republika Południowej Afryki' => 'Republika Południowej Afryki',
                'Republika Środkowoafrykańska' => 'Republika Środkowoafrykańska',
                'Republika Zielonego Przylądka' => 'Republika Zielonego Przylądka',
                'Rosja' => 'Rosja',
                'Rumunia' => 'Rumunia',
                'Rwanda' => 'Rwanda',
                'Salwador' => 'Salwador',
                'Samoa' => 'Samoa',
                'San Marino' => 'San Marino',
                'Senegal' => 'Senegal',
                'Serbia' => 'Serbia',
                'Seszele' => 'Seszele',
                'Sierra Leone' => 'Sierra Leone',
                'Singapur' => 'Singapur',
                'Słowacja' => 'Słowacja',
                'Słowenia' => 'Słowenia',
                'Somalia' => 'Somalia',
                'Sri Lanka' => 'Sri Lanka',
                'Stany Zjednoczone' => 'Stany Zjednoczone',
                'Sudan' => 'Sudan',
                'Sudan Południowy' => 'Sudan Południowy',
                'Surinam' => 'Surinam',
                'Syria' => 'Syria',
                'Szwajcaria' => 'Szwajcaria',
                'Szwecja' => 'Szwecja',
                'Tadżykistan' => 'Tadżykistan',
                'Tajlandia' => 'Tajlandia',
                'Tanzania' => 'Tanzania',
                'Togo' => 'Togo',
                'Tonga' => 'Tonga',
                'Trynidad i Tobago' => 'Trynidad i Tobago',
                'Tunezja' => 'Tunezja',
                'Turcja' => 'Turcja',
                'Turkmenistan' => 'Turkmenistan',
                'Tuvalu' => 'Tuvalu',
                'Uganda' => 'Uganda',
                'Ukraina' => 'Ukraina',
                'Urugwaj' => 'Urugwaj',
                'Uzbekistan' => 'Uzbekistan',
                'Vanuatu' => 'Vanuatu',
                'Watykan' => 'Watykan',
                'Wenezuela' => 'Wenezuela',
                'Węgry' => 'Węgry',
                'Wielka Brytania' => 'Wielka Brytania',
                'Wietnam' => 'Wietnam',
                'Wybrzeże Kości Słoniowej' => 'Wybrzeże Kości Słoniowej',
                'Wyspy Marshalla' => 'Wyspy Marshalla',
                'Wyspy Salomona' => 'Wyspy Salomona',
                'Zambia' => 'Zambia',
                'Zimbabwe' => 'Zimbabwe',
                'Zjednoczone Emiraty Arabskie' => 'Zjednoczone Emiraty Arabskie',

            ],
            'wrapper' => [
                'class' => 'col-md-4'
            ],
            'attributes'=> ['id'=>'CountryNameSelect']  
        ])->tab('Dane dziecka');

        CRUD::field([
            'name' => 'group',
            'label' => 'Zgromadzenie',
            'type' => 'select_from_array',
            'options' => [
                'michalitki' => 'michalitki',
                'pasjonistki' => 'pasjonistki',
                'klawerianki' => 'klawerianki',
                'opatrzności bożej' => 'opatrzności bożej',
                'urszulanki' => 'urszulanki',
                'franciszkanie' => 'franciszkanie',
                'salezjanie' => 'salezjanie',
                'pallotyni' => 'pallotyni',
                'franciszkanki od Cierpiących' => 'franciszkanki od Cierpiących',
                'kanoniczki (duchaczki)' => 'kanoniczki (duchaczki)',
            ],
            'wrapper' => [
                'class' => 'col-md-4'
            ],  
        ])->tab('Dane dziecka');

        CRUD::field([
            'name' => 'adoption_start_date',
            'label' => 'Data adopcji',
            'type' => 'date',
            'wrapper' => [
                'class' => 'col-md-2'
            ],  
        ])->tab('Dane dziecka');

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
        ])->tab('Dane dziecka');

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

        ])->suffix("lat")->tab('Dane dziecka');

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
        ])->tab('Dane dziecka');

        CRUD::field([
            'name' => 'image_url',
            'type' => 'upload',
            'label' => 'Zdjęcie',
            'wrapper' => [
                'class' => 'col-md-4'
            ],  
        ])->withFiles([
        'disk' => 'public', // the disk where file will be stored
        'path' => 'photos'
        ])->tab('Dane dziecka');
        
        CRUD::field([
            'name' => 'others',
            'label' => 'Uwagi',
            'type' => 'textarea',
            'wrapper' => [
                'class' => 'col-md-12'
            ],  
        ])->tab('Dane dziecka');
        
        CRUD::field([
            'name' => 'coordinator_first_name',
            'label' => 'Imię asystenta',
            'type' => 'text',
            'wrapper' => [
                'class' => 'col-md-4'
            ], 
        ])->tab('Dane opiekuna');

        CRUD::field([
            'name' => 'coordinator_last_name',
            'label' => 'Nazwisko asystenta',
            'type' => 'text',
            'wrapper' => [
                'class' => 'col-md-4'
            ], 
        ])->tab('Dane opiekuna');
        
        CRUD::field([
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
         ])->tab('Dane opiekuna');

        CRUD::field([
            'name' => 'adopter_id',                // Field in the database for the selected Adopter
            'label' => 'Opiekun',                  // Label for the field
            'type' => 'select_grouped',            // Field type
            'entity' => 'adopter',                 // Relationship method in the Child model
            'model' => 'App\Models\Adopter',       // Model for the select options
            'attribute' => 'adopter_full_name',         // Attribute to display as the option label
            'attributes'=> ['id'=>'AdopterSelect'],
            'group_by' => 'adopterType',           // Group by the `adopterType` relationship on the Adopter model
            'group_by_attribute' => 'type_name',        // Display attribute in the AdopterType model
            'group_by_relationship_back' => 'adopter',        // Display attribute in the AdopterType model
            'options' => (function ($query) {
                return $query->orderBy('type_name')->get(); // Sort adopters within each group
            }),
        ])->tab('Dane opiekuna');

        /*  CRUD::field([
            'name' => 'adopter_id',
            'label' => 'Opiekun',
            'type' => 'select_grouped',
            'group_by' => 'adopterType',
            'group_by_attribute' => 'type_name',
            'entity' => 'adopterType.adopter',  // The relationship method in the model
            'model' => 'App\Models\Adopter',  // The related model
            'attribute' => 'adopter_full_name',  // The attribute to display (Adopter name)
            'attributes'=> ['id'=>'AdopterNameSelect'],
            'options'   => (function ($query) {
                return $query->orderBy('adopter_type', 'ASC')->get();  // Sort by name, optional
            }),
            'wrapper' => [
                'class' => 'col-md-8',
            ]
         ])->tab('Dane opiekuna'); */
        
        /* CRUD::field([
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
        ])->tab('Dane opiekuna');

        CRUD::field([
            'name' => 'adopter_first_name',
            'label' => 'Imię opiekuna',
            'type' => 'text',
            'wrapper' => [
                'class' => 'col-md-4'
            ], 
        ])->tab('Dane opiekuna');

        CRUD::field([
            'name' => 'adopter_last_name',
            'label' => 'Nazwisko opiekuna',
            'type' => 'text',
            'wrapper' => [
                'class' => 'col-md-4'
            ], 
        ])->tab('Dane opiekuna');
        
        CRUD::field([
            'name' => 'adopter_type_name',
            'label' => 'Nazwa',
            'type' => 'text',
            'wrapper' => [
                'class' => 'col-md-4'
            ], 
        ])->tab('Dane opiekuna');

        CRUD::field([
            'name' => 'adopter_email',
            'label' => 'Adres email opiekuna',
            'type' => 'email',
            'wrapper' => [
                'class' => 'col-md-4'
            ], 
        ])->tab('Dane opiekuna');

        CRUD::field([
            'name' => 'adopter_phone',
            'label' => 'Numer telefonu opiekuna',
            'type' => 'text',
            'wrapper' => [
                'class' => 'col-md-4'
            ], 
        ])->tab('Dane opiekuna');

        CRUD::field([
            'name' => 'adopter_address',
            'label' => 'Adres opiekuna',
            'type' => 'text',
            'wrapper' => [
                'class' => 'col-md-4'
            ], 
        ])->tab('Dane opiekuna'); */

        
        // Define a field to display existing payments (if any) and allow managing them
        CRUD::field([
            'name'  => 'payments_section',
            'label' => 'Manage Payments',
            'type'  => 'custom_payment_field', // You will create this as a custom field in Step 2
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
        $this->checkPermissions();

        $child = $this->crud->getCurrentEntry();
        $this->crud->setTitle('Edycja '. $child->first_name,'edit');
        $this->crud->setHeading('Edycja profilu '. $child->first_name . ' ' . $child->last_name,'edit');
        $this->crud->setSubHeading('Edytuj informacje','edit');
        $this->setupCreateOperation();       
    }

    protected function setupShowOperation(){
        $this->checkPermissions();
    }

    protected function setupDeleteOperation()
    {   
        $this->checkPermissions();
        CRUD::field('image_url')->type('upload')->withFiles();

        // Alternatively, if you are not doing much more than defining fields in your create operation:
        // $this->setupCreateOperation();
    }

    // EXPORT - TO CHANGE IN FUTURE CUZ OF LONG CODE!

    public function exportToCsvAll()
    {
        // Log request data to see what values are being passed
        // \Log::info('Request Data: ' . json_encode(request()->all()));

        // Build the query to match the filtered records
        $query = $this->crud->query;

        // Apply filters based on the request inputs
        if ($group = request()->input('group')) {
            $query->where('group', '=', $group);
        }

        if ($commandory_id = request()->input('commandory_id')) {
            $query->where('commandory_id', '=', $commandory_id);
        }

        if ($sex = request()->input('sex')) {
            $query->where('sex', '=', $sex);
        }

        // Debug: Log the query with applied filters
        // \Log::info('Filtered Query SQL: ' . $query->toSql());
        // \Log::info('Query Bindings: ' . json_encode($query->getBindings()));

        // Get the filtered data
        $records = $query->get();

        // Prepare CSV data
        $csvData = [];
        $csvData[] = ['Imię', 'Nazwisko','Numer ewidencji', 'Wiek', 'Płeć', 'Miejscowość', 'Kraj', 'Zgromadzenie','Komandoria','Uwagi','Asystent','Data adopcji','Data zakończenia','Czas trwania (lat)','Rodzaj opiekuna','Nazwa','Imię i nazwisko','Email','Telefon','Adres']; // CSV header

        foreach ($records as $record) {
            $csvData[] = [
                $record->first_name,
                $record->last_name,
                $record->evidence_number,
                $record->age,
                $record->sex,
                $record->birth_place,
                $record->country,
                $record->group,
                $record->commandory_name,
                $record->others,
                $record->coordinator_first_name.' '.$record->coordinator_last_name,
                $record->adoption_start_date,
                $record->adoption_end_date,
                intval($record->length_of_adoption/365),
                $record->adopter_type,
                $record->adopter_type_name,
                $record->adopter_first_name.' '.$record->adopter_last_name,
                $record->adopter_email,
                $record->adopter_phone,
                $record->adopter_address,
            ];
        }

        // Create CSV
        $filename = 'baza-HeartsOMSIPII-Wszystko-' . now()->format('d-m-Y_H-i-s') . '.csv';
        // Start output buffering
        ob_start();
        $handle = fopen('php://output', 'w');

        // Add UTF-8 BOM to handle special characters
        fputs($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);
        
        // Return CSV download
        return Response::make('', 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
        // Get output content
        $csvOutput = ob_get_clean();
    }

    public function exportToCsvChild()
    {
        // Log request data to see what values are being passed
        // \Log::info('Request Data: ' . json_encode(request()->all()));

        // Build the query to match the filtered records
        $query = $this->crud->query;

        // Apply filters based on the request inputs
        if ($group = request()->input('group')) {
            $query->where('group', '=', $group);
        }

        if ($commandory_id = request()->input('commandory_id')) {
            $query->where('commandory_id', '=', $commandory_id);
        }

        if ($sex = request()->input('sex')) {
            $query->where('sex', '=', $sex);
        }

        // Debug: Log the query with applied filters
        // \Log::info('Filtered Query SQL: ' . $query->toSql());
        // \Log::info('Query Bindings: ' . json_encode($query->getBindings()));

        // Get the filtered data
        $records = $query->get();

        // Prepare CSV data
        $csvData = [];
        $csvData[] = ['Imię', 'Nazwisko','Numer ewidencji', 'Wiek', 'Płeć', 'Miejscowość', 'Kraj', 'Zgromadzenie','Uwagi','Data adopcji','Czas trwania','Data zakończenia']; // CSV header

        foreach ($records as $record) {
            $csvData[] = [
                $record->first_name,
                $record->last_name,
                $record->evidence_number,
                $record->age,
                $record->sex,
                $record->birth_place,
                $record->country,
                $record->group,
                $record->others,            
                $record->adoption_start_date,
                intval($record->length_of_adoption/365),
                $record->adoption_end_date,             
            ];
        }

        // Create CSV
        $filename = 'baza-HeartsOMSIPII-Dzieci-' . now()->format('d-m-Y_H-i-s') . '.csv';
        // Start output buffering
        ob_start();
        $handle = fopen('php://output', 'w');

        // Add UTF-8 BOM to handle special characters
        fputs($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);
        
        // Return CSV download
        return Response::make('', 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
        // Get output content
        $csvOutput = ob_get_clean();
    }

    public function exportToCsvAdopter()
    {
        // Filter children based on the input filters
        $childQuery = Child::query();

        if ($group = request()->input('group')) {
            $childQuery->where('group', '=', $group);
        }

        if ($commandory_id = request()->input('commandory_id')) {
            $childQuery->where('commandory_id', '=', $commandory_id);
        }

        if ($sex = request()->input('sex')) {
            $childQuery->where('sex', '=', $sex);
        }

        // Get filtered children with their adopters, then retrieve unique adopters
        $children = $childQuery->with('adopter')->get();

        // Extract unique adopters from the filtered children
        $uniqueAdopters = $children->pluck('adopter')->unique('id');

        // Prepare CSV data
        $csvData = [];
        $csvData[] = ['Rodzaj opiekuna', 'Nazwa', 'Imię i nazwisko', 'Email', 'Telefon', 'Adres']; // CSV header

        foreach ($uniqueAdopters as $adopter) {
            if ($adopter) {  // Check if adopter exists
                $csvData[] = [
                    $adopter->adopter_type,
                    $adopter->adopter_type_name,
                    $adopter->adopter_first_name . ' ' . $adopter->adopter_last_name,
                    $adopter->adopter_email,
                    $adopter->adopter_phone,
                    $adopter->adopter_address,
                ];
            }
        }

        // Create CSV
        $filename = 'baza-HeartsOMSIPII-Opiekunowie-'. now()->format('d-m-Y_H-i-s') . '.csv';

        // Start output buffering
        ob_start();
        $handle = fopen('php://output', 'w');

        // Add UTF-8 BOM to handle special characters
        fputs($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);

        // Get output content and clear buffer
        $csvOutput = ob_get_clean();

        // Return CSV download
        return Response::make($csvOutput, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    
  /*   public function show($id)
    {
        $entry = $this->crud->getCurrentEntry();
        $entry->load('payments'); // Eager load payments

        return parent::show($id);
    } */



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
        $this->calculateRemainingDays($this->crud->entry);


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

    protected function checkPermissions(){
                // Define the CRUD operations and their corresponding permissions
        $permissions = [
            'list'   => 'Listowanie dzieci', // 'view child' permission
            'create' => 'Dodawanie dzieci',   // 'create child' permission
            'update' => 'Edytowanie dzieci', // 'update child' permission
            'delete' => 'Usuwanie dzieci',     // 'delete child' permission
            'show' => 'Przeglądanie dzieci',     // 'delete child' permission
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
