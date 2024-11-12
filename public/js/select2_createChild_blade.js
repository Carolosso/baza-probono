$(document).ready(function () {
    $('#CountryNameSelect').select2({
        placeholder: "wybierz",
        allowClear: true,
        width: '100%',  // Optional: Make the dropdown take full width
        //theme: 'bootstrap'  // Optional: Make the dropdown take full width
    });
    $('#CommandoryNameSelect').select2({
        placeholder: "wybierz",
        allowClear: true,
        width: '100%',  // Optional: Make the dropdown take full width
        // theme: 'bootstrap'  // Optional: Make the dropdown take full width
    });
    $('#AdopterNameSelect').select2({
        placeholder: "wybierz/szukaj",
        allowClear: true,
        width: '100%',  // Optional: Make the dropdown take full width
        // theme: 'bootstrap'  // Optional: Make the dropdown take full width
        matcher: function (params, data) {
            // If there are no search terms, return all options
            if ($.trim(params.term) === '') {
                return data;
            }

            // Do not display the item if there is no 'text' property
            if (typeof data.text === 'undefined') {
                return null;
            }

            // Split the search term into individual words
            var searchTerms = params.term.toLowerCase().split(" ");

            // Check if each word in the search term is found in the option text
            var allTermsMatch = searchTerms.every(function (term) {
                return data.text.toLowerCase().includes(term);
            });

            // If all terms match, return the option; otherwise, exclude it
            if (allTermsMatch) {
                return data;
            }

            return null;
        }
    });
});