<?php
/**
 * 分销商处理  partner_do.php
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
    case 'add'://添加分销商
        $name           = safeCheck($_POST['name'], 0);
        $company        = safeCheck($_POST['company'], 0);
        $nikname        = safeCheck($_POST['nikname'], 0);
        $openid         = safeCheck($_POST['openid'], 0);
        $account        = safeCheck($_POST['account'], 0);
        $password       = safeCheck($_POST['password'], 0);
        $state          = safeCheck($_POST['state']);
        $phone          = safeCheck($_POST['phone'], 0);
        $address        = safeCheck($_POST['address'],0);
        $qrcode         = safeCheck($_POST['qrcode'], 0);
        $product        = $_POST['product'];
        //构造需要传递的数组参数
        $partnerAttr = array(

            'name'          => $name,
            'company'       => $company,
            'nikname'       => $nikname,
            'openid'        => $openid,
            'account'       => $account,
            'password'      => $password,
            'state'         => $state,
            'phone'         => $phone,
            'address'       => $address,
            'qrcode'        => $qrcode,
            'product'       => $product
        );

        try {
            $rs = Partner::add($partnerAttr);
            echo $rs;
        }catch (MyException $e){

            echo $e->jsonMsg();
        }

        break;

    case 'edit'://编辑

        $id             = safeCheck($_POST['id']);
        $name           = safeCheck($_POST['name'], 0);
        $company        = safeCheck($_POST['company'], 0);
        $nikname        = safeCheck($_POST['nikname'], 0);
        $openid         = safeCheck($_POST['openid'], 0);
        $account        = safeCheck($_POST['account'], 0);
        $password       = safeCheck($_POST['password'], 0);
        $state          = safeCheck($_POST['state']);
        $phone          = safeCheck($_POST['phone'], 0);
        $address        = safeCheck($_POST['address'],0);
        $qrcode         = safeCheck($_POST['qrcode'], 0);
        $product        = $_POST['product'];

        //构造需要传递的数组参数
        $partnerAttr = array(


            'name'          => $name,
            'company'       => $company,
            'nikname'       => $nikname,
            'openid'        => $openid,
            'account'       => $account,
            'password'      => $password,
            'state'         => $state,
            'phone'         => $phone,
            'address'       => $address,
            'qrcode'        => $qrcode,
            'product'       => $product
 

        );

        try {
            $rs = Partner::edit($id, $partnerAttr);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;

    case 'edit_nopass'://编辑

        $id             = safeCheck($_POST['id']);
        $name           = safeCheck($_POST['name'], 0);
        $company        = safeCheck($_POST['company'], 0);
        $nikname        = safeCheck($_POST['nikname'], 0);
        $openid         = safeCheck($_POST['openid'], 0);
        $state          = safeCheck($_POST['state']);
        $phone          = safeCheck($_POST['phone'], 0);
        $address        = safeCheck($_POST['address'],0);
        $qrcode         = safeCheck($_POST['qrcode'], 0);
        $product        = $_POST['product'];

        //构造需要传递的数组参数
        $partnerAttr = array(


            'name'          => $name,
            'company'       => $company,
            'nikname'       => $nikname,
            'openid'        => $openid,
            'state'         => $state,
            'phone'         => $phone,
            'address'       => $address,
            'qrcode'        => $qrcode,
            'product'       => $product
 

        );

        try {
            $rs = Partner::edit_nopass($id, $partnerAttr);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;


    case 'del'://删除
        $id = safeCheck($_POST['id']);

        try {
            $rs = Partner::del($id);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;

    case 'reset'://重置密码
            $id = safeCheck($_POST['id']);
            $newpass = 'agriculture_888';
            
            try{
                $r = Partner::resetPwd($id, $newpass);
                echo $r;
            }catch(MyException $e){
                echo $e->jsonMsg();
            }
            break;

    case 'editpass'://修改密码
            $old_password = safeCheck($_POST['old_password'], 0);
            $new_password = safeCheck($_POST['new_password'], 0);
            $re_password  = safeCheck($_POST['re_password'], 0);
            
            if($new_password != $re_password){
                echo action_msg('两次密码不一致', -1);
                exit();
            }
            try {
                $r = Partner::updatePwd($old_password, $new_password);
                echo $r;
            }catch (MyException $e){
                echo $e->jsonMsg();
            }
            break;

}
?>