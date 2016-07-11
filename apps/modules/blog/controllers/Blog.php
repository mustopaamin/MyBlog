<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Blog extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('mo_blog','mb');
    }
/*
	public function index()
    {
		$data = array(
			'app_title'=>'MyBlog',
			'app_desc' =>'it all User'
		);
		
        $data['content']	= 'storystrap/content';
        $this->load->view('storystrap/index', $data);
    }
*/
	public function index()
    {
		$this->load->library('pagination');
		$data = array(
			'app_title'=>'MyBlog',
			'app_desc' =>'it all User'
		);

		$limit = 2;
							  $this->db->limit($limit,0);
        $data['list']		= $this->mb->fnGetData();
        $data['content']	= 'storystrap/article';

		$config['base_url'] 	= site_url('blog/hal');
		$config['total_rows']	= $this->db->count_all('t_posting');
		$config['per_page']		= $limit;
		$this->pagination->initialize($config);
		$data['pagination']		= $this->pagination->create_links();

        $this->load->view('storystrap/index', $data);
    }
    
    public function hal($page = null)
    {
		$this->load->library('pagination');
		$data = array(
			'app_title'=>'MyBlog',
			'app_desc' =>'it all User'
		);

		$limit = 2;
		if(!$page){
			$offset = $page;
			$this->db->limit($limit,$offset);
		} 
		else $this->db->limit($limit,0);
		
        $data['list']		= $this->mb->fnGetData();
        $data['content']	= 'storystrap/article';

		$config['base_url'] 	= site_url('blog/hal');
		$config['total_rows']	= $this->db->count_all('t_posting');
		$config['per_page']		= $limit;
		$this->pagination->initialize($config);
		$data['pagination']		= $this->pagination->create_links();
		
        $this->load->view('storystrap/index', $data);		
	}
	
	public function detail($id = null)
	{
		$data = array(
			'app_title'=>'MyBlog',
			'app_desc' =>'it all User'
		);
		
		$data['row']		= $this->mb->getDataId($id);
        $data['content']	= 'storystrap/article_detail';
        $this->load->view('storystrap/index', $data);		
	}

}

/* End of file User.php */
/* Location: ./application/modules/User/controllers/User.php */ 
