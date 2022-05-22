<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
	
	function __construct() {
		
		
        parent::__construct();
		
	}
		public function ookla() {
		echo '<iframe width="100%" height="650px" frameborder="0" src="https://test-inf-1.speedtestcustom.com"></iframe>';
	}

	public function ookla2() {
		echo '<iframe width="100%" height="650px" frameborder="0" src="https://test-inf-2.speedtestcustom.com"></iframe>';
	}
	public function icon() {
		$this->view('icon');
	}
	public function ukur($nd)	{
		header('Content-Type: application/xml; charset=utf-8');
		$soBody = '
			<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:soap="http://ibooster.telkom.co.id/api/soap.php">
			   <soapenv:Header/>
			   <soapenv:Body>
				  <soap:ukur_indikasi soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
					 <input xsi:type="ibo:ukur_in" xmlns:ibo="http://10.62.165.36/soap/iBooster">
						<!--You may enter the following 2 items in any order-->
						<nd xsi:type="xsd:string">'.$nd.'</nd>
						<realm xsi:type="xsd:string">@telkom.net</realm>
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
		curl_close($soCh);
		
		echo '<pre>';
		echo htmlspecialchars($soResponse, ENT_QUOTES);
		echo '</pre>';
	}


	public function myip($nd) {
		header('Access-Control-Allow-Origin: *');
		//if($ip != ''){
		//	$output['ip_addr'] = null;
		//	if($ip == '4'){
		//		$output['ip_addr'] = '125.161.215.125';
		//	}
		//	if($ip == '6'){
		//		$output['ip_addr'] = '2001:448a:304c:7fab::/64';
		//		$output['username'] = '122302257390@telkom.net';
		//	}
		//}else{
		//	$output['err'] = 'empty';
		//}
		$output['onu_rx_pwr'] = null;
		$output['version_id'] = '';
		$output['identifier']= 'GPON03-D7-TIM-3';
		$output['reg_type'] = 'ZTEG-F609';
		echo json_encode($output);
	}

	public function ipradius(){
		$output = array(
			'success' => false
		);
		$soBody = http_build_query(array(
			'grant_type' => 'client_credentials', 
			'client_id' => '1deb0ee9-69c0-4419-abf8-8edcb8da5d13', 
			'client_secret' => 'ea107442-23d4-4487-9f37-b8757fc2614d' 
		));
		for($iRetry = 0; $iRetry < 5; $iRetry++) {
			$soCh = curl_init();
			$urltoken = 'https://apigwsit.telkom.co.id:7777/invoke/pub.apigateway.oauth2/getAccessToken';
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
			'Content-Type: application/json',
			'Authorization: Bearer '.$bearer
		);
		$field = array(
			'username' => '122302257390',
			'realm' => 'telkom.net'
		);
		$soBody = json_encode($field, true);
		
		$soCh = curl_init();
		curl_setopt($soCh, CURLOPT_URL, 'https://apigwsit.telkom.co.id:7777/gateway/telkom-radius/1.0/getUsageOnline');
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
		$ipradius = json_decode($soResponse, true);
		$chSuccess = 0;
		
		if($soError == '') {
			$chSuccess = 1;
			try {
				$jipradius = json_decode($soResponse, true);
			}
			catch(Exception $ex) {
				
			}

			if(isset($jipradius['returnMessage']) == 'OK'){
				$frameip = $jipradius['output']['Framed-IP-Address'];
				
			}
		}
		else {
			$error[] = $soError;
		}
		// echo json_encode($jipradius);

		if(isset($bearer)) {
		$output['success'] = true;
		$output['data'] = array(
			'Bearer' => $bearer,
			'frame-ip' => $frameip
		);}
		header('Content-Type: application/json');
		echo json_encode($output);
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
						'TICKETID' => 'IN129068126'
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
		$soResponse = curl_exec($soCh);
		$soInfo = curl_getinfo($soCh);
		$httpcode = curl_getinfo($soCh, CURLINFO_HTTP_CODE);
		$soError = curl_error($soCh);
		
		curl_close($soCh);
		
		$ipradius = json_decode($soResponse, true);
		$chSuccess = 0;

		$nd = $ipradius['QueryTK_INCIDENTResponse']['TK_INCIDENTSet']['INCIDENT']['TK_SERVICENO'];
	//	$nde = $ipradius['QueryTK_INCIDENTResponse']['TK_INCIDENTSet']['INCIDENT']['ASSETNUM'];
	//	$ndEx = explode('_', $nde);
		$output['success'] = true;
		$output['data'] = array(
			'nd' => $nd
		//	'nde' => $ndEx[1]
		);
	
		echo json_encode($output, JSON_PRETTY_PRINT);
	}

	public function speed(){
		$input = array(
			"credential_id" => "app-mycx",
			"credential_secret" => "UMaFYkpuQbxY41YOsYoB",
			"user_id" => "unique user id",
			"nd" => "122302257390"
		);
		$data = json_encode($input);		

		$method = 'AES-256-CBC';
		$key ='50be0febf0809b2778df3270f3b6c43c';
		$IV = '5511cfa1205c482c';
		$plaintext = $data;
		
		

		$encrypted = openssl_encrypt($plaintext,$method,$key, OPENSSL_RAW_DATA, $IV);
		$encrypted = base64_encode($encrypted);
		$tes = urlencode($encrypted);
		echo $tes;
	}
	
}
