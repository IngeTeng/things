<?php
/**
 * @Author: anchen
 * @Date:   2017-03-12 22:17:47
 * @Last Modified by:   anchen
 * @Last Modified time: 2017-03-13 22:43:07
 */
require('../../conn.php');
require('../../config.inc.php');
require('../../wx_config.php');
require($LIB_PATH.'address.class.php');
require($LIB_TABLE_PATH.'table_address.class.php');
$act = safeCheck($_GET['act'], 0);
switch($act){
    case 'add'://添加
        $openid           = safeCheck($_POST['openid'],0);
        $nikname          = safeCheck($_POST['nikname'],0);
        $name             = safeCheck($_POST['name'],0);
        $phone            = safeCheck($_POST['phone']);
        $address          = safeCheck($_POST['address'],0);
        $area             = safeCheck($_POST['area'],0);
        $postcode         = safeCheck($_POST['postcode']);
        $addressAttr = array(

            'openid'             => $openid,
            'nikname'            => $nikname,
            'name'               => $name,
            'phone'              => $phone,
            'address'            => $address,
            'area'               => $area,
            'postcode'           => $postcode
        );

        try {
            $rs = Address::add($addressAttr);
            echo $rs;
        }catch (MyException $e){

            echo $e->jsonMsg();
        }
        break;


    case 'edit'://编辑

        $id                 = safeCheck($_POST['id']);
        $name               = safeCheck($_POST['name'],0);
        $phone              = safeCheck($_POST['phone']);
        $address            = safeCheck($_POST['address'],0);
        $area               = safeCheck($_POST['area'],0);
        $postcode           = safeCheck($_POST['postcode']);

        //构造需要传递的数组参数
        $addressAttr = array(

            'name'               => $name,
            'phone'              => $phone,
            'address'            => $address,
            'area'               => $area,
            'postcode'           => $postcode
 

        );

        try {
            $rs = Address::edit($id, $addressAttr);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;

         case 'del'://删除
        $id = safeCheck($_POST['id']);

        try {
            $rs = Address::del($id);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;
}

?>