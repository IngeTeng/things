<?php
/**
 * 留言处理  suggest_do.php
 *
 * @version       v0.01
 * @create time   2016/11/14
 * @update time
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

require_once('admin_init.php');
//require_once('admincheck.php');


/*$POWERID = '7001';//权限
Admin::checkAuth($POWERID, $ADMINAUTH);*/


$act = safeCheck($_GET['act'], 0);

switch($act){
    case 'add'://添加

        $name            = safeCheck($_POST['name'],0);
        $phone            = safeCheck($_POST['phone']);
        $desc             = $_POST['desc'];
        //构造需要传递的数组参数
        $suggestAttr = array(

            'name'              => $name,
            'phone'             => $phone,
            'desc'              => $desc
        
        );

        try {
            $rs = Suggest::add($suggestAttr);
            $mes = '留言成功';
            $url = 'http://www.yanxin325.com/school_map/web/map/';
             echo "<script>alert('{$mes}');</script>";
             echo "<script>window.location='{$url}';</script>";
        }catch (MyException $e){

            echo $e->jsonMsg();
        }

        break;

    case 'del'://删除
        $id = safeCheck($_POST['id']);

        try {
            $rs = Suggest::del($id);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;
}
?>