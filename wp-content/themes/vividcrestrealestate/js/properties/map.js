(function($) { $(function() { 
    'use strict';
    
    
    // Init map
    var centerMap = new google.maps.LatLng(43.666667, -79.416667); // Toronto hardcoded
    
    var propertiesMap = new google.maps.Map(document.getElementById('map'), {
        center: centerMap,
        zoom: 10,
        panControl: true,
        zoomControl: true,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.SMALL
        }
    });	


    // Properties markers
    var markers = [];
    
    Vividcrest.properties.forEach(function(property) {
        // Create the marker
        var marker = new google.maps.Marker({
            map: propertiesMap,
            position: new google.maps.LatLng(property.latitude, property.longitude),
            clickable: true
        });
        
        markers.push(marker);


        // Handle click on the marker
        var infowindow = new google.maps.InfoWindow();

        marker.addListener('click', function() {
            var isShown = property.isShown || false;

            if (!isShown) {
				property.excerpt = property.description.substring(0, 100) + "...";
				
                // Draw infowindow
				var html = '';
				
				html += '<div class="universal__cell property map__property">';
				html += '<div class="property__image">';
				html += '<a href="/properties/' + property.id + '">';
				html += '<span class="label__icon--small icon--green">' + property.type + '</span>';
				html += '<img src="' + property.main_image + '" / >';
				html += '</a>';
				html += '</div>';
				html += '<div class="property__info-line">';
				html += '<a href="/properties/' + property.id + '">';
				html += '<p class="property__price">' + property.price + '</p>';
				html += '</a>';
				html += '</div>';
				html += '<div class="property__description">';
				html += '<a href="/properties/' + property.id + '">';
				html += '<ul>';
				html += '<li>'  + property.bedrooms + ' beds </li>';
				html += '<li>'  + property.bathrooms + ' baths </li>';
				html += '<li>'  + property.size + ' sq.ft.</li>';
				html += '</ul>';
				html += '</a>';
				html += '</div>';
				html += '<div class="property__description--extra">';
				html += '<a href="/properties/' + property.id + '">';
				html += '<p>' + property.excerpt + '</p>';
				html += '</a>';
				html += '</div>';
				html += '</div>'
				
				
				// Show infowindow
                infowindow.setContent(html);                
                infowindow.open(propertiesMap, this);
            }
            else {
                // Close infowindow
                infowindow.close();


                // Mark as not shown
                address.isShown = false;
            }
        });
    }); 
    
    
    // Init clusterization
    var markerCluster = new MarkerClusterer(propertiesMap, markers);
}) })(jQuery)
