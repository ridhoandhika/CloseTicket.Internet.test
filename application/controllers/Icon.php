<?php
//namespace application/controllers;
defined('BASEPATH') OR exit('No direct script access allowed');

class Icon extends CI_Controller {
    
    function __construct() {
        parent::__construct();
    }

    public function index(){
         $this->ModelTemplate->render();
        //echo "sdfsd"; die();
        // $data      =  $this->db->get('icon');

        $this->load->view('icon/index');
        
    }
}