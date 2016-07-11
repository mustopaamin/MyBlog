<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Mo_category extends CI_Model {

	public $table = 't_category';
	
    function fnGetData()
    {
        $this->db->order_by('f_category_id', 'DESC');
        return $this->db->get($this->table)->result();		
	}

	function getDataId($id)
	{
		$sql = $this->db->get_where($this->table,array('f_category_id'=> $id))->row_array();
		return $sql;
	}

	function saveData()
	{
		$data = array(
				'f_category_id' => $this->input->post('f_category_id'),
				'f_category_name' => $this->input->post('f_category_name'),
				'f_category_parent' => $this->input->post('f_category_parent'),
				'f_category_active' => $this->input->post('f_category_active'),
		);
		$sql = $this->db->insert($this->table,$data);
		return $sql;
	}

	function updateData($id)
	{
		$data = array(
				'f_category_id' => $this->input->post('f_category_id'),
				'f_category_name' => $this->input->post('f_category_name'),
				'f_category_parent' => $this->input->post('f_category_parent'),
				'f_category_active' => $this->input->post('f_category_active'),
		);

		$this->db->where('f_category_id',$id);
		$sql = $this->db->update($this->table,$data);
		return $sql;		
	}

	function deleteData($id)
	{
		$this->db->where('f_category_id',$id);
		$sql = $this->db->delete($this->table);
		return $sql;		
	}
	
	function comboData()
	{
		$sql = $this->db->get('t_category');
		if($sql)
		{
			foreach($sql->result() as $r):
				$list[$r->f_category_id] = $r->f_category_name;
			endforeach;
		}
		return $list;
	}

	function remoteComboData()
	{
		if($this->input->get('term')) $this->db->like('f_category_id',$this->input->get('term')); // pencarian name
		if($this->input->get('id')) $this->db->where('f_category_id',$this->input->get('id')); // saat pencarian update
		
		$this->db->limit('10');
		$result = $this->db->get($this->table)->result();
		$DataJson = array();
		foreach($result as $row):
			$data['id']	= $row->f_category_id; // value
			$data['text']	= $row->f_category_id; // change display 
			array_push($DataJson,$data);
		endforeach;
		return $DataJson;
	}
}

/* End of file Mo_category.php */
/* Location: ./application/modules/Category/models/Mo_category.php */	

	


