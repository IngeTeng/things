<?php

header("content-type:text/html;charset=utf-8");
//https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx9ef13086bd8c0623&secret=80e11ae5716e560f81c91f9f6c63fe35
//$token="GtEee_vTEVbyd0a5M9G8YkzjWBKA4gB2TCNBzxHYIBM-BKDAJC5D4aYzlY-1vblw5dUHtCYkrgwIbavMhFzm_rL4MGISRcSaWTROYXhpptRtjN1HZVha6xq3pUcR21cBxM698rlkxwdsS2w5KmFSTQ";
require('config.inc.php');
//$appid = 'wxc8f5291782d61fa0';
//$secret = '6b6a3b440f278255728643e75fc9720b';
//$appid = 'wxb885b306ffeed602';
//$secret = '869823e0132e4af3cb7c7fb0110a8d09';

/*$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
//var_dump($url);
$ch = curl_init();//初始化curl
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
$access_token = curl_exec($ch);//运行curl
var_dump($access_token);
curl_close($ch);
$array = get_object_vars(json_decode($access_token));
$token = $array['access_token'];*/


        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
        $ch = curl_init();
        //设置参数
        
        curl_setopt($ch , CURLOPT_URL , $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch , CURLOPT_RETURNTRANSFER ,1);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER,0);
        //调用接口
        $res = curl_exec($ch);
        //关闭curl
        var_dump($res);
        curl_close($ch);
        $arr = json_decode($res , true);
        $token = $arr['access_token'];

$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$token;

//var_dump($url);

$curlPost = '{"button":[
         {
               "type":"view",
               "name":"农贸商城",
               "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/home.php").'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"
          },
          {
               "type":"view",
               "name":"成为店家",
              "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/partner.php").'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"
           },
           {              
               "name":"个人中心",
               "sub_button":[
                {
                   "type":"view",
                   "name":"我的订单",
                   "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/order_list.php").'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"
                },
                {
                   "type":"view",
                   "name":"个人中心",
                   "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/self.php").'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"
                },
                {
                   "type":"view",
                   "name":"在线客服",
                   "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/service.php").'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"
                }]
           }]
       }';

     

$ch = curl_init();//初始化curl
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
//var_dump($curlPost);
curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
$data = curl_exec($ch);//运行curl
curl_close($ch);
var_dump($data);
echo($data);
?>