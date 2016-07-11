<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Category extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('mo_category');
		$config = array('module' => 'webadmin/category','roleid'=> $this->session->userdata('sRoleId'));
		$this->load->library('rolemodule',$config);
    }

	public function index()
    {
		$data = array(
			'app_title'=>'Data Category',
			'app_desc' =>'it all Category'
		);
		
        $data['content']	= 'vw_category';
        $this->load->view('webadmin/main', $data);
    }

	public function fnCategoryDataJson()
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
		$this->datatables->select('f_category_id,f_category_name,f_category_parent,f_category_active');
		$this->datatables->from('t_category');
		$this->datatables->add_column('Aksi',$button,'f_category_id');
		
		echo $this->datatables->generate();		
	}

	public function fnCategoryDataId()
	{
		$id 	= $this->input->get_post('id');
		$data	= $this->mo_category->getDataId($id);
		echo json_encode($data);		
	}

	//Untuk Form Terpisah
	public function fnCategoryAdd()
    {
		$data = array(
			'app_title'=>'Form Category',
			'app_desc' =>'it all Form Category',
			'form_header'	=>'<i class="fa fa-table"></i> Add&nbsp;&nbsp;',
			'fAct'			=>'Add',
		);
		
        $data['content']	= 'vw_category_add';
        $this->load->view('webadmin/main', $data);
    }

	public function fnCategorySave()
	{
		if($this->mo_category->saveData())
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
	public function fnCategoryEdit($id)
    {
		$data = array(
			'app_title'=>'Form Category',
			'app_desc' =>'it all Form Category',
			'form_header'	=>'<i class="fa fa-edit"></i> Edit&nbsp;&nbsp;',
			'fAct'			=>'Edit',
			'fId'			=>$id,
		);
		
        $data['content']	= 'vw_category_add';
        $this->load->view('webadmin/main', $data);
    }

	public function fnCategoryUpdate()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_category->updateData($id))
		{
			$this->session->set_userdata('SUCMSG','Sukses Edit !!!');
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}

	public function fnCategoryDelete()
	{
		$id 	= $this->input->get_post('id');
		if($this->mo_category->deleteData($id))
		{
			echo 'TRUE';
		}
		else
		{
			echo 'FALSE';
		}		
	}

	public function fnCategoryComboData()
	{
		$json['result'] = $this->mo_category->remoteComboData();
		echo json_encode($json);
	}

	public function fnCategoryExcel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "t_category.xls";
        $judul = "t_category";
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
		xlsWriteLabel($tablehead, $kolomhead++, "F Category Id");
		xlsWriteLabel($tablehead, $kolomhead++, "F Category Name");
		xlsWriteLabel($tablehead, $kolomhead++, "F Category Parent");
		xlsWriteLabel($tablehead, $kolomhead++, "F Category Active");

		foreach ($this->mo_category->fnGetData() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_category_id);
			xlsWriteLabel($tablebody, $kolombody++, $data->f_category_name);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_category_parent);
			xlsWriteNumber($tablebody, $kolombody++, $data->f_category_active);

			$tablebody++;
			$nourut++;
        }

        xlsEOF();
        exit();
	}

	public function fnCategoryWord()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=t_category.doc");

        $data = array(
            't_category_data' => $this->mo_category->fnGetData(),
            'start' => 0
        );
        
        $this->load->view('vw_category_doc',$data);
    }

}

/* End of file Category.php */
/* Location: ./application/modules/Category/controllers/Category.php */ 
