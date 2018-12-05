<?php
/**
 * 地址处理  address_do.php
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
        $openid           = safeCheck($_POST['openid'],0);
        $nikname          = safeCheck($_POST['nikname'],0);
        $name             = safeCheck($_POST['name'],0);
        $phone            = safeCheck($_POST['phone']);
        $address          = safeCheck($_POST['address'],0);
        $area             = safeCheck($_POST['area'],0);
        $postcode         = safeCheck($_POST['postcode']);
        //构造需要传递的数组参数
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
        $openid             = safeCheck($_POST['openid'],0);
        $nikname            = safeCheck($_POST['nikname'],0);
        $name               = safeCheck($_POST['name'],0);
        $phone              = safeCheck($_POST['phone']);
        $address            = safeCheck($_POST['address'],0);
        $area               = safeCheck($_POST['area'],0);
        $postcode           = safeCheck($_POST['postcode']);

        //构造需要传递的数组参数
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