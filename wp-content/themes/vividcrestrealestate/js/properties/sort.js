(function($) { $(function() { 
    'use strict';
    
    $('select[name="properties-per-page"').on('change', function() {
        var perPage = $(this).val();
        var sort = (typeof urlParams.sort !== typeof undefined
            ? encodeURIComponent(urlParams.sort)
            : encodeURIComponent('publish_date|DESC')
        );
        var redirectionUrl = window.location.origin + window.location.pathname +  '?sort=' + sort + '&per_page=' + perPage;
        
        window.location.replace(redirectionUrl);
    });
    
    $('select[name="properties-sorting"').on('change', function() {
        var perPage = urlParams.per_page || 8;
        var sort = encodeURIComponent($(this).val());
        var redirectionUrl = window.location.origin + window.location.pathname +  '?sort=' + sort + '&per_page=' + perPage;
        
        window.location.replace(redirectionUrl);
    });
}) })(jQuery)
