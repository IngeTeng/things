<?php
/**
 * @Author: anchen
 * @Date:   2017-03-20 15:50:41
 * @Last Modified by:   anchen
 * @Last Modified time: 2017-04-04 22:45:23
 */
require('../../conn.php');
require('../../config.inc.php');
require('../../wx_config.php');
$act = safeCheck($_GET['act'], 0);

switch($act){
    case 'add'://添加
        $pay_id           = safeCheck($_POST['pay_id'],0);
        $nikname          = safeCheck($_POST['nikname'],0);
        $openid           = safeCheck($_POST['openid'],0);
        $addressid        = safeCheck($_POST['addressid']);
        $address_name     = safeCheck($_POST['address_name'],0);
        $address_phone    = safeCheck($_POST['address_phone']);
        $address_area     = safeCheck($_POST['address_area'],0);
        $address          = safeCheck($_POST['address'],0);
        $total            = safeCheck($_POST['total']);
        $state            = safeCheck($_POST['state']);
        $product_details   = $_POST['product_detail'];
        //构造需要传递的数组参数
        $orderAttr = array(

            'pay_id'             => $pay_id,
            'nikname'            => $nikname,
            'openid'             => $openid,
            'addressid'          => $addressid,
            'address_name'       => $address_name,
            'address_phone'      => $address_phone,
            'address_area'       => $address_area,
            'address'            => $address,
            'state'              => $state
        );

        foreach ($product_details as $product_detail) {


            # code...
            # 
            $product = Product::getInfoById($product_detail['id']);
           
            $order_detailAttr = array(
            'openid'             => $openid,
            'payid'              => $pay_id,
            'num'                => $product_detail['num'],
            'productid'          => $product_detail['id'],
            'product_img'        => $product['pic'],
            'product_title'      => $product['title'],
            'product_price'      => $product['price'],
            'product_add_phone'  => $product['add_phone'],
            'product_sale_price' => $product['sale_price'],
            'product_post_price' => $product['post_price'],
            'total'              => $product_detail['total'],
            'state'              => $state  

            );
            $res = Order_detail::add($order_detailAttr);
            //var_dump($res);
        }
        

        try {
            $rs = Order::add($orderAttr);
            echo $rs;
        }catch (MyException $e){

            echo $e->jsonMsg();
        }

        break;

    case 'edit'://编辑

        $id               = safeCheck($_POST['id']);
        $state            = safeCheck($_POST['state']);

        //构造需要传递的数组参数
        $orderAttr = array(


            
            'state'              => $state
 

        );

        try {
            $rs = order_detail::edit($id, $orderAttr);
            $order_detail = Order_detail::getInfoById($id);
            //var_dump($order_detail);
            //exit;
            $rss = order::edit($order_detail['id'] , $orderAttr);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;

        case 'del'://删除        先删除小订单 删除后查询payid是否还有其他小订单，如果有则什么都不做，如果没有就删除大订单
        $id = safeCheck($_POST['id']);
        $openid = safeCheck($_POST['openid'],0);
        $user = User::getInfoByOpenid($openid);
        $time =time();
        try {
            $order_detail_Info = table_order_detail::getInfoById($id);
            $rs = Order_detail::del($id);
            $order_detail_other = table_order_detail::getInfoByPayid($order_detail_Info['payid']);
            if(empty($order_detail_other)){
            
                $rss = Order::del($order_detail_Info['payid']);
            }
            //总金额
            $product = Product::getInfoById($order_detail_Info['productid']);
            if($product['issale']){
                $price = $product['sale_price'];
            }else{
                $price = $product['price'];
            }
            $total = $price*$order_detail_Info['num'];
            $totalprice = number_format($total , 2);
            //提交取消订单的消息模板
            if($user['0']['state2']==2){
            $array = array(
                'touser' =>  $openid,
                'template_id' => "pj34JOwhX9jIXhRX5yI2udeAsgkbvG117nwRAzAoAYw",
                'url' => 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/order_list.php").'?choice=1&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect',
                'data' => array(
                     'first' => array( 'value' =>urlencode( '尊敬的'.$user['0']['nikname'].',你已成功取消订单' ), 
                                'color'=>"#173177"
                                ),
                    'keyword1' => array( 'value' =>urlencode($order_detail_Info['payid']) , 
                                'color'=>"#173177"
                                ),

                    'keyword2' => array('value' =>urlencode( date('Y-m-d H:i:s' , $time) ),
                                'color'=>"#173177"
                                ),
                    'keyword3' => array('value' =>urlencode( $totalprice ),
                                'color'=>"#173177"
                                ),
                    'keyword4' => array('value' =>urlencode( '暂不需要该商品' ),
                                'color'=>"#173177"
                                ),
                    'remark' => array( 'value' => urlencode('您的订单已取消成功，可点击查看详情' ),
                                 'color'=>"#173177"),

                ),
        );
                $res = sendTemplateMsg(urldecode(json_encode($array)));

        }



            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;


        case 'sure'://确定收货
        $id = safeCheck($_POST['id']);
        $openid = safeCheck($_POST['openid'],0);
        $order_detail = order_detail::getInfoById($id);
        $user = User::getInfoByOpenid($order_detail['openid']);
        try {
            if($order_detail['state']==3){
            

            //确认收货
            $time = time();
             if($user['0']['state4']==2){
            $array = array(
                'touser' =>  $openid,
                'template_id' => "SnWDGFl8Gj5CfTpU9oyKmpSgkY6cOBgz3e1GJ47xatw",
                'url' => 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/order_list.php").'?choice=4&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect',
                'data' => array(
                     'first' => array( 'value' =>urlencode( '尊敬的'.$user['0']['nikname'].',您的订单'.$order_detail['product_title'].'已确认收货' ), 
                                'color'=>"#173177"
                                ),
                    'keyword1' => array( 'value' =>urlencode($order_detail['payid']) , 
                                'color'=>"#173177"
                                ),
                    'keyword2' => array( 'value' =>urlencode($order_detail['total']) , 
                                'color'=>"#173177"
                                ),

                    'keyword3' => array('value' =>urlencode( date('Y-m-d H:i:s' , $time) ),
                                'color'=>"#173177"
                                ),
                    'remark' => array( 'value' => urlencode('感谢您在此购物成功，同时希望您的再次光临！' ),
                                 'color'=>"#173177"),

                ),
        );
                $res = sendTemplateMsg(urldecode(json_encode($array)));

        }
            $rs = Order_detail::sure($id);
        }else{

            $rs = action_msg('检查状态，不能成为交易完成状态', 1);
        }
            
            
            //$rs = Order::del($id);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;





}