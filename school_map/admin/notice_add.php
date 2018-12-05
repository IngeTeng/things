<?php
    /**
     * 添加公告 notice_add.php
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
    $FLAG_TOPNAV    = "content";
    $FLAG_LEFTMENU  = 'notice_list';
    
    //加载所需的类
    require($LIB_PATH.'notice.class.php');
    require($LIB_TABLE_PATH.'table_notice.class.php');
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="author" content="微普科技 http://www.wiipu.com" />
        <title>添加公告 --公告管理</title>
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
                var ckeditor = CKEDITOR.replace('ck_content',{
                    toolbar : 'Common',
                    forcePasteAsPlainText : 'true',//强制纯文本格式粘贴
                    filebrowserImageUploadUrl : 'ckeditor_upload.php?type=img',
                    filebrowserUploadUrl : 'ckeditor_upload.php?type=file'
                });

                //简介字数统计
                $("#notice_intro").keyup(function(){
                    var maxlen = 140;
                    var len = $(this).val().length;
                    if(len > maxlen){
                        $(this).val($(this).val().substring(0, maxlen));
                    }
                    var num = maxlen - len;
                    $("#introwordscount").text(num);
                });


                //添加公告
                $('.btn_submit').click(function(){
                    //start数据检查                 
                    var title            = $('input[name=title]').val();
                    var abstract         = $('#notice_intro').val();
                    var desc             = ckeditor.getData();
                    
                    if(title == ''){
                        layer.msg('标题不能为空');
                        return false;
                    }
                    if(abstract == ''){
                        layer.msg('摘要不能为空');
                        return false;
                    }
    
                     //end数据检查
                    
                    $.ajax({
                        type : 'POST',
                        data : {
                            title              : title,
                            abstract           : abstract,
                            desc               : desc
                          
                        },
                        dataType : 'json',
                        url      : 'notice_do.php?act=add',
                        success  : function(data){
                            console.log('success');
                            var code = data.code;
                            var msg  = data.msg;
                            switch(code){
                                case 1:
                                    layer.alert(msg, {icon: 6,shade: false}, function(index){
                                        location.href = 'notice_list.php';
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
            <?php include('content_menu.inc.php');?>
            <div id="maincontent">
                <div id="position">当前位置：<a href="notice_list.php">公告管理</a> &gt; 添加公告</div>
                <div id="formlist">

                    <p>
                        <label>公告标题</label>
                        <input name="title" type="text" class="text-input input-length-50" />
                        <span class="warn-inline">*</span>
                    </p>
                     <p>
                        <label>内容摘要</label>
                        <textarea name="intro" class="text-area input-length-50" id="notice_intro"></textarea>
                        <span class="warn-block">限140字。还能输入<span id="introwordscount" style="color: red;">140</span>字。</span>
                    </p>

                      <p>
                        <label>图文详情</label>
                        <div style="margin-left:156px;width:80%;"><textarea name="desc" id="ck_content"></textarea></div>
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