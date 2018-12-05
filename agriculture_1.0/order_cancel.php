<?php 
    require('conn.php');
    require('config.inc.php');
    require('wx_config.php');
    require($LIB_PATH.'order.class.php');
    require($LIB_TABLE_PATH.'table_order.class.php');
    require($LIB_PATH.'order_detail.class.php');
    require($LIB_TABLE_PATH.'table_order_detail.class.php');
    require($LIB_PATH.'user.class.php');
    require($LIB_TABLE_PATH.'table_user.class.php');

    if(!empty($_POST['pay_id'])){
        $pay_id = safeCheck($_POST['pay_id'],0);
    }else{
        $pay_id = '';
    }
    if(!empty($_POST['total'])){
        $total = safeCheck($_POST['total']);
    }else{
        $total = '';
    }
    if(!empty($_POST['openid'])){
        $openid = safeCheck($_POST['openid'],0);
    }else{
        $openid = '';
    }

    if(!empty($_POST['status'])){
        $status = safeCheck($_POST['status'],0);
    }else{
        $status = '';
    }

    $time=time();



    $order_details = Order_detail::getInfoByPayId($pay_id);
            //var_dump($order_detail);
        
    //发送消息模板
    $user = User::getInfoByOpenid($openid);
    if($user['0']['state1']==2){
    $product = table_order_detail::getInfoByPayId($pay_id);
    $totalprice = number_format($total , 2);
    $time =time();
    if($status==2){
    $array = array(
                'touser' =>  $openid,
                'template_id' => "d0bTApyCoE7UTwXqG8mjcKDofuTg0P7o9RWKf1QA1iE",
                'url' => 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/order_list.php").'?choice=2&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect',
                'data' => array(
                     'first' => array( 'value' =>urlencode( '尊敬的'.$user['0']['nikname'].',恭喜您已购买成功！' ), 
                                'color'=>"#173177"
                                ),
                    'keyword1' => array( 'value' =>urlencode($product['0']['product_title'].'...') , 
                                'color'=>"#173177"
                                ),
                    'keyword2' => array( 'value' =>urlencode($totalprice) , 
                                'color'=>"#173177"
                                ),
                    'keyword3' => array('value' =>urlencode( date('Y-m-d H:i:s' , $time) ),
                                'color'=>"#173177"
                                ),
                    'keyword4' => array('value' =>urlencode( $pay_id ),
                                'color'=>"#173177"
                                ),
                    'remark' => array( 'value' => urlencode('您的订单我们已经收到，我们会尽快为您配送' ),
                                 'color'=>"#173177"),

                ),
        );
    }else{
        $array = array(
                'touser' =>  $openid,
                'template_id' => "d0bTApyCoE7UTwXqG8mjcKDofuTg0P7o9RWKf1QA1iE",
                'url' => 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/order_list.php").'?choice=1&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect',
                'data' => array(
                     'first' => array( 'value' =>urlencode( '尊敬的'.$user['0']['nikname'].',订单提交成功，请您在24小时之内付款' ), 
                                'color'=>"#173177"
                                ),
                    'keyword1' => array( 'value' =>urlencode($product['0']['product_title'].'...') , 
                                'color'=>"#173177"
                                ),
                    'keyword2' => array( 'value' =>urlencode($totalprice) , 
                                'color'=>"#173177"
                                ),
                    'keyword3' => array('value' =>urlencode( date('Y-m-d H:i:s' , $time) ),
                                'color'=>"#173177"
                                ),
                    'keyword4' => array('value' =>urlencode( $pay_id ),
                                'color'=>"#173177"
                                ),
                    'remark' => array( 'value' => urlencode('您的订单我们已经收到，当您付款后，我们会尽快为您配送' ),
                                 'color'=>"#173177"),

                ),
        );
    }
                
               $res = sendTemplateMsg(urldecode(json_encode($array)));

}



    echo $r;

   /* $order_detailAttr = array(

        'state'                    => 2

        );
    $rs = Order_detail::edit($order_detailAttr);*/


?>