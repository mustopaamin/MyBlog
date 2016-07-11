<?php
$html = "<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class " . $nm_class_c . " extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        \$this->load->model('".strtolower($nm_model)."');
		\$config = array('module' => '".strtolower($nm_controller)."','roleid'=> \$this->session->userdata('sRoleId'));
		\$this->load->library('rolemodule',\$config);
    }";

$html .="\n\n\tpublic function index()
    {
		\$data = array(
			'app_title'=>'Data $nm_global',
			'app_desc' =>'it all $nm_global'
		);
		
        \$data['content']	= 'vw_$tabelf';
        \$this->load->view('webadmin/main', \$data);
    }";

$html .="\n\n\tpublic function fn".$nm_global."DataJson()
	{
		\$button = '';
		if(\$this->rolemodule->check_button('edit'))
		{
			\$button .= '&nbsp;&nbsp;<a href=\"#\" onclick=\"fnEdit($1)\" class=\"tip\" title=\"Edit\"><i class=\"glyphicon glyphicon-edit\"></i></a>&nbsp;&nbsp;';
		}

		if(\$this->rolemodule->check_button('delete'))
		{
			\$button .= '&nbsp;&nbsp;<a href=\"#\" onclick=\"fnDelete($1)\" class=\"tip\" title=\"Hapus\"><i class=\"text-red glyphicon glyphicon-trash\"></i></a>&nbsp;&nbsp;';
		}

		\$this->load->library('datatables');
		\$this->datatables->select('$select_field');
		\$this->datatables->from('$tabel');
		\$this->datatables->add_column('Aksi',\$button,'$where_select');
		
		echo \$this->datatables->generate();		
	}";        

$html .="\n\n\tpublic function fn".$nm_global."DataId()
	{
		\$id 	= \$this->input->get_post('id');
		\$data	= \$this->".strtolower($nm_model)."->getDataId(\$id);
		echo json_encode(\$data);		
	}";        

if($this->input->post('df') == 2)
{
$html .="\n\n\t//Untuk Form Terpisah
	public function fn".$nm_global."Add()
    {
		\$data = array(
			'app_title'=>'Form $nm_global',
			'app_desc' =>'it all Form $nm_global',
			'form_header'	=>'<i class=\"fa fa-table\"></i> Add&nbsp;&nbsp;',
			'fAct'			=>'Add',
		);
		
        \$data['content']	= 'vw_".$tabelf."_add';
        \$this->load->view('webadmin/main', \$data);
    }";
}
    
$html .="\n\n\tpublic function fn".$nm_global."Save()
	{
		if(\$this->".strtolower($nm_model)."->saveData())
		{
			\$this->session->set_userdata('SUCMSG','Sukses Tambah !!!');
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}";

if($this->input->post('df') == 2)
{
$html .="\n\n\t//Untuk Form Terpisah
	public function fn".$nm_global."Edit(\$id)
    {
		\$data = array(
			'app_title'=>'Form $nm_global',
			'app_desc' =>'it all Form $nm_global',
			'form_header'	=>'<i class=\"fa fa-edit\"></i> Edit&nbsp;&nbsp;',
			'fAct'			=>'Edit',
			'fId'			=>\$id,
		);
		
        \$data['content']	= 'vw_".$tabelf."_add';
        \$this->load->view('webadmin/main', \$data);
    }";
}

$html .="\n\n\tpublic function fn".$nm_global."Update()
	{
		\$id 	= \$this->input->get_post('id');
		if(\$this->".strtolower($nm_model)."->updateData(\$id))
		{
			\$this->session->set_userdata('SUCMSG','Sukses Edit !!!');
			echo json_encode(array('msg'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>false));
		}		
	}";

$html .="\n\n\tpublic function fn".$nm_global."Delete()
	{
		\$id 	= \$this->input->get_post('id');
		if(\$this->".strtolower($nm_model)."->deleteData(\$id))
		{
			echo 'TRUE';
		}
		else
		{
			echo 'FALSE';
		}		
	}";

$html .="\n\n\tpublic function fn".$nm_global."ComboData()
	{
		\$json['result'] = \$this->".strtolower($nm_model)."->remoteComboData();
		echo json_encode(\$json);
	}";

$html .= "\n\n\tpublic function fn".$nm_global."Excel()
    {
        \$this->load->helper('exportexcel');
        \$namaFile = \"$tabel.xls\";
        \$judul = \"$tabel\";
        \$tablehead = 0;
        \$tablebody = 1;
        \$nourut = 1;
        //penulisan header
        header(\"Pragma: public\");
        header(\"Expires: 0\");
        header(\"Cache-Control: must-revalidate, post-check=0,pre-check=0\");
        header(\"Content-Type: application/force-download\");
        header(\"Content-Type: application/octet-stream\");
        header(\"Content-Type: application/download\");
        header(\"Content-Disposition: attachment;filename=\" . \$namaFile . \"\");
        header(\"Content-Transfer-Encoding: binary \");

        xlsBOF();

        \$kolomhead = 0;
        xlsWriteLabel(\$tablehead, \$kolomhead++, \"No\");";
        
foreach ($col_tabel as $row) {
        $column_name = label($row->name);
        $html .= "\n\t\txlsWriteLabel(\$tablehead, \$kolomhead++, \"$column_name\");";
}
$html .= "\n\n\t\tforeach (\$this->" . strtolower($nm_model) . "->fnGetData() as \$data) {
            \$kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber(\$tablebody, \$kolombody++, \$nourut);";
foreach ($col_tabel as $row) {
        $column_name = $row->name;
        $xlsWrite = $row->type == 'int' || $row->type == 'double' || $row->type == 'decimal' ? 'xlsWriteNumber' : 'xlsWriteLabel';
        $html .= "\n\t\t\t" . $xlsWrite . "(\$tablebody, \$kolombody++, \$data->$column_name);";
}
$html .= "\n\n\t\t\t\$tablebody++;
			\$nourut++;
        }

        xlsEOF();
        exit();
	}";

$html .= "\n\n\tpublic function fn".$nm_global."Word()
    {
        header(\"Content-type: application/vnd.ms-word\");
        header(\"Content-Disposition: attachment;Filename=$tabel.doc\");

        \$data = array(
            '" . $tabel . "_data' => \$this->" . strtolower($nm_model)  . "->fnGetData(),
            'start' => 0
        );
        
        \$this->load->view('vw_" . $tabelf . "_doc',\$data);
    }";   

$html .= "\n\n}\n\n/* End of file $nm_controller.php */
/* Location: ./application/modules/$nm_controller/controllers/$nm_controller.php */";

echo $html;
?> 
