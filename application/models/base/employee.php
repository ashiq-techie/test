<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Model {
	public function employeeCheck($iJobRoleId = '', $sAction = '')
	{
		// maximum of 10 records
		$this->db->from('employee_details');
		$this->db->where('is_deleted', 0);
		$iTotalCount = $this->db->count_all_results();
		if ($iTotalCount >= 10 && $sAction != 'update') {
			return 'error,Only a maximum of 10 records are allowed';
		} else {
			if (empty($iJobRoleId)) {
				return 'true'; // if we just need to check the first case alone (maximum of 10 records helps reusing the function)
			}
			// maximum of 4 records per job role
			$this->db->from('employee_details');
			$this->db->where('job_role_id', $iJobRoleId);
			$this->db->where('is_deleted', 0);
			$iJobRoleCount = $this->db->count_all_results();
			if ($iJobRoleCount >= 4) {
				return 'error,Only a maximum of 4 Job Roles allowed';
			} else {
				return 'true';
			}
		}

	}

	public function insertEmployee($aPeople, $iJobRoleId)
	{
		$aInsertData = array(
			'first_name' => $aPeople['first_name'], 
			'last_name' => $aPeople['last_name'], 
			'email' => $aPeople['email'], 
			'job_role_id' => $iJobRoleId, 
			'is_deleted' => 0
		);
		$result = $this->db->insert('employee_details', $aInsertData);
		if ($result) {
			return true;
		} else {
			return false;
		}
	}

	public function getEmployees()
	{
		$this->db->select('employee_id, first_name, last_name, email, job_role_name');
		$this->db->from('employee_details');
		$this->db->where('is_deleted', 0);
		$this->db->join('job_role', 'employee_details.job_role_id = job_role.job_role_id');
		$result = $this->db->get()->result_array();
		if (!empty($result)) {
			return $result;
		} else {
			return false;
		}
	}

	public function updateEmployee($aNameParts, $value)
	{
		$iEmployeeId = preg_replace('/([\]])/', "", $aNameParts[1]);
		$sAttribute = preg_replace('/([\]])/', "", $aNameParts[2]);
		$this->db->where('employee_id', $iEmployeeId);
		$aUpdateArray = array(
			$sAttribute => $value 
		);
		$this->db->update('employee_details', $aUpdateArray);
	}

	public function deleteEmployee($iEmployeeId)
	{
		$this->db->where('employee_id', $iEmployeeId);
		$aUpdateArray = array(
			'is_deleted' => 1
		);
		$this->db->update('employee_details', $aUpdateArray);
	}
}

/* End of file employee.php */
/* Location: ./application/models/base/employee.php */