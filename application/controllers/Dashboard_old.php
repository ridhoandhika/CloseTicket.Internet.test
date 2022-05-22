<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_old extends CI_Controller {
	
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
		if(isset($this->cfgDashboard['auth'][$this->input->post('username')]) && $this->cfgDashboard['auth'][$this->input->post('username')]['password'] == $this->input->post('password')) {
			$this->session->set_userdata('SignedIn', true);
			$this->session->set_userdata('SignedRole', $this->cfgDashboard['auth'][$this->input->post('username')]['role']);
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
						whitelist,
						blacklist,
						who_success,
						who_failed,
						token_1_success,
						token_1_failed,
						nd_success,
						nd_failed,
						redaman_success_spec,
						redaman_success_unspec,
						redaman_failed,
						pcrf_success,
						pcrf_failed,
						speedtest_success_passed_1,
						speedtest_success_passed_0,
						speedtest_failed,
						close_1,
						close_0
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
						'close' => 0,
						'reopen' => 0
					),
					'02' => array(
						'success_redaman' => 0,
						'fail_redaman' => 0
					),
					'03' => array(
						'success_speedtest' => 0,
						'fail_speedtest' => 0
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
						'whitelist' => $r01['whitelist'],
						'blacklist' => $r01['blacklist'],
						'who_success' => $r01['who_success'],
						'who_failed' => $r01['who_failed'],
						'token_1_success' => $r01['token_1_success'],
						'token_1_failed' => $r01['token_1_failed'],
						'nd_success' => $r01['nd_success'],
						'nd_failed' => $r01['nd_failed'],
						'redaman_success_spec' => $r01['redaman_success_spec'],
						'redaman_success_unspec' => $r01['redaman_success_unspec'],
						'redaman_failed' => $r01['redaman_failed'],
						'pcrf_success' => $r01['pcrf_success'],
						'pcrf_failed' => $r01['pcrf_failed'],
						'speedtest_success_passed_1' => $r01['speedtest_success_passed_1'],
						'speedtest_success_passed_0' => $r01['speedtest_success_passed_0'],
						'speedtest_failed' => $r01['speedtest_failed'],
						'close_1' => $r01['close_1'],
						'close_0' => $r01['close_0']
					);
					$chart['01']['close'] += $r01['close_1'];
					$chart['01']['reopen'] += $r01['close_0'];
					$chart['02']['success_redaman'] += $r01['redaman_success_spec'];
					$chart['02']['fail_redaman'] += $r01['redaman_success_unspec'];
					$chart['03']['success_speedtest'] += $r01['speedtest_success_passed_1'];
					$chart['03']['fail_speedtest'] += $r01['speedtest_success_passed_0'];
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
			if($this->input->post('detail-type') != '' && $this->input->post('detail-tick') != '') {
				$token = 0;
				$w01 = '';
				switch($this->input->post('detail-field')) {
					case 'who_success':
						$w01 = '
							AND ip_addr IS NOT NULL 
							AND ip_addr <> \'\'
						';
						$token++;
						break;
					case 'who_failed':
						$w01 = '
							AND (
								ip_addr IS NULL
								OR ip_addr = \'\'
							)
						';
						$token++;
						break;
					case 'token_1_success':
						$w01 = '
							AND ip_addr IS NOT NULL 
							AND ip_addr <> \'\' 
							AND bearer1 IS NOT NULL
							AND bearer1 <> \'\'
						';
						$token++;
						break;
					case 'token_1_failed':
						$w01 = '
							AND ip_addr IS NOT NULL 
							AND ip_addr <> \'\' 
							AND (
								bearer1 IS NULL
								OR bearer1 = \'\'
							)
						';
						$token++;
						break;
					case 'nd_success':
						$w01 = '
							AND ip_addr IS NOT NULL 
							AND ip_addr <> \'\' 
							AND bearer1 IS NOT NULL
							AND bearer1 <> \'\'
							AND nd IS NOT NULL
							AND nd <> \'\'
						';
						$token++;
						break;
					case 'nd_failed':
						$w01 = '
							AND ip_addr IS NOT NULL 
							AND ip_addr <> \'\' 
							AND bearer1 IS NOT NULL
							AND bearer1 <> \'\'
							AND (
								nd IS NULL
								OR nd = \'\'
							)
						';
						$token++;
						break;
					case 'redaman_success_spec':
						$w01 = '
							AND ip_addr IS NOT NULL 
							AND ip_addr <> \'\' 
							AND bearer1 IS NOT NULL
							AND bearer1 <> \'\'
							AND nd IS NOT NULL
							AND nd <> \'\'
							AND redaman_ts IS NOT NULL
							AND onu_rx_pwr IS NOT NULL
							AND redaman_passed > 0
						';
						$token++;
						break;
					case 'redaman_success_unspec':
						$w01 = '
							AND ip_addr IS NOT NULL 
							AND ip_addr <> \'\' 
							AND bearer1 IS NOT NULL
							AND bearer1 <> \'\'
							AND nd IS NOT NULL
							AND nd <> \'\'
							AND redaman_ts IS NOT NULL
							AND onu_rx_pwr IS NOT NULL
							AND redaman_passed = 0
						';
						$token++;
						break;
					case 'redaman_failed':
						$w01 = '
							AND ip_addr IS NOT NULL 
							AND ip_addr <> \'\' 
							AND bearer1 IS NOT NULL
							AND bearer1 <> \'\'
							AND nd IS NOT NULL
							AND nd <> \'\'
							AND redaman_ts IS NOT NULL
							AND onu_rx_pwr IS NULL
						';
						$token++;
						break;
					case 'pcrf_success':
						$w01 = '
							AND ip_addr IS NOT NULL 
							AND ip_addr <> \'\' 
							AND bearer1 IS NOT NULL
							AND bearer1 <> \'\'
							AND nd IS NOT NULL
							AND nd <> \'\'
							AND package_name IS NOT NULL
							AND package_name <> \'\'
						';
						$token++;
						break;
					case 'pcrf_failed':
						$w01 = '
							AND ip_addr IS NOT NULL 
							AND ip_addr <> \'\' 
							AND bearer1 IS NOT NULL
							AND bearer1 <> \'\'
							AND nd IS NOT NULL
							AND nd <> \'\'
							AND (
								package_name IS NULL
								OR package_name = \'\'
							)
						';
						$token++;
						break;
					case 'speedtest_success_passed_1':
						$w01 = '
							AND ip_addr IS NOT NULL 
							AND ip_addr <> \'\' 
							AND bearer1 IS NOT NULL
							AND bearer1 <> \'\'
							AND nd IS NOT NULL
							AND nd <> \'\'
							AND package_name IS NOT NULL
							AND package_name <> \'\'
							AND speed_passed > 0
						';
						$token++;
						break;
					case 'speedtest_success_passed_0':
						$w01 = '
							AND ip_addr IS NOT NULL 
							AND ip_addr <> \'\' 
							AND bearer1 IS NOT NULL
							AND bearer1 <> \'\'
							AND nd IS NOT NULL
							AND nd <> \'\'
							AND package_name IS NOT NULL
							AND package_name <> \'\'
							AND speed_passed = 0
						';
						$token++;
						break;
					case 'speedtest_failed':
						$w01 = '
							AND ip_addr IS NOT NULL 
							AND ip_addr <> \'\' 
							AND bearer1 IS NOT NULL
							AND bearer1 <> \'\'
							AND nd IS NOT NULL
							AND nd <> \'\'
							AND package_name IS NOT NULL
							AND package_name <> \'\'
							AND (
								speed_passed IS NULL
							)
						';
						$token++;
						break;
					case 'close_1':
						$w01 = '
							AND close = 1
						';
						$token++;
						break;
					case 'close_0':
						$w01 = '
							AND close = 0
						';
						$token++;
						break;
					default:
				}
				if($token > 0) {
					if($this->input->post('detail-type') == 'hour') {
						$q01 = $this->db->query('
							SELECT
								ts,
								TIME(ts_finish) as ts_finish,
								uid,
								nd,
								remote_addr,
								bras,
								ip_addr,
								ticket,
								token1_log_total_time,
								ndbyip_log_total_time,
								onu_rx_pwr,
								reg_type,
								version_id,
								identifier,
								redaman_log_total_time,
								redaman_passed,
								token2_log_total_time,
								pcrf_log_total_time,
								package_name,
								quota_used,
								speed_log_response,
								speedtest_download,
								speedtest_upload,
								speedtest_units,
								speedtest_latency_minimum,
								speedtest_latency_jitter,
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
					}
					else {
						$q01 = $this->db->query('
							SELECT
								ts,
								TIME(ts_finish) as ts_finish,
								uid,
								nd,
								remote_addr,
								bras,
								ip_addr,
								ticket,
								token1_log_total_time,
								ndbyip_log_total_time,
								onu_rx_pwr,
								reg_type,
								version_id,
								identifier,
								redaman_log_total_time,
								redaman_passed,
								token2_log_total_time,
								pcrf_log_total_time,
								package_name,
								quota_used,
								speed_log_response,
								speedtest_download,
								speedtest_upload,
								speedtest_units,
								speedtest_latency_minimum,
								speedtest_latency_jitter,
								speed_passed,
								close
							FROM
								task_archive
							WHERE
								1 = 1
								AND DATE(ts) = DATE('.$this->db->escape($this->input->post('detail-tick')).')
								'.$w01.'
							ORDER BY
								ts ASC
						');
					}
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
	
	public function pageSearch()	{
		

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
	
	public function jSearchTicket()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		if($this->session->userdata('SignedIn') == true) {
			if($this->input->post('ticket') != '') {
				$q01 = $this->db->query('
					SELECT
						ts,
						TIME(ts_finish) as ts_finish,
						ip_addr,
						remote_addr,
						bras,
						ticket,
						token1_log_total_time,
						ndbyip_log_total_time,
						nd,
						onu_rx_pwr,
						reg_type,
						version_id,
						identifier,
						redaman_log_total_time,
						redaman_passed,
						token2_log_total_time,
						pcrf_log_total_time,
						package_name,
						quota_used,
						speed_log_response,
						speedtest_download,
						speedtest_upload,
						speedtest_units,
						speedtest_latency_minimum,
						speedtest_latency_jitter,
						speed_passed,
						close,
						uid
					FROM
						task_archive
					WHERE
						1 = 1
						AND ticket = '.$this->db->escape($this->input->post('ticket')).'
					ORDER BY
						ts DESC
				');
				$output['success'] = true;
				$output['data'] = array(
					'detail' => $q01->result_array()
				);
			}
			else {
				$error[] = 'empty ticket';
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
	
	public function jSearchND()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		if($this->session->userdata('SignedIn') == true) {
			if($this->input->post('nd') != '') {
				$q01 = $this->db->query('
					SELECT
						ts,
						TIME(ts_finish) as ts_finish,
						ip_addr,
						remote_addr,
						bras,
						ticket,
						token1_log_total_time,
						ndbyip_log_total_time,
						nd,
						onu_rx_pwr,
						reg_type,
						version_id,
						identifier,
						redaman_log_total_time,
						redaman_passed,
						token2_log_total_time,
						pcrf_log_total_time,
						package_name,
						quota_used,
						speed_log_response,
						speedtest_download,
						speedtest_upload,
						speedtest_units,
						speedtest_latency_minimum,
						speedtest_latency_jitter,
						speed_passed,
						close,
						uid
					FROM
						task_archive
					WHERE
						1 = 1
						AND nd_number = '.$this->db->escape($this->input->post('nd')).'
					ORDER BY
						ts DESC
				');
				$output['success'] = true;
				$output['data'] = array(
					'detail' => $q01->result_array()
				);
			}
			else {
				$error[] = 'empty ticket';
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
