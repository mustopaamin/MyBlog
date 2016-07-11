<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Mo_module extends CI_Model {

	public $table = 't_module';
	
    function fnGetData()
    {
        $this->db->order_by('f_module_id', 'DESC');
        return $this->db->get($this->table)->result();		
	}

	function getDataId($id)
	{
		$sql = $this->db->get_where($this->table,array('f_module_id'=> $id))->row_array();
		return $sql;
	}

	function saveData()
	{
		$data = array(
				'f_module_id' => $this->input->post('f_module_id'),
				'f_module_class' => $this->input->post('f_module_class'),
				'f_module_name' => $this->input->post('f_module_name'),
				'f_module_desc' => $this->input->post('f_module_desc'),
				'f_module_icon' => $this->input->post('f_module_icon'),
				'f_module_level' => $this->input->post('f_module_level'),
				'f_module_parent' => $this->input->post('f_module_parent'),
				'f_module_urut' => $this->input->post('f_module_urut'),
				'f_module_active' => $this->input->post('f_module_active'),
		);
		$sql = $this->db->insert($this->table,$data);
		return $sql;
	}

	function updateData($id)
	{
		$data = array(
				'f_module_id' => $this->input->post('f_module_id'),
				'f_module_class' => $this->input->post('f_module_class'),
				'f_module_name' => $this->input->post('f_module_name'),
				'f_module_desc' => $this->input->post('f_module_desc'),
				'f_module_icon' => $this->input->post('f_module_icon'),
				'f_module_level' => $this->input->post('f_module_level'),
				'f_module_parent' => $this->input->post('f_module_parent'),
				'f_module_urut' => $this->input->post('f_module_urut'),
				'f_module_active' => $this->input->post('f_module_active'),
		);

		$this->db->where('f_module_id',$id);
		$sql = $this->db->update($this->table,$data);
		return $sql;		
	}

	function deleteData($id)
	{
		$this->db->where('f_module_id',$id);
		$sql = $this->db->delete($this->table);
		return $sql;		
	}
	
	function comboData()
	{
		$sql = $this->db->get('t_module');
		if($sql)
		{
			foreach($sql->result() as $r):
				$list[$r->f_module_id] = $r->f_module_name;
			endforeach;
		}
		return $list;
	}

	function remoteComboData()
	{
		if($this->input->get('term')) $this->db->like('f_module_id',$this->input->get('term')); // pencarian name
		if($this->input->get('id')) $this->db->where('f_module_id',$this->input->get('id')); // saat pencarian update
		
		$this->db->limit('10');
		$result = $this->db->get($this->table)->result();
		$DataJson = array();
		foreach($result as $row):
			$data['id']	= $row->f_module_id; // value
			$data['text']	= $row->f_module_name; // change display 
			array_push($DataJson,$data);
		endforeach;
		return $DataJson;
	}
}

/* End of file Mo_module.php */
/* Location: ./application/modules/Module/models/Mo_module.php */	

	


