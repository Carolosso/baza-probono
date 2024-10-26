$(document).ready(function () {
    // Function to calculate remaining days until child turns 18
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

        if (typeOfAdoption === 'do uzyskania pełnoletności') {
            var { remainingYears, remainingDays } = calculateRemainingDays();
            lengthField.val(remainingYears).prop('readonly', true);  // Display years
            lengthInDaysField.val(remainingDays);                    // Store days
        } else {
            lengthField.val('').prop('readonly', false);             // Clear and make editable
            lengthInDaysField.val('');
            endDateOfAdoption.val('');                       // Clear hidden field
        }
    }

    // Handle changes in type_of_adoption dropdown
    $('select[name="type_of_adoption"]').on('change', function () {
        updateLengthOfAdoption();
    });

    // Handle changes in age input for recalculation
    $('input[name="age"]').on('change', function () {
        if ($('select[name="type_of_adoption"]').val() === 'do uzyskania pełnoletności') {
            updateLengthOfAdoption();
        }
    });

    // Convert custom years input to days when user changes length_of_adoption manually
    $('input[name="length_of_adoption_years"]').on('input', function () {
        if ($('select[name="type_of_adoption"]').val() === 'niestandardowy') {
            var customYears = parseInt($(this).val());
            $('input[name="length_of_adoption"]').val(customYears * 365 || '');
        }
    });

    // Initial setup on page load
    updateLengthOfAdoption();
});
