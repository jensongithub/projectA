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
 * @link			http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Language Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link			http://codeigniter.com/user_guide/helpers/language_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Lang
 *
 * Load a language file by the given parameter
 *
 * @access	public
 * @param	string	the language line
 * @param	string	the id of the form element
 * @return	string
 */
if ( ! function_exists('load_lang')) {
	function load_lang($langfile = '') {
		global $URI;
		$segment = $URI->segment(1);

		$ci = get_instance(); // CI_Loader instance
		$languages = $ci->config->item('lang');

		if (isset($languages[$segment]))	{
			$language = $languages[$segment];
		}
		else {
			$language = $ci->config->item('language');
		}
		$ci->lang->load($langfile, $language);
	}
}


// ------------------------------------------------------------------------

/**
 * Lang
 *
 * Fetches a language variable and optionally outputs a form label
 *
 * @access	public
 * @param	string	the language line
 * @param	string	the id of the form element
 * @return	string
 */
if ( ! function_exists('lang')) {
	function lang($line, $id = '') {
		$CI =& get_instance();
		$line = $CI->lang->line($line);

		if ($id != '')	{
			$line = '<label for="'.$id.'">'.$line."</label>";
		}

		return $line;
	}
}

if ( ! function_exists('lang')) {
	function lang($line, $id = '') {
		$CI =& get_instance();
		$line = $CI->lang->line($line);

		$args = func_get_args();

		if(is_array($args)) array_shift($args);

		if(is_array($args) && count($args)) {
			foreach($args as $arg) {
				$line = str_replace_first('%s', $arg, $line);
			}
		}

		if ($id != '') {
			$line = '<label for="'.$id.'">'.$line."</label>";
		}

		return $line;
	}
}

if ( ! function_exists('lang')) {
	function str_replace_first($search_for, $replace_with, $in) {
		$pos = strpos($in, $search_for);
		if($pos === false) {
			return $in;
		}
		else {
			return substr($in, 0, $pos) . $replace_with . substr($in, $pos + strlen($search_for), strlen($in));
		}
	}
}

/* End of file my_language_helper.php */
/* Location: ./application/helpers/my_language_helper.php */