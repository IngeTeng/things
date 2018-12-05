<?php
/**
 * 订单详情页  order_detail_do.php
 *
 * @version       v0.01
 * @create time   2016/11/14
 * @update time
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

require_once('admin_init.php');
require_once('admincheck.php');
require('../config.inc.php');
require('../wx_config.php');


/*$POWERID = '7001';//权限
Admin::checkAuth($POWERID, $ADMINAUTH);*/


$act = safeCheck($_GET['act'], 0);

switch($act){
    case 'add'://添加
        $payid                  = safeCheck($_POST['payid']);
        $num                    = safeCheck($_POST['num']);
        $productid              = safeCheck($_POST['productid'],0);
        $product_img            = safeCheck($_POST['product_img'],0);
        $product_title          = safeCheck($_POST['product_title'],0);
        $product_price          = safeCheck($_POST['product_price']);
        $product_sale_price     = safeCheck($_POST['product_sale_price'],0);
        $product_post_price     = safeCheck($_POST['product_post_price'],0);
        $product_add_phone      = safeCheck($_POST['product_add_phone']);
        //构造需要传递的数组参数
        $order_detailAttr = array(

            'payid'                 => $payid,
            'num'                   => $num,
            'productid'             => $productid,
            'product_img'           => $product_img,
            'product_title'         => $product_title,
            'product_price'         => $product_price,
            'product_sale_price'    => $product_sale_price,
            'product_post_price'    => $product_post_price,
            'product_add_phone'     => $product_add_phone

        );

        try {
            $rs = Order_detail::add($order_detailAttr);
            echo $rs;
        }catch (MyException $e){

            echo $e->jsonMsg();
        }

        break;

    case 'edit'://编辑

        $id              = safeCheck($_POST['id']);
        $payid           = safeCheck($_POST['payid']);
        $num             = safeCheck($_POST['num']);
        $productid       = safeCheck($_POST['productid']);
        $product_img            = safeCheck($_POST['product_img'],0);
        $product_title          = safeCheck($_POST['product_title'],0);
        $product_price          = safeCheck($_POST['product_price']);
        $product_sale_price     = safeCheck($_POST['product_sale_price'],0);
        $product_post_price     = safeCheck($_POST['product_post_price'],0);

        //构造需要传递的数组参数
        $order_detailAttr = array(


            'payid'                 => $payid,
            'num'                   => $num,
            'productid'             => $productid,
            'product_img'           => $product_img,
            'product_title'         => $product_title,
            'product_price'         => $product_price,
            'product_sale_price'    => $product_sale_price,
            'product_post_price'    => $product_post_price
 

        );

        try {
            $rs = Order_detail::edit($id, $order_detailAttr);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;


    case 'del'://删除
        $id = safeCheck($_POST['id']);

        try {
            $rs = Order_detail::del($id);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;

    case 'post'://发货
         $id = safeCheck($_POST['id']);
        $order_detail = order_detail::getInfoById($id);
        $user = User::getInfoByOpenid($order_detail['openid']);
        try {
            if($order_detail['state']==2){

                  //发送消息模板
        $time= time();
            if($user['0']['state3']==2){
            $array = array(
                'touser' =>  $order_detail['openid'],
                'template_id' => "TSmi-fx5j-tpk5mEW8E71MUaa4e7qnVKk58xrYn8aD8",
                'url' => 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/order_list.php").'?choice=3&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect',
                'data' => array(
                     'first' => array( 'value' =>urlencode( '尊敬的'.$user['0']['nikname'].',你已成功取消订单' ), 
                                'color'=>"#173177"
                                ),
                    'keyword1' => array( 'value' =>urlencode($order_detail['payid']) , 
                                'color'=>"#173177"
                                ),
                    'keyword2' => array( 'value' =>urlencode($order_detail['product_title']) , 
                                'color'=>"#173177"
                                ),
                    'keyword3' => array( 'value' =>urlencode($order_detail['num'].'件') , 
                                'color'=>"#173177"
                                ),
                    'keyword4' => array( 'value' =>urlencode($order_detail['total']) , 
                                'color'=>"#173177"
                                ),
                    'keyword5' => array('value' =>urlencode( date('Y-m-d H:i:s' , $time) ),
                                'color'=>"#173177"
                                ),
                    'remark' => array( 'value' => urlencode('您的订单已发货，请注意查收！' ),
                                 'color'=>"#173177"),

                ),
        );
                $res = sendTemplateMsg(urldecode(json_encode($array)));

        }
        
            $rs = Order_detail::post($id);
        }else{

            $rs = action_msg('检查状态，不能成为发货状态', 1);
        }
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;

}
?>