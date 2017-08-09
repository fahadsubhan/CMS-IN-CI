<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rolemanagement extends Base_Controller {
	public 	$data = array();
	
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('Roles_model');
		$this->data['is_login'] = $this->is_login;
		$this->data['is_admin'] = $this->is_admin;
	}
	 
	public function index()
	{
		
		if($this->is_admin)
		{
			$this->data['roleslist'] = $this->Roles_model->get_records();
			$this->data['view'] = 'admin/rolemanagement/index';
			$this->data['script'] = '<script>
	$(document).ready(function(e) {
       $(".delete_row").on( "click", function() 
	   {
 		 console.log($(this).attr("id"));
		 $("#delete .delete_url").attr("href", "'.site_url('admin/rolemanagement/delete/').'"+$(this).attr("id"));
		 $("#delete").modal("show")
		});
    });
</script>';
			$this->load->view('admin/default',$this->data);
		}
		else
		redirect(site_url('admin/dashboard/login'));
		
	}
	
	//Add New Role
	public function add() 
	{
		if(!$this->is_admin)
		{
			redirect(site_url('admin/dashboard/login'));
		}
		$this->form_validation->set_rules('role_title', 'Role Title', 'trim|required');
		$this->form_validation->set_rules('role_key', 'Role key', 'trim|required|min_length[4]|max_length[75]|alpha_numeric');
		
		if ($this->form_validation->run() === false) 
		{
			$this->data['view'] = 'admin/rolemanagement/add';
			$this->load->view('admin/default',$this->data);
			
		} 
		else 
		{
			
			$role_title = $this->input->post('role_title');
			$role_key    = $this->input->post('role_key');
			$role_status   = ($this->input->post('role_status')=='on')?1:0;
			
			$roleData = array(
			'role_title'   => $role_title,
			'role_key'      => $role_key,
			'role_status'   => $role_status,
			'role_created_date'   => date('Y-m-j H:i:s')
		);
		
		$result = $this->Roles_model->insert($roleData);
			
			if ($result) 
			{
				$this->session->set_flashdata('success_msg', 'Successfully added');
				redirect(site_url('admin/rolemanagement/'));
			} 
			else 
			{
				$this->data['error'] = 'There was a problem creating your new account. Please try again.';
				$this->data['view'] = 'admin/rolemanagement/add';
				$this->load->view('admin/default',$this->data);
			}
			
		}
		
	}
	
	//Update Roles
	public function update($id) 
	{
		if(!$this->is_admin)
		{
			redirect(site_url('admin/dashboard/login'));
		}
		$this->form_validation->set_rules('role_title', 'Role Title', 'trim|required');
		$this->form_validation->set_rules('role_key', 'Role key', 'trim|required|min_length[4]|max_length[75]|alpha_numeric');
		$this->form_validation->set_rules('roleID', '', 'required');
		
		if ($this->form_validation->run() === false) 
		{
			$this->data['roleID'] = $id;
			$this->data['roleDetails'] = $this->Roles_model->getByPK($id);
			$this->data['view'] = 'admin/rolemanagement/update';
			$this->load->view('admin/default',$this->data);
			
		} 
		else 
		{
			
			$role_title = $this->input->post('role_title');
			$role_key    = $this->input->post('role_key');
			$role_status   = ($this->input->post('role_status')=='on')?1:0;
			
			$roleData = array(
			'role_title'   => $role_title,
			'role_key'      => $role_key,
			'role_status'   => $role_status,
			);
		
	
			$result = $this->Roles_model->updateByPK($roleData, $id);
			
			if ($result) 
			{
				$this->session->set_flashdata('success_msg', 'Record Updated Successfully');
				redirect(site_url('admin/rolemanagement/'));
			}else
			{
				$this->data['error'] = 'There was a problem in updating. Please try again.';
				$this->data['roleID'] = $id;
				$this->data['roleDetails'] = $this->Roles_model->getByPK($id);
				$this->data['view'] = 'admin/rolemanagement/update';
				$this->load->view('admin/default',$this->data);
			}
			
		}
		
	}
	//Update Status
	public function status($status, $id)
	{
		$roleData = array(
			'role_status'   => $status
		);

		$result = $this->Roles_model->updateByPK($roleData, $id);
		if($status)
			$msg = 'Successfully Enabled';
		else
			$msg = 'Successfully Disabled';
		
		if ($result) 
		{
			$this->session->set_flashdata('success_msg', $msg);
			redirect(site_url('admin/rolemanagement/'));
		} 
		
	}
	//Delete Record
	public function delete($id)
	{

		$result = $this->Roles_model->deleteByPK($id);
		
		if ($result) 
		{
			$this->session->set_flashdata('success_msg', 'Successfully Delete');
			redirect(site_url('admin/rolemanagement/'));
		} 
		
	}

}
