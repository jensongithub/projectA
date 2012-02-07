<?php
class User_model extends CI_Model {

	public function __construct()	{
		$this->load->database();
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
			$query = $this->db->get('user');
			return $query->result_array();
		}
		else {
			$query = $this->db->get_where( 'user', array($field => $key) );
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
		if ( $user === FALSE ) {
			$user['firstname'] = $this->input->post('firstname');
			$user['lastname'] = $this->input->post('lastname');
			$user['email'] = $this->input->post('email');
			$user['pwd'] = md5($this->input->post('pwd'));
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
			$user['firstname'] = $this->input->post('firstname');
			$user['lastname'] = $this->input->post('lastname');
			$user['email'] = $this->input->post('email');
			$user['pwd'] = md5($this->input->post('pwd'));
			$user['phone'] = $this->input->post('phone');
			$user['gender'] = $this->input->post('gender');
			
			$user['modified_time'] = date( 'Y-m-d H:i:s', time() );
			$user['role_id'] = 1;
			$this->db->update('users', $user);
			return $user;
		}
		else if ( is_array($user) ) {
			$this->db->update('users', $user);
			return $user;
		}
		
		return FALSE;
	}
}

?>