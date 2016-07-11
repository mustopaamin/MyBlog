<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Mo_admin extends CI_Model {

	public $table = 't_user';
	
	function Auth($username,$password)
	{
		$this->db->where('f_user_email',$username);
		$this->db->where('f_user_password',sha1(md5($password)));
		$sql = $this->db->get($this->table);
		if($sql->num_rows()>0)
		{
			return $sql->row();
		}
		else
		{
			return FALSE;
		}
		
	}
	
    function fnGetData()
    {
        $this->db->order_by('f_user_id', 'DESC');
        return $this->db->get($this->table)->result();		
	}

	function getDataId($id)
	{
		$sql = $this->db->get_where($this->table,array('f_user_id'=> $id))->row_array();
		return $sql;
	}

	function saveData()
	{
		$data = array(
				'f_user_id' => $this->input->post('f_user_id'),
				'f_user_email' => $this->input->post('f_user_email'),
				'f_user_password' => $this->input->post('f_user_password'),
				'f_user_name' => $this->input->post('f_user_name'),
				'f_user_role' => $this->input->post('f_user_role'),
				'f_user_active' => $this->input->post('f_user_active'),
				'f_user_create_on' => $this->input->post('f_user_create_on'),
				'f_user_create_by' => $this->input->post('f_user_create_by'),
				'f_user_update_on' => $this->input->post('f_user_update_on'),
				'f_user_update_by' => $this->input->post('f_user_update_by'),
		);
		$sql = $this->db->insert($this->table,$data);
		return $sql;
	}

	function updateData($id)
	{
		$data = array(
				'f_user_id' => $this->input->post('f_user_id'),
				'f_user_email' => $this->input->post('f_user_email'),
				'f_user_password' => $this->input->post('f_user_password'),
				'f_user_name' => $this->input->post('f_user_name'),
				'f_user_role' => $this->input->post('f_user_role'),
				'f_user_active' => $this->input->post('f_user_active'),
				'f_user_create_on' => $this->input->post('f_user_create_on'),
				'f_user_create_by' => $this->input->post('f_user_create_by'),
				'f_user_update_on' => $this->input->post('f_user_update_on'),
				'f_user_update_by' => $this->input->post('f_user_update_by'),
		);

		$this->db->where('f_user_id',$id);
		$sql = $this->db->update($this->table,$data);
		return $sql;		
	}

	function deleteData($id)
	{
		$this->db->where('f_user_id',$id);
		$sql = $this->db->delete($this->table);
		return $sql;		
	}
	
	function comboData()
	{
		$sql = $this->db->get('t_user');
		if($sql)
		{
			foreach($sql->result() as $r):
				$list[$r->f_user_id] = $r->f_user_id;
			endforeach;
		}
		return $list;
	}

	function remoteComboData()
	{
		if($this->input->get('term')) $this->db->like('f_user_id',$this->input->get('term')); // pencarian name
		if($this->input->get('id')) $this->db->where('f_user_id',$this->input->get('id')); // saat pencarian update
		
		$this->db->limit('10');
		$result = $this->db->get($this->table)->result();
		$DataJson = array();
		foreach($result as $row):
			$data['id']	= $row->f_user_id; // value
			$data['text']	= $row->f_user_id; // change display 
			array_push($DataJson,$data);
		endforeach;
		return $DataJson;
	}
}

/* End of file Mo_user.php */
/* Location: ./application/modules/User/models/Mo_user.php */	

	


