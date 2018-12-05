<?php
    /**
     * 添加节点 node_add.php
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
    $FLAG_TOPNAV    = "route";
    $FLAG_LEFTMENU  = 'node_list';
    
    //加载所需的类
    require($LIB_PATH.'node.class.php');
    require($LIB_TABLE_PATH.'table_node.class.php');
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="author" content="微普科技 http://www.wiipu.com" />
        <title>添加节点 - 节点管理</title>
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
              
                
                //添加新闻
                $('.btn_submit').click(function(){
                    //start数据检查                 
                    var title            = $('input[name=title]').val();
                    var jing             = $('input[name=jing]').val();
                    var wei              = $('input[name=wei]').val();

                    
                    
                     //end数据检查
                    
                    $.ajax({
                        type : 'POST',
                        data : {
                            title              : title,
                            jing              : jing,
                            wei                : wei
                          
                        },
                        dataType : 'json',
                        url      : 'node_do.php?act=add',
                        success  : function(data){
                            console.log('success');
                            var code = data.code;
                            var msg  = data.msg;
                            switch(code){
                                case 1:
                                    layer.alert(msg, {icon: 6,shade: false}, function(index){
                                        location.href = 'node_list.php';
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
            <?php include('link_menu.inc.php');?>
            <div id="maincontent">
                <div id="position">当前位置：<a href="node_list.php">节点管理</a> &gt; 添加节点</div>
                <div id="formlist">

                    <p>
                        <label>节点名称</label>
                        <input name="title" type="text" class="text-input input-length-50" />
                        <span class="warn-inline">*</span>
                    </p>

                    <p>
                        <label>经度</label>
                        <input name="jing" type="text" class="text-input input-length-50" />
                        <span class="warn-inline">*</span>
                    </p>
                    

                     <p>
                        <label>纬度</label>
                        <input name="wei" type="text" class="text-input input-length-50" />
                        <span class="warn-inline">*</span>
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