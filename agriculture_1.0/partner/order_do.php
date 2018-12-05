<?php
/**
 * 订单处理  order_do.php
 *
 * @version       v0.01
 * @create time   2016/11/14
 * @update time
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

require_once('admin_init.php');
require_once('admincheck.php');


/*$POWERID = '7001';//权限
Admin::checkAuth($POWERID, $ADMINAUTH);*/


$act = safeCheck($_GET['act'], 0);

switch($act){
    case 'add'://添加
        $pay_id           = safeCheck($_POST['pay_id']);
        $nikname          = safeCheck($_POST['nikname'],0);
        $openid           = safeCheck($_POST['openid'],0);
        $addressid        = safeCheck($_POST['addressid'],0);
        $address_name     = safeCheck($_POST['address_name'],0);
        $address_phone    = safeCheck($_POST['address_phone']);
        $address_area     = safeCheck($_POST['address_area'],0);
        $address          = safeCheck($_POST['address'],0);
       // $state            = safeCheck($_POST['state']);
        //构造需要传递的数组参数
        $orderAttr = array(

            'pay_id'             => $pay_id,
            'nikname'            => $nikname,
            'openid'             => $openid,
            'addressid'          => $addressid,
            'address_name'       => $address_name,
            'address_phone'      => $address_phone,
            'address_area'       => $address_area,
            'address'            => $address
            //'state'              => $state
        );

        try {
            $rs = Order::add($orderAttr);
            echo $rs;
        }catch (MyException $e){

            echo $e->jsonMsg();
        }

        break;

    case 'edit'://编辑

        $id               = safeCheck($_POST['id']);
        $pay_id           = safeCheck($_POST['pay_id']);
        $nikname          = safeCheck($_POST['nikname'],0);
        $openid           = safeCheck($_POST['openid']);
        $addressid        = safeCheck($_POST['addressid'],0);
        $address_name     = safeCheck($_POST['address_name'],0);
        $address_phone    = safeCheck($_POST['address_phone']);
        $address_area     = safeCheck($_POST['address_area'],0);
        $address          = safeCheck($_POST['address'],0);
        //$state            = safeCheck($_POST['state']);

        //构造需要传递的数组参数
        $orderAttr = array(


            'pay_id'             => $pay_id,
            'nikname'            => $nikname,
            'openid'             => $openid,
            'addressid'          => $addressid,
            'address_name'       => $address_name,
            'address_phone'      => $address_phone,
            'address_area'       => $address_area,
            'address'            => $address
            //'state'              => $state
 

        );

        try {
            $rs = Order::edit($id, $orderAttr);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;


    case 'del'://删除
        $payid = safeCheck($_POST['id']);

        try {
            $order_details = Order_detail::getInfoByPayId($payid);
            //var_dump($order_detail);
            foreach($order_details as $order_detail){
                $rss = Order_detail::del($order_detail['id']);
                    }
            $rs = Order::del($payid);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;

    case 'post'://发货
        $id = safeCheck($_POST['id']);
        $order = order::getInfoById($id);
        
        try {
            if($order['state']==3){
        
            $rs = Order::post($id);
        }else{

            $rs = action_msg('检查状态，不能成为发货状态', 1);
        }
            
            
            //$rs = Order::del($id);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;
}
?>