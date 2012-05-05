<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
Should be in : /application/librairies
Must be declare in /application/config/autoload.php in the 
$autoload['libraries'] = array('your_other libraries','locale');
*/

require_once('gettext.inc');

class CI_Locale {
	function __construct() {
		$CI =& get_instance();
		$lang = $CI->lang->lang();

		$locale = 'en_US';
		if( $lang == 'zh' )
			$locale = 'zh_HK';
		else if( $lang == 'cn' )
			$locale = 'zh_CN';

		$path = APPPATH . "language/locales";
		$encoding = 'UTF-8';
		$domain = 'lna';

		/*
		$path = "php-gettext-1.0.11/examples/locale";
		$locale = 'zh_TW';
		$domain = 'messages';
		*/

		T_setlocale(LC_MESSAGES, $locale);
		T_bindtextdomain($domain, $path);
		T_bind_textdomain_codeset($domain, $encoding);
		T_textdomain($domain);
	}
}

?>