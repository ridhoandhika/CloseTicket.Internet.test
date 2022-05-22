<?php
//slave
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
	
	private $DB;
	
	function __construct() {
		
	}

	
	public function ookla() {
		echo '<iframe width="100%" height="650px" frameborder="0" src="https://test-inf-1.speedtestcustom.com"></iframe>';
	}

	public function ookla2() {
		echo '<iframe width="100%" height="650px" frameborder="0" src="https://test-inf-2.speedtestcustom.com"></iframe>';
	}

	
	public function check($ip_input = null) {
		header('Access-Control-Allow-Origin: *');

		$output = array(
			'success' => FALSE
		);
		if($ip_input != null){
			$output = array(
				'success' => TRUE
			);
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
					$ip_addr = $jWHO['ip_addr'];
					$WHO = 'OK';
				}
				
			}
			else {
				$WHO = 'NOOK';
				$errorWHO = $soErrorWHO;
			}
			
			//Token
			/*$soBody = http_build_query(array(
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
			}*/

			$soBody = http_build_query(array(
				'grant_type' => 'client_credentials', 
				'client_id' => '916a4ea5-e308-4662-a387-7c7735799c16', 
				'client_secret' => '73f1cf21-acc7-4aeb-9f27-143d49f32f66' 
			));
			$soToken = curl_init();
			$urltoken = 'https://apigw.telkom.co.id:7777/invoke/pub.apigateway.oauth2/getAccessToken';
			curl_setopt($soToken, CURLOPT_URL, $urltoken);
			curl_setopt($soToken, CURLOPT_SSLVERSION, 6);  
			curl_setopt($soToken, CURLOPT_POST, true);
			curl_setopt($soToken, CURLOPT_POSTFIELDS, $soBody);
			curl_setopt($soToken, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($soToken, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($soToken, CURLOPT_SSL_VERIFYPEER, 0);
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
			// $ip = $ip_input; //IP Address
			//$ip = '180.241.249.154'; //IP Address
			//$ip = '125.167.190.30'; //IP Address
			//NDbyIP
			/*$soHeader = array(
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
			}*/

			$ip = '10.60.170.38'; 
		$soHeader = array(
			'Content-Type: application/json',
			'Authorization: Bearer '.$bearer
		);
		$soNDbyIP = curl_init();
		curl_setopt($soNDbyIP, CURLOPT_URL, 'https://apigw.telkom.co.id:7777/gateway/telkom-radius-ip/1.0/getNDByIP?ip='.$ip);
		curl_setopt($soNDbyIP, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($soNDbyIP, CURLOPT_HTTPHEADER, $soHeader);
		curl_setopt($soNDbyIP, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($soNDbyIP, CURLOPT_SSL_VERIFYPEER, FALSE);
		$soResponseNDbyIP = curl_exec($soNDbyIP);
		$soErrorNDbyIP = curl_error($soNDbyIP);
		$httpcodeND = curl_getinfo($soNDbyIP, CURLINFO_HTTP_CODE);
		curl_close($soNDbyIP);
		$errorNDbyIP = '';
		$NDbyIP = 'NOOK';
		if($soErrorNDbyIP == '') {
			try {
				$jND= json_decode($soResponseNDbyIP, true);
			}
			catch(Exception $ex) {
				
			}
			if(isset($jND['data']['ND']) && $jND['data']['ND'] != 'NULL'){
				$nd = $jND['data']['ND'];
				$NDbyIP = 'OK';
			}

			// if($httpcodeND != 200){
			// 	if(isset($jND['returnMessage'])){ 
			// 		$messageND = $soResponseNDbyIP;
			// 	}else{
			// 		if(!isset($jND['statusCode'])){
			// 			$messageND = $soResponseNDbyIP;
			// 		}
			// 	}
			// }else{
			// 	$messageND = $soResponseNDbyIP;
			// }
		}else {
			$errorNDbyIP = $soErrorNDbyIP;
		}
		if($jND['returnMessage'] != 'OK'){
			$errorNDbyIP = $soResponseNDbyIP;
		}


		//IP Radius
		$field = array(
			'username' => $ip_input,
			'realm' => 'telkom.net'
		);
		$soBody = json_encode($field, true);
		$soHeader = array(
			'Content-Type: application/json',
			'Authorization: Bearer '.$bearer
		);
		
		$soRadius = curl_init();
		curl_setopt($soRadius, CURLOPT_URL, 'https://apigw.telkom.co.id:7777/gateway/telkom-radius/1.0/getUsageOnline');
		curl_setopt($soRadius, CURLOPT_POST, TRUE);
		curl_setopt($soRadius, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($soRadius, CURLOPT_POSTFIELDS, $soBody);
		curl_setopt($soRadius, CURLOPT_HTTPHEADER, $soHeader);
		curl_setopt($soRadius, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($soRadius, CURLOPT_SSL_VERIFYPEER, FALSE);
		$soResponseIP = curl_exec($soRadius);
		$soErrorIP = curl_error($soRadius);
		$httpcodeIP = curl_getinfo($soRadius, CURLINFO_HTTP_CODE);
		curl_close($soRadius);
		 $IPOnline = '';
		$OnlineStatus = 'NOOK';
		if($soErrorIP == '') {
			try {
				$getIPOnline = json_decode($soResponseIP, true);
			}
			catch(Exception $ex) {
				
			}
			if($getIPOnline['returnMessage'] == "OK"){
				$ukur = $getIPOnline['output']['Framed-IP-Address'];
				$OnlineStatus = 'OK';
			} 
			// if($httpcodeIP == 200){
			// 	if(isset($getIPOnline['returnMessage'])){ 
			// 		$messageIP = $soResponseIP; 
			// 	} else {
			// 		if(!isset($getIPOnline['statusCode'])){
			// 			$messageIP = $soResponseIP;
			// 		}
			// 	}
			// }
			// else{
			// 	$message = $soResponseIP;
			// }
		}
		else {
			$IPOnline = $soErrorIP;
		}
		

			//Redaman
		/*	$nd = '122302272094@telkom.net';
			$ndEx = explode('@', $nd);
			$soBodyRedaman = '
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
			$soHeaderRedaman = array(
				'Content-Type: text/xml;charset=UTF-8',
				'SOAPAction: "http://10.62.165.36/air/index.php/ukur_indikasi"',
				'Content-Length: '.strlen($soBodyRedaman)
			);
			$soCh = curl_init();
			curl_setopt($soCh, CURLOPT_URL, 'http://10.62.165.36/air/index.php');
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
			}*/


			$field = array(
				'input' =>	array(
					'nd' => $ip_input,
					//$nd,
					'realm' => 'telkom.net',
				)
			);
			$soBody = json_encode($field, true);
			$soHeader = array(
				'Content-Type: application/json',
				'Authorization: Bearer '.$bearer
			);
			
			$soRedaman = curl_init();
			curl_setopt($soRedaman, CURLOPT_URL, 'https://apigw.telkom.co.id:7777/gateway/telkom-ibooster-iboosterapi/1.0/iBooster/ukur_indikasi');
			curl_setopt($soRedaman, CURLOPT_POST, TRUE);
			curl_setopt($soRedaman, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($soRedaman, CURLOPT_POSTFIELDS, $soBody);
			curl_setopt($soRedaman, CURLOPT_HTTPHEADER, $soHeader);
			curl_setopt($soRedaman, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($soRedaman, CURLOPT_SSL_VERIFYPEER, FALSE);
			$soResponseRedaman = curl_exec($soRedaman);
			$soErrorRedaman = curl_error($soRedaman);
			curl_close($soRedaman);
			$redaman = '';
			$RedamanStatus = 'NOOK';
			if($soErrorRedaman == '') {
				try {
					$jUkur= json_decode($soResponseRedaman, true);
				} 
				catch(Exception $ex) {
					
				}
				if(isset($jUkur['onu_rx_pwr'])){
					$ukur = $jUkur['onu_rx_pwr'];
					$RedamanStatus = 'OK';
				} 
			}
			else {
				$redaman = $soErrorRedaman;
			}
			
			//PCRF
			/*$soHeader = array(
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
			}*/

			$field = array(
				'serviceNumber' => $ip_input
				//$nd
			);
			$soBody = json_encode($field, true);
			//NDbyIP
			$soHeader = array(
				'Content-Type: application/json',
				'Authorization: Bearer '.$bearer
			);
	
			$soPCFR = curl_init();
			curl_setopt($soPCFR, CURLOPT_URL, 'https://apigw.telkom.co.id:7777/gateway/telkom-pcrf-usageDetail/1.0/getInfoUsageDetail');
			curl_setopt($soPCFR, CURLOPT_POST, TRUE);
			curl_setopt($soPCFR, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($soPCFR, CURLOPT_POSTFIELDS, $soBody);
			curl_setopt($soPCFR, CURLOPT_HTTPHEADER, $soHeader);
			curl_setopt($soPCFR, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($soPCFR, CURLOPT_SSL_VERIFYPEER, FALSE);
			$soResponsePCRF = curl_exec($soPCFR);
			$soErrorPCRF = curl_error($soPCFR);
			curl_close($soPCFR);
			$PCRFerror = '';
			$PCRF = 'NOOK';
			if($soErrorPCRF == '') {
				try {
					$jPCRF = json_decode($soResponsePCRF, true);
				}
				catch(Exception $ex) {
					
				}
				// if(!isset($jPCRF['data']['getInfoUsageResponse']['package'])){ 
				// 	$messagePCRF = $soResponsePCRF;
				// } 
				if(isset($jPCRF['data']['getInfoUsageResponse']['package']) && $jPCRF['data']['getInfoUsageResponse']['package'] != 'NULL') {
						$packageName = $jPCRF['data']['getInfoUsageResponse']['package'];
						$PCRF = 'OK';
						//$PCRFStatus = 'OK';
				}
				// if(isset($packageName)) {
				// 	$PCRFStatus = 'OK';
				// }
				// else {
				// 	if(isset($messagePCRF)) {
				// 		$ResPCRFEror = $messagePCRF;
				// 	}
				// 	else {
				// 		$ResPCRFEror = 'unable to get combination of package and quota';
				// 	}
				// }
			}
			else {
				$PCRFerror = $soErrorPCRF;
			}
		
			
			//Speedtest
			/* $soBody = '
				<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:soap="http://ibooster.telkom.co.id/api/soap.php">
					<soapenv:Header/>
					<soapenv:Body>
						<soap:speedtest_download soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
							<input xsi:type="acs:speedtest_download_in" xmlns:acs="http://10.62.165.36/soap/ACSIS">
								<internet_number xsi:type="xsd:string">'.$nd.'</internet_number>
								<abc xsi:type="xsd:string">'.$nd.'</abc>
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
			$Speed = 'NOOK';
			$Speederror = '';
			$message = '';
			if($soError == '') {
				$chSuccess = 1;
				$allowedError = 0;
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
							$el__Message = $el__output->getElementsByTagName('Message')->item(0);
							$message = $el__Message->nodeValue;
						}
						elseif($el__output->getElementsByTagName('Message')->length > 0) {
							$el__Message = $el__output->getElementsByTagName('Message')->item(0);
							$message = $el__Message->nodeValue;
							if($message == 'Serial Number Not Found' || $message == 'Not Connected to ACS') {
								$allowedError++;
							}
						}
					}
				}
				if(isset($speed) || $allowedError > 0) {
					$passed = 0;
					if($allowedError > 0) {
						$passed = '4';
					}
					else {
						$Speed = 'OK';
					}
				}
				else {
					if(isset($message) && $allowedError == 0) {
						$Speederror = $message;
					}
					else {
						$Speederror = 'unable to read Speed element';
					}
				}
			}
			else {
				$Speederror = $soError;
			}
			if($message == 'Serial Number Not Found' || $message == 'Not Connected to ACS') {
				$Speederror = $message;
			} */
			
			/* //httpstatus
			$outputConsoleHTTP = array();
			exec('systemctl status httpd', $outputConsoleHTTP);
			$HTTPLine = explode(" ",$outputConsoleHTTP[2]);
			$StatusHTTP = $HTTPLine[4].' '.$HTTPLine[5];
			//httpstatus */
			
			/* $message = "".
				"<b><u>Closing Ticket Internet (SCC)</u></b>"."</br>".
				"<i>check time <u>".date("d-m-Y H:i")."</u></i>"."</br>".
				"IP Test : ".$ip_input."</br>".
				"ND Test : ".$nd."</br>".
				""."</br>".
				"Service:"."</br>".
				//"Status HTTP : ".$StatusHTTP."</br>".
				"<hr>"."</br>".
				"API WHO : <b>".$WHO."</b>"."</br>".
				"   Response : ".$soResponseWHO.' '.$errorWHO."</br>".
				"<hr>"."</br>".
				"API Token : <b>".$Token."</b>"."</br>".
				"   Response : ".$soResponseToken.' '.$errorToken."</br>".
				"<hr>"."</br>".
				"API NDbyIP : <b>".$NDbyIP."</b>"."</br>".
				"   Response : ".$soResponseNDbyIP.' '.$soErrorNDbyIP."</br>".
				"<hr>"."</br>".
				"API Redaman : <b>".$RedamanStatus."</b>"."</br>".
				"   Response : ".$soResponseRedaman.' '.$soErrorRedaman."</br>".
				"<hr>"."</br>".
				"API PCRF : <b>".$PCRF."</b>"."</br>".
				"   Response : ".$soResponsePCRF.' '.$PCRFerror."</br>".
				//"API Speedtest : ".$Speed.' '.$Speederror."\n".
				"<hr>"."</br>"
			; */
			
			//
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
				'IPByND' => array(
					'status' => $OnlineStatus,
					'success' => $soResponseIP,
					'failed' => $IPOnline
				),
				'redaman' => array(
					'status' => $RedamanStatus,
					'success' => $soResponseRedaman,
					'failed' => $redaman
				),
				'pcrf' => array(
					'status' => $PCRF,
					'success' => $soResponsePCRF,
					'failed' => $PCRFerror
				)				
			);
			$output['data'] = $message;
			
			echo json_encode($output);

			// var_dump($PCRFerror);
			
		}
	}

	public function ticket(){

		$output = array(
			'success' => false
		);
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
		
//'Content-Type: application/json',
		$soHeader = array(
			'Accept: application/json',
			'Content-Type: application/json',
			'Authorization: Bearer '.$bearer
		);
		// $field = array(
		// 	'input' => 	array(
		// 		'nd' => $ndEx[0],
		// 		'realm' => $ndEx[1],
		// 	)
		// );
		$field = array(
			'QueryTK_INCIDENT' => array( 
				'TK_INCIDENTQuery' => array(
					'INCIDENT' =>array(
						'TICKETID' => 'IN138716422'
					),      
				)
			)
		);
		$soBody = json_encode($field, true);
		
		$soCh = curl_init();
		curl_setopt($soCh, CURLOPT_URL, 'https://apigw.telkom.co.id:7777/ws/telkom-mycx-tcIncident/1.0/QueryTK_INCIDENT');
		curl_setopt($soCh, CURLOPT_POST, TRUE);
		curl_setopt($soCh, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($soCh, CURLOPT_POSTFIELDS, $soBody);
		curl_setopt($soCh, CURLOPT_HTTPHEADER, $soHeader);
		curl_setopt($soCh, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($soCh, CURLOPT_SSL_VERIFYPEER, FALSE);
		$soResponse2 = curl_exec($soCh);
		$soInfo = curl_getinfo($soCh);
		$httpcode = curl_getinfo($soCh, CURLINFO_HTTP_CODE);
		$soError = curl_error($soCh);
		
		curl_close($soCh);

		$ipradius =  json_decode($soResponse2, true);
		$chSuccess = 0;

		// $nd = $ipradius['QueryTK_INCIDENTResponse'];
		// $nd = $ipradius['QueryTK_INCIDENTResponse']['TK_INCIDENTSet']['INCIDENT']['TK_SERVICENO'];
		$output['success'] = true;
		$output['data'] = array(
			'nd' => $nd
		);
		echo json_encode($output, JSON_PRETTY_PRINT);
	}

	/*function getSystemMemInfo() 
	{   
		// if(
		// 	$this->input->post('ip_server') == '10.60.170.38'
		// ){
			//Service httpd
			$outputConsoleHTTP = array();
			exec('systemctl status httpd', $outputConsoleHTTP);
			$HTTPLine = explode(" ",$outputConsoleHTTP[2]); 

			//Storage
			$outputHDD = array();
			exec('df -h', $outputHDD);
			$HDDLine = explode(" ",$outputHDD[11]);
			
			//Memmory
			$outputmem = array();
			exec("free -m", $outputmem);
			$MemLine = explode(" ",$outputmem[1]);
		
			$total = null;
				if(isset($MemLine[11]) == ""){$total = $MemLine[12].' Mb';}else{$total=$MemLine[11].' Mb';}
			$used = null;
				if(isset($MemLine[19]) == ""){$used = $MemLine[20].' Mb';}else{$used=$MemLine[19].' Mb';}
			$free = null;
				if(isset($MemLine[28]) == ""){$free = $MemLine[27].' Mb';}else{$free=$MemLine[28].' Mb';}
			$share = null;
				if(isset($MemLine[37]) == ""){$share = $MemLine[36].' Mb';}else{$share=$MemLine[37].' Mb';}
			$cache = null;
				if(isset($MemLine[44]) == ""){$cache = $MemLine[44].' Mb';}else{$cache = $MemLine[45].' Mb';}
			$available = null;
				if(isset($MemLine[52]) == ""){$available = $MemLine[52].' Mb';}else{ $available = $MemLine[53].' Mb';}

			$output['data'] = array(
				'Memory server SCC' => '10.60.170.37',
				'httpd' => $HTTPLine[4].' '.$HTTPLine[5],
				'Memory' => [
				'Total' => $total,
				'Used' => $used,
				'Free' => $free,
				'Share' => $share,
				'Cache' =>  $cache,
				'Available' => $available
				],
				'Storage' => [
					'Size' =>$HDDLine[5],
					'Used' =>$HDDLine[8],
					'Avail' =>$HDDLine[11],
					'Use %' =>$HDDLine[13],
					'Directory' =>$HDDLine[14],
				]

			);
			header('Content-Type: application/json');
			$pesan = json_encode($output, JSON_PRETTY_PRINT);
			
			$bot_url = "https://api.telegram.org/bot2016937428:AAEnvN2uVk4uN4W2hJJ-_Fii0rYRp-xVJN0/";
			$url = $bot_url."sendMessage?chat_id=-1001797564330&text=".urlencode($pesan)."&parse_mode=HTML";
			$x = file_get_contents($url);

			echo $pesan;
		// }
	}*/


}
