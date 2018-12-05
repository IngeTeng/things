<?php
/**
* 	配置账号信息
*/

class WxPayConf_pub
{
	//=======【基本信息设置】=====================================
	//微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
	//const APPID = 'wxc8f5291782d61fa0';
	const APPID = 'wxf1b0a589ad02add5';
	//受理商ID，身份标识
	//const MCHID = '1236047502';
	const MCHID = '1443547102';
	//商户支付密钥Key。审核通过后，在微信发送的邮件中查看
	//const KEY = 'wiipuxian2015wiipuxian2015wiipux';
	const KEY = 'yanxin325yanxin325yanxin325yanxi';
	//JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
	//const APPSECRET = '6b6a3b440f278255728643e75fc9720b';
	const APPSECRET = '0b68b5d5c9788627e39b8d56270c95bd';
	
	//=======【JSAPI路径设置】===================================
	//获取access_token过程中的跳转uri，通过跳转将code传入jsapi支付页面
	const JS_API_CALL_URL = 'http%3a%2f%2fwww.yanxin325.com%2fwechat_pay%2fjs_pay.php';
	
	//=======【证书路径设置】=====================================
	//证书路径,注意应该填写绝对路径
	const SSLCERT_PATH = 'http://www.yanxin325.com/wechat_pay/WxPay/cacert/apiclient_cert.pem';
	const SSLKEY_PATH = 'http://www.yanxin325.com/wechat_pay/WxPay/cacert/apiclient_key.pem';
	
	//=======【异步通知url设置】===================================
	//异步通知url，商户根据实际开发过程设定
	const NOTIFY_URL = 'http://www.yanxin325.com/wechat_pay/wxpay_notify_url.php';

	//=======【curl超时设置】===================================
	//本例程通过curl使用HTTP POST方法，此处可修改其超时时间，默认为30秒
	const CURL_TIMEOUT = 30;
}
	
?>