<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ipmanagement extends Base_Controller {
	public 	$data = array();
	
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('Whitelistips_model');
		$this->data['is_login'] = $this->is_login;
		$this->data['is_admin'] = $this->is_admin;
	}
	 
	public function index()
	{
		
		if($this->is_admin)
		{
			$this->data['ipslist'] = $this->Whitelistips_model->get_records();
			$this->data['view'] = 'admin/ipmanagement/index';
			$this->data['script'] = '<script>
	$(document).ready(function(e) {
       $(".delete_row").on( "click", function() 
	   {
 		 console.log($(this).attr("id"));
		 $("#delete .delete_url").attr("href", "'.site_url('admin/ipmanagement/delete/').'"+$(this).attr("id"));
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
		$this->form_validation->set_rules('ip_address', 'Ip Address', 'trim|required');
		
		if ($this->form_validation->run() === false) 
		{
			$this->data['view'] = 'admin/ipmanagement/add';
			$this->load->view('admin/default',$this->data);
			
		} 
		else 
		{
			
			$title = $this->input->post('title');
			$ip_address    = $this->input->post('ip_address');
			$is_active   = ($this->input->post('is_active')=='on')?1:0;
			
			$ipData = array(
			'title'   => $title,
			'ip_address'      => $ip_address,
			'is_active'   => $is_active
		);
		
		$result = $this->Whitelistips_model->insert($ipData);
			
			if ($result) 
			{
				$this->session->set_flashdata('success_msg', 'Successfully added');
				redirect(site_url('admin/ipmanagement/'));
			} 
			else 
			{
				$this->data['error'] = 'There was a problem creating your new account. Please try again.';
				$this->data['view'] = 'admin/ipmanagement/add';
				$this->load->view('admin/default',$this->data);
			}
			
		}
		
	}
	
		//Update Ip in the white list
	public function update($id) 
	{
		if(!$this->is_admin)
		{
			redirect(site_url('admin/dashboard/login'));
		}
		$this->form_validation->set_rules('ip_address', 'Ip Address', 'trim|required');
		$this->form_validation->set_rules('ip_id', 'Ip ID', 'required');
		
		if ($this->form_validation->run() === false) 
		{
			$this->data['ipID'] = $id;
			$this->data['ipDetails'] = $this->Whitelistips_model->getByPK($id);
			$this->data['view'] = 'admin/ipmanagement/update';
			$this->load->view('admin/default',$this->data);
			
		} 
		else 
		{
			
			$title = $this->input->post('title');
			$ip_address    = $this->input->post('ip_address');
			$is_active   = ($this->input->post('is_active')=='on')?1:0;
			
			$ipData = array(
			'title'   => $title,
			'ip_address'      => $ip_address,
			'is_active'   => $is_active
			);
		
	
			$result = $this->Whitelistips_model->updateByPK($ipData, $id);
			
			if ($result) 
			{
				$this->session->set_flashdata('success_msg', 'Record Updated Successfully');
				redirect(site_url('admin/ipmanagement/'));
			}else
			{
				$this->data['error'] = 'There was a problem in updating. Please try again.';
				$this->data['ipID'] = $id;
				$this->data['ipDetails'] = $this->Whitelistips_model->getByPK($id);
				$this->data['view'] = 'admin/ipmanagement/update';
				$this->load->view('admin/default',$this->data);
			}
			
		}
		
	}
	
	public function status($status, $id)
	{
		$ipData = array(
			'is_active'   => $status
		);

		$result = $this->Whitelistips_model->updateByPK($ipData, $id);
		if($status)
			$msg = 'Successfully Enabled';
		else
			$msg = 'Successfully Disabled';
		
		if ($result) 
		{
			$this->session->set_flashdata('success_msg', $msg);
			redirect(site_url('admin/ipmanagement/'));
		} 
		
	}
	
	public function delete($id)
	{

		$result = $this->Whitelistips_model->deleteByPK($id);
		
		if ($result) 
		{
			$this->session->set_flashdata('success_msg', 'Successfully Delete');
			redirect(site_url('admin/ipmanagement/'));
		} 
		
	}

}
