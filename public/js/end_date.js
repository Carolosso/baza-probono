crud.field('length_of_adoption').onChange(field => {
    crud.field('remaining_days_of_adoption').show(field.value == 5);
})