<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	
	var $hardcode;
	
	function __construct() {
		
        parent::__construct();
		$this->hardcode = array(
			array('ticket' => 'IN55256167', 'nd' => '172420213610'),
			array('ticket' => 'IN55324460', 'nd' => '152412912129'),
			array('ticket' => 'IN55275228', 'nd' => '172415806237'),
			array('ticket' => 'IN12345678', 'nd' => '122431209260'),
			array('ticket' => 'IN55286969', 'nd' => '122847205495'),
			array('ticket' => 'IN55265447', 'nd' => '122409296191'),
			array('ticket' => 'IN55265170', 'nd' => '111605111130'),
			array('ticket' => 'IN55264989', 'nd' => '121116209467'),
			array('ticket' => 'IN55264554', 'nd' => '111601151672'),
			array('ticket' => 'IN55264337', 'nd' => '172324501374'),
			array('ticket' => 'IN55264777', 'nd' => '161601221913'),
			array('ticket' => 'IN55263266', 'nd' => '162401318469'),
			array('ticket' => 'IN55262885', 'nd' => '121517203384'),
			array('ticket' => 'IN55262749', 'nd' => '161102209439'),
			array('ticket' => 'IN55262714', 'nd' => '172401229642'),
			array('ticket' => 'IN55262479', 'nd' => '171303103964'),
			array('ticket' => 'IN55262378', 'nd' => '152611213094'),
			array('ticket' => 'IN55262264', 'nd' => '172420229403'),
			array('ticket' => 'IN55262240', 'nd' => '122242251847'),
			array('ticket' => 'IN55261857', 'nd' => '172208210648'),
			array('ticket' => 'IN55261697', 'nd' => '142505102004'),
			array('ticket' => 'IN55261408', 'nd' => '172502202553'),
			array('ticket' => 'IN55261256', 'nd' => '162619204568'),
			array('ticket' => 'IN55261222', 'nd' => '131242113527'),
			array('ticket' => 'IN55261165', 'nd' => '131182106240'),
			array('ticket' => 'IN55260963', 'nd' => '111416108863'),
			array('ticket' => 'IN55260836', 'nd' => '121703202868'),
			array('ticket' => 'IN55260640', 'nd' => '172120800495'),
			array('ticket' => 'IN55260033', 'nd' => '122110264955'),
			array('ticket' => 'IN55259200', 'nd' => '152412902202'),
			array('ticket' => 'IN55258980', 'nd' => '121519215453'),
			array('ticket' => 'IN55258851', 'nd' => '131313122217'),
			array('ticket' => 'IN55258741', 'nd' => '122328220733'),
			array('ticket' => 'IN55258662', 'nd' => '121869205283'),
			array('ticket' => 'IN55258628', 'nd' => '111411102988'),
			array('ticket' => 'IN55258420', 'nd' => '152611214166'),
			array('ticket' => 'IN55258223', 'nd' => '121118210217'),
			array('ticket' => 'IN55258165', 'nd' => '162603300538'),
			array('ticket' => 'IN55257858', 'nd' => '162503900333'),
			array('ticket' => 'IN55257684', 'nd' => '122207227871'),
			array('ticket' => 'IN55257660', 'nd' => '142137100899'),
			array('ticket' => 'IN55257444', 'nd' => '131184156983'),
			array('ticket' => 'IN55257404', 'nd' => '152305122413'),
			array('ticket' => 'IN55257059', 'nd' => '111102106663'),
			array('ticket' => 'IN55256841', 'nd' => '122861212776'),
			array('ticket' => 'IN55256795', 'nd' => '122121209241'),
			array('ticket' => 'IN55256760', 'nd' => '152611206759'),
			array('ticket' => 'IN55256705', 'nd' => '122117234310'),
			array('ticket' => 'IN55256637', 'nd' => '121869214349'),
			array('ticket' => 'IN55256445', 'nd' => '142410300265'),
			array('ticket' => 'IN55256384', 'nd' => '152401290742'),
			array('ticket' => 'IN55256295', 'nd' => '152604216761'),
			array('ticket' => 'IN55255995', 'nd' => '111213129481'),
			array('ticket' => 'IN55255823', 'nd' => '122861219397'),
			array('ticket' => 'IN55255602', 'nd' => '111501207731'),
			array('ticket' => 'IN55255420', 'nd' => '162609202101'),
			array('ticket' => 'IN55255337', 'nd' => '111501100592'),
			array('ticket' => 'IN55255309', 'nd' => '122844216055'),
			array('ticket' => 'IN55255269', 'nd' => '121701001038'),
			array('ticket' => 'IN55255379', 'nd' => '121101209713'),
			array('ticket' => 'IN55255113', 'nd' => '111511209505'),
			array('ticket' => 'IN55255169', 'nd' => '143113114928'),
			array('ticket' => 'IN55255001', 'nd' => '122861220718'),
			array('ticket' => 'IN55254994', 'nd' => '131165147736'),
			array('ticket' => 'IN55254915', 'nd' => '131183146177'),
			array('ticket' => 'IN55254600', 'nd' => '142212111964'),
			array('ticket' => 'IN55254466', 'nd' => '172705215910'),
			array('ticket' => 'IN55254442', 'nd' => '152743207096'),
			array('ticket' => 'IN55254309', 'nd' => '131184161748'),
			array('ticket' => 'IN55254288', 'nd' => '122861237983'),
			array('ticket' => 'IN55254124', 'nd' => '146212100224'),
			array('ticket' => 'IN55254264', 'nd' => '122438304222'),
			array('ticket' => 'IN55253979', 'nd' => '152744207503'),
			array('ticket' => 'IN55253831', 'nd' => '172115215684'),
			array('ticket' => 'IN55253827', 'nd' => '152319211469'),
			array('ticket' => 'IN55253268', 'nd' => '152744216898'),
			array('ticket' => 'IN55253177', 'nd' => '141505123707'),
			array('ticket' => 'IN55252837', 'nd' => '172108205817'),
			array('ticket' => 'IN55251912', 'nd' => '152404327777'),
			array('ticket' => 'IN55250729', 'nd' => '152640200456'),
			array('ticket' => 'IN55250755', 'nd' => '152451901267'),
			array('ticket' => 'IN55250554', 'nd' => '122423200486'),
			array('ticket' => 'IN55250141', 'nd' => '152315252935'),
			array('ticket' => 'IN55249956', 'nd' => '172414203093'),
			array('ticket' => 'IN55249321', 'nd' => '172708204777'),
			array('ticket' => 'IN55248972', 'nd' => '111720101580'),
			array('ticket' => 'IN55248913', 'nd' => '162302302818'),
			array('ticket' => 'IN55248611', 'nd' => '111213209041'),
			array('ticket' => 'IN55247636', 'nd' => '172420237282'),
			array('ticket' => 'IN55247495', 'nd' => '172101007110'),
			array('ticket' => 'IN55246939', 'nd' => '111705103308'),
			array('ticket' => 'IN55246616', 'nd' => '111707100046'),
			array('ticket' => 'IN55246107', 'nd' => '111224109737'),
			array('ticket' => 'IN55244975', 'nd' => '172402805944'),
			array('ticket' => 'IN55244595', 'nd' => '152404325267'),
			array('ticket' => 'IN55243206', 'nd' => '131172146810'),
			array('ticket' => 'IN55243014', 'nd' => '172605209015'),
			array('ticket' => 'IN55242784', 'nd' => '111418200769'),
			array('ticket' => 'IN55242724', 'nd' => '152730209713'),
			array('ticket' => 'IN55242209', 'nd' => '122420217519'),
			array('ticket' => 'IN55242110', 'nd' => '111123101748'),
			array('ticket' => 'IN55241155', 'nd' => '152611215030'),
			array('ticket' => 'IN55240941', 'nd' => '152324201850'),
			array('ticket' => 'IN55240168', 'nd' => '172106207184'),
			array('ticket' => 'IN55240051', 'nd' => '152317301835'),
			array('ticket' => 'IN55239886', 'nd' => '111605119987'),
			array('ticket' => 'IN55237904', 'nd' => '111209105910'),
			array('ticket' => 'IN55236595', 'nd' => '111708116071'),
			array('ticket' => 'IN55236376', 'nd' => '162601800324'),
			array('ticket' => 'IN55233864', 'nd' => '172420227702'),
			array('ticket' => 'IN55233779', 'nd' => '172502805238'),
			array('ticket' => 'IN55232780', 'nd' => '172705208931'),
			array('ticket' => 'IN55232937', 'nd' => '111501127074'),
			array('ticket' => 'IN55226850', 'nd' => '162603400295'),
			array('ticket' => 'IN55226250', 'nd' => '131239113601'),
			array('ticket' => 'IN55224495', 'nd' => '162603400968'),
			array('ticket' => 'IN55222675', 'nd' => '152404211043'),
			array('ticket' => 'IN55221966', 'nd' => '152451900671'),
			array('ticket' => 'IN55219854', 'nd' => '152610211113'),
			array('ticket' => 'IN55219754', 'nd' => '152301234286'),
			array('ticket' => 'IN55218377', 'nd' => '152331309227'),
			array('ticket' => 'IN55216244', 'nd' => '111123101370'),
			array('ticket' => 'IN55213673', 'nd' => '152404309260'),
			array('ticket' => 'IN55211165', 'nd' => '152303336131'),
			array('ticket' => 'IN55210186', 'nd' => '152611215035'),
			array('ticket' => 'IN55206561', 'nd' => '172103802799'),
			array('ticket' => 'IN55194692', 'nd' => '152317305847'),
			array('ticket' => 'IN55186378', 'nd' => '111809111673'),
			array('ticket' => 'IN55178527', 'nd' => '172104256380'),
			array('ticket' => 'IN55177177', 'nd' => '111801103383'),
			array('ticket' => 'IN55175589', 'nd' => '172601784753'),
			array('ticket' => 'IN55174683', 'nd' => '111744101349'),
			array('ticket' => 'IN55167929', 'nd' => '172302201643'),
			array('ticket' => 'IN55162940', 'nd' => '111207121594'),
			array('ticket' => 'IN55158715', 'nd' => '143132100730'),
			array('ticket' => 'IN55156522', 'nd' => '131156122418'),
			array('ticket' => 'IN55129256', 'nd' => '122333216046'),
			array('ticket' => 'IN55126017', 'nd' => '131174100319'),
			array('ticket' => 'IN55003821', 'nd' => '121204222905')
		);
		
	}
	
	public function index()	{
		
		$token = 0;
		foreach($this->config->item('whitelist') as $cidr) {
			$range = cidrToRange($cidr);
			if(ip2long($range[0]) <= ip2long($_SERVER['REMOTE_ADDR']) && ip2long($_SERVER['REMOTE_ADDR']) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || true) {
			$this->session->set_userdata('ticket', '');
			$this->session->set_userdata('uid', '');
			$this->ModelTemplate->render(array('hardcode' => $this->hardcode));
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
			if(ip2long($range[0]) <= ip2long($_SERVER['REMOTE_ADDR']) && ip2long($_SERVER['REMOTE_ADDR']) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || true) {
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
						'.$this->db->escape($_SERVER['REMOTE_ADDR']).',
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
			if(ip2long($range[0]) <= ip2long($_SERVER['REMOTE_ADDR']) && ip2long($_SERVER['REMOTE_ADDR']) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || true) {
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
			if(ip2long($range[0]) <= ip2long($_SERVER['REMOTE_ADDR']) && ip2long($_SERVER['REMOTE_ADDR']) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || true) {
			$soBody = http_build_query(array(
				'grant_type' => 'client_credentials'
			));
			$soCh = curl_init();
			curl_setopt($soCh, CURLOPT_URL, 'https://apifactory.telkom.co.id:8243/token');
			curl_setopt($soCh, CURLOPT_USERPWD, 'kekvD45HqfxYSJRI9f14JRluUbMa:UBXwy2TLRQfD2cwjSA8m6GQi4gEa');
			curl_setopt($soCh, CURLOPT_POST, TRUE);
			curl_setopt($soCh, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($soCh, CURLOPT_POSTFIELDS, $soBody);
			curl_setopt($soCh, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($soCh, CURLOPT_SSL_VERIFYPEER, FALSE);
			$soResponse = curl_exec($soCh);
			$soError = curl_error($soCh);
			curl_close($soCh);
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
					$bearer = $jToken['access_token'];
				}
				catch(Exception $ex) {
					
				}
				if(isset($jToken['access_token'])) {
					$bearer = $jToken['access_token'];
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
			}
			else {
				$error[] = $eToken;
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
			if(ip2long($range[0]) <= ip2long($_SERVER['REMOTE_ADDR']) && ip2long($_SERVER['REMOTE_ADDR']) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || true) {
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
				$soCh = curl_init();
				curl_setopt($soCh, CURLOPT_URL, 'https://apifactory.telkom.co.id:8243/api/indibox/getUserInfo/1.0/getNDByIP?ip='.$r01['ip_addr']);
				curl_setopt($soCh, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($soCh, CURLOPT_HTTPHEADER, $soHeader);
				curl_setopt($soCh, CURLOPT_SSL_VERIFYHOST, FALSE);
				curl_setopt($soCh, CURLOPT_SSL_VERIFYPEER, FALSE);
				$soResponse = curl_exec($soCh);
				$soError = curl_error($soCh);
				curl_close($soCh);
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
				$output['debug'] = array(
					'fileRequest' => $fileRequest,
					'fileResponse' => $fileResponse
				);
				$nd = null;
				$chSuccess = 0;
				if($soError == '') {
					$chSuccess = 1;
					try {
						$jND= json_decode($soResponse, true);
					}
					catch(Exception $ex) {
						
					}
					if(isset($jND['ND'])) {
						$nd = $jND['ND'];
						// hardcode - start
						if(isset($_GET['hardcode']) && isset($this->hardcode[$_GET['hardcode']])) {
							$nd = $this->hardcode[$_GET['hardcode']]['nd'];
						}
						// hardcode - finish
						$output['success'] = true;
						$output['data'] = array(
							'ipaddr' => $r01['ip_addr'],
							'userid' => $nd,
							'ticket' => $this->session->userdata('ticket')
						);
					}
				}
				else {
					$error[] = $soError;
				}
				$q01 = $this->db->query('
					UPDATE task_active SET
						ndbyip_success = '.$this->db->escape($chSuccess).',
						ndbyip_log_request = '.$this->db->escape($fileRequest).',
						ndbyip_log_response = '.$this->db->escape($fileResponse).',
						ndbyip_ts = NOW(),
						nd = '.$this->db->escape($nd.'@telkom.net').'
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
			if(ip2long($range[0]) <= ip2long($_SERVER['REMOTE_ADDR']) && ip2long($_SERVER['REMOTE_ADDR']) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || true) {
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
					$soError = curl_error($soCh);
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
								}
								elseif($el__output->getElementsByTagName('MESSAGE')->length > 0) {
									$el__MESSAGE = $el__output->getElementsByTagName('MESSAGE')->item(0);
									$message = $el__MESSAGE->nodeValue;
								}
							}
						}
						if(isset($redaman)) {
							$passed = 1;
							if($redaman < -25) {
								$passed = 0;
							}
							$output['success'] = true;
							$output['data'] = array(
								'redaman_value' => $redaman,
								'redaman_passed' => $passed
							);
						}
						else {
							if(isset($message)) {
								$error[] = $message;
							}
							else {
								$error[] = 'unable to read onu_rx_pwr element';
							}
						}
						$v01Redaman = null;
						if(isset($redaman)) {
							$v01Redaman = $redaman;
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
								redaman_ts = NOW(),
								onu_rx_pwr = '.$this->db->escape($v01Redaman).',
								redaman_passed = '.$this->db->escape($v01Passed).',
								incomplete = '.$this->db->escape($v01Incomplete).'
							WHERE
								1 = 1
								AND uid = '.$this->db->escape($this->session->userdata('uid')).'
						');
					}
					else {
						$error[] = $soError;
					}
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
			if(ip2long($range[0]) <= ip2long($_SERVER['REMOTE_ADDR']) && ip2long($_SERVER['REMOTE_ADDR']) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || true) {
			$soBody = http_build_query(array(
				'grant_type' => 'client_credentials'
			));
			$soCh = curl_init();
			curl_setopt($soCh, CURLOPT_URL, 'https://apifactory.telkom.co.id:8243/token');
			curl_setopt($soCh, CURLOPT_USERPWD, 'kekvD45HqfxYSJRI9f14JRluUbMa:UBXwy2TLRQfD2cwjSA8m6GQi4gEa');
			curl_setopt($soCh, CURLOPT_POST, TRUE);
			curl_setopt($soCh, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($soCh, CURLOPT_POSTFIELDS, $soBody);
			curl_setopt($soCh, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($soCh, CURLOPT_SSL_VERIFYPEER, FALSE);
			$soResponse = curl_exec($soCh);
			$soError = curl_error($soCh);
			curl_close($soCh);
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
				if(isset($jToken['access_token'])) {
					$bearer = $jToken['access_token'];
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
			}
			else {
				$error[] = $soError;
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
			if(ip2long($range[0]) <= ip2long($_SERVER['REMOTE_ADDR']) && ip2long($_SERVER['REMOTE_ADDR']) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || true) {
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
				$soBody = json_encode(array(
					'nd' => $ndEx[0],
					'realm' => $ndEx[1]
				));
				if(count($ndEx) > 1) {
					$soCh = curl_init();
					curl_setopt($soCh, CURLOPT_URL, 'https://apifactory.telkom.co.id:8243/telkom/pcrf/api/v1.0/getInfoPCRF');
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
						'fileRequest' => $fileRequest,
						'fileResponse' => $fileResponse
					);
					$chSuccess = 0;
					if($soError == '') {
						$chSuccess = 1;
						try {
							$jPCRF = json_decode($soResponse, true);
						}
						catch(Exception $ex) {
							
						}
						if(isset($jPCRF['ServicePackage']) && count($jPCRF['ServicePackage']) > 0) {
							$packageName = $jPCRF['ServicePackage'][0]['NAME'];
						}
						if(isset($jPCRF['Quota']) && isset($jPCRF['Quota']['QuotaUsed'])) {
							$quotaUsed = $jPCRF['Quota']['QuotaUsed'];
						}
						// hardcode - start
						// $packageName = 'INETF10M';
						// $quotaUsed = '101194726';
						// hardcode - finish
						if(isset($packageName) && isset($quotaUsed)) {
							$output['success'] = true;
							$output['data'] = array(
								'package_name' => $packageName,
								'quota_used' => $quotaUsed
							);
						}
						else {
							$error[] = 'unable to get combination of package and quota';
						}
					}
					else {
						$error[] = $eToken;
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
					$error[] = 'user data not in email formatted string';
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
			if(ip2long($range[0]) <= ip2long($_SERVER['REMOTE_ADDR']) && ip2long($_SERVER['REMOTE_ADDR']) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || true) {
			$q01 = $this->db->query('
				SELECT
					nd,
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
				// hardcode - start
				//$r01['nd'] = '122325220444@telkom.net';
				// hardcode - finish
				$soBody = '
					<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:soap="http://ibooster.telkom.co.id/api/soap.php">
						<soapenv:Header/>
						<soapenv:Body>
							<soap:speedtest_download soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
								<input xsi:type="acs:speedtest_download_in" xmlns:acs="http://10.62.165.36/soap/ACSIS">
									<internet_number xsi:type="xsd:string">'.$r01['nd'].'</internet_number>
								</input>
							</soap:speedtest_download>
						</soapenv:Body>
					</soapenv:Envelope>
				';
				$soHeader = array(
					'Content-Type: text/xml;charset=UTF-8',
					'SOAPAction: "http://10.62.165.36/api-acsis/index_speed.php/speedtest_download"',
					'Content-Length: '.strlen($soBody)
				);
				$soCh = curl_init();
				curl_setopt($soCh, CURLOPT_URL, 'http://10.62.165.36/api-acsis/index_speed.php');
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
				$logRequest = $this->ModelLog->write($tLog.'.speed.request.log', $soBody);
				$fileRequest = null;
				if($logRequest['success']) {
					$fileRequest = $logRequest['data']['file'];
				}
				$logResponse = $this->ModelLog->write($tLog.'.speed.response.log', $soResponse.PHP_EOL.'========================='.PHP_EOL.$soError);
				$fileResponse = null;
				if($logResponse['success']) {
					$fileResponse = $logResponse['data']['file'];
				}
				// hardcode - start
				/*
				$soError = '';
				$soResponse = '
					<SOAP-ENV:Envelope SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:tns="http://10.62.165.36/soap/ACSIS">
						<SOAP-ENV:Body>
							<ns1:speedtest_downloadResponse xmlns:ns1="http://ibooster.telkom.co.id/api/soap.php">
								<output xsi:type="tns:speedtest_download_out">
									<Message xsi:type="xsd:string">tidak ada error dalam pengiriman perintah ke CPE</Message>
									<State xsi:type="xsd:string">Completed</State>
									<Duration xsi:type="xsd:string">7 seconds</Duration>
									<Speed xsi:type="xsd:string">11.429 Mbit/s</Speed>
								</output>
							</ns1:speedtest_downloadResponse>
						</SOAP-ENV:Body>
					</SOAP-ENV:Envelope>
				';
				*/
				//hardcode - finish
				$chSuccess = 0;
				if($soError == '') {
					$chSuccess = 1;
					$doc = new DOMDocument();
					$doc->loadXML($soResponse);
					$el__Envelope = $doc->getElementsByTagName('Envelope')->item(0);
					$el__Body = $el__Envelope->getElementsByTagName('Body')->item(0);
					if($el__Body->getElementsByTagName('speedtest_downloadResponse')->length > 0) {
						$el__speedtest_downloadResponse = $el__Body->getElementsByTagName('speedtest_downloadResponse')->item(0);
						if($el__speedtest_downloadResponse->getElementsByTagName('output')->length > 0) {
							$el__output = $el__speedtest_downloadResponse->getElementsByTagName('output')->item(0);
							if($el__output->getElementsByTagName('Speed')->length > 0) {
								$el__Speed = $el__output->getElementsByTagName('Speed')->item(0);
								$speed = $el__Speed->nodeValue;
								$xSpeed = explode(' ', $speed);
								if(count($xSpeed) > 1) {
									$speed = $xSpeed[0];
								}
							}
							elseif($el__output->getElementsByTagName('Message')->length > 0) {
								$el__Message = $el__output->getElementsByTagName('Message')->item(0);
								$message = $el__Message->nodeValue;
							}
						}
					}
					if(isset($speed)) {
						$passed = 0;
						$q02 = $this->db->query('
							SELECT
								fup(
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
						// hardcode - start
						// $passed = 0;
						// hardcode - finish
						$output['success'] = true;
						$output['data'] = array(
							'speed_passed' => $passed,
							'speed_count' => $speed
						);
					}
					else {
						if(isset($message)) {
							$error[] = $message;
						}
						else {
							$error[] = 'unable to read Speed element';
						}
					}
				}
				else {
					$error[] = $soError;
				}
				$v01Speed = null;
				if(isset($speed)) {
					$v01Speed = $speed;
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
						incomplete = '.$this->db->escape($v01Incomplete).'
					WHERE
						1 = 1
						AND uid = '.$this->db->escape($this->session->userdata('uid')).'
				');
				if(!isset($speed) || !isset($passed) || $passed == 0) {
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
			if(ip2long($range[0]) <= ip2long($_SERVER['REMOTE_ADDR']) && ip2long($_SERVER['REMOTE_ADDR']) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || true) {
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
	
	/*
	public function saveSession()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		$token = 0;
		foreach($this->config->item('whitelist') as $cidr) {
			$range = cidrToRange($cidr);
			if(ip2long($range[0]) <= ip2long($_SERVER['REMOTE_ADDR']) && ip2long($_SERVER['REMOTE_ADDR']) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || true) {
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', '');
			$this->form_validation->set_rules('session_id', 'Session ID', 'required');
			$this->form_validation->set_rules('response', 'API Response', 'required');
			if($this->form_validation->run() == false) {
				$error[] = form_error('session_id');
				$error[] = form_error('response');
			}
			else {
				$fileRequest = null;
				$fileResponse = null;
				$tLog = time().'.'.rand(111111, 999999);
				$logResponse = $this->ModelLog->write($tLog.'.session.response.log', $this->input->post('response'));
				if($logResponse['success']) {
					$fileResponse = $logResponse['data']['file'];
				}
				$q01 = $this->db->query('
					UPDATE task_active SET
						sess_success = '.$this->db->escape($this->input->post('success')).',
						sess_log_request = '.$this->db->escape($fileRequest).',
						sess_log_response = '.$this->db->escape($fileResponse).',
						sess_ts = NOW(),
						session_id = '.$this->db->escape($this->input->post('session_id')).'
					WHERE
						1 = 1
						AND uid =  '.$this->db->escape($this->session->userdata('uid')).'
				');
				if($this->input->post('session_id') == '') {
					$q02 = $this->db->query('
						DELETE FROM task_active
						WHERE
							1 = 1
							AND uid =  '.$this->db->escape($this->session->userdata('uid')).'
					');
				}
			}
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}
	
	public function saveAttribute()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		$token = 0;
		foreach($this->config->item('whitelist') as $cidr) {
			$range = cidrToRange($cidr);
			if(ip2long($range[0]) <= ip2long($_SERVER['REMOTE_ADDR']) && ip2long($_SERVER['REMOTE_ADDR']) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || true) {
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', '');
			$this->form_validation->set_rules('response', 'API Response', 'required');
			if($this->form_validation->run() == false) {
				$error[] = form_error('response');
			}
			else {
				$fileRequest = null;
				$fileResponse = null;
				$tLog = time().'.'.rand(111111, 999999);
				$logResponse = $this->ModelLog->write($tLog.'.attribute.response.log', $this->input->post('response'));
				if($logResponse['success']) {
					$fileResponse = $logResponse['data']['file'];
				}
				$q01 = $this->db->query('
					UPDATE task_active SET
						attr_success = '.$this->db->escape($this->input->post('success')).',
						attr_log_request = '.$this->db->escape($fileRequest).',
						attr_log_response = '.$this->db->escape($fileResponse).',
						attr_ts = NOW()
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
	
	public function decryptAttribute()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		$token = 0;
		foreach($this->config->item('whitelist') as $cidr) {
			$range = cidrToRange($cidr);
			if(ip2long($range[0]) <= ip2long($_SERVER['REMOTE_ADDR']) && ip2long($_SERVER['REMOTE_ADDR']) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		if($token > 0 || true) {
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('', '');
			$this->form_validation->set_rules('encrypted_data', 'Encrypted Data', 'required');
			if($this->form_validation->run() == false) {
				$error[] = form_error('encrypted_data');
			}
			else {
				$key = md5(utf8_encode('Telkom135'), true);
				$key .= substr($key, 0, 8);
				$data = base64_decode($this->input->post('encrypted_data'));
				$data = mcrypt_decrypt('tripledes', $key, $data, 'ecb');
				$block = mcrypt_get_block_size('tripledes', 'ecb');
				$len = strlen($data);
				$pad = ord($data[$len-1]);
				$decrypted = substr($data, 0, strlen($data) - $pad);
				try {
					$jDecrypted = json_decode($decrypted, true);
				}
				catch(Exception $x) {
					
				}
				if(isset($jDecrypted)) {
					$decryptedIpaddr = null;
					if(isset($jDecrypted['ipaddr'])) {
						$decryptedIpaddr = $jDecrypted['ipaddr'];
					}
					$decryptedSourceip = null;
					if(isset($jDecrypted['sourceip'])) {
						$decryptedSourceip = $jDecrypted['sourceip'];
					}
					$decryptedUserid = null;
					if(isset($jDecrypted['userid'])) {
						$decryptedUserid = $jDecrypted['userid'];
					}
					// hardcode - start
					$decryptedUserid = '152401129054@telkom.net';
					// hardcode - finish
					$q01 = $this->db->query('
						UPDATE task_active SET
							decrypted_sourceip = '.$this->db->escape($decryptedSourceip).',
							decrypted_userid = '.$this->db->escape($decryptedUserid).'
						WHERE
							1 = 1
							AND uid =  '.$this->db->escape($this->session->userdata('uid')).'
					');
					$output['success'] = true;
					$output['data'] = array(
						'ipaddr' => $decryptedIpaddr,
						'sourceip' => $decryptedSourceip,
						'userid' => $decryptedUserid,
						'ticket' => $this->session->userdata('ticket')
					);
				}
				else {
					$error[] = 'unable to decrypt message';
				}
			}
		}
		if(count($error) > 0) {
			$output['error'] = $error;
		}
		echo json_encode($output);
		
	}
	*/
	
}
