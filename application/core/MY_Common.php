<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * MY_Common Class
 *
 * Parses URIs and determines routing, extending the original Router
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @author		Marco Fan
 * @category	Libraries
 * @link		http://codeigniter.com/user_guide/
 */


/**
* Loads the main config.php file
*
* This function lets us grab the config file even if the Config class
* hasn't been instantiated yet
*
* @access	private
* @return	array
*/
if ( ! function_exists('get_config'))
{
	function &get_config($replace = array())
	{
		static $_config;

		if (isset($_config))
		{
			return $_config[0];
		}

		$config_loaded = FALSE;
		if( $_SERVER["SERVER_NAME"] == CN_DOMAIN ){
			if ( ! defined('ENVIRONMENT') OR ! file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/config_cn.php')){
				if( file_exists( APPPATH.'config/config_cn.php' ) ){
					$file_path = APPPATH.'config/config_cn.php';
					$config_loaded = TRUE;
					if( ! defined('IS_CN' ) )
						define( 'IS_CN', 1 );
				}
			}
		}

		if( ! $config_loaded ){
			if ( ! defined('ENVIRONMENT') OR ! file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/config.php')){
				$file_path = APPPATH.'config/config.php';
			}
		}
		
		//echo __FILE__ . " line " . __LINE__ . ": loaded $file_path<br/>";

		// Fetch the config file
		if ( ! file_exists($file_path))
		{
			exit('The configuration file does not exist.');
		}

		require($file_path);

		// Does the $config array exist in the file?
		if ( ! isset($config) OR ! is_array($config))
		{
			exit('Your config file does not appear to be formatted correctly.');
		}

		// Are any values being dynamically replaced?
		if (count($replace) > 0)
		{
			foreach ($replace as $key => $val)
			{
				if (isset($config[$key]))
				{
					$config[$key] = $val;
				}
			}
		}

		return $_config[0] =& $config;
	}
}

?>