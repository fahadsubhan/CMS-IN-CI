<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Base_Controller {
	public 	$data = array();
	
	public function __construct() 
	{
		parent::__construct();	
		$this->load->model('Users_model');
		$this->data['is_login'] = $this->is_login;
		$this->data['is_admin'] = $this->is_admin;		

	}
	 
	public function index()
	{
		if($this->is_admin)
		{
			$this->data['view'] = 'admin/dashboard/index';
			$this->load->view('admin/default',$this->data);
		}
		else
		redirect(base_url('admin/dashboard/login'));
		
	}
	
	
	//User Login
	public function login() 
	{
		if($this->is_admin)
		{
			redirect(base_url('admin/dashboard'));
		}
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run() == false) 
		{
			$this->data['view'] = 'admin/dashboard/login';
			$this->load->view('admin/default',$this->data);
			
		} 
		else 
		{

			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			$userdata = $this->login_permission($username, $password);
			if($userdata!=false) 
			{
				$this->set_access($userdata);
				redirect(base_url('admin/dashboard'));
			} 
			else 
			{
				// login failed
				$this->data['error'] = 'Wrong username or password.';
				$this->data['view'] = 'admin/dashboard/login';
				$this->load->view('admin/default',$this->data);
				
				
				
			}
			
		}
		
	}

	
	
	private function login_permission($username=false, $password=false)
	{
		$result = $this->Users_model->get_record(array('username'=>$username, 'password'=>md5($password), 'user_role_id'=>1));
		if($result)
		return $result;
		else
		return false;
	}
	

	
	
	//Logout
	public function logout() 
	{
		if ($this->session->userdata('logged_in') === true&&$this->session->userdata('user_role') == 1)
		{
			$this->unset_access();
			redirect(base_url('admin/dashboard/login'));
			
		} 
		else 
		{
			redirect('/');
			
		}
		
	}
}
