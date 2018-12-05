<?php
    /**
     * 修改商品记录  product_add.php
     *
     * @version       v0.01
     * @create time   2016/4/16
     * @update time   
     * @author        IngeTeng
     * @copyright     Neptune工作室
     */
    require_once('admin_init.php');
    require_once('admincheck.php');

    $POWERID        = '7001';//权限
    Admin::checkAuth($POWERID, $ADMINAUTH);
    $FLAG_TOPNAV    = "order";
    $FLAG_LEFTMENU  = 'submit_list';
    
    //加载所需的类
    require_once('order_init.php');

//获得参数后，率先检查参数的合法性
$id = safeCheck($_GET['id']);
try {
    $r = Submit::getInfoById($id);
    $submit_id                      = $r['id'];
    $submit_only                    = $r['only'];
    $submit_openid                  = $r['openid']; 
    $submit_nikname                 = $r['nikname'];
    $submit_desc                    = $r['desc'];
    $submit_replay                  = $r['replay'];
    $submit_createtime              = $r['createtime'];
} catch(MyException $e){
    echo $e->getMessage();
    exit();
}
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="author" content="Neptune工作室" />
        <title>处理工单 - 工单管理</title>
        <link rel="stylesheet" href="css/style.css" type="text/css" />
        <link rel="stylesheet" href="css/form.css" type="text/css" />
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/layer/layer.js"></script>
        <script type="text/javascript" src="js/common.js"></script>
        <script type="text/javascript" src="js/upload.js"></script>
        <script src="laydate/laydate.js"></script>
        <script src="ckeditor/ckeditor.js"></script> 
        <script type="text/javascript">
            $(function(){


                 //编辑器初始化
                var ckeditor = CKEDITOR.replace('ck_content1',{
                    toolbar : 'Common',
                    forcePasteAsPlainText : 'true',//强制纯文本格式粘贴
                    filebrowserImageUploadUrl : 'ckeditor_upload.php?type=img',
                    filebrowserUploadUrl : 'ckeditor_upload.php?type=file'
                });
                //编辑器初始化
                var ckeditor = CKEDITOR.replace('ck_content2',{
                    toolbar : 'Common',
                    forcePasteAsPlainText : 'true',//强制纯文本格式粘贴
                    filebrowserImageUploadUrl : 'ckeditor_upload.php?type=img',
                    filebrowserUploadUrl : 'ckeditor_upload.php?type=file'
                });
    

                
                //添加
                $('.btn_submit').click(function(){
                    //start数据检查                 
        
                    var replay           = ckeditor.getData();


                    
                
                     //end数据检查
                    
                    $.ajax({
                        type : 'POST',
                        data : {
                
                            replay             : replay,
                            id                 : <?php echo $submit_id?>
                    
                          
                        },
                        dataType : 'json',
                        url      : 'submit_do.php?act=edit',
                        success  : function(data){
                            console.log('success');
                            var code = data.code;
                            var msg  = data.msg;
                            switch(code){
                                case 1:
                                    layer.alert(msg, {icon: 6,shade: false}, function(index){
                                        location.href = 'submit_list.php';
                                    });
                                    break;
                                default:
                                    layer.alert(msg, {icon: 5});
                            }
                        }
                    });
                    
                });
                
            });
                
        </script>
    </head>
    <body>
        <div id="header">
            <?php include('top.inc.php');?>
            <?php include('nav.inc.php');?>
        </div>
        <div id="container">
            <?php include('order_menu.inc.php');?>
            <div id="maincontent">
                <div id="position">当前位置：<a href="submit_list.php">工单管理</a> &gt; 处理工单</div>
                <div id="formlist">
                    <p>
                        <label>工单号码</label>
                        <input name="only" type="text" class="text-input input-length-30" value="<?php echo $submit_only;?>" disabled="true"/>
                        <span class="warn-inline">*</span>
                    </p>
                           
                    <p>
                        <label>微信识别码</label>
                        <input name="openid" type="text" class="text-input input-length-30" value="<?php echo $submit_openid?> " disabled="true"/>
                        <span class="warn-inline">*</span>
                    </p>
                    <p>
                        <label>微信昵称</label>
                        <input name="nikname" type="text" class="text-input input-length-30" value="<?php echo $submit_nikname?>" disabled="true"/>
                        <span class="warn-inline">*</span>
                    </p>
                    <p>
                        <label>用户问题</label>
            
                        <div style="margin-left:156px;width:80%;"><textarea name="desc" id="ck_content1" disabled="true"><?php echo $submit_desc?></textarea></div>
                    </p>
                    <p>
                        <label>处理工单</label>
                        <div style="margin-left:156px;width:80%;"><textarea name="replay" id="ck_content2"><?php echo $submit_replay?></textarea></div>
                    </p>
                    <p>
                        <label>&nbsp;</label>
                        <input type="button" class="btn_submit" value="提　交" />
                    </p>
                </div>
                
            </div>
            <div class="clear"></div>
        </div>
        <?php include('footer.inc.php');?>
    </body>
</html>