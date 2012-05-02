<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *�\��G��I?���f���Ψ�?
 * @author http://www.heui.org
 * @version 0.1
 */
 
/**�ͦ�?�W?�G
 *$array�n?�W��??
 *return ?�W?�G�r�Ŧ�
*/
function build_mysign($sort_array,$key,$sign_type = "MD5") {
    $prestr = create_linkstring($sort_array);       //��??�Ҧ������A���ӡ�??=??�ȡ����Ҧ��Ρ�&���r�ū������r�Ŧ�
    $prestr = $prestr.$key;                         //������Z���r�Ŧ�A�O�w����??����?���_?
    $mysgin = sign($prestr,$sign_type);             //���?���r�Ŧ�?�W�A?�o?�W?�G
    return $mysgin;
}  
 
/********************************************************************************/
 
/**��??�Ҧ������A���ӡ�??=??�ȡ����Ҧ��Ρ�&���r�ū������r�Ŧ�
    *$array �ݭn������??
    *return ���������H�Z���r�Ŧ�
*/
function create_linkstring($array) {
    $arg  = "";
    while (list ($key, $val) = each ($array)) {
        $arg.=$key."=".$val."&";
    }
    $arg = substr($arg,0,count($arg)-2);             //�h���̦Z�@?&�r��
    return $arg;
}
 
/********************************************************************************/
 
/**���h??�����ŭȩM?�W??
    *$parameter ?�W???
    *return �h���ŭ��O?�W??�Z���s?�W???
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
 
/**???�Ƨ�
    *$array �Ƨǫe��??
    *return �ƧǦZ��??
 */
function arg_sort($array) {
    ksort($array);
    reset($array);
    return $array;
}
 
/********************************************************************************/
 
/**?�W�r�Ŧ�
    *$prestr �ݭn?�W���r�Ŧ�
    *return ?�W?�G
 */
function sign($prestr,$sign_type) {
    $sign='';
    if($sign_type == 'MD5') {
        $sign = md5($prestr);
    }elseif($sign_type =='DSA') {
        //DSA ?�W��k�ݦZ???
        die("DSA ?�W��k�ݦZ???�A?���ϥ�MD5?�W�覡");
    }else {
        die("��I??�����".$sign_type."?����?�W�覡");
    }
    return $sign;
}
 
/********************************************************************************/
 
// ��Ӯ���,���I?��^��????�U?
// ?�`�N�A?���O�_?�qfopen�t�m
function  log_result($word) {
    $fp = fopen("log.txt","a");
    flock($fp, LOCK_EX) ;
    fwrite($fp,"?�����G".strftime("%Y%m%d%H%M%S",time())."\n".$word."\n");
    flock($fp, LOCK_UN);
    fclose($fp);
}  
 
/********************************************************************************/
 
/**??�h���r��??�覡
    *$input �ݭn??���r�Ŧ�
    *$_output_charset ?�X��??�榡
    *$_input_charset ?�J��??�榡
    *return ??�Z���r�Ŧ�
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
 
/**??�h���r�Ÿ�?�覡
    *$input �ݭn��?���r�Ŧ�
    *$_output_charset ?�X����?�榡
    *$_input_charset ?�J����?�榡
    *return ��?�Z���r�Ŧ�
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
 
/**�Τ_��??�A?�α��fquery_timestamp??��??�W��?�z��?
�`�N�G�Ѥ_�C������PHP�t�m?�Ҥ����?�{XML�ѪR�A�]����?�A?���B���a??��?�����DOMDocument�BSSL��PHP�t�m?�ҡC��?���a???�ϥ�PHP???��
*$partner �X�@������ID
*return ??�W�r�Ŧ�
*/
function query_timestamp($partner) {
    $URL = "https://mapi.alipay.com/gateway.do?service=query_timestamp&partner=".$partner;
    $encrypt_key = "";
//�Y�n�ϥΨ�??�A?�����U����4��`?
//    $doc = new DOMDocument();
//    $doc->load($URL);
//    $itemEncrypt_key = $doc->getElementsByTagName( "encrypt_key" );
//    $encrypt_key = $itemEncrypt_key->item(0)->nodeValue;
//    return $encrypt_key;
}
 
?>