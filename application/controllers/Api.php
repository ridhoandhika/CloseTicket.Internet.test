<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
	
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
	
	public function check()	{
		
		$output = array(
			'success' => false
		);
		$error = array();
		if($this->session->userdata('SignedIn') == true) {
			$ip_input = $this->input->post('ip');
			$nd = '';
			//WHO
			$soWHO = curl_init();
			curl_setopt($soWHO, CURLOPT_URL, 'https://myip.indihome.co.id');
			curl_setopt($soWHO, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($soWHO, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($soWHO, CURLOPT_SSL_VERIFYPEER, FALSE);
			$soResponseWHO = curl_exec($soWHO);
			$soErrorWHO = curl_error($soWHO);
			curl_close($soWHO);
			$errorWHO = '';
			$WHO = 'NOOK';
			if($soErrorWHO == '') {
				try {
					$jWHO = json_decode($soResponseWHO, true);
				}
				catch(Exception $ex) {
					
				}
				if(isset($jWHO['ip_addr'])) {
					//$ip = $jWHO['ip_addr'];
					$WHO = 'OK';
				}
				
			}
			else {
				$WHO = 'NOOK';
				$errorWHO = $soErrorWHO;
			}
			
			//Token
			$soBody = http_build_query(array(
				'grant_type' => 'client_credentials'
			));
			$soToken = curl_init();
			curl_setopt($soToken, CURLOPT_URL, 'https://apifactory.telkom.co.id:8243/token');
			curl_setopt($soToken, CURLOPT_USERPWD, 'kekvD45HqfxYSJRI9f14JRluUbMa:UBXwy2TLRQfD2cwjSA8m6GQi4gEa');
			curl_setopt($soToken, CURLOPT_POST, TRUE);
			curl_setopt($soToken, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($soToken, CURLOPT_POSTFIELDS, $soBody);
			curl_setopt($soToken, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($soToken, CURLOPT_SSL_VERIFYPEER, FALSE);
			$soResponseToken = curl_exec($soToken);
			$soErrorToken = curl_error($soToken);
			curl_close($soToken);
			$errorToken = '';
			$Token = 'NOOK';
			if($soErrorToken == '') {
				try {
					$jToken = json_decode($soResponseToken, true);
				}
				catch(Exception $ex) {
					
				}
				if(isset($jToken['access_token'])) {
					$bearer = $jToken['access_token'];
					$Token = 'OK';
				}
				
			}
			else {
				$errorToken = $soErrorToken;
			}
			$ip = $ip_input; //IP Address
			//$ip = '180.241.249.154'; //IP Address
			//$ip = '125.167.190.30'; //IP Address
			//NDbyIP
			$soHeader = array(
				'Content-Type: text/xml',
				'Authorization : Bearer '.$bearer
			);
			$urlND = 'https://apifactory.telkom.co.id:8243/api/indibox/getUserInfo/1.0/getNDByIP?ip='.$ip_input;
			$soNDbyIP = curl_init();
			curl_setopt($soNDbyIP, CURLOPT_URL, $urlND);
			curl_setopt($soNDbyIP, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($soNDbyIP, CURLOPT_HTTPHEADER, $soHeader);
			curl_setopt($soNDbyIP, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($soNDbyIP, CURLOPT_SSL_VERIFYPEER, FALSE);
			$soResponseNDbyIP = curl_exec($soNDbyIP);
			$soErrorNDbyIP = curl_error($soNDbyIP);
			curl_close($soNDbyIP);
			$errorNDbyIP = '';
			$NDbyIP = 'NOOK';
			if($soErrorNDbyIP == '') {
				try {
					$jND= json_decode($soResponseNDbyIP, true);
				}
				catch(Exception $ex) {
					
				}
				if(isset($jND['ND']) && $jND['ND'] != 'NULL'){
					$nd = $jND['ND'];
					$NDbyIP = 'OK';
				}
				
			}
			else {
				$errorNDbyIP = $soErrorNDbyIP;
			}
			if($jND['statusMessage'] != 'Success'){
				$errorNDbyIP = $soResponseNDbyIP;
			}
			//Redaman
			$nd = $nd.'@telkom.net';
			$ndEx = explode('@', $nd);
			$soBodyRedaman = '
				<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:soap="http://ibooster.telkom.co.id/api/soap.php">
				   <soapenv:Header/>
				   <soapenv:Body>
					  <soap:ukur_indikasi soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
						 <input xsi:type="ibo:ukur_in" xmlns:ibo="http://10.62.165.53/soap/iBooster">
							<!--You may enter the following 2 items in any order-->
							<nd xsi:type="xsd:string">'.$ndEx[0].'</nd>
							<realm xsi:type="xsd:string">'.$ndEx[1].'</realm>
						 </input>
					  </soap:ukur_indikasi>
				   </soapenv:Body>
				</soapenv:Envelope>
			';
			$soHeaderRedaman = array(
				'Content-Type: text/xml;charset=UTF-8',
				'SOAPAction: "http://10.62.165.53/air/index.php/ukur_indikasi"',
				'Content-Length: '.strlen($soBodyRedaman)
			);
			$soCh = curl_init();
			curl_setopt($soCh, CURLOPT_URL, 'http://10.62.165.53/air/index.php');
			curl_setopt($soCh, CURLOPT_POST, TRUE);
			curl_setopt($soCh, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($soCh, CURLOPT_POSTFIELDS, $soBodyRedaman);
			curl_setopt($soCh, CURLOPT_HTTPHEADER, $soHeaderRedaman);
			curl_setopt($soCh, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($soCh, CURLOPT_SSL_VERIFYPEER, FALSE);
			$soResponseRedaman = curl_exec($soCh);
			$soErrorRedaman = curl_error($soCh);
			$redaman__ = '';
			$RedamanStatus = 'NOOK';
			$chSuccess = 0;
			if($soErrorRedaman == '') {
				$chuccess = 1;
				$doc = new DOMDocument();
				$doc->loadXML($soResponseRedaman);
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
						}
						elseif($el__output->getElementsByTagName('MESSAGE')->length > 0) {
							$el__MESSAGE = $el__output->getElementsByTagName('MESSAGE')->item(0);
							$message = $el__MESSAGE->nodeValue;
						}
					}
				}
				if(isset($redaman)) {
					if($redaman) {
						$RedamanStatus = 'OK';
					}
				}
				else {
					if(isset($message)) {
						$redaman__ = $message;
					}
					else {
						$redaman__ = 'unable to read onu_rx_pwr element';
					}
				}
			}
			else {
				$redaman__ = $soError;
			}
			
			//PCRF
			$soHeader = array(
				'Content-Type: application/json',
				'Authorization : Bearer '.$bearer
			);
			$nd = $nd;
			$ndEx = explode('@', $nd);
			$soBody = json_encode(array(
				'nd' => $ndEx[0],
				'realm' => 'telkom.net'
			));
			$soCh = curl_init();
			curl_setopt($soCh, CURLOPT_URL, 'https://apifactory.telkom.co.id:8243/telkom/pcrf/api/v1.0/getInfoPCRF');
			curl_setopt($soCh, CURLOPT_POST, TRUE);
			curl_setopt($soCh, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($soCh, CURLOPT_POSTFIELDS, $soBody);
			curl_setopt($soCh, CURLOPT_HTTPHEADER, $soHeader);
			curl_setopt($soCh, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($soCh, CURLOPT_SSL_VERIFYPEER, FALSE);
			$soResponsePCRF = curl_exec($soCh);
			$soErrorPCRF = curl_error($soCh);
			curl_close($soCh);
			$PCRFerror = '';
			$PCRF = 'NOOK';
			if($soErrorPCRF == '') {
				try {
					$jPCRF = json_decode($soResponsePCRF, true);
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
					$PCRF = 'OK';
				}
				else {
					$PCRFerror = 'unable to get combination of package and quota';
				}
			}
			else {
				$PCRFerror = $soError;
			}
			
			$message = array(
				'ip' => $ip_input,
				'nd' => $nd,
				'who' => array(
					'status' => $WHO,
					'success' => $soResponseWHO,
					'failed' => $errorWHO
				),
				'token' => array(
					'status' => $Token,
					'success' => $soResponseToken,
					'failed' => $errorToken
				),
				'NDbyIP' => array(
					'status' => $NDbyIP,
					'success' => $soResponseNDbyIP,
					'failed' => $soErrorNDbyIP
				),
				'redaman' => array(
					'status' => $RedamanStatus,
					'success' => $soResponseRedaman,
					'failed' => $soErrorRedaman
				),
				'pcrf' => array(
					'status' => $PCRF,
					'success' => $soResponsePCRF,
					'failed' => $PCRFerror
				)				
			);
			$output['success'] = true;
			$output['data'] = $message;			
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
