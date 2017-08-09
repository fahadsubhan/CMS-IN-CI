<?php
class LanguageLoader
{
	function initialize() {
		$ci =& get_instance();
		$ci->load->helper('language');
		
		if($ci->session->userdata('language'))
		{
			$language = $ci->session->userdata('language');
		} else
		{
			//$result = getDefaultLanguage();
	     	//$language = $result->GlobalCode;
		}
		$ci->lang->load('rest_controller', 'DE');
	}
}