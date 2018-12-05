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

require_once('admin_init.php');
require_once('admincheck.php');
require('../config.inc.php');
require('../wx_config.php');


$POWERID = '7001';//权限
Admin::checkAuth($POWERID, $ADMINAUTH);


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

    case 'edit'://编辑

        $id               = safeCheck($_POST['id']);
        $replay           = $_POST['replay'];
       
        //构造需要传递的数组参数
        $submitAttr = array(

            'replay'               => $replay
 

        );

        try {
            $rs = Submit::edit($id, $submitAttr);
            $submit = Submit::getInfoById($id);
            $user = User::getInfoByOpenid($submit['openid']);
            $time = time();
             if(!empty($replay)){
                    if($user['0']['state5']==2){
                        $array = array(
                            'touser' =>  $submit['openid'],
                            'template_id' => "Nhx5BR-AdxInIT4xjffTLSl-GUcMGrHtwOGwkU-8GCk",
                            'url' => 'http://www.yanxin325.com/agriculture_1.0/web/agriculture/submit_desc.php?submitid='.$submit['id'],
                            'data' => array(
                                 'first' => array( 'value' =>urlencode( '尊敬的'.$user['0']['nikname'].',您有一条工单消息' ), 
                                            'color'=>"#173177"
                                            ),
                                'keyword1' => array( 'value' =>urlencode($user['0']['nikname']) , 
                                            'color'=>"#173177"
                                            ),

                                'keyword2' => array('value' =>urlencode( date('Y-m-d H:i:s' , $time) ),
                                            'color'=>"#173177"
                                            ),
                                'remark' => array( 'value' => urlencode('请注意及时查询' ),
                                             'color'=>"#173177"),

                            ),
                    );
                            $res = sendTemplateMsg(urldecode(json_encode($array)));

                    }
            }
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;


    case 'del'://删除
        $id = safeCheck($_POST['id']);

        try {
            $rs = Submit::del($id);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;
}
?>