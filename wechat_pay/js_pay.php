<?php

require('../agriculture_1.0/conn.php');
include_once("./WxPay/WxPayPubHelper.php");
include_once("./WxPay/medoo.php");
require($LIB_PATH.'order.class.php');
require($LIB_TABLE_PATH.'table_order.class.php');
require($LIB_PATH.'order_detail.class.php');
require($LIB_TABLE_PATH.'table_order_detail.class.php');



if(!empty($_GET['pay_id'])){
	$pay_id = strCheck($_GET['pay_id'],0);
}else{
	$pay_id = '';
}

if(!empty($_GET['total'])){
	$total = strCheck($_GET['total'],0);
}else{
	$total = '';
}

//使用jsapi接口
$jsApi = new JsApi_pub();

if (!isset($_GET['code']))
{
//	$id = $_GET["id"];
//	if ($id == "")
//	{
//		return;
//	}
//	$name = $_GET["name"];
//	$num = $_GET["num"];
//	$t = $_GET["t"];
//	$t2=md5(md5("$id").base64_encode("$name").md5("$num"));
//	if ($t2 != $t)
//	{
//		return;
//	}
//	setcookie("wx_order_num", $id, time()+3600);
//	setcookie("wx_price_num", $num, time()+3600);
//	setcookie("wx_pay_name", $name, time()+3600);
	
	$url = $jsApi->createOauthUrlForCode(WxPayConf_pub::JS_API_CALL_URL);
	$state = json_encode(array(  
               "pay_id" => "$pay_id",
               "total" => "$total"
              
        ));  
	//利用STATE传参数
	$url = str_replace("STATE", $state, $url);  
	//var_dump($url);exit();
	Header("Location: $url"); 
	return;
}

//获取code码，以获取openid

$code = $_GET['code'];

// echo $code;

$jsApi->setCode($code);
$openid = $jsApi->getOpenId();
if(empty($openid)){
	$openid = $_SESSION['openid'];
}
$_SESSION['openid'] = $openid;

$state    = $_GET['state'];  
$state    = str_replace("\\", "", $state);  
$param    = json_decode($state, true);  
//$flag     = $param['flag'];  
//$id       = $param['id'];
//$couponid = $param['couponid'];
$pay_id = $param['pay_id'];
$total = $param['total'];


//获得service字段和要支付的价格，这里的flag是用来判断去哪个表去查询相关信息，在wpay_page界面第一次出现
/*if($flag == 1){
$row = table_combo_cate::getInfoById($id);
$service = $row['name'];
$money = $row['money'];
}else{
    if($flag == 2){
        $row = table_care::getInfoById($id);
        $service = $row['name'];
		$money  = $row['salary'];
    }else{
		if($flag == 3){
			$row = table_test::getInfoById($id);
			$service = $row['name'];
			$money  = $row['price'];
		}else{
			$row = table_insurance::getInfoById($id);
			$service = $row['name'];
			$money  = $row['price'];
		}
    }

}
//计算使用优惠券之后的价格
if($couponid){
	$couponinfo = Coupon::getInfoById($couponid);
	$fullcut = $couponinfo['fullcut'];
	$account = $couponinfo['account'];
	if($money > $fullcut){
		if($account >= 1){
			$money = $money-$account;
		}else{
			$money = $money*$account;
		}
	}else{
		$couponid = 0;
	}
}
*/



