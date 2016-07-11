<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Mo_posting extends CI_Model {

	public $table = 't_posting';
	
    function fnGetData()
    {
        $this->db->order_by('f_posting_id', 'DESC');
        return $this->db->get($this->table)->result();		
	}

	function getDataId($id)
	{
		$sql = $this->db->get_where($this->table,array('f_posting_id'=> $id))->row_array();
		return $sql;
	}

	function saveData()
	{
		$tagpost = $this->input->post('f_posting_tag');
		$tag = '';
		$data = array(
				'f_posting_name' => $this->input->post('f_posting_name'),
				'f_posting_slug' => seo_title($this->input->post('f_posting_name')),
				'f_category_id' => $this->input->post('f_category_id'),
				'f_posting_text' => $this->input->post('f_posting_text'),
				'f_posting_image' => $this->input->post('f_posting_image'),
				'f_posting_date' => date('Y-m-d'),
				'f_posting_time' => date('H:i:s'),
				'f_posting_active' => $this->input->post('f_posting_active'),
				'f_create_on' => date('d-m-Y H:i:s'),
				'f_create_by' => $this->session->userdata('sRoleId'),
		);
		
		foreach($tagpost as $t)
		{
			$tag .= $t.',';
		}
		$data['f_posting_tag'] = trim($tag,',');
		
		$sql = $this->db->insert($this->table,$data);
		return $sql;
	}

	function updateData($id)
	{
		$tagpost = $this->input->post('f_posting_tag');
		$tag = '';
		$data = array(
				'f_posting_name' => $this->input->post('f_posting_name'),
				'f_posting_slug' => seo_title($this->input->post('f_posting_name')),
				'f_category_id' => $this->input->post('f_category_id'),
				'f_posting_text' => $this->input->post('f_posting_text'),
				'f_posting_tag' => $this->input->post('f_posting_tag'),
				'f_posting_image' => $this->input->post('f_posting_image'),
				'f_posting_active' => $this->input->post('f_posting_active'),
				'f_update_date' => date('d-m-Y H:i:s'),
				'f_update_by' => $this->session->userdata('sRoleId'),
		);

		foreach($tagpost as $t)
		{
			$tag .= $t.',';
		}
		$data['f_posting_tag'] = trim($tag,',');
		
		$this->db->where('f_posting_id',$id);
		$sql = $this->db->update($this->table,$data);
		return $sql;		
	}

	function deleteData($id)
	{
		$this->db->where('f_posting_id',$id);
		$sql = $this->db->delete($this->table);
		return $sql;		
	}
	
	function comboData()
	{
		$sql = $this->db->get('t_posting');
		if($sql)
		{
			foreach($sql->result() as $r):
				$list[$r->f_posting_id] = $r->f_posting_name;
			endforeach;
		}
		return $list;
	}

	function remoteComboData()
	{
		if($this->input->get('term')) $this->db->like('f_posting_id',$this->input->get('term')); // pencarian name
		if($this->input->get('id')) $this->db->where('f_posting_id',$this->input->get('id')); // saat pencarian update
		
		$this->db->limit('10');
		$result = $this->db->get($this->table)->result();
		$DataJson = array();
		foreach($result as $row):
			$data['id']	= $row->f_posting_id; // value
			$data['text']	= $row->f_posting_id; // change display 
			array_push($DataJson,$data);
		endforeach;
		return $DataJson;
	}
}

/* End of file Mo_posting.php */
/* Location: ./application/modules/Posting/models/Mo_posting.php */	

	


