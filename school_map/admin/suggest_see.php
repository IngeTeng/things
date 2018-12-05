<?php
/**
 * 添加分销商  suggest_add.php
 *
 * @version       v0.01
 * @create time   2016/11/14
 * @update time
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */
require_once('admin_init.php');
require_once('admincheck.php');

$POWERID        = '7001';//权限
Admin::checkAuth($POWERID, $ADMINAUTH);

$FLAG_TOPNAV    = "content";
$FLAG_LEFTMENU  = 'suggest_list';

//获得参数后，率先检查参数的合法性
$id = safeCheck($_GET['id']);
try {
    $r = Suggest::getInfoById($id);
    $suggest_id                 = $r['id'];
    $suggest_name               = $r['name'];
    $suggest_phone              = $r['phone'];
    $suggest_desc               = $r['desc'];
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
    <title>查看详细留言 - 留言管理 - 管理系统 </title>
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
            //返回
            $('.btn_submit').click(function(){
                location.href = 'suggest_list.php';
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
        <div id="position">当前位置：<a href="suggest_list.php">留言管理</a> &gt; 查看留言内容</div>
        <div id="formlist">
            <p>
                <label>真实姓名:</label>
                <label><?php echo $suggest_name?></label>
               
            </p>
            
            <p>
                <label>电话:</label>
                <label><?php echo $suggest_phone?></label>
            </p>
            
           
            <p>
                <label>留言详情:</label>
                <div style="margin-left:156px;width:80%;"><textarea name="product"  id="ck_content" disabled="true"><?php echo $suggest_desc?></textarea></div>
            </p>
            <p>
                <label>&nbsp;</label>
                <input type="button" class="btn_submit" value="返  回" />
            </p>
        </div>

    </div>
    <div class="clear"></div>
</div>
<?php include('footer.inc.php');?>
</body>
</html>