$unifiedOrder = new UnifiedOrder_pub();
	
	//设置统一支付接口参数
	//设置必填参数
	//appid已填,商户无需重复填写
	//mch_id已填,商户无需重复填写
	//noncestr已填,商户无需重复填写
	//spbill_create_ip已填,商户无需重复填写
	//sign已填,商户无需重复填写
	$unifiedOrder->setParameter("openid","$openid");//商品描述
	$unifiedOrder->setParameter("body",'嵩县延鑫三农服务平台');//商品描述
	//自定义订单号，此处仅作举例
	$timeStamp = time();
	//$fee = intval($res['ordfee']*100);
	$money = intval($total*100);
	$unifiedOrder->setParameter("out_trade_no",WxPayConf_pub::MCHID.date("YmdHis"));//商户订单号 
	$unifiedOrder->setParameter("total_fee",$money);//总金额
	$unifiedOrder->setParameter("notify_url",WxPayConf_pub::NOTIFY_URL);//通知地址 
	$unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
	//非必填参数，商户可根据实际情况选填
	//$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号  
	//$unifiedOrder->setParameter("device_info","XXXX");//设备号 
	//$unifiedOrder->setParameter("attach","XXXX");//附加数据 
	//$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
	//$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间 
	//$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记 
	//$unifiedOrder->setParameter("openid","XXXX");//用户标识
	$unifiedOrder->setParameter("product_id","$pay_id");//订单ID

	$prepay_id = $unifiedOrder->getPrepayId();
	//=========步骤3：使用jsapi调起支付============
	$jsApi->setPrepayId($prepay_id);

	$jsApiParameters = $jsApi->getParameters();


	//echo ($jsApiParameters);exit();

?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no,minimal-ui"/>
	<meta name="format-detection" content="telephone=no" searchtype="map"/>
	<meta name="apple-mobile-web-app-capable" content="yes"/>
    <title>微信安全支付</title>
	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="js/layer/layer.js"></script>
	<script type="text/javascript">
		$(function(){
			
			function recordadd()
			{	
			
				var pay_id        = "<?php echo $pay_id;?>";
				var total         = "<?php echo $total;?>";
				var openid         = "<?php echo $openid;?>";
				$.ajax({
                    type : 'POST',
                    data : {
                        //username       : username,
                        pay_id      : pay_id,
                        total       : total,
                        openid      : openid,
                        status      : 2
         
                        },
                    dataType : 'json',
                    url      : '../agriculture_1.0/order_add.php',
                    success  : function(data){


                    		var code = data.code;
							var msg = data.msg;
							//var msg  = data.weixin_openid;
							//var msg = '插入消费记录成功';
							switch(code){
							//switch(1){
								case 1:
									 layer.msg(msg, function(index){
										location.href = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf1b0a589ad02add5&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/order_list.php");?>?choice=2&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect';
									});
									break;
								default:
									layer.alert(msg, {icon: 5});
							}
						
                    }
                });
			
				
			}

			//调用微信JS api 支付
			function jsApiCall()
			{
				WeixinJSBridge.invoke(
					'getBrandWCPayRequest',
					<?php echo $jsApiParameters; ?>,
					function(res){

						WeixinJSBridge.log(res.err_msg);
						if (res.err_msg == 'get_brand_wcpay_request:ok') {
							recordadd();
							//window.location.href="http://lvbu.ckusoft.com/wiipu_health/web/jkyl/my_right.php";
						}else{

							var pay_id        = "<?php echo $pay_id;?>";
							var total         = "<?php echo $total;?>";
							var openid         = "<?php echo $openid;?>";
							$.ajax({
			                    type : 'POST',
			                    data : {
			                        pay_id      : pay_id,
			                        total       : total,
			                        openid      : openid,
			                        status      : 1
			         
			                        },
			                    dataType : 'json',
			                    url      : '../agriculture_1.0/order_cancel.php',
			                    success  : function(data){
									
			                    }
			                });
							window.location.href='https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf1b0a589ad02add5&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/order_list.php");?>?choice=1&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect';
						};
						
					}
				);
			}

			function callpay()
			{
				if (typeof WeixinJSBridge == "undefined"){
					if( document.addEventListener ){
						document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
					}else if (document.attachEvent){
						document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
						document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
					}
				}else{
					jsApiCall();
				}
			}
			callpay();
		});
		
	</script>
</head>
<body>
	<!-- <input type="hidden" id="openid" value="<?php echo $openid;?>"/>
	<input type="hidden" id="id" value="<?php echo $id;?>"/>
	<input type="hidden" id="flag" value="<?php echo $flag;?>"/> -->
</body>
</html>