<?php
/**
 * 工单处理  submit_do.php
 *
 * @version       v0.01
 * @create time   2016/11/14
 * @update time
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

require('../../conn.php');
require('../../config.inc.php');
require('../../wx_config.php');
require($LIB_PATH.'submit.class.php');
require($LIB_TABLE_PATH.'table_submit.class.php');

$act = safeCheck($_GET['act'], 0);

switch($act){
    case 'add'://添加

        $openid           = safeCheck($_POST['openid'],0);
        $nikname          = safeCheck($_POST['nikname'],0);
        $desc             = safeCheck($_POST['desc'],0);
        //only单号在table_calss里面添加
        //构造需要传递的数组参数
        $submitAttr = array(

            'openid'             => $openid,
            'nikname'            => $nikname,
            'desc'               => $desc
        
        );

        try {
            $rs = Submit::add($submitAttr);
            echo $rs;
        }catch (MyException $e){

            echo $e->jsonMsg();
        }

        break;

}
?>