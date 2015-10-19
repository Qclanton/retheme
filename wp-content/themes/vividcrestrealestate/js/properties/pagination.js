(function($) { $(function() { 
    'use strict';
    
    $('ul.pagintaion li').on('click', function() {
        $(this).parent().find('li.current').removeClass('current');
        $(this).addClass('current');
        
        $('.property').hide();
        $('.property[data-page="' + $(this).html() + '"]').show();
    });
}) })(jQuery)
