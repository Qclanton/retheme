(function($) { $(function() { 
    'use strict';
    
    function redraw(properties) {
        var properties_html = '';
        
        properties.forEach(function(property, i) {
            // Pagination params
            var page = Math.ceil((i+1)/8);
            var hidden = (page == 1 ? 'style="display:none"' : '');
            
            // Property params
            property.link = '/properties/' + property.id;
            property.size = (property.size != 0 ? property.size : 'N/A');
            property.excerpt = property.description.substring(0, 100) + "...";            
            
            // New property block
            properties_html += '<div data-page="' + page + '" ' + hidden + ' class="universal__cell property">';
            properties_html += '   <div class="property__image">';
            properties_html += '       <i class="fa fa-star-o"></i>';
            properties_html += '       <a href="' + property.link + '">';
            properties_html += '           <span class="label__icon--small icon--green">Open House</span>';
            properties_html += '           <img src="' + property.main_image + '" />';
            properties_html += '       </a>';
           	properties_html += '       <div class="carousel-arrows--small">';
			properties_html += '           <div class="carousel-arrow--prev"></div>';
			properties_html += '           <div class="carousel-arrow--next"></div>';
			properties_html += '       </div>';
            properties_html += '   </div>';
            properties_html += '   <div class="property__info-line">';
            properties_html += '       <a href="' + property.link + '">';
            properties_html += '           <p class="property__price">' + Math.ceil(property.price) + '</p>';
            properties_html += '       </a>';
            properties_html += '   </div>';
            properties_html += '   <div class="property__description">';
            properties_html += '       <a href="' + property.link + '">';
            properties_html += '           <ul>';
            properties_html += '               <li>' + property.bedrooms + ' beds</li>';
            properties_html += '               <li>' + property.bathrooms + ' baths</li>';
            properties_html += '               <li>' + property.size + ' sq.ft.</li>';
            properties_html += '           </ul>';
            properties_html += '           <p class="property__description-city">';
            properties_html += '               <strong>' + property.address + '</strong>';
            properties_html += '           </p>';
            properties_html += '           <p class="property__description-city">';
            properties_html +=                     property.excerpt;
            properties_html += '           </p>';
            properties_html += '       </a>';
            properties_html += '   </div>';
            properties_html += '</div>';
        });
        
        
        // Redraw all properties
        $('div.properties-list').html(properties_html);
        
        
        // Set first page
        $('ul.pagintaion li.page-button[data-page="1"]').click();   
    }
    
    
    $('select[name="properties-sorting"').on('change', function() {
        var params = $(this).val().split('|');        
        var field = params[0];
        var side = params[1];
        var type =  params[2] || "string";
        
        Vividcrest.properties.sort(function(some, other) { 
            if (type == "number") {
                some[field] = Number(some[field]);
                other[field] = Number(other[field]);
            }
            
            if (some[field] > other[field]) {
                return (side === 'asc' ? 1 : -1);
            } else {
                return (side === 'asc' ? -1 : 1);
            }
        });
        
        redraw(Vividcrest.properties);     
    });
}) })(jQuery)
