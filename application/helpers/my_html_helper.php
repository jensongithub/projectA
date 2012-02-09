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
 * CodeIgniter HTML Helpers
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
				return $ci->config->item('base_url') . $ci->config->item($resource . '_dir');

			default:
				return '';
		}
	}
}


// ------------------------------------------------------------------------

/**
 * Return the local path to the css file
 *
 * @access	public
 * @param	string	resource
 * @return	string	path to the resource
 */
if ( ! function_exists('css')) {
	function css($resource, $media = 'screen', $render_path = TRUE) {
		$ci =& get_instance();
		$css = "<link rel='stylesheet' type='text/css' href='";
		if( $render_path === TRUE ) {
			$css .= $ci->config->item('base_url') . $ci->config->item('css_dir') . $resource;
		}
		else {
			$css .= $ci->config->item('base_url') . $resource;
		}
		$css .= "' media='$media' />";
		return $css;
	}
}


// ------------------------------------------------------------------------

/**
 * Return the local path to the javascript file
 *
 * @access	public
 * @param	string	resource
 * @return	string	path to the resource
 */
if ( ! function_exists('js')) {
	function js($resource) {
		$ci =& get_instance();
		$js = "<script type='text/javascript' src='";
		$js .= $ci->config->item('base_url') . $ci->config->item('js_dir') . $resource;
		$js .= "' ></script>";
		return $js;
	}
}


// ------------------------------------------------------------------------

/**
 * Image
 *
 * Generates an <img /> element
 *
 * @access	public
 * @param	mixed
 * @return	string
 */
if ( ! function_exists('img'))
{
	function img($src = '', $index_page = FALSE)
	{
		if ( ! is_array($src) )
		{
			$src = array('src' => $src);
		}

		// If there is no alt attribute defined, set it to an empty string
		if ( ! isset($src['alt']))
		{
			$src['alt'] = '';
		}

		$img = '<img';

		foreach ($src as $k=>$v)
		{

			if ($k == 'src' AND strpos($v, '://') === FALSE)
			{
				$CI =& get_instance();

				if ($index_page === TRUE)
				{
					$img .= ' src="'.$CI->config->site_url($v).'"';
				}
				else
				{
					$img .= ' src="'.$CI->config->slash_item('base_url').$CI->config->item('image_dir').$v.'"';
				}
			}
			else
			{
				$img .= " $k=\"$v\"";
			}
		}

		$img .= '/>';

		return $img;
	}
}

/* End of file my_path_helper.php */
/* Location: ./application/helpers/my_path_helper.php */