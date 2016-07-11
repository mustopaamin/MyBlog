<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * Role Module Class
 * Role Module ini hanya untuk settingan pribadi. Dengan settingan yang sudah ada.
 * 
 * @package		CodeIgniter
 * @category	Libraries
 * @author		Mustopa Amin
 * @copyright	Copyright (c) 2015 - now, Mustopa Amin, Inc.
 * @since		Version 0.1
 * @email		mustopaamin@ymail.com , mustopaamin@gmail.com
 */

// ------------------------------------------------------------------------

class Rolemodule {
	
	// Global container variables for chained argument results
	protected $ci;			
	
	
	var	$t_module		= 't_module';		// set table module
	var	$t_role_module	= 't_role_module';	// set table role module
	var	$columns		= 'f_module_class';		// set name field in table (only 1)
	var	$columns_id 	= 'f_module_id';		// set name field id in table (only 1)
	var	$module			= '';				// set name module (only 1)
	var	$roleid			= '';				// set session role id /  
	
	// fields in table $t_role_module
	var	$columns_roleid	= 'f_role_id';		
	var	$columns_modid	= 'f_module_id';
	var	$columns_add	= 'f_add_button_status';
	var	$columns_edit	= 'f_edit_button_status';
	var	$columns_delete	= 'f_delete_button_status';
	var	$columns_export	= 'f_export_button_status';
	var	$columns_import	= 'f_import_button_status';
	
	public function __construct($params = array())
	{
		if (count($params) > 0)
		{
			$this->initialize($params);
		}
		
		$this->ci =& get_instance();
		
		$this->session_web();
		$this->view_page();
		log_message('debug', "Rolemodule Class Initialized");
	}

	/**
	 * Initialize Preferences
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 * @return	void
	 */
	function initialize($params = array())
	{
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				if (isset($this->$key))
				{
					$this->$key = $val;
				}
			}
		}
	}
	
	/**
	 * Session Web
	 * Pengecekan session
	 */
	function session_web()
	{
		if($this->roleid != '' || $this->roleid > 0 )
		{
			return true;
		}
		else
		{
			$this->ci->session->set_userdata('LOGMSG', 'Sesi anda sudah habis ...');
			redirect('webadmin');
			exit($msg);
		}
	}
	
	/**
	 * Find ID Module
	 * Pencarian Id Module untuk table role_module
	 */
	function find_id_module()
	{
		$field_id = $this->columns_id;
		$this->ci->db->select($field_id);
		$this->ci->db->where($this->columns,$this->module);
		$module_id = $this->ci->db->get($this->t_module)->row();
		return $module_id->$field_id;
	}
	
	/**
	 * View page
	 * Pengecekan Akses ke halaman ini
	 */
	function view_page()
	{
		$module_id = $this->find_id_module();
		$this->ci->db->where($this->columns_roleid,$this->roleid);
		$this->ci->db->where($this->columns_modid,$module_id);
		$sql = $this->ci->db->get($this->t_role_module);
		if($sql->num_rows() > 0)
		{
			return true;
		}
		else
		{
			$data['content']	= 'accesdenied';
			$msg = $this->ci->load->view('webadmin/main',$data,true);
			exit($msg);
		}
	}
	
	/**
	 * Select button
	 * Option pengecekan button
	 */
	function select_button($select = 'add')
	{
		$button = array(
				'add' => $this->columns_add,
				'edit' => $this->columns_edit,
				'delete' => $this->columns_delete,
				'export' => $this->columns_export,
				'import' => $this->columns_import,
			);
		
		return $button[$select];	
	}
	
	/**
	 * Check button
	 * Pengecekan button di halaman tersebut
	 */
	function check_button($select = 'add')
	{
		$module_id = $this->find_id_module();
		$col = $this->select_button($select);
		$this->ci->db->select($col);
		$this->ci->db->where($this->columns_roleid,$this->roleid);
		$this->ci->db->where($this->columns_modid,$module_id);
		$sql = $this->ci->db->get($this->t_role_module);
		if($sql->num_rows() > 0)
		{
			$row = $sql->row();
			if($row->$col == 1)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}
	
}

// END Rolemodule class
/* End of file Rolemodule.php */
/* Location: ./application/libraries/Rolemodule.php */
