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
        $('ul.pagintaion li.current').removeClass('current');
        $('ul.pagintaion li.page-button[data-page="' + page + '"]').addClass('current');
        
        
        
        // Set "previous" button
        var previousButton = $('ul.pagintaion .previous')
        
        if (previousButton.length > 0) {
             previousButton.attr('data-page', page-1);
             
             if (page > 1) {
                previousButton.show();
             } else {
                previousButton.hide();
             }
        }
        
        
        
        // Set "next" button
        var nextButton = $('ul.pagintaion li .next');
        
        if (nextButton.length > 0) {
             nextButton.attr('data-page', page+1);
             
             if (page < total) {
                nextButton.show();
             } else {
                nextButton.hide();
             }
        }
        
        
        
        // Show or hide separators
        if (page > 4) {
            $('ul.pagintaion li.separator').each(function(index) { 
                var separator = $(this);
                
                if (index == 0) {
                    (page > 4 
                        ? separator.show()
                        : separator.hide()
                    );
                } else {
                    (page < (total-2)
                        ? separator.show()
                        : separator.hide()
                    );
                }
            });
        } 
        
        
        
        // Show only first, last and nearest buttons
        $('ul.pagintaion li.page-button').hide();
        $('ul.pagintaion li.page-button-first').show();
        $('ul.pagintaion li.page-button-last').show();
        
        for (var i=(page-2); i<=(page+2); i++) {
            var button = $('ul.pagintaion li.page-button[data-page="' + i + '"]');
            
            if (button.length > 0) {
                button.show();
            }
        }
        
        
        // Show only necessary properties
        $('.property').hide();
        $('.property[data-page="' + page + '"]').show();
    });
}) })(jQuery)
