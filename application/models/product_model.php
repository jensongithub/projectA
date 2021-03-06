<?php
class Product_model extends CI_Model {

	public function __construct()	{
		$this->load->database();
	}
	
	public function get_products() {
		//$result = $this->db->query("SELECT products.*, categories.id AS cat_id, categories.name AS cat_name, categories.path FROM products, product_category, categories WHERE products.id = product_category.pro_id AND product_category.cat_id=categories.id ORDER BY priority DESC, created_time DESC");
		$result = $this->db->query("SELECT products.*, categories.id AS cat_id, categories.name AS cat_name, categories.path FROM products LEFT JOIN (product_category, categories) ON (products.id = product_category.pro_id AND product_category.cat_id=categories.id) ORDER BY priority DESC, created_time DESC");
		return $result->result_array();
	}
	
	/****************************************************************
	* Get a product/ list of products by the given id
	*
	* Parameters:
	* id				: a single product id / an array of product ids
	*
	* get_anyway	: set to FALSE if only want to get available products
	*					  default = TRUE, only return the product no matter what the product status is
	*/
	public function get_product_by_id($id = '', $get_anyway = TRUE){
		if (is_array($id)){
			$id_list = implode("','", $id);
			
			$query = "SELECT * FROM products WHERE products.id in ('$id_list')";
			if( ! $get_anyway )
				$query .= " AND (products.status = 'A' OR products.status = 'S')";
			$result = $this->db->query($query);
			return $result->result_array();
		}else{
			$query = "SELECT * FROM products WHERE id = ?";
			if( ! $get_anyway )
				$query .= " AND (products.status = 'A' OR products.status = 'S')";
			$result = $this->db->query($query, $id);
			
			return $result->row_array();
		}
	}
	
	public function get_cart_item_price($cart){
		$item_id = array();
		foreach($cart as $each_item){
			$item_id[] = $each_item['id'];
		}
		
		//get unit price by item code		 
		$product_details = $this->get_product_by_id($item_id);
		 
		return $product_details;
	}
	public function get_products_in_category( $cid = '', $order_by = "priority DESC, created_time DESC") {
		if( $cid == '' ){
			$query = "SELECT DISTINCT p.* FROM products p, product_category pc WHERE NOT EXISTS (SELECT c.id FROM categories c WHERE p.id = pc.pro_id AND pc.cat_id = c.id)";
			$result = $this->db->query( $query );
			return $result->result_array();
		}
		$this->db->select("products.*")->from("products, product_category")->where("products.id = product_category.pro_id AND product_category.cat_id = $cid")->order_by($order_by);
		$result = $this->db->get();
		return $result->result_array();
	}
	
