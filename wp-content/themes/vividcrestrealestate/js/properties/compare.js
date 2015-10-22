(function($) { $(function() { 
    'use strict';
    
    // Turn on autosjson cookie
	$.cookie.json = true;
    
    
    // Set cookie settings
    var cookieSettings = {
        path: '/',
        expires: 31
    }
    
	// Get comparsions and set functions for manage
	var comparsions = {
		list: $.cookie('comparsions') || [],
		
        isCollapsed: $.cookie('comparsionBlockCollapsed') || false,
        
		removeBlock: function() {
			$('section#compare-block').remove();
		},
		
        renderCollapsed: function() {
            var html = '';
            
            html += '<section id="compare-block" class="universal-wrapper compare-block-wrapper">'
            html += '   <div class="block-wrapper--light-grey block-wrapper--small">';
            html += '       <a class="expand-compare" href="#"><i class="fa fa-expand"></i> Expand Compare</a>';
            html += '   </div>';
            html += '</section>';
            
            $('section.content-block-wrapper').after(html);
        },
        
        collapse: function() {
            this.isCollapsed = true;
            $.cookie('comparsionBlockCollapsed', true, cookieSettings);
            
            this.renderBlock();
        },
        
        expand: function() {
            this.isCollapsed = false;
            $.cookie('comparsionBlockCollapsed', false, cookieSettings);
            
            this.renderBlock();
        },
        
		renderBlock: function() {
            this.removeBlock();
			var html = '';			
            
    
    
            if (this.isCollapsed) {
                console.log(this.isCollapsed);
                this.renderCollapsed();
                return;
            }

            
            if (this.list.length == 0) {
                return;
            }
			
	
    
            // Draw html
            html += '<section id="compare-block" class="universal-wrapper compare-block-wrapper">';
            html += '   <div class="universal-wrapper--inner block-wrapper--light-grey">';
            html += '       <div class="compare__navigation">';
            html += '           <a href="#" class="collapse-compare">';	
            html += '               <i class="fa fa-minus-square-o"></i>';
            html += '           </a>';	
            html += '           <a href="#" class="close-compare">';
            html += '               <i class="fa fa-times"></i>'
            html += '           </a>';	
            html += '   </div>';
            html += '   <div class="compare__title">';	
            html += '       <h1>Compare Up to 5 properties</h1>';	
            html += '   </div>';
            html += '   <div class="universal_line-wrapper five__cols">';	
            
            for (var i=0; i<5; i++) {
                var property = this.list[i] || {id: null, link: '#', image: '#'};
                
                html += '   <div class="universal__cell compare">';
                html += '       <div class="property__image">';
                
                if (property.id !== null) {
                    html += '       <a data-property-id="' + property.id + '" class="uncompare-link-block" href="#">';
                    html += '           <i class="fa fa-times"></i>';
                    html += '       </a>';
                    html += '       <a class="property-link" href="' + property.link + '">';
                    html += '           <img src="' + property.image + '"/>';
                    html += '       </a>';
                    
                }
                
                html += '       </div>';
                html += '   </div>';
                
            }
            
            html += '       <div class="universal__cell compare">';	
            html += '           <a class="universal-button to-detailed-compare" href="/compare">';	
            html += '               Detailed Compare';
            html += '           </a>';
            html += '       </div>';
            html += '   </div>';
            html += '</section>';
            
            $('section.content-block-wrapper').after(html);
		},
		
		find: function(property) {
			var result = -1;
			
			this.list.forEach(function(compare, index) {			
				if (compare.id == property.id) {
					result = index;
				}			
			});
			
			return result;
		},
		
		has: function(property) {
			return this.find(property) > -1;
		},
		
		add: function(property) {
			this.list.push(property);	
			$.cookie('comparsions', this.list, cookieSettings);
			this.renderBlock();
		},
		
		remove: function(propertyId) {
            var property = {
                id: propertyId
            };            
			var existedPropertyIndex = this.find(property);
			
			if (existedPropertyIndex > -1) {
				this.list.splice(existedPropertyIndex, 1);
				$.cookie('comparsions', this.list, cookieSettings);
				this.renderBlock();
			}
		},
		
		clear: function() {		
			this.list = [];
			$.cookie('comparsions', this.list, cookieSettings);			
			this.removeBlock();
		}
	};





	// Function for extract property data from html
	function extractProperty(element) {	
        var link = element.find('.property-link');
        
		var property = {
            "id": link.attr('data-property-id'),
			"link": link.attr('href'),
			"image": link.find('img').attr('src')
		};
		
		return property; 		
	}
	
    
    
    
    	
	// Add function for display links and adding comparsions
	$.fn.addCompareLinks = function() {
        // Add events for mouse moves
		this.on('mouseenter', function() {
			var property = extractProperty($(this));
            var compareElementWrapper = $(this).find('.property__image');
            
            var hasProperty = comparsions.has(property);
            var title = (hasProperty ? "Uncompare" : "Compare");
            var mainClass = (hasProperty ? "uncompare-link" : "compare-link");
            
            var html = ''
            html += '<a title="' + title + '" class="' + mainClass + ' label__icon--small label__icon--right">';
            html +=     title;
            html += '</a>';
            
            if (comparsions.list.length < 5 || hasProperty) {
                compareElementWrapper.prepend(html);
            }
        });		
		
		this.on('mouseleave', function() { 
			$(this).find('a.compare-link').remove();
			$(this).find('a.uncompare-link').remove();
		});
        
        
		// Add listeners for events
		this.on('click', 'a.compare-link', function(ev) { 
			ev.preventDefault();
			
			var property = extractProperty($(this).parents('.property'));					
			comparsions.add(property);	
			
			$(this)
				.removeClass('compare-link')
				.addClass('uncompare-link')
				.html('Uncompare')
			;			
		});
		
		this.on('click', 'a.uncompare-link', function(ev) { 
			ev.preventDefault();
			
			var property = extractProperty($(this).parents('.property'));				
			comparsions.remove(property.id);					
			
			$(this)				
				.removeClass('uncompare-link')
				.addClass('compare-link')
				.html('Compare')
			;
		});
	}
	
	
	
	// Add handler for "uncompare" links in generated block
	$('body').on('click', '.uncompare-link-block', function(ev) { 
		ev.preventDefault();			
		comparsions.remove($(this).attr('data-property-id'));		
	});	
	
	// Add handler for "close" compare links
	$('body').on('click', 'a.close-compare', function(ev) { 
		ev.preventDefault();	
		comparsions.clear();
	});
  
    // Add handler for "collapse" compare links
	$('body').on('click', 'a.collapse-compare', function(ev) { 
		ev.preventDefault();
		comparsions.collapse();
	});
    
    // Add handler for "expand" compare links
    $('body').on('click', 'a.expand-compare', function(ev) { 
		ev.preventDefault();
        comparsions.expand();
	});





	// Activate
    $('.property').addCompareLinks();
    comparsions.renderBlock();
}) })(jQuery)
