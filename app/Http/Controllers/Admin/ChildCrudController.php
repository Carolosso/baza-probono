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
        //CRUD::setValidation(ChildRequest::class);
        $this->crud->setTitle('Dodaj','create');
        $this->crud->setHeading('Tworzenie profil dziecka','create');
        $this->crud->setSubHeading('Wprowadź informacje','create');
        //CRUD::setFromDb(); // set fields from db columns.
         // First, store the entry
        $entry = $this->crud->create($request->all());
        // Calculate and save adoption_end_date
        $this->calculateAndSaveAdoptionEndDate($entry, $request);
        return redirect()->to($this->crud->route);

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
            'name' => 'sex',
            'label' => 'Płeć',
            'type' => 'radio',
            'options' => [
                'kobieta' => "Kobieta",
                'mężczyzna' => "Mężczyzna",
            ],
            'inline' => true,
        ])->tab('Dane dziecka');

        CRUD::field([
            'name' => 'birth_place',
            'label' => 'Miejscowość pochodzenia',
            'type' => 'text'
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

            ]
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
            ]
        ])->tab('Dane dziecka');

        CRUD::field([
            'name' => 'adoption_start_date',
            'label' => 'Data adopcji',
            'type' => 'date'
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
            'name' => 'others',
            'label' => 'Uwagi',
            'type' => 'textarea'
        ])->tab('Dane dziecka');
        
        CRUD::field([
            'name' => 'coordinator_first_name',
            'label' => 'Imię koordynatora',
            'type' => 'text'
        ])->tab('Dane opiekuna');

        CRUD::field([
            'name' => 'coordinator_last_name',
            'label' => 'Nazwisko koordynatora',
            'type' => 'text'
        ])->tab('Dane opiekuna');

        CRUD::field([
            'name' => 'adopter_type',
            'label' => 'Rodzaj opiekuna',
            'type' => 'select_from_array',
            'options' => [
                'Chorągiew' => 'Chorągiew',
                'Komandoria' => 'Komandoria',
                'Schola' => 'Schola',
                'Rada Rodziców' => 'Rada Rodziców',
                'Osoba świecka' => 'Osoba świecka',
            ]
        ])->tab('Dane opiekuna');

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
            'name' => 'adopter_email',
            'label' => 'Adres Email opiekuna',
            'type' => 'email'
        ])->tab('Dane opiekuna');

        CRUD::field([
            'name' => 'adopter_phone',
            'label' => 'Numer telefonu opiekuna',
            'type' => 'text'
        ])->tab('Dane opiekuna');

        CRUD::field([
            'name' => 'flag_comandory',
            'label' => 'Komandoria',
            'type' => 'select_from_array',
            'options' => [
                'białostocka' => 'białostocka',
                'bielsko-żywiecka' => 'bielsko-żywiecka',
                'bydgoska' => 'bydgoska',
                'częstochowska' => 'częstochowska',
                'drohiczyńska' => 'drohiczyńska',
                'elbląska' => 'elbląska',
                'ełcka' => 'ełcka',
                'gdańska' => 'gdańska',
                'gliwicka' => 'gliwicka',
                'gnieźnieńska' => 'gnieźnieńska',
                'kaliska' => 'kaliska',
                'katowicka' => 'katowicka',
                'kielecka' => 'kielecka',
                'koszalińsko-kołobrzeska' => 'koszalińsko-kołobrzeska',
                'krakowska' => 'krakowska',
                'legnicka' => 'legnicka',
                'lubelska' => 'lubelska',
                'łomżyńska' => 'łomżyńska',
                'łowicka' => 'łowicka',
                'łódzka' => 'łódzka',
                'warmińska' => 'warmińska',
                'opolska' => 'opolska',
                'pelplińska' => 'pelplińska',
                'płocka' => 'płocka',
                'poznańska' => 'poznańska',
                'przemyska' => 'przemyska',
                'radomska' => 'radomska',
                'rzeszowska' => 'rzeszowska',
                'sandomierska' => 'sandomierska',
                'siedlecka' => 'siedlecka',
                'sosnowiecka' => 'sosnowiecka',
                'szczecińsko-kamieńska' => 'szczecińsko-kamieńska',
                'świdnicka' => 'świdnicka',
                'tarnowska' => 'tarnowska',
                'toruńska' => 'toruńska',
                'warszawska' => 'warszawska',
                'warszawsko-praska' => 'warszawsko-praska',
                'włocławska' => 'włocławska',
                'wrocławska' => 'wrocławska',
                'zamojsko-lubaczowska' => 'zamojsko-lubaczowska',
                'zielonogórsko-gorzowska' => 'zielonogórsko-gorzowska',

            ]
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



    private function calculateAndSaveAdoptionEndDate($entry, $request)
    {
        // Get the adoption_start_date and length_of_adoption from the request
        $adoptionStartDate = $request->input('adoption_start_date');
        $lengthOfAdoption = $request->input('length_of_adoption');

        // Ensure both fields are available
        if ($adoptionStartDate && $lengthOfAdoption) {
            // Parse the adoption start date and add the length of adoption days
            $adoptionEndDate = Carbon::parse($adoptionStartDate)->addDays($lengthOfAdoption);

            // Save the adoption end date in the entry
            $entry->adoption_end_date = $adoptionEndDate;
            $entry->save(); // Save the entry with the updated adoption_end_date
        }
    }

   private function addAdoptionField($child_age)
    {
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
