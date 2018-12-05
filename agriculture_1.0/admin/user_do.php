<?php
/**
 * 用户处理  user_do.php
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
    case 'add'://添加用户,对比添加新闻
        $img       = safeCheck($_POST['img'], 0);
        $nikname   = safeCheck($_POST['nikname'], 0);
        $sex       = safeCheck($_POST['sex']);
        $openid    = safeCheck($_POST['openid'],0);
        //构造需要传递的数组参数
        $userAttr = array(

            'img'       => $img,
            'nikname'   => $nikname,
            'sex'       => $sex,
            'openid'    =>$openid
        );

        try {
            $rs = User::add($userAttr);
            echo $rs;
        }catch (MyException $e){

            echo $e->jsonMsg();
        }

        break;

    case 'edit'://编辑

        $id             = safeCheck($_POST['id']);
        $img            = safeCheck($_POST['img'], 0);
        $nikname        = safeCheck($_POST['nikname'], 0);
        $sex            = safeCheck($_POST['sex']);
        $openid         = safeCheck($_POST['openid'],0);

        //构造需要传递的数组参数
        $userAttr = array(

            'img'           => $img,
            'nikname'       => $nikname,
            'sex'           => $sex,
            'openid'        => $openid
 

        );

        try {
            $rs = User::edit($id, $userAttr);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;


    case 'del'://删除
        $id = safeCheck($_POST['id']);

        try {
            $rs = User::del($id);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;



}
?>