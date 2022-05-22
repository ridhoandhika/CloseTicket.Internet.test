<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Package extends CI_Controller {
	
	var $cfgDashboard;
	
	function __construct() {
		
        parent::__construct();
		if(!$this->session->userdata('enc')) {
			$this->session->set_userdata('enc', sha1(time().'.'.rand(111111, 999999)));
		}
		$this->cfgDashboard = $this->config->item('config.dashboard');
		
	}
	
	public function index()	{
		

		if($this->session->userdata('SignedIn') == true) {
			$this->ModelTemplate->render(
				array(),
				array(
					'Chart.bundle.min.js'
				),
				array(
					'material-design-iconic-font.min.css',
					'materialdesign.css'
				)
			);
		}
		else {
			redirect('Dashboard/pageSignIn');
		}
		
	}
	
	public function jsonList_fup()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		if($this->session->userdata('SignedIn') == true) {
			$q01 = $this->db->query('
				SELECT
					a.id, 
					a.package_name,
					b.usage_amount_1,
					b.usage_unit_1,
					b.usage_amount_2,
					b.usage_unit_2,
					b.usage_amount_3,
					b.usage_unit_3,
					b.speed_amount_1,
					b.speed_unit_1,
					b.speed_amount_2,
					b.speed_unit_2,
					b.speed_amount_3,
					b.speed_unit_3
				FROM
					matrix_type AS a
					INNER JOIN matrix_fup AS b ON
						a.package_type = '.$this->db->escape('fup').'
						AND a.id = b.type_id
				WHERE
					1 = 1
				ORDER BY
					a.package_name ASC
			');
			$output['success'] = true;
			$output['data'] = $q01->result_array();
		}
		else {
			$error[] = 'unauthorized';
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}
	
	public function jsonUpdate_fup()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		if($this->session->userdata('SignedIn') == true) {
			$q01 = $this->db->query('
				SELECT
					id
				FROM
					matrix_type
				WHERE
					1 = 1
					AND id <> '.$this->db->escape($this->input->post('id')).'
					AND package_name = '.$this->db->escape($this->input->post('package_name')).'
				
			');
			if($q01->num_rows() > 0) {
				$error[] = 'package name already exist';
			}
			else {
				$q02 = $this->db->query('
					UPDATE matrix_type
					SET
						package_name = '.$this->db->escape($this->input->post('package_name')).'
					WHERE
						1 = 1
						AND id = '.$this->db->escape($this->input->post('id')).'
				');
				$q03 = $this->db->query('
					UPDATE matrix_fup
					SET
						usage_amount_2 = '.$this->db->escape($this->input->post('usage_amount_2')).',
						usage_amount_3 = '.$this->db->escape($this->input->post('usage_amount_3')).',
						usage_unit_2 = '.$this->db->escape($this->input->post('usage_unit_2')).',
						usage_unit_3 = '.$this->db->escape($this->input->post('usage_unit_3')).',
						speed_amount_1 = '.$this->db->escape($this->input->post('speed_amount_1')).',
						speed_amount_2 = '.$this->db->escape($this->input->post('speed_amount_2')).',
						speed_amount_3 = '.$this->db->escape($this->input->post('speed_amount_3')).',
						speed_unit_1 = '.$this->db->escape($this->input->post('speed_unit_1')).',
						speed_unit_2 = '.$this->db->escape($this->input->post('speed_unit_2')).',
						speed_unit_3 = '.$this->db->escape($this->input->post('speed_unit_3')).'
					WHERE
						1 = 1
						AND type_id = '.$this->db->escape($this->input->post('id')).'
				');
				$output['success'] = true;
			}
		}
		else {
			$error[] = 'unauthorized';
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}
	
	public function jsonCreate_fup()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		if($this->session->userdata('SignedIn') == true) {
			$q01 = $this->db->query('
				SELECT
					id
				FROM
					matrix_type
				WHERE
					1 = 1
					AND package_name = '.$this->db->escape($this->input->post('package_name')).'
				
			');
			if($q01->num_rows() > 0) {
				$error[] = 'package name already exist';
			}
			else {
				$q01 = $this->db->query('
					INSERT INTO matrix_type (
						package_name,
						package_type
					)
					VALUES (
						'.$this->db->escape($this->input->post('package_name')).',
						'.$this->db->escape('fup').'
					)
				');
				$id = $this->db->insert_id();
				$q02 = $this->db->query('
					INSERT INTO matrix_fup (
						type_id,
						usage_amount_1,
						usage_amount_2,
						usage_amount_3,
						usage_unit_1,
						usage_unit_2,
						usage_unit_3,
						speed_amount_1,
						speed_amount_2,
						speed_amount_3,
						speed_unit_1,
						speed_unit_2,
						speed_unit_3
					)
					VALUES (
						'.$this->db->escape($id).',
						'.$this->db->escape($this->input->post('usage_amount_1')).',
						'.$this->db->escape($this->input->post('usage_amount_2')).',
						'.$this->db->escape($this->input->post('usage_amount_3')).',
						'.$this->db->escape($this->input->post('usage_unit_1')).',
						'.$this->db->escape($this->input->post('usage_unit_2')).',
						'.$this->db->escape($this->input->post('usage_unit_3')).',
						'.$this->db->escape($this->input->post('speed_amount_1')).',
						'.$this->db->escape($this->input->post('speed_amount_2')).',
						'.$this->db->escape($this->input->post('speed_amount_3')).',
						'.$this->db->escape($this->input->post('speed_unit_1')).',
						'.$this->db->escape($this->input->post('speed_unit_2')).',
						'.$this->db->escape($this->input->post('speed_unit_3')).'
					)
				');
				$output['success'] = true;
			}
		}
		else {
			$error[] = 'unauthorized';
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}
	
	public function jsonDelete_fup()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		if($this->session->userdata('SignedIn') == true) {
			$q01 = $this->db->query('
				DELETE a, b 
				FROM
					matrix_type AS a
					INNER JOIN matrix_fup AS b ON
						a.package_type = '.$this->db->escape('fup').'
						AND a.id = b.type_id
				WHERE
					1 = 1
					AND a.id = '.$this->db->escape($this->input->post('id')).'
			');
			if($this->db->affected_rows() > 0) {
				$output['success'] = true;
			}
		}
		else {
			$error[] = 'unauthorized';
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}
	
	public function jsonList_quota_yes()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		if($this->session->userdata('SignedIn') == true) {
			$q01 = $this->db->query('
				SELECT
					a.id, 
					a.package_name,
					b.quota,
					b.unit
				FROM
					matrix_type AS a
					INNER JOIN matrix_quota_yes AS b ON
						a.package_type = '.$this->db->escape('quota_yes').'
						AND a.id = b.type_id
				WHERE
					1 = 1
				ORDER BY
					a.package_name ASC
			');
			$output['success'] = true;
			$output['data'] = $q01->result_array();
		}
		else {
			$error[] = 'unauthorized';
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}
	
	public function jsonUpdate_quota_yes()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		if($this->session->userdata('SignedIn') == true) {
			$q01 = $this->db->query('
				SELECT
					id
				FROM
					matrix_type
				WHERE
					1 = 1
					AND id <> '.$this->db->escape($this->input->post('id')).'
					AND package_name = '.$this->db->escape($this->input->post('package_name')).'
				
			');
			if($q01->num_rows() > 0) {
				$error[] = 'package name already exist';
			}
			else {
				$q02 = $this->db->query('
					UPDATE matrix_type
					SET
						package_name = '.$this->db->escape($this->input->post('package_name')).'
					WHERE
						1 = 1
						AND id = '.$this->db->escape($this->input->post('id')).'
				');
				$q03 = $this->db->query('
					UPDATE matrix_quota_yes
					SET
						quota = '.$this->db->escape($this->input->post('quota')).',
						unit = '.$this->db->escape($this->input->post('unit')).'
					WHERE
						1 = 1
						AND type_id = '.$this->db->escape($this->input->post('id')).'
				');
				$output['success'] = true;
			}
		}
		else {
			$error[] = 'unauthorized';
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}
	
	public function jsonCreate_quota_yes()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		if($this->session->userdata('SignedIn') == true) {
			$q01 = $this->db->query('
				SELECT
					id
				FROM
					matrix_type
				WHERE
					1 = 1
					AND package_name = '.$this->db->escape($this->input->post('package_name')).'
				
			');
			if($q01->num_rows() > 0) {
				$error[] = 'package name already exist';
			}
			else {
				$q01 = $this->db->query('
					INSERT INTO matrix_type (
						package_name,
						package_type
					)
					VALUES (
						'.$this->db->escape($this->input->post('package_name')).',
						'.$this->db->escape('quota_yes').'
					)
				');
				$id = $this->db->insert_id();
				$q02 = $this->db->query('
					INSERT INTO matrix_quota_yes (
						type_id,
						quota,
						unit
					)
					VALUES (
						'.$this->db->escape($id).',
						'.$this->db->escape($this->input->post('quota')).',
						'.$this->db->escape($this->input->post('unit')).'
					)
				');
				$output['success'] = true;
			}
		}
		else {
			$error[] = 'unauthorized';
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}
	
	public function jsonDelete_quota_yes()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		if($this->session->userdata('SignedIn') == true) {
			$q01 = $this->db->query('
				DELETE a, b 
				FROM
					matrix_type AS a
					INNER JOIN matrix_quota_yes AS b ON
						a.package_type = '.$this->db->escape('quota_yes').'
						AND a.id = b.type_id
				WHERE
					1 = 1
					AND a.id = '.$this->db->escape($this->input->post('id')).'
			');
			if($this->db->affected_rows() > 0) {
				$output['success'] = true;
			}
		}
		else {
			$error[] = 'unauthorized';
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function jsonList_quota_no()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		if($this->session->userdata('SignedIn') == true) {
			$q01 = $this->db->query('
				SELECT
					a.id, 
					a.package_name,
					b.speed,
					b.unit
				FROM
					matrix_type AS a
					INNER JOIN matrix_quota_no AS b ON
						a.package_type = '.$this->db->escape('quota_no').'
						AND a.id = b.type_id
				WHERE
					1 = 1
				ORDER BY
					a.package_name ASC
			');
			$output['success'] = true;
			$output['data'] = $q01->result_array();
		}
		else {
			$error[] = 'unauthorized';
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}
	
	public function jsonUpdate_quota_no()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		if($this->session->userdata('SignedIn') == true) {
			$q01 = $this->db->query('
				SELECT
					id
				FROM
					matrix_type
				WHERE
					1 = 1
					AND id <> '.$this->db->escape($this->input->post('id')).'
					AND package_name = '.$this->db->escape($this->input->post('package_name')).'
				
			');
			if($q01->num_rows() > 0) {
				$error[] = 'package name already exist';
			}
			else {
				$q02 = $this->db->query('
					UPDATE matrix_type
					SET
						package_name = '.$this->db->escape($this->input->post('package_name')).'
					WHERE
						1 = 1
						AND id = '.$this->db->escape($this->input->post('id')).'
				');
				$q03 = $this->db->query('
					UPDATE matrix_quota_no
					SET
						speed = '.$this->db->escape($this->input->post('speed')).',
						unit = '.$this->db->escape($this->input->post('unit')).'
					WHERE
						1 = 1
						AND type_id = '.$this->db->escape($this->input->post('id')).'
				');
				$output['success'] = true;
			}
		}
		else {
			$error[] = 'unauthorized';
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}
	
	public function jsonCreate_quota_no()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		if($this->session->userdata('SignedIn') == true) {
			$q01 = $this->db->query('
				SELECT
					id
				FROM
					matrix_type
				WHERE
					1 = 1
					AND package_name = '.$this->db->escape($this->input->post('package_name')).'
				
			');
			if($q01->num_rows() > 0) {
				$error[] = 'package name already exist';
			}
			else {
				$q01 = $this->db->query('
					INSERT INTO matrix_type (
						package_name,
						package_type
					)
					VALUES (
						'.$this->db->escape($this->input->post('package_name')).',
						'.$this->db->escape('quota_no').'
					)
				');
				$id = $this->db->insert_id();
				$q02 = $this->db->query('
					INSERT INTO matrix_quota_no (
						type_id,
						speed,
						unit
					)
					VALUES (
						'.$this->db->escape($id).',
						'.$this->db->escape($this->input->post('speed')).',
						'.$this->db->escape($this->input->post('unit')).'
					)
				');
				$output['success'] = true;
			}
		}
		else {
			$error[] = 'unauthorized';
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}
	
	public function jsonDelete_quota_no()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		if($this->session->userdata('SignedIn') == true) {
			$q01 = $this->db->query('
				DELETE a, b 
				FROM
					matrix_type AS a
					INNER JOIN matrix_quota_no AS b ON
						a.package_type = '.$this->db->escape('quota_no').'
						AND a.id = b.type_id
				WHERE
					1 = 1
					AND a.id = '.$this->db->escape($this->input->post('id')).'
			');
			if($this->db->affected_rows() > 0) {
				$output['success'] = true;
			}
		}
		else {
			$error[] = 'unauthorized';
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}
	
}
