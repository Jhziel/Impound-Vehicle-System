$(document).ready(function(){
    $('#driver-form').submit(function(e) {
			e.preventDefault();
			var _this = $(this)
			$('.err-msg').remove();
			
			if ($('[name="license_id_no"]').hasClass('is-invalid') ||
				$('[name="lastname"]').hasClass('is-invalid') ||
				$('[name="firstname"]').hasClass('is-invalid') ||
				$('[name="middlename"]').hasClass('is-invalid') ||
				$('[name="nationality"]').hasClass('is-invalid') ||
				$('[name="contact"]').hasClass('is-invalid')
			) {
				alert_toast('Please check your input before proceeding', 'error');
				end_loader();
				return false;
			}
			$.ajax({
				url: _base_url_ + "classes/Master.php?f=save_driver",
				data: new FormData($(this)[0]),
				cache: false,
				contentType: false,
				processData: false,
				method: 'POST',
				type: 'POST',
				dataType: 'json',
				error: err => {
					console.log(err)
					alert_toast("An error occureders", 'error');
					end_loader();
				},
				success: function(resp) {
					if (typeof resp == 'object' && resp.status == 'success') {
						location.href = "./?page=drivers";
					} else if (resp.status == 'failed' && !!resp.msg) {
						var el = $('<div>')
						el.addClass("alert alert-danger err-msg").text(resp.msg)
						_this.prepend(el)
						el.show('slow')
						$("html, body").animate({
							scrollTop: _this.closest('.card').offset().top
						}, "fast");
						end_loader()
					} else {
						alert_toast("An error occured", 'error');
						end_loader();
						console.log(resp)
					}
				}
			})
		})
})