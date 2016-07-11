<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Webadmin extends MX_Controller {

	 
	function __construct()
	{
		parent::__construct();
		$this->load->model('mo_admin','ma');
	}
	
	public function index()
	{
		$StatusLogin=$this->session->userdata('sStatus');
		if(!$StatusLogin || $StatusLogin == 0) {
			$this->BelumLogin();
		} else {
			$this->TelahLogin();
		}
	}
	
	public function BelumLogin()
	{
		$this->load->view('vw_login');
	}
	
	public function ProsesLogin()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		$Login = $this->ma->Auth($username,$password);
		//echo print_r($cekLogin);
		if(!$Login)
		{
			echo json_encode(array('msg'=>'User/Password Salah!!!')); 
		}
		else
		{
			//echo print_r($cekLogin);
			$sLogin = array(
				'sId' => $Login->f_user_id,
				'sEmail' => $Login->f_user_email,
				'sName' => $Login->f_user_name,
				//'sPassword' => $Login->f_user_password,
				'sRoleId' => $Login->f_user_role,
				//'sRoleName' => $Login->rolename,
				//'sEmpId' => $Login->f_emp_id,
				//'sBranchId' => $Login->f_comp_branch_id,
				'sStatus' => $Login->f_user_active,
				'validated' => true,
			);
			$this->session->set_userdata($sLogin);
			echo json_encode(array('msg'=>'sukses')); 
		}
	}
	
	public function TelahLogin()
	{
		$data['app_title']	= 'Admin MyBlog';
		$data['content']	= 'webadmin/blank';
		$this->load->view('webadmin/main',$data);
	}
	
	function ProsesLogout()
	{
			$sLogin = array(
				'sId' => '',
				'sName' => '',
				'sPassword' => '',
				'sRoleId' => '',
				'sRoleName' => '',
				'sLimitStatus' => '',
				'sEmpId' => '',
				'sBranchId' => '',
				'sStatus' => false,
				'validated' => false,
			);

		$this->session->unset_userdata($sLogin);
		$this->session->sess_destroy();
		redirect( base_url(),'refresh');
	}
	
	function registrasi()
	{
		$this->auth->check_isvalidated();
		$this->load->library('datatables');
		
		$this->datatables->select('',false);
		$this->datatables->where('a.f_training_schedule_status', 'Open');
        
		$this->datatables->join('t_training_room as e','a.f_training_room_id=e.f_training_room_id','Left');    
		$this->datatables->join('t_employee as d','a.f_training_schedule_trainer=d.f_emp_id','Left');
	    $this->datatables->join('t_training_category as b','a.f_training_category_id=b.f_training_category_id','Left');                

		$this->datatables->from('t_training_schedule as a');
		
		echo $this->datatables->generate();
	}	
	
	function convert_date()
	{
		$this->load->helper('fungsional');
		$range = createDateRange('2016-05-19','2016-05-25');
		
		echo "result <pre>";echo print_r($range)."</pre><br/>";

	}
	
}
