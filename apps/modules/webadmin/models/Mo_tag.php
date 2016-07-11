<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Mo_tag extends CI_Model {

	public $table = 't_tag';
	
    function fnGetData()
    {
        $this->db->order_by('f_tag_id', 'DESC');
        return $this->db->get($this->table)->result();		
	}

	function getDataId($id)
	{
		$sql = $this->db->get_where($this->table,array('f_tag_id'=> $id))->row_array();
		return $sql;
	}

	function saveData()
	{
		$data = array(
				'f_tag_id' => $this->input->post('f_tag_id'),
				'f_tag_name' => $this->input->post('f_tag_name'),
				'f_tag_active' => $this->input->post('f_tag_active'),
		);
		$sql = $this->db->insert($this->table,$data);
		return $sql;
	}

	function updateData($id)
	{
		$data = array(
				'f_tag_id' => $this->input->post('f_tag_id'),
				'f_tag_name' => $this->input->post('f_tag_name'),
				'f_tag_active' => $this->input->post('f_tag_active'),
		);

		$this->db->where('f_tag_id',$id);
		$sql = $this->db->update($this->table,$data);
		return $sql;		
	}

	function deleteData($id)
	{
		$this->db->where('f_tag_id',$id);
		$sql = $this->db->delete($this->table);
		return $sql;		
	}
	
	function comboData()
	{
		$sql = $this->db->get('t_tag');
		if($sql)
		{
			foreach($sql->result() as $r):
				$list[$r->f_tag_id] = $r->f_tag_name;
			endforeach;
		}
		return $list;
	}

	function comboDataName()
	{
		$sql = $this->db->get('t_tag');
		if($sql)
		{
			foreach($sql->result() as $r):
				$list[$r->f_tag_name] = $r->f_tag_name;
			endforeach;
		}
		return $list;
	}

	function remoteComboData()
	{
		if($this->input->get('term')) $this->db->like('f_tag_id',$this->input->get('term')); // pencarian name
		if($this->input->get('id')) $this->db->where('f_tag_id',$this->input->get('id')); // saat pencarian update
		
		$this->db->limit('10');
		$result = $this->db->get($this->table)->result();
		$DataJson = array();
		foreach($result as $row):
			$data['id']	= $row->f_tag_id; // value
			$data['text']	= $row->f_tag_id; // change display 
			array_push($DataJson,$data);
		endforeach;
		return $DataJson;
	}
}

/* End of file Mo_tag.php */
/* Location: ./application/modules/Tag/models/Mo_tag.php */	

	


