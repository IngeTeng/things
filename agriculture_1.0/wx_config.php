<?php 
 //require('config.inc.php');

 function getOpenid(){
	session_start();
    //$appid = 'wxc8f5291782d61fa0';
    //$secret = '6b6a3b440f278255728643e75fc9720b';
	$appid = 'wxf1b0a589ad02add5';
	$secret = '0b68b5d5c9788627e39b8d56270c95bd';
	$code = $_GET["code"];
	$get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
	//var_dump($get_token_url);
    $ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$get_token_url);
	curl_setopt($ch,CURLOPT_HEADER,0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	$res = curl_exec($ch);
	curl_close($ch);
	$json_obj = json_decode($res,true);
	$access_token = $json_obj['access_token']; 
	$openid = $json_obj['openid'];
    //var_dump($access_token);
	$_SESSION['openid'] = $openid;
    return $openid;
}


    function getWxAccessToken(){
        //请求地址
        $appid = 'wxf1b0a589ad02add5';
        $appsecret = '0b68b5d5c9788627e39b8d56270c95bd';
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
        //初始化
        $ch = curl_init();
        //设置参数
        curl_setopt($ch , CURLOPT_URL , $url);
        curl_setopt($ch , CURLOPT_RETURNTRANSFER ,1);
        //调用接口
        $res = curl_exec($ch);
        //关闭curl
        curl_close($ch);
        $arr = json_decode($res , true);
        return $arr['access_token'];
    }

    function http_curl($url){
        //获取imooc
        //1.初始化curl
        $ch = curl_init();
        //$url = 'http://www.baidu.com';
        //2.设置curl的参数
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //3.采集
        $output = curl_exec($ch);
        //4.关闭
        curl_close($ch);
        return $output;
    }

    function getJsApiTicket(){
        //如果session中保存有效的jsapi_ticket
        if($_SESSION['jsapi_ticket_expire_time']>time() && $_SESSION['jsapi_ticket']){
            $jsapi_ticket = $_SESSION['jsapi_ticket'];
        }else{
            $access_token = getWxAccessToken();
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$access_token."&type=jsapi";
            $res = http_curl($url);
            $res=json_decode($res,true);
            $jsapi_ticket = $res['ticket'];
            $_SESSION['jsapi_ticket'] = $jsapi_ticket;
            $_SESSION['jsapi_ticket_expire_time'] = time()+7000;
        }   
        return $jsapi_ticket;
    }
    //获取16位随机码
    function getRandCode($num=16){
        $array = array(
            'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
            'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
            '0','1','2','3','4','5','6','7','8','9'
        );
        $tmpstr = '';
        $max = count($array);
        for($i =1 ; $i<=$num; $i++){
            $tmpstr .=rand(1,$max-1);
            $tmpstr .=$array[$key];
        }
        return $tmpstr;

    }
    function curPageURL() 
    {
        $pageURL = 'http';

        if ($_SERVER["HTTPS"] == "on") 
        {
            $pageURL .= "s";
        }
        $pageURL .= "://";

        if ($_SERVER["SERVER_PORT"] != "80") 
        {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } 
        else 
        {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }
    //获取数字签名
    function getSignature($jsapiTicket,$nonceStr,$timestamp,$url){

        $string = "jsapi_ticket=".$jsapiTicket."&noncestr=".$nonceStr."&timestamp=".$timestamp."&url=".$url;
        $signature = sha1 ( $string );

        return $signature;
    }

    //获取用户信息
    /*function getUserInfo(){
       $code = $_GET["code"];
        $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$get_token_url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        $json_obj = json_decode($res,true);
        $access_token = $json_obj['access_token']; 
        $openid = $json_obj['openid'];
        //var_dump($access_token);
        $info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
        $info = json_decode(file_get_contents($info_url),true);
        var_dump($info);
        $data['name'] = $info->nickname;
        $data['image'] = $info->headimgurl;
        return $data;
    }*/
    function getUserInfo(){
        //$appid = 'wxc8f5291782d61fa0';
        //$secret = '6b6a3b440f278255728643e75fc9720b';
		$appid = 'wxf1b0a589ad02add5';
		$secret = '0b68b5d5c9788627e39b8d56270c95bd';
        $code = $_GET["code"];
        $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
        //var_dump($get_token_url);
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$get_token_url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        //var_dump($res);
        curl_close($ch);
        $json_obj = json_decode($res,true);
        $access_token = $json_obj['access_token']; 
        $openid = $json_obj['openid'];
        //var_dump($access_token);
        $info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
        //var_dump($info_url);
        //var_dump(file_get_contents($info_url));
        //$info = json_decode(file_get_contents($info_url),true);
        $res = http_curl($info_url);
        $info = json_decode($res , true);
        //var_dump($info);

        return $info;
    }
    //方培工作室测试
    function http_request($url , $data =null){

        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL ,$url);
        curl_setopt($curl , CURLOPT_SSL_VERIFYPEER ,FALSE);
        curl_setopt($curl , CURLOPT_SSL_VERIFYHOST , FALSE);
        if(!empty($data)){

            curl_setopt($curl , CURLOPT_POST ,1);
            curl_setopt($curl , CURLOPT_POSTFIELDS ,$data);
        }
        curl_setopt($curl , CURLOPT_RETURNTRANSFER ,1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }


    /**
     * 发送post请求
     * @param string $url
     * @param string $param
     * @return bool|mixed
     */
    function request_post($url = '', $param = '')
    {
        if (empty($url) || empty($param)) {
            return false;
        }
        $postUrl = $url;
        $curlPost = $param;
        $ch = curl_init(); //初始化curl
        curl_setopt($ch, CURLOPT_URL, $postUrl); //抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0); //设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1); //post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch); //运行curl
        curl_close($ch);
        return $data;
    }

     /**
     * 发送get请求
     * @param string $url
     * @return bool|mixed
     */
    function request_get($url = '')
    {
        if (empty($url)) {
            return false;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }



    function http_curl_new( $url,$type='get',$res='json',$arr=''){

        //1.初始化curl
        $ch = curl_init();
        //$url = 'http://www.baidu.com';
        //2.设置curl的参数
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if($type == 'post'){
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$arr);
        }
        //3.采集
        $output = curl_exec($ch);
        //4.关闭
        curl_close($ch);
        if($res=='json'){
            if( curl_errno($ch) ){
            //请求失败，返回错误信息
                return curl_error($ch) ;
            }else{
            //请求成功
                return json_decode($output,true);
            }

        }

}
    //推送消息模板
   function sendTemplateMsg($data){
        $access_token =getWxAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
       $res = http_request($url , $data);
        return json_decode($res , true);
    }

    //消息模板中的数据格式
    /*$array = array(
            'touser' => "ouj6BwBEERSkfhpp1pddwWjiNMwQ",
            'template_id' => "ONvBVQds95meNOXdlXbhqvaY2PNUrRNcV1pLD4d4cKo",
            'url' => "location.html",
            'data' => array(
                     'first' => array( 'value' =>urlencode( "恭喜您预约成功！" ), 
                                'color'=>"#173177"
                                ),
                    'examuser' => array( 'value' =>urlencode( '张三') , 
                                'color'=>"#173177"
                                ),
                    'regdate' => array('value' =>urlencode( date('Y-m-d H:i:s' , $time) ),
                                'color'=>"#173177"
                                ),
                    'address' => array( 'value' =>urlencode('1111'),
                                 'color'=>"#173177"
                                 ),
                    'hosptel' => array( 'value' =>urlencode('11111'), 
                                'color'=>"#173177"
                                ),

                    'remark' => array( 'value' => urlencode('点击该链接查看医院位置' ),
                                 'color'=>"#173177"),

                ),
        );*/





?>