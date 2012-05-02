<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Codeigiter的支付?外部服?接口控制
 * @author http://www.heui.org
 * @version 0.1
 */
require_once("alipay_function.php");
class Alipay_service {
 
    var $gateway;           //网?地址
    var $_key;              //安全校??
    var $mysign;            //?名?果
    var $sign_type;         //?名?型
    var $parameter;         //需要?名的????
    var $_input_charset;    //字符??格式
 
    function __construct($parameter)
    {
        self::Alipay_service(
            $parameter['parameter'],
            $parameter['key'],
            $parameter['sign_type']
        );
    }
 
    /**
     * 构造函?
     * ?配置文件及入口文件中初始化?量
     * @param array $parameter 需要?名的????
     * @param string $key 安全校??
     * @param string $sign_type ?名?型
     */
    public function Alipay_service($parameter, $key, $sign_type)
    {
 
        $this->gateway      = "https://www.alipay.com/cooperate/gateway.do?";
        $this->_key        = $key;
        $this->sign_type   = $sign_type;
 
        $this->parameter   = para_filter($parameter);
 
        //?定_input_charset的值,?空值的情?下默??GBK
        if($this->parameter['_input_charset'] == '')
            $this->parameter['_input_charset'] = 'GBK';
 
        $this->_input_charset   = $this->parameter['_input_charset'];
 
        //?得?名?果
        $sort_array   = arg_sort($this->parameter);    //得到?字母a到z排序后的?名????
        $this->mysign = build_mysign($sort_array,$this->_key,$this->sign_type);
    }
 
    /**
     *
     * Enter description here ...
     */
    function build_form() {
        //GET方式??
        $sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='".$this->gateway."_input_charset=".$this->parameter['_input_charset']."' method='get'>";
        //POST方式??（GET与POST二必?一）
        //$sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='".$this->gateway."_input_charset=".$this->parameter['_input_charset']."' method='post'>";
 
        while (list ($key, $val) = each ($this->parameter)) {
            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }
 
        $sHtml = $sHtml."<input type='hidden' name='sign' value='".$this->mysign."'/>";
        $sHtml = $sHtml."<input type='hidden' name='sign_type' value='".$this->sign_type."'/>";
 
        //submit按?控件?不要含有name?性
        $sHtml = $sHtml."<input type='submit' value='支付?确?付款'></form>";
 
        //$sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";
 
        return $sHtml;
    }
 
}