	public function get_products_for_listing($dept = '', $cat = '', $sub = '', $offset = 0, $count = 20, &$product_count = 0){
		$this->load->helper( 'file' );

		$q_sub = "";
		
		$q_dept = "SELECT level, text_en FROM categories cat, navigations nav WHERE cat.id = nav.cat_id AND nav.text_en = ? ";
		$q_cat = "SELECT nav.level, CONCAT(q_dept.text_en, '/', nav.text_en) AS text_en FROM categories cat, navigations nav, ($q_dept) q_dept WHERE cat.id = nav.cat_id AND nav.text_en = ? AND nav.level LIKE CONCAT(q_dept.level, '%') ";

		if( $sub != "" ){
			$q_sub = "SELECT cat.id, CONCAT(q_cat.text_en, '/', nav.text_en) AS text_en FROM categories cat, navigations nav, ($q_cat) q_cat WHERE cat.id = nav.cat_id AND nav.text_en = ? AND nav.level LIKE CONCAT(q_cat.level, '%') ";
		}
		else{
			$q_sub = "SELECT cat.id, q_cat.text_en AS text_en FROM categories cat, navigations nav, ($q_cat) q_cat WHERE cat.id = nav.cat_id AND nav.level LIKE CONCAT(q_cat.level, '%') ";
		}
		
		// real
		$q_pro = "SELECT DISTINCT pro.id, pro.name_en, pro.name_zh, pro.front_img, pro.description_en, pro.description_zh, pro.priority, pro.price, pro.discount, pro.components, pro.status, pro.created_time, pc.cat_id, cat.path AS i_path, q_sub.text_en AS c_path FROM products pro, product_category pc, categories cat, navigations nav, ($q_sub) q_sub WHERE pro.id = pc.pro_id AND pc.cat_id = cat.id AND cat.id = nav.cat_id AND pc.cat_id = q_sub.id AND (pro.status = 'A' OR pro.status = 'S') ORDER BY priority DESC, created_time DESC, pro.id";
		$result = $this->db->query($q_pro, array($dept, $cat, $sub) );
		//echo "<p><br/>" . $this->db->last_query() . "<br/></p>";
		
		$product_count = $result->num_rows();

		//echo "Product count = $product_count";
		// if no result, return empty array
		if( $product_count <= 0 )
			return array();
		
		// if has at least 1 record, post-process
		$products = $result->result_array();
		$ret = array();
		for( $i = $offset; count($ret) < $count && $i < $product_count; $i++ ){
			$ret[] = $products[$i];
		}
		/*
		foreach ($products as $key => $row) {
			$priority[$key]  = $row['priority'];
			$created_time[$key] = $row['created_time'];
		}
		array_multisort( $created_time, SORT_DESC, $priority, SORT_ASC, $products);

		echo "<p>product_model.php: Searching " . $this->config->item('image_dir') . 'products/' . "</p>";
		$files = get_filenames($this->config->item('image_dir') . 'products/');
		$file_count = count( $files );
		$i = 0; $j = 0;
		
		// match the image file with the products
		$match_count = 0;
		echo "<br/>file count = $file_count; product count = $product_count<br/>";
		while( $i < $product_count ){
			$prefix = substr($files[$j], 0, 6);
			$postfix = substr($files[$j], 12);
			if( $postfix == '-F_s.jpg' ){
				if( $prefix > $products[$i]['id'] ){
					unset($products[$i]);
					$i++;
					if( $i >= $product_count )
						break;
				}
				else if( $prefix < $products[$i]['id'] ){
					$j++;
					if( $j >= $file_count )
						break;
				}
				else{
					echo '* ' . $products[$i]['id'] . " <===> " . $files[$j] . '<br />';
					$products[$i]['image'] = $files[$j];
					$match_count++;
					$i++;
					if( $i >= $product_count )
						break;
				}
			}
			else{
				$j++;
				if( $j >= $file_count )
					break;
			}
			echo $products[$i]['id'] . " <===> " . $files[$j] . '<br />';
		}
		echo "<p>$match_count match(es)</p>";
		*/
		
		/*
		foreach( $products as $key => $product ){
			echo "<br/>";
			print_r($product);
		}
		*/

		return $ret;
	}

	public function get_products_for_sales_listing($dept_level = '', $offset = 0, $count = 20, &$product_count = 0){
		$this->load->helper( 'file' );

		$q_dept = "SELECT level, text_en FROM navigations nav WHERE nav.level LIKE '$dept_level%' ";
		$q_cat = "SELECT nav.level, CONCAT(q_dept.text_en, '/', nav.text_en) AS text_en FROM categories cat, navigations nav, ($q_dept) q_dept WHERE cat.id = nav.cat_id AND nav.level LIKE CONCAT(q_dept.level, '.%') ";
		$q_sub = "SELECT nav.cat_id AS id, CONCAT(q_cat.text_en, '/', nav.text_en) AS text_en FROM navigations nav, ($q_cat) q_cat WHERE nav.level LIKE CONCAT(q_cat.level, '.%') ";
		
		$q_fin = "($q_sub) UNION (SELECT cat.id, CONCAT(q_dept.text_en, '/', nav.text_en) AS text_en FROM categories cat, navigations nav, ($q_dept) q_dept WHERE cat.id = nav.cat_id AND nav.level LIKE CONCAT(q_dept.level, '.%') AND nav.level REGEXP '^[^\.+]\.[^\.+]$')";
		
		// real
		$q_pro = "SELECT DISTINCT pro.id, pro.name_en, pro.name_zh, pro.front_img, pro.description_en, pro.description_zh, pro.priority, pro.price, pro.discount, pro.components, pro.status, pro.created_time, pc.cat_id, cat.path AS i_path, q_fin.text_en AS c_path FROM products pro, product_category pc, categories cat, ($q_fin) q_fin WHERE pro.id = pc.pro_id AND pc.cat_id = cat.id AND pc.cat_id = q_fin.id AND pro.status = 'S' ORDER BY priority DESC, created_time DESC, pro.id";
		$result = $this->db->query($q_pro, $dept_level . '%' );
		//echo "<p><br/>" . $this->db->last_query() . "<br/></p>";
		
		$product_count = $result->num_rows();

		//echo "Product count = $product_count";
		// if no result, return empty array
		if( $product_count <= 0 )
			return array();
		
		// if has at least 1 record, post-process
		$products = $result->result_array();
		$ret = array();
		for( $i = $offset; count($ret) < $count && $i < $product_count; $i++ ){
			$ret[] = $products[$i];
		}

		return $ret;
	}
	
