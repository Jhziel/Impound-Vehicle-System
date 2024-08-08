<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
	$user = $conn->query("SELECT * FROM users where id ='{$_GET['id']}'");
	foreach ($user->fetch_array() as $k => $v) {
		$meta[$k] = $v;
	}

	$qry = $conn->query("SELECT * FROM `staff_privellages` WHERE `staff_unique_id` = '$meta[unique_id]'");
	foreach ($qry->fetch_assoc() as $k => $v) {
		$$k = $v;
	}
}
?>
<?php if ($_settings->chk_flashdata('success')) : ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($id) ? "Update " : "Create New " ?> User</h3>

		<div class="card-tools">

			<a href="./?page=user/list" class="btn btn-outline-secondary mr-2">
				<i class="fas fa-arrow-left"></i> Back
			</a>
			<button class="btn btn-danger mr-2" id="clear-all">
				<i class="fas fa-times"></i> Clear All
			</button>
			<button class="btn btn-primary" form="manage-user">
				<i class="fas fa-save"></i> Save
			</button>

		</div>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-6">
				<div id="msg"></div>
				<form action="" id="manage-user">
					<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id'] : '' ?>">
					<input type="hidden" name="unique_id" value="">
					<div class="form-group ">
						<label for="name">First Name</label>
						<input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname'] : '' ?>" required>
					</div>
					<div class="form-group ">
						<label for="name">Last Name</label>
						<input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname'] : '' ?>" required>
					</div>
					<div class="form-group ">
						<label for="username">Username</label>
						<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username'] : '' ?>" required autocomplete="off">
					</div>
					<div class="form-group ">
						<label for="password">Password</label>
						<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off" <?php echo isset($meta['id']) ? "" : 'required' ?>>
						<?php if (isset($_GET['id'])) : ?>
							<small><i>Leave this blank if you dont want to change the password.</i></small>
						<?php endif; ?>
					</div>
					<div class="form-group ">
						<label for="type">Login Type</label>
						<select name="type" id="type" class="custom-select">
							<option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected' : '' ?>>Administrator</option>
							<option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected' : '' ?>>Staff</option>
						</select>
					</div>
					<div class="form-group ">
						<label for="" class="control-label">Avatar</label>
						<div class="custom-file">
							<input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
							<label class="custom-file-label" for="customFile">Choose file</label>
						</div>
					</div>
					<div class="form-group  d-flex justify-content-center">
						<img src="<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] : '') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
					</div>

			</div>
			<div class="col-6">
				<h2 class="text-center">PRIVELLAGES</h2>
				<div class="form-check ml-4">
					<input type="checkbox" class="form-check-input" name="driver_list_check" id="driver_list_check " <?php echo isset($driver_list_check) && $driver_list_check === '1' ? 'checked' : '' ?>>
					<label class="form-check-label ml-2" for="driver_list_check">Driver List</label>
				</div>
				<div class="form-check ml-2 mt-1">
					<label class="form-check-label ml-1" for="offense_records_check">Offense Records</label>
				</div>
				<div class="form-check ml-5">
					<input type="checkbox" class="form-check-input" name="ticket_violation_check" id="ticket_violation_check" <?php echo isset($ticket_violation_check) && $ticket_violation_check === '1' ? 'checked' : '' ?>>
					<label class="form-check-label ml-2" for="ticket_violation_check">Ticket Violation</label>
				</div>
				<div class="form-check ml-5">
					<input type="checkbox" class="form-check-input" name="impound_vehicle_check" id="impound_vehicle_check" <?php echo isset($impound_vehicle_check) && $impound_vehicle_check === '1' ? 'checked' : '' ?>>
					<label class="form-check-label ml-2" for="impound_vehicle_check">Impound Vehicle</label>
				</div>
				<div class="form-check ml-4 mt-1">
					<input type="checkbox" class="form-check-input" name="impound_area_check" id="impound_area_check" <?php echo isset($impound_area_check) && $impound_area_check === '1' ? 'checked' : '' ?>>
					<label class="form-check-label ml-2" for="impound_area_check">Impound Area</label>
				</div>
				<div class="form-check ml-4 mt-1">
					<input type="checkbox" class="form-check-input" name="reports_check" id="reports_check" <?php echo isset($reports_check) && $reports_check === '1' ? 'checked' : '' ?>>
					<label class="form-check-label ml-2" for="reports_check">Reports</label>
				</div>
				<div class="form-check ml-1 mt-1">
					<label class="form-check-label  ml-2" for="archieve_data_check">Archieve Data</label>
				</div>
				<div class="form-check ml-5">
					<input type="checkbox" class="form-check-input" name="driver_archieve_check" id="driver_archieve_check" <?php echo isset($driver_archieve_check) && $driver_archieve_check === '1' ? 'checked' : '' ?>>
					<label class="form-check-label ml-2" for="driver_archieve_check">Driver Archieve</label>
				</div>
				<div class="form-check ml-5">
					<input type="checkbox" class="form-check-input" name="enforcer_archieve_check" id="enforcer_archieve_check">
					<label class="form-check-label ml-2" for="enforcer_archieve_check">Enforcer Archieve</label>
				</div>
				<div class="form-check ml-5">
					<input type="checkbox" class="form-check-input" name="ticket_violation_archieve_check" id="ticket_violation_archieve_check" <?php echo isset($ticket_violation_archieve_check) && $ticket_violation_archieve_check === '1' ? 'checked' : '' ?>>
					<label class="form-check-label ml-2" for="ticket_violation_archieve_check">Ticket Violation Archieve</label>
				</div>
				<div class="form-check ml-5">
					<input type="checkbox" class="form-check-input" name="impound_vehicle_archieve_check" id="impound_vehicle_archieve_check" <?php echo isset($impound_vehicle_archieve_check) && $impound_vehicle_archieve_check === '1' ? 'checked' : '' ?>>
					<label class="form-check-label ml-2" for="impound_vehicle_archieve_check">Impound Vehicle Archieve</label>
				</div>
			</div>
		</div>
		</form>


	</div>
	
</div>
<style>
	img#cimg {
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>
	function displayImg(input, _this) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#cimg').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
	$('#clear-all').click(function() {
		$('#manage-user')[0].reset(); // Reset the form

	});
	$('#manage-user').submit(function(e) {
		e.preventDefault();
		start_loader()
		$.ajax({
			url: _base_url_ + 'classes/Users.php?f=save',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				if (resp == 1) {
					location.href = './?page=user/list';
				} else {
					$('#msg').html('<div class="alert alert-danger">Username already exist</div>')
				}
				end_loader()
			}
		})
	})
</script>