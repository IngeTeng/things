<?php
/**
 * @Author: anchen
 * @Date:   2017-03-16 20:58:03
 * @Last Modified by:   anchen
 * @Last Modified time: 2017-03-20 11:51:35
 */
require('../../conn.php');
require($LIB_PATH.'cart.class.php');
require($LIB_TABLE_PATH.'table_cart.class.php');
require($LIB_PATH.'product.class.php');
require($LIB_TABLE_PATH.'table_product.class.php');

$act = $_GET['act'];

switch($act){
   case 'edit'://编辑

        $id                  = safeCheck($_POST['id']);
        $productnum          = safeCheck($_POST['productnum']);

        //构造需要传递的数组参数
        $cartAttr = array(


            'productnum'         => $productnum
            
 

        );

        try {
            $rs = Cart::edit($id, $cartAttr);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;

    case 'del'://删除
        $id = safeCheck($_POST['id']);

        try {
            $rs = Cart::del($id);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;

    case 'select'://编辑

        $id                  = safeCheck($_POST['id']);
        $ischecked           = safeCheck($_POST['ischecked']);

        $cartAttr = array(
            'ischecked'     => $ischecked

        );
        $rs = table_cart::edit_ischecked($id,$cartAttr);
        $cart = Cart::getInfoById($id);
        //var_dump($cart);
        $product = Product::getInfoById($cart['productid']);

            $res[0]= $cart['productnum'];
            $res[1] = $product['price'];
            $res[2] = $product['sale_price'];
            $res[3] = $product['issale'];
            echo action_msg_res($msg, 1,$res);
        //构造需要传递的数组参数
        
       /* $cartAttr = array(


            'productnum'         => $productnum
            
 

        );

        try {
            $rs = Cart::edit($id, $cartAttr);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }*/

        break;

        case 'select_topay'://付款前的查询
        $openid = safeCheck($_POST['openid'],0);
        $ischecked = safeCheck($_POST['ischecked']);
      
            $rs = table_cart::getInfoByOpenId_ischecked( $openid , $ischecked);
            //var_dump($rs);
            if(!empty($rs)){
                $res = 1;
                $msg = "成功";
                echo action_msg_res($msg, 1,$res);
            }else{
                $res = 0;
                $msg = "请选择要付款的商品";
                echo action_msg_res($msg, 0,$res);
            }
        

        break;

    
}