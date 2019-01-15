window.addEventListener('DOMContentLoaded', function(){
	$("[data-reset-filter]").on("click", function(){
		$(this).parents('.filterView').find("input, select, textarea").each(function(){
			var type = $(this).attr('type')
			if (type === 'checkbox' || type === 'radio') {
				$(this).prop('checked', false)
			}
			else if (type === 'hidden') {
				return;
			}
			else {
				$(this).val(null)
			}
		})
		return false;
	})
})
