<?php
class User_model extends CI_Model {
	var $CI;
	public function __construct()	{
		parent::__construct();
		$this->load->database();
		$this->CI =& get_instance();
	}
	
	/********************************
	 * Get a user/ a list of users from the database
	 *
	 * param *
	 * key		the search key, return all users if not provided
	 * field		the field to search by, default is search by id
	 *
	 * return *
	 * array		an array containing the search result, array key is the db fields
	 */
	public function get_user($key = '', $field = 'id') {
		if ($key === '') {
			$query = $this->db->get('users');
			return $query->result_array();
		}
		else {
			$query = $this->db->get_where( 'users', array($field => $key) );
			return $query->row_array();
		}
	}
	

	
	
	/********************************
	 * Insert a new user into the database
	 *
	 * param	*
	 * user		an array containing the user information which to be inserted into the DB, 
	 *				the array keys must match the DB fields.
	 * 			If this parameter is not provided, this method reads from the html post.
	 *
	 * return *
	 * mixed		return an array containing the user array;
	 *				return false if error occurs
	 */
	public function insert_user($user = FALSE) {
		$this->CI->load->model('common_model');
		if ( $user === FALSE ) {
			$user['firstname'] = $this->input->post('firstname');
			$user['lastname'] = $this->input->post('lastname');
			$user['email'] = $this->input->post('email');
			$user['pwd'] = md5($this->input->post('pwd'));
			$user['activate_code'] = $this->common_model->_generate_random_string();
			$user['phone'] = $this->input->post('phone');
			$user['gender'] = $this->input->post('gender');
			
			
			$now = date( 'Y-m-d H:i:s', time() );
			$user['created_time'] = $now;
			$user['modified_time'] = $now;
			$user['role_id'] = 1;
			$query = $this->db->insert('users', $user);
			return $user;
		}
		else if ( is_array($user) ) {
			$query = $this->db->insert('users', $user);
			return $user;
		}
		
		return FALSE;
	}
	
	/********************************
	 * Update users in the database
	 *
	 * param	*
	 * id			the user id used for the update operation
	 * user		an array containing the user information which to be inserted into the DB, 
	 *				the array keys must match the DB fields.
	 * 			If this parameter is not provided, this method reads from the html post.
	 *
	 * return *
	 * mixed		return an array containing the user array;
	 *				return false if error occurs
	 */
	public function update_user($id = '', $user = FALSE) {
		if ( $id === '' ) {
			return FALSE;
		}
		
		$this->db->where('id', $id);
		
		if ( $user === FALSE ) {
			$user['pwd'] = md5($this->input->post('pwd'));
			$user['phone'] = $this->input->post('phone');			
		}
		$user['modified_time'] = date( 'Y-m-d H:i:s', time() );
		$q = $this->db->update('users', $user);
		
		
		return $user;
	}
	
	public function authenticate_user(){
		$login['email'] = $this->input->post('email');
		$login['pwd'] = md5($this->input->post('pwd'));
		$now = gmdate('Y-m-d H:i:s', time() );
		
		$sql = "SELECT id, firstname, lastname, email, pwd, phone, gender, role_id, activate_code, activate_date FROM users WHERE email = ? ";		
		$query = $this->db->query($sql, array($login['email'])); 
		
		$ret = FALSE;
		if (count($query->result_array())>0){
			list($user) = $query->result_array();
			if ($query->num_rows()===1){
				if ($user['pwd']===$login['pwd']){
					$user['is_login']=TRUE;
					$ret = &$user;
				}
			}
		}
		return $ret;
	}
	
	/********************
	 * User for forgotten password. When user click forgotten password, email and auto-generated activation code are sent to user email.
	 * User click the link provided in the email and call this function.
	 */
	public function authenticate_user_by_email($email, $activate_code){
	
		$login['email'] = $email;		
		$now = gmdate('Y-m-d H:i:s', time() );
		
		$sql = "SELECT id, firstname, lastname, email, pwd, phone, gender, role_id, activate_code FROM users WHERE email = ? ";		
		$query = $this->db->query($sql, array($login['email'])); 
		
		list($user) = $query->result_array();

		if ($query->num_rows()===1){
			if ($user['activate_code'] === $activate_code ) {
				$user['is_login']=TRUE;
				$session_data = $this->session->all_userdata();
				$session_data['user'] = $user;
				$this->session->set_userdata($session_data);
				return $user;
			}
		}else{
			return FALSE;
		}
	}
	
	
	/********************
	 * Called when the user click the activation link in the email after registeration.
	 * User click the link provided in the email and call this function.
	 */
	public function activate_user($email, $activate_code){
		$is_valid = FALSE;
		$sql = "SELECT id, firstname, lastname, email, pwd, phone, gender, role_id, activate_code FROM users WHERE email = ? and activate_date is NULL";
		$query = $this->db->query($sql, array($email)); 
		
		list($user) = $query->result_array();
		
		if ($query->num_rows()>0){
			if ($user['activate_code'] === $activate_code ) {
				$user['activate_date'] = date( 'Y-m-d H:i:s', time() );
				$user['modified_time'] = date( 'Y-m-d H:i:s', time() );
				
				$this->db->where('email', $email);
				$this->db->update('users', array('activate_date'=>$user['activate_date'], 
												 'modified_time'=>$user['modified_time']
												));
				
				$user['is_login'] = TRUE;
				$session_data = $this->session->all_userdata();
				$session_data['user'] = $user;
				$this->session->set_userdata($session_data);
				redirect('index');
				$is_valid = TRUE;
				//return $user;
			}
		}
		
		if($is_valid===FALSE){
			redirect(site_url().'login');
		}
	}
	
	/********************
	 * User for forgotten password. When user click forgotten password. The user are directed to reset password page.
	 * User click the link provided in the email and call this function.
	 */
	public function reset_password_by_email($email){
		$this->CI->load->model("common_model");
		
		$user['pwd'] = NULL;
		$user['activate_code'] = $this->common_model->_generate_random_string();
		$user['modified_time'] = date( 'Y-m-d H:i:s', time() );
		$this->db->where('email', $email);
		$this->db->update('users', $user);
		
		return $user['activate_code'];
	}
}

?>