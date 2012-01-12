<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Path Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Marco Fan
 * @link		
 */

// ------------------------------------------------------------------------

/**
 * Return useful path
 *
 * Return the absolute path to the specified resource.
 *
 * @access	public
 * @param	string	resource (images, js, css)
 * @return	string	path to the resource
 */
if ( ! function_exists('get_path')) {
	function get_path($resource) {
		switch($resource) {
			case 'image':
			case 'js':
			case 'css':
				$ci =& get_instance();
				return 'http://' . $ci->config->item('base_url') . $ci->config->item($resource . '_dir');

			default:
				return '';
		}
	}
}


/* End of file my_path_helper.php */
/* Location: ./application/helpers/my_path_helper.php */