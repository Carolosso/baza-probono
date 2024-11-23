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
    $('#AdopterSelect').select2({
        placeholder: "wybierz/szukaj",
        allowClear: true,
        width: '100%',
        height: '100%',
        matcher: function (params, data) {
            // If there are no search terms, return all options and groups
            if ($.trim(params.term) === '') {
                return data;
            }

            // Do not display items without 'text' property
            if (typeof data.text === 'undefined') {
                return null;
            }

            // Split the search term into individual words
            var searchTerms = params.term.toLowerCase().split(" ");

            // Handle matching logic for optgroups and options
            if (data.children && data.children.length > 0) {
                // This is an optgroup, filter its children
                var matchedOptions = data.children.filter(function (option) {
                    // Check if every search term is found in the option text
                    return searchTerms.every(function (term) {
                        return option.text.toLowerCase().includes(term);
                    });
                });

                // If the optgroup has matching children, return it with the filtered children
                if (matchedOptions.length > 0) {
                    var modifiedData = $.extend({}, data, true);
                    modifiedData.children = matchedOptions;
                    return modifiedData;
                }
                return null;
            } else {
                // Check individual option (non-grouped)
                var allTermsMatch = searchTerms.every(function (term) {
                    return data.text.toLowerCase().includes(term);
                });

                // If all terms match, return the option; otherwise, exclude it
                return allTermsMatch ? data : null;
            }
        }
    });

});