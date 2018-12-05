<?php
/**
 * @Author: anchen
 * @Date:   2017-03-12 15:38:37
 * @Last Modified by:   anchen
 * @Last Modified time: 2017-03-17 20:22:33
 */
require('../../conn.php');
require($LIB_PATH.'cart.class.php');
require($LIB_TABLE_PATH.'table_cart.class.php');

$productid = $_POST['productid'];
$productnum = $_POST['productnum'];
$product_pic = $_POST['product_pic'];
$product_price = $_POST['product_price'];
$product_title = $_POST['product_title'];
$openid = $_POST['openid'];
$nikname = $_POST['nikname'];

 $cartAttr = array(

            'productid'          => $productid,
            'productnum'         => $productnum,
            'product_pic'        => $product_pic,
            'product_price'      => $product_price,
            'product_title'      => $product_title,
            'openid'             => $openid,
            'nikname'            => $nikname
        );
 //var_dump($cartAttr);
        try {
            $rs = Cart::add($cartAttr);
            echo $rs;
        }catch (MyException $e){

            echo $e->jsonMsg();
        }