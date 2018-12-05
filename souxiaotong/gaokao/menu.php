<?php

header("content-type:text/html;charset=utf-8");

require('config.inc.php');


        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
        var_dump($url);
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
        //var_dump($res);
        curl_close($ch);
        $arr = json_decode($res , true);
        $token = $arr['access_token'];

$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$token;

//var_dump($url);

$curlPost = '{"button":[
         {
               "type":"view",
               "name":"点击查询",
               "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/souxiaotong/gaokao/web/sxt/sxt.php").'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"
          }]
       }';

      /* $curlPost = '{"button":[
         {
               "type":"view",
               "name":"农贸商城",
               "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://119.23.132.228/gaokao/web/sxt/sxt.html").'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"
          },
          {
               "type":"view",
               "name":"成为店家",
              "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://119.23.132.228/gaokao/web/sxt/sxt.html").'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"
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
       }';*/

     

$ch = curl_init();//初始化curl
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
//var_dump($curlPost);
curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
$data = curl_exec($ch);//运行curl
curl_close($ch);
//var_dump($data);
echo($data);
?>