<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {
	
	var $limit = 50;

	public function __construct()
	{
		parent::__construct();
		
		if(!$this->session->userdata('enc')) {
			$this->session->set_userdata('enc', sha1(time().'.'.rand(111111, 999999)));
		}
	}
	
	
	
		
	public function xls_summary()
	{
		ini_set('max_execution_time', '600');
		ini_set('memory_limit', '256M');
		if($this->session->userdata('SignedIn') == true) {
			if($this->input->post('xls-filter-start') != ''){	
				$datefirst = $this->input->post('xls-filter-start') . ' 00:00:00';
				$datefinish = $this->input->post('xls-filter-start') . ' 23:59:59';

				$q01 = $this->db->query('
					select 
						uid,
						remote_addr,
						ticket,
						ip_addr,
						CASE WHEN frame_ipv6 is not null THEN CONCAT(frame_ip," ",frame_ipv6) ELSE frame_ip end as f_ip_address,
						ip_passed,
						ndbyip_ts,
						nd,
						redaman_ts,
						onu_rx_pwr,
						reg_type,
						version_id,
						identifier,
						pcrf_ts,
						package_name,
						quota_used,
						speed_ts,
						speedtest_download,
						speedtest_upload,
						speedtest_units,
						speedtest_latency_minimum,
						speedtest_latency_jitter,
						close,
						ts
					from 
						task_archive
					where 
						1 = 1
						AND ts BETWEEN \''.$datefirst.'\' and \''.$datefinish.'\'
				');
				if($q01->num_rows() > 0) {
					$dataView = array(
						'data' => $q01->result_array()
					);
					/* $stringXLS = $this->load->view('Report/xls/summary', $dataView, TRUE);
					header("Content-type: application/octet-stream");
					header("Content-Disposition: attachment; filename=\"scc_".$this->input->post('xls-filter-start').".xls\"");
					echo $stringXLS; */
					header("Content-Description: File Transfer"); 
					header("Content-Disposition: attachment; filename=\"scc_".$this->input->post('xls-filter-start').".csv\"");
					header("Content-Type: application/csv; ");

					// file creation 
					$file = fopen('php://output', 'w');

					$header = array('uid','remote_addr','ticket','ip_addr','frame_ip_address','ip_passed','ndbyip_ts','nd','redaman_ts','onu_rx_pwr','reg_type','version_id','identifier','pcrf_ts','package_name','quota_used','speed_ts','speedtest_download','speedtest_upload','speedtest_units','speedtest_latency_minimum','speedtest_latency_jitter','close','ts'); 
					fputcsv($file, $header);
					foreach ($q01->result_array() as $key=>$line){ 
						fputcsv($file,$line); 
					}
					fclose($file); 
					exit; 
				}
			}
		}
		else {
			redirect('Dashboard/pageSignIn');
		}
	}
	
	public function xls_summary_range()
	{
		ini_set('max_execution_time', '600');
		if($this->session->userdata('SignedIn') == true) {
			if($this->input->post('xls-filter2-start') != '' && $this->input->post('xls-filter2-finish') != ''){	
				$datefirst = $this->input->post('xls-filter2-start') . ' 00:00:00';
				$datefinish = $this->input->post('xls-filter2-finish') . ' 23:59:59';

				$q01 = $this->db->query('
					select 
						uid,
						remote_addr,
						ticket,
						ip_addr,
						CASE WHEN frame_ipv6 is not null THEN CONCAT(frame_ip," ",frame_ipv6) ELSE frame_ip end as f_ip_address,
						ip_passed,
						ndbyip_ts,
						nd,
						redaman_ts,
						onu_rx_pwr,
						reg_type,
						version_id,
						identifier,
						pcrf_ts,
						package_name,
						quota_used,
						speed_ts,
						speedtest_download,
						speedtest_upload,
						speedtest_units,
						speedtest_latency_minimum,
						speedtest_latency_jitter,
						close,
						ts
					from 
						task_archive
					where 
						1 = 1
						AND ts BETWEEN \''.$datefirst.'\' and \''.$datefinish.'\'
				');
				if($q01->num_rows() > 0) {
					$dataView = array(
						'data' => $q01->result_array()
					);
					/* $stringXLS = $this->load->view('Report/xls/summary', $dataView, TRUE);
					header("Content-type: application/octet-stream");
					header("Content-Disposition: attachment; filename=\"scc_".$this->input->post('xls-filter-start').".xls\"");
					echo $stringXLS; */
					header("Content-Description: File Transfer"); 
					header("Content-Disposition: attachment; filename=\"scc_".$this->input->post('xls-filter2-start')."--".$this->input->post('xls-filter2-finish').".csv\"");
					header("Content-Type: application/csv; ");

					// file creation 
					$file = fopen('php://output', 'w');

					$header = array('uid','remote_addr','ticket','ip_addr','frame_ip_address','ip_passed','ndbyip_ts','nd','redaman_ts','onu_rx_pwr','reg_type','version_id','identifier','pcrf_ts','package_name','quota_used','speed_ts','speedtest_download','speedtest_upload','speedtest_units','speedtest_latency_minimum','speedtest_latency_jitter','close','ts'); 
					fputcsv($file, $header);
					foreach ($q01->result_array() as $key=>$line){ 
						fputcsv($file,$line); 
					}
					fclose($file); 
					exit; 
				}
			}
		}
		else {
			redirect('Dashboard/pageSignIn');
		}
	}
	
	/*public function log_scc_old()
	{
		$output = array(
			'success' => false
		);
		$error = array();
		if(
			$this->input->post('ticket') != ''
		) {
			$q01 = $this->db->query('
				SELECT 
					* 
				FROM	
					(
						SELECT
							uid,
							nd,
							remote_addr,
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
							speedtest_download,
							speedtest_upload,
							speedtest_units,
							speedtest_latency_minimum,
							speedtest_latency_jitter,
							speed_passed,
							close,
							ts
						FROM
							task_archive
						WHERE
							1 = 1
							AND ticket = '.$this->db->escape($this->input->post('ticket')).'
						UNION ALL
						SELECT
							uid,
							nd,
							remote_addr,
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
							speedtest_download,
							speedtest_upload,
							speedtest_units,
							speedtest_latency_minimum,
							speedtest_latency_jitter,
							speed_passed,
							close,
							ts
						FROM
							task_active
						WHERE
							1 = 1
							AND ticket = '.$this->db->escape($this->input->post('ticket')).'
					) as x
					ORDER BY
						x.close DESC,
						x.ts DESC
					LIMIT 0, 1
			');
			if($q01->num_rows() > 0) {
				$r01 = $q01->row_array();
				$output['success'] = true;
				$output['data'] = $q01->row_array();
			}
			else {
				$error[] = 'record not found';
			}
		}
		else {
			$error[] = 'invalid request';
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
	}*/
	public function log_scc()
	{
		date_default_timezone_set('Asia/Jakarta');

		$datestart = date('Y-m-d H:i:s');
		$output = array(
			'success' => false
		);
		$error = array();
		$request = array(
			'ticket' => $this->input->post('ticket') 
		);

		if(
			$this->input->post('ticket') != ''
		) {
			$q01 = $this->db->query('
			SELECT
			CASE WHEN 
					token is null THEN "tidak mendapatkan authentikasi APIGW" 
					WHEN token = 1 AND nd is null THEN "Nomor internet tidak ditemukan, Pastikan ticket di input dengan benar"
						WHEN token = 1 AND nd is not null AND frame_ip IS NULL THEN "tidak mendapat output dari GetIP Radius" 
							WHEN token = 1 AND nd is not null AND frame_ip IS NOT NULL AND ip_addr IS NULL THEN "tidak mendapat output dari MyIP" 
								WHEN token = 1 AND nd is not null AND frame_ip IS NOT NULL AND ip_addr IS NOT NULL AND ip_passed = 0 THEN "tidak dirumah pelanggan" 
									WHEN token = 1 AND nd is not null AND frame_ip IS NOT NULL AND ip_addr IS NOT NULL AND ip_passed = 1 AND onu_rx_pwr IS NULL THEN "tidak mendapat ouput dari iBooster" 
										WHEN token = 1 AND nd is not null AND frame_ip IS NOT NULL AND ip_addr IS NOT NULL AND ip_passed = 1 AND onu_rx_pwr IS NOT NULL AND package_name IS NULL THEN "tidak mendapat ouput dari PCRF" 
											WHEN token = 1 AND nd is not null AND frame_ip IS NOT NULL	AND ip_addr IS NOT NULL AND ip_passed = 1 AND onu_rx_pwr IS NOT NULL AND package_name IS NOT NULL AND speedtest_download IS NULL THEN "hasil speedtest tidak ditemukan" 
											WHEN token = 1 AND nd is not null AND frame_ip IS NOT NULL AND ip_addr IS NOT NULL AND ip_passed = 1 AND onu_rx_pwr IS NOT NULL AND package_name IS NOT NULL AND speedtest_download IS NOT NULL AND CLOSE IS NOT NULL THEN "Success" 
											else "Success"	END msg,x.* 
					FROM (
					SELECT
						uid,
						ticket,
						nd,
						remote_addr,
						token1_log_total_time,
						CASE WHEN bearer1 IS NOT NULL THEN 1 ELSE bearer1 END token,
						frame_ip,
						ip_addr,
						ip_passed,
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
						speedtest_download,
						speedtest_upload,
						speedtest_units,
						speedtest_latency_minimum,
						speedtest_latency_jitter,
						speed_passed,
						CLOSE,
						ts 
				FROM
					task_archive 
				WHERE
					1 = 1 
					AND ticket = '.$this->db->escape($this->input->post('ticket')).'
			UNION ALL
				SELECT
					uid,
					ticket,
					nd,
					remote_addr,
					token1_log_total_time,
					CASE WHEN bearer1 IS NOT NULL THEN 1 ELSE bearer1 END token,
					frame_ip,
					ip_addr,
					ip_passed,
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
					speedtest_download,
					speedtest_upload,
					speedtest_units,
					speedtest_latency_minimum,
					speedtest_latency_jitter,
					speed_passed,
					CLOSE,
					ts 
				FROM
					task_active 
				WHERE
					1 = 1 
					AND ticket = '.$this->db->escape($this->input->post('ticket')).'
					) AS x 
				ORDER BY
					x.CLOSE DESC,
					x.ts DESC 
					LIMIT 0,1
			');
			if($q01->num_rows() > 0) {
				$r01 = $q01->row_array();
				$output['success'] = true;
				$output['Message'] = $r01['msg'];
				$output['data'] = array(
					'uid' => $r01['uid'],
					'ticket' => $r01['ticket'],
					'nd' => $r01['nd'],
					'remote_addr' => $r01['remote_addr'],
					'token1_log_total_time' => $r01['token1_log_total_time'],
					'Auth' => $r01['token'],
					'frame_ip' => $r01['frame_ip'],
					'ip_addr' => $r01['ip_addr'],
					'ip_passed' => $r01['ip_passed'],
					'onu_rx_pwr' => $r01['onu_rx_pwr'],
					'reg_type' => $r01['reg_type'],
					'version_id' => $r01['version_id'],
					'identifier' => $r01['identifier'],
					'redaman_log_total_time' => $r01['redaman_log_total_time'],
					'redaman_passed' => $r01['redaman_passed'],
					'token2_log_total_time' => $r01['token2_log_total_time'],
					'pcrf_log_total_time' => $r01['pcrf_log_total_time'],
					'package_name' => $r01['package_name'],
					'quota_used' => $r01['quota_used'],
					'speedtest_download' => $r01['speedtest_download'],
					'speedtest_upload' => $r01['speedtest_upload'],
					'speedtest_units' => $r01['speedtest_units'],
					'speedtest_latency_minimum' => $r01['speedtest_latency_minimum'],
					'speedtest_latency_jitter' => $r01['speedtest_latency_jitter'],
					'speed_passed' => $r01['speed_passed'],
					'CLOSE' => $r01['CLOSE'],
					'ts' => $r01['ts'],
				); //$q01->row_array();
			}
			else {
				$output['Message'] = 'Not Found';
				$error[] = 'record not found';
			}
		}
		else {
			$error[] = 'invalid request';
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		$ndEx =	isset($r01['nd']) ? $r01['nd'] : null;
		$uid =  isset($r01['uid']) ? $r01['uid'] : null;
	
		$ndEx1 = null;
		if(isset($ndEx) != ''){
			$ndEx = explode('@',$ndEx);
			$ndEx1 = $ndEx[0];
		}else{
			$ndEx1 = null;
		}

	
		$datefinish = date('Y-m-d H:i:s');

		$this->db->query('
			INSERT INTO log_getResult (
				name_api,
				request,
				nd,
				uid,
				response,
				ts_start,
				ts_finish
			)
			VALUES (
				\'getResultFF\',
				'.$this->db->escape(json_encode($request)).',
				'.$this->db->escape($ndEx1).',
				'.$this->db->escape($uid).',
				'.$this->db->escape(json_encode($output)).',
				\''.$datestart.'\',
				\''.$datefinish.'\'
			)
		');

		// echo json_encode($output);
		header('Content-Type: application/json');
		echo json_encode($output, JSON_PRETTY_PRINT);
	}
	
	public function log_scc_ol()
	{
		date_default_timezone_set('Asia/Jakarta');

		$datestart = date('Y-m-d H:i:s');
		$output = array(
			'success' => false
		);
		$error = array();
		$request = array(
			'ticket' => $this->input->post('ticket') 
		);

		if(
			$this->input->post('ticket') != ''
		) {
			$q01 = $this->db->query('
				SELECT 
					* 
				FROM	
					(
						SELECT
							uid,
							ticket,
							nd,
							remote_addr,
							token1_log_total_time,
							frame_ip,
							ip_addr,
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
							speedtest_download,
							speedtest_upload,
							speedtest_units,
							speedtest_latency_minimum,
							speedtest_latency_jitter,
							speed_passed,
							close,
							ts
						FROM
							task_archive
						WHERE
							1 = 1
							AND ticket = '.$this->db->escape($this->input->post('ticket')).'
						UNION ALL
						SELECT
							uid,
							ticket,
							nd,
							remote_addr,
							token1_log_total_time,
							frame_ip,
							ip_addr,
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
							speedtest_download,
							speedtest_upload,
							speedtest_units,
							speedtest_latency_minimum,
							speedtest_latency_jitter,
							speed_passed,
							close,
							ts
						FROM
							task_active
						WHERE
							1 = 1
							AND ticket = '.$this->db->escape($this->input->post('ticket')).'
					) as x
					ORDER BY
						x.close DESC,
						x.ts DESC
					LIMIT 0, 1
			');
			if($q01->num_rows() > 0) {
				$r01 = $q01->row_array();
				$output['success'] = true;
				$output['data'] = $q01->row_array();
			}
			else {
				$error[] = 'record not found';
			}
		}
		else {
			$error[] = 'invalid request';
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		$ndEx =	isset($r01['nd']) ? $r01['nd'] : null;
		$uid =  isset($r01['uid']) ? $r01['uid'] : null;
	
		$ndEx1 = null;
		if(isset($ndEx) != ''){
			$ndEx = explode('@',$ndEx);
			$ndEx1 = $ndEx[0];
		}else{
			$ndEx1 = null;
		}

	
		$datefinish = date('Y-m-d H:i:s');

		$this->db->query('
			INSERT INTO log_getResult (
				name_api,
				request,
				nd,
				uid,
				response,
				ts_start,
				ts_finish
			)
			VALUES (
				\'getResultFF\',
				'.$this->db->escape(json_encode($request)).',
				'.$this->db->escape($ndEx1).',
				'.$this->db->escape($uid).',
				'.$this->db->escape(json_encode($output)).',
				\''.$datestart.'\',
				\''.$datefinish.'\'
			)
		');

		echo json_encode($output);
	}


	public function fizzBuzz()
	{
		$angka = 50;
		for ($i=1; $i <= $angka; $i++) {
			if ($i % 3 == 0 && $i % 5 == 0) {
			 	echo "FizzBuzz <br />";
			} elseif ($i % 3 == 0) {
			 	echo "Fizz <br />";
			} elseif ($i % 5 == 0) {
			 	echo "Buzz <br />";
			} else {
			 	echo  "* <br />";
			}
		}
	}
}