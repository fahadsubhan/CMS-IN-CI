<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Base_Controller {
	public 	$data = array();

	public function __construct() 
	{
		parent::__construct();
		$this->data['is_login'] = $this->is_login;
		$this->data['is_admin'] = $this->is_admin;
	}
	
	public function index()
	{
			$this->data['view'] = 'frontend/home/home';
			$this->load->view('frontend/default',$this->data);
	}
	
	
}
