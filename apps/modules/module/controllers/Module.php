<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Module extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('mo_module');
		$config = array('module' => 'Module','roleid'=> $this->session->userdata('sRoleId'));
		$this->load->library('rolemodule',$config);
    }

	public function index()
    {
		$data = array(
			'app_title'=>'Data Module',
			'app_desc' =>'it all Module'
		);
		
        $data['content']	= 'vw_module';
        $this->load->view('webadmin/main', $data);
    }

	public function fnModuleDataJson()
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
		$this->datatables->select('f_module_id,f_module_class,f_module_name,f_module_desc,f_module_icon,f_module_level,f_module_parent,f_module_urut,f_module_active');
		$this->datatables->from('t_module');
		$this->datatables->add_column('Aksi',$button,'f_module_id');
		
		echo $this->datatables->generate();		
	}

	public function fnModuleDataId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_module->getDataId($id);
		echo json_encode($data);		
	}

	//Untuk Form Terpisah
	public function fnModuleAdd()
    {
		$data = array(
			'app_title'=>'Form Module',
			'app_desc' =>'it all Form Module',
			'form_header'	=>'<i class="fa fa-table"></i> Add&nbsp;&nbsp;',
			'fAct'			=>'Add',
		);
		
        $data['content']	= 'vw_module_add';
        $this->load->view('webadmin/main', $data);
    }

	public function fnModuleSave()
	{
		if($this->mo_module->saveData())
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
	public function fnModuleEdit($id)
    {
		$data = array(
			'app_title'=>'Form Module',
			'app_desc' =>'it all Form Module',
			'form_header'	=>'<i class="fa fa-edit"></i> Edit&nbsp;&nbsp;',
			'fAct'			=>'Edit',
			'fId'			=>$id,
		);
		
        $data['content']	= 'vw_module_add';
        $this->load->view('webadmin/main', $data);
    }

	public function fnModuleUpdate()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_module->updateData($id))
		{
			$this->session->set_userdata('SUCMSG','Sukses Edit !!!');
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}

	public function fnModuleDelete()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_module->deleteData($id))
		{
			echo 'TRUE';
		}
		else
		{
			echo 'FALSE';
		}		
	}

	public function fnModuleComboData()
	{
		$json['result'] = $this->mo_module->remoteComboData();
		echo json_encode($json);
	}

	public function fnModuleComboDataLevel()
	{
		$level = $this->input->post('level') - 1;
		$this->db->where('f_module_level',$level);
		$json = $this->mo_module->comboData();
		echo json_encode($json);
	}

	public function fnModuleExcel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "t_module.xls";
        $judul = "t_module";
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
		xlsWriteLabel($tablehead, $kolomhead++, "F Module Id");
		xlsWriteLabel($tablehead, $kolomhead++, "F Module Class");
		xlsWriteLabel($tablehead, $kolomhead++, "F Module Name");
		xlsWriteLabel($tablehead, $kolomhead++, "F Module Desc");
		xlsWriteLabel($tablehead, $kolomhead++, "F Module Icon");
		xlsWriteLabel($tablehead, $kolomhead++, "F Module Level");
		xlsWriteLabel($tablehead, $kolomhead++, "F Module Parent");
		xlsWriteLabel($tablehead, $kolomhead++, "F Module Urut");
		xlsWriteLabel($tablehead, $kolomhead++, "F Module Active");

		foreach ($this->mo_module->fnGetData() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_module_id);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_module_class);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_module_name);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_module_desc);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_module_icon);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_module_level);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_module_parent);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_module_urut);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_module_active);

			$tablebody++;
			$nourut++;
        }

        xlsEOF();
        exit();
	}

	public function fnModuleWord()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=t_module.doc");

        $data = array(
            't_module_data' => $this->mo_module->fnGetData(),
            'start' => 0
        );
        
        $this->load->view('vw_module_doc',$data);
    }

}

/* End of file Module.php */
/* Location: ./application/modules/Module/controllers/Module.php */ 