	public function get_similar_products($id = FALSE, $cat_id = FALSE, $num = 1){
		$query = "SELECT COUNT(*) AS 'count' FROM products p, product_category pc WHERE ( p.status = 'A' OR p.status = 'S' ) AND p.id = pc.pro_id AND pc.cat_id = ?";
		$count = $this->db->query($query, $cat_id)->row_array();
		$max = $count['count'] - 2;
		
		$products = array();
		$temp = array();
		$rand = 0;
		
		if( $max <= $num - 1 ){
			$query = "SELECT * FROM products p, product_category pc WHERE ( p.status = 'A' OR p.status = 'S' ) AND p.id = pc.pro_id AND p.id <> ? AND pc.cat_id = ? ORDER BY rand()";
			$products = $this->db->query($query, array($id, $cat_id, $rand))->result_array();
		}
		else{
			while( count($products) < $num ){
				while( TRUE ){
					$rand = rand(0, $max);
					if( ! isset($temp[$rand]) )
						break;
				}
				$temp[$rand] = 1;
				$query = "SELECT * FROM products p, product_category pc WHERE ( p.status = 'A' OR p.status = 'S' ) AND p.id = pc.pro_id AND p.id <> ? AND pc.cat_id = ? LIMIT ?, 1";
				$products[] = $this->db->query($query, array($id, $cat_id, $rand))->row_array();
			}
		}
		
		return($products);
	}
	
	public function get_products_color( $pid = '' ) {
		$query = "SELECT DISTINCT pcs.color FROM product_color_size pcs WHERE pro_id = ?";
		$result = $this->db->query( $query, $pid);
		return $result->result_array();
	}
	
	public function get_product_category( $pid = '' ) {
		$query = "SELECT cat.* FROM products pro, categories cat, product_category pc WHERE pro.id = pc.pro_id AND cat.id = pc.cat_id AND pro.id = ?";
		$result = $this->db->query( $query, $pid );
		return $result->row_array();
	}
	
	public function move_product_to_cat( $pid = '', $cid = '' ) {
		if( $pid == '' || $cid == '' )
			return FALSE;

		$root = getcwd() . "/" . $this->config->item('image_dir') . "products/";
		$cat = $this->get_product_category( $pid );
		$from_path = $root . $cat['path'];
		$query = "SELECT path FROM categories WHERE id = ?";
		$result = $this->db->query($query, $cid )->row_array();
		$to_path = $root . $result['path'];
		
		try{
			$files = scandir($from_path);
			foreach( $files as $file ){
				$cmp = strcasecmp( substr($file, 0, 6), $pid);
				if( $cmp < 0 )
					continue;
				else if( $cmp > 0 )
					break;
				rename($from_path . "/" . $file, $to_path . "/" . $file);
				//echo "rename( $from_path/$file, $to_path/$file )<br/>";
			}
		}catch(Exception $e){
			echo "There are some problems on file/directory access, please make sure the image file / directory exist.";
			return FALSE;
		}

		$query = "SELECT pc.cat_id FROM product_category pc WHERE pc.pro_id = ?";
		$result = $this->db->query($query, array($pid));
		if ($result->num_rows() > 0) {
			$query = "UPDATE product_category SET cat_id = ? WHERE pro_id = ?";
			$this->db->query($query, array($cid, $pid));
		}
		else{
			$query = "INSERT INTO product_category (pro_id, cat_id) VALUES ( ?, ?)";
			$this->db->query($query, array($pid, $cid));
		}
		return TRUE;
	}

	public function change_status($pid = '', $status = ''){
		if( $pid == '' || $status == '' )
			return FALSE;

		$query = "UPDATE products SET status = ? WHERE id = ?";
		$this->db->query( $query, array( $status, $pid ) );
		return TRUE;
	}
	
