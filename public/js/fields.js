crud.field('adopter_type').onChange(function (field) {
    var allowedValues = ['Chorągiew', 'Komandoria', 'Schola', 'Rada Rodziców', 'Wspólnota parafialna', 'Szkoła', 'Urząd'];
    // Check if field.value is one of the allowed values
    crud.field('adopter_type_name').show(allowedValues.includes(field.value));
}).change();
