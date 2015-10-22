(function($) { $(function() { 
    'use strict';
    
    
    // Set default center point
    var centerPoint = {
        latitude: 43.666667,
        longitude: -79.416667
    };
    
    
    // Set center from the first property
    if (typeof Vividcrest.properties != undefined && Vividcrest.properties.length > 0) {
        var firstProperty = Vividcrest.properties[0];
        
        centerPoint = {
            latitude: firstProperty.latitude,
            longitude: firstProperty.longitude,
        };
    }
    
    
    // Init map
    var centerMap = new google.maps.LatLng(centerPoint.latitude, centerPoint.longitude);
    
    var propertiesMap = new google.maps.Map(document.getElementById('map'), {
        center: centerMap,
        zoom: 10,
        panControl: true,
        zoomControl: true,
        scrollwheel: false,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.SMALL
        }
    });	


    // Properties markers
    var markers = [];
    var openedInfowindow = null;
    
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
            var isShown = (openedInfowindow !== null && infowindow.content === openedInfowindow.content);

            if (!isShown) {
                // Close opened infowindow
                if (openedInfowindow !== null) {
                    openedInfowindow.close();
                }

                // Define additional variables
				property.excerpt = property.description.substring(0, 100) + "...";
                property.formattedPrice = Math.ceil(property.price).toString().split(/(?=(?:\d{3})+$)/).join(',');
				
                // Draw infowindow
				var html = '';
				
				html += '<div class="universal__cell property map__property">';
				html += '   <div class="property__image">';
				html += '       <a href="/properties/' + property.id + '">';
				html += '           <span class="label__icon--small icon--green">' + property.type + '</span>';
				html += '           <img src="' + property.main_image + '" / >';
				html += '       </a>';
				html += '   </div>';
				html += '   <div class="property__info-line">';
				html += '       <a href="/properties/' + property.id + '">';
				html += '           <p class="property__price">$' + property.formattedPrice + '</p>';
				html += '       </a>';
				html += '   </div>';
				html += '   <div class="property__description">';
				html += '       <a href="/properties/' + property.id + '">';
				html += '           <ul>';
				html += '               <li>'  + property.bedrooms + ' beds </li>';
				html += '               <li>'  + property.bathrooms + ' baths </li>';
				html += '               <li>'  + property.size + ' sq.ft.</li>';
				html += '           </ul>';
				html += '       </a>';
				html += '   </div>';
				html += '   <div class="property__description--extra">';
				html += '       <a href="/properties/' + property.id + '">';
				html += '           <p>' + property.excerpt + '</p>';
				html += '       </a>';
				html += '   </div>';
				html += '</div>'
				
				
				// Show infowindow
                infowindow.setContent(html);                
                infowindow.open(propertiesMap, this);
                openedInfowindow = infowindow;
            }
            else {
                // Close infowindow
                infowindow.close();
                openedInfowindow = null;
            }
        });
    }); 
    
    
    // Init clusterization
    var markerCluster = new MarkerClusterer(propertiesMap, markers);
}) })(jQuery)
