(function($) { $(function() { 
    'use strict';
    
    // Show necessary forms    
    $('.agent__contact-form a[data-action="request-information"]').on('click', function(ev) {
        ev.preventDefault();
        
        $('#agent__contact-appointment').hide();
        $('#agent__contact').toggle();
        
    });
    
    $('.agent__contact-form a[data-action="request-showing"]').on('click', function(ev) {
        ev.preventDefault();
        
        $('#agent__contact').hide();
        $('#agent__contact-appointment').toggle();
    });
    
    
    
    
    // Set datepickers
    $('.agent__contact-form input.date').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    
    
    
    
    // Send form
    $('#agent__contact-form, #agent__contact-appointment').on('submit', function(ev) { 
        ev.preventDefault();
        
        // Perepare 
        var form = $(this);
        var propertyId = form.data('property-id');
        var data = $(this).serialize() + '&action=vividcrest_send_form&form_id=' + form.attr('id') + '&contact[property_id]=' + propertyId;
        var url = '/wp-admin/admin-ajax.php';
        
        // Make request
        $.post(url, data, function(response) {            
            if (response == 1) {
                form.find('input[type="submit"]')
                    .after('<p>Form sent</p>')
                    .remove();
            } else {
                console.log(response);
            }        
        });   
    });
}) })(jQuery)
