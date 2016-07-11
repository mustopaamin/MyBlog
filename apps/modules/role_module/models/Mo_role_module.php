<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Mo_role_module extends CI_Model {

	public $table = 't_role';
	
    function fnGetData()
    {
        $this->db->order_by('f_role_id', 'DESC');
        return $this->db->get($this->table)->result();		
	}

	function getDataId($id)
	{
		$sql = $this->db->get_where($this->table,array('f_role_id'=> $id))->row_array();
		return $sql;
	}

	function saveData()
	{
		$data = array(
				'f_role_id' => $this->input->post('f_role_id'),
				'f_role_code' => $this->input->post('f_role_code'),
				'f_role_name' => $this->input->post('f_role_name'),
				'f_role_desc' => $this->input->post('f_role_desc'),
				'f_role_active' => $this->input->post('f_role_active'),
		);
		$sql = $this->db->insert($this->table,$data);
		return $sql;
	}

	function updateData($id)
	{
		$data = array(
				'f_role_id' => $this->input->post('f_role_id'),
				'f_role_code' => $this->input->post('f_role_code'),
				'f_role_name' => $this->input->post('f_role_name'),
				'f_role_desc' => $this->input->post('f_role_desc'),
				'f_role_active' => $this->input->post('f_role_active'),
		);

		$this->db->where('f_role_id',$id);
		$sql = $this->db->update($this->table,$data);
		return $sql;		
	}

	function deleteData($id)
	{
		$this->db->where('f_role_id',$id);
		$sql = $this->db->delete($this->table);
		return $sql;		
	}
	
	function comboData()
	{
		$sql = $this->db->get('t_role');
		if($sql)
		{
			foreach($sql->result() as $r):
				$list[$r->f_role_id] = $r->f_role_id;
			endforeach;
		}
		return $list;
	}

	function remoteComboData()
	{
		if($this->input->get('term')) $this->db->like('f_role_id',$this->input->get('term')); // pencarian name
		if($this->input->get('id')) $this->db->where('f_role_id',$this->input->get('id')); // saat pencarian update
		
		$this->db->limit('10');
		$result = $this->db->get($this->table)->result();
		$DataJson = array();
		foreach($result as $row):
			$data['id']	= $row->f_role_id; // value
			$data['text']	= $row->f_role_id; // change display 
			array_push($DataJson,$data);
		endforeach;
		return $DataJson;
	}
}

/* End of file Mo_role_module.php */
/* Location: ./application/modules/Role_module/models/Mo_role_module.php */	

	


