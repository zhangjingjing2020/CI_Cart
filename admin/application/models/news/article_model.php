<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/*
	 * 文章管理模型
	 * @Author 水木工作室
	 */
	class Article_model extends CI_Model{

		public function __construct(){
			//调用父类构造函数
			parent::__construct();
			$this->load->database();
		}
		
		/*
		 * @access public
		 * @prama $data array
		 * @return bool  成功返回true，失败返回false
		 */		
		function add_article($data){
			//使用AR类完成插入操作
			return $this->db->insert('article',$data);//表名无需加前缀
		}
		

		/*
		 * 获取分页数据
		 */
		function article_list($limit,$offset) {
			$this->db->select('article.id,article.title,article.author,art_cat.cat_name,article.add_time');
			$this->db->from('article');
			$this->db->join('art_cat', 'art_cat.id = article.cat_id', 'left');
			$this->db->limit($limit,$offset);
			$query = $this->db->get();
			//echo $this->db->last_query();
			return $query->result_array();
		}
		
		//统计文章记录总数
		function count_article(){
			return $this->db->count_all('article');
		}
		
		//查询单条文章信息
		function select_article($id){
			$this->db->select('title, author, cat_id,art_cat.cat_name, content');
			$this->db->join('art_cat', 'art_cat.id = article.cat_id', 'left');
			$query = $this->db->get_where('article', array('article.id' => $id) );
			//echo $this->db->last_query();
			return $query->row_array();
		}
		
		/*
		 * 更新文章数据
		 */
		function update_article($data){
			$id = $this->input->get('id', TRUE);
			$this->db->where('id', $id);
			return $this->db->update('article', $data);
		}

	}