<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Generator extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		$this->load->model('mo_generator');
	}

	public function index()
	{
		$data = array(
			'app_title'=>'Generator CMV to CodeIgniter CI 3',
			'app_desc' =>'Generator'
		);

		$data['title']		= 'Generator CMV to CodeIgniter CI 3';
		$data['content']	= 'form_generator';
		$data['tabel']		= $this->mo_generator->list_tabel();
		$this->load->view('layout/main',$data);
	}
	
	function join_table01()
	{
		$data['title']		= 'Generator CMV to CodeIgniter';
		$data['content']	= 'form_generator_join';
		$data['tabel']		= $this->mo_generator->list_tabel();
		$this->load->view('layout/main',$data);		
	}
	
	function fnGenerate()
	{
//		echo "<pre>";echo print_r($_POST)."</pre><br/>";
		$data['tabel']		= $this->input->post('tabel');
		$data['tabelf']		= strtolower($this->input->post('name_md')); //
//		$module				= 'md_'.$this->input->post('name_md');
		$module				= $this->input->post('name_md');
		$nama_model			= 'mo_'.$this->input->post('name_md');
		$fieldtable			= array();
		$fieldform			= array();
		$intable			= $this->input->post('intabel');
		$intable_name		= $this->input->post('intabelv'); // thead table
		$inform				= $this->input->post('inform');
		$inform_name		= $this->input->post('informv'); // label form
		$inform_type		= $this->input->post('type'); // type form input
		$select				= '';
		$aoColumns			= '';
		$aoColumns1			= '';
		$inputName			= '';
		foreach($intable as $intable):
			$fieldtable[] 	= array(	'nama_field' => $intable	);
			$select			.= $intable.',';
			$aoColumns		.= "null,";
		endforeach;

		foreach($inform as $inform):
			$fieldform[] = array(	'nama_form' => $inform	);
			$inputName		.= "\t\t\t\t$('input[name=\"".$inform."\"]').val(data[\"".$inform."\"]);\n";
		endforeach;

		$fields = $this->db->field_data($this->input->post('tabel'));
//		$data_primary = array();		
		foreach ($fields as $field)
		{
			if ($field->primary_key == '1') {
//				$data_primary[] = array('name_primary' => $field->name);
				$data_primary 	= $field->name;
			}		 
		}
		
		$data['nm_controller']	= ucfirst($module);
		$data['select_field']	= trim($select,',');
		$data['where_select']	= $data_primary;
		$data['aoColumns']		= trim($aoColumns,',');
		$data['inputName']		= $inputName;
		$data['nm_model']		= ucfirst($nama_model);
		$data['nm_class_c']		= ucfirst($module);
		$data['nm_class_m']		= ucfirst($nama_model);
		$data['nm_global']		= ucfirst($this->input->post('name_md'));
		
		$data['col_tabel']		= $fields;
		$data['fields_tabel']	= $fieldtable;
		$data['thead']			= $intable_name; // thead table
		$data['fields_form']	= $fieldform;
		$data['label_form']		= $inform_name; // label form
		$data['type_form']		= $inform_type; // type input form

//		$fModule = FCPATH .APPPATH .'modules/'.$module;
		$file_index = $this->load->view('index',false,true);
		$fModule = APPPATH .'modules/'.$module;
//		echo $fModule."<br/>";
//		echo "<pre>";echo print_r($data)."</pre><br/>";

		if(!is_dir($fModule))
		{

			mkdir($fModule,'0777');
			chmod($fModule,0777);

			// Pembuatan Controller
			$fController = $fModule .'/controllers';
			$source_controller_template = $this->load->view('template_controller', $data, TRUE);
			mkdir($fController,'0777');
			chmod($fController,0777);
	        if (write_file($fController.'/'.ucfirst($module).'.php', $source_controller_template)) {
				write_file($fController.'/index.html', $file_index);
	            $sukses[] = 'Folder dan File Controller sukses dibuat ;)';
	            chmod($fController.'/'.ucfirst($module).'.php',0777);
	            chmod($fController.'/index.html',0777);
	        }

			
			// Pembuatan Model
			$fModel = $fModule .'/models';
			$source_model_template = $this->load->view('template_model', $data, TRUE);
			mkdir($fModel,'0777');
			chmod($fModel,0777);
	        if (write_file($fModel.'/'.ucfirst($nama_model).'.php', $source_model_template)) {
				write_file($fModel.'/index.html', $file_index);
	            $sukses[] = 'Folder dan File Model sukses dibuat ;)';
	            chmod($fModel.'/'.ucfirst($nama_model).'.php',0777);
	            chmod($fModel.'/index.html',0777);
	        }

	
			// Pembuatan Views
			$fView = $fModule .'/views';
			mkdir($fView,'0777');
			chmod($fView,0777);
			
			if($this->input->post('df') == 1)
			{
				$source_view_template = $this->load->view('template_view_all',$data, TRUE);
		        if (write_file($fView.'/vw_'.$data['tabelf'].'.php', $source_view_template)) {
		            $sukses[] = 'Folder dan File View sukses dibuat ;)';
		            chmod($fView.'/vw_'.$data['tabelf'].'.php',0777);
					write_file($fView.'/index.html', $file_index);
					chmod($fView.'/index.html',0777);
		        }
			}
			
			if($this->input->post('df') == 2)
			{
				$source_view_template1 = $this->load->view('template_view_display',$data, TRUE);
				$source_view_template2 = $this->load->view('template_view_form',$data, TRUE);
		        if (write_file($fView.'/vw_'.$data['tabelf'].'.php', $source_view_template1)) {
		            $sukses[] = 'Folder dan File View sukses dibuat ;)';
		            chmod($fView.'/vw_'.$data['tabelf'].'.php',0777);
		            write_file($fView.'/vw_'.$data['tabelf'].'_add.php', $source_view_template2);
		            chmod($fView.'/vw_'.$data['tabelf'].'_add.php',0777);
					write_file($fView.'/index.html', $file_index);
					chmod($fView.'/index.html',0777);
		        }
	        }

	        $sukses[] = '<a href="'.site_url($module).'" target="_blank"> Lihat</a>';
	        $this->session->set_userdata('SMSG', $sukses);
		}
		else
		{
			$this->session->set_userdata('EMSG', 'Folder dan File View sudah dibuat :(');
		}

		redirect('generator');
		
	}

	function field_tabel()
	{
		$tabel = $this->input->get_post('tabel');
		$fields = $this->db->field_data($tabel);
		
		echo "<tr style='background-color:#6DDF6D'><td colspan='6'>Tabel : ".$tabel."</td></tr>";
		$onselect = array("text"=>"Text","hidden"=>"Hidden","password"=>"Password","select"=>"Select","textarea"=>"Textarea","datepicker"=>"Datepicker"); 
		$i=1;
		foreach ($fields as $field)
		{
			if($field->primary_key == 1)
			{
				$ro = "disabled";
				$int = "<input type='hidden' name='intabel[]' checked value='".$field->name."'>";
				//$intv = "<input type='hidden' name='intabelv[]' value='".$field->name."'>";
				$inf = "<input type='hidden' name='inform[]' checked value='".$field->name."'>";
				//$infv = "<input type='hidden' name='informv[]' value='".$field->name."'>";
				$type = form_dropdown('type',$onselect,'hidden','class="form-control type'.$i.'" disabled')."<input type='hidden' name='type[]' value='hidden'>";
				$reference .= $field->name;
			}
			else
			{
				$ro = "data-rule-required=\"true\"";
				$int = "";
				$intv = "";
				$inf = "";
				$infv = "";
				$type = form_dropdown('type[]',$onselect,'text','class="form-control type'.$i.'"');
			}
			
			echo "<tr>";
			echo "<td>".$field->name."</td>";
			echo "<td class='tdCk'><input type='checkbox' name='intabel[]' checked value='".$field->name."' ".$ro." class='c".$i."' onClick='thead(".$i.")'>".$int."</td>";
			echo "<td><input type='text' name='intabelv[]' value='".$field->name."' class='form-control text".$i."' onKeyup='labelf(".$i.")'>".$intv."</td>";
			echo "<td class='tdCk'><input type='checkbox' name='inform[]' checked value='".$field->name."' ".$ro."  class='d".$i."' onClick='finput(".$i.")'>".$inf."</td>";
			echo "<td><input type='text' name='informv[]' value='".$field->name."' class='form-control ftext".$i."'>".$infv."</td>";
			echo "<td>".$type."</td>";
			echo "</tr>";
			$i++;
		} 		
	}

	public function blank()
	{
		$data['title']		= 'AdminLTE 2 | Blank Page';
		$data['content']	= 'layout/blank';
		$this->load->view('layout/main',$data);
	}
	
	function data_field()
	{
		$fields = $this->db->field_data('db_master');
		
		foreach ($fields as $field)
		{
		   echo "Nama : ".$field->name.br();
		   echo "Type : ".$field->type.br();
		   echo "Panjang : ".$field->max_length.br();
		   echo "Primary : ".$field->primary_key.br();
		   echo br();
		}
		
		echo "<br/>"; 		

		$fields = $this->db->field_data('db_detail');
		
		foreach ($fields as $field)
		{
		   echo "Nama : ".$field->name.br();
		   echo "Type : ".$field->type.br();
		   echo "Panjang : ".$field->max_length.br();
		   echo "Primary : ".$field->primary_key.br();
		   echo br();
		} 		
	}
}

/* End of file generate.php */
/* Location: ./application/controllers/generate.php */
