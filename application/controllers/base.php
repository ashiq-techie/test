<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Base extends CI_Controller {

	public function index()
	{
		$data = [];
		$this->load->model('base/employee', 'oEmployeeModel');
		$aEmployees = $this->oEmployeeModel->getEmployees();
		if ($aEmployees) {
			$data['aEmployees'] = $aEmployees;
		} else {
			$data['aEmployees'] = '';
		}
		$this->load->view('header', $data, FALSE);
		$this->load->view('base/index', $data, FALSE);
		$this->load->view('footer', $data, FALSE);
	}

	public function insert()
	{
		if ($this->input->method() == 'post' && $this->input->is_ajax_request()) {
			$aPeopleUpdate = $this->input->post('peopleUpdate');
			$aPeople = $this->input->post('people');
			$this->load->model('base/employee', 'oEmployeeModel');
			$this->load->model('base/job_role', 'oJobRoleModel');
			foreach ($aPeople as $key => $element) {
				if ($key == 'email') {
					if (filter_var($element, FILTER_VALIDATE_EMAIL) === false) {
						$response['status'] = 'error';
						$response['insert'] = 'invalid email address';
						echo json_encode($response);
						exit();
					}
				} 

				if ((empty($element))) {
					$response['status'] = 'error';
					$response['insert'] ='"' . str_replace('_', ' ', $key).'" is empty!';
					echo json_encode($response);
					exit();
				}
			}
			// create part
			if (!empty($aPeople)) {
				$iJobRoleId = $this->oJobRoleModel->checkAndRetrieveJobRoleId(preg_replace("/[^A-Za-z0-9]/", "", $aPeople['job_role']),$aPeople['job_role']);
				$sResultEmployeeCheck = $this->oEmployeeModel->employeeCheck($iJobRoleId);
				if($sResultEmployeeCheck == 'true'){
					$result = $this->oEmployeeModel->insertEmployee($aPeople, $iJobRoleId);
					if($result === true){
						$response['status'] = 'success';
					} else {
						$response['status'] = 'error';
						$response['insert'] = 'failed inserting due to database error';
					}
				} else {
					$aResultEmployeeCheck = explode(',', $sResultEmployeeCheck);
					$response = [
						'status' => $aResultEmployeeCheck[0],
						'insert' => $aResultEmployeeCheck[1]
					];
				}
				echo json_encode($response);
			}
			
		} else {
			exit('Only ajax requests are allowed');
		}
	}

	public function update()
	{
		if ($this->input->method() == 'post' && $this->input->is_ajax_request()) {
			$name = $this->input->post('name');
			$value = $this->input->post('value');
			$this->load->model('base/employee', 'oEmployeeModel');
			$this->load->model('base/job_role', 'oJobRoleModel');
			$response = [];
			$aNameParts = explode('[', $name);
			if (empty($value)) {
				$response['status'] = 'error';
				$response['update'] = 'Updated Value cannot be empty';
				echo json_encode($response);
				exit();
			}
			if (strpos($name, 'email')) {
				if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
					$response['status'] = 'error';
					$response['update'] = 'invalid email address';
					echo json_encode($response);
					exit();
				}
			}
			if (strpos($name, 'job_role') !== false) {
				$aNameParts[2] = 'job_role_id]';
				$iJobRoleId = $this->oJobRoleModel->checkAndRetrieveJobRoleId(preg_replace("/[^A-Za-z0-9]/", "", $value),$value);
				$sResultEmployeeCheck = $this->oEmployeeModel->employeeCheck($iJobRoleId,'update');
				if ($sResultEmployeeCheck == 'true') {
					$this->oEmployeeModel->updateEmployee($aNameParts, $iJobRoleId);
					$response = [
						'status' => 'success',
						'update' => $sResultEmployeeCheck
					];
				} else {
					$aResultEmployeeCheck = explode(',', $sResultEmployeeCheck);
					$response = [
						'status' => $aResultEmployeeCheck[0],
						'update' => $aResultEmployeeCheck[1]
					];
				}
			} else {
				$this->oEmployeeModel->updateEmployee($aNameParts, $value);
			}
			echo json_encode($response);
		}else{
			exit('Only ajax requests are allowed');
		}
	}

	public function delete()
	{
		if ($this->input->method() == 'post' && $this->input->is_ajax_request()) {
			$this->load->model('base/employee', 'oEmployeeModel');
			$iEmployeeId = $this->input->post('emp_id');
			$this->oEmployeeModel->deleteEmployee($iEmployeeId);
			$response = ['status' => 'success'];
			echo json_encode($response);
		} else {
			exit('Only ajax requests are allowed');
		}
	}
}

/* End of file base.php */
/* Location: ./application/controllers/base.php */