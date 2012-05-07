<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		Rick Ellis
 * @copyright	Copyright (c) 2006, EllisLab, Inc.
 * @license		http://www.codeignitor.com/user_guide/license.html
 * @link		http://www.codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * SQLSRV Result Class
 *
 * This class extends the parent result class: CI_DB_result
 *
 * @category	Database
 * @author		Jon Ellis-Jones	<jon@kaweb.co.uk>
 * @link		http://www.kaweb.co.uk/blog/mssql-server-2005-and-codeigniter
 */
class CI_DB_sqlsrv_result extends CI_DB_result {
	
	/**
	 * Number of rows in the result set
	 *
	 * @access	public
	 * @return	integer
	 * @link	http://blogs.msdn.com/sqlphp/archive/2008/03/05/functions-to-return-row-count-and-field-count.aspx
	 */
	function num_rows()
	{
		return count(@sqlsrv_field_metadata($this->result_id));
	}
	
	// --------------------------------------------------------------------

	/**
	 * Number of fields in the result set
	 *
	 * @access	public
	 * @return	integer
	 */
	function num_fields()
	{
		return @sqlsrv_num_fields($this->result_id);
	}

	// --------------------------------------------------------------------

	/**
	 * Fetch Field Names
	 *
	 * Generates an array of column names
	 *
	 * @access	public
	 * @return	array
	 */
	function list_fields()
	{
		$field_names = array();
		foreach(sqlsrv_field_metadata($this->result_id) as $offset => $field)
		{
			$field_names[] = $field['Name'];
		}
		
		return $field_names;
	}
	
	// Deprecated
	function field_names()
	{
		return $this->list_fields();
	}

	// --------------------------------------------------------------------

	/**
	 * Field data
	 *
	 * Generates an array of objects containing field meta-data
	 *
	 * @access	public
	 * @return	array
	 */
	function field_data()
	{
		$retval = array();
		foreach(sqlsrv_field_metadata($this->result_id) as $offset => $field)
		{
			$F 				= new stdClass();
			$F->name 		= $field['Name'];
			$F->type 		= $field['Type'];
			$F->max_length	= $field['Size'];
			$F->primary_key = 0;
			$F->default		= '';
			
			$retval[] = $F;
		}
		
		return $retval;
	}

	// --------------------------------------------------------------------

	/**
	 * Free the result
	 *
	 * @return	null
	 */		
	function free_result()
	{
		if (is_resource($this->result_id))
		{
			sqlsrv_free_stmt($this->result_id);
			$this->result_id = FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Data Seek
	 *
	 * Moves the internal pointer to the desired offset.  We call
	 * this internally before fetching results to make sure the
	 * result set starts at zero
	 *
	 * @access	private
	 * @return	array
	 */
	function _data_seek($n = 0)
	{
		return;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Result - associative array
	 *
	 * Returns the result set as an array
	 *
	 * @access	private
	 * @return	array
	 */
	function _fetch_assoc()
	{
		return sqlsrv_fetch_array($this->result_id, SQLSRV_FETCH_ASSOC);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Result - object
	 *
	 * Returns the result set as an object
	 *
	 * @access	private
	 * @return	object
	 */
	function _fetch_object()
	{
		return sqlsrv_fetch_object($this->result_id);
	}
}

?>