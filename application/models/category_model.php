<?php
class Category_model extends CI_Model {

	public function __construct()	{
		$this->load->database();
	}
	
	public function get_categories($id = "") {
		if ($id === "") {
			$this->db->order_by("name", "asc"); 
			$query = $this->db->get('categories');
			return $query->result_array();
		}
		
		$query = $this->db->get_where('categories', array('id' => $id));
		return $query->row_array();
	}
	
	public function get_categories_by_name($cat = "", $exact = FALSE) {
		$cat = strtolower($cat);
		if( $exact == FALSE )
			$cat = "%$cat%";
		$result = $this->db->query("SELECT * FROM categories WHERE lower(name) LIKE '$cat'");
		
		if( $result->num_rows() > 1 )
			return $result->result_array();
		else if( $result->num_rows() == 1 )
			return $result->row_array();
		return FALSE;
	}
	
	public function get_category_by_text($dept = '', $cat = '', $sub = '') {
		/*
		$query = "";
		$q_dept = "SELECT level, text FROM categories cat, navigations nav WHERE cat.id = nav.cat_id AND nav.text = ? ";
		$q_cat = "SELECT cat.id, nav.level, CONCAT(q_dept.text, '/', nav.text) AS text FROM categories cat, navigations nav, ($q_dept) q_dept WHERE cat.id = nav.cat_id AND nav.text = ? AND nav.level LIKE CONCAT(q_dept.level, '%') ";

		if( $sub != "" ){
			$query = "SELECT cat.id, nav.level, CONCAT(q_cat.text, '/', nav.text) AS text FROM categories cat, navigations nav, ($q_cat) q_cat WHERE cat.id = nav.cat_id AND nav.text = ? AND nav.level LIKE CONCAT(q_cat.level, '%') ";
		}
		else{
			//$q_sub = "SELECT cat.id, CONCAT(q_cat.text, '/', nav.text) AS text FROM categories cat, navigations nav, ($q_cat) q_cat WHERE cat.id = nav.cat_id AND nav.level LIKE CONCAT(q_cat.level, '%') ";
			$query = $q_cat;
		}
		
		// real
		//$q_pro = "SELECT pro.id, pro.name, pro.description_en, pro.description_zh, pro.priority, pro.price, pro.discount, pro.components, pro.status, pro.created_time, pc.cat_id, cat.path AS i_path, q_sub.text AS c_path FROM products pro, product_category pc, categories cat, navigations nav, ($q_sub) q_sub WHERE pro.id = pc.pro_id AND pc.cat_id = cat.id AND cat.id = nav.cat_id AND pc.cat_id = q_sub.id ORDER BY id";
		$result = $this->db->query($query, array($dept, $cat, $sub) );
		echo "<p><br/>" . $this->db->last_query() . "<br/></p>";
		*/
		
		// didn't handle any error yet, the category may not exist
		if( $dept == '' )
			return FALSE;

		$path = array();
		$query = "SELECT * FROM categories cat, navigations nav WHERE cat.id = nav.cat_id AND text_en LIKE ?";
		$result = $this->db->query($query, $dept);
		if( $result->num_rows() <= 0 )
			return FALSE;

		$path[0] = $result->row_array();
		$path[0]['c_path'] = $path[0]['text_en'];
		
		if( $cat == '' )
			return $path;

		$query = "SELECT * FROM categories cat, navigations nav WHERE cat.id = nav.cat_id AND nav.level LIKE ? AND text_en LIKE ?";
		$result = $this->db->query($query, array($path[0]['level'] . '.%', $cat) );
		if( $result->num_rows() <= 0 )
			return FALSE;
		
		$path[1] = $result->row_array();
		$path[1]['c_path'] = $path[0]['c_path'] . '/' . $path[1]['text_en'];

		if( $sub == '' )
			return $path;

		$query = "SELECT * FROM categories cat, navigations nav WHERE cat.id = nav.cat_id AND nav.level LIKE ? AND text_en LIKE ?";
		$result = $this->db->query($query, array($path[1]['level'] . '.%', $sub) );
		if( $result->num_rows() <= 0 )
			return FALSE;
		
		$path[2] = $result->row_array();
		$path[2]['c_path'] = $path[1]['c_path'] . '/' . $path[2]['text_en'];
		
		return $path;
	}
	
	public function get_category_showcase($path = '') {
		$path = 'products/' . $path . '/showcase.jpg';
		if(file_exists('images/' . $path)){
			return $path;
		}
		return FALSE;
	}
	
	public function get_number_of_products($cat_id = 0){
		$cat_q = "SELECT level FROM navigations WHERE cat_id = ?";
		$sub_q = "SELECT id FROM categories c, navigations n, ($cat_q) cq WHERE c.id = n.cat_id AND n.level LIKE CONCAT(cq.level, '%')";
		$query = "SELECT COUNT(*) AS num FROM products p, product_category pc WHERE p.id = pc.pro_id AND pc.cat_id IN ($sub_q)";
		$result = $this->db->query( $query, $cat_id );
		$result = $result->row_array();
		return $result['num'];
	}
	
	public function add_category($cat = "", $path = "") {
		if( $cat == "" )
			return FALSE;
		
		$now = date( 'Y-m-d H:i:s', time() );
		$category['name'] = $cat;
		$category['path'] = $path;
		$category['created_time'] = $now;
		$category['modified_time'] = $now;
		$this->db->insert('categories', $category);
		return $category;
	}
	
	public function edit_category($catid = '', $data = '') {
		if( $catid == '' || $data == '' )
			return FALSE;
		
		$now = date( 'Y-m-d H:i:s', time() );
		$category['modified_time'] = $now;
		foreach( $data as $key => $value )
			$category[$key] = $value;

		$this->db->where('id', $catid);
		return $this->db->update('categories', $category);
	}
}

?>