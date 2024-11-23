crud.field('adopter_type_id').onChange(function (field) {
    var allowedValues = [
        'Chorągiew',
        'Komandoria',
        'Schola',
        'Rada Rodziców',
        'Wspólnota parafialna',
        'Szkoła',
        'Urząd',
        'Firma'
    ];

    // Use jQuery to get the selected option's text
    var selectedText = crud.field('adopter_type_id').$input.find('option:selected').text();

    // Show or hide 'adopter_type_name' based on whether the text matches the allowed values
    crud.field('adopter_type_name').show(allowedValues.includes(selectedText));
}).change();
