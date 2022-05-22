<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Check extends CI_Controller {
	
	var $whitelistEnabled;
	var $remoteIP;
	
	function __construct() {
		
        parent::__construct();
		$this->remoteIP = $_SERVER['REMOTE_ADDR'];
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$this->remoteIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		header('X-Frame-Options: SAMEORIGIN');
		//$this->remoteIP = '180.242.224.111';
		
	}
	
	public function test123()	{
		echo 113;
	}
	public function index()	{
		
		$this->whitelistEnabled = true;
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
		$qWhitelisted = 0;
		if($token > 0) {
			$qWhitelisted = 1;
		}
		$this->db->query('
			INSERT INTO log_check (
				remote_addr,
				session,
				whitelisted,
				ts
			)
			VALUES (
				'.$this->db->escape($this->remoteIP).',
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
		if($token > 0 || !$this->whitelistEnabled) {
			$uid = time().'.'.sha1(rand(111111,999999));
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', '');
			$this->form_validation->set_rules('ticket', 'Ticket Number', 'required|alpha_numeric');
			if($this->form_validation->run() == false) {
				$error[] = form_error('ticket');
			}
			else {
				$q01 = $this->db->query('
					INSERT INTO task_active (
						uid,
						remote_addr,
						ticket,
						ts
					)
					VALUES (
						'.$this->db->escape($uid).',
						'.$this->db->escape($this->remoteIP).',
						'.$this->db->escape($this->input->post('ticket')).',
						NOW()
					)
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
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}
	
	public function saveWho()	{
		
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
		//$output['ip'] = '155';
		echo json_encode($output);
		
	}
	public function xyzz() {
		$soHeader = array(
			'Content-Type: app/xml',
			'Authorization : Bearer d8a174c9-bf06-3840-bb93-bfa577c853cd'
		);

		$soCh = curl_init();
		curl_setopt($soCh, CURLOPT_URL, 'https://apifactory.telkom.co.id:8243/api/indibox/getUserInfo/1.0/getNDByIP?ip=36.68.44.246');
		curl_setopt($soCh, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($soCh, CURLOPT_HTTPHEADER, $soHeader);
		curl_setopt($soCh, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($soCh, CURLOPT_SSL_VERIFYPEER, FALSE);
		$soResponse = curl_exec($soCh);
		$soInfo = curl_getinfo($soCh);
		$soError = curl_error($soCh);
		curl_close($soCh);

		echo $soResponse.'|'.$soError;
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
					'Content-Type: text/xml',
					'Authorization : Bearer '.$r01['bearer1']
				);
				$nd = null;
				for($iRetry = 0; $iRetry < 5; $iRetry++) {
					$soCh = curl_init();
					curl_setopt($soCh, CURLOPT_URL, 'https://apifactory.telkom.co.id:8243/api/indibox/getUserInfo/1.0/getNDByIP?ip='.$r01['ip_addr']);
					curl_setopt($soCh, CURLOPT_RETURNTRANSFER, TRUE);
					curl_setopt($soCh, CURLOPT_HTTPHEADER, $soHeader);
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
					
					$logRequest = $this->ModelLog->write($tLog.'.ndbyip.request.log', 'https://apifactory.telkom.co.id:8243/api/indibox/getUserInfo/1.0/getNDByIP?ip='.$r01['ip_addr'].PHP_EOL.'========================='.PHP_EOL.'Authorization : Bearer '.$r01['bearer1']);
					
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
						if(isset($jND['ND']) && $jND['ND'] != 'NULL'){
							$nd = $jND['ND'];
							// hardcode - start
							// hardcode - finish
							break;
						}
					}
					else {
						$error[] = $soError;
					}
				}
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
				}
				$q01 = $this->db->query('
					UPDATE task_active SET
						ndbyip_success = '.$this->db->escape($chSuccess).',
						ndbyip_log_request = '.$this->db->escape($fileRequest).',
						ndbyip_log_response = '.$this->db->escape($fileResponse).',
						ndbyip_log_total_time = '.$this->db->escape($total_time).',
						ndbyip_ts = NOW(),
						nd = '.$this->db->escape($nd).'
					WHERE
						1 = 1
						AND uid = '.$this->db->escape($this->session->userdata('uid')).'
				');
				if($nd == null) {
					$q02 = $this->db->query('
						DELETE FROM task_active
						WHERE
							1 = 1
							AND uid =  '.$this->db->escape($this->session->userdata('uid')).'
					');
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
					nd
				FROM
					task_active
				WHERE
					1 = 1
					AND uid = '.$this->db->escape($this->session->userdata('uid')).'
			');
			if($q01->num_rows() > 0) {
				$r01 = $q01->row_array();
				$ndEx = explode('@', $r01['nd']);
				if(count($ndEx) > 1) {
					$passed = 1;
					for($iRetry = 0; $iRetry < 5; $iRetry++) {
						$soBody = '
							<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:soap="http://ibooster.telkom.co.id/api/soap.php">
							   <soapenv:Header/>
							   <soapenv:Body>
								  <soap:ukur_indikasi soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
									 <input xsi:type="ibo:ukur_in" xmlns:ibo="http://10.62.165.36/soap/iBooster">
										<!--You may enter the following 2 items in any order-->
										<nd xsi:type="xsd:string">'.$ndEx[0].'</nd>
										<realm xsi:type="xsd:string">'.$ndEx[1].'</realm>
									 </input>
								  </soap:ukur_indikasi>
							   </soapenv:Body>
							</soapenv:Envelope>
						';
						$soHeader = array(
							'Content-Type: text/xml;charset=UTF-8',
							'SOAPAction: "http://10.62.165.36/air/index.php/ukur_indikasi"',
							'Content-Length: '.strlen($soBody)
						);
						$soCh = curl_init();
						curl_setopt($soCh, CURLOPT_URL, 'http://10.62.165.36/air/index.php');
						curl_setopt($soCh, CURLOPT_POST, TRUE);
						curl_setopt($soCh, CURLOPT_RETURNTRANSFER, TRUE);
						curl_setopt($soCh, CURLOPT_POSTFIELDS, $soBody);
						curl_setopt($soCh, CURLOPT_HTTPHEADER, $soHeader);
						curl_setopt($soCh, CURLOPT_SSL_VERIFYHOST, FALSE);
						curl_setopt($soCh, CURLOPT_SSL_VERIFYPEER, FALSE);
						$soResponse = curl_exec($soCh);
						$soInfo = curl_getinfo($soCh);
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
							$chuccess = 1;
							$doc = new DOMDocument();
							$doc->loadXML($soResponse);
							$el__Envelope = $doc->getElementsByTagName('Envelope')->item(0);
							$el__Body = $el__Envelope->getElementsByTagName('Body')->item(0);
							if($el__Body->getElementsByTagName('ukur_indikasiResponse')->length > 0) {
								$el__ukurResponse = $el__Body->getElementsByTagName('ukur_indikasiResponse')->item(0);
								if($el__ukurResponse->getElementsByTagName('output')->length > 0) {
									$el__output = $el__ukurResponse->getElementsByTagName('output')->item(0);
									if($el__output->getElementsByTagName('onu_rx_pwr')->length > 0) {
										$el__onu_rx_pwr = $el__output->getElementsByTagName('onu_rx_pwr')->item(0);
										$redaman = $el__onu_rx_pwr->nodeValue;
										if($el__output->getElementsByTagName('reg_type')->length > 0) {
											$el__reg_type = $el__output->getElementsByTagName('reg_type')->item(0);
											$reg_type = $el__reg_type->nodeValue;
										}
										if($el__output->getElementsByTagName('version_id')->length > 0) {
											$el__version_id = $el__output->getElementsByTagName('version_id')->item(0);
											$version_id = $el__version_id->nodeValue;
										}
										if($el__output->getElementsByTagName('identifier')->length > 0) {
											$el__identifier = $el__output->getElementsByTagName('identifier')->item(0);
											$identifier = $el__identifier->nodeValue;
										}
									}
									elseif($el__output->getElementsByTagName('MESSAGE')->length > 0) {
										$el__MESSAGE = $el__output->getElementsByTagName('MESSAGE')->item(0);
										$message = $el__MESSAGE->nodeValue;
									}
								}
							}
							if(isset($redaman)) {
								if($redaman < -24 || $redaman > -13) {
									$passed = 0;
								}
								break;
							}
							else {
								if(isset($message)) {
									$error[] = $message;
								}
								else {
									$error[] = 'unable to read onu_rx_pwr element';
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
						$output['data'] = array(
							'redaman_value' => $redaman,
							'redaman_passed' => $passed,
							'redaman_reg_type' => $v01RegType,
							'redaman_version_id' => $v01VersionId,
							'redaman_identifier' => substr($v01identifier, 0, 4)
						);
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
					'Authorization : Bearer '.$r01['bearer2']
				);
				$realm = array(
					'telkom.net',
					'apps.telkom',
					'gold.telkom'
				);
				$x = array();
				for($iRealm = 0; $iRealm < 3; $iRealm++) {
					$soBody = json_encode(array(
						'nd' => $ndEx[0],
						'realm' => $realm[$iRealm]
					));
					if(count($ndEx) > 1) {
						for($iRetry = 0; $iRetry < 5; $iRetry++) {
							$soCh = curl_init();
							curl_setopt($soCh, CURLOPT_URL, 'https://apifactory.telkom.co.id:8243/telkom/pcrf/api/v1.0/getInfoPCRF');
							curl_setopt($soCh, CURLOPT_POST, TRUE);
							curl_setopt($soCh, CURLOPT_RETURNTRANSFER, TRUE);
							curl_setopt($soCh, CURLOPT_POSTFIELDS, $soBody);
							curl_setopt($soCh, CURLOPT_HTTPHEADER, $soHeader);
							curl_setopt($soCh, CURLOPT_SSL_VERIFYHOST, FALSE);
							curl_setopt($soCh, CURLOPT_SSL_VERIFYPEER, FALSE);
							$soResponse = curl_exec($soCh);
							$soInfo = curl_getinfo($soCh);
							$soError = curl_error($soCh);
							curl_close($soCh);
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
							$output['debug'] = array(
								'total_time' => $soInfo
							);
							$chSuccess = 0;
							if($soError == '') {
								$chSuccess = 1;
								try {
									$jPCRF = json_decode($soResponse, true);
								}
								catch(Exception $ex) {
									
								}
								if(
									isset($jPCRF['servicePackageResponse']) 
									&& isset($jPCRF['servicePackageResponse']['ServicePackage']) 
									&& count($jPCRF['servicePackageResponse']['ServicePackage']) > 0
								) {
									$packageName = $jPCRF['servicePackageResponse']['ServicePackage'][0]['NAME'];
								}
								if(
									isset($jPCRF['quotaResponse']) 
									&& isset($jPCRF['quotaResponse']['Quota']) 
									&& isset($jPCRF['quotaResponse']['Quota']['QuotaUsed']) 
								) {
									$quotaUsed = $jPCRF['quotaResponse']['Quota']['QuotaUsed'];
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
	
	
	
	public function retrieveSpeed() {
		
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
					quota_used
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
				$v01Passed = null;
				$v01Incomplete = 1;
				if(isset($passed)) {
					$v01Passed = $passed;
					if($passed == 0) {
						$v01Incomplete = 0;
					}
				}
				//speed_passed = '.$this->db->escape($v01Passed).',
				$q01 = $this->db->query('
					UPDATE task_active SET
						speed_success = '.$this->db->escape($chSuccess).',
						speed_log_request = '.$this->db->escape($fileRequest).',
						speed_log_response = '.$this->db->escape($fileResponse).',
						speed_ts = NOW(),
						speed_test = '.$this->db->escape($v01Speed).',
						speed_passed = \'1\',
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
				nd,
				hash,
				response,
				ts
			)
			VALUES (
				'.$this->db->escape($this->input->post('nd')).',
				'.$this->db->escape($this->input->post('hash')).',
				'.$this->db->escape(json_encode($output)).',
				\''.$date.'\'
			)
		');
		echo json_encode($output);
		
	}
	
}
