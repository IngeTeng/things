<?php
/**
 * 节点处理  submit_do.php
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

        $title            = safeCheck($_POST['title'],0);
        $jing             = safeCheck($_POST['jing'],0);
        $wei              = safeCheck($_POST['wei'],0);
        //only单号在table_calss里面添加
        //构造需要传递的数组参数
        $nodeAttr = array(

            'title'             => $title,
            'jing'              => $jing,
            'wei'               => $wei
        
        );

        try {
            $rs = Node::add($nodeAttr);
            echo $rs;
        }catch (MyException $e){

            echo $e->jsonMsg();
        }

        break;

    case 'edit'://编辑

        $id               = safeCheck($_POST['id']);
        $title            = safeCheck($_POST['title'],0);
        $jing             = safeCheck($_POST['jing'],0);
        $wei              = safeCheck($_POST['wei'],0);

        //构造需要传递的数组参数
        $nodeAttr = array(

            'title'             => $title,
            'jing'              => $jing,
            'wei'               => $wei
 

        );

        try {
            $rs = Node::edit($id, $nodeAttr);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;


    case 'del'://删除
        $id = safeCheck($_POST['id']);

        try {
            $rs = Node::del($id);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;
}
?>