<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Tag extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('mo_tag');
		$config = array('module' => 'webadmin/tag','roleid'=> $this->session->userdata('sRoleId'));
		$this->load->library('rolemodule',$config);
    }

	public function index()
    {
		$data = array(
			'app_title'=>'Data Tag',
			'app_desc' =>'it all Tag'
		);
		
        $data['content']	= 'vw_tag';
        $this->load->view('webadmin/main', $data);
    }

	public function fnTagDataJson()
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
		$this->datatables->select('f_tag_id,f_tag_name,f_tag_active');
		$this->datatables->from('t_tag');
		$this->datatables->add_column('Aksi',$button,'f_tag_id');
		
		echo $this->datatables->generate();		
	}

	public function fnTagDataId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_tag->getDataId($id);
		echo json_encode($data);		
	}

	//Untuk Form Terpisah
	public function fnTagAdd()
    {
		$data = array(
			'app_title'=>'Form Tag',
			'app_desc' =>'it all Form Tag',
			'form_header'	=>'<i class="fa fa-table"></i> Add&nbsp;&nbsp;',
			'fAct'			=>'Add',
		);
		
        $data['content']	= 'vw_tag_add';
        $this->load->view('webadmin/main', $data);
    }

	public function fnTagSave()
	{
		if($this->mo_tag->saveData())
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
	public function fnTagEdit($id)
    {
		$data = array(
			'app_title'=>'Form Tag',
			'app_desc' =>'it all Form Tag',
			'form_header'	=>'<i class="fa fa-edit"></i> Edit&nbsp;&nbsp;',
			'fAct'			=>'Edit',
			'fId'			=>$id,
		);
		
        $data['content']	= 'vw_tag_add';
        $this->load->view('webadmin/main', $data);
    }

	public function fnTagUpdate()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_tag->updateData($id))
		{
			$this->session->set_userdata('SUCMSG','Sukses Edit !!!');
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}

	public function fnTagDelete()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_tag->deleteData($id))
		{
			echo 'TRUE';
		}
		else
		{
			echo 'FALSE';
		}		
	}

	public function fnTagComboData()
	{
		$json['result'] = $this->mo_tag->remoteComboData();
		echo json_encode($json);
	}

	public function fnTagExcel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "t_tag.xls";
        $judul = "t_tag";
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
		xlsWriteLabel($tablehead, $kolomhead++, "F Tag Id");
		xlsWriteLabel($tablehead, $kolomhead++, "F Tag Name");
		xlsWriteLabel($tablehead, $kolomhead++, "F Tag Active");

		foreach ($this->mo_tag->fnGetData() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_tag_id);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_tag_name);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_tag_active);

			$tablebody++;
			$nourut++;
        }

        xlsEOF();
        exit();
	}

	public function fnTagWord()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=t_tag.doc");

        $data = array(
            't_tag_data' => $this->mo_tag->fnGetData(),
            'start' => 0
        );
        
        $this->load->view('vw_tag_doc',$data);
    }

}

/* End of file Tag.php */
/* Location: ./application/modules/Tag/controllers/Tag.php */ 
