<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class User extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('mo_user');
		$config = array('module' => 'User','roleid'=> $this->session->userdata('sRoleId'));
		$this->load->library('rolemodule',$config);
    }

	public function index()
    {
		$data = array(
			'app_title'=>'Data User',
			'app_desc' =>'it all User'
		);
		
        $data['content']	= 'vw_user';
        $this->load->view('webadmin/main', $data);
    }

	public function fnUserDataJson()
	{
		$button = '';
		if($this->rolemodule->check_button('edit'))
		{
			$button .= '&nbsp;&nbsp;<a href="#" onclick="fnEdit($1)" class="tip" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;';
		}

		if($this->rolemodule->check_button('delete'))
		{
			$button .= '&nbsp;&nbsp;<a href="#" onclick="fnDelete($1)" class="tip" title="Hapus"><i class="text-red glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;';
		}

		$this->load->library('datatables');
		$this->datatables->select('f_user_id,f_user_email,f_user_name,f_user_role,f_user_active,f_user_create_on,f_user_create_by,f_user_update_on,f_user_update_by');
		$this->datatables->from('t_user');
		$this->datatables->add_column('Aksi',$button,'f_user_id');
		
		echo $this->datatables->generate();		
	}

	public function fnUserDataId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_user->getDataId($id);
		echo json_encode($data);		
	}

	//Untuk Form Terpisah
	public function fnUserAdd()
    {
		$data = array(
			'app_title'=>'Form User',
			'app_desc' =>'it all Form User',
			'form_header'	=>'<i class="fa fa-table"></i> Add&nbsp;&nbsp;',
			'fAct'			=>'Add',
		);
		
        $data['content']	= 'vw_user_add';
        $this->load->view('webadmin/main', $data);
    }

	public function fnUserSave()
	{
		if($this->mo_user->saveData())
		{
			$this->session->set_userdata('SUCMSG','Sukses Tambah !!!');
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}

	//Untuk Form Terpisah
	public function fnUserEdit($id)
    {
		$data = array(
			'app_title'=>'Form User',
			'app_desc' =>'it all Form User',
			'form_header'	=>'<i class="fa fa-edit"></i> Edit&nbsp;&nbsp;',
			'fAct'			=>'Edit',
			'fId'			=>$id,
		);
		
        $data['content']	= 'vw_user_add';
        $this->load->view('webadmin/main', $data);
    }

	public function fnUserUpdate()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_user->updateData($id))
		{
			$this->session->set_userdata('SUCMSG','Sukses Edit !!!');
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}

	public function fnUserDelete()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_user->deleteData($id))
		{
			echo 'TRUE';
		}
		else
		{
			echo 'FALSE';
		}		
	}

	public function fnUserComboData()
	{
		$json['result'] = $this->mo_user->remoteComboData();
		echo json_encode($json);
	}

	public function fnUserExcel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "t_user.xls";
        $judul = "t_user";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
		xlsWriteLabel($tablehead, $kolomhead++, "F User Id");
		xlsWriteLabel($tablehead, $kolomhead++, "F User Email");
		xlsWriteLabel($tablehead, $kolomhead++, "F User Password");
		xlsWriteLabel($tablehead, $kolomhead++, "F User Name");
		xlsWriteLabel($tablehead, $kolomhead++, "F User Role");
		xlsWriteLabel($tablehead, $kolomhead++, "F User Active");
		xlsWriteLabel($tablehead, $kolomhead++, "F User Create On");
		xlsWriteLabel($tablehead, $kolomhead++, "F User Create By");
		xlsWriteLabel($tablehead, $kolomhead++, "F User Update On");
		xlsWriteLabel($tablehead, $kolomhead++, "F User Update By");

		foreach ($this->mo_user->fnGetData() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_user_id);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_user_email);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_user_password);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_user_name);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_user_role);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_user_active);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_user_create_on);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_user_create_by);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_user_update_on);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_user_update_by);

			$tablebody++;
			$nourut++;
        }

        xlsEOF();
        exit();
	}

	public function fnUserWord()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=t_user.doc");

        $data = array(
            't_user_data' => $this->mo_user->fnGetData(),
            'start' => 0
        );
        
        $this->load->view('vw_user_doc',$data);
    }

}

/* End of file User.php */
/* Location: ./application/modules/User/controllers/User.php */ 
