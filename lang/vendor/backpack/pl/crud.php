<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Backpack Crud Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the CRUD interface.
    | You are free to change them to anything
    | you want to customize your views to better match your application.
    |
    */

    // Forms
    'save_action_save_and_new' => 'Zapisz i dodaj nowy element',
    'save_action_save_and_edit' => 'Zapisz i edytuj ten element',
    'save_action_save_and_back' => 'Zapisz i wróć',
    'save_action_save_and_preview' => 'Zapisz i podgląd',
    'save_action_changed_notification' => 'Domyślne zachowanie po zapisaniu zostało zmienione.',

    // Create form
    'add' => 'Dodaj',
    'back_to_all' => 'Wróć do wszystkich ',
    'cancel' => 'Anuluj',
    'add_a_new' => 'Dodaj nowy ',

    // Edit form
    'edit' => 'Edytuj',
    'save' => 'Zapisz',

    // Translatable models
    'edit_translations' => 'Tłumaczenie',
    'language' => 'Język',

    // CRUD table view
    'all' => 'Wszystkie ',
    'in_the_database' => 'w bazie danych',
    'list' => 'Lista',
    'reset' => 'Resetuj widok',
    'actions' => 'Akcje',
    'preview' => 'Podgląd',
    'delete' => 'Usuń',
    'admin' => 'Admin',
    'details_row' => 'To jest wiersz szczegółów. Zmień według uznania.',
    'details_row_loading_error' => 'Wystąpił błąd podczas ładowania szczegółów. Proszę spróbować ponownie.',
    'clone' => 'Klonuj',
    'clone_success' => '<strong>Element sklonowany</strong><br>Nowy element został dodany z tymi samymi informacjami.',
    'clone_failure' => '<strong>Klonowanie nie powiodło się</strong><br>Nie udało się utworzyć nowego elementu. Spróbuj ponownie.',

    // Confirmation messages and bubbles
    'delete_confirm' => 'Czy na pewno chcesz usunąć ten element?',
    'delete_confirmation_title' => 'Element usunięty',
    'delete_confirmation_message' => 'Element został pomyślnie usunięty.',
    'delete_confirmation_not_title' => 'NIE usunięto',
    'delete_confirmation_not_message' => 'Wystąpił błąd. Twój element może nie zostać usunięty.',
    'delete_confirmation_not_deleted_title' => 'Nie usunięto',
    'delete_confirmation_not_deleted_message' => 'Nic się nie stało. Twój element jest bezpieczny.',

    // Bulk actions
    'bulk_no_entries_selected_title' => 'Nie wybrano elementów',
    'bulk_no_entries_selected_message' => 'Proszę wybrać co najmniej jeden element, aby wykonać akcję grupową.',

    // Bulk delete
    'bulk_delete_are_you_sure' => 'Czy na pewno chcesz usunąć te :number elementy?',
    'bulk_delete_sucess_title' => 'Elementy usunięte',
    'bulk_delete_sucess_message' => ' elementy zostały usunięte',
    'bulk_delete_error_title' => 'Nie udało się usunąć',
    'bulk_delete_error_message' => 'Niektóre elementy nie mogły zostać usunięte',

    // Bulk clone
    'bulk_clone_are_you_sure' => 'Czy na pewno chcesz sklonować te :number elementy?',
    'bulk_clone_sucess_title' => 'Elementy sklonowane',
    'bulk_clone_sucess_message' => ' elementy zostały sklonowane.',
    'bulk_clone_error_title' => 'Klonowanie nie powiodło się',
    'bulk_clone_error_message' => 'Niektóre elementy nie mogły zostać utworzone. Spróbuj ponownie.',

    // Ajax errors
    'ajax_error_title' => 'Błąd',
    'ajax_error_text' => 'Błąd podczas ładowania strony. Odśwież stronę.',

    // DataTables translation
    'emptyTable' => 'Brak danych w tabeli',
    'info' => 'Wyświetlono od _START_ do _END_ z _TOTAL_ elementów',
    'infoEmpty' => 'Brak wpisów',
    'infoFiltered' => '(odfiltrowano z _MAX_ wszystkich elementów)',
    'infoPostFix' => '.',
    'thousands' => ',',
    'lengthMenu' => '_MENU_ elementów na stronę',
    'loadingRecords' => 'Ładowanie...',
    'processing' => 'Przetwarzanie...',
    'search' => 'Szukaj',
    'zeroRecords' => 'Nie znaleziono pasujących wpisów',
    'paginate' => [
        'first' => 'Pierwsza',
        'last' => 'Ostatnia',
        'next' => 'Następna',
        'previous' => 'Poprzednia',
    ],
    'aria' => [
        'sortAscending' => ': aktywuj, aby posortować kolumnę rosnąco',
        'sortDescending' => ': aktywuj, aby posortować kolumnę malejąco',
    ],
    'export' => [
        'export' => 'Eksportuj',
        'copy' => 'Kopiuj',
        'excel' => 'Excel',
        'csv' => 'CSV',
        'pdf' => 'PDF',
        'print' => 'Drukuj',
        'column_visibility' => 'Widoczność kolumn',
    ],
    'custom_views' => [
        'title' => 'widoki niestandardowe',
        'title_short' => 'widoki',
        'default' => 'domyślny',
    ],

    // global crud - errors
    'unauthorized_access' => 'Brak dostępu - nie masz uprawnień, aby zobaczyć tę stronę.',
    'please_fix' => 'Proszę naprawić następujące błędy:',

    // global crud - success / error notification bubbles
    'insert_success' => 'Element został pomyślnie dodany.',
    'update_success' => 'Element został pomyślnie zaktualizowany.',

    // CRUD reorder view
    'reorder' => 'Zmień kolejność',
    'reorder_text' => 'Użyj przeciągania i upuszczania, aby zmienić kolejność.',
    'reorder_success_title' => 'Zrobione',
    'reorder_success_message' => 'Twoja kolejność została zapisana.',
    'reorder_error_title' => 'Błąd',
    'reorder_error_message' => 'Twoja kolejność nie została zapisana.',

    // CRUD yes/no
    'yes' => 'Tak',
    'no' => 'Nie',

    // CRUD filters navbar view
    'filters' => 'Filtry',
    'toggle_filters' => 'Przełącz filtry',
    'remove_filters' => 'Usuń filtry',
    'apply' => 'Zastosuj',

    //filters language strings
    'today' => 'Dzisiaj',
    'yesterday' => 'Wczoraj',
    'last_7_days' => 'Ostatnie 7 dni',
    'last_30_days' => 'Ostatnie 30 dni',
    'this_month' => 'Ten miesiąc',
    'last_month' => 'Zeszły miesiąc',
    'custom_range' => 'Zakres niestandardowy',
    'weekLabel' => 'T',

    // Fields
    'browse_uploads' => 'Przeglądaj przesłane pliki',
    'select_all' => 'Zaznacz wszystkie',
    'unselect_all' => 'Odznacz wszystkie',
    'select_files' => 'Wybierz pliki',
    'select_file' => 'Wybierz plik',
    'clear' => 'Wyczyść',
    'page_link' => 'Link do strony',
    'page_link_placeholder' => 'http://example.com/twoja-strona',
    'internal_link' => 'Link wewnętrzny',
    'internal_link_placeholder' => 'Wewnętrzny slug. Np.: \'admin/page\' (bez cudzysłowów) dla \':url\'',
    'external_link' => 'Link zewnętrzny',
    'choose_file' => 'Wybierz plik',
    'new_item' => 'Nowy element',
    'select_entry' => 'Wybierz wpis',
    'select_entries' => 'Wybierz wpisy',
    'upload_multiple_files_selected' => 'Wybrano pliki. Po zapisaniu zostaną wyświetlone powyżej.',

    //Table field
    'table_cant_add' => 'Nie można dodać nowego :entity',
    'table_max_reached' => 'Osiągnięto maksymalną liczbę :max',

    // google_map
    'google_map_locate' => 'Znajdź moją lokalizację',

    // File manager
    'file_manager' => 'Menedżer plików',

    // InlineCreateOperation
    'related_entry_created_success' => 'Powiązany element został utworzony i wybrany.',
    'related_entry_created_error' => 'Nie udało się utworzyć powiązanego elementu.',
    'inline_saving' => 'Zapisywanie...',

    // returned when no translations found in select inputs
    'empty_translations' => '(puste)',

    // The pivot selector required validation message
    'pivot_selector_required_validation_message' => 'Pole pivot jest wymagane.',

    // Quick button messages
    'quick_button_ajax_error_title' => 'Żądanie nie powiodło się!',
    'quick_button_ajax_error_message' => 'Wystąpił błąd podczas przetwarzania żądania.',
    'quick_button_ajax_success_title' => 'Żądanie zakończone!',
    'quick_button_ajax_success_message' => 'Twoje żądanie zakończyło się sukcesem.',

    // translations
    'no_attributes_translated' => 'Ten wpis nie jest przetłumaczony na :locale.',
    'no_attributes_translated_href_text' => 'Wypełnij pola z :locale',
];