document.addEventListener("DOMContentLoaded", function () {
    // Function to calculate and update the 'do uzyskania pełnoletności' option
    function updateRemainingDays() {
        // Get the child's age from the hidden field
        var childAgeInput = document.querySelector('input[name="age"]');
        var childAge = parseInt(childAgeInput.value);

        // Calculate the remaining years until the child turns 18
        var remainingYears = 18 - childAge;
        var remainingDays = remainingYears * 365;

        // Ensure the calculation does not result in a negative number
        if (remainingDays < 0) {
            remainingDays = 0;
            remainingYears = 0;
        }

        // Find the 'select' field and update the fourth option
        var selectField = document.querySelector('select[name="length_of_adoption"]');

        // Select the fourth option (index 3 since it's zero-based)
        var optionToUpdate = selectField.children[3]; // or use selectField.querySelectorAll('option')[3];

        if (optionToUpdate) {
            // Set the value as the remaining days
            optionToUpdate.value = remainingDays;

            // Update the label to show "do uzyskania pełnoletności (X lat)"
            optionToUpdate.text = 'do uzyskania pełnoletności (' + remainingYears + ' lat)';

            // Optionally, set it as selected if no other option is chosen
            if (!selectField.value || selectField.value === optionToUpdate.value) {
                selectField.value = remainingDays;
            }
        }
    }

    // Run the update function when the page loads
    updateRemainingDays();

    // Attach the event listener to the child_age input field
    var childAgeInput = document.querySelector('input[name="age"]');
    if (childAgeInput) {
        childAgeInput.addEventListener('change', function () {
            // Recalculate the remaining days when the age changes
            updateRemainingDays();
        });
    }
});
