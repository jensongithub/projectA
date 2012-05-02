<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *功能：支付?接口公用函?
 * @author http://www.heui.org
 * @version 0.1
 */
 
/**生成?名?果
 *$array要?名的??
 *return ?名?果字符串
*/
function build_mysign($sort_array,$key,$sign_type = "MD5") {
    $prestr = create_linkstring($sort_array);       //把??所有元素，按照“??=??值”的模式用“&”字符拼接成字符串
    $prestr = $prestr.$key;                         //把拼接后的字符串再与安全校??直接?接起?
    $mysgin = sign($prestr,$sign_type);             //把最?的字符串?名，?得?名?果
    return $mysgin;
}  
 
/********************************************************************************/
 
/**把??所有元素，按照“??=??值”的模式用“&”字符拼接成字符串
    *$array 需要拼接的??
    *return 拼接完成以后的字符串
*/
function create_linkstring($array) {
    $arg  = "";
    while (list ($key, $val) = each ($array)) {
        $arg.=$key."=".$val."&";
    }
    $arg = substr($arg,0,count($arg)-2);             //去掉最后一?&字符
    return $arg;
}
 
/********************************************************************************/
 
/**除去??中的空值和?名??
    *$parameter ?名???
    *return 去掉空值与?名??后的新?名???
 */
function para_filter($parameter) {
    $para = array();
    while (list ($key, $val) = each ($parameter)) {
        if($key == "sign" || $key == "sign_type" || $val == "")continue;
        else    $para[$key] = $parameter[$key];
    }
    return $para;
}
 
/********************************************************************************/
 
/**???排序
    *$array 排序前的??
    *return 排序后的??
 */
function arg_sort($array) {
    ksort($array);
    reset($array);
    return $array;
}
 
/********************************************************************************/
 
/**?名字符串
    *$prestr 需要?名的字符串
    *return ?名?果
 */
function sign($prestr,$sign_type) {
    $sign='';
    if($sign_type == 'MD5') {
        $sign = md5($prestr);
    }elseif($sign_type =='DSA') {
        //DSA ?名方法待后???
        die("DSA ?名方法待后???，?先使用MD5?名方式");
    }else {
        die("支付??不支持".$sign_type."?型的?名方式");
    }
    return $sign;
}
 
/********************************************************************************/
 
// 日志消息,把支付?返回的????下?
// ?注意服?器是否?通fopen配置
function  log_result($word) {
    $fp = fopen("log.txt","a");
    flock($fp, LOCK_EX) ;
    fwrite($fp,"?行日期：".strftime("%Y%m%d%H%M%S",time())."\n".$word."\n");
    flock($fp, LOCK_UN);
    fclose($fp);
}  
 
/********************************************************************************/
 
/**??多种字符??方式
    *$input 需要??的字符串
    *$_output_charset ?出的??格式
    *$_input_charset ?入的??格式
    *return ??后的字符串
 */
function charset_encode($input,$_output_charset ,$_input_charset) {
    $output = "";
    if(!isset($_output_charset) )$_output_charset  = $_input_charset;
    if($_input_charset == $_output_charset || $input ==null ) {
        $output = $input;
    } elseif (function_exists("mb_convert_encoding")) {
        $output = mb_convert_encoding($input,$_output_charset,$_input_charset);
    } elseif(function_exists("iconv")) {
        $output = iconv($_input_charset,$_output_charset,$input);
    } else die("sorry, you have no libs support for charset change.");
    return $output;
}
 
/********************************************************************************/
 
/**??多种字符解?方式
    *$input 需要解?的字符串
    *$_output_charset ?出的解?格式
    *$_input_charset ?入的解?格式
    *return 解?后的字符串
 */
function charset_decode($input,$_input_charset ,$_output_charset) {
    $output = "";
    if(!isset($_input_charset) )$_input_charset  = $_input_charset ;
    if($_input_charset == $_output_charset || $input ==null ) {
        $output = $input;
    } elseif (function_exists("mb_convert_encoding")) {
        $output = mb_convert_encoding($input,$_output_charset,$_input_charset);
    } elseif(function_exists("iconv")) {
        $output = iconv($_input_charset,$_output_charset,$input);
    } else die("sorry, you have no libs support for charset changes.");
    return $output;
}
 
/*********************************************************************************/
 
/**用于防??，?用接口query_timestamp??取??戳的?理函?
注意：由于低版本的PHP配置?境不支持?程XML解析，因此必?服?器、本地??中?有支持DOMDocument、SSL的PHP配置?境。建?本地???使用PHP???件
*$partner 合作身份者ID
*return ??戳字符串
*/
function query_timestamp($partner) {
    $URL = "https://mapi.alipay.com/gateway.do?service=query_timestamp&partner=".$partner;
    $encrypt_key = "";
//若要使用防??，?取消下面的4行注?
//    $doc = new DOMDocument();
//    $doc->load($URL);
//    $itemEncrypt_key = $doc->getElementsByTagName( "encrypt_key" );
//    $encrypt_key = $itemEncrypt_key->item(0)->nodeValue;
//    return $encrypt_key;
}
 
?>