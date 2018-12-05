<?php
/**
 * @Author: anchen
 * @Date:   2017-03-14 16:48:46
 * @Last Modified by:   anchen
 * @Last Modified time: 2017-03-20 11:33:13
 */
require('../../conn.php');
require($LIB_PATH.'product.class.php');
require($LIB_TABLE_PATH.'table_product.class.php');
require($LIB_PATH.'comment.class.php');
require($LIB_TABLE_PATH.'table_comment.class.php');
require($LIB_PATH.'order_detail.class.php');
require($LIB_TABLE_PATH.'table_order_detail.class.php');
require($LIB_PATH.'cart.class.php');
require($LIB_TABLE_PATH.'table_cart.class.php');

$act = safeCheck($_GET['act'], 0);
    switch($act){
            
        case 'edit'://编辑预约信息

            $id                     = strCheck($_POST['id']);
            $cateid                 = strCheck($_POST['cateid']);
            $title                  = strCheck($_POST['title'],0);
            $num                    = strCheck($_POST['num']);
            $pic                    = strCheck($_POST['pic'],0);
            $price                  = strCheck($_POST['price']);
            $post_price             = strCheck($_POST['post_price']);
            $issale                 = strCheck($_POST['issale']);
            $ishot                  = strCheck($_POST['ishot']);
            $isnew                  = strCheck($_POST['isnew']);
            $sale_price             = strCheck($_POST['sale_price']);
            /*$id                     = $_POST['id'];
            $cateid                 = $_POST['cateid'];
            $title                  = $_POST['title'];
            $num                    = $_POST['num'];
            $pic                    = $_POST['pic'];
            $price                  = $_POST['price'];
            $post_price             = $_POST['post_price'];
            $issale                 = $_POST['issale'];
            $ishot                  = $_POST['ishot'];
            $isnew                  = $_POST['isnew'];
            $sale_price             = $_POST['sale_price'];*/

            //构造需要传递的数组参数
            $productAttr = array(
                

                'cateid'            => $cateid,
                'title'             => $title,
                'num'               => $num,
                'pic'               => $pic,
                'price'             => $price,
                'post_price'        => $post_price,
                'issale'            => $issale,
                'ishot'             => $ishot,
                'isnew'             => $isnew,
                'sale_price'        => $sale_price
                );          
            try {
                $rs = Product::edit_desc($id,$productAttr);
                echo $rs;
            }catch (MyException $e){
                echo $e->jsonMsg();
            }
            break;
            
        case 'del'://删除套餐
            $id = safeCheck($_POST['id']);
            
            try {
                $order_detail = Order_detail::getInfoByProductid($id);
                if($order_detail){
                $comments = Comment::getInfoByOrder_detailid($order_detail['id']);
                //var_dump($comments);
                 if(!empty($comments)){//如果列表不为空
                    foreach($comments as $comment){
                            $rss = Comment::del($comment['id']);
                    }
                }
               }
               $cartAttr = array(
                'ischecked'     => 0

                    );
               table_cart::edit_ischecked($id,$cartAttr);
                $rs = Product::del_front($id);
                //var_dump($rs);
                echo $rs;
            }catch (MyException $e){
                echo $e->jsonMsg();
            }
            break;

        
    }
?>