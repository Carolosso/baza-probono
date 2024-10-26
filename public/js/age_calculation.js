$(document).ready(function () {
    // Function to calculate remaining days until the child turns 18
    function calculateRemainingDays() {
        var childAge = parseInt($('input[name="age"]').val());
        var remainingYears = 18 - childAge;
        var remainingDays = remainingYears > 0 ? remainingYears * 365 : 0;
        return { remainingYears, remainingDays };
    }

    // Function to update length_of_adoption display and store days in hidden field
    function updateLengthOfAdoption() {
        var typeOfAdoption = $('select[name="type_of_adoption"]').val();
        var endDateOfAdoption = $('input[name="adoption_end_date"]');
        var lengthField = $('input[name="length_of_adoption_years"]');
        var lengthInDaysField = $('input[name="length_of_adoption"]');

        // Check if type is set to "till 18 years old"
        if (typeOfAdoption === 'do uzyskania pełnoletności') {
            var { remainingYears, remainingDays } = calculateRemainingDays();
            lengthField.val(remainingYears).prop('readonly', true);  // Display in years
            lengthInDaysField.val(remainingDays);                    // Store in days
        } else {
            // Custom adoption type: keep the length editable and load stored data
            var lengthOfAdoptionInDays = lengthInDaysField.val();
            if (lengthOfAdoptionInDays) {
                lengthField.val(Math.floor(lengthOfAdoptionInDays / 365)); // Convert days to years for display
            }
            lengthField.prop('readonly', false);
        }
    }

    // Function to calculate the adoption end date
    function calculateEndDate() {
        var startDate = $('[name="adoption_start_date"]').val();
        var lengthOfAdoptionDays = parseInt($('[name="length_of_adoption"]').val(), 10);

        if (startDate && !isNaN(lengthOfAdoptionDays)) {
            var startDateObj = new Date(startDate);
            startDateObj.setDate(startDateObj.getDate() + lengthOfAdoptionDays);
            var endDate = startDateObj.toISOString().split('T')[0];
            $('[name="adoption_end_date"]').val(endDate);
        }
    }

    // Event listeners for changes in type_of_adoption, age, adoption_start_date, and length_of_adoption fields
    $('select[name="type_of_adoption"]').on('change', function () {
        updateLengthOfAdoption();
        calculateEndDate();
    });

    $('input[name="age"]').on('change', function () {
        if ($('select[name="type_of_adoption"]').val() === 'do uzyskania pełnoletności') {
            updateLengthOfAdoption();
            calculateEndDate();
        }
    });

    $('[name="adoption_start_date"], [name="length_of_adoption_years"]').on('change keyup', function () {
        calculateEndDate();
    });

    // Convert custom years input to days on manual input in length_of_adoption_years
    $('input[name="length_of_adoption_years"]').on('input', function () {
        if ($('select[name="type_of_adoption"]').val() === 'niestandardowy') {
            var customYears = parseInt($(this).val());
            $('input[name="length_of_adoption"]').val(customYears * 365 || '');
        }
    });

    // Initial setup on page load
    updateLengthOfAdoption();
    calculateEndDate();
});
