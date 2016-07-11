<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Posting extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('mo_posting');
        $this->load->model('mo_category');
        $this->load->model('mo_tag');
		$config = array('module' => 'webadmin/posting','roleid'=> $this->session->userdata('sRoleId'));
		$this->load->library('rolemodule',$config);
    }

	public function index()
    {
		$data = array(
			'app_title'=>'Data Posting',
			'app_desc' =>'it all Posting'
		);
		
        $data['content']	= 'vw_posting';
        $this->load->view('webadmin/main', $data);
    }

	public function fnPostingDataJson()
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
		$this->datatables->select('f_posting_id,f_posting_name,f_category_name,f_posting_text,f_posting_tag,f_posting_date,f_posting_time,f_posting_active');
		$this->datatables->join('t_category a','a.f_category_id=t_posting.f_category_id');
		$this->datatables->from('t_posting');
		$this->datatables->add_column('Aksi',$button,'f_posting_id');
		
		echo $this->datatables->generate();		
	}

	public function fnPostingDataId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_posting->getDataId($id);
		echo json_encode($data);		
	}

	//Untuk Form Terpisah
	public function fnPostingAdd()
    {
		$data = array(
			'app_title'=>'Form Posting',
			'app_desc' =>'it all Form Posting',
			'form_header'	=>'<i class="fa fa-table"></i> Add&nbsp;&nbsp;',
			'fAct'			=>'Add',
		);
		
        $data['category']	= $this->mo_category->comboData();
        $data['tag']		= $this->mo_tag->comboDataName();
        $data['content']	= 'vw_posting_add';
        $this->load->view('webadmin/main', $data);
    }

	public function fnPostingSave()
	{
		if($this->mo_posting->saveData())
		{
			$this->session->set_userdata('SUCMSG','Sukses Tambah !!!');
			//echo json_encode(array('msg'=>true));
		}
		else
		{
			//echo json_encode(array('msg'=>false));
		}		
	}

	//Untuk Form Terpisah
	public function fnPostingEdit($id)
    {
		$data = array(
			'app_title'=>'Form Posting',
			'app_desc' =>'it all Form Posting',
			'form_header'	=>'<i class="fa fa-edit"></i> Edit&nbsp;&nbsp;',
			'fAct'			=>'Edit',
			'fId'			=>$id,
		);
		
        $data['category']	= $this->mo_category->comboData();
        $data['tag']		= $this->mo_tag->comboDataName();
        $data['content']	= 'vw_posting_add';
        $this->load->view('webadmin/main', $data);
    }

	public function fnPostingUpdate()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_posting->updateData($id))
		{
			$this->session->set_userdata('SUCMSG','Sukses Edit !!!');
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}

	public function fnPostingDelete()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_posting->deleteData($id))
		{
			echo 'TRUE';
		}
		else
		{
			echo 'FALSE';
		}		
	}

	public function fnPostingComboData()
	{
		$json['result'] = $this->mo_posting->remoteComboData();
		echo json_encode($json);
	}

	public function fnPostingExcel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "t_posting.xls";
        $judul = "t_posting";
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
		xlsWriteLabel($tablehead, $kolomhead++, "F Posting Id");
		xlsWriteLabel($tablehead, $kolomhead++, "F Posting Name");
		xlsWriteLabel($tablehead, $kolomhead++, "F Posting Slug");
		xlsWriteLabel($tablehead, $kolomhead++, "F Category Id");
		xlsWriteLabel($tablehead, $kolomhead++, "F Posting Text");
		xlsWriteLabel($tablehead, $kolomhead++, "F Posting Tag");
		xlsWriteLabel($tablehead, $kolomhead++, "F Posting Image");
		xlsWriteLabel($tablehead, $kolomhead++, "F Posting Read");
		xlsWriteLabel($tablehead, $kolomhead++, "F Posting Date");
		xlsWriteLabel($tablehead, $kolomhead++, "F Posting Time");
		xlsWriteLabel($tablehead, $kolomhead++, "F Posting Active");
		xlsWriteLabel($tablehead, $kolomhead++, "F Create On");
		xlsWriteLabel($tablehead, $kolomhead++, "F Create By");
		xlsWriteLabel($tablehead, $kolomhead++, "F Update Date");
		xlsWriteLabel($tablehead, $kolomhead++, "F Update By");

		foreach ($this->mo_posting->fnGetData() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_posting_id);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_posting_name);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_posting_slug);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_category_id);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_posting_text);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_posting_tag);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_posting_image);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_posting_read);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_posting_date);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_posting_time);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_posting_active);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_create_on);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_create_by);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_update_date);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_update_by);

			$tablebody++;
			$nourut++;
        }

        xlsEOF();
        exit();
	}

	public function fnPostingWord()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=t_posting.doc");

        $data = array(
            't_posting_data' => $this->mo_posting->fnGetData(),
            'start' => 0
        );
        
        $this->load->view('vw_posting_doc',$data);
    }

}

/* End of file Posting.php */
/* Location: ./application/modules/Posting/controllers/Posting.php */ 
