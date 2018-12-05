<?php
   /**
     * 管理员列表  admin_list.php
     *
     * @version       v0.03
     * @create time   2014-8-3
     * @update time   2016/3/26
     * @author        IngeTeng
     */
    require_once('admin_init.php');
    require_once('admincheck.php');

    $POWERID        = '7004';//权限
    Admin::checkAuth($POWERID, $ADMINAUTH);
    
    $FLAG_TOPNAV    = "data";
    $FLAG_LEFTMENU  = 'index_list';
    
    //加载所需的类
    /*require($LIB_PATH.'news.class.php');
    require($LIB_TABLE_PATH.'table_news.class.php');
    require($LIB_PATH.'newssort.class.php');
    require($LIB_TABLE_PATH.'table_newssort.class.php');*/
    
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="author" content="微普科技 http://www.wiipu.com" />
        <title>数据管理 - 管理系统 </title>
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
                var fileurl = "";
                 
                //文件上传
                $('.fileinput').on('change', 'input[type=file]', function(){
                    console.log('11');
                    $('.fileloading').html('<img src="images/loading.gif" width="24" height="24"/> 上传中...');
                    ajaxFileUpload();
                    return false;
                });
                function ajaxFileUpload(){
                    var uploadUrl = 'data_picupload.php';//处理文件
                    
                    $.ajaxFileUpload({
                        url           : uploadUrl,
                        fileElementId : 'picfile',
                        dataType      : 'json',
                        success       : function(data, status){
                            console.log('22');
                            var code = data.code;
                            var msg  = data.msg;
                            fileurl = msg;
                            $('#picfile').val('');
                            $('.fileloading').html('');
                            
                            switch(code){
                                case 1:
                                    $('input[name=pic]').val(msg);
                                    // $('#picpreview').html('<img src="<?php echo $HTTP_PATH?>'+msg+'" width="100"/>');
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


                $('.btn_submit').click(function(){
                    console.log(fileurl);
                    location.href = 'read_excel.php?fileurl='+fileurl;
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
            <?php include('data_menu.inc.php');?>
            <div id="maincontent">
                <div id="position">当前位置：<a href="index_list.php">数据管理</a> &gt; 添加数据</div>
                <div id="formlist">
                    <p>
                        <label>导入文件</label>
                        <input name="pic" type="text" readonly="readonly" class="text-input input-length-30 readonlyinput" value=""/>
                        <span class="fileinput">选择EXCEL文件
                            <input type="file" name="picfile" id="picfile" />
                        </span>
                        <span class="fileloading"></span>
                        <span class="warn-block">* 文件格式：jpg。文件大小：<200KB。图片尺寸：宽200px高150px。</span>
                        <span class="warn-block" id="picpreview"></span>
                    </p>
                    <p>
                        <label>&nbsp;</label>
                        <input type="button" class="btn_submit" value="上 传" />
                    </p>
                </div>
                
            </div>
            <div class="clear"></div>
        </div>
        <?php include('footer.inc.php');?>
    </body>
</html>