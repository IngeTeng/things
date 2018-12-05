<?php
    /**
     * 添加新闻 news_add.php
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
    $FLAG_LEFTMENU  = 'news_list';
    
    //加载所需的类
    require($LIB_PATH.'news.class.php');
    require($LIB_TABLE_PATH.'table_news.class.php');
  

  //获得参数后，率先检查参数的合法性
    $id = safeCheck($_GET['id']);
    try {

        $r = News::getInfoById($id);
        $news_id                      = $r['id'];
        $news_title                   = $r['title'];
        $news_pic                     = $r['pic']; 
        $news_admin                   = $r['admin'];
        $news_desc                    = $r['desc'];
        $news_createtime              = $r['createtime'];
    } catch(MyException $e){
        echo $e->getMessage();
        exit();
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="author" content="微普科技 http://www.wiipu.com" />
        <title>添加新闻 --新闻管理</title>
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

                 //文件上传
            $('.fileinput').on('change', 'input[type=file]', function(){
                $('.fileloading').html('<img src="images/loading.gif" width="24" height="24"/> 上传中...');
                ajaxFileUpload();
                return false;
            });
            function ajaxFileUpload(){
                var uploadUrl = 'news_photoupload.php';//处理文件

                $.ajaxFileUpload({
                    url           : uploadUrl,
                    fileElementId : 'picfile', // 需要上传的文件域的ID，即<input type="file">的ID。
                    dataType      : 'json',//服务器返回的数据类型
                    success       : function(data, status){//提交成功后自动执行的处理函数，参数data就是服务器返回的数据

                        var code = data.code;
                        var msg  = data.msg;


                        $('#picfile').val('');//成功后置为空
                        $('.fileloading').html('');

                        switch(code){
                            case 1:
                                $('input[name=pic]').val(msg);
                                $('#picpreview').html('<img src="<?php echo $HTTP_PATH?>'+msg+'" width="300"/>');
                                layer.msg('上传成功');
                                break;
                            default:
                                layer.alert(msg, {icon: 5});
                        }
                    },
                    error: function (data, status, e){
                        layer.alert(e);
                    }
                })
                return false;
            }

                //添加新闻
                $('.btn_submit').click(function(){
                    //start数据检查                 
                    var title            = $('input[name=title]').val();
                    var pic              = $('input[name=pic]').val();
                    var desc             = ckeditor.getData();
                    
                    if(title == ''){
                        layer.msg('标题不能为空');
                        return false;
                    }
                    if(pic == ''){
                        layer.msg('图片不能为空');
                        return false;
                    }
    
                     //end数据检查
                    
                    $.ajax({
                        type : 'POST',
                        data : {
                            title              : title,
                            pic                : pic,
                            desc               : desc,
                            id                 : <?php echo $news_id?>
                          
                        },
                        dataType : 'json',
                        url      : 'news_do.php?act=edit',
                        success  : function(data){
                            console.log('success');
                            var code = data.code;
                            var msg  = data.msg;
                            switch(code){
                                case 1:
                                    layer.alert(msg, {icon: 6,shade: false}, function(index){
                                        location.href = 'news_list.php';
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
                <div id="position">当前位置：<a href="node_list.php">新闻管理</a> &gt; 添加新闻</div>
                <div id="formlist">

                    <p>
                        <label>新闻标题</label>
                        <input name="title" type="text" class="text-input input-length-50" value="<?php echo $news_title?> "/>
                        <span class="warn-inline">*</span>
                    </p>

                   <p>
                    <label>新闻图片</label>
                    <input name="pic" type="text" readonly="readonly" class="text-input input-length-30 readonlyinput" value="<?php echo $news_pic?>"/>
                    <span class="fileinput">选择图片文件
                                <input type="file" name="picfile" id="picfile" />
                    </span>
                    <span class="fileloading"></span>
                    <span class="warn-block">* 文件格式：jpg。文件大小：<200KB。 图片尺寸：宽800px高350px。</span>
                    <span class="warn-block" id="picpreview"><img src="<?php echo $HTTP_PATH.$news_pic?>" width="300"/></span>
                </p>
                    

                      <p>
                        <label>图文详情</label>
                        <div style="margin-left:156px;width:80%;"><textarea name="desc" id="ck_content"><?php echo $news_desc?></textarea></div>
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