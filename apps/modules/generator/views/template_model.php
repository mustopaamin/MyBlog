<?php
$html = "<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class " . $nm_class_m . " extends CI_Model {

	public \$table = '$tabel';
	
    function fnGetData()
    {
        \$this->db->order_by('$where_select', 'DESC');
        return \$this->db->get(\$this->table)->result();		
	}

	function getDataId(\$id)
	{
		\$sql = \$this->db->get_where(\$this->table,array('$where_select'=> \$id))->row_array();
		return \$sql;
	}

	function saveData()
	{
		\$data = array(";

foreach($fields_form as $ff):
$html .= "\n\t\t\t\t'".$ff['nama_form']."' => \$this->input->post('".$ff['nama_form']."'),";
endforeach;

$html .= "\n\t\t);
		\$sql = \$this->db->insert(\$this->table,\$data);
		return \$sql;
	}

	function updateData(\$id)
	{
		\$data = array(";

foreach($fields_form as $ff):
$html .= "\n\t\t\t\t'".$ff['nama_form']."' => \$this->input->post('".$ff['nama_form']."'),";
endforeach;

$html .= "\n\t\t);

		\$this->db->where('$where_select',\$id);
		\$sql = \$this->db->update(\$this->table,\$data);
		return \$sql;		
	}

	function deleteData(\$id)
	{
		\$this->db->where('$where_select',\$id);
		\$sql = \$this->db->delete(\$this->table);
		return \$sql;		
	}
	
	function comboData()
	{
		\$sql = \$this->db->get('$tabel');
		if(\$sql)
		{
			foreach(\$sql->result() as \$r):
				\$list[\$r->$where_select] = \$r->$where_select;
			endforeach;
		}
		return \$list;
	}

	function remoteComboData()
	{
		if(\$this->input->get('term')) \$this->db->like('$where_select',\$this->input->get('term')); // pencarian name
		if(\$this->input->get('id')) \$this->db->where('$where_select',\$this->input->get('id')); // saat pencarian update
		
		\$this->db->limit('10');
		\$result = \$this->db->get(\$this->table)->result();
		\$DataJson = array();
		foreach(\$result as \$row):
			\$data['id']	= \$row->$where_select; // value
			\$data['text']	= \$row->$where_select; // change display 
			array_push(\$DataJson,\$data);
		endforeach;
		return \$DataJson;
	}
}

/* End of file $nm_model.php */
/* Location: ./application/modules/$nm_controller/models/$nm_model.php */";

echo $html;
?>
	

	


