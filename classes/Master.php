<?php
require_once('../config.php');
class Master extends DBConnection
{
	private $settings;
	public function __construct()
	{
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	function capture_err()
	{
		if (!$this->conn->error)
			return false;
		else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function save_offense()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'description'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if (isset($_POST['description'])) {
			if (!empty($data)) $data .= ",";
			$data .= " `description`='" . addslashes(htmlentities($description)) . "' ";
		}
		$check = $this->conn->query("SELECT * FROM `offenses` where `code` = '{$code}' " . (!empty($id) ? " and id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Offense code already exist.";
			return json_encode($resp);
			exit;
		}
		if (empty($id)) {
			$sql = "INSERT INTO `offenses` set {$data} ";
			$save = $this->conn->query($sql);
		} else {
			$sql = "UPDATE `offenses` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if ($save) {
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "New Offense successfully saved.");
			else
				$this->settings->set_flashdata('success', "Offense successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_offense()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `offenses` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "offense successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}


	function save_driver()
	{
		foreach ($_POST as $k => $v) {
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);
		$name = ucwords($lastname . ', ' . $firstname . ' ' . $middlename);
		$chk = $this->conn->query("SELECT * FROM `drivers_list` where  license_id_no = '{$license_id_no}' " . ($id > 0 ? " and id!= '{$id}' " : ""))->num_rows;
		$this->capture_err();
		if ($chk > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Licesnse ID already exist in the database. Please review and try again.";
			return json_encode($resp);
			exit;
		}
		if (empty($id))
			$sql1 = "INSERT INTO `drivers_list` set `name` = '{$name}', license_id_no = '{$license_id_no}' ";
		else
			$sql1 = "UPDATE `drivers_list` set `name` = '{$name}', license_id_no = '{$license_id_no}' where id = '{$id}' ";

		$save1 = $this->conn->query($sql1);
		$this->capture_err();
		$driver_id = empty($id) ? $this->conn->insert_id : $id;
		$this->conn->query("DELETE FROM `drivers_meta` where driver_id = '{$driver_id}' ");
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!empty($data)) $data .= ",";
				$v = addslashes($v);
				$data .= " ('{$driver_id}','{$k}','{$v}') ";
			}
		}
		$data .= ",('{$driver_id}','driver_id','{$driver_id}')";


		$sql = "INSERT INTO `drivers_meta` (`driver_id`,`meta_field`,`meta_value`) VALUES {$data} ";
		$save = $this->conn->query($sql);
		$this->capture_err();
		if ($save) {
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "New Driver successfully saved.");
			else
				$this->settings->set_flashdata('success', "Driver Details successfully updated.");
			$id = empty($id) ? $this->conn->insert_id : $id;
			$dir = 'uploads/drivers/';
			if (!is_dir(base_app . $dir))
				mkdir(base_app . $dir);
			if (isset($_FILES['img'])) {
				if (!empty($_FILES['img']['tmp_name'])) {
					$fname = $dir . $driver_id . "." . (pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
					$move =  move_uploaded_file($_FILES['img']['tmp_name'], base_app . $fname);
					if ($move) {
						$this->conn->query("INSERT INTO `drivers_meta` set `meta_value` = '{$fname}', driver_id = '{$driver_id}',`meta_field` = 'image_path' ");
						if (!empty($image_path) && is_file(base_app . $image_path))
							unlink(base_app . $image_path);
					}
				}
			}
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}

	function save_driver_modal()
	{
		foreach ($_POST as $k => $v) {
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);
		$name = ucwords($lastname . ', ' . $firstname . ' ' . $middlename);
		$chk = $this->conn->query("SELECT * FROM `drivers_list` where  license_id_no = '{$license_id_no}' " . ($id > 0 ? " and id!= '{$id}' " : ""))->num_rows;
		$this->capture_err();
		if ($chk > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Licesnse ID already exist in the database. Please review and try again.";
			return json_encode($resp);
			exit;
		}
		if (empty($id))
			$sql1 = "INSERT INTO `drivers_list` set `name` = '{$name}', license_id_no = '{$license_id_no}' ";
		else
			$sql1 = "UPDATE `drivers_list` set `name` = '{$name}', license_id_no = '{$license_id_no}' where id = '{$id}' ";

		$save1 = $this->conn->query($sql1);
		$this->capture_err();
		$driver_id = empty($id) ? $this->conn->insert_id : $id;
		$this->conn->query("DELETE FROM `drivers_meta` where driver_id = '{$driver_id}' ");
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!empty($data)) $data .= ",";
				$v = addslashes($v);
				$data .= " ('{$driver_id}','{$k}','{$v}') ";
			}
		}
		$data .= ",('{$driver_id}','driver_id','{$driver_id}')";


		$sql = "INSERT INTO `drivers_meta` (`driver_id`,`meta_field`,`meta_value`) VALUES {$data} ";
		$save = $this->conn->query($sql);
		$this->capture_err();
		if ($save) {
			$resp['status'] = 'success';
			$resp['driver_id'] =  $driver_id;

			if (empty($id))
				$this->settings->set_flashdata('success', "New Driver successfully saved.");
			else
				$this->settings->set_flashdata('success', "Driver Details successfully updated.");
			$id = empty($id) ? $this->conn->insert_id : $id;
			$dir = 'uploads/drivers/';
			if (!is_dir(base_app . $dir))
				mkdir(base_app . $dir);
			if (isset($_FILES['img'])) {
				if (!empty($_FILES['img']['tmp_name'])) {
					$fname = $dir . $driver_id . "." . (pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
					$move =  move_uploaded_file($_FILES['img']['tmp_name'], base_app . $fname);
					if ($move) {
						$this->conn->query("INSERT INTO `drivers_meta` set `meta_value` = '{$fname}', driver_id = '{$driver_id}',`meta_field` = 'image_path' ");
						if (!empty($image_path) && is_file(base_app . $image_path))
							unlink(base_app . $image_path);
					}
				}
			}
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}

	function delete_driver()
	{
		extract($_POST);
		$qry = $this->conn->query("SELECT * FROM `drivers_meta` where driver_id = '{$id}'");
		while ($row = $qry->fetch_assoc()) {
			${$row['meta_field']} = $row['meta_value'];
		}
		$del = $this->conn->query("DELETE FROM `drivers_list` where id = '{$id}'");
		$this->capture_err();
		if ($del) {
			$resp['status'] = 'success';
			if (is_file(base_app . $image_path))
				unlink((base_app . $image_path));
			$this->settings->set_flashdata('success', "Driver's Info successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function delete_img()
	{
		extract($_POST);
		if (is_file(base_app . $path)) {
			if (unlink(base_app . $path)) {
				$del = $this->conn->query("DELETE FROM `uploads` where file_path = '{$path}'");
				$resp['status'] = 'success';
			} else {
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete ' . $path;
			}
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown ' . $path . ' path';
		}
		return json_encode($resp);
	}

	function display_vehicle_owner()
	{
		extract($_POST);
		if ($query) {
			$inpText = $query;
			$sql = $this->conn->query("SELECT p.impound_no AS owner_number,m.*,f.plate_no FROM parking_number p  LEFT JOIN impound_vehicle_list m on p.impound_no = m.impound_no LEFT JOIN offense_list f on  p.impound_no=f.ticket_no WHERE f.plate_no LIKE '%$inpText%' OR m.vehicle_owner LIKE '%$inpText%'");

			if ($sql->num_rows > 0) {
				while ($row = $sql->fetch_assoc()) {
					echo '<a href="#" id="name" class="list-group-item list-group-item-action border-1">' . $row['vehicle_owner'] . ' [' . $row['plate_no'] . ']' . '</a>';
				}
			} else {
				echo '<p class="list-group-item border-1">No Record</p>';
			}
		}
	}
	function display_parking_location()
	{
		extract($_POST);

		if (!strpos($query, '[')) {
			$resp['status'] = 'failed';
			$resp['message'] = 'No record';
			return json_encode($resp);
		}

		$plate_no_part = explode('[', $query, 2);
		$plate_no = trim($plate_no_part[1], '[]');
		$sql = $this->conn->query("SELECT i.* ,o.plate_no,o.ticket_no FROM impound_vehicle_list i LEFT JOIN offense_list o on i.impound_no=o.ticket_no WHERE o.plate_no='{$plate_no}'");


		if ($sql->num_rows > 0 || strpos($query, '[]')) {
			while ($row = $sql->fetch_assoc()) {
				$resp['try'] = $plate_no;
				$resp['status'] = 'success';
				$resp['parking'] = $row['parking_location'];
			}
		} else {
			$resp['status'] = 'failed';
			$resp['message'] = 'No record';
		}

		return json_encode($resp);
	}

	function unarchive_driver()
	{
		extract($_POST);
		$qry = $this->conn->query("UPDATE `drivers_list` SET `status`='1' WHERE id = '{$id}'");
		if ($qry) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Driver data successfully unarchive.");
		}

		return json_encode($resp);
	}

	function save_enforcer()
	{
		foreach ($_POST as $k => $v) {
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);
		$name = ucwords($lastname . ', ' . $firstname . ' ' . $middlename);
		$chk = $this->conn->query("SELECT * FROM `enforcers_list` where  employee_id_no = '{$employee_id_no}' " . ($id > 0 ? " and id!= '{$id}' " : ""))->num_rows;
		$this->capture_err();
		if ($chk > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Employee ID already exist in the database. Please review and try again.";
			return json_encode($resp);
			exit;
		}
		if (empty($id))
			$sql1 = "INSERT INTO `enforcers_list` set `name` = '{$name}', employee_id_no = '{$employee_id_no}' ";
		else
			$sql1 = "UPDATE `enforcers_list` set `name` = '{$name}', employee_id_no = '{$employee_id_no}' where id = '{$id}' ";

		$save1 = $this->conn->query($sql1);
		$this->capture_err();
		$enforcers_id = empty($id) ? $this->conn->insert_id : $id;
		$this->conn->query("DELETE FROM `enforcers_meta` where enforcers_id = '{$enforcers_id}' ");
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!empty($data)) $data .= ",";
				$v = addslashes($v);
				$data .= " ('{$enforcers_id}','{$k}','{$v}') ";
			}
		}
		$data .= ",('{$enforcers_id}','enforcers_id','{$enforcers_id}')";


		$sql = "INSERT INTO `enforcers_meta` (`enforcers_id`,`meta_field`,`meta_value`) VALUES {$data} ";
		$save = $this->conn->query($sql);
		$this->capture_err();
		if ($save) {
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "New Enforcer successfully saved.");
			else
				$this->settings->set_flashdata('success', "Enforcer Details successfully updated.");
			$id = empty($id) ? $this->conn->insert_id : $id;
			$dir = 'uploads/drivers/';
			if (!is_dir(base_app . $dir))
				mkdir(base_app . $dir);
			if (isset($_FILES['img'])) {
				if (!empty($_FILES['img']['tmp_name'])) {
					$fname = $dir . $enforcers_id . "." . (pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
					$move =  move_uploaded_file($_FILES['img']['tmp_name'], base_app . $fname);
					if ($move) {
						$this->conn->query("INSERT INTO `enforcers_meta` set `meta_value` = '{$fname}', enforcers_id = '{$enforcers_id}',`meta_field` = 'image_path' ");
						if (!empty($image_path) && is_file(base_app . $image_path))
							unlink(base_app . $image_path);
					}
				}
			}
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function archive_enforcer()
	{
		extract($_POST);
		$qry = $this->conn->query("UPDATE `enforcers_list` SET `status`='4' WHERE id = '{$id}'");
		if ($qry) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Enforcer data successfully archive.");
		}

		return json_encode($resp);
	}
	function unarchive_enforcer()
	{
		extract($_POST);
		$qry = $this->conn->query("UPDATE `enforcers_list` SET `status`='1' WHERE id = '{$id}'");
		if ($qry) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Enforcer data successfully unarchive.");
		}

		return json_encode($resp);
	}
	function save_offense_record()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'fine', 'offense_id', 'enforcers_id', 'offense_name'))) {
				$v = addslashes($v);
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}


		$chk = $this->conn->query("SELECT * FROM `offense_list` WHERE `ticket_no` = '{$ticket_no}' " . (($id > 0) ? "AND `id` != '{$id}' " : "") . "AND `status`!= '4'")->num_rows;
		$this->capture_err();
		if ($chk > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Offense Ticket No. already exist in the database. Please review and try again.";
			return json_encode($resp);
			exit;
		}
		if (isset($_POST['enforcers_id']) && $_POST['enforcers_id'] != '') {
			$selectedEnforcer = $_POST['enforcers_id'];
			$enforcerParts = explode(']', $selectedEnforcer, 2);
			if (count($enforcerParts) === 2) {
				$employeeId = trim($enforcerParts[0], '[]');
				$enforcerName = trim($enforcerParts[1]);

				// Remove square brackets from employeeId if present
				$employeeId = str_replace(['[', ']'], '', $employeeId);

				// Escape any commas in the enforcerName
				$enforcerName = str_replace(',', '\,', $enforcerName);

				// Append officer_name and officer_id as separate key-value pairs
				$data .= ", `officer_name` = '{$enforcerName}', `officer_id` = '{$employeeId}' ";
				$this->conn->query("INSERT INTO `enforcers_tally` set officer_name = '{$enforcerName}' ");
			}
		}



		if (empty($id)) {
			$sql = "INSERT INTO `offense_list` set {$data} ";
		} else {
			$sql = "UPDATE `offense_list` set {$data} where id = '{$id}' ";
		}
		$save = $this->conn->query($sql);
		$this->capture_err();
		$driver_offense_id = empty($id) ? $this->conn->insert_id : $id;
		$this->conn->query("DELETE FROM `offense_items` where `driver_offense_id` = '{$driver_offense_id}'");
		$this->capture_err();
		$data = "";
		foreach ($offense_id as $k => $v) {
			if (!empty($data)) $data .= ", ";
			$data .= "('{$driver_offense_id}','{$v}','{$fine[$k]}','{$status}','{$date_created}')";
		}
		$save2 = $this->conn->query("INSERT INTO `offense_items` (`driver_offense_id`,`offense_id`,`fine`,`status`,`date_created`) VALUES {$data}");
		$this->capture_err();
		$data = "";
		if (isset($offense_name)) {
			// If $offense_name is an array (multiple entries)
			if (is_array($offense_name)) {
				foreach ($offense_name as $name) {
					$escapedName = $this->conn->real_escape_string($name);
					$save3 = $this->conn->query("INSERT INTO `offense_tally` (`name`) VALUES ('$escapedName')");
				}
			} else {
				// If $offense_name is a single entry
				$escapedName = $this->conn->real_escape_string($offense_name);
				$save3 = $this->conn->query("INSERT INTO `offense_tally` (`name`) VALUES ('$escapedName')");
			}
		}
		if ($save && $save2) {
			if (empty($id))
				$this->settings->set_flashdata('success', " New Offense Record successfully saved.");
			else
				$this->settings->set_flashdata('success', " Offense Record successfully updated.");
			$resp['status'] = 'success';
			$resp['id'] = $driver_offense_id;
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_offense_record()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `offense_list` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Offense Record successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function unarchive_offense()
	{
		extract($_POST);
		$qry = $this->conn->query("UPDATE `offense_list` SET `status`='2' WHERE id = '{$id}'");
		if ($qry) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Offense data successfully unarchive.");
		}

		return json_encode($resp);
	}

	function save_impound_vehicle()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'fine', 'offense_id', 'enforcers_id', 'offense_name', 'vehicle_type', 'ownership', 'parking_location'))) {
				$v = addslashes($v);
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}

		$qrys = $this->conn->query("SELECT `name` from `drivers_list` where id = '{$driver_id}' ");
		if ($qrys->num_rows > 0) {
			foreach ($qrys->fetch_assoc() as $k => $v) {
				$$k = $v;
			}
		}
		$qryss = $this->conn->query("SELECT `ticket_no` from `offense_list` where id = '{$id}' ");
		if ($qryss->num_rows > 0) {
			foreach ($qryss->fetch_assoc() as $k => $v) {
				${"impound_vehicle_" . $k} = $v;
			}
		}

		$chk = $this->conn->query("SELECT * FROM `offense_list` where  ticket_no = '{$ticket_no}' " . (($id > 0) ? " and id!= '{$id}' " : "") . "AND `status`!= '4'")->num_rows;
		$this->capture_err();
		if ($chk > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Offense Ticket No. already exist in the database. Please review and try again.";
			return json_encode($resp);
			exit;
		}

		$chk2 = $this->conn->query("SELECT * FROM `offense_list` where  plate_no = '{$plate_no}' " . (($id > 0) ? " and id!= '{$id}' " : "") . "AND `status`!= '4'")->num_rows;
		$this->capture_err();
		if ($chk2 > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Plate No. already exist in the database. Please review and try again.";
			return json_encode($resp);
			exit;
		}


		if (isset($_POST['enforcers_id']) && $_POST['enforcers_id'] != '') {
			$selectedEnforcer = $_POST['enforcers_id'];
			$enforcerParts = explode(']', $selectedEnforcer, 2);
			if (count($enforcerParts) === 2) {
				$employeeId = trim($enforcerParts[0], '[]');
				$enforcerName = trim($enforcerParts[1]);

				// Remove square brackets from employeeId if present
				$employeeId = str_replace(['[', ']'], '', $employeeId);

				// Escape any commas in the enforcerName
				$enforcerName = str_replace(',', '\,', $enforcerName);

				// Append officer_name and officer_id as separate key-value pairs
				$data .= ", `officer_name` = '{$enforcerName}', `officer_id` = '{$employeeId}' ";
				$this->conn->query("INSERT INTO `enforcers_tally` set officer_name = '{$enforcerName}' ");
			}
		}
		$this->conn->query("INSERT INTO `location_tally` set `location` = '{$location_of_incident}' ");
		$day = $date_created;
		$time = date('H:i:s', strtotime($day));
		$time =  explode(':', $time);
		$time =  $time[0];
		$day = date('l', strtotime($day));

		if ($time == 0) {
			$time = 24;
		}

		$this->conn->query("INSERT INTO `day_tally` (`day`,`time`) VALUES  ('$day','$time')");

		/* if (isset($_FILES['img']) && $_FILES['img']['tmp_name'] != '') {
			$fname = 'uploads/' . strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], '../' . $fname);
			if ($move) {
				$this->conn->query("INSERT INTO `impound_vehicle_list` (`impound_no`,`vehicle_owner`,`vehicle_type`, `ownership`, `parking_location`,`photo_of_entry`) VALUES ('$ticket_no','$name','$vehicle_type','$ownership','$parking_location','$fname')");
			
				if (isset($_SESSION['userdata']['avatar']) && is_file('../' . $_SESSION['userdata']['avatar']) && $_SESSION['userdata']['id'] == $id)
					unlink('../' . $_SESSION['userdata']['avatar']);
			}
		} */

		if (empty($id)) {
			$this->conn->query("UPDATE `parking_number` SET `impound_no` = '{$ticket_no}' WHERE `parking_location` = '{$parking_location}'");
			$this->conn->query("UPDATE `parking_number` SET `availability` = 2 WHERE `parking_location` = '{$parking_location}'");
			$this->conn->query("INSERT INTO `impound_vehicle_list` (`impound_no`,`vehicle_owner`,`vehicle_type`, `ownership`, `parking_location`) VALUES ('$ticket_no','$name','$vehicle_type','$ownership','$parking_location')");
			$sql = "INSERT INTO `offense_list` set {$data} ";
		} else {
			$qrysse = $this->conn->query("SELECT * FROM `impound_vehicle_list` WHERE `impound_no` = '$impound_vehicle_ticket_no'");
			if ($qrysse->num_rows > 0) {
				$row = $qrysse->fetch_assoc();
				foreach ($row as $k => $v) {
					${"parking_" . $k} = trim($v);
				}
			}
			if ($parking_parking_location === trim($parking_location)) {

				$this->conn->query("UPDATE impound_vehicle_list SET `impound_no` ='$ticket_no',`vehicle_owner` = '$name', `vehicle_type` = '$vehicle_type', `ownership` = '$ownership', `parking_location` = '$parking_location' WHERE `impound_no` = '$impound_vehicle_ticket_no'");
				$this->conn->query("UPDATE parking_number SET `impound_no` ='$ticket_no' WHERE `impound_no` = '$impound_vehicle_ticket_no'");
			} else {
				$this->conn->query("UPDATE `parking_number` SET `impound_no` = '' WHERE `parking_location` = '{$parking_parking_location}'");
				$this->conn->query("UPDATE `parking_number` SET `impound_no` = '{$ticket_no}' WHERE `parking_location` = '{$parking_location}'");
				$this->conn->query("UPDATE impound_vehicle_list SET `impound_no` ='$ticket_no',`vehicle_owner` = '$name', `vehicle_type` = '$vehicle_type', `ownership` = '$ownership', `parking_location` = '$parking_location' WHERE `impound_no` = '$impound_vehicle_ticket_no'");
				$this->conn->query("UPDATE parking_number SET `impound_no` ='$ticket_no' WHERE `impound_no` = '$impound_vehicle_ticket_no'");
			}
			$sql = "UPDATE `offense_list` set {$data} where id = '{$id}' ";
		}
		$save = $this->conn->query($sql);
		$this->capture_err();
		$driver_offense_id = empty($id) ? $this->conn->insert_id : $id;
		$this->conn->query("DELETE FROM `offense_items` where `driver_offense_id` = '{$driver_offense_id}'");
		$this->capture_err();
		$data = "";
		foreach ($offense_id as $k => $v) {

			if (!empty($data)) $data .= ", ";
			$data .= "('{$driver_offense_id}','{$v}','{$fine[$k]}','{$status}','{$date_created}')";
		}
		$save2 = $this->conn->query("INSERT INTO `offense_items` (`driver_offense_id`,`offense_id`,`fine`,`status`,`date_created`) VALUES {$data}");
		$this->capture_err();
		$data = "";

		if (isset($offense_name)) {
			// If $offense_name is an array (multiple entries)
			if (is_array($offense_name)) {
				foreach ($offense_name as $name) {
					$escapedName = $this->conn->real_escape_string($name);
					$save3 = $this->conn->query("INSERT INTO `offense_tally` (`name`) VALUES ('$escapedName')");
				}
			} else {
				// If $offense_name is a single entry
				$escapedName = $this->conn->real_escape_string($offense_name);
				$save3 = $this->conn->query("INSERT INTO `offense_tally` (`name`) VALUES ('$escapedName')");
			}
		}
		if ($save && $save2) {
			if (empty($id))
				$this->settings->set_flashdata('success', " New Offense Record successfully saved.");
			else
				$this->settings->set_flashdata('success', " Offense Record successfully updated.");
			$resp['status'] = 'success';
			$resp['id'] = $driver_offense_id;
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}

	function archive_impound()
	{
		extract($_POST);

		$qry = $this->conn->query("UPDATE `offense_list` SET `status`='1' WHERE id = '{$id}'");
		$qry2 = $this->conn->query("SELECT `ticket_no` FROM  `offense_list` WHERE id = '{$id}'")->fetch_assoc();
		$impound_no = $qry2['ticket_no'];
		$this->conn->query("UPDATE `parking_number` SET `impound_no`='' WHERE impound_no = '{$impound_no}'");
		if ($qry && $qry2) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "The vehicle has been successfully released.");
		}

		return json_encode($resp);
	}

	function insert_chat()
	{

		extract($_POST);

		$qry = "INSERT INTO chat_message (sender_id,receiver_id,msg) VALUES (?,?,?)";
		$statement = $this->conn->prepare($qry);
		$statement->bind_param('iis', $senderId, $receiverId, $msg);
		$statement->execute();

		$resp = array(); // Initialize $resp array

		if ($statement) {
			$resp['senderId'] = $senderId; // Corrected variable name
			$resp['receiverId'] = $receiverId;
			$resp['msg'] = $msg;
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'error';
			$resp['message'] = 'Failed to insert chat.';
		}

		return json_encode($resp);

		/* function str_openssl_enc($str, $iv)
		{
			$key = '1234567890vishal%$%^%$$#$#';
			$chiper = "AES-128-CTR";
			$options = 0;
			$str = openssl_encrypt($str, $chiper, $key, $options, $iv);
			return $str;
		}
		extract($_POST);
		$message = $_POST['message'];
		$outgoing_id = $_POST['unique_id'];
		$incoming_id = $_POST['incoming_id'];
		$iv = openssl_random_pseudo_bytes(16);

		$message = str_openssl_enc($message, $iv);
		$iv = bin2hex($iv);

		if (!empty($outgoing_id)) {
			$qry = $this->conn->query("INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg,iv)
			VALUES ({$incoming_id}, {$outgoing_id}, '{$message}','{$iv}')");
			if ($qry) {

				return 1;
			}
		} */
	}
	function release_photo()
	{
		extract($_POST);
		if (isset($_FILES['img']) && $_FILES['img']['tmp_name'] != '') {
			$fname = 'uploads/' . strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], '../' . $fname);
			if ($move) {
				/* $this->conn->query("UPDATE INTO `impound_vehicle_list` (`impound_no`,`vehicle_owner`,`vehicle_type`, `ownership`, `parking_location`,`photo_of_entry`) VALUES ('$ticket_no','$name','$vehicle_type','$ownership','$parking_location','$fname')"); */
				$query = "UPDATE `impound_vehicle_list` SET `photo_of_release` = '{$fname}' WHERE id = '{$id}'";

				$this->conn->query($query);
				if (isset($_SESSION['userdata']['avatar']) && is_file('../' . $_SESSION['userdata']['avatar']) && $_SESSION['userdata']['id'] == $id)
					unlink('../' . $_SESSION['userdata']['avatar']);
			}
		}
	}
	function insert_driver_chat()
	{

		function str_openssl_encr($str, $iv)
		{
			$key = '1234567890vishal%$%^%$$#$#';
			$chiper = "AES-128-CTR";
			$options = 0;
			$str = openssl_encrypt($str, $chiper, $key, $options, $iv);
			return $str;
		}
		extract($_POST);
		$message = $_POST['message'];
		$outgoing_id = 843919718;
		$incoming_id = $this->settings->userdata('unique_id');
		$iv = openssl_random_pseudo_bytes(16);

		$message = str_openssl_encr($message, $iv);
		$iv = bin2hex($iv);

		if (!empty($outgoing_id)) {
			$qry = $this->conn->query("INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg,iv)
			VALUES ({$incoming_id}, {$outgoing_id}, '{$message}','{$iv}')");
			if ($qry) {

				return 1;
			}
		}
	}

	function get_chat_ctmo()
	{

		extract($_POST);

		$sql = "SELECT chat_message.*, users.* 
        FROM chat_message 
        LEFT JOIN users ON users.unique_id = chat_message.receiver_id
        WHERE 
            (receiver_id= {$receiver_id} AND sender_id = {$sender_id})
            OR 
            (receiver_id = {$sender_id} AND sender_id = {$receiver_id}) 
			OR 
            (
                (receiver_id = {$sender_id} AND sender_id = 1) 
                OR 
                (sender_id = 1 AND receiver_id = {$sender_id})
				OR 
                (receiver_id = {$receiver_id} AND sender_id = 1) 
                OR 
                (sender_id = 1 AND receiver_id = {$receiver_id})
            )
           
        ORDER BY msg_id";

		$qry = $this->conn->query($sql);
		$resp = array();

		if ($qry->num_rows > 0) {
			while ($result = $qry->fetch_assoc()) {
				/* $status = ($result['incoming_msg_id'] === $incoming_id) ? 1 : (($result['outgoing_msg_id'] === $incoming_id) ? 3 : (($result['incoming_msg_id'] === 1 || $result['outgoing_msg_id'] === 1) ? 4 : 2)); */

			
					$status = ($result['sender_id'] === $sender_id) ? 1 : (($result['sender_id'] === $receiver_id) ? 2 : 3);

				$resp[] = array(
					'msg' => $result['msg'],
					'status' => $status
				);
			}
			return json_encode($resp);
		}
	}

	public function save_response()
	{
		extract($_POST);
		if (!empty($id)) {
			$del = $this->conn->query("DELETE FROM `questions` where id= '$id' ");
			if (!$del) {
				return 2;
				exit;
			}
		}
		$data = "";
		$ins_resp = $this->conn->query("INSERT INTO `responses` set response_message = '{$response_message}' ");
		if (!$ins_resp) {
			return 2;
			exit;
		}
		$resp_id = $this->conn->insert_id;

		foreach ($question as $k => $v) {
			$data = " response_id = {$resp_id} ";
			$data .= ", `question` = '$question[$k]' ";
			$ins[] = $this->conn->query("INSERT INTO `questions` set $data ");
		}
		if (isset($ins) && count($ins) == count($question)) {
			$this->settings->set_flashdata("success", " Data successfully saved");
			return 1;
		} else {
			return 2;
			exit;
		}
	}
	public function delete_response()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `questions` where id = $id");
		if ($del) {
			$this->settings->set_flashdata("success", " Data successfully deleted");
			return 1;
		} else {
			$this->conn->error;
		}
	}

	function get_response()
	{

		extract($_POST);
		$ctmo_id = 843919718;
		$client_id = $this->settings->userdata('unique_id');


		/* $message = str_replace(array("?"), '', $message);
		$not_question = array("what", "what is", "who", "who is", "where");
 */
		/* if (in_array(strtolower($message), $not_question)) {
			$resp['status'] = "success";
			$resp['message'] = "";
			return json_encode($resp);
		} */

		$sql = "SELECT r.response_message,q.id FROM `questions` q INNER JOIN `responses` r ON q.response_id = r.id WHERE q.question LIKE '%{$message}%' ";
		$qry = $this->conn->query($sql);

		if ($qry && $qry->num_rows > 0) {
			$result = $qry->fetch_array();
			$resp['status'] = "success";
			$resp['message'] = $result['response_message'];


			if (!empty($ctmo_id)) {
				$qry = $this->conn->query("INSERT INTO chat_message (sender_id, receiver_id, msg)
                VALUES ('{$client_id}', '1', '{$message}')");
			}
			$botMessage = $result['response_message'];
			$resp['sql'] = $sql;
			$this->conn->query("INSERT INTO `frequent_asks` SET question_id = '{$result['id']}' ");
			if (!empty($ctmo_id)) {
				$qry = $this->conn->query("INSERT INTO chat_message (sender_id, receiver_id, msg)
                VALUES ('1', '{$client_id}', '{$botMessage}')");
			}
			return json_encode($resp);
		} else {
			$resp['status'] = "fail";
			$chk = $this->conn->query("SELECT * FROM `unanswered` WHERE `question` = '{$message}' ");

			if ($chk && $chk->num_rows > 0) {
				$this->conn->query("UPDATE `unanswered` SET no_asks = no_asks + 1 WHERE `question` = '{$message}'");
			} else {
				$this->conn->query("INSERT INTO `unanswered` SET question = '{$message}' ");
			}

			if (!empty($ctmo_id)) {
				$qry = $this->conn->query("INSERT INTO chat_message (sender_id, receiver_id, msg)
                VALUES ('{$client_id}', '1', '{$message}')");
			}

			if (!empty($ctmo_id)) {
				$qry = $this->conn->query("INSERT INTO chat_message (sender_id, receiver_id, msg)
                VALUES ('1', '{$client_id}', 'I will connect you to one of our Staff')");
			}
			$this->conn->query("UPDATE bot_status SET checker = 2 WHERE unique_id = '{$client_id}'");
			return json_encode($resp);
		}
	}

	public function delete_unanswer()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `unanswered` where id = $id");
		if ($del) {
			$this->settings->set_flashdata("success", " Data successfully deleted");
			return 1;
		} else {
			$this->conn->error;
		}
	}
	public function connect_staff()
	{
		

		$client_id = $this->settings->userdata('unique_id');
		
			$resp['status'] = "success";

			if (!empty($client_id)) {
				$qry = $this->conn->query("INSERT INTO chat_message (sender_id, receiver_id, msg)
                VALUES ('1', '{$client_id}', 'I will connect you to one of our staff')");
			}
			$this->conn->query("UPDATE bot_status SET checker = 2 WHERE unique_id = '{$client_id}'");
			return json_encode($resp);
		
	}
	public function archive_data($previoustable, $archive_table, $id, $message)
	{
		// Start transaction
		$this->conn->begin_transaction();

		try {
			// Disable foreign key checks temporarily
			$this->conn->query("SET foreign_key_checks = 0");

			// Move data from previous table to archive table
			$qry = $this->conn->query("INSERT INTO `$archive_table` SELECT * FROM `$previoustable` WHERE id = '{$id}'");

			// Delete data from previous table
			$del = $this->conn->query("DELETE FROM `$previoustable` WHERE id = $id");

			
			// Re-enable foreign key checks
			$this->conn->query("SET foreign_key_checks = 1");

			// Commit transaction
			$this->conn->commit();

			if ($qry && $del) {
				$resp['status'] = 'success';
				$this->settings->set_flashdata('success', $message);
			} else {
				$resp['status'] = 'error';
			}
		} catch (Exception $e) {
			// Rollback transaction if an error occurs
			$this->conn->rollback();
			$resp['status'] = 'error';
		}

		// Return response as JSON
		return json_encode($resp);
	}
	public function archive_impound_data($previoustable, $archive_table, $id, $message)
	{
		// Start transaction
		$this->conn->begin_transaction();

		try {
			// Disable foreign key checks temporarily
			$this->conn->query("SET foreign_key_checks = 0");

			// Move data from previous table to archive table
			$qry = $this->conn->query("INSERT INTO `$archive_table` SELECT * FROM `$previoustable` WHERE id = '{$id}'");

			// Delete data from previous table
			$del = $this->conn->query("DELETE FROM `$previoustable` WHERE id = $id");

			// Re-enable foreign key checks
			$this->conn->query("SET foreign_key_checks = 1");

			// Commit transaction
			$this->conn->commit();

			if ($qry && $del) {
				$resp['status'] = 'success';
				$this->settings->set_flashdata('success', $message);
			} else {
				$resp['status'] = 'error';
			}
		} catch (Exception $e) {
			// Rollback transaction if an error occurs
			$this->conn->rollback();
			$resp['status'] = 'error';
		}

		// Return response as JSON
		return json_encode($resp);
	}

	public function unarchive_data($previoustable, $offical_table, $id, $message)
	{
		// Start transaction
		$this->conn->begin_transaction();

		try {
			// Disable foreign key checks temporarily
			$this->conn->query("SET foreign_key_checks = 0");

			// Move data from previous table to archive table
			$qry = $this->conn->query("INSERT INTO `$offical_table` SELECT * FROM `$previoustable` WHERE id = '{$id}'");

			// Delete data from previous table
			$del = $this->conn->query("DELETE FROM `$previoustable` WHERE id = $id");


			// Re-enable foreign key checks
			$this->conn->query("SET foreign_key_checks = 1");

			// Commit transaction
			$this->conn->commit();

			if ($qry && $del) {
				$resp['status'] = 'success';
				$this->settings->set_flashdata('success', $message);
			} else {
				$resp['status'] = 'error';
			}
		} catch (Exception $e) {
			// Rollback transaction if an error occurs
			$this->conn->rollback();
			$resp['status'] = 'error';
		}

		// Return response as JSON
		return json_encode($resp);
	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_offense':
		echo $Master->save_offense();
		break;
	case 'delete_offense':
		echo $Master->delete_offense();
		break;
	case 'archive_offense':
		echo
		$Master->archive_data('offense_list', 'ticket_archive', $_POST['id'], "Offense data successfully archived.");
		break;
	case 'archive_driver':
		echo
		$Master->archive_data('drivers_list', 'drivers_list_archive', $_POST['id'], "Driver data successfully archived.");
		break;
	case 'archive_enforcer':
		echo
		$Master->archive_data('enforcers_list', 'enforcers_list_archieve', $_POST['id'], "Enforcer data successfully archived.");
		break;
	case 'archive_impound_data':
		echo
		$Master->archive_impound_data('offense_list', 'impound_vehicle_archive', $_POST['id'], "Impound Vehicle data successfully archived.");
		break;
	case 'unarchive_driver':
		echo
		$Master->unarchive_data('drivers_list_archive', 'drivers_list', $_POST['id'], "Driver data successfully unarchived.");
		break;
	case 'unarchive_offense':
		echo
		$Master->unarchive_data('ticket_archive', 'offense_list', $_POST['id'], "Driver data successfully unarchived.");
		break;
	case 'unarchive_enforcer':
		echo
		$Master->unarchive_data('enforcers_list_archieve', 'enforcers_list', $_POST['id'], "Driver data successfully unarchived.");
		break;
	case 'display_vehicle_owner':
		echo $Master->display_vehicle_owner();
		break;
	case 'display_parking_location':
		echo $Master->display_parking_location();
		break;
	case 'save_driver':
		echo $Master->save_driver();
		break;
	case 'save_driver_modal':
		echo $Master->save_driver_modal();
		break;
	case 'delete_driver':
		echo $Master->delete_driver();
		break;

	case 'unarchive_driver':
		echo $Master->unarchive_driver();
		break;
	case 'connect_staff':
		echo $Master->connect_staff();
		break;
	case 'save_enforcer':
		echo $Master->save_enforcer();
		break;
	case 'archive_enforcer':
		echo $Master->archive_enforcer();
		break;
	case 'unarchive_enforcer':
		echo $Master->unarchive_enforcer();
		break;
	case 'release_photo':
		echo $Master->release_photo();
		break;
	case 'save_offense_record':
		echo $Master->save_offense_record();
		break;

	case 'unarchive_offense':
		echo $Master->unarchive_offense();
		break;
	case 'delete_offense_record':
		echo $Master->delete_offense_record();
		break;
	case 'delete_img':
		echo $Master->delete_img();
		break;
	case 'insert_chat':
		echo $Master->insert_chat();
		break;
	case 'insert_driver_chat':
		echo $Master->insert_driver_chat();
		break;
	case 'get_chat_ctmo':
		echo $Master->get_chat_ctmo();
		break;
	case 'save_impound_vehicle':
		echo $Master->save_impound_vehicle();
		break;
	case 'archive_impound':
		echo $Master->archive_impound();
		break;
		/* case 'unarchive_impound':
		echo $Master->unarchive_impound();
		break; */
	case 'save_response':
		echo $Master->save_response();
		break;
	case 'delete_response':
		echo $Master->delete_response();
		break;
	case 'get_response':
		echo $Master->get_response();
		break;
	case 'delete_unanswer':
		echo $Master->delete_unanswer();
		break;
	default:
		// echo $sysset->index();
		break;
}
