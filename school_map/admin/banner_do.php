<?php
/**
 * 首页图片处理  banner_do.php
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
   

    case 'edit'://编辑
        $id              = safeCheck($_POST['id']);
        $pic              = safeCheck($_POST['pic'],0);

        //构造需要传递的数组参数
        $bannerAttr = array(

         
            'pic'                => $pic
 

        );

        try {
            $rs = banner::edit($id, $bannerAttr);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;


}
?>