	public function add_product_in_excel_sheets($sheets = FALSE) {
		if( $sheets == FALSE )
			return FALSE;

		$cols = array( '', 'id', 'price', 'discount', 'description_en', 'description_zh', 'priority', 'components', 'status');
		$success_count = 0;
		$fail_count = 0;
		$fail_log = array();
		
		foreach( $sheets as $key => $sheet){
			$cat_id = explode(' -', $sheet['name']);
			$cat_id = $cat_id[0];
			//echo "<p>Handling category $cat_id</p>";
			
			// for each row
			for ($i = 1; $i <= $sheet['numRows']; $i++) {
				if( !isset($sheet['cells'][$i]) || !isset($sheet['cells'][$i][1]) || strpos($sheet['cells'][$i][1], '#') === 0 || $sheet['cells'][$i][1] == '' )
					continue;

				$query = "UPDATE products SET "
				. "price = ?2, discount = ?3, description_en = ?4, description_zh = ?5, priority = ?6, components = ?7, status = ?8 "
				. "WHERE id = ?";
				$data = array();
				$style_code = $sheet['cells'][$i][1];
				
				// for each column
				for ($j = 2; $j <= 8; $j++) {
					if( ! isset($sheet['cells'][$i][$j]) || $sheet['cells'][$i][$j] == '' ){
						$query = str_replace( "?$j", $cols[$j], $query );
						continue;
					}
					else{
						if( $cols[$j] == "description_zh" )
							$data[] = iconv("big5", "utf-8", $sheet['cells'][$i][$j] );
						else if( $cols[$j] == "components" ){
							$com_list = array();
							$items = explode(",", $sheet['cells'][$i][$j]);
							foreach($items as $item){
								$t = explode(" ", preg_replace("(\s+)", " ", trim($item)) );
								$com_list[$t[1]] = $t[0];
							}
							$data[] = json_encode( $com_list );
						}
						else
							$data[] = $sheet['cells'][$i][$j];
					}
				}
				
				// fill in the id and prepare the update query
				$data[] = $style_code;
				$query = preg_replace( "(\?\d+)", "?", $query);

				try{
					$result = $this->db->query($query, $data);
					if( $result ) {
						$success_count++;
						$query = "INSERT INTO product_category VALUES ( ?, ? ) ON DUPLICATE KEY UPDATE pro_id = pro_id";
						$this->db->query( $query, array( $style_code, $cat_id ) );
					}
					else{
						$fail_count++;
						$fail_log[] = "DB error - " . $style_code;
					}
				}catch(Exception $e){
					$fail_count++;
					$fail_log[] = $e->getMessage() . " - " . $style_code;
				}
			}
		}
		
		// return an array to notify the result
		return array( "success" => $success_count, "fail" => $fail_count, "fail_log" => $fail_log );
	}
	
	public function handle_products_excel($upload_data = FALSE){
		if( ! is_array($upload_data) )
			return FALSE;

		// setup the excel reader
		$this->excel_reader_2_21->setOutputEncoding('CP950');
		$this->excel_reader_2_21->setStoreExtendedInfo(FALSE);
		
		$this->excel_reader_2_21->read( $upload_data['full_path'] );

		$sheets = $this->excel_reader_2_21->sheets;
		
		// add the sheet name to each sheet
		$ns = count( $sheets );
		for($i = 0; $i < $ns; $i++){
			$sheets[$i]['name'] = $this->excel_reader_2_21->boundsheets[$i]['name'];
		}

		return $this->product_model->add_product_in_excel_sheets( $sheets );
	}
	
	public function edit_product($detail = FALSE){
		//print_r($detail);
		$query = "UPDATE products SET name_en = ?, name_zh = ?, price = ?, discount = ?, priority = ?, front_img = ?, description_en = ?, description_zh = ?, components = ?, status = ? WHERE id = ?";
		$this->db->query($query, array( $detail['name_en'], $detail['name_zh'], $detail['price'], $detail['discount'], $detail['priority'], $detail['front_img'], $detail['description_en'], $detail['description_zh'], $detail['components'], $detail['status'], $detail['id']) );
		//echo "<p>" . $this->db->last_query() . "</p>";
	}

	public function add_product($detail = FALSE){
		//print_r($detail);
		try{
			$query = "INSERT INTO products (id, name_en, name_zh, description_en, description_zh, price, discount, priority, components, status) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE id=id";
			$this->db->query($query, array( $detail['id'], $detail['name_en'], $detail['name_zh'], $detail['description_en'], $detail['description_zh'], $detail['price'], $detail['discount'], $detail['priority'], $detail['components'], $detail['status']) );
			$query = "INSERT INTO product_category (pro_id, cat_id) VALUES ( ?, ?) ON DUPLICATE KEY UPDATE cat_id=cat_id";
			$this->db->query($query, array( $detail['id'], $detail['cat']) );
		}catch(Exception $e){
			return FALSE;
		}
		return TRUE;
		//echo "<p>" . $this->db->last_query() . "</p>";
	}
	
	public function get_all_categories(){
		$query = "SELECT id, name, path FROM categories";
		$query = $this->db->query($query);
		return $query->result_array();
	}
}

?>