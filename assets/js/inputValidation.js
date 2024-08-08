$(document).ready(function(){
    $('#license_no_Input').on('input', function() {
			var licenseNoValue = $(this).val(); // Remove non-numeric characters
			var regex = /^[a-zA-Z0-9\s'-]+$/;

			if (licenseNoValue.trim().length === 0) {
				$(this).removeClass('is-valid');
				$(this).removeClass('is-invalid');
			} else if (regex.test(licenseNoValue)) {
				$(this).removeClass('is-invalid');
				$(this).addClass('is-valid');
			} else {
				$(this).removeClass('is-valid');
				$(this).addClass('is-invalid');
			}
		});

		$('#last_name_Input').on('input', function() {
			var lastNameValue = $(this).val();
			var regex = /^[a-zA-Z\s'-]+$/; // Regular expression to allow alphabetic characters, spaces, hyphens, and apostrophes

			if (lastNameValue.trim().length === 0) {
				$(this).removeClass('is-valid');
				$(this).removeClass('is-invalid');
			} else if (regex.test(lastNameValue)) {
				$(this).removeClass('is-invalid');
				$(this).addClass('is-valid');
			} else {
				$(this).removeClass('is-valid');
				$(this).addClass('is-invalid');
			}

		});

		$('#first_name_Input').on('input', function() {
			var firstNameValue = $(this).val();
			var regex = /^[a-zA-Z\s'-]+$/; // Regular expression to allow alphabetic characters, spaces, hyphens, and apostrophes

			if (firstNameValue.trim().length === 0) {
				$(this).removeClass('is-valid');
				$(this).removeClass('is-invalid');
			} else if (regex.test(firstNameValue)) {
				$(this).removeClass('is-invalid');
				$(this).addClass('is-valid');
			} else {
				$(this).removeClass('is-valid');
				$(this).addClass('is-invalid');
			}
		});

		$('#middle_name_Input').on('input', function() {
			var middleNameValue = $(this).val();
			var regex = /^[a-zA-Z\s'-]+$/; // Regular expression to allow alphabetic characters, spaces, hyphens, and apostrophes

			if (middleNameValue.trim().length === 0) {
				$(this).removeClass('is-valid');
				$(this).removeClass('is-invalid');
			} else if (regex.test(middleNameValue)) {
				$(this).removeClass('is-invalid');
				$(this).addClass('is-valid');
			} else {
				$(this).removeClass('is-valid');
				$(this).addClass('is-invalid');
			}

		});
		$('#nationality_Input').on('input', function() {
			var nationalityValue = $(this).val();
			var regex = /^[a-zA-Z\s'-]+$/; // Regular expression to allow alphabetic characters, spaces, hyphens, and apostrophes

			if (nationalityValue.trim().length === 0) {
				$(this).removeClass('is-valid');
				$(this).removeClass('is-invalid');
			} else if (regex.test(nationalityValue)) {
				$(this).removeClass('is-invalid');
				$(this).addClass('is-valid');
			} else {
				$(this).removeClass('is-valid');
				$(this).addClass('is-invalid');
			}

		});

		$('#houseno_Input').on('input', function() {
			var houseNoValue = $(this).val();
			var regex = /^[a-zA-Z0-9\s]+$/; // Regular expression to allow alphanumeric characters and spaces

			if (houseNoValue.trim().length === 0) {
				$(this).removeClass('is-valid');
				$(this).removeClass('is-invalid');
			} else if (regex.test(houseNoValue)) {
				$(this).removeClass('is-invalid');
				$(this).addClass('is-valid');
			} else {
				$(this).removeClass('is-valid');
				$(this).addClass('is-invalid');
			}
		});

		$('#contactInput').on('input', function() {
			var contactValue = $(this).val(); // Remove non-numeric characters
			var invalidFeedback = $(this).closest('.form-group').find('.invalid-feedback');
			var validFeedback = $(this).closest('.form-group').find('.valid-feedback');


			if (contactValue.trim().length === 0) {
				$(this).removeClass('is-valid');
				$(this).removeClass('is-invalid');
			} else if (contactValue.length > 0) {

				if (contactValue.length !== 11) {
					$(this).addClass('is-invalid');
					$(this).removeClass('is-valid');
					invalidFeedback.show();
					validFeedback.hide();
				} else {
					$(this).removeClass('is-invalid');
					$(this).addClass('is-valid');
					invalidFeedback.hide();
					validFeedback.show();
				}
			} else {
				$(this).removeClass('is-valid');
				$(this).addClass('is-invalid');
				invalidFeedback.hide();
				validFeedback.hide();

			}
		});
		/*   $('#last_name_Input').on('input', function() {
		            var lastNameValue = $(this).val(); // Remove non-numeric characters
		            var isempty = $(this).closest('.form-group').find('.isempty');

		            if (lastNameValue.length > 0) {
		                $(this).removeClass('is-invalid');
		                $(this).addClass('is-valid');
		            } else {
		                $(this).removeClass('is-valid');
		                $(this).addClass('is-invalid');


		            }
		        }); */
})