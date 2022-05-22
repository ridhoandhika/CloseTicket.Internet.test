<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Check_old extends CI_Controller {
	
	var $whitelistEnabled;
	var $remoteIP;
	
	function __construct() {
		
        parent::__construct();
		$this->remoteIP = $_SERVER['REMOTE_ADDR'];
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$this->remoteIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		header('X-Frame-Options: SAMEORIGIN');
		//$this->remoteIP = '180.242.224.111'; ip public
		
	} 
	
	public function test123()	{
		echo $_SERVER['SERVER_ADDR'];
	}
	public function index()	{
		
		$this->whitelistEnabled = true;
		/*$output = array(
			'success' => false
		);*/

		/*
		if(isset($_GET['whitelist']) && $_GET['whitelist'] == 0) {
			$this->whitelistEnabled = false;
		}
		if(isset($_GET['hardcode'])) {
			$this->session->set_userdata('hardcode', $_GET['hardcode']);
		}
		else {
			$this->session->unset_userdata('hardcode');
		}
		*/
		$token = 0;
		foreach($this->config->item('whitelist') as $cidr) {
			$range = cidrToRange($cidr);
			if(ip2long($range[0]) <= ip2long($this->remoteIP) && ip2long($this->remoteIP) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		//echo $cidr;
		
		$qrange = $cidr;
		$qWhitelisted = 0;
		if($token > 0) {
			$qWhitelisted = 1;
		}
		$this->db->query('
			INSERT INTO log_check (
				remote_addr,
				ip_bras,
				session,
				whitelisted,
				ts
			)
			VALUES (
				'.$this->db->escape($this->remoteIP).',
				'.$this->db->escape($qrange).',
				'.$this->db->escape($this->session->session_id).',
				'.$this->db->escape($qWhitelisted).',
				NOW()
			)
			ON DUPLICATE KEY UPDATE
				ts = VALUES(ts)
		');
		if($token > 0 || !$this->whitelistEnabled) {
			$this->session->set_userdata('ticket', '');
			$this->session->set_userdata('uid', '');
			$this->ModelTemplate->render();

		}
		else {
			redirect('Welcome');
		}
		
	}
	
	public function createTask()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		$token = 0;
		foreach($this->config->item('whitelist') as $cidr) {
			$range = cidrToRange($cidr);
			if(ip2long($range[0]) <= ip2long($this->remoteIP) && ip2long($this->remoteIP) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}

		//server
		//'.$this->db->escape($_SERVER['SERVER_ADDR']).'
		$qrange = $cidr;
		if($token > 0 || !$this->whitelistEnabled) {
			$uid = time().'.'.sha1(rand(111111,999999));
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', '');
			// $this->form_validation->set_rules('ticket', 'Ticket Number', 'required|alpha_numeric');
			// if($this->form_validation->run() == false) {
			// 	$error[] = form_error('ticket');
			// }
			// else {
				$q01 = $this->db->query('
					INSERT INTO task_active (
						uid,
						remote_addr,
						ip_bras,
						ticket,
						ts					
					)
					VALUES (
						'.$this->db->escape($uid).',
						'.$this->db->escape($this->remoteIP).',
						'.$this->db->escape($qrange).',
						'.$this->db->escape($this->input->post('ticket')).',
						NOW()					)
				');
				if($this->db->affected_rows() > 0) {
					$this->session->set_userdata('ticket', $this->input->post('ticket'));
					$this->session->set_userdata('uid', $uid);
					$output['success'] = true;
					$output['data'] = array(
						'uid' => $uid
					);
				}
				else {
					$error[] = 'unable to create task';
				}
			}
		// }
		// if(count($error) > 0) {
		// 	$output['error'] = $error;
		// }
		echo json_encode($output);
		
	}
	
	
	public function saveWhoIP6()	{		
		$output = array(
			'success' => false
		);
		$error = array();
		$token = 0;
		foreach($this->config->item('whitelist') as $cidr) {
			$range = cidrToRange($cidr);
			if(ip2long($range[0]) <= ip2long($this->remoteIP) && ip2long($this->remoteIP) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || !$this->whitelistEnabled) {
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', '');
			$this->form_validation->set_rules('ip_addr', 'IP Address', 'required');
			$this->form_validation->set_rules('response', 'API Response', 'required');
			if($this->form_validation->run() == false) {
				$error[] = form_error('ip_addr');
				$error[] = form_error('response');
			}
			else {
				$fileRequest = null;
				$fileResponse = null;
				$tLog = time().'.'.rand(111111, 999999);
				$logResponse = $this->ModelLog->write($tLog.'.who.response.log', $this->input->post('response'));
				if($logResponse['success']) {
					$fileResponse = $logResponse['data']['file'];
				}
				$ndEx = explode('@', $this->input->post('username'));
				$output['data'] = array(
					'nd' => $ndEx[0], 
					'ticket' => $this->session->userdata('ticket')
					
				);
				$q01 = $this->db->query('
					UPDATE task_active SET
						who_success = '.$this->db->escape($this->input->post('success')).',
						who_log_request = '.$this->db->escape($fileRequest).',
						who_log_response = '.$this->db->escape($fileResponse).',
						who_ts = NOW(),
						ip_addr = '.$this->db->escape($this->input->post('ip_addr')).',
						nd_number = '.$this->db->escape($ndEx[0]).',
						nd = '.$this->db->escape($this->input->post('username')).'
					WHERE
						1 = 1
						AND uid =  '.$this->db->escape($this->session->userdata('uid')).'
				');
				if($this->input->post('ip_addr') && $this->input->post('username') == '') {
					$q02 = $this->db->query('
						DELETE FROM task_active
						WHERE
							1 = 1
							AND uid =  '.$this->db->escape($this->session->userdata('uid')).'
					');
				}
				else {
					$output['success'] = true;
				}
			}
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}

	
	
	public function saveWhoIP4(){
		$output = array(
			'success' => false
		);
		$error = array();
		$token = 0;
		foreach($this->config->item('whitelist') as $cidr) {
			$range = cidrToRange($cidr);
			if(ip2long($range[0]) <= ip2long($this->remoteIP) && ip2long($this->remoteIP) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || !$this->whitelistEnabled) {
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', '');
			$this->form_validation->set_rules('ip_addr', 'IP Address', 'required');
			$this->form_validation->set_rules('response', 'API Response', 'required');
			if($this->form_validation->run() == false) {
				$error[] = form_error('ip_addr');
				$error[] = form_error('response');
			}
			else {
				$fileRequest = null;
				$fileResponse = null;
				$tLog = time().'.'.rand(111111, 999999);
				$logResponse = $this->ModelLog->write($tLog.'.who.response1.log', $this->input->post('response'));
				if($logResponse['success']) {
					$fileResponse = $logResponse['data']['file'];
				}
				$q01 = $this->db->query('
					UPDATE task_active SET
						who_success = '.$this->db->escape($this->input->post('success')).',
						who_log_request = '.$this->db->escape($fileRequest).',
						who_log_response = '.$this->db->escape($fileResponse).',
						who_ts = NOW(),
						ip_addr = '.$this->db->escape($this->input->post('ip_addr')).'
					WHERE
						1 = 1
						AND uid =  '.$this->db->escape($this->session->userdata('uid')).'
				');
				if($this->input->post('ip_addr') == '') {
					$q02 = $this->db->query('
						DELETE FROM task_active
						WHERE
							1 = 1
							AND uid =  '.$this->db->escape($this->session->userdata('uid')).'
					');
				}
				else {
					$output['success'] = true;
				}
			}
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}

	public function retrieveToken1() {
		
		$output = array(
			'success' => false
		);
		$error = array();
		$token = 0;
		foreach($this->config->item('whitelist') as $cidr) {
			$range = cidrToRange($cidr);
			if(ip2long($range[0]) <= ip2long($this->remoteIP) && ip2long($this->remoteIP) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || !$this->whitelistEnabled) {
			$soBody = http_build_query(array(
				'grant_type' => 'client_credentials', 
				'client_id' => '916a4ea5-e308-4662-a387-7c7735799c16', 
				'client_secret' => '73f1cf21-acc7-4aeb-9f27-143d49f32f66' 
			));
			for($iRetry = 0; $iRetry < 5; $iRetry++) {
				$soCh = curl_init();
				$urltoken = 'https://apigw.telkom.co.id:7777/invoke/pub.apigateway.oauth2/getAccessToken';
				curl_setopt($soCh, CURLOPT_URL, $urltoken);
				curl_setopt($soCh, CURLOPT_SSLVERSION, 6);  
				curl_setopt($soCh, CURLOPT_POST, true);
				curl_setopt($soCh, CURLOPT_POSTFIELDS, $soBody);
				curl_setopt($soCh, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($soCh, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($soCh, CURLOPT_SSL_VERIFYPEER, 0);
				$soResponse = curl_exec($soCh);
				$soInfo = curl_getinfo($soCh);
				$soError = curl_error($soCh);
				//$output['debug'] = $soResponse;
				curl_close($soCh);
				$total_time = null;
				if(isset($soInfo['total_time'])){
					$total_time = $soInfo['total_time'];
					$total_time = $total_time * 1000;
				}
				$tLog = time().'.'.rand(111111, 999999);
				$logRequest = $this->ModelLog->write($tLog.'.token1.request.log', $soBody);
				$fileRequest = null;
				if($logRequest['success']) {
					$fileRequest = $logRequest['data']['file'];
				}
				$logResponse = $this->ModelLog->write($tLog.'.token1.response.log', $soResponse.PHP_EOL.'========================='.PHP_EOL.$soError);
				$fileResponse = null;
				if($logResponse['success']) {
					$fileResponse = $logResponse['data']['file'];
				}
				$chSuccess = 0;
				if($soError == '') {
					$chSuccess = 1;
					try {
						$jToken = json_decode($soResponse, true);
					}
					catch(Exception $ex) {
						
					}
					if(isset($jToken['access_token'])) {
						$bearer = $jToken['access_token'];
						break;
					}
				}
				else {
					$error[] = $soError;
				}
			}
			if(isset($bearer)) {
				$output['success'] = true;
				$output['data'] = array(
					//'Bearer' => $bearer
				);
			}
			else {
				$error[] = 'unable to generate token';
			}
			$v01Bearer = null;
			if(isset($bearer)) {
				$v01Bearer = $bearer;
			}
			$q01 = $this->db->query('
				UPDATE task_active SET
					token1_success = '.$this->db->escape($chSuccess).',
					token1_log_request = '.$this->db->escape($fileRequest).',
					token1_log_response = '.$this->db->escape($fileResponse).',
					token1_log_total_time = '.$this->db->escape($total_time).',
					token1_ts = NOW(),
					bearer1 = '.$this->db->escape($v01Bearer).'
				WHERE
					1 = 1
					AND uid = '.$this->db->escape($this->session->userdata('uid')).'
			');
			if(!isset($bearer)) {
				$q02 = $this->db->query('
					DELETE FROM task_active
					WHERE
						1 = 1
						AND uid =  '.$this->db->escape($this->session->userdata('uid')).'
				');
			}
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}

	public function retrieveNDByIP()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		$token = 0;
		foreach($this->config->item('whitelist') as $cidr) {
			$range = cidrToRange($cidr);
			if(ip2long($range[0]) <= ip2long($this->remoteIP) && ip2long($this->remoteIP) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || !$this->whitelistEnabled) {
			$q01 = $this->db->query('
				SELECT
					ip_addr,
					bearer1
				FROM
					task_active
				WHERE
					1 = 1
					AND uid = '.$this->db->escape($this->session->userdata('uid')).'
			');
			if($q01->num_rows() > 0) {
				$r01 = $q01->row_array();
				$soHeader = array(
					'Content-Type: application/json',
					'Authorization: Bearer '.$r01['bearer1']
				);
				$nd = null;
				$nd_number = null;
				for($iRetry = 0; $iRetry < 5; $iRetry++) {
					$soCh = curl_init();
					curl_setopt($soCh, CURLOPT_URL, 'https://apigw.telkom.co.id:7777/gateway/telkom-radius-ip/1.0/getNDByIP?ip='.$r01['ip_addr']);
					curl_setopt($soCh, CURLOPT_RETURNTRANSFER, TRUE);
					curl_setopt($soCh, CURLOPT_HTTPHEADER, $soHeader);
					curl_setopt($soCh, CURLOPT_SSL_VERIFYHOST, FALSE);
					curl_setopt($soCh, CURLOPT_SSL_VERIFYPEER, FALSE);
					$soResponse = curl_exec($soCh);
					$soInfo = curl_getinfo($soCh);
					$httpcode = curl_getinfo($soCh, CURLINFO_HTTP_CODE);
					$soError = curl_error($soCh);
					curl_close($soCh);
					$total_time = null;
					if(isset($soInfo['total_time'])){
						$total_time = $soInfo['total_time'];
						$total_time = $total_time * 1000;
					}
					$tLog = time().'.'.rand(111111, 999999);
					
					$logRequest = $this->ModelLog->write($tLog.'.ndbyip.request.log', 'https://apigw.telkom.co.id:7777/gateway/telkom-radius-ip/1.0/getNDByIP?ip'.$r01['ip_addr'].PHP_EOL.'========================='.PHP_EOL.'Authorization: Bearer '.$r01['bearer1']);
					
					$fileRequest = null;
					if($logRequest['success']) {
						$fileRequest = $logRequest['data']['file'];
					}
					$logResponse = $this->ModelLog->write($tLog.'.ndbyip.response.log', $soResponse.PHP_EOL.'========================='.PHP_EOL.$soError);
					$fileResponse = null;
					if($logRequest['success']) {
						$fileResponse = $logResponse['data']['file'];
					}
					$chSuccess = 0;
					if($soError == '') {
						$chSuccess = 1;
						try {
							$jND= json_decode($soResponse, true);
						}
						catch(Exception $ex) {
							
						}
						// hardcode - start
						//$jND['ND']  = '131183160508';
						// hardcode - finish
						if(isset($jND['data']['ND']) && $jND['data']['ND'] != 'NULL'){
							$nd = $jND['data']['ND'];
							$nd_number = $jND['data']['ND'];
							
							break;
						}
					}
					else {
						$error[] = $soError;
					}
				}
				/* $output['debug'] = array(
					'soHeader' => json_encode($soHeader, true),
					'bearer1' => $r01['bearer1'],
					'soResponse' => $soResponse,
					'IP' => $r01['ip_addr'],
					'ND' => $nd,
					'URL' => 'https://apigw.telkom.co.id:7777/gateway/telkom-radius-ip/1.0/getNDByIP?ip='.$r01['ip_addr']
				); */
				// hardcode
				if($this->session->userdata('hardcode') != '') {
					$nd = $this->session->userdata('hardcode');
				}
				// hardcode
				if($nd != null) {
					$output['success'] = true;
					$output['data'] = array(
						'nd' => $nd,
						'ticket' => $this->session->userdata('ticket')
						
					);
					$nd .= '@telkom.net';
				}else{
					//$output['success'] = true;
					$output['data'] = array(
						'nd' => $nd,
						'ticket' => $this->session->userdata('ticket')
						
					);
				}
				$q01 = $this->db->query('
					UPDATE task_active SET
						ndbyip_success = '.$this->db->escape($chSuccess).',
						ndbyip_log_request = '.$this->db->escape($fileRequest).',
						ndbyip_log_response = '.$this->db->escape($fileResponse).',
						ndbyip_log_total_time = '.$this->db->escape($total_time).',
						ndbyip_ts = NOW(),
						nd = '.$this->db->escape($nd).',
						nd_number = '.$this->db->escape($nd_number).'
					WHERE
						1 = 1
						AND uid = '.$this->db->escape($this->session->userdata('uid')).'
				');
				// if($nd == null) {
				// 	$q02 = $this->db->query('
				// 		DELETE FROM task_active
				// 		WHERE
				// 			1 = 1
				// 			AND uid =  '.$this->db->escape($this->session->userdata('uid')).'
				// 	');
				// }
			}
			else {
				$error[] = 'task not found';
			}
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		
		$output['status'] = $httpcode;
		echo json_encode($output);


		
		
	}
	
	public function retrieveUkur() {
		
		$output = array(
			'success' => false
		);
		$error = array();
		$token = 0;
		foreach($this->config->item('whitelist') as $cidr) {
			$range = cidrToRange($cidr);
			if(ip2long($range[0]) <= ip2long($this->remoteIP) && ip2long($this->remoteIP) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || !$this->whitelistEnabled) {
			$q01 = $this->db->query('
				SELECT
					nd,
					bearer1
				FROM
					task_active
				WHERE
					1 = 1
					AND uid = '.$this->db->escape($this->session->userdata('uid')).'
			');
			if($q01->num_rows() > 0) {
				$r01 = $q01->row_array();
				$soHeader = array(
					'Content-Type: application/json',
					'Authorization: Bearer '.$r01['bearer1']
				);
				
				$realm = array(
					'telkom.net'
				);
				$ndEx = explode('@', $r01['nd']);
				if(count($ndEx) > 1) {
					$passed = null;
					for($iRetry = 0; $iRetry < 5; $iRetry++) {
						
						$field = array(
							'input' => 	array(
								'nd' => $ndEx[0],
								'realm' => $ndEx[1],
							)
						);
						$soBody = json_encode($field, true);
						
						$soCh = curl_init();
						curl_setopt($soCh, CURLOPT_URL, 'https://apigw.telkom.co.id:7777/gateway/telkom-ibooster-iboosterapi/1.0/iBooster/ukur_indikasi');
						curl_setopt($soCh, CURLOPT_POST, TRUE);
						curl_setopt($soCh, CURLOPT_RETURNTRANSFER, TRUE);
						curl_setopt($soCh, CURLOPT_POSTFIELDS, $soBody);
						curl_setopt($soCh, CURLOPT_HTTPHEADER, $soHeader);
						curl_setopt($soCh, CURLOPT_SSL_VERIFYHOST, FALSE);
						curl_setopt($soCh, CURLOPT_SSL_VERIFYPEER, FALSE);
						$soResponse = curl_exec($soCh);
						$soInfo = curl_getinfo($soCh);
						$httpcode = curl_getinfo($soCh, CURLINFO_HTTP_CODE);
						$soError = curl_error($soCh);
						$total_time = null;
						if(isset($soInfo['total_time'])){
							$total_time = $soInfo['total_time'];
							$total_time = $total_time * 1000;
						}
						$tLog = time().'.'.rand(111111, 999999);
						$logRequest = $this->ModelLog->write($tLog.'.ukur.request.log', $soBody);
						$fileRequest = null;
						if($logRequest['success']) {
							$fileRequest = $logRequest['data']['file'];
						}
						$logResponse = $this->ModelLog->write($tLog.'.ukur.response.log', $soResponse.PHP_EOL.'========================='.PHP_EOL.$soError);
						$fileResponse = null;
						if($logResponse['success']) {
							$fileResponse = $logResponse['data']['file'];
						}
						curl_close($soCh);
						$chSuccess = 0;
						
						if($soError == '') {
							$chSuccess = 1;
							try {
								$jUkur = json_decode($soResponse, true);
							}
							catch(Exception $ex) {
								
							}
							if(
								isset($jUkur['onu_rx_pwr']) 
							) {
								$redaman = $jUkur['onu_rx_pwr'];
								$version_id = $jUkur['version_id'];
								$identifier = $jUkur['identifier'];
								$reg_type = $jUkur['reg_type'];
								$nas_ip = $jUkur['nas_ip'];
							}
							if(isset($redaman)) {
								if($redaman < -24 || $redaman > -13) {
									$passed = 0;
								}else if($redaman > -24 || $redaman < -13) {
									$passed = 1;
								} else { $passed = null; }
								break;
							}
							else {
								if(isset($message)) {
									$error[] = $message;
								}
								else {
									$error[] = 'unable to read onu_rx_pwr';
								}
							}
							if(isset($identifier)){
								if(substr($identifier, 0, 4) != 'GPON'){
									$passed = 1;
								}
							}
						}
						else {
							$error[] = $soError;
						}
					}
					$v01Redaman = null;
					$v01RegType = null;
					$v01VersionId = null;
					$v01identifier = null;
					$output['data'] = array(
						'redaman_passed' => $passed,
					);
					
					if(isset($redaman)) {
						$v01Redaman = $redaman;
						if(isset($reg_type)) {
							$v01RegType = $reg_type;
						}
						if(isset($version_id)) {
							$v01VersionId = $version_id;
						}
						if(isset($identifier)) {
							$v01identifier = $identifier;
						}
						$output['success'] = true;
					
						
					}
					$v01Passed = null;
					$v01Incomplete = 1;
					if(isset($passed)) {
						$v01Passed = $passed;
						if($passed == 0) {
							$v01Incomplete = 0;
						}
					}
					/* $output['debug'] = array(
						'soHeader' => json_encode($soHeader, true),
						'bearer1' => $r01['bearer1'],
						'soResponse' => $soResponse
					); */
					$q01 = $this->db->query('
						UPDATE task_active SET
							redaman_success = '.$this->db->escape($chSuccess).',
							redaman_log_request = '.$this->db->escape($fileRequest).',
							redaman_log_response = '.$this->db->escape($fileResponse).',
							redaman_log_total_time = '.$this->db->escape($total_time).',
							redaman_ts = NOW(),
							onu_rx_pwr = '.$this->db->escape($v01Redaman).',
							reg_type = '.$this->db->escape($v01RegType).',
							version_id = '.$this->db->escape($v01VersionId).',
							identifier = '.$this->db->escape($v01identifier).',
							redaman_passed = '.$this->db->escape($v01Passed).',
							incomplete = '.$this->db->escape($v01Incomplete).'
						WHERE
							1 = 1
							AND uid = '.$this->db->escape($this->session->userdata('uid')).'
					');
				}
				else {
					$error[] = 'user data not in email formatted string';
				}
				if(!isset($passed) || $passed == 0) {
					/*
					$q02 = $this->db->query('
						DELETE FROM task_active
						WHERE
							1 = 1
							AND uid =  '.$this->db->escape($this->session->userdata('uid')).'
					');
					*/
				}
			}
			else {
				$error[] = 'task not found';
			}
		}
		
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		
		$output['status'] = $httpcode;
		echo json_encode($output);
		
	}
	
	public function retrieveToken2() {
		
		$output = array(
			'success' => false
		);
		$error = array();
		$token = 0;
		foreach($this->config->item('whitelist') as $cidr) {
			$range = cidrToRange($cidr);
			if(ip2long($range[0]) <= ip2long($this->remoteIP) && ip2long($this->remoteIP) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || !$this->whitelistEnabled) {
			$soBody = http_build_query(array(
				'grant_type' => 'client_credentials',
				'client_id' => '916a4ea5-e308-4662-a387-7c7735799c16',
				'client_secret' => '73f1cf21-acc7-4aeb-9f27-143d49f32f66'
			));
			for($iRetry = 0; $iRetry < 5; $iRetry++) {
				$soCh = curl_init();
				$urltoken = 'https://apigw.telkom.co.id:7777/invoke/pub.apigateway.oauth2/getAccessToken';
				curl_setopt($soCh, CURLOPT_URL, $urltoken);
				curl_setopt($soCh, CURLOPT_SSLVERSION, 6);  
				curl_setopt($soCh, CURLOPT_POST, true);
				curl_setopt($soCh, CURLOPT_POSTFIELDS, $soBody);
				curl_setopt($soCh, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($soCh, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($soCh, CURLOPT_SSL_VERIFYPEER, 0);
				$soResponse = curl_exec($soCh);
				$soInfo = curl_getinfo($soCh);
				$soError = curl_error($soCh);
				//$output['debug'] = $soResponse;
				curl_close($soCh);

				$total_time = null;
				if(isset($soInfo['total_time'])){
					$total_time = $soInfo['total_time'];
					$total_time = $total_time * 1000;
				}
				$tLog = time().'.'.rand(111111, 999999);
				$logRequest = $this->ModelLog->write($tLog.'.token2.request.log', $soBody);
				$fileRequest = null;
				if($logRequest['success']) {
					$fileRequest = $logRequest['data']['file'];
				}
				$logResponse = $this->ModelLog->write($tLog.'.token2.response.log', $soResponse.PHP_EOL.'========================='.PHP_EOL.$soError);
				$fileResponse = null;
				if($logResponse['success']) {
					$fileResponse = $logResponse['data']['file'];
				}
				$chSuccess = 0;
				if($soError == '') {
					$chSuccess = 1;
					try {
						$jToken = json_decode($soResponse, true);
						$bearer = $jToken['access_token'];
					}
					catch(Exception $ex) {
						
					}
					if(isset($bearer)) {
						break;
					}
				}
				else {
					$error[] = $soError;
				}
			}
			if(isset($bearer)) {
				$output['success'] = true;
				/* $output['data'] = array(
					'bearer' => $bearer
				); */
			}
			else {
				$error[] = 'unable to generate token';
			}
			$v01Bearer = null;
			if(isset($bearer)) {
				$v01Bearer = $bearer;
			}
			$q01 = $this->db->query('
				UPDATE task_active SET
					token2_success = '.$this->db->escape($chSuccess).',
					token2_log_request = '.$this->db->escape($fileRequest).',
					token2_log_response = '.$this->db->escape($fileResponse).',
					token2_log_total_time = '.$this->db->escape($total_time).',
					token2_ts = NOW(),
					bearer2 = '.$this->db->escape($v01Bearer).'
				WHERE
					1 = 1
					AND uid = '.$this->db->escape($this->session->userdata('uid')).'
			');
			if(!isset($bearer)) {
				/*
				$q02 = $this->db->query('
					DELETE FROM task_active
					WHERE
						1 = 1
						AND uid =  '.$this->db->escape($this->session->userdata('uid')).'
				');
				*/
			}
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}
	
	public function retrieveToken2_old() {
		
		$output = array(
			'success' => false
		);
		$error = array();
		$token = 0;
		foreach($this->config->item('whitelist') as $cidr) {
			$range = cidrToRange($cidr);
			if(ip2long($range[0]) <= ip2long($this->remoteIP) && ip2long($this->remoteIP) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || !$this->whitelistEnabled) {
			$soBody = http_build_query(array(
				'grant_type' => 'client_credentials'
			));
			for($iRetry = 0; $iRetry < 5; $iRetry++) {
				$soCh = curl_init();
				curl_setopt($soCh, CURLOPT_URL, 'https://apifactory.telkom.co.id:8243/token');
				curl_setopt($soCh, CURLOPT_USERPWD, 'kekvD45HqfxYSJRI9f14JRluUbMa:UBXwy2TLRQfD2cwjSA8m6GQi4gEa');
				curl_setopt($soCh, CURLOPT_POST, TRUE);
				curl_setopt($soCh, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($soCh, CURLOPT_POSTFIELDS, $soBody);
				curl_setopt($soCh, CURLOPT_SSL_VERIFYHOST, FALSE);
				curl_setopt($soCh, CURLOPT_SSL_VERIFYPEER, FALSE);
				$soResponse = curl_exec($soCh);
				$soInfo = curl_getinfo($soCh);
				$soError = curl_error($soCh);
				curl_close($soCh);
				$total_time = null;
				if(isset($soInfo['total_time'])){
					$total_time = $soInfo['total_time'];
					$total_time = $total_time * 1000;
				}
				$tLog = time().'.'.rand(111111, 999999);
				$logRequest = $this->ModelLog->write($tLog.'.token2.request.log', $soBody);
				$fileRequest = null;
				if($logRequest['success']) {
					$fileRequest = $logRequest['data']['file'];
				}
				$logResponse = $this->ModelLog->write($tLog.'.token2.response.log', $soResponse.PHP_EOL.'========================='.PHP_EOL.$soError);
				$fileResponse = null;
				if($logResponse['success']) {
					$fileResponse = $logResponse['data']['file'];
				}
				$chSuccess = 0;
				if($soError == '') {
					$chSuccess = 1;
					try {
						$jToken = json_decode($soResponse, true);
						$bearer = $jToken['access_token'];
					}
					catch(Exception $ex) {
						
					}
					if(isset($bearer)) {
						break;
					}
				}
				else {
					$error[] = $soError;
				}
			}
			if(isset($bearer)) {
				$output['success'] = true;
				$output['data'] = array(
					'bearer' => $bearer
				);
			}
			else {
				$error[] = 'unable to generate token';
			}
			$v01Bearer = null;
			if(isset($bearer)) {
				$v01Bearer = $bearer;
			}
			$q01 = $this->db->query('
				UPDATE task_active SET
					token2_success = '.$this->db->escape($chSuccess).',
					token2_log_request = '.$this->db->escape($fileRequest).',
					token2_log_response = '.$this->db->escape($fileResponse).',
					token2_log_total_time = '.$this->db->escape($total_time).',
					token2_ts = NOW(),
					bearer2 = '.$this->db->escape($v01Bearer).'
				WHERE
					1 = 1
					AND uid = '.$this->db->escape($this->session->userdata('uid')).'
			');
			if(!isset($bearer)) {
				/*
				$q02 = $this->db->query('
					DELETE FROM task_active
					WHERE
						1 = 1
						AND uid =  '.$this->db->escape($this->session->userdata('uid')).'
				');
				*/
			}
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}
	
	public function retrievePCRF() {
		
		$output = array(
			'success' => false
		);
		$error = array();
		$token = 0;
		foreach($this->config->item('whitelist') as $cidr) {
			$range = cidrToRange($cidr);
			if(ip2long($range[0]) <= ip2long($this->remoteIP) && ip2long($this->remoteIP) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || !$this->whitelistEnabled) {
			$q01 = $this->db->query('
				SELECT
					nd,
					nd_number,
					bearer2
				FROM
					task_active
				WHERE
					1 = 1
					AND uid = '.$this->db->escape($this->session->userdata('uid')).'
			');
			if($q01->num_rows() > 0) {
				$r01 = $q01->row_array();
				// hardcode - start
				// $r01['decrypted_userid'] = '121707100209@telkom.net';
				// hardcode - finish
				$ndEx = explode('@', $r01['nd']);
				$soHeader = array(
					'Content-Type: application/json',
					'Authorization: Bearer '.$r01['bearer2']
				);
				$field = array(
					'serviceNumber' => $r01['nd_number']
				);
				$soBody = json_encode($field, true);
				$realm = array(
					'telkom.net'
				);
				$x = array();
				for($iRealm = 0; $iRealm < 1; $iRealm++) {
					
					if(count($ndEx) > 1) {
						for($iRetry = 0; $iRetry < 5; $iRetry++) {
							
							$soCh = curl_init();
							curl_setopt($soCh, CURLOPT_URL, 'https://apigw.telkom.co.id:7777/gateway/telkom-pcrf-usageDetail/1.0/getInfoUsageDetail');
							curl_setopt($soCh, CURLOPT_POST, TRUE);
							curl_setopt($soCh, CURLOPT_RETURNTRANSFER, TRUE);
							curl_setopt($soCh, CURLOPT_POSTFIELDS, $soBody);
							curl_setopt($soCh, CURLOPT_HTTPHEADER, $soHeader);
							curl_setopt($soCh, CURLOPT_SSL_VERIFYHOST, FALSE);
							curl_setopt($soCh, CURLOPT_SSL_VERIFYPEER, FALSE);
							$soResponse = curl_exec($soCh);
							$soInfo = curl_getinfo($soCh);
							$httpcode = curl_getinfo($soCh, CURLINFO_HTTP_CODE);
							$soError = curl_error($soCh);
							curl_close($soCh);
							$output['status'] = $httpcode;
							$total_time = null;
							if(isset($soInfo['total_time'])){
								$total_time = $soInfo['total_time'];
								//$total_time = $total_time * 1000;
							}
							$tLog = time().'.'.rand(111111, 999999);
							$logRequest = $this->ModelLog->write($tLog.'.pcrf.request.log', $soBody.PHP_EOL.'========================='.PHP_EOL.$r01['bearer2']);
							$fileRequest = null;
							if($logRequest['success']) {
								$fileRequest = $logRequest['data']['file'];
							}
							$logResponse = $this->ModelLog->write($tLog.'.pcrf.response.log', $soResponse.PHP_EOL.'========================='.PHP_EOL.$soError);
							$fileResponse = null;
							if($logRequest['success']) {
								$fileResponse = $logResponse['data']['file'];
							}
							/* $output['debug'] = array(
								'soHeader' => json_encode($soHeader, true),
								'soBody' => $soBody,
								'bearer2' => $r01['bearer2'],
								'nd_number' => $r01['nd_number'],
								'soResponse' => $soResponse
							); */
							$chSuccess = 0;
							if(
								$soError == '' 
								OR $httpcode = '200'
							) {
								$chSuccess = 1;
								try {
									$jPCRF = json_decode($soResponse, true);
								}
								catch(Exception $ex) {
									
								}
								if(
									isset($jPCRF['data']) 
									&& isset($jPCRF['data']['getInfoUsageResponse']) 
								) {
									if(isset($jPCRF['data']['getInfoUsageResponse']['package'])){
										$packageName = $jPCRF['data']['getInfoUsageResponse']['package'];
									} else {
										$packageName = null;
									}
									
									
									//-- hardcode
									//$packageName = null;
									//-- hardcode

								} 
								 
								if(
									isset($jPCRF['data']) 
									&& isset($jPCRF['data']['getInfoUsageResponse']) 
								) {
									if(isset($jPCRF['data']['getInfoUsageResponse']['package'])){
										$quotaUsed = $jPCRF['data']['getInfoUsageResponse']['usage'];
									} else {
										$quotaUsed = null;
									}

									
									//-- hardcode
									//$quotaUsed = null;
									//-- hardcode

								} 
								if(isset($packageName)) {
									$q02 = $this->db->query('
										UPDATE task_active
										SET
											nd = '.$this->db->escape($ndEx[0].'@'.$realm[$iRealm]).'
										WHERE
											1 = 1
											AND uid = '.$this->db->escape($this->session->userdata('uid')).'
									');
									break 2;
								}
								else {
									//$packageName = null;

									$error[] = 'unable to get combination of package and quota';
								}
							}
							else {
								$error[] = $eToken;
							}
						}
					}
					else {
						$error[] = 'user data not in email formatted string';
					}
				}
				if(isset($packageName)) {
					$output['success'] = true;
					$output['data'] = array(
						'package_name' => $packageName
					);
				} 
				$v01PackageName = null;
				if(isset($packageName)) {
					$v01PackageName = $packageName;
				}
				$v01QuotaUsed = null;
				if(isset($quotaUsed)) {
					$v01QuotaUsed = $quotaUsed;
				}
				$q01 = $this->db->query('
					UPDATE task_active SET
						pcrf_success = '.$this->db->escape($chSuccess).',
						pcrf_log_request = '.$this->db->escape($fileRequest).',
						pcrf_log_response = '.$this->db->escape($fileResponse).',
						pcrf_log_total_time = '.$this->db->escape($total_time).',
						pcrf_ts = NOW(),
						package_name = '.$this->db->escape($v01PackageName).',
						quota_used = '.$this->db->escape($v01QuotaUsed).'
					WHERE
						1 = 1
						AND uid = '.$this->db->escape($this->session->userdata('uid')).'
				');
				if(!isset($packageName) || !isset($quotaUsed)) {
					/*
					$q02 = $this->db->query('
						DELETE FROM task_active
						WHERE
							1 = 1
							AND uid =  '.$this->db->escape($this->session->userdata('uid')).'
					');
					*/
				}
			}
			else {
				$error[] = 'task not found';
			}
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		
		echo json_encode($output);
		
	}
	
	public function retrieveSpeedOokla() {
	
		$output = array(
		'success' => false
		);

		$error = array();
		$token = 0;
		foreach($this->config->item('whitelist') as $cidr) {
			$range = cidrToRange($cidr);
			if(ip2long($range[0]) <= ip2long($this->remoteIP) && ip2long($this->remoteIP) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || !$this->whitelistEnabled) {
			$q01 = $this->db->query('	
				SELECT
					b.ip_bras,
					speedtest
				FROM
					log_check a
				INNER JOIN mapping_ookla b on a.ip_bras=b.ip_bras
				WHERE 
					a.remote_addr = '.$this->db->escape($this->remoteIP).'
				order By ts DESC
				LIMIT 1
			');
			if($q01->num_rows() > 0) {
			 	$r01 = $q01->row_array();
				$output['success'] = true;
				$output['data'] = array(
					'speedtest' => $r01['speedtest']
				);

			}
			if(count($error) > 0) {
				$output['error'] = $error;
			}
			echo json_encode($output);
		}
	}	

	public function retrieveSpeed_old() {
		$output['success'] = true;
		$output['data'] = array(
			'speed_passed' => 1//$passed
		);
		 $this->db->query('
				UPDATE task_active SET
				
					speedtest_download = \'Bypass\',
					speed_passed = 1
				
				WHERE
					1 = 1
					AND uid = '.$this->db->escape($this->session->userdata('uid')).'
			');

		echo json_encode($output);
	}

	public function retrieveSpeed() {
		$spd = json_decode(file_get_contents('php://input'), true);
		
		if(isset($spd['download'])){
			var_dump($spd['download']);
		}else {
			var_dump($spd['dl']);
		}
	}

	public function retrieveSpeed_oldd() {
	
		$output = array(
			'success' => false
		);
		$error = array();
		$token = 0;
		foreach($this->config->item('whitelist') as $cidr) {
			$range = cidrToRange($cidr);
			if(ip2long($range[0]) <= ip2long($this->remoteIP) && ip2long($this->remoteIP) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || !$this->whitelistEnabled) {
			$q01 = $this->db->query('
				SELECT
					nd,
					reg_type,
					version_id,
					package_name,
					quota_used,
					pcrf_success
				FROM
					task_active
				WHERE
					1 = 1
					AND uid = '.$this->db->escape($this->session->userdata('uid')).'
			');
			if($q01->num_rows() > 0) {
				$r01 = $q01->row_array();
				
				
					
				
				//old
				//$checkDevice = false;
				$checkDevice = true;
				$q01b = $this->db->query('
					SELECT
						COUNT(*) AS check_device
					FROM
						speed_device
					WHERE
						1 = 1
						AND reg_type = '.$this->db->escape($r01['reg_type']).'
						AND (
							check_version = 0
							OR version_id = '.$this->db->escape($r01['version_id']).'
						)
				');
				if($q01b->num_rows() > 0) {
					$r01b = $q01b->row_array();
					if($r01b['check_device'] > 0) {
						$checkDevice = true;
					}
				}
				// hardcode - start
				//$r01['nd'] = '122325220444@telkom.net';
				// hardcode - finish
				$checkQuota = true;
				if($r01['quota_used'] != null) {
					$checkQuota = true;
				}
				if($checkDevice && $checkQuota) {
					$chSuccess = 0;
					try {
						$payload = json_decode(file_get_contents('php://input'), true);
						$chSuccess = 1;
					}
					catch(Exception $x) {
						
					}

					
					$fileRequest = null;
					$fileResponse = null;
					$tLog = time().'.'.rand(111111, 999999);
					$logResponse = $this->ModelLog->write($tLog.'.speed.response.log', file_get_contents('php://input'));
					if($logResponse['success']) {
						$fileResponse = $logResponse['data']['file'];
					}
					if(isset($payload) && isset($payload['download'])) {
						$speed = round($payload['download'] / 1.024) / 1000;
						$q02 = $this->db->query('
							SELECT
								speed_requirement(
									'.$this->db->escape($r01['package_name']).',
									'.$this->db->escape($r01['quota_used']).',
									'.$this->db->escape($speed).'
								) AS fup
						');
						if($q02->num_rows() > 0) {
							$r02 = $q02->row_array();
							if($r02['fup'] != null) {
								$passed = $r02['fup'];
							}
						}
					}
					
					if(
						$r01['pcrf_success'] == 1 
						AND $r01['package_name'] == null 
						AND $r01['quota_used'] == null
					){
						$passed = 1;
					}
					
				}
				else {
					$xToken = 0;
					if(!$checkDevice) {
						$passed = 3;
						$xToken++;
					}
					elseif(!$checkQuota) {
						$passed = 2;
						$xToken++;
					}
					if($xToken > 0) {
						$chSuccess = 1;
						$fileRequest = null;
						$fileResponse = null;
					}
				}
				if(isset($passed) && (isset($speed) || !$checkDevice || !$checkQuota)) {
					$output['success'] = true;
					$output['data'] = array(
						'speed_passed' => $passed
					);
				}
				$v01Speed = null;
				$v01speedtest_download = null;
				$v01speedtest_upload = null;
				$v01speedtest_units = null;
				$v01speedtest_latency_minimum = null;
				$v01speedtest_latency_jitter = null;
				if(isset($speed)) {
					$v01Speed = $speed;
					$v01speedtest_download = $payload['download'];
					$v01speedtest_upload = $payload['upload'];
					$v01speedtest_units = $payload['units'];
					$v01speedtest_latency_minimum = $payload['latency']['minimum'];
					$v01speedtest_latency_jitter = $payload['latency']['jitter'];
				}
				$v01Passed = null;
				$v01Incomplete = 1;
				if(isset($passed)) {
					$v01Passed = $passed;
					if($passed == 0) {
						$v01Incomplete = 0;
					}
				}
				$q01 = $this->db->query('
					UPDATE task_active SET
						speed_success = '.$this->db->escape($chSuccess).',
						speed_log_request = '.$this->db->escape($fileRequest).',
						speed_log_response = '.$this->db->escape($fileResponse).',
						speed_ts = NOW(),
						speed_test = '.$this->db->escape($v01Speed).',
						speed_passed = '.$this->db->escape($v01Passed).',
						speedtest_download = '.$this->db->escape($v01speedtest_download).',
						speedtest_upload = '.$this->db->escape($v01speedtest_upload).',
						speedtest_units = '.$this->db->escape($v01speedtest_units).',
						speedtest_latency_minimum = '.$this->db->escape($v01speedtest_latency_minimum).',
						speedtest_latency_jitter = '.$this->db->escape($v01speedtest_latency_jitter).',
						incomplete = '.$this->db->escape($v01Incomplete).'
					WHERE
						1 = 1
						AND uid = '.$this->db->escape($this->session->userdata('uid')).'
				');
				if(!isset($passed) || $passed == 0) {
					$q02 = $this->db->query('
						DELETE FROM task_active
						WHERE
							1 = 1
							AND uid =  '.$this->db->escape($this->session->userdata('uid')).'
					');
				}
			}
			else {
				$error[] = 'unable to decrypt message';
			}
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}
	
	public function retrieveSpeedAcsis() {
		
		$output['success'] = true;
		$output['data'] = array(
			'speed' => '-',
			'message' => '-'
		);
		echo json_encode($output);
	}
	
	public function retrieveSpeedAcsis_old() {
		
		$output = array(
			'success' => false
		);
		$error = array();
		$token = 0;
		foreach($this->config->item('whitelist') as $cidr) {
			$range = cidrToRange($cidr);
			if(ip2long($range[0]) <= ip2long($this->remoteIP) && ip2long($this->remoteIP) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || !$this->whitelistEnabled) {
			$q01 = $this->db->query('
				SELECT
					nd,
					bearer1
				FROM
					task_active
				WHERE
					1 = 1
					AND uid = '.$this->db->escape($this->session->userdata('uid')).'
			');
			if($q01->num_rows() > 0) {
				$r01 = $q01->row_array();
				
				// hardcode - start
				//$r01['nd'] = '122325220444@telkom.net';
				// hardcode - finish
				
				$soHeader = array(
					'Content-Type: application/json',
					'Authorization: Bearer '.$r01['bearer1']
				);
				
				$field = array(
					'internet_number' => $r01['nd']
				);
				$soBody = json_encode($field, true);
				for($iRetry = 0; $iRetry < 5; $iRetry++) {
					$soCh = curl_init();
					curl_setopt($soCh, CURLOPT_URL, 'https://apigw.telkom.co.id:7777/gateway/telkom-iBooster-pengukuran/1.0/speedTestDownload');
					curl_setopt($soCh, CURLOPT_POST, TRUE);
					curl_setopt($soCh, CURLOPT_RETURNTRANSFER, TRUE);
					curl_setopt($soCh, CURLOPT_POSTFIELDS, $soBody);
					curl_setopt($soCh, CURLOPT_HTTPHEADER, $soHeader);
					curl_setopt($soCh, CURLOPT_SSL_VERIFYHOST, FALSE);
					curl_setopt($soCh, CURLOPT_SSL_VERIFYPEER, FALSE);
					$soResponse = curl_exec($soCh);
					$soError = curl_error($soCh);
					curl_close($soCh);
					$tLog = time().'.'.rand(111111, 999999);
					$logRequest = $this->ModelLog->write($tLog.'.speed-acsis.request.log', $soBody);
					$fileRequest = null;
					if($logRequest['success']) {
						$fileRequest = $logRequest['data']['file'];
					}
					$logResponse = $this->ModelLog->write($tLog.'.speed-acsis.response.log', $soResponse.PHP_EOL.'========================='.PHP_EOL.$soError);
					$fileResponse = null;
					if($logResponse['success']) {
						$fileResponse = $logResponse['data']['file'];
					}

					//hardcode - finish
					$chSuccess = 0;
					$speed = 0;
					if($soError == '') {
						$chSuccess = 1;
						try {
							$jSpeed = json_decode($soResponse, true);
						}
						catch(Exception $ex) {
							
						}
						if(
							($jSpeed['returnMessage'] == true)
							&& isset($jSpeed['data']['Speed'])
						) {
							$speed = $jSpeed['data']['Speed'];
							$message = $jSpeed['data']['Message'];
						}
						if(isset($speed)) {
							$passed = 1;
						}
					}
					else {
						$error[] = $soError;
					}
				}
				
				$v01Speed = 0;
				if(isset($speed)) {
					$v01Speed = $speed;
				}
				$v01message = NULL;
				if(isset($message)) {
					$v01message = $message;
				}
				if(isset($speed)) {
					$output['success'] = true;
					$output['data'] = array(
						'speed' => $v01Speed,
						'message' => $v01message
					);
				}
				$q01 = $this->db->query('
					INSERT INTO speedtest_acsis (
						uid_task,
						speedtest_download,
						speedtest_message,
						speedtest_request,
						speedtest_response,
						ts
					)
					VALUES (
						'.$this->db->escape($this->session->userdata('uid')).',
						'.$this->db->escape($v01Speed).',
						'.$this->db->escape($v01message).',
						'.$this->db->escape($fileRequest).',
						'.$this->db->escape($fileResponse).',
						NOW()
					)
				');
			}
			else {
				$error[] = 'unable to decrypt message';
			}
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}
	
	public function retrieveClose()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		$token = 0;
		foreach($this->config->item('whitelist') as $cidr) {
			$range = cidrToRange($cidr);
			if(ip2long($range[0]) <= ip2long($this->remoteIP) && ip2long($this->remoteIP) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || !$this->whitelistEnabled) {
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', '');
			$this->form_validation->set_rules('close', 'Close Ticket', 'required|numeric');
			if($this->form_validation->run() == false) {
				$error[] = form_error('close');
			}
			else {
				$q01 = $this->db->query('
					UPDATE task_active
					SET
						close = '.$this->db->escape($this->input->post('close')).',
						incomplete = 0
					WHERE
						1 = 1
						AND uid =  '.$this->db->escape($this->session->userdata('uid')).'
						AND redaman_passed > 0
						AND speed_passed > 0
				');
				if($this->db->affected_rows() > 0) {
					$output['success'] = true;
					$output['data'] = array(
						'close' => $this->input->post('close')
					);
					$q02 = $this->db->query('
						DELETE FROM task_active
						WHERE
							1 = 1
							AND uid =  '.$this->db->escape($this->session->userdata('uid')).'
					');
				}
				else {
					$error[] = 'unable to set close flag';
				}
			}
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}
	
	public function getResult()	{
		$date = date('Y-m-d H:i:s');
		$output = array(
			'success' => false
		);
		$error = array();
		if(
			$this->input->post('nd') != ''
			&& $this->input->post('hash') != ''
			&& sha1('INFOMEDIA#'.$this->input->post('nd').'#NUSANTARA') == $this->input->post('hash')
		) {
			$q01 = $this->db->query('
				SELECT
					ticket,
					nd,
					redaman_passed,
					speed_passed,
					close
				FROM
					task_archive
				WHERE
					1 = 1
					AND DATE(ts) = DATE(NOW())
					AND nd = '.$this->db->escape($this->input->post('nd')).'
				ORDER BY
					ts DESC
				LIMIT 0, 1
			');
			if($q01->num_rows() > 0) {
				$r01 = $q01->row_array();
				$output['success'] = true;
				$output['data'] = array(
					'ticket' => $r01['ticket'],
					'nd' => $r01['nd'],
					'redaman_passed' => $r01['redaman_passed'],
					'speed_passed' => $r01['speed_passed'],
					'close' => $r01['close']
				);
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
		$q02 = $this->db->query('
			INSERT INTO log_getResult (
				name_api,
				nd,
				hash,
				response,
				ts_start,
				ts_finish
			)
			VALUES (
				\'getResult\',
				'.$this->db->escape($this->input->post('nd')).',
				'.$this->db->escape($this->input->post('hash')).',
				'.$this->db->escape(json_encode($output)).',
				\''.$datestart.'\',
				NOW()
			)
		');
		echo json_encode($output);
		
	}
	
	public function getResultSCC()	{
		$datestart = date('Y-m-d H:i:s');
		$output = array(
			'success' => false
		);
		$error = array();
		if(
			$this->input->post('ticket') != '' || $this->input->post('nd') != ''
			&& $this->input->post('hash') != ''
			&& sha1('INFOMEDIA#'.$this->input->post('nd').'#NUSANTARA') == $this->input->post('hash')
		) {
			$q01 = $this->db->query('
				SELECT 
					* 
				FROM	
					(
						SELECT
							ticket,
							nd,
							redaman_passed,
							speed_passed,
							close,
							ts
						FROM
							task_archive
						WHERE
							1 = 1							
							
							AND DATE(ts) = DATE(NOW())  
							AND (
								'.$this->db->escape('').' = '.$this->db->escape($this->input->post('ticket')).'
								OR '.$this->db->escape($this->input->post('ticket')).' IS NULL
								OR ticket = '.$this->db->escape($this->input->post('ticket')).'
							)
							AND (
								'.$this->db->escape('').' = '.$this->db->escape($this->input->post('nd')).'
								OR '.$this->db->escape($this->input->post('nd')).' IS NULL
								OR nd_number = '.$this->db->escape($this->input->post('nd')).'
							)
						UNION ALL
						SELECT
							ticket,
							nd,
							redaman_passed,
							speed_passed,
							close,
							ts
						FROM
							task_active
						WHERE
							1 = 1
							
							AND DATE(ts) = DATE(NOW())  
							AND (
								'.$this->db->escape('').' = '.$this->db->escape($this->input->post('ticket')).'
								OR '.$this->db->escape($this->input->post('ticket')).' IS NULL
								OR ticket = '.$this->db->escape($this->input->post('ticket')).'
							)
							AND (
								'.$this->db->escape('').' = '.$this->db->escape($this->input->post('nd')).'
								OR '.$this->db->escape($this->input->post('nd')).' IS NULL
								OR nd_number = '.$this->db->escape($this->input->post('nd')).'
							)

					) as x
				ORDER BY
					x.close DESC,
					x.ts DESC
				LIMIT 0, 1
			');
			if($q01->num_rows() > 0) {
				$r01 = $q01->row_array();
				$output['success'] = true;
				$output['data'] = array(
					'ticket' => $r01['ticket'],
					'nd' => $r01['nd'],
					'redaman_passed' => $r01['redaman_passed'],
					'speed_passed' => $r01['speed_passed'],
					'close' => $r01['close']
				);
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
 		$q02 = $this->db->query('
			INSERT INTO log_getResult (
				name_api,
				nd,
				hash,
				response,
				ts_start,
				ts_finish
			)
			VALUES (
				\'getResultSCC\',
				'.$this->db->escape($this->input->post('nd')).',
				'.$this->db->escape($this->input->post('hash')).',
				'.$this->db->escape(json_encode($output)).',
				\''.$datestart.'\',
				NOW()
			)
		');
		echo json_encode($output);
		
	}
	
}
