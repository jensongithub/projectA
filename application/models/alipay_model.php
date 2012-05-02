<?php
/**
 * 支付?模型
 * @version 0.1
 * @author http://www.heui.org
 *
 */
class Alipay_model extends CI_Model{
 
    var $alipay_config;
 
    function __construct ()
    {
        parent::__construct();
        $this->config->load('alipay', TRUE);
        $this->alipay_config = $this->config->item('alipay');
    }
    /**
     *
     * 服?器异步通知
     */
    function notify_verify ()
    {
        $tmp = array(
            'partner'        => $this->alipay_config['partner'],
            'key'            => $this->alipay_config['key'],
            'sign_type'      => $this->alipay_config['sign_type'],
            '_input_charset' => $this->alipay_config['sign_type'],
            'transport'      => $this->alipay_config['transport'],
        );
 
        $this->load->library('alipay/alipay_notify', $tmp);
        $verify_result = $this->alipay_notify->notify_verify();
 
        if($verify_result) {
            $dingdan           = $_POST['out_trade_no'];    //?取支付?????的???
            $total             = $_POST['total_fee'];       //?取支付?????的?价格
 
            if($_POST['trade_status'] == 'TRADE_FINISHED' ||$_POST['trade_status'] == 'TRADE_SUCCESS') {    //交易成功?束
                echo "success";     //?不要修改或?除
            } else {
                echo "success";     //其他??判?。普通即?到?中，其他??不用判?，直接打印success。
            }
            self::update_status($_POST['trade_no'], $dingdan);
        } else {
            echo "fail";
 
        }
    }
 
    /**
     *
     * ?面跳?同步通知
     */
    function return_verify ()
    {
        $tmp = array(
            'partner'        => $this->alipay_config['partner'],
            'key'            => $this->alipay_config['key'],
            'sign_type'      => $this->alipay_config['sign_type'],
            '_input_charset' => $this->alipay_config['sign_type'],
            'transport'      => $this->alipay_config['transport'],
        );
 
        $this->load->library('alipay/alipay_notify', $tmp);
        $verify_result = $this->alipay_notify->return_verify();
        if($verify_result) {//??成功
 
            $dingdan           = $_GET['out_trade_no'];    //?取???
            $total_fee         = $_GET['total_fee'];        //?取?价格
 
            if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
 
            } else {
                return  $_GET['trade_status'];
            }
            self::update_status($_GET['trade_no'], $dingdan);
        } else {
            return "fail";
        }
    }
 
    /**
     *
     * 更新????（更新支付????）
     * @param string $alipay_trade_no 支付????
     * @param string $order_sn 商????
     */
    function update_status ($alipay_trade_no, $order_id)
    {
        //?在?里加上商?的????程序代
        $this->db->where('name', $order_id);
        $this->db->update('sl_order', array('trade_no' => $alipay_trade_no));
    }
 
    /**
     *
     * 构造提交表?
     * @param ???? $order_id
     * @param ??名 $order_name
     * @param ??金? $money
     */
    function build_form ($order_id, $order_name, $money)
    {
 
        /*以下??是需要通?下??的???据?入???得*/
        //必填??
        $out_trade_no = $order_id;      //?与?网站??系?中的唯一???匹配
        $subject      = $order_name;    //??名?，?示在支付?收?台里的“商品名?”里，?示在支付?的交易管理的“商品名?”的列表里。
        $body         = ''; //??描述、????、???注，?示在支付?收?台里的“商品描述”里
        $total_fee    = $money; //???金?，?示在支付?收?台里的“?付??”里
 
        //?展功能??——默?支付方式
        /*
        $pay_mode     = $_POST['pay_bank'];
        if ($pay_mode == "directPay") {
            $paymethod    = "directPay";    //默?支付方式，四?值可?：bankPay(网?); cartoon(卡通); directPay(余?); CASH(网?支付)
            $defaultbank  = "";
        }
        else {
            $paymethod    = "bankPay";      //默?支付方式，四?值可?：bankPay(网?); cartoon(卡通); directPay(余?); CASH(网?支付)
            $defaultbank  = $pay_mode;      //默?网?代?，代?列表?http://club.alipay.com/read.php?tid=8681379
        }*/
        $paymethod    = "directPay";
        $defaultbank  = "";
 
        //?展功能??——防??
        //?慎重??是否??防??功能
        //exter_invoke_ip、anti_phishing_key一旦被使用?，那么它?就?成?必填??
        //??防??功能后，服?器、本机??必?支持?程XML解析，?配置好??境。
        //若要使用防??功能，?打?class文件?中alipay_function.php文件，找到?文件最下方的query_timestamp函?，根据注???函??行修改
        //建?使用POST方式?求?据
        $anti_phishing_key  = '';           //防????戳
        $exter_invoke_ip =  $this->input->ip_address();               //?取客?端的IP地址，建?：???取客?端IP地址的程序
        //如：
        //$exter_invoke_ip = '202.1.1.1';
        //$anti_phishing_key = query_timestamp($partner);       //?取防????戳函?
 
        //?展功能??——其他
        $extra_common_param = '';           //自定???，可存放任何?容（除=、&等特殊字符外），不??示在?面上
        $buyer_email        = '';           //默??家支付???
 
        //?展功能??——分?(若要使用，?按照注?要求的格式?值)
        $royalty_type       = "";           //提成?型，?值?固定值：10，不需要修改
        $royalty_parameters = "";
        //提成信息集，与需要?合商?网站自身情????取每?交易的各分?收款??、各分?金?、各分??明。最多只能?置10?
        //各分?金?的?和?小于等于total_fee
        //提成信息集格式?：收款方Email_1^金?1^?注1|收款方Email_2^金?2^?注2
        //如：
        //royalty_type = "10"
        //royalty_parameters    = "111@126.com^0.01^分??注一|222@126.com^0.01^分??注二"
 
        //$alipay_config = $this->alipay_config;
        $parameter = array(
            "service"           => "create_direct_pay_by_user",  //接口名?，不需要修改
            "payment_type"      => "1",                          //交易?型，不需要修改
 
            //?取配置文件中的值
            "partner"           => $this->alipay_config['partner'],
            "seller_email"      => $this->alipay_config['seller_email'],
            "return_url"        => $this->alipay_config['return_url'],
            "notify_url"        => $this->alipay_config['notify_url'],
            "_input_charset"    => $this->alipay_config['_input_charset'],
            "show_url"          => $this->alipay_config['show_url'],
 
            //????据中???取到的必填??
            "out_trade_no"      => $out_trade_no,
            "subject"           => $subject,
            "body"              => $body,
            "total_fee"         => $total_fee,
 
            //?展功能??——网?提前
            "paymethod"         => $paymethod,
            "defaultbank"       => $defaultbank,
 
            //?展功能??——防??
            "anti_phishing_key" => $anti_phishing_key,
            "exter_invoke_ip"   => $exter_invoke_ip,
 
            //?展功能??——自定???
            "buyer_email"       => $buyer_email,
            "extra_common_param"=> $extra_common_param,
 
            //?展功能??——分?e
            "royalty_type"      => $royalty_type,
            "royalty_parameters"=> $royalty_parameters
        );
 
        $tmp = array('parameter' => $parameter, 'key' => $this->alipay_config['key'], 'sign_type' =>$this->alipay_config['sign_type']);
 
        $this->load->library('alipay/alipay_service', $tmp);
        return $this->alipay_service->build_form();
    }
 
}