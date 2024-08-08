$(document).ready(function(){
    $('#clear-all').click(function() {
            $('#offense-form')[0].reset(); // Reset the form
            $('#fine-list tbody').empty(); // Clear the offense list
            $('#total_amount').text("₱0.00"); // Reset total amount
            $('input[name="total_amount"]').val(0); // Reset total amount input
            $('#driver_id').val(null).trigger('change'); // Reset the select element
            $('#enforcers_id').val(null).trigger('change'); // Reset the select element
            $('.assignParkingSpot').each(function() {
                if ($(this).hasClass('bg-warning')) {
                    $(this).removeClass('bg-warning').addClass('bg-success');
                }
            });
             $('#parking_location').val('');

        });
})