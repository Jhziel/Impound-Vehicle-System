$(document).ready(function(){
    $('.archive_data').click(function() {
			Swal.fire({
				title: "Are you sure you want to archieve this data?",
				icon: "warning",
				showCancelButton: true,
				cancelButtonColor: "#d33",
				confirmButtonColor: "#3085d6",
				confirmButtonText: " Yes "
			}).then((result) => {
				if (result.isConfirmed) {
					archive_offense($(this).attr('data-id'),$(this).attr('data-type'));
				}
			});

		});

        function archive_offense(id,dataType) {
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=archive_"+dataType,
			method: "POST",
			data: {
				id: id
			},
			dataType: "json",
			success: function(resp) {
				if (typeof resp === 'object' && resp.status === 'success') {
					location.reload();
				} else {
					alert_toast("An error occurred.", 'error');
					end_loader();
				}
			},
			error: function(err) {
				console.log(err);
				alert_toast("Error occurred.", 'error');
				end_loader();
			},
		});
	}
})