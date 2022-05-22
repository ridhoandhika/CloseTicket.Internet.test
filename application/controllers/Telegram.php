<?php
//slave
defined('BASEPATH') OR exit('No direct script access allowed');

class Telegram extends CI_Controller {
	
	private $DB;
	
	function __construct() {
		
	}

	
	public function curl() {
		//App Status HTTP-------------------------------------------------
		$outputConsoleHTTP = array();
		exec('systemctl status httpd', $outputConsoleHTTP);
		$HTTPLine = explode(" ",$outputConsoleHTTP[2]);
		$StatusHTTP = $HTTPLine[4].' '.$HTTPLine[5];
		//App Status HTTP-------------------------------------------------
	}
	
	public function sent() {
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
				$ip = $jWHO['ip_addr'];
				$WHO = 'OK';
			}
		}
		else {
			$WHO = 'NOOK';
			$errorWHO = $soErrorWHO;
		}
		
		//Token
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
				
		
		//$ip = '180.241.249.154'; //IP Address
		//$ip = '36.85.42.180'; //IP Address // IP Null
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

			if($httpcodeND != 200){
				if(isset($jND['returnMessage'])){ 
					$messageND = $soResponseNDbyIP;
				}else{
					if(!isset($jND['statusCode'])){
						$messageND = $soResponseNDbyIP;
					}
				}
			}else{
				$messageND = $soResponseNDbyIP;
			}
		}
		else {
			$errorNDbyIP = $soErrorNDbyIP;
		}
		

		//IP Radius
		$field = array(
			'username' => '172403225072',
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
		$soError = curl_error($soRadius);
		$httpcodeIP = curl_getinfo($soRadius, CURLINFO_HTTP_CODE);
		curl_close($soRadius);
		$IPOnline = $soError;
		$OnlineStatus = 'NOOK';
		if($soError == '') {
			try {
				$getIPOnline = json_decode($soResponseIP, true);
			}
			catch(Exception $ex) {
				
			}
			if($getIPOnline['returnMessage'] == "OK"){
				$ukur = $getIPOnline['output']['Framed-IP-Address'];
				$OnlineStatus = 'OK';
			} 
			if($httpcodeIP == 200){
				if(isset($getIPOnline['returnMessage'])){ 
					$messageIP = $soResponseIP; 
				} else {
					if(!isset($getIPOnline['statusCode'])){
						$messageIP = $soResponseIP;
					}
				}
			}
			else{
				$message = $soResponseIP;
			}
		}
		else {
			$IPOnline = $soError;
		}

		//Redaman
		$field = array(
			'input' =>	array(
				'nd' => '172407207761',
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
		$soResponse = curl_exec($soRedaman);
		$soError = curl_error($soRedaman);
		curl_close($soRedaman);
		$redaman = $soError;
		$RedamanStatus = 'NOOK';
		if($soError == '') {
			try {
				$jUkur= json_decode($soResponse, true);
			}
			catch(Exception $ex) {
				
			}
			if(isset($jUkur['onu_rx_pwr'])){
				$ukur = $jUkur['onu_rx_pwr'];
				$RedamanStatus = 'OK';
			} 
			if(isset($jUkur['MESSAGE'])){ 
				$message = $soResponse;//$jUkur['MESSAGE'];
			} else {
				if(!isset($jUkur['onu_rx_pwr'])){
					$message = $soResponse;
				}
			}
			if(isset($ukur)) {
				if($ukur) {
					$RedamanStatus = 'OK';
				}
			}
			else {
				if(isset($message)) {
					$redaman = $message;
				}
				else {
					$redaman = 'unable to read onu_rx_pwr element';
				}
			}
		}
		else {
			$redaman = $soError;
		}
		
		
		//PCRF
		$field = array(
			'serviceNumber' => '172407207761'
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
		$ResPCRFEror = '';
		$PCRFStatus = 'NOOK';
		if($soErrorPCRF == '') {
			try {
				$jPCRF = json_decode($soResponsePCRF, true);
			}
			catch(Exception $ex) {
				
			}
			if(!isset($jPCRF['data']['getInfoUsageResponse']['package'])){ 
				$messagePCRF = $soResponsePCRF;
			} 
			if(isset($jPCRF['data']['getInfoUsageResponse']['package']) && $jPCRF['data']['getInfoUsageResponse']['package'] != 'NULL') {
					$packageName = $jPCRF['data']['getInfoUsageResponse']['package'];
					//$PCRFStatus = 'OK';
			}
			if(isset($packageName)) {
				$PCRFStatus = 'OK';
			}
			else {
				if(isset($messagePCRF)) {
					$ResPCRFEror = $messagePCRF;
				}
				else {
					$ResPCRFEror = 'unable to get combination of package and quota';
				}
			}
		}
		else {
			$ResPCRFEror = $soErrorPCRF;
		}
	

		
		//httpstatus
		$outputConsoleHTTP = array();
		exec('systemctl status httpd', $outputConsoleHTTP);
		$HTTPLine = explode(" ",$outputConsoleHTTP[2]);
		$StatusHTTP = $HTTPLine[4].' '.$HTTPLine[5];
				
		$kirim = "";
		if($StatusHTTP !='active (running)' || $WHO !='OK' || $Token !='OK' || $httpcodeND !=200 || $RedamanStatus !='OK' || $PCRFStatus !='OK' || $httpcodeIP != 200) { 
		$kirim .= "<b><u>Closing Ticket Internet</u></b>"."\n".
					"<i>check time <u>".date("d-m-Y H:i")."</u></i>"."\n".
					"IP Test : ".$ip."\n".
					"ND Test : 172413205942@telkom.net\n".
					""."\n";
		}

		if($StatusHTTP !='active (running)') { 
			$kirim .= 'Status HTTP : '.$StatusHTTP.' '."\n";
		} 
		if($WHO !='OK') { 
			$kirim .= 'API WHO : '.$WHO.' '.$errorWHO.' '."\n";
		}
		if($Token !='OK') { 
			$kirim .= 'API Token : '.$Token.' '.$errorToken.' '."\n";
		}
		if($httpcodeND !=200) { 
			$kirim .= 'API NDByIP : '.$NDbyIP.' '.$messageND.' '."\n";
		}
		if($RedamanStatus !='OK') { 
			$kirim .= 'API Redaman : '.$RedamanStatus.' '.$redaman.' '."\n";
		} 
		if($PCRFStatus !='OK') { 
			$kirim .= 'API PCRF : '.$PCRFStatus.' '.$ResPCRFEror.' '."\n";
		} 
		if($httpcodeIP != 200) { 
			$kirim .= 'API GetIP Radius : '.$OnlineStatus.' '.$messageIP.' '."\n";
		} 
		echo $kirim;
		//Tele dev

		if($StatusHTTP !='active (running)' || $WHO != 'OK' || $Token != 'OK' || $httpcodeND != 200 || $RedamanStatus != 'OK' || $PCRFStatus != 'Ok' || $httpcodeIP != 200){
			$bot_url = "https://api.telegram.org/bot2016937428:AAEnvN2uVk4uN4W2hJJ-_Fii0rYRp-xVJN0/";
			$url = $bot_url."sendMessage?chat_id=-1001797564330&text=".urlencode($kirim)."&parse_mode=HTML";
			$x = file_get_contents($url);
			}
		/*if($StatusHTTP !='active (running)' || $WHO != 'OK' || $Token != 'OK' || $httpcodeND != 200 || $RedamanStatus != 'OK' || $PCRFStatus != 'Ok' || $httpcodeIP != 200){
		$bot_url = "https://api.telegram.org/bot1095123335:AAEhU3HrjumjlnZG9_d5jTCmVhiNVJYPVnk/";
		//$bot_url = "https://api.telegram.org/bot2096675573:AAHVRRtSUQTnNws_NeCkoyIWQLLyQ-WyOmY/";				
		$url = $bot_url."sendMessage?chat_id=-1001450856243&text=".urlencode($kirim)."&parse_mode=HTML";
		//$url = $bot_url."sendMessage?chat_id=1736274357&text=".urlencode($kirim)."&parse_mode=HTML";		
		$x = file_get_contents($url);
		}*/


	}

	public function sentold() {
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
				$ip = $jWHO['ip_addr'];
				$WHO = 'OK';
			}
		}
		else {
			$WHO = 'NOOK';
			$errorWHO = $soErrorWHO;
		}
		
		//Token
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
				
		
		//$ip = '180.241.249.154'; //IP Address
		//$ip = '36.85.42.180'; //IP Address // IP Null
		$ip = '10.60.170.38'; //IP Address		
		//NDbyIP
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
		// $soInfo = curl_getinfo($soNDbyIP);
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
			if(isset($jND['data']['ND']) && $jND['data']['ND'] != 'NULL'){
				$nd = $jND['data']['ND'];
				$NDbyIP = 'OK';
			}
		}
		else {
			$errorNDbyIP = $soErrorNDbyIP;
		}
		if($jND['statusMessage'] != 'OK'){
			$errorNDbyIP = $soResponseNDbyIP;
		}
		

		//Redaman
		$field = array(
			'input' =>	array(
				'nd' => '172424819749',
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
		$soResponse = curl_exec($soRedaman);
		$soError = curl_error($soRedaman);
		curl_close($soRedaman);
		$redaman = $soError;
		$RedamanStatus = 'NOOK';
		if($soError == '') {
			try {
				$jUkur= json_decode($soResponse, true);
			}
			catch(Exception $ex) {
				
			}
			if(isset($jUkur['onu_rx_pwr'])){
				$ukur = $jUkur['onu_rx_pwr'];
				$RedamanStatus = 'OK';
			} 
			else if(isset($jUkur['MESSAGE'])){ 
				$message = $jUkur['MESSAGE'];
			}
			if(isset($ukur)) {
				if($ukur) {
					$RedamanStatus = 'OK';
				}
			}
			else {
				if(isset($message)) {
					$redaman = $message;
				}
				else {
					$redaman = 'unable to read onu_rx_pwr element';
				}
			}
		}
		else {
			$redaman = $soError;
		}
		
		
		//PCRF
		$field = array(
			'serviceNumber' => '172424819749'
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
		$ResPCRFEror = '';
		$PCRFStatus = 'NOOK';
		if($soErrorPCRF == '') {
			try {
				$jPCRF = json_decode($soResponsePCRF, true);
			}
			catch(Exception $ex) {
				
			}
			if(isset($jPCRF['data']['getInfoUsageResponse']['package']) && $jPCRF['data']['getInfoUsageResponse']['package'] != 'NULL') {
					$packageName = $jPCRF['data']['getInfoUsageResponse']['package'];
					//$PCRFStatus = 'OK';
			}
			if(isset($packageName)) {
				$PCRFStatus = 'OK';
			}
			else {
				$ResPCRFEror = 'unable to get combination of package and quota';
			}
		}
		else {
			$ResPCRFEror = $soErrorPCRF;
		}
	

		
		//httpstatus
		$outputConsoleHTTP = array();
		exec('systemctl status httpd', $outputConsoleHTTP);
		$HTTPLine = explode(" ",$outputConsoleHTTP[2]);
		$StatusHTTP = $HTTPLine[4].' '.$HTTPLine[5];
		
		//$message = "".
		//	"<b><u>Closing Ticket Internet</u></b>"."\n".
		//	"<i>check time <u>".date("d-m-Y H:i")."</u></i>"."\n".
		//	"IP Test : ".$ip."\n".
		//	"ND Test : ".$nd."@telkom.net\n".
		//	""."\n".
		//	"Service:"."\n".
		//	
		// 	"Status HTTP : ".$StatusHTTP."\n".
		// 	"API WHO : ".$WHO.' '.$errorWHO."\n".
		//	"API Token : ".$Token.' '.$errorToken."\n".
		//	"API NDbyIP : ".$NDbyIP.' '.$errorNDbyIP."\n".
		//	//"API Redaman : ".$RedamanStatus.' '.$redaman."\n".
		//	"API PCRF : ".$PCRFStatus.' '.$ResPCRFEror."\n".
		// 	//"API Speedtest : ".$Speed.' '.$Speederror."\n".
		// 	""."\n"
		// ;
		
		$kirim = "";
		if($StatusHTTP !='active (running)' || $WHO !='OK' || $Token !='OK' || $NDbyIP !='OK' || $RedamanStatus !='OK' || $PCRFStatus !='OK') { 
		$kirim .= "<b><u>Closing Ticket Internet</u></b>"."\n".
					"<i>check time <u>".date("d-m-Y H:i")."</u></i>"."\n".
					"IP Test : ".$ip."\n".
					"ND Test : 172424819749@telkom.net\n".
					""."\n";
		}

		if($StatusHTTP !='active (running)') { 
			$kirim .= 'Status HTTP : '.$StatusHTTP.' '."\n";
		} 
		if($WHO !='OK') { 
			$kirim .= 'API WHO : '.$WHO.' '.$errorWHO.' '."\n";
		}
		if($Token !='OK') { 
			$kirim .= 'API Token : '.$Token.' '.$errorToken.' '."\n";
		}
		if($NDbyIP !='OK') { 
			$kirim .= 'API NDByIP : '.$NDbyIP.' '.$errorNDbyIP.' '."\n";
		}
		if($RedamanStatus !='OK') { 
			$kirim .= 'API Redaman : '.$RedamanStatus.' '.$redaman.' '."\n";
		} 
		if($PCRFStatus !='OK') { 
			$kirim .= 'API PCRF : '.$PCRFStatus.' '.$ResPCRFEror.' '."\n";
		} 

		echo $kirim;
		//Tele dev
		//echo $message;
		if($StatusHTTP !='active (running)' || $WHO != 'OK' || $Token != 'OK' || $NDbyIP != 'Ok' || $RedamanStatus != 'OK' || $PCRFStatus != 'Ok'){
		$bot_url = "https://api.telegram.org/bot2016937428:AAEnvN2uVk4uN4W2hJJ-_Fii0rYRp-xVJN0/";
		$url = $bot_url."sendMessage?chat_id=-1001797564330&text=".urlencode($kirim)."&parse_mode=HTML";
		$x = file_get_contents($url);
		}
		
		//Tele prod
		//$bot_url = "https://api.telegram.org/bot1095123335:AAEhU3HrjumjlnZG9_d5jTCmVhiNVJYPVnk/";
		//$url = $bot_url."sendMessage?chat_id=-1001450856243&text=".urlencode($kirim)."&parse_mode=HTML";
		//$x = file_get_contents($url);


	}
	
	public function senthttpd(){
		//httpstatus
		$outputConsoleHTTP = array();
		exec('systemctl status httpd', $outputConsoleHTTP);
		$HTTPLine = explode(" ",$outputConsoleHTTP[2]);
		$StatusHTTP = $HTTPLine[4].' '.$HTTPLine[5];
		//print_r($outputConsoleHTTP);

		$outputmem = array();
		exec('free -m', $outputmem);
		$MemLine = explode(" ",$outputmem[1]);
		$StatusMem = $MemLine[0].' '.$MemLine[10].' '.$MemLine[11].' '.$MemLine[20].' '.$MemLine[28].' '.$MemLine[37].' '.$MemLine[46].' '.$MemLine[54];

		$outputHDD = array();
		exec('df -h', $outputHDD);
		$HDDLine = explode(" ",$outputHDD[9]);
		$StatusHDD = $HDDLine[0].' '.$HDDLine[2].' '.$HDDLine[4].' '.$HDDLine[6].' '.$HDDLine[7].' '.$HDDLine[8];
		
		$ip = $_SERVER['SERVER_ADDR'];
		$pesan = "".
			"<b><u>Checking VM SCC</u></b>"."\n".
		 	"<i>check time <u>".date("d-m-Y H:i")."</u></i>"."\n".
			"IP Server : ".$ip."\n".
		
			""."\n".
			"<b><u>httpd: </u></b>"."\n".
			"HTTP Status: ".$StatusHTTP."\n".							
			""."\n".
			"<b><u>Memorry: </u></b>"."\n".
			"total: ".$MemLine[11].' '."Mb"."\n".
			"used: ".$MemLine[20].' '."Mb"."\n".
			"free: ".$MemLine[28].' '."Mb"."\n".
			"Shared: ".$MemLine[37].' '."Mb"."\n".
			"buf/Cache: ".$MemLine[46].' '."Mb"."\n".
			"available: ".$MemLine[54].' '."Mb"."\n".
			""."\n".
			"<b><u>Storage: </u></b>"."\n".
			"Size: ".$HDDLine[2]."\n".
			"Used: ".$HDDLine[4]."\n".
			"Avail: ".$HDDLine[6]."\n".
			"Use %: ".$HDDLine[7]."\n".
			"Dir: ".$HDDLine[8]."\n".
			""."\n"
			;
		echo $pesan;

		$bot_url = "https://api.telegram.org/bot2016937428:AAEnvN2uVk4uN4W2hJJ-_Fii0rYRp-xVJN0/";
		$url = $bot_url."sendMessage?chat_id=-1001797564330&text=".urlencode($pesan )."&parse_mode=HTML";
		$x = file_get_contents($url);

	}

	public function sentVM() {

		//httpstatus
		$outputConsoleHTTP = array();
		exec('systemctl status httpd', $outputConsoleHTTP);
		$HTTPLine = explode(" ",$outputConsoleHTTP[2]);
		$StatusHTTP = $HTTPLine[4].' '.$HTTPLine[5];
		//print_r($outputConsoleHTTP);

        	//memory
		$outputmem = array();
		exec('free -m', $outputmem);
		$MemLine = explode(" ",$outputmem[1]);
		$StatusMem = $MemLine[0].' '.$MemLine[10].' '.$MemLine[11].' '.$MemLine[20].' '.$MemLine[28].' '.$MemLine[37].' '.$MemLine[46].' '.$MemLine[54];

        	//storage
		$outputHDD = array();
		exec('df -h', $outputHDD);
		$HDDLine = explode(" ",$outputHDD[9]);
		$StatusHDD = $HDDLine[0].' '.$HDDLine[2].' '.$HDDLine[4].' '.$HDDLine[6].' '.$HDDLine[7].' '.$HDDLine[8];
		
		$pesan = "";
		if($StatusHTTP !='active (running)' || $MemLine[11] == 7820 || $MemLine[20] > 6000 || $MemLine[28] < 100 || $MemLine[37] > 6500 || $MemLine[46] >= 6512 || $MemLine[54] >= 6512 ||
		$HDDLine[2] != '1.2G' || $HDDLine[4] > '1.2G' || $HDDLine[6] < '1.3M' || $HDDLine[7] > 100 || $HDDLine[8] != '/home') { 
		$pesan .= "<b><u>Alert Error VM</u></b>"."\n".
			  "<i>check time <u>".date("d-m-Y H:i")."</u></i>"."\n".
			  "IP Test : ".$_SERVER['SERVER_ADDR']."\n".
			  ""."\n" ;
		}
                if($StatusHTTP !='active (running)') {		
			$pesan .= "<b><u>Httpd Status</u></b>"."\n" ;
		}

			if($StatusHTTP !='active (running)') { 
				$pesan .= 'Status HTTP : '.$StatusHTTP.' '."\n";
			} 
		if($MemLine[11] != 7820 || $MemLine[20] > 6000 || $MemLine[28] < 100 || $MemLine[37] > 6500 || $MemLine[46] >= 6512 || $MemLine[54] >= 6512) {
			$pesan .= "<b><u>Memory</u></b>"."\n" ;
		}
		
			if($MemLine[11] != 7820 ) {
				$pesan .= 'Total : '.$MemLine[11].' '."Mb".' '."\n";
			}
			if($MemLine[20] > 6000 ) { 
				$pesan .= 'used : '.$MemLine[20].' '."Mb".' '."\n";
			}
			if($MemLine[28] < 100 ) { 
				$pesan .= 'free : '.$MemLine[28].' '."Mb".' '."\n";
			}
			if($MemLine[37] > 6500 ) { 
				$pesan .= 'Shared : '.$MemLine[37].' '."Mb".' '."\n";
			}
			if($MemLine[46] >= 6512 ) { 
				$pesan .= 'buf/Cache : '.$MemLine[46].' '."Mb".' '."\n";
			}
			if($MemLine[54] >= 6512 ) { 
				$pesan .= 'available : '.$MemLine[54].' '."Mb".' '."\n";
			}
		if($HDDLine[2] != '1.2G' || $HDDLine[4] > '1.2G' || $HDDLine[6] < '1.3M' || $HDDLine[7] > 100 || $HDDLine[8] != '/home'){
			$pesan .= "<b><u>Storage</u></b>"."\n";
		}

           		 if($HDDLine[2] != '1.2G' ) { 
                		$pesan .= 'Size : '.$HDDLine[2].''."\n";
            		}
			
            		if($HDDLine[4] > '1.2G' ) { 
                		$pesan .= 'Used : '.$HDDLine[4].''."\n";
            		}
			
            		if($HDDLine[6] < '200M' ) { 
                		$pesan .= 'Avail : '.$HDDLine[6].''."\n";
           		}
			
            		if($HDDLine[7] > 80 ) { 
                		$pesan .= 'Use % : '.$HDDLine[7].''."\n";
            		}
			
            		if($HDDLine[8] != '/home' ) { 
                		$pesan .= 'Dir : '.$HDDLine[8].''."\n";
            		}
			
		echo $pesan;

		$bot_url = "https://api.telegram.org/bot2016937428:AAEnvN2uVk4uN4W2hJJ-_Fii0rYRp-xVJN0/";
		$url = $bot_url."sendMessage?chat_id=-1001797564330&text=".urlencode($pesan)."&parse_mode=HTML";
		$x = file_get_contents($url);
	}

}

		
		
