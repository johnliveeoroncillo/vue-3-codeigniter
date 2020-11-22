<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/CreatorJwt.php';

class Api extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}


	function index() {
		echo 'test';
	}
	
	function login() {
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			if(empty($username) || empty($password)) {
				$message = array('message' => 'Username or password cannot be empty');
			}  
			else if($username != 'admin' || $password != 'admin') {
				$message = array('message' => 'Invalid username or password');
			} 
			else {
				$message = $this->api_model->login($username, $password);
				if(!empty($message['flag'])) {
					$message['access_token'] = $this->__generate($message['id']);
				}
			}
		}
		else {
			$message = array('message' => 'Invalid Request Method');
		}

		echo json_encode($message);
	}

	function users() {
		if($_SERVER['REQUEST_METHOD'] == 'GET') {

			$response = $this->__validate();

			if($response) {
				$message = $this->api_model->getUsers($response);
			}
		}
		else {
			$message = array('message' => 'Invalid Request Method');
		}

		echo json_encode($message);
	}

	function create() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {

			$response = $this->__validate();

			if($response) {
				$message = $this->api_model->createUser($response);
			}
		}
		else {
			$message = array('message' => 'Invalid Request Method');
		}

		echo json_encode($message);
	}

	function delete() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {

			$response = $this->__validate();

			if($response) {
				$message = $this->api_model->deleteUser($response);
			}
		}
		else {
			$message = array('message' => 'Invalid Request Method');
		}

		echo json_encode($message);
	}


	private function __generate($user_id) {
		$this->objOfJwt = new CreatorJwt();
        header('Content-Type: application/json');

        $tokenData['uniqueId'] = $user_id;
        $tokenData['expiration'] = date('Y-m-d H:i:s', strtotime('+1 day'));
        $jwtToken = $this->objOfJwt->GenerateToken($tokenData);
       	return $jwtToken;
	}

	private function __validate() {
		$this->objOfJwt = new CreatorJwt();
        header('Content-Type: application/json');

		 $token = $this->input->request_headers();
		 try {
		 	$explode = explode(' ', $token['authorization']);
            $jwtData = $this->objOfJwt->DecodeToken($explode[1]);
            if(date('Y-m-d H:i:s') > $jwtData['expiration']) {
            	http_response_code('401');
	            echo json_encode(array('message' => 'Expired Token, please relogin'));
	            exit;
            }
            else if(empty($jwtData['uniqueId'])) {
            	http_response_code('401');
	            echo json_encode(array('message' => 'Invalid User ID'));
	            exit;
            }
            else {
            	return $jwtData;
            }
        }
        catch (Exception $e) {
            http_response_code('401');
            echo json_encode(array('message' => $e->getMessage()));
            exit;
        }
	}
}
