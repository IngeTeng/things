<?php
/**
 * 通用通知接口demo
 * ====================================================
 * 支付完成后，微信会把相关支付和用户信息发送到商户设定的通知URL，
 * 商户接收回调信息后，根据需要设定相应的处理流程。
 * 
 * 这里举例使用log文件形式记录回调信息。
*/
	require('../agriculture_1.0/conn.php');
	include_once("./log_.php");
	include_once("./WxPayPubHelper/WxPayPubHelper.php");
	require($LIB_PATH.'order.class.php');
	require($LIB_TABLE_PATH.'table_order.class.php');


    //使用通用通知接口
	$notify = new Notify_pub();

	//存储微信的回调
	$xml = $GLOBALS['HTTP_RAW_POST_DATA'];	
	$notify->saveData($xml);
	
	//验证签名，并回应微信。
	//对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
	//微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
	//尽可能提高通知的成功率，但微信不保证通知最终能成功。
	if($notify->checkSign() == FALSE){
	//if(1){
		//$res = $notify->getData();
		//$notify->setReturnParameter("return_sign",$res['sign']);
		//$notify->setReturnParameter("sign",$notify->checkSign());
		$notify->setReturnParameter("return_code","FAIL");//返回状态码
		$notify->setReturnParameter("return_msg","签名失败");//返回信息
	}else{
		//$notify->setReturnParameter("flag",$flag);
		$notify->setReturnParameter("return_code","SUCCESS");//设置返回码
	}
	$returnXml = $notify->returnXml();
	echo $returnXml;
	//echo 'SUCCESS';
	//echo '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
	
	//==商户根据实际情况设置相应的处理流程，此处仅作举例=======
	
	//以log文件形式记录回调信息
	$log_ = new Log_();
	$log_name="./notify_url.log";//log文件路径
	$res = $notify->getData();
	$log_->log_result($log_name,"【接收到的notify通知】:\n".$xml."\n");
	$log_->log_result($log_name,"【接收到的notify通知】:\n".$returnXml."\n");

	if($notify->checkSign() == TRUE)
	{
		if ($notify->data["return_code"] == "FAIL") {
			//此处应该更新一下订单状态，商户自行增删操作
			$log_->log_result($log_name,"【通信出错】:\n".$xml."\n");
			$state = 2;
		}
		elseif($notify->data["result_code"] == "FAIL"){
			//此处应该更新一下订单状态，商户自行增删操作
			$log_->log_result($log_name,"【业务出错】:\n".$xml."\n");
			$state = 2;
		}
		else{
			//此处应该更新一下订单状态，商户自行增删操作
			$log_->log_result($log_name,"【支付成功】:\n".$xml."\n");
			$state = 1;
			//$log_->log_result($log_name,"【支付已经成功】:\n".$params."\n");
		}
		
		//商户自行增加处理流程,
		//例如：更新订单状态
		//例如：数据库操作
		//例如：推送支付完成信息
		
		$rs = $notify->xmlToArray($xml);
		//$user_weixin_openid      = $rs['openid'];
		//$money                   = $rs['total_fee'];
		//$service                 = "service";//这部分的插入需要在js_pay界面下插入，即这张表的字段分两部分插入
		//$couponid                = 1;
		//$pay_id                    = $rs['product_id'];


//$shoplistAttr = array(
//
//'paynumber'               => 498876,
//'payway'                  => "qwqwee",
//'user_weixin_openid'      => "om86q",
//'money'                   => 12987,
//'service'                 => "service",
//'couponid'                => 12,
//'state'                   => 1
//);

		//构造需要传递的数组参数
		$time=time();
        $orderAttr = array(

        'state'                     => 2


    );

    //$r = Order::edit($pay_id,$orderAttr);
    //var_dump($r);

        
	}

?>