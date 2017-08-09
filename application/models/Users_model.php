<?php
Class Users_model extends Base_Model
{
	public function __construct()
	{
		parent::__construct();
		
	}
	
	public function getData($username, $password, $ip_address)
	{
		
		$this->db->select('*');
		$this->db->from('users');
		$this->db->from('whitelistips');
		$this->db->where('users.username',$username);
		$this->db->where('users.password',$password);
		$this->db->where('users.is_active', 1);
		$this->db->where('users.user_role_id !=',1);
		$this->db->where('whitelistips.ip_address',$ip_address);
		$this->db->where('whitelistips.is_active',1);
		$query = $this->db->get();
		
	
		if($query->num_rows() > 0)
		{
			return $query->row_array();
		}else
		{
			return false;
		}
	
	
	}
	
	public function getUsersList()
	{
		
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('roles','users.user_role_id = roles.role_id');
		$query = $this->db->get();
		
	
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}else
		{
			return false;
		}
	
	
	}
	
}