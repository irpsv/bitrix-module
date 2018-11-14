window.addEventListener("DOMContentLoaded", function(){
	var replaceNames = function(form, message) {
		var id = $(form).parent().attr('id')
		var labels = window.formViewBootstrapLabels[id]
		if (labels) {
			for (var field in labels) {
				var re = new RegExp('('+field+')', 'gi');
				var label = labels[field]
				message = message.replace(re, label)
			}
		}
		return message;
	}
	var alertSuccess = function(form, message) {
		var alert = $(form).find(".formViewBootstrap__alert")
		alert.show()
		alert.removeClass("alert-danger")
		alert.addClass("alert-success")
		alert.text(message)
	}
	var alertError = function(form, message) {
		var alert = $(form).find(".formViewBootstrap__alert")
			message = replaceNames(form, message)
		alert.show()
		alert.removeClass("alert-success")
		alert.addClass("alert-danger")
		alert.text(message)
	}

	$(".formViewBootstrap[data-ajax=1]").each(function(){
		var form = $(this).find('form').first()
		var successMessage = $(this).data('success') || 'Успешно';

		form.on('submit', function(){
			var btn = form.find("[type='submit']")
			btn.prop("disabled", true)
			$.ajax({
				url: form.attr("action"),
				method: form.attr("method") || "get",
				data: form.serialize(),
				success: function(data) {
					try {
						var jsonData = JSON.parse(data)
						if (jsonData.success) {
							alertSuccess(form, successMessage)
						}
						else if (jsonData.error) {
							btn.prop("disabled", false)
							alertError(form, jsonData.error)
						}
						else {
							btn.prop("disabled", false)
							alertError(form, "Неизвестная ошибка")
							console.log(data);
						}
					}
					catch (e) {
						btn.prop("disabled", false)
						alertError(form, data)
						console.log(data);
					}
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
