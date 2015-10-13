(function($) { $(function() { 	
	$('ul.tabs').on('click', 'li:not(.current)', function() {  
		$(this).addClass('current')
			.siblings().removeClass('current')  
				.parents('div.property__visual-wrapper').find('div.box').eq($(this).index())
					.fadeIn(150)
				.siblings('div.box')
					.hide();  
	});
}) })(jQuery)  
