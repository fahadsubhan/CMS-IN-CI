<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends Base_Controller {
	public 	$data = array();
	
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('Users_model');
		$this->load->model('Roles_model');
		$this->data['is_login'] = $this->is_login;
		$this->data['is_admin'] = $this->is_admin;
	}
	 
	public function index()
	{
		
		if($this->is_admin)
		{
			$this->data['employeeslist'] = $this->Users_model->getUsersList();
			$this->data['view'] = 'admin/employee/index';
			$this->data['script'] = '<script>
	$(document).ready(function(e) {
       $(".delete_row").on( "click", function() 
	   {
 		 console.log($(this).attr("id"));
		 $("#delete .delete_url").attr("href", "'.site_url('admin/employee/delete/').'"+$(this).attr("id"));
		 $("#delete").modal("show")
		});
    });
</script>';
			$this->load->view('admin/default',$this->data);
		}
		else
		redirect(site_url('admin/dashboard/login'));
		
	}
	
	//Add Ip in the white list
	public function add() 
	{
		if(!$this->is_admin)
		{
			redirect(site_url('admin/dashboard/login'));
		}
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|is_unique[users.username]', array('is_unique' => 'This username already exists. Please choose another one.'));
		$this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|is_unique[users.user_email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');
		$this->form_validation->set_rules('role_id', 'User Role', 'required');
		
		if ($this->form_validation->run() === false) 
		{
			$this->data['roleslist']=$this->Roles_model->get_records();
			$this->data['view'] = 'admin/employee/add';
			$this->load->view('admin/default',$this->data);
			
		} 
		else 
		{
			
			$username = $this->input->post('username');
			$user_email    = $this->input->post('user_email');
			$password = $this->input->post('password');
			$role_id = $this->input->post('role_id');
			//Be Default User Active
			$is_active = 1;
			
			$accountData = array(
			'username'   => $username,
			'user_email'      => $user_email,
			'password'   => md5($password),
			'created_at' => date('Y-m-j H:i:s'),
			'user_role_id'      => $role_id,
			'is_active' => $is_active
			);
		
			$result = $this->Users_model->insert($accountData);
			
			if ($result) 
			{
				$this->session->set_flashdata('success_msg', 'Successfully added');
				redirect(site_url('admin/employee/'));
			} 
			else 
			{
				$this->data['roleslist']=$this->Roles_model->get_records();
				$this->data['error'] = 'There was a problem creating your new account. Please try again.';
				$this->data['view'] = 'admin/employee/add';
				$this->load->view('admin/default',$this->data);
			}
			
		}
		
	}
	
	//Update Ip in the white list
	public function update($user_id) 
	{
		if(!$this->is_admin)
		{
			redirect(site_url('admin/dashboard/login'));
		}
		
		if($this->input->post('old_user_email')!=$this->input->post('user_email'))
		{
			$this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|is_unique[users.user_email]');
		}
		
		$this->form_validation->set_rules('password', 'Password', 'trim|min_length[6]');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|min_length[6]|matches[password]');
		$this->form_validation->set_rules('role_id', 'User Role', 'required');
		
		if ($this->form_validation->run() === false) 
		{
			$this->data['userID'] = $user_id;
			$this->data['roleslist']=$this->Roles_model->get_records();
			$this->data['userDetails'] = $this->Users_model->getByPK($user_id);
			$this->data['view'] = 'admin/employee/update';
			$this->load->view('admin/default',$this->data);
			
		} 
		else 
		{
			
			$user_email    = $this->input->post('user_email');
			$password = $this->input->post('password');
			$role_id = $this->input->post('role_id');
			
			$accountData = array(
			'user_email'      => $user_email,
			'updated_at' => date('Y-m-j H:i:s'),
			'user_role_id'      => $role_id
			);
		
			if($password!='')
			$accountData['password'] =  md5($password);
	
			$result = $this->Users_model->updateByPK($accountData, $user_id);
			
			if ($result) 
			{
				$this->session->set_flashdata('success_msg', 'Record Updated Successfully');
				redirect(site_url('admin/employee/'));
			}else
			{
				$this->data['error'] = 'There was a problem in updating. Please try again.';
				$this->data['userID'] = $user_id;
				$this->data['roleslist']=$this->Roles_model->get_records();
				$this->data['userDetails'] = $this->Users_model->getByPK($user_id);
				$this->data['view'] = 'admin/employee/update';
				$this->load->view('admin/default',$this->data);
			}
			
		}
		
	}
	
	public function status($status, $id)
	{
		$userData = array(
			'is_active'   => $status
		);

		$result = $this->Users_model->updateByPK($userData, $id);
		if($status)
			$msg = 'Successfully Enabled';
		else
			$msg = 'Successfully Disabled';
		
		if ($result) 
		{
			$this->session->set_flashdata('success_msg', $msg);
			redirect(site_url('admin/employee/'));
		} 
		
	}
	
	public function delete($id)
	{

		$result = $this->Users_model->deleteByPK($id);
		
		if ($result) 
		{
			$this->session->set_flashdata('success_msg', 'Successfully Delete');
			redirect(site_url('admin/employee/'));
		} 
		
	}

}
