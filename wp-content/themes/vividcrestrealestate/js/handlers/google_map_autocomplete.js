(function($) { $(function() {
    function autocompleteAddress(field) {        
        // Init autocomplete
        autocomplete = new google.maps.places.Autocomplete(
            field
        );
    }

    
    var addresses = $('input.address');
    
    // Init for all address fields
    addresses.each(function() { 
        autocompleteAddress(this);
    });
    
    // Re-init by the click
    addresses.on('click', function() {
        autocompleteAddress(this); 
    });    
}); })(jQuery);
