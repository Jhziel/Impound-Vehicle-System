<?php
require_once('../config.php');
class Users extends DBConnection
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
	public function save_users()
	{

		extract($_POST);
		$ran_id = rand(time(), 100000000);


		$_POST['unique_id'] = $ran_id;

		$checkboxes = [
			'driver_list_check',
			'ticket_violation_check',
			'impound_vehicle_check',
			'reports_check',
			'impound_area_check',
			'driver_archieve_check',
			'enforcer_archieve_check',
			'ticket_violation_archieve_check',
			'impound_vehicle_archieve_check'
		];

		foreach ($checkboxes as $checkbox) {
			$$checkbox = isset($_POST[$checkbox]) ? 1 : 0; // Set 1 if checked, else 0
		}

		// Prepare and execute SQL query using prepared statements to avoid SQL injection
		$stmt = $this->conn->prepare("INSERT INTO `staff_privellages` (`staff_unique_id`, `driver_list_check`, `ticket_violation_check`, `impound_vehicle_check`, `reports_check`, `impound_area_check`, `driver_archieve_check`, `enforcer_archieve_check`, `ticket_violation_archieve_check`, `impound_vehicle_archieve_check`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("siiiiiiiii", $_POST['unique_id'], $driver_list_check, $ticket_violation_check, $impound_vehicle_check, $reports_check, $impound_area_check, $driver_archieve_check, $enforcer_archieve_check, $ticket_violation_archieve_check, $impound_vehicle_archieve_check);
		$stmt->execute();

		// Create string for non-sensitive data to be used in the query
		$data = '';
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'password')) && !in_array($k, $checkboxes)) {
				if (!empty($data)) $data .= " , ";
				$data .= " {$k} = '{$v}' ";
			}
		}

		if (!empty($password)) {
			$password = md5($password);
			if (!empty($data)) $data .= " , ";
			$data .= " `password` = '{$password}' ";
		}

		if (isset($_FILES['img']) && $_FILES['img']['tmp_name'] != '') {
			$fname = 'uploads/' . strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], '../' . $fname);
			if ($move) {
				$data .= " , avatar = '{$fname}' ";
				if (isset($_SESSION['userdata']['avatar']) && is_file('../' . $_SESSION['userdata']['avatar']) && $_SESSION['userdata']['id'] == $id)
					unlink('../' . $_SESSION['userdata']['avatar']);
			}
		}
		if (empty($id)) {
			$qry = $this->conn->query("INSERT INTO users set {$data}");
			if ($qry) {
				$this->settings->set_flashdata('success', 'User Details successfully saved.');
				return 1;
			} else {
				return 2;
			}
		} else {
			$qry = $this->conn->query("UPDATE users set $data where id = {$id}");
			if ($qry) {
				$this->settings->set_flashdata('success', 'User Details successfully updated.');
				/* foreach ($_POST as $k => $v) {
					if ($k != 'id') {
						if (!empty($data)) $data .= " , ";
						$this->settings->set_userdata($k, $v);
					}
				} */
				if (isset($fname) && isset($move))
					$this->settings->set_userdata('avatar', $fname);

				return 1;
			} else {
				return "UPDATE users set $data where id = {$id}";
			}
		}
	}

	public function display_users()
	{
		function validate_images($file)
		{
			if (!empty($file)) {
				return $file; // Return the provided file path if not empty
			} else {
				return 'dist/img/no-image-available.png'; // Return default image path if empty
			}
		}
		$userType = $this->settings->userdata('type');
		$unique_id = $this->settings->userdata('unique_id');
		$resp = array();
		if ($userType == 2) {
			$sql = "SELECT u.*, b.*,CONCAT(u.firstname, ' ', u.lastname) AS name, m.msg_id AS last_message_id -- Include columns from the new table
					FROM `users` u LEFT JOIN chat_message m ON u.unique_id = m.sender_id OR u.unique_id = m.receiver_id
					LEFT JOIN bot_status b ON u.unique_id = b.unique_id  -- Join condition for the new table
					WHERE u.`type` = '3' AND b.`checker` = 2
					AND m.msg_id = (SELECT MAX(msg_id) FROM chat_message WHERE sender_id = u.unique_id OR receiver_id = u.unique_id)
					ORDER BY m.msg_id DESC";
		}


		$qry = $this->conn->query($sql);

		if ($qry->num_rows > 0) {
			while ($result = $qry->fetch_assoc()) {
				$user_id = $result['unique_id'];
				// Fetch the user's unique_id

				$sql2 = "SELECT * FROM chat_message WHERE 
				 (sender_id = '{$user_id}' OR receiver_id = '{$user_id}') 
				 AND (sender_id = '{$unique_id}' OR receiver_id = '{$unique_id}')
				  ORDER BY msg_id DESC LIMIT 1";

				$query2 = $this->conn->query($sql2);


				if ($query2->num_rows > 0) {
					$row2 = $query2->fetch_array();
					
					$message = $row2['msg'];

					if (isset($row2['sender_id'])) {
						($unique_id == $row2['sender_id']) ? $you = "You: " : $you = "";
					} else {
						$you = "";
					}
					$result['last_message'] = $you . $message;
				} else {
					$result['last_message'] = "No message available";
				}

				$resp[] = array(
					'name' => $result['name'],
					'status' => $result['status'],
					'id' => $result['id'],
					'unique_id' => $result['unique_id'],
					'avatar' => validate_images($result['avatar']),
					'last_message' => $result['last_message']
				);
			}
		}

		return json_encode($resp);
	}

	public function  temp_display_users()
	{
		function validate_imagess($file)
		{
			if (!empty($file)) {
				return $file; // Return the provided file path if not empty
			} else {
				return 'dist/img/no-image-available.png'; // Return default image path if empty
			}
		}

		$userType = $this->settings->userdata('type');
		$unique_id = $this->settings->userdata('unique_id');
		$resp = array();
		if ($userType == 2) {
			$sql = "SELECT * FROM users WHERE type='2'";
		}


		$qry = $this->conn->query($sql);

		if ($qry->num_rows > 0) {
			while ($result = $qry->fetch_assoc()) {

				$resp[] = array(
					'name' => $result['name'],
					'status' => $result['status'],
					'id' => $result['id'],
					'unique_id' => $result['unique_id'],
					'avatar' => validate_images($result['avatar']),
					'last_message' => $result['last_message']
				);
			}
		}

		return json_encode($resp);
	}


	public function delete_users()
	{
		extract($_POST);
		$avatar = $this->conn->query("SELECT avatar FROM users where id = '{$id}'")->fetch_array()['avatar'];
		$qry = $this->conn->query("DELETE FROM users where id = $id");
		if ($qry) {
			$this->settings->set_flashdata('success', 'User Details successfully deleted.');
			if (is_file(base_app . $avatar))
				unlink(base_app . $avatar);
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
		}
		return json_encode($resp);
	}
	public function save_driver()
	{
		extract($_POST);
		$ran_id = rand(time(), 100000000);

		$_POST['type'] = 3;
		$_POST['unique_id'] = $ran_id;
		$_POST['status'] = "Offline";
		$data = '';
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'password'))) {
				if (!empty($data)) $data .= " , ";
				$data .= " {$k} = '{$v}' ";
			}
		}
		if (!empty($password)) {
			$password = md5($password);
			if (!empty($data)) $data .= " , ";
			$data .= " `password` = '{$password}' ";
		}

		if (isset($_FILES['img']) && $_FILES['img']['tmp_name'] != '') {
			$fname = 'uploads/' . strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], '../' . $fname);
			if ($move) {
				$data .= " , avatar = '{$fname}' ";
				if (isset($_SESSION['userdata']['avatar']) && is_file('../' . $_SESSION['userdata']['avatar']) && $_SESSION['userdata']['id'] == $id)
					unlink('../' . $_SESSION['userdata']['avatar']);
			}
		}
		$unique_id = $_POST['unique_id'];
		$this->conn->query("INSERT INTO bot_status (`unique_id`) VALUES ('$unique_id')");

		if (empty($id)) {
			$qry = $this->conn->query("INSERT INTO users set {$data}");
			if ($qry) {
				$this->settings->set_flashdata('success', 'Your account successfully created.');
				return 1;
			} else {
				return 2;
			}
		}
	}
}

$users = new users();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
	case 'save':
		echo $users->save_users();
		break;
	case 'save_d':
		echo $users->save_driver();
		break;
	case 'display_user':
		echo $users->display_users();
		break;
	case 'temp_display_users':
		echo $users->temp_display_users();
		break;
	case 'delete':
		echo $users->delete_users();
		break;
	default:
		// echo $sysset->index();
		break;
}
