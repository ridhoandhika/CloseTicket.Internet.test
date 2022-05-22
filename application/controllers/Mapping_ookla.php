<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapping_ookla extends CI_Controller {
	
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

	public function jsonList_mapping()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		if($this->session->userdata('SignedIn') == true) {
			$q01 = $this->db->query('
				SELECT id,ip_bras, bras,speedtest
				FROM
					mapping_ookla
				WHERE
					1 = 1
				ORDER BY
					bras
				limit 10
					
			');
			$output['success'] = true;
			$output['data'] = $q01->result_array();
			// var_dump($output);
		}
		else {
			$error[] = 'unauthorized';
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}

	public function jsonSearch_mapping()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		if($this->session->userdata('SignedIn') == true) {
			$q01 = $this->db->query('
				SELECT id,ip_bras, bras,speedtest
				FROM
					mapping_ookla
				WHERE
					1 = 1
				AND ip_bras like "%"'.$this->db->escape($this->input->post('ip_bras')).'"%"
				ORDER BY
					bras
					limit 20
					
			');
			// if($q01->num_rows() > 0) {
			// 	$error[] = 'package name already exist';
			// }else {
			// 	$q02 = $this->db->query('
			// 		UPDATE mapping_ookla
			// 		SET
			// 			ip_bras = '.$this->db->escape($this->input->post('ip_bras')).'
			// 		WHERE
			// 			1 = 1
			// 			AND id = '.$this->db->escape($this->input->post('id')).'
			// 	');
			// 	$q03 = $this->db->query('
			// 		UPDATE mapping_ookla
			// 		SET
			// 			bras = '.$this->db->escape($this->input->post('bras')).',
			// 			speedtest = '.$this->db->escape($this->input->post('speedtest')).',
			// 		WHERE
			// 			1 = 1
			// 			AND id = '.$this->db->escape($this->input->post('id')).'
			// 	');
			// 	$output['success'] = true;
			// }
		// }
		// else {
		// 	$error[] = 'unauthorized';
		// }
		// if(count($error) > 0) {
		// 	$output['error'] = $error;
		// }
		// echo json_encode($output);
			$output['success'] = true;
			$output['data'] = $q01->result_array();
			// var_dump($output);
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
