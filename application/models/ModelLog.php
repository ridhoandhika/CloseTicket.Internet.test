<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelLog extends CI_Model {
	
	function __construct() {
		
		parent::__construct();
		
	}
	
	function write($filename = '', $content = '') {
		
		$return = array(
			'success' => false
		);
		$error = array();
		$pathBase = '_log/';
		$pathDetail = '';
		if(!file_exists($pathBase.$pathDetail)) {
			mkdir($pathBase.$pathDetail);
		}
		$pathDetail .= date('Y/');
		if(!file_exists($pathBase.$pathDetail)) {
			mkdir($pathBase.$pathDetail);
		}
		$pathDetail .= date('m/');
		if(!file_exists($pathBase.$pathDetail)) {
			mkdir($pathBase.$pathDetail);
		}
		$pathDetail .= date('d/');
		if(!file_exists($pathBase.$pathDetail)) {
			mkdir($pathBase.$pathDetail);
		}
		$fp = fopen($pathBase.$pathDetail.$filename, 'w');
		$fw = fwrite($fp, $content);
		fclose($fp);
		if($fw != false) {
			$return['success'] = true;
			$return['data'] = array(
				'file' => $pathDetail.$filename
			);
		}
		if(count($error) > 0) {
			$return['error'] = $error;
		}
		return $return;
		
	}

	function writelog($filename = '', $content = '') {
		
		$return = array(
			'success' => false
		);
		$error = array();
		$pathBase = '_log/';
		$pathDetail = '';
		if(!file_exists($pathBase.$pathDetail)) {
			mkdir($pathBase.$pathDetail);
		}
		$pathDetail .= 'getresult/';
		if(!file_exists($pathBase.$pathDetail)) {
			mkdir($pathBase.$pathDetail);
		}
		$pathDetail .= date('Y/');
		if(!file_exists($pathBase.$pathDetail)) {
			mkdir($pathBase.$pathDetail);
		}
		$pathDetail .= date('m/');
		if(!file_exists($pathBase.$pathDetail)) {
			mkdir($pathBase.$pathDetail);
		}
		$pathDetail .= date('d/');
		if(!file_exists($pathBase.$pathDetail)) {
			mkdir($pathBase.$pathDetail);
		}
		$fp = fopen($pathBase.$pathDetail.$filename, 'w');
		$fw = fwrite($fp, $content);
		fclose($fp);
		if($fw != false) {
			$return['success'] = true;
			$return['data'] = array(
				'file' => $pathDetail.$filename
			);
		}
		if(count($error) > 0) {
			$return['error'] = $error;
		}
		return $return;
		
	}
	
}