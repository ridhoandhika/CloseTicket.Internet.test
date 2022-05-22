<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
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
	
	public function pageSignIn() {
		
		if($this->session->userdata('SignedIn') == true) {
			redirect('Dashboard/index');
		}
		else {
			$this->ModelTemplate->render();
		}
		
	}
	
	public function pageSignOut() {
		
		$this->session->sess_destroy();
		redirect('Dashboard/index');
		
	}
	
	public function jsonSignIn()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		if(isset($this->cfgDashboard['auth'][$this->input->post('username')]) && $this->cfgDashboard['auth'][$this->input->post('username')] == $this->input->post('password')) {
			$this->session->set_userdata('SignedIn', true);
			$output['success'] = true;
		}
		else {
			$error[] = 'incorrect username and password combination';
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}
	
	public function jOverviewList()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		if($this->session->userdata('SignedIn') == true) {
			if($this->input->post('filter-start') != '' && $this->input->post('filter-finish') != '') {
				$q01 = $this->db->query('
					SELECT
						tick,
						total,
						success_close,
						success_reopen,
						fail_redaman,
						fail_speedtest,
						incomplete
					FROM
						task_mart
					WHERE
						1 = 1
						AND tick >= '.$this->db->escape($this->input->post('filter-start').' 00:00:00').'
						AND tick < DATE_ADD('.$this->db->escape($this->input->post('filter-finish').' 00:00:00').', INTERVAL 1 DAY)
					ORDER BY
						tick ASC
				');
				$chart = array(
					'01' => array(
						'complete' => 0,
						'incomplete' => 0
					),
					'02' => array(
						'success' => 0,
						'fail' => 0
					),
					'03' => array(
						'close' => 0,
						'reopen' => 0
					),
					'04' => array(
						'redaman' => 0,
						'speedtest' => 0
					)
				);
				$list = array();
				foreach($q01->result_array() as $r01) {
					$date = substr($r01['tick'], 0, 10);
					$time = substr($r01['tick'], 11, 8);
					if(!isset($list[$date])) {
						$list[$date] = array();
					}
					$list[$date][$time] = array(
						'tick' => $r01['tick'],
						'total' => $r01['total'],
						'success_close' => $r01['success_close'],
						'success_reopen' => $r01['success_reopen'],
						'fail_redaman' => $r01['fail_redaman'],
						'fail_speedtest' => $r01['fail_speedtest'],
						'incomplete' => $r01['incomplete']
					);
					$chart['01']['complete'] += $r01['success_close'] + $r01['success_reopen'] + $r01['fail_redaman'] + $r01['fail_speedtest'];
					$chart['01']['incomplete'] += $r01['incomplete'];
					$chart['02']['success'] += $r01['success_close'] + $r01['success_reopen'];
					$chart['02']['fail'] += $r01['fail_redaman'] + $r01['fail_speedtest'];
					$chart['03']['close'] += $r01['success_close'];
					$chart['03']['reopen'] += $r01['success_reopen'];
					$chart['04']['redaman'] += $r01['fail_redaman'];
					$chart['04']['speedtest'] += $r01['fail_speedtest'];
				}
				$output['success'] = true;
				$output['data'] = array(
					'list' => $list,
					'chart' => $chart
				);
			}
			else {
				$error[] = 'incorrect username and password combination';
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
	
	public function jOverviewDetail()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		if($this->session->userdata('SignedIn') == true) {
			if($this->input->post('detail-tick') != '') {
				$token = 0;
				$w01 = '';
				switch($this->input->post('detail-field')) {
					case 'success_close':
						$w01 = '
							AND close = 1
						';
						$token++;
						break;
					case 'success_reopen':
						$w01 = '
							AND close = 0
						';
						$token++;
						break;
					case 'fail_redaman':
						$w01 = '
							AND redaman_passed = 0
						';
						$token++;
						break;
					case 'fail_speedtest':
						$w01 = '
							AND speed_passed = 0
						';
						$token++;
						break;
					case 'incomplete':
						$w01 = '
							AND incomplete = 1
						';
						$token++;
						break;
					default:
				}
				if($token > 0) {
					$q01 = $this->db->query('
						SELECT
							ts,
							uid,
							remote_addr,
							ticket,
							session_id,
							decrypted_userid,
							onu_rx_pwr,
							redaman_passed,
							package_name,
							quota_used,
							speed_test,
							speed_passed,
							close
						FROM
							task_archive
						WHERE
							1 = 1
							AND ts >= '.$this->db->escape($this->input->post('detail-tick')).'
							AND ts < DATE_ADD('.$this->db->escape($this->input->post('detail-tick')).', INTERVAL 1 HOUR)
							'.$w01.'
						ORDER BY
							ts ASC
					');
					$output['success'] = true;
					$output['data'] = array(
						'detail' => $q01->result_array()
					);
				}
			}
			else {
				$error[] = 'incorrect username and password combination';
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
