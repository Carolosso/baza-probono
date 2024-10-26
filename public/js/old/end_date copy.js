$(document).ready(function () {
    // Function to calculate the adoption end date
    function calculateEndDate() {
        // Get the start date value using the 'name' attribute
        var startDate = $('[name="adoption_start_date"]').val();
        // Get the length of adoption in days using the 'name' attribute
        var lengthOfAdoption = parseInt($('[name="length_of_adoption"]').val(), 10);

        // Make sure both values are available before calculating
        if (startDate && !isNaN(lengthOfAdoption)) {
            // Parse the start date into a Date object
            var startDateObj = new Date(startDate);

            // Add the length of adoption (days) to the start date
            startDateObj.setDate(startDateObj.getDate() + lengthOfAdoption);

            // Format the date in YYYY-MM-DD format
            var endDate = startDateObj.toISOString().split('T')[0];

            // Set the calculated date in the adoption_end_date field
            $('[name="adoption_end_date"]').val(endDate);
        }
    }

    // Event listener for changes in adoption_start_date and length_of_adoption fields
    $('[name="adoption_start_date"], [name="length_of_adoption_years"],[name="type_of_adoption"] ').on('change keyup', function () {
        calculateEndDate(); // Call the function to calculate and set the end date
    });

    // Trigger calculation on page load if fields are already filled
    calculateEndDate();
});

