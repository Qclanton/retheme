(function($) { $(function() { 
    'use strict';
    
    // Cute multi select
    $('.search_form select[name="search_property[types][]"]')
        .css('width', '300px')
        .tokenize({displayDropdownOnFocus:true})
    ;
}) })(jQuery)
