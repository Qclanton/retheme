(function($) { $(function() { 
    'use strict';
    
    // Show necessary forms    
    $('.view-toggle').on('click', function(ev) {
        ev.preventDefault();
        
        if (!$(this).parent().hasClass('current')) {
            var searchForm = $($('.search_form')[0]);
            
            searchForm
                .attr('action', $(this).attr('href'))
                .find('input[type="submit"]').click(); // .submit() does not work
        }
    });
}) })(jQuery)
