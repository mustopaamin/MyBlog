<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Role_module extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('mo_role_module');
		$config = array('module' => 'Role_module','roleid'=> $this->session->userdata('sRoleId'));
		$this->load->library('rolemodule',$config);
    }

	public function index()
    {
		$data = array(
			'app_title'=>'Data Role module',
			'app_desc' =>'it all Role_module'
		);
		
        $data['content']	= 'vw_role_module';
        $this->load->view('webadmin/main', $data);
    }

	public function fnRole_moduleDataJson()
	{
		$button = '';
		if($this->rolemodule->check_button('add'))
		{
			$button .= '&nbsp;&nbsp;<a href="#" onclick="fnModule($1)" class="tip text-yellow" title="Access Module"><i class="glyphicon glyphicon-folder-open"></i></a>&nbsp;&nbsp;';
		}

		if($this->rolemodule->check_button('edit'))
		{
			$button .= '&nbsp;&nbsp;<a href="#" onclick="fnEdit($1)" class="tip" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;';
		}

		if($this->rolemodule->check_button('delete'))
		{
			$button .= '&nbsp;&nbsp;<a href="#" onclick="fnDelete($1)" class="tip" title="Hapus"><i class="text-red glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;';
		}

		$this->load->library('datatables');
		$this->datatables->select('f_role_id,f_role_code,f_role_name,f_role_desc,f_role_active');
		$this->datatables->from('t_role');
		$this->datatables->add_column('Aksi',$button,'f_role_id');
		
		echo $this->datatables->generate();		
	}

	public function fnRole_moduleDataId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_role_module->getDataId($id);
		echo json_encode($data);		
	}

	//Untuk Form Terpisah
	public function fnRole_moduleAdd()
    {
		$data = array(
			'app_title'=>'Form Role module',
			'app_desc' =>'it all Form Role_module',
			'form_header'	=>'<i class="fa fa-table"></i> Add&nbsp;&nbsp;',
			'fAct'			=>'Add',
		);
		
        $data['content']	= 'vw_role_module_add';
        $this->load->view('webadmin/main', $data);
    }

	public function fnRole_moduleSave()
	{
		if($this->mo_role_module->saveData())
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
	public function fnRole_moduleEdit($id)
    {
		$data = array(
			'app_title'=>'Form Role module',
			'app_desc' =>'it all Form Role_module',
			'form_header'	=>'<i class="fa fa-edit"></i> Edit&nbsp;&nbsp;',
			'fAct'			=>'Edit',
			'fId'			=>$id,
		);
		
        $data['content']	= 'vw_role_module_add';
        $this->load->view('webadmin/main', $data);
    }

	public function fnRole_moduleUpdate()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_role_module->updateData($id))
		{
			$this->session->set_userdata('SUCMSG','Sukses Edit !!!');
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}

	public function fnRole_moduleDelete()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_role_module->deleteData($id))
		{
			echo 'TRUE';
		}
		else
		{
			echo 'FALSE';
		}		
	}

	public function fnRole_moduleComboData()
	{
		$json['result'] = $this->mo_role_module->remoteComboData();
		echo json_encode($json);
	}

	public function fnRole_moduleExcel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "t_role.xls";
        $judul = "t_role";
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
		xlsWriteLabel($tablehead, $kolomhead++, "F Role Id");
		xlsWriteLabel($tablehead, $kolomhead++, "F Role Code");
		xlsWriteLabel($tablehead, $kolomhead++, "F Role Name");
		xlsWriteLabel($tablehead, $kolomhead++, "F Role Desc");
		xlsWriteLabel($tablehead, $kolomhead++, "F Role Active");

		foreach ($this->mo_role_module->fnGetData() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_role_id);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_role_code);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_role_name);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_role_desc);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_role_active);

			$tablebody++;
			$nourut++;
        }

        xlsEOF();
        exit();
	}

	public function fnRole_moduleWord()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=t_role.doc");

        $data = array(
            't_role_data' => $this->mo_role_module->fnGetData(),
            'start' => 0
        );
        
        $this->load->view('vw_role_module_doc',$data);
    }

}

/* End of file Role_module.php */
/* Location: ./application/modules/Role_module/controllers/Role_module.php */ 
