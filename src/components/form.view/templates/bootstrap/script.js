window.FormView = function(config) {
	var self = {}
	var form = $(config.selector);
	var responseBlock = form.find('.jsFormViewResponse')

	var replaceNames = function(message) {
		if (config.labels) {
			for (var field in config.labels) {
				var re = new RegExp('('+field+')', 'gi');
				var label = config.labels[field]
				message = message.replace(re, label)
			}
		}
		return message;
	}
	var alertSuccess = function(message) {
		console.log("alertSuccess", message);
		responseBlock.removeClass("alert-danger")
		responseBlock.addClass("alert-success")
		responseBlock.text(message)
		responseBlock.show(200)
	}
	var alertError = function(message) {
		console.log("alertError", message);
		responseBlock.removeClass("alert-success")
		responseBlock.addClass("alert-danger")
		responseBlock.text(
			replaceNames(message)
		)
		responseBlock.show(200)
	}

	form.on('submit', function(){
		responseBlock.hide(200)
		var btn = form.find("[type='submit']").prop("disabled", true)
		$.ajax({
			url: form.attr("action"),
			method: form.attr("method") || "get",
			data: form.serialize(),
			success: function(data) {
				try {
					var jsonData = JSON.parse(data)
					if (jsonData.success) {
						alertSuccess(successMessage)
					}
					else if (jsonData.error) {
						btn.prop("disabled", false)
						alertError(jsonData.error)
					}
					else {
						btn.prop("disabled", false)
						alertError("Неизвестная ошибка")
					}
				}
				catch (e) {
					btn.prop("disabled", false)
					alertError("Некорректный ответ сервера")
					console.log("response", data);
				}
			},
			error: function(e) {
				btn.prop("disabled", false)
				alertError(e.responseText)
			}
		})
		return false;
	})

	return self;
}
