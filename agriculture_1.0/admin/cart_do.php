<?php
/**
 * 购物车处理  cart_do.php
 *
 * @version       v0.01
 * @create time   2016/11/14
 * @update time
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

require_once('admin_init.php');
require_once('admincheck.php');


$POWERID = '7001';//权限
Admin::checkAuth($POWERID, $ADMINAUTH);


$act = safeCheck($_GET['act'], 0);

switch($act){
    case 'add'://添加
        $productid           = safeCheck($_POST['productid']);
        $productnum          = safeCheck($_POST['productnum']);
        $product_pic         = safeCheck($_POST['product_pic'],0);
        $product_price       = safeCheck($_POST['product_price']);
        $product_title       = safeCheck($_POST['product_title'],0);
        $openid              = safeCheck($_POST['openid'], 0);
        $nikname             = safeCheck($_POST['nikname'], 0);
        //构造需要传递的数组参数
        $cartAttr = array(

            'productid'          => $productid,
            'productnum'         => $productnum,
            'product_pic'        => $product_pic,
            'product_price'      => $product_price,
            'product_title'      => $product_title,
            'openid'             => $openid,
            'nikname'            => $nikname
        );

        try {
            $rs = Cart::add($cartAttr);
            echo $rs;
        }catch (MyException $e){

            echo $e->jsonMsg();
        }

        break;

    case 'edit'://编辑

        $id                  = safeCheck($_POST['id']);
        $productid           = safeCheck($_POST['productid']);
        $productnum          = safeCheck($_POST['productnum']);
        $openid              = safeCheck($_POST['openid'], 0);
        $nikname             = safeCheck($_POST['nikname'], 0);

        //构造需要传递的数组参数
        $cartAttr = array(


            'productid'          => $productid,
            'productnum'         => $productnum,
            'openid'             => $openid,
            'nikname'            => $nikname
 

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


}
?>