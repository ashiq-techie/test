<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_role extends CI_Model {

	public function checkAndRetrieveJobRoleId($sUniqueJobName,$sJobRole)
	{
		$this->db->select('job_role_id');
		$this->db->from('job_role');
		$this->db->where('job_role_name_unique', $sUniqueJobName);
		$result = $this->db->get()->row_array();
		if (!empty($result)) {
			return $result['job_role_id'];
		} else {
			$aInsertData = array(
				'job_role_name' => $sJobRole, 
				'job_role_name_unique' => $sUniqueJobName);
			$this->db->insert('job_role', $aInsertData);
			return $this->db->insert_id();
		}

	}

}

/* End of file jobRole.php */
/* Location: ./application/models/base/jobRole.php */