<?php
//合作身份者ID，以2088??的16位??字
$config['partner']      = "";
 
//安全???，以?字和字母?成的32位字符
$config['key']              = "";
 
//??支付???或?家支付???
$config['seller_email'] = "info@casimira.com";
 
//交易?程中服?器通知的?面 要用 http://格式的完整路?，不允?加?id=123??自定???
$config['notify_url']       = "";
 
//付完款后跳?的?面 要用 http://格式的完整路?，不允?加?id=123??自定???
$config['return_url']       = "";
 
//网站商品的展示地址，不允?加?id=123??自定???
$config['show_url']     = "http://www.casimira.com.hk";
 
//收款方名?，如：公司名?、网站名?、收款人姓名等
$config['mainname']     = "Casimira";
 
//↑↑↑↑↑↑↑↑↑↑?在?里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
//$config['total_fee']    = 1;  //???金?，?示在支付?收?台里的“?付??”里
 
//?名方式 不需修改
$config['sign_type']        = "MD5";
 
//字符??格式 目前支持 GBK 或 utf-8
$config['_input_charset']   = "utf-8";
 
//??模式,根据自己的服?器是否支持ssl??，若支持???https；若不支持???http
$config['transport']        = "http";
 
?>