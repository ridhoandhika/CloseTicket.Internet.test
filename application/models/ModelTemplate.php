<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelTemplate extends CI_Model {
	
	function __construct() {
		
		parent::__construct();
		
	}
	
	function render($pageData = array(), $pageScript = array(), $pageStyle = array()) {
		
		$pageFile = $this->router->fetch_directory().$this->router->fetch_class().'/'.$this->router->fetch_method();
		$pageView = $this->load->view($pageFile, $pageData, TRUE);
		$this->load->view('_template', array(
			'content' => $pageView,
			'script' => $pageScript,
			'style' => $pageStyle,
			'file' => $pageFile
		));
		
	}
	
}