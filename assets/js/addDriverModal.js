 function ucwords(str) {
            return str.replace(/\w\S*/g, function(txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
        }

$(document).ready(function() {
        $('#driver-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this)
            $('.err-msg').remove();
            start_loader();
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
                url: _base_url_ + "classes/Master.php?f=save_driver_modal",
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
                    if (typeof resp === 'object' && resp.status === 'success') {
                        $('#uni_modal').modal('hide');
                        var driverId = resp.driver_id;
                        var license_no = $('#license_no_Input').val();
                        var last_name = $('#last_name_Input').val();
                        var first_name = $('#first_name_Input').val();
                        var middle_name = $('#middle_name_Input').val();

                        // Fix: Invoke ucwords function to format the name
                        var formattedName = "[" + license_no + "]" + ucwords(last_name + ', ' + first_name + ' ' + middle_name);

                        // Fix: Use .val() to get the value of the option
                        var newDriver = $('<option>', {
                            value: formattedName,
                            text: formattedName,
                            value: driverId
                        });

                        // Fix: Use .append(newDriver) to append the new option
                        $("#driver_id").append(newDriver);

                        // Optionally, you can set the new option as selected
                        newDriver.prop("selected", true);
                        end_loader();
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