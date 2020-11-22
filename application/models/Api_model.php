<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}
	
	function login($username, $password) {
		$query = $this->db->get_where('users', array('username' => $username));
		$num_rows = $query->num_rows();
		$row = $query->row();
		if($num_rows > 0) {
			if($row->status != 'ATV') {
				$message = array('message' => 'Account is inactive');
			}
			else if(decrypt($row->password) <> $password) {
				$message = array('message' => 'Invalid Password');
			}
			else {
				$message = array('flag' => 1, 'id' => encrypt($row->user_id));
			}	
		}
		else {
			$message = array('message' => 'Username not found');
		}

		return $message;
	}

	function getUsers($token) {
		$requestor = $token['uniqueId'];

		$query = $this->db->get_where('users');
		$num_rows = $query->num_rows();
		$result = $query->result();
		return $result;
	}

	function createUser($token) {
		$requestor = $token['uniqueId'];

		$username = $this->input->post('u');
		$password = $this->input->post('p');
		$status = $this->input->post('s');

		if(empty($username)) {
			$message = array('message' => 'Username cannot be empty');
		}
		else if(empty($password)) {
			$message = array('message' => 'Password cannot be empty');
		}
		else if(empty($status)) {
			$message = array('message' => 'Status cannot be empty');
		}
		else {

			$get_user = $this->db->get_where('users', array('username' => $username))->num_rows();
			if(!empty($get_user)) {
				$message = array('message' => 'User already exists');
				return $message;
			}
			$this->db->trans_start();
			$this->db->insert('users', array('username' => $username, 'password' => encrypt($password), 'status' => $status));
			$this->db->trans_complete();
			if($this->db->trans_status() === false) {
				$this->db->trans_rollback();
				$message = array('message' => $this->db->error());
			}
			else {
				$this->db->trans_commit();
				$message = array('message' => 'User successfully created', 'error' => false);
			}
		}

		return $message;
	}

	function deleteUser($token) {
		$requestor = $token['uniqueId'];

		$user_id = $this->input->post('id');

		if(empty($user_id)) {
			$message = array('message' => 'User ID cannot be empty');
		}
		else if($user_id == 1) {
			$message = array('message' => 'You do not have permission to delete this user');
		}
		else {
			$this->db->trans_start();
			$this->db->where(array('user_id' => $user_id));
			$this->db->delete('users');
			$this->db->trans_complete();
			if($this->db->trans_status() === false) {
				$this->db->trans_rollback();
				$message = array('message' => $this->db->error());
			}
			else {
				$this->db->trans_commit();
				$message = array('message' => 'User successfully deleted', 'error' => false);
			}
		}

		return $message;
	}
}
