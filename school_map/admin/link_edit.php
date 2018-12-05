<?php
    /**
     * 添加节点 link_add.php
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
    $FLAG_LEFTMENU  = 'link_list';
    
    //加载所需的类
    require($LIB_PATH.'link.class.php');
    require($LIB_TABLE_PATH.'table_link.class.php');

   $id = strCheck($_GET['id']);
    try {

        $rc = Link::getList();
        //$cateids = category::getOptions($rc);
        //var_dump($cateids);
        $r = Link::getInfoById($id);
        //var_dump($r);
        $link_id                 = $r['id'];
        $link_node_id            = $r['node_id'];
        $link_title              = $r['title'];
        $link_parent             = $r['parent'];
        //var_dump($category_name);
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
        <title>添加节点 - 路径管理</title>
        <link rel="stylesheet" href="css/style.css" type="text/css" />
        <link rel="stylesheet" href="css/form.css" type="text/css" />
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/layer/layer.js"></script>
        <script type="text/javascript" src="js/common.js"></script>
        <script type="text/javascript" src="js/upload.js"></script>
        <script src="laydate/laydate.js"></script>
       <!--  <script src="ckeditor/ckeditor.js"></script> -->
        <script type="text/javascript">
            $(function(){   


                
                //添加
                $('.btn_submit').click(function(){
                    //start数据检查                 
                    var title                   = $('input[name=title]').val();
                    var node_id                 = $('#link_node_id').val();
                    var parent                  = $('#link_parent').val();

                    if(title == ''){
                        layer.msg('路径名不能为空');
                        return false;
                    }
                    if(node_id == ''){
                        layer.msg('节点不能为空');
                        return false;
                    }
                    if(parent == ''){
                        layer.msg('上级节点不能为空');
                        return false;
                    }
                     //end数据检查
                    
                    $.ajax({
                        type : 'POST',
                        data : {
                            title              : title,
                            node_id            : node_id,
                            parent             : parent,
                            id                 : <?php echo $link_id?>
                            
                          
                        },
                        dataType : 'json',
                        url      : 'link_do.php?act=edit',
                        success  : function(data){
                            console.log('success');
                            var code = data.code;
                            var msg  = data.msg;
                            switch(code){
                                case 1:
                                    layer.alert(msg, {icon: 6,shade: false}, function(index){
                                        location.href = 'link_list.php';
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
                <div id="position">当前位置：<a href="link_list.php">路径管理</a> &gt; 添加节点</div>
                <div id="formlist">

                    <p>
                        <label>路径名称</label>
                        <input name="title" type="text" class="text-input input-length-30" value="<?php echo $link_title?>" />
                        <span class="warn-inline">*</span>
                    </p>

                    <p>
                        <label>节点名称</label>
                        <select name="node_id" class="select-option" id="link_node_id">
                            <option value="0">请选择</option>
                            <?php
                                $nodes = Node::getList();
                                if(!empty($nodes)){
                                    foreach($nodes as $node){
                                       echo '<option value="'.$node['id'].'"';
                                        if($link_node_id == $node['id']) echo ' selected ';
                                        echo '>'.$node['title'].'</option>';
                                    }
                                }
                            ?>
                            
                        </select>
                        <span class="warn-inline">*</span>
                    </p>
                   
                    <p>

                        <label>上级节点</label>
                        <select name="parent" class="select-option" id="link_parent">
                            <?php
                                $linkids = Link::getOptions($rc);
                                //var_dump($cateids);

                                if(!empty($linkids)){
                                    $keys=array_keys($linkids);
                                    foreach($keys as $key){
                                            
                                       echo '<option value="'.$key.'"';
                                        if($link_parent == $key) echo ' selected ';
                                        echo '>'.$linkids[$key].'</option>';
                                    }
                                }
                            ?>
                            
                        </select>
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