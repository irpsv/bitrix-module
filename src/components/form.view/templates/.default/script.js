window.addEventListener("DOMContentLoaded", function(){
	var alertSuccess = function(form) {
		var alert = $(form).find(".formView__alert")
		alert.show()
		alert.removeClass("alert-danger")
		alert.addClass("alert-success")
		alert.text("Успешно")
	}
	var alertError = function(form, message) {
		var alert = $(form).find(".formView__alert")
		alert.show()
		alert.removeClass("alert-success")
		alert.addClass("alert-danger")
		alert.text(message)
	}
	$(".formView form").each(function(){
		var form = $(this)
		form.on('submit', function(){
			var btn = form.find("[type='submit']")
			btn.prop("disabled", true)
			$.ajax({
				url: form.attr("action"),
				method: form.attr("method") || "get",
				data: form.serialize(),
				success: function(data) {
					alertSuccess(form)
				},
				error: function(e) {
					btn.prop("disabled", false)
					alertError(form, e.responseText)
				}
			})
			return false;
		})
	})
})
