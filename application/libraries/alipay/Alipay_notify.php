<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Codeigiter�I��?�{���A?���q��?
 * @author http://www.heui.org
 * @version 0.1
 */
 
require_once("alipay_function.php");
 
class Alipay_notify {
    var $gateway;           //�I?�a�}
    var $_key;              //�w����??
    var $partner;           //�X�@���ID
    var $sign_type;         //?�W�覡 �t?�q?
    var $mysign;            //?�W?�G
    var $_input_charset;    //�r��??�榡
    var $transport;         //??�Ҧ�
 
    function __construct($parameter)
    {
        self::Alipay_notify(
            $parameter['partner'],
            $parameter['key'],
            $parameter['sign_type'],
            $parameter['_input_charset'],
            $parameter['transport']
        );
    }
    /**�۳y��?
    *?�t�m��󤤪�l��?�q
    *$partner �X�@������ID
    *$key �w����??
    *$sign_type ?�W?��
    *$_input_charset �r��??�榡
    *$transport ??�Ҧ�
     */
    function Alipay_notify($partner,$key,$sign_type,$_input_charset = "GBK",$transport= "https") {
 
        $this->transport = $transport;
        if($this->transport == "https") {
            $this->gateway = "https://www.alipay.com/cooperate/gateway.do?";
        }else {
            $this->gateway = "http://notify.alipay.com/trade/notify_query.do?";
        }
        $this->partner          = $partner;
        $this->_key    = $key;
        $this->mysign           = "";
        $this->sign_type     = $sign_type;
        $this->_input_charset   = $_input_charset;
    }
 
    /********************************************************************************/
 
    /**?notify_url��??
    *��^��???�G�Gtrue/false
     */
    function notify_verify() {
        //?��?�{�A?��ATN?�G�A??�O�_�O��I?�A?��??��?�D
        if($this->transport == "https") {
            $veryfy_url = $this->gateway. "service=notify_verify" ."&partner=" .$this->partner. "&notify_id=".$_POST["notify_id"];
        } else {
            $veryfy_url = $this->gateway. "partner=".$this->partner."&notify_id=".$_POST["notify_id"];
        }
        $veryfy_result = $this->get_verify($veryfy_url);
 
        //�ͦ�?�W?�G
        if(empty($_POST)) {                         //�P?POST?��??�O�_?��
            return false;
        }
        else {
            $post          = para_filter($_POST);       //?�Ҧ�POST��^��??�h��
            $sort_post     = arg_sort($post);       //?�Ҧ�POST��?�^?��?�u�Ƨ�
            $this->mysign  = build_mysign($sort_post,$this->_key,$this->sign_type);   //�ͦ�?�W?�G
 
            //?���??
            log_result("veryfy_result=".$veryfy_result."\n notify_url_log:sign=".$_POST["sign"]."&mysign=".$this->mysign.",".create_linkstring($sort_post));
 
            //�P?veryfy_result�O�_?ture�A�ͦ���?�W?�Gmysign�O?�o��?�W?�Gsign�O�_�@�P
            //$veryfy_result��?�G���Otrue�A�O�A?��?�m??�B�X�@������ID�Bnotify_id�@��?���Ħ�?
            //mysign�Osign�����A�O�w����??�B?�D?��??�榡�]�p�G?�۩w???���^�B??�榡��?
            if (preg_match("/true$/i",$veryfy_result) && $this->mysign == $_POST["sign"]) {
                return true;
            } else {
                return false;
            }
        }
    }
 
    /********************************************************************************/
 
    /**?return_url��??
    *return ???�G�Gtrue/false
     */
    function return_verify() {
        //?��?�{�A?��ATN?�G�A??�O�_�O��I?�A?��??��?�D
        if($this->transport == "https") {
            $veryfy_url = $this->gateway. "service=notify_verify" ."&partner=" .$this->partner. "&notify_id=".$_GET["notify_id"];
        } else {
            $veryfy_url = $this->gateway. "partner=".$this->partner."&notify_id=".$_GET["notify_id"];
        }
        $veryfy_result = $this->get_verify($veryfy_url);
 
        //�ͦ�?�W?�G
        if(empty($_GET)) {                          //�P?GET?��??�O�_?��
            return false;
        }
        else {
            $get          = para_filter($_GET);     //?�Ҧ�GET��?�^?��?�u�h��
            $sort_get     = arg_sort($get);         //?�Ҧ�GET��?�^?��?�u�Ƨ�
            $this->mysign  = build_mysign($sort_get,$this->_key,$this->sign_type);    //�ͦ�?�W?�G
 
            //?���??
            //log_result("veryfy_result=".$veryfy_result."\n return_url_log:sign=".$_GET["sign"]."&mysign=".$this->mysign."&".create_linkstring($sort_get));
 
            //�P?veryfy_result�O�_?ture�A�ͦ���?�W?�Gmysign�O?�o��?�W?�Gsign�O�_�@�P
            //$veryfy_result��?�G���Otrue�A�O�A?��?�m??�B�X�@������ID�Bnotify_id�@��?���Ħ�?
            //mysign�Osign�����A�O�w����??�B?�D?��??�榡�]�p�G?�۩w???���^�B??�榡��?
            if (preg_match("/true$/i",$veryfy_result) && $this->mysign == $_GET["sign"]) {
                return true;
            }else {
                return false;
            }
        }
    }
 
    /********************************************************************************/
 
    /**?��?�{�A?��ATN?�G
    *$url ���wURL��?�a�}
    *return �A?��ATN?�G��
     */
    function get_verify($url,$time_out = "60") {
        $urlarr     = parse_url($url);
        $errno      = "";
        $errstr     = "";
        $transports = "";
        if($urlarr["scheme"] == "https") {
            $transports = "ssl://";
            $urlarr["port"] = "443";
        } else {
            $transports = "tcp://";
            $urlarr["port"] = "80";
        }
        $fp=@fsockopen($transports . $urlarr['host'],$urlarr['port'],$errno,$errstr,$time_out);
        if(!$fp) {
            die("ERROR: $errno - $errstr<br />\n");
        } else {
            fputs($fp, "POST ".$urlarr["path"]." HTTP/1.1\r\n");
            fputs($fp, "Host: ".$urlarr["host"]."\r\n");
            fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
            fputs($fp, "Content-length: ".strlen($urlarr["query"])."\r\n");
            fputs($fp, "Connection: close\r\n\r\n");
            fputs($fp, $urlarr["query"] . "\r\n\r\n");
            while(!feof($fp)) {
                $info[]=@fgets($fp, 1024);
            }
            fclose($fp);
            $info = implode(",",$info);
            return $info;
        }
    }
 
    /********************************************************************************/
 
}
?>