(function($) { $(function() { 
    'use strict';
    
    $('ul.pagintaion li').on('click', function() {
        // Separator clicks
        if ($(this).hasClass('separator')) {
            return false;
        }
        
        
        
        // Set vars
        var page = Number($(this).attr('data-page'));
        var total = $('ul.pagintaion li.page-button:last').attr('data-page');
        
        
        
        // Set marker "current"
        $(this).parent().find('li.current').removeClass('current');
        $(this).parent().find('li.page-button[data-page="' + page + '"]').addClass('current');
        
        
        
        // Set "previous" button
        var previousButton = $(this).parent().find('.previous');

        
        if (previousButton.length > 0) {
             previousButton.attr('data-page', page-1);
             
             if (page > 1) {
                previousButton.show();
             } else {
                previousButton.hide();
             }
        }
        
        
        
        // Set "next" button
        var nextButton = $(this).parent().find('.next');
        
        if (nextButton.length > 0) {
             nextButton.attr('data-page', page+1);
             
             if (page < total) {
                nextButton.show();
             } else {
                nextButton.hide();
             }
        }
        
        
        
        // Show or hide first separator
        if (page > 4) {
            $(this).parent().find('li.separator:first').show()
        } else {
            $(this).parent().find('li.separator:first').hide()
        }
        
        
        
        // Show or hide last separator
        if (page < (total-2)) {
            $(this).parent().find('li.separator:last').show()
        } else {
            $(this).parent().find('li.separator:last').hide()
        }
        
        
        
        // Show only first, last and nearest buttons
        $(this).parent().find('li.page-button').hide();
        $(this).parent().find('li.page-button:first').show();
        $(this).parent().find('li.page-button:last').show();
        
        for (var i=(page-2); i<=(page+2); i++) {
            var button = $(this).parent().find('li.page-button[data-page="' + i + '"]');
            
            if (button.length > 0) {
                button.show();
            }
        }
        
        
        // Show only necessary properties
        $('.property').hide();
        $('.property[data-page="' + page + '"]').show();
    });
}) })(jQuery)
