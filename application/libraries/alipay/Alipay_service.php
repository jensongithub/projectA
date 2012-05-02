<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Codeigiter����I?�~���A?���f����
 * @author http://www.heui.org
 * @version 0.1
 */
require_once("alipay_function.php");
class Alipay_service {
 
    var $gateway;           //�I?�a�}
    var $_key;              //�w����??
    var $mysign;            //?�W?�G
    var $sign_type;         //?�W?��
    var $parameter;         //�ݭn?�W��????
    var $_input_charset;    //�r��??�榡
 
    function __construct($parameter)
    {
        self::Alipay_service(
            $parameter['parameter'],
            $parameter['key'],
            $parameter['sign_type']
        );
    }
 
    /**
     * �۳y��?
     * ?�t�m���ΤJ�f��󤤪�l��?�q
     * @param array $parameter �ݭn?�W��????
     * @param string $key �w����??
     * @param string $sign_type ?�W?��
     */
    public function Alipay_service($parameter, $key, $sign_type)
    {
 
        $this->gateway      = "https://www.alipay.com/cooperate/gateway.do?";
        $this->_key        = $key;
        $this->sign_type   = $sign_type;
 
        $this->parameter   = para_filter($parameter);
 
        //?�w_input_charset����,?�ŭȪ���?�U�q??GBK
        if($this->parameter['_input_charset'] == '')
            $this->parameter['_input_charset'] = 'GBK';
 
        $this->_input_charset   = $this->parameter['_input_charset'];
 
        //?�o?�W?�G
        $sort_array   = arg_sort($this->parameter);    //�o��?�r��a��z�ƧǦZ��?�W????
        $this->mysign = build_mysign($sort_array,$this->_key,$this->sign_type);
    }
 
    /**
     *
     * Enter description here ...
     */
    function build_form() {
        //GET�覡??
        $sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='".$this->gateway."_input_charset=".$this->parameter['_input_charset']."' method='get'>";
        //POST�覡??�]GET�OPOST�G��?�@�^
        //$sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='".$this->gateway."_input_charset=".$this->parameter['_input_charset']."' method='post'>";
 
        while (list ($key, $val) = each ($this->parameter)) {
            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }
 
        $sHtml = $sHtml."<input type='hidden' name='sign' value='".$this->mysign."'/>";
        $sHtml = $sHtml."<input type='hidden' name='sign_type' value='".$this->sign_type."'/>";
 
        //submit��?����?���n�t��name?��
        $sHtml = $sHtml."<input type='submit' value='��I?��?�I��'></form>";
 
        //$sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";
 
        return $sHtml;
    }
 
}