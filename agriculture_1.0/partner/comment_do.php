<?php
/**
 * 评论处理  comment_do.php
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
        $openid           = safeCheck($_POST['openid'],0);
        $nikname          = safeCheck($_POST['nikname'],0);
        $order_detailid   = safeCheck($_POST['order_detailid']);
        $productid        = safeCheck($_POST['productid']);
        $product          = Product::getInfoById($productid);
        $product_title    = $product['title'];
        $desc             = $_POST['desc'];
        //构造需要传递的数组参数
        $commentAttr = array(

            'openid'             => $openid,
            'nikname'            => $nikname,
            'order_detailid'     => $order_detailid,
            'productid'          => $productid,
            'product_title'      => $product_title,
            'desc'               => $desc
        );

        try {
            $rs = Comment::add($commentAttr);
            echo $rs;
        }catch (MyException $e){

            echo $e->jsonMsg();
        }

        break;

    case 'edit'://编辑

        $id                  = safeCheck($_POST['id']);
        $openid              = safeCheck($_POST['openid'],0);
        $nikname             = safeCheck($_POST['nikname'],0);
        $order_detailid      = safeCheck($_POST['order_detailid']);
        $desc                = $_POST['desc'];

        //构造需要传递的数组参数
        $commentAttr = array(


            'openid'             => $openid,
            'nikname'            => $nikname,
            'order_detailid'     => $order_detailid,
            'desc'               => $desc
 

        );

        try {
            $rs = Comment::edit($id, $commentAttr);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;


    case 'del'://删除
        $id = safeCheck($_POST['id']);

        try {
            $rs = Comment::del($id);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;


}
?>