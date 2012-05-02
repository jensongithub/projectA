<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Codeigiter付款?程中服?器通知?
 * @author http://www.heui.org
 * @version 0.1
 */
 
require_once("alipay_function.php");
 
class Alipay_notify {
    var $gateway;           //网?地址
    var $_key;              //安全校??
    var $partner;           //合作伙伴ID
    var $sign_type;         //?名方式 系?默?
    var $mysign;            //?名?果
    var $_input_charset;    //字符??格式
    var $transport;         //??模式
 
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
    /**构造函?
    *?配置文件中初始化?量
    *$partner 合作身份者ID
    *$key 安全校??
    *$sign_type ?名?型
    *$_input_charset 字符??格式
    *$transport ??模式
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
 
    /**?notify_url的??
    *返回的???果：true/false
     */
    function notify_verify() {
        //?取?程服?器ATN?果，??是否是支付?服?器??的?求
        if($this->transport == "https") {
            $veryfy_url = $this->gateway. "service=notify_verify" ."&partner=" .$this->partner. "&notify_id=".$_POST["notify_id"];
        } else {
            $veryfy_url = $this->gateway. "partner=".$this->partner."&notify_id=".$_POST["notify_id"];
        }
        $veryfy_result = $this->get_verify($veryfy_url);
 
        //生成?名?果
        if(empty($_POST)) {                         //判?POST?的??是否?空
            return false;
        }
        else {
            $post          = para_filter($_POST);       //?所有POST返回的??去空
            $sort_post     = arg_sort($post);       //?所有POST反?回?的?据排序
            $this->mysign  = build_mysign($sort_post,$this->_key,$this->sign_type);   //生成?名?果
 
            //?日志??
            log_result("veryfy_result=".$veryfy_result."\n notify_url_log:sign=".$_POST["sign"]."&mysign=".$this->mysign.",".create_linkstring($sort_post));
 
            //判?veryfy_result是否?ture，生成的?名?果mysign与?得的?名?果sign是否一致
            //$veryfy_result的?果不是true，与服?器?置??、合作身份者ID、notify_id一分?失效有?
            //mysign与sign不等，与安全校??、?求?的??格式（如：?自定???等）、??格式有?
            if (preg_match("/true$/i",$veryfy_result) && $this->mysign == $_POST["sign"]) {
                return true;
            } else {
                return false;
            }
        }
    }
 
    /********************************************************************************/
 
    /**?return_url的??
    *return ???果：true/false
     */
    function return_verify() {
        //?取?程服?器ATN?果，??是否是支付?服?器??的?求
        if($this->transport == "https") {
            $veryfy_url = $this->gateway. "service=notify_verify" ."&partner=" .$this->partner. "&notify_id=".$_GET["notify_id"];
        } else {
            $veryfy_url = $this->gateway. "partner=".$this->partner."&notify_id=".$_GET["notify_id"];
        }
        $veryfy_result = $this->get_verify($veryfy_url);
 
        //生成?名?果
        if(empty($_GET)) {                          //判?GET?的??是否?空
            return false;
        }
        else {
            $get          = para_filter($_GET);     //?所有GET反?回?的?据去空
            $sort_get     = arg_sort($get);         //?所有GET反?回?的?据排序
            $this->mysign  = build_mysign($sort_get,$this->_key,$this->sign_type);    //生成?名?果
 
            //?日志??
            //log_result("veryfy_result=".$veryfy_result."\n return_url_log:sign=".$_GET["sign"]."&mysign=".$this->mysign."&".create_linkstring($sort_get));
 
            //判?veryfy_result是否?ture，生成的?名?果mysign与?得的?名?果sign是否一致
            //$veryfy_result的?果不是true，与服?器?置??、合作身份者ID、notify_id一分?失效有?
            //mysign与sign不等，与安全校??、?求?的??格式（如：?自定???等）、??格式有?
            if (preg_match("/true$/i",$veryfy_result) && $this->mysign == $_GET["sign"]) {
                return true;
            }else {
                return false;
            }
        }
    }
 
    /********************************************************************************/
 
    /**?取?程服?器ATN?果
    *$url 指定URL路?地址
    *return 服?器ATN?果集
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