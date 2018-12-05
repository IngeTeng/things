<?php
    /**
     * 修改首页图片 banner_add.php
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
    $FLAG_LEFTMENU  = 'banner_edit';
    
    //加载所需的类
    require($LIB_PATH.'banner.class.php');
    require($LIB_TABLE_PATH.'table_banner.class.php');
  

  //获得参数后，率先检查参数的合法性
    $id = 1;
    try {

        $r = Banner::getInfoById($id);
        $banner_id                      = $r['id'];
        $banner_pic                     = $r['pic']; 
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
        <title>修改首页图片 --首页图片管理</title>
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
              
                

                 //文件上传
            $('.fileinput').on('change', 'input[type=file]', function(){
                $('.fileloading').html('<img src="images/loading.gif" width="24" height="24"/> 上传中...');
                ajaxFileUpload();
                return false;
            });
            function ajaxFileUpload(){
                var uploadUrl = 'banner_photoupload.php';//处理文件

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
                                $('#picpreview').html('<img src="<?php echo $HTTP_PATH?>'+msg+'" width="500"/>');
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

                //修改首页图片
                $('.btn_submit').click(function(){
                    //start数据检查                 
                   
                    var pic              = $('input[name=pic]').val();
                    
                   
                    if(pic == ''){
                        layer.msg('图片不能为空');
                        return false;
                    }
    
                     //end数据检查
                    
                    $.ajax({
                        type : 'POST',
                        data : {
                           
                            pic                : pic,
                            id                 : <?php echo $banner_id?>
                          
                        },
                        dataType : 'json',
                        url      : 'banner_do.php?act=edit',
                        success  : function(data){
                            console.log('success');
                            var code = data.code;
                            var msg  = data.msg;
                            switch(code){
                                case 1:
                                    layer.alert(msg, {icon: 6,shade: false}, function(index){
                                        location.href = 'banner_edit.php';
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
                <div id="position">当前位置：<a href="node_list.php">首页图片管理</a> &gt; 修改首页图片</div>
                <div id="formlist">


                   <p>
                    <label>首页图片图片</label>
                    <input name="pic" type="text" readonly="readonly" class="text-input input-length-30 readonlyinput" value="<?php echo $banner_pic?>"/>
                    <span class="fileinput">选择图片文件
                                <input type="file" name="picfile" id="picfile" />
                    </span>
                    <span class="fileloading"></span>
                    <span class="warn-block">* 文件格式：jpg。文件大小：<200KB。图片尺寸：宽1900px高1000px。 </span>
                    <span class="warn-block" id="picpreview"><img src="<?php echo $HTTP_PATH.$banner_pic?>" width="500"/></span>
                </p>
                    


                    <p>
                        <label>&nbsp;</label>
                        <input type="button" class="btn_submit" value="保存" />
                    </p>
                </div>
                
            </div>
            <div class="clear"></div>
        </div>
        <?php include('footer.inc.php');?>
    </body>
</html>