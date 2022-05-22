<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
	var $remoteIP;
	
	function __construct() {
		
        parent::__construct();
		$this->remoteIP = $_SERVER['REMOTE_ADDR'];
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$this->remoteIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		header('X-Frame-Options: SAMEORIGIN');
		
	}
	
	public function test123()	{
		echo 'x';
	}
	public function index()	{
		
		$token = 0;
		foreach($this->config->item('whitelist') as $cidr) {
			$range = cidrToRange($cidr);
			if(ip2long($range[0]) <= ip2long($this->remoteIP) && ip2long($this->remoteIP) <= ip2long($range[1])) {
				$token++;
				break;
			}
		}
		$pageData = array(
			'ip' => $this->remoteIP,
			'whitelist' => $token
		);
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
				module,
				ts
			)
			VALUES (
				'.$this->db->escape($this->remoteIP).',
				'.$this->db->escape($qrange).',
				'.$this->db->escape($this->session->session_id).',
				'.$this->db->escape($qWhitelisted).',
				\'Welcome\',
				NOW()
			)
			ON DUPLICATE KEY UPDATE
				ts = VALUES(ts)
		');
		$this->ModelTemplate->render($pageData);
		
	}
	
}
