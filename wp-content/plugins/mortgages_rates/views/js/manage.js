(function($){ $(function() {	
	$('input[name=subaction]').on('change', function() {
		var subaction = $(this).val();
		var invert_subaction = (subaction == 'add' ? 'edit' : 'add');

		
		$('.' + subaction).each(function() {
			if (!$(this).hasClass('deleted') || $('input[name=show_deleted]').attr('checked') == 'checked' ) {				
				$(this).show();
			}
		});
		
		$('.' + invert_subaction).hide();
	});
	
	
	
	$('input[name=show_deleted]').on('change', function() {
		$('.deleted').toggle();
	});
	
	
	
	$('.life-button').on('click', function(event) { 
		event.preventDefault();
		
		var id = $(this).attr('id').split('--')[1];
		var action = ($(this).hasClass('restore-button') ? 'restore' : 'delete');
		if ($(this).hasClass('constatly_delete-button')) { action += '_constatly'; }
		
		$('input[name=action]').val(action);
		$('input[name=element_id]').val(id);
		
		$('form').submit();
	});		
}); })(jQuery);
