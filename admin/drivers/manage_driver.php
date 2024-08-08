<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
	$qry = $conn->query("SELECT * from `drivers_list` where id = '{$_GET['id']}' ");
	$qry2 = $conn->query("SELECT * from `drivers_meta` where driver_id = '{$_GET['id']}' ");
	if ($qry->num_rows > 0) {
		foreach ($qry->fetch_assoc() as $k => $v) {
			$$k = $v;
		}
	}
	if ($qry2->num_rows > 0) {
		while ($row = $qry2->fetch_assoc()) {
			${$row['meta_field']} = $row['meta_value'];
		}
	}
}
?>

<style>
	img#cimg {
		height: 25vh;
		width: 15vw;
		object-fit: scale-down;
		object-position: center center;
	}
</style>
<div class="card card-outline card-info">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($id) ? "Update " : "Create New " ?> driver</h3>

		<div class="card-tools">

			<a href="?page=drivers" class="btn btn-outline-secondary mr-2">
				<i class="fas fa-arrow-left"></i> Back
			</a>
			<button class="btn btn-danger mr-2" id="clear-all">
				<i class="fas fa-times"></i> Clear All
			</button>
			<button class="btn btn-primary" form="driver-form">
				<i class="fas fa-save"></i> Save
			</button>

		</div>
	</div>
	<div class="card-body">
		<form action="" id="driver-form">
			<input type="hidden" name="id" value="<?= $id ??  '' ?>">
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label for="license_id_no" class="control-label">License No.</label><span class="text-danger h5">*</span>
						<input type="text" maxlength="50" class="form-control form " id="license_no_Input" autocomplete="off" required name="license_id_no" value="<?php echo isset($license_id_no) ? $license_id_no : '' ?>">
						<div class="invalid-feedback">
							Please do not enter a Special Character expect for Hypen
						</div>
					</div>
					<div class="form-group">
						<label for="lastname" class="control-label">Last Name</label><span class="text-danger h5">*</span>
						<input type="text" class="form-control form " id="last_name_Input" required name="lastname" value="<?= $lastname ?? '' ?>">
						<div class="invalid-feedback">
							Please do not enter a Special Character or Number
						</div>
					</div>
					<div class="form-group">
						<label for="firstname" class="control-label">First Name</label><span class="text-danger h5">*</span>
						<input type="text" class="form-control form " id="first_name_Input" required name="firstname" value="<?php echo isset($firstname) ? $firstname : '' ?>">
						<div class="invalid-feedback">
							Please do not enter a Special Character or Number
						</div>
					</div>
					<div class="form-group">
						<label for="middlename" class="control-label">Middle Name</label><span class="text-danger h5">*</span>
						<input type="text" class="form-control form" name="middlename" id="middle_name_Input" value="<?php echo isset($middlename) ? $middlename : '' ?>">
						<div class="invalid-feedback">
							Please do not enter a Special Character or Number
						</div>
					</div>
					<div class="form-group">
						<label for="province" class="control-label">Province</label><span class="text-danger h5">*</span>
						<select name="province" id="province" class="custom-select select2" required>
							<option value="">--Select a Province--</option>
							<option <?php echo (isset($province) && $province == 'Abra') ? 'selected' : '' ?>>Abra</option>
							<option <?php echo (isset($province) && $province == 'Agusan del Sur') ? 'selected' : '' ?>>Agusan del Norte</option>
							<option <?php echo (isset($province) && $province == 'Agusan del Sur') ? 'selected' : '' ?>>Agusan del Sur</option>
							<option <?php echo (isset($province) && $province == 'Aklan') ? 'selected' : '' ?>>Aklan</option>
							<option <?php echo (isset($province) && $province == 'Albay') ? 'selected' : '' ?>>Albay</option>
							<option <?php echo (isset($province) && $province == 'Antique') ? 'selected' : '' ?>>Antique</option>
							<option <?php echo (isset($province) && $province == 'Apayao') ? 'selected' : '' ?>>Apayao</option>
							<option <?php echo (isset($province) && $province == 'Aurora') ? 'selected' : '' ?>>Aurora</option>
							<option <?php echo (isset($province) && $province == 'Basilan') ? 'selected' : '' ?>>Basilan</option>
							<option <?php echo (isset($province) && $province == 'Bataan') ? 'selected' : '' ?>>Bataan</option>
							<option <?php echo (isset($province) && $province == 'Batanes') ? 'selected' : '' ?>>Batanes</option>
							<option <?php echo (isset($province) && $province == 'Batangas') ? 'selected' : '' ?>>Batangas</option>
							<option <?php echo (isset($province) && $province == 'Benguet') ? 'selected' : '' ?>>Benguet</option>
							<option <?php echo (isset($province) && $province == 'Biliran') ? 'selected' : '' ?>>Biliran</option>
							<option <?php echo (isset($province) && $province == 'Bohol') ? 'selected' : '' ?>>Bohol</option>
							<option <?php echo (isset($province) && $province == 'Bukidnon') ? 'selected' : '' ?>>Bukidnon</option>
							<option <?php echo (isset($province) && $province == 'Bulacan') ? 'selected' : '' ?>>Bulacan</option>
							<option <?php echo (isset($province) && $province == 'Cagayan') ? 'selected' : '' ?>>Cagayan</option>
							<option <?php echo (isset($province) && $province == 'Camarines Norte') ? 'selected' : '' ?>>Camarines Norte</option>
							<option <?php echo (isset($province) && $province == 'Camarines Sur') ? 'selected' : '' ?>>Camarines Sur</option>
							<option <?php echo (isset($province) && $province == 'Camiguin') ? 'selected' : '' ?>>Camiguin</option>
							<option <?php echo (isset($province) && $province == 'Capiz') ? 'selected' : '' ?>>Capiz</option>
							<option <?php echo (isset($province) && $province == 'Catanduanes') ? 'selected' : '' ?>>Catanduanes</option>
							<option <?php echo (isset($province) && $province == 'Cavite') ? 'selected' : '' ?>>Cavite</option>
							<option <?php echo (isset($province) && $province == 'Cebu') ? 'selected' : '' ?>>Cebu</option>
							<option <?php echo (isset($province) && $province == 'Cotabato') ? 'selected' : '' ?>>Cotabato</option>
							<option <?php echo (isset($province) && $province == 'Davao de Oro') ? 'selected' : '' ?>>Davao de Oro</option>
							<option <?php echo (isset($province) && $province == 'Davao del Norte') ? 'selected' : '' ?>>Davao del Norte</option>
							<option <?php echo (isset($province) && $province == 'Davao del Sur') ? 'selected' : '' ?>>Davao del Sur</option>
							<option <?php echo (isset($province) && $province == 'Davao Occidental') ? 'selected' : '' ?>>Davao Occidental</option>
							<option <?php echo (isset($province) && $province == 'Davao Oriental') ? 'selected' : '' ?>>Davao Oriental</option>
							<option <?php echo (isset($province) && $province == 'Dinagat Islands') ? 'selected' : '' ?>>Dinagat Islands</option>
							<option <?php echo (isset($province) && $province == 'Eastern Samar') ? 'selected' : '' ?>>Eastern Samar</option>
							<option <?php echo (isset($province) && $province == 'Guimaras') ? 'selected' : '' ?>>Guimaras</option>
							<option <?php echo (isset($province) && $province == 'Ifugao') ? 'selected' : '' ?>>Ifugao</option>
							<option <?php echo (isset($province) && $province == 'Ilocos Norte') ? 'selected' : '' ?>>Ilocos Norte</option>
							<option <?php echo (isset($province) && $province == 'Ilocos Sur') ? 'selected' : '' ?>>Ilocos Sur</option>
							<option <?php echo (isset($province) && $province == 'Iloilo') ? 'selected' : '' ?>>Iloilo</option>
							<option <?php echo (isset($province) && $province == 'Isabela') ? 'selected' : '' ?>> Isabela</option>
							<option <?php echo (isset($province) && $province == 'Kalinga') ? 'selected' : '' ?>>Kalinga</option>
							<option <?php echo (isset($province) && $province == 'La Union') ? 'selected' : '' ?>>La Union</option>
							<option <?php echo (isset($province) && $province == 'Laguna') ? 'selected' : '' ?>>Laguna</option>
							<option <?php echo (isset($province) && $province == 'Lanao del Norte') ? 'selected' : '' ?>>Lanao del Norte</option>
							<option <?php echo (isset($province) && $province == 'Lanao del Sur') ? 'selected' : '' ?>>Lanao del Sur</option>
							<option <?php echo (isset($province) && $province == 'Leyte') ? 'selected' : '' ?>>Leyte</option>
							<option <?php echo (isset($province) && $province == 'Maguindanao del Norte') ? 'selected' : '' ?>>Maguindanao del Norte</option>
							<option <?php echo (isset($province) && $province == 'Marinduque') ? 'selected' : '' ?>>Marinduque</option>
							<option <?php echo (isset($province) && $province == 'Masbate') ? 'selected' : '' ?>>Masbate</option>
							<option <?php echo (isset($province) && $province == 'Metro Manila') ? 'selected' : '' ?>>Metro Manila</option>
							<option <?php echo (isset($province) && $province == 'Misamis Occidental') ? 'selected' : '' ?>>Misamis Occidental</option>
							<option <?php echo (isset($province) && $province == 'Misamis Oriental') ? 'selected' : '' ?>>Misamis Oriental</option>
							<option <?php echo (isset($province) && $province == 'Mountain Province') ? 'selected' : '' ?>>Mountain Province</option>
							<option <?php echo (isset($province) && $province == 'Negros Occidental') ? 'selected' : '' ?>>Negros Occidental</option>
							<option <?php echo (isset($province) && $province == 'Negros Oriental') ? 'selected' : '' ?>>Negros Oriental</option>
							<option <?php echo (isset($province) && $province == 'Northern Samar') ? 'selected' : '' ?>>Northern Samar</option>
							<option <?php echo (isset($province) && $province == 'Nueva Ecija') ? 'selected' : '' ?>>Nueva Ecija</option>
							<option <?php echo (isset($province) && $province == 'Nueva Vizcaya') ? 'selected' : '' ?>>Nueva Vizcaya</option>
							<option <?php echo (isset($province) && $province == 'Occidental Mindoro') ? 'selected' : '' ?>>Occidental Mindoro</option>
							<option <?php echo (isset($province) && $province == 'Oriental Mindoro') ? 'selected' : '' ?>>Oriental Mindoro</option>
							<option <?php echo (isset($province) && $province == 'Palawan') ? 'selected' : '' ?>>Palawan</option>
							<option <?php echo (isset($province) && $province == 'Pampanga') ? 'selected' : '' ?>>Pampanga</option>
							<option <?php echo (isset($province) && $province == 'Pangasinan') ? 'selected' : '' ?>>Pangasinan</option>
							<option <?php echo (isset($province) && $province == 'Quezon') ? 'selected' : '' ?>>Quezon</option>
							<option <?php echo (isset($province) && $province == 'Quirino') ? 'selected' : '' ?>>Quirino</option>
							<option <?php echo (isset($province) && $province == 'Rizal') ? 'selected' : '' ?>>Rizal</option>
							<option <?php echo (isset($province) && $province == 'Romblon') ? 'selected' : '' ?>>Romblon</option>
							<option <?php echo (isset($province) && $province == 'Samar') ? 'selected' : '' ?>>Samar</option>
							<option <?php echo (isset($province) && $province == 'Sarangani') ? 'selected' : '' ?>>Sarangani</option>
							<option <?php echo (isset($province) && $province == 'Siquijor') ? 'selected' : '' ?>>Siquijor</option>
							<option <?php echo (isset($province) && $province == 'Sorsogon') ? 'selected' : '' ?>>Sorsogon</option>
							<option <?php echo (isset($province) && $province == 'South Cotabato') ? 'selected' : '' ?>>South Cotabato</option>
							<option <?php echo (isset($province) && $province == 'Southern Leyte') ? 'selected' : '' ?>>Southern Leyte</option>
							<option <?php echo (isset($province) && $province == 'Sultan Kudarat') ? 'selected' : '' ?>>Sultan Kudarat</option>
							<option <?php echo (isset($province) && $province == 'Sulu') ? 'selected' : '' ?>>Sulu</option>
							<option <?php echo (isset($province) && $province == 'Surigao del Norte') ? 'selected' : '' ?>>Surigao del Norte</option>
							<option <?php echo (isset($province) && $province == 'Surigao del Sur') ? 'selected' : '' ?>>Surigao del Sur</option>
							<option <?php echo (isset($province) && $province == 'Tarlac') ? 'selected' : '' ?>>Tarlac</option>
							<option <?php echo (isset($province) && $province == 'Tawi-Tawi') ? 'selected' : '' ?>>Tawi-Tawi</option>
							<option <?php echo (isset($province) && $province == 'Zambales') ? 'selected' : '' ?>>Zambales</option>
							<option <?php echo (isset($province) && $province == 'Zamboanga del Norte') ? 'selected' : '' ?>>Zamboanga del Norte</option>
							<option <?php echo (isset($province) && $province == 'Zamboanga del Sur') ? 'selected' : '' ?>>Zamboanga del Sur</option>
							<option <?php echo (isset($province) && $province == 'Zamboanga Sibugay') ? 'selected' : '' ?>>Zamboanga Sibugay</option>
						</select>
					</div>
					<div class="form-group" style="margin-bottom: 63px;" id="barangayGroup">
						<label for="barangay" class="control-label">Barangay</label><span class="text-danger h5">*</span>
						<select name="barangay" id="barangay" class="custom-select select2" required>
							<option value="">--Select a Barangay--</option>
						</select>
					</div>
					<div class="form-group">
						<label for="" class="control-label">Photo</label>
						<div class="custom-file">
							<input type="hidden" name="image_path" value="<?php echo isset($image_path) ? $image_path : '' ?>">
							<input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
							<label class="custom-file-label" for="customFile">Choose file</label>
						</div>
					</div>
					<div class="form-group d-flex justify-content-center">
						<img align="center" src="<?php echo validate_image(isset($image_path) ? $image_path : '') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
					</div>

				</div>
				<div class="col-6">
					<div class="form-group">
						<label for="civil_status" class="control-label">Civil Status</label><span class="text-danger h5">*</span>
						<select name="civil_status" id="civil_status" class="custom-select select2">
							<option <?php echo (isset($civil_status) && $civil_status == 'Single') ? 'selected' : '' ?>>Single</option>
							<option <?php echo (isset($civil_status) && $civil_status == 'Married') ? 'selected' : '' ?>>Married</option>
							<option <?php echo (isset($civil_status) && $civil_status == 'Divorced') ? 'selected' : '' ?>>Divorced</option>
							<option <?php echo (isset($civil_status) && $civil_status == 'Windowed') ? 'selected' : '' ?>>Windowed</option>
						</select>
					</div>
					<div class="form-group">
						<label for="nationality" class="control-label">Nationality</label><span class="text-danger h5">*</span>
						<input type="text" class="form-control form " required name="nationality" id="nationality_Input" value="<?php echo isset($nationality) ? $nationality : '' ?>">
						<div class="invalid-feedback">
							Please do not enter a Special Character or Number
						</div>
					</div>
					<div class="form-group">
						<label for="contact" class="control-label">Contact Number</label><span class="text-danger h5">*</span>
						<input type="tel" class="form-control form " name="contact" id="contactInput" value="<?php echo isset($contact) ? $contact : '' ?>" required maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
						<div class="invalid-feedback text-danger" style="display: none;">
							Contact number must be 11 digits.
						</div>


					</div>

					<div class="form-group">
						<label for="license_type" class="control-label">License Type</label><span class="text-danger h5">*</span>
						<select name="license_type" id="license_type" class="custom-select select2">
							<option <?php echo (isset($license_type) && $license_type == 'Student') ? 'selected' : '' ?>>Student</option>
							<option <?php echo (isset($license_type) && $license_type == 'Non-Professional') ? 'selected' : '' ?>>Non-Professional</option>
							<option <?php echo (isset($license_type) && $license_type == 'Professional') ? 'selected' : '' ?>>Professional</option>
						</select>
					</div>
					<div class="form-group" id="municipalityGroup">
						<label for="municipality" class="control-label">Municipality</label><span class="text-danger h5">*</span>
						<select name="municipality" id="municipality" class="custom-select select2" required>
							<option value="">--Select a Municipality--</option>
						</select>
					</div>
					<div class="form-group">
						<label for="permanent_address" class="control-label">House No.</label><span class="text-danger h5">*</span>
						<textarea rows="3" class="form-control" style="resize:none" id="houseno_Input" required name="permanent_address"><?php echo isset($permanent_address) ? $permanent_address : '' ?></textarea>
						<div class="invalid-feedback">
							Please do not enter a Special Character
						</div>
					</div>
					<div class="form-group">
						<label for="dob" class="control-label">Date of Birth</label><span class="text-danger h5">*</span>
						<input type="date" class="form-control form" required name="dob" value="<?php echo isset($dob) ? date("Y-m-d", strtotime($dob)) : '' ?>" max="<?php echo date('Y-m-d'); ?>">

					</div>
				</div>
			</div>
		</form>
	</div>

</div>
<script src="/../traffic_offense/assets/js/Municipality_Province_Barangay.js"></script>
<script src="/../traffic_offense/assets/js/displayImg.js"></script>
<script src="/../traffic_offense/assets/js/inputValidation.js"></script>
<script src="/../traffic_offense/assets/js/addDriver.js"></script>
<script>
	$(document).ready(function() {
		$('#clear-all').click(function() {
			$('#driver-form')[0].reset(); // Reset the form
			
		});


		var selectedProvince = "<?php echo isset($province) ? $province : ''; ?>";
		$('#province').val(selectedProvince).change();
		var municipalityValue = "<?php echo isset($municipality) ? $municipality : ''; ?>";
		$('#municipality').val(municipalityValue).change(); // Set the value directly from the database
		var barangayValue = "<?php echo isset($barangay) ? $barangay : ''; ?>";
		$('#barangay').val(barangayValue).change(); // Set the value directly from the database
	})
</script>