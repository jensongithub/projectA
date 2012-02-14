<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
Should be in : /application/librairies
Must be declare in /application/config/autoload.php in the 
$autoload['libraries'] = array('your_other libraires','locale');
*/

class CI_Locale {
	var $domain = 'yourdomain.com'; // name of the po files (I use the domain name , but It can be anything)

	function __construct() {
		$CI =& get_instance();
		$locale = $CI->lang->lang();
		$locale .= '_' . strtoupper($locale);
		
		putenv("LANG=$locale");
		setlocale(LC_ALL, $locale);
		bindtextdomain($this->domain, APPPATH.'language/locales/');
		textdomain($this->domain);
		bind_textdomain_codeset($this->domain, 'UTF-8');
	}
}
