(function($) { $(function() { 
    'use strict';
    
    $.fn.SmallSlider = function(slides, buttons, speed) {
		var slides = slides || [];
		var buttons = buttons || {"prev": "<", "next": ">"};
		var speed = speed || 'fast';
		var wrapper = this;
		
		slides.setActive = function(index, animation_speed) {
			var current_slide = Number(wrapper.find('.small-slider-slides > .active').attr('data-slide-index'));
			var thumb = undefined;
			
			if (typeof animation_speed == typeof undefined) {
				animation_speed = speed;
			}

			if (index == 'prev' || index == 'next') {
				var thumb = index;					
				var prev_slide = current_slide == 0 ? slides.length-1 : current_slide-1;
				var next_slide = current_slide == slides.length-1 ? 0 : current_slide*1+1;
				
				index = index == 'prev' ? prev_slide : next_slide;
			}			
			var slide = this[index];
			
						
			if (typeof thumb !== typeof undefined) {
				var hide_direction = thumb == 'prev' ? 'right' : 'left';
				var show_direction = thumb == 'prev' ? 'left' : 'right';
			}
			else {		
				var hide_direction = index < current_slide ? 'right' : 'left';
				var show_direction = index < current_slide ? 'left' : 'right';
			}
			
			
			
			// Hide inactive slides
			wrapper.find('.small-slider-slide').each(function() { 
				if ($(this).hasClass('active')) {
					$(this).removeClass('active');
				}
				
				if ($(this).css('display') != "none") {
					if (animation_speed == 0) {
						$(this).hide();
					}
					else {
						$(this).hide('slide', {"direction": hide_direction}, animation_speed);
					}
				}
			});
			
			// Show active slide
			wrapper.find('.small-slider-slide[data-slide-index="'+index+'"]').addClass('active');
			if (animation_speed == 0) {
				wrapper.find('.small-slider-slide[data-slide-index="'+index+'"]').show();
			}
			else {
				wrapper.find('.small-slider-slide[data-slide-index="'+index+'"]')
					.show('slide', {"direction": show_direction}, animation_speed);	
			}	
		}		
		
		
		// Render slides
		var slides_html = '';
		slides_html +=	'<div class="small-slider-slides">';
		slides.forEach(function(slide, index) { 
			slides_html +=	'<img data-slide-index="'+index+'" style="display:none" class="small-slider-slide" src="'+slide+'"></img>';
		}); 
		slides_html +=	'</div>';
		this.prepend(slides_html);		
		
		
		// Render arrows
		if (slides.length > 1) {
			var arrows_html = '';
			arrows_html +=	'<div class="small-slider-arrows">';
			arrows_html +=		'<div class="small-slider-prev">'+buttons.prev+'</div>';
			arrows_html +=		'<div class="small-slider-next">'+buttons.next+'</div>';
			arrows_html +=	'</div>';
			this.append(arrows_html);
		}
		
		
		// Set handler for arrows
		this.on('click', 'div.small-slider-prev', function(ev) {
            ev.preventDefault();
            
			if (wrapper.find('.small-slider-slide').is(':animated') == false) {
				slides.setActive('prev');
			}		
		});
        
		this.on('click', 'div.small-slider-next', function(ev) {
            ev.preventDefault();
             
			if (wrapper.find('.small-slider-slide').is(':animated') == false) {
				slides.setActive('next');	
			}	
		});		
		
		// Activate first slide immediately
		slides.setActive(0, 0);
	}
    
    
    $.fn.PropertySliderInit = function() {
        var properties = $(this);
        
        properties.each(function() {
            var property = $(this); 
            var url = '/wp-admin/admin-ajax.php';
            var data = {
                action: 'vividcrest_get_property_images',
                property_id: property.attr('data-property-id')
            };
        
            // Make request
            $.post(url, data, function(response) {
                if (response == 0) {
                    return false;
                }
                                
                
                var images = JSON.parse(response);
                
                if (images.length > 1) {
                    var currentImageWrapper = property.find('img').parent();
                    
                    currentImageWrapper
                        .html('')
                        .SmallSlider(images)
                    ;
                }
            });   
        });
    }
    
    
    $('.slidered-property').PropertySliderInit();
}) })(jQuery)
