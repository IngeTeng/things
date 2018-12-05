<?php
    /**
     * 新闻图片上传  news_picupload.php
     *
     * @version       v0.01
     * @create time   2016-4-17
     * @update time   
     * @author        jt
     * @copyright     Copyright (c) 微普科技 WiiPu Tech Inc. (http://www.wiipu.com)
     */

    require_once('admin_init.php');
    require_once('admincheck.php'); 
    
    $POWERID = '7004';//权限
    Admin::checkAuth($POWERID, $ADMINAUTH);
    
    require($LIB_COMMON_PATH.'fileupload.class.php');
    
    //测试Loading效果
    //sleep(10);
    
    //上传
    $allowext        = array( 'jpg', 'png', 'gif','xlsx');
    $fileElement     = 'picfile';
    $filepath_rel    = 'userfiles/data/';//相对路径
    $filepath_abs    = $FILE_PATH.$filepath_rel;//绝对路径
    
    try{
        $fup = new FileUpload('5M', $allowext);

        $r = $fup->upload($fileElement, $filepath_abs, '', true);
         //var_dump($r);
        $name_abs = $filepath_abs.$r;
        $name_rel = $filepath_rel.$r;
        
        //检查图片尺寸
        // $imgsize  = getimagesize($name_abs);
        // $imgwidth = $imgsize[0];
        // $imgheight= $imgsize[1];
        
        // if($imgwidth !== 200 || $imgheight !== 150){
        //     echo action_msg('图片尺寸大小不正确', 1001);
        //     exit();
        // }
        
        //上传成功
        echo action_msg($name_rel, 1);
    }catch(Exception $e){
        echo action_msg($e->getMessage(), $e->getCode());
    }
    
?>