<?php
/**
 * ��I?�ҫ�
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
     * �A?���ݨB�q��
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
            $dingdan           = $_POST['out_trade_no'];    //?����I?????��???
            $total             = $_POST['total_fee'];       //?����I?????��?ɲ��
 
            if($_POST['trade_status'] == 'TRADE_FINISHED' ||$_POST['trade_status'] == 'TRADE_SUCCESS') {    //������\?��
                echo "success";     //?���n�ק��?��
            } else {
                echo "success";     //��L??�P?�C���q�Y?��?���A��L??���ΧP?�A�������Lsuccess�C
            }
            self::update_status($_POST['trade_no'], $dingdan);
        } else {
            echo "fail";
 
        }
    }
 
    /**
     *
     * ?����?�P�B�q��
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
        if($verify_result) {//??���\
 
            $dingdan           = $_GET['out_trade_no'];    //?��???
            $total_fee         = $_GET['total_fee'];        //?��?ɲ��
 
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
     * ��s????�]��s��I????�^
     * @param string $alipay_trade_no ��I????
     * @param string $order_sn ��????
     */
    function update_status ($alipay_trade_no, $order_id)
    {
        //?�b?���[�W��?��????�{�ǥN
        $this->db->where('name', $order_id);
        $this->db->update('sl_order', array('trade_no' => $alipay_trade_no));
    }
 
    /**
     *
     * �۳y�����?
     * @param ???? $order_id
     * @param ??�W $order_name
     * @param ??��? $money
     */
    function build_form ($order_id, $order_name, $money)
    {
 
        /*�H�U??�O�ݭn�q?�U??��???�u?�J???�o*/
        //����??
        $out_trade_no = $order_id;      //?�O?�I��??�t?�����ߤ@???�ǰt
        $subject      = $order_name;    //??�W?�A?�ܦb��I?��?�x�������ӫ~�W?�����A?�ܦb��I?������޲z�����ӫ~�W?�����C���C
        $body         = ''; //??�y�z�B????�B???�`�A?�ܦb��I?��?�x�������ӫ~�y�z����
        $total_fee    = $money; //???��?�A?�ܦb��I?��?�x������?�I??����
 
        //?�i�\��??�X�X�q?��I�覡
        /*
        $pay_mode     = $_POST['pay_bank'];
        if ($pay_mode == "directPay") {
            $paymethod    = "directPay";    //�q?��I�覡�A�|?�ȥi?�GbankPay(�I?); cartoon(�d�q); directPay(�E?); CASH(�I?��I)
            $defaultbank  = "";
        }
        else {
            $paymethod    = "bankPay";      //�q?��I�覡�A�|?�ȥi?�GbankPay(�I?); cartoon(�d�q); directPay(�E?); CASH(�I?��I)
            $defaultbank  = $pay_mode;      //�q?�I?�N?�A�N?�C��?http://club.alipay.com/read.php?tid=8681379
        }*/
        $paymethod    = "directPay";
        $defaultbank  = "";
 
        //?�i�\��??�X�X��??
        //?�V��??�O�_??��??�\��
        //exter_invoke_ip�Banti_phishing_key�@���Q�ϥ�?�A���\��?�N?��?����??
        //??��??�\��Z�A�A?���B����??��?���?�{XML�ѪR�A?�t�m�n??�ҡC
        //�Y�n�ϥΨ�??�\��A?��?class���?��alipay_function.php���A���?���̤U�誺query_timestamp��?�A���u�`???��??��ק�
        //��?�ϥ�POST�覡?�D?�u
        $anti_phishing_key  = '';           //��????�W
        $exter_invoke_ip =  $this->input->ip_address();               //?����?�ݪ�IP�a�}�A��?�G???����?��IP�a�}���{��
        //�p�G
        //$exter_invoke_ip = '202.1.1.1';
        //$anti_phishing_key = query_timestamp($partner);       //?����????�W��?
 
        //?�i�\��??�X�X��L
        $extra_common_param = '';           //�۩w???�A�i�s�����?�e�]��=�B&���S��r�ť~�^�A��??�ܦb?���W
        $buyer_email        = '';           //�q??�a��I???
 
        //?�i�\��??�X�X��?(�Y�n�ϥΡA?���Ӫ`?�n�D���榡?��)
        $royalty_type       = "";           //����?���A?��?�T�w�ȡG10�A���ݭn�ק�
        $royalty_parameters = "";
        //�����H�����A�O�ݭn?�X��?�I���ۨ���????���C?������U��?����??�B�U��?��?�B�U��??���C�̦h�u��?�m10?
        //�U��?��?��?�M?�p�_���_total_fee
        //�����H�����榡?�G���ڤ�Email_1^��?1^?�`1|���ڤ�Email_2^��?2^?�`2
        //�p�G
        //royalty_type = "10"
        //royalty_parameters    = "111@126.com^0.01^��??�`�@|222@126.com^0.01^��??�`�G"
 
        //$alipay_config = $this->alipay_config;
        $parameter = array(
            "service"           => "create_direct_pay_by_user",  //���f�W?�A���ݭn�ק�
            "payment_type"      => "1",                          //���?���A���ݭn�ק�
 
            //?���t�m��󤤪���
            "partner"           => $this->alipay_config['partner'],
            "seller_email"      => $this->alipay_config['seller_email'],
            "return_url"        => $this->alipay_config['return_url'],
            "notify_url"        => $this->alipay_config['notify_url'],
            "_input_charset"    => $this->alipay_config['_input_charset'],
            "show_url"          => $this->alipay_config['show_url'],
 
            //????�u��???���쪺����??
            "out_trade_no"      => $out_trade_no,
            "subject"           => $subject,
            "body"              => $body,
            "total_fee"         => $total_fee,
 
            //?�i�\��??�X�X�I?���e
            "paymethod"         => $paymethod,
            "defaultbank"       => $defaultbank,
 
            //?�i�\��??�X�X��??
            "anti_phishing_key" => $anti_phishing_key,
            "exter_invoke_ip"   => $exter_invoke_ip,
 
            //?�i�\��??�X�X�۩w???
            "buyer_email"       => $buyer_email,
            "extra_common_param"=> $extra_common_param,
 
            //?�i�\��??�X�X��?e
            "royalty_type"      => $royalty_type,
            "royalty_parameters"=> $royalty_parameters
        );
 
        $tmp = array('parameter' => $parameter, 'key' => $this->alipay_config['key'], 'sign_type' =>$this->alipay_config['sign_type']);
 
        $this->load->library('alipay/alipay_service', $tmp);
        return $this->alipay_service->build_form();
    }
 
}