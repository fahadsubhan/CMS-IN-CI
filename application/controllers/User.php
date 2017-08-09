<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Base_Controller {
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
		if($this->is_login)
		{
			redirect(base_url('user/account'));
		}
		else
		{
			redirect(base_url('user/login'));
		}
	}
	
	//User Register
	public function register() 
	{
		if($this->is_login)
		{
			redirect(base_url('user/account'));
		}
		$this->data['regsuccess'] = false;
		$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|is_unique[users.username]', array('is_unique' => 'This username already exists. Please choose another one.'));
		$this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|is_unique[users.user_email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');
		
		if ($this->form_validation->run() === false) 
		{
			$this->data['view'] = 'frontend/user/register';
			$this->load->view('frontend/default',$this->data);
			
		} 
		else 
		{
			
			$username = $this->input->post('username');
			$user_email    = $this->input->post('user_email');
			$password = $this->input->post('password');
			//By Default Role ID 2 For Subscriber
			$user_role_id = 2;
			//Be Default User Active
			$is_active = 1;
			
			$accountData = array(
			'username'   => $username,
			'user_email'      => $user_email,
			'password'   => md5($password),
			'created_at' => date('Y-m-j H:i:s'),
			'user_role_id' => $user_role_id,
			'is_active' => $is_active
		);
		
		$result = $this->Users_model->insert($accountData);
			
			if ($result) 
			{
				$this->data['regsuccess'] = true;
				$this->data['view'] = 'frontend/user/register';
				$this->load->view('frontend/default',$this->data);
			} 
			else 
			{
				$this->data['error'] = 'There was a problem creating your new account. Please try again.';
				$this->data['view'] = 'frontend/user/register';
				$this->load->view('frontend/default',$this->data);
			}
			
		}
		
	}
	
	
	//User Login
	public function login() 
	{
		if($this->is_login)
		{
			redirect(base_url('user/account'));
		}
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run() == false) 
		{
			$this->data['view'] = 'frontend/user/login';
			$this->load->view('frontend/default',$this->data);
			
		} 
		else 
		{

			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			$userdata = $this->login_permission($username,  md5($password));
			if($userdata!=false) 
			{
				$this->set_access($userdata);
				redirect(base_url('user/account'));
			} 
			else 
			{
				// login failed
				$this->data['error'] = 'Login Failed, Try Again';
				$this->data['view'] = 'frontend/user/login';
				$this->load->view('frontend/default',$this->data);
				
				
				
			}
			
		}
		
	}
	
	//User Account
	public function account() 
	{
		if(!$this->is_login)
		{
			redirect(base_url('user/login'));
		}

		$this->data['userID'] = $this->user_id;
		$this->data['userDetails'] = $this->Users_model->getByPK($this->user_id);

		if($this->session->userdata('user_email')!=$this->input->post('user_email'))
		{
			$this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|is_unique[users.user_email]');
		}
		
		$this->form_validation->set_rules('password', 'Password', 'trim|min_length[6]');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|min_length[6]|matches[password]');
		$this->form_validation->set_rules('user_id', '', 'required');
		
		if ($this->form_validation->run() === false) 
		{
			$this->data['view'] = 'frontend/user/account';
			$this->load->view('frontend/default',$this->data);
			
		} 
		else 
		{
			
			$user_email    = $this->input->post('user_email');
			$password = $this->input->post('password');
			
			$accountData = array(
			'user_email'      => $user_email,
			'updated_at' => date('Y-m-j H:i:s'),
		);
		
			if($password!='')
			$accountData['password'] =  md5($password);
		
			$result = $this->Users_model->updateByPK($accountData, $this->user_id);
			
			if ($result) 
			{
				$this->session->set_userdata('user_email',$user_email);
				$this->session->set_flashdata('success_msg', 'Record Updated Successfully');
				redirect(base_url('user/account'));
			} 
			else 
			{
				$this->data['error'] = 'There was a problem updating your new account. Please try again.';
				$this->data['view'] = 'frontend/user/account';
				$this->load->view('frontend/default',$this->data);
			}
			
		}
		
	}
	
	
	
	private function login_permission($username=false, $password=false)
	{
		if($this->config->item('is_iplogin'))
		{
			$ip_address = $this->input->ip_address();
			$result = $this->Users_model->getData($username, $password, $ip_address);
		}
		else
		{
			$result = $this->Users_model->get_record(array('username'=>$username, 'password'=>$password, 'is_active'=>1, 'user_role_id !='=>1));
		}
		if($result)
		return $result;
		else
		return false;
	}
	

	
	
	//Logout
	public function logout() 
	{
		if ($this->session->userdata('logged_in') === true)
		{
			$this->unset_access();
			redirect(base_url('user/login'));
			
		} 
		else 
		{
			redirect('/');
			
		}
		
	}
}
