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
require($LIB_PATH.'user.class.php');
require($LIB_TABLE_PATH.'table_user.class.php');

$act = safeCheck($_GET['act'], 0);
 $roleid      = safeCheck($_POST['roleid']);
 $id          = safeCheck($_POST['id']);
 $state       = safeCheck($_POST['state']);

switch($act){
    case 'user'://添加
       
    
    if($id==1){

        $msgAttr = array(

            'state1'             => $state
        
        );
           
    }
    if($id==2){
         $msgAttr = array(

            'state2'             => $state
        
        );
           
    }
    if($id==3){
         $msgAttr = array(

            'state3'             => $state
        
        );
           
    }
    if($id==4){
         $msgAttr = array(

            'state4'             => $state
        
        );
           
    }
    if($id==5){
         $msgAttr = array(

            'state5'             => $state
        
        );
           
    }

    try {
            $rs = User::update_msg($roleid,$id,$msgAttr);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }
    break;

    case 'partner'://添加
    if($id==6){
         $msgAttr = array(

            'state1'             => $state
        
        );
            
    }

    if($id==7){
         $msgAttr = array(

            'state2'             => $state
        
        );
           
    }
    try {
            $rs = Partner::update_msg($roleid,$id,$msgAttr);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }
        break;

     
}

?>