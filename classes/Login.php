<?php
require_once '../config.php';

class Login extends DBConnection
{
	private $settings;
	public function __construct()
	{
		global $_settings;
		$this->settings = $_settings;

		parent::__construct();
		ini_set('display_error', 1);
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function index()
	{
		echo "<h1>Access Denied</h1> <a href='" . base_url . "'>Go Back.</a>";
	}
	public function login()
	{
		extract($_POST);
		$status = "Online";
		$qry = $this->conn->query("SELECT * FROM users WHERE username = '$username' AND password = md5('$password') ");

		if ($qry->num_rows > 0) {
			$user_data = $qry->fetch_assoc();
			foreach ($user_data as $k => $v) {
				if (!is_numeric($k) && $k != 'password') {
					$this->settings->set_userdata($k, $v);
				}
			}

			$id = $user_data['id'];

			$sql = "UPDATE users SET status = '{$status}' WHERE id = '{$id}'";
			$this->conn->query($sql); // Update the status to 'online'
			return json_encode(array('status' => 'success', 'type' => $user_data['type']));
		} else {
			return json_encode(array('status' => 'incorrect', 'last_qry' => "SELECT * FROM users WHERE username = '$username' AND password = md5('$password') "));
		}
	}

	public function logout()
	{
		$id = $this->settings->userdata('id'); // Access the user's ID from session data
		if ($this->settings->sess_des()) {
			$status = "Offline";
			$sql = "UPDATE users SET status = '{$status}' WHERE id = '{$id}'";
			$this->conn->query($sql); // Update the status to 'Offline'

			redirect('admin/login.php');
		}
	}
}
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$auth = new Login();
switch ($action) {
	case 'login':
		echo $auth->login();
		break;

	case 'logout':
		echo $auth->logout();
		break;
	default:
		echo $auth->index();
		break;
}
