<?php
/**
 * 添加分销商  partner_add.php
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

$FLAG_TOPNAV    = "role";
$FLAG_LEFTMENU  = 'partner_list';

//获得参数后，率先检查参数的合法性
$id = safeCheck($_GET['id']);
try {
    $r = Partner::getInfoById($id);
    $partner_id                 = $r['id'];
    $partner_name               = $r['name'];
    $partner_company            = $r['company'];
    $partner_nikname            = $r['nikname'];
    $partner_openid             = $r['openid'];
    $partner_account            = $r['account'];
    $partner_password           = $r['password'];
    $partner_state              = $r['state'];
    $partner_phone              = $r['phone'];
    $partner_address            = $r['address'];
    $partner_qrcode             = $r['qrcode'];
    $partner_product            = $r['product'];
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
    <title>添加分销商 - 分销商管理 - 管理系统 </title>
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
                var uploadUrl = 'partner_photoupload.php';//处理文件

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
                                $('input[name=qrcode]').val(msg);
                                $('#picpreview').html('<img src="<?php echo $HTTP_PATH?>'+msg+'" width="100"/>');
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

           
        

            //添加用户
            $('.btn_submit').click(function(){
                location.href = 'partner_list.php';
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
    <?php include('role_menu.inc.php');?>
    <div id="maincontent">
        <div id="position">当前位置：<a href="partner_list.php">分销商管理</a> &gt; 修改分销商</div>
        <div id="formlist">
            <p>
                <label>真实姓名:</label>
                <label><?php echo $partner_name?></label>
               
            </p>
            <p>
                <label>经销商店铺名:</label>
                <label><?php echo $partner_company?></label>
               
            </p>
            <p>
                <label>微信昵称:</label>
                 <label><?php echo $partner_nikname?></label>
            </p>
            <p>
                <label>微信识别号:</label>
               <label ><?php echo $partner_openid?></label>
              
            </p>
            <p>
                <label>登陆账号:</label>
                <label><?php echo $partner_account?></label>
                
            </p>
            <p>
                <label>审核状态:</label>
                <?php if($partner_state == 0) echo ' <label>待审核</label> ';?>
                <?php if($partner_state == 1) echo ' <label>已审核</label> ';?>
                    
            </p>
            <p>
                <label>电话:</label>
                <label><?php echo $partner_phone?></label>
            </p>
             <p>
                <label>详细住址:</label>
               <label><?php echo $partner_address?></label>
            </p>
            
            <p>
                <label>转账二维码:</label>
                <input name="qrcode" type="text" value="<?php echo $partner_qrcode?>" readonly="readonly" class="text-input input-length-30 readonlyinput" value="" disabled="true"/>
                <span class="warn-block" id="picpreview"><img src="<?php echo $HTTP_PATH.$partner_qrcode?>" width="100"/></span>
            </p>
            <p>
            <p>
                <label>预售产品信息:</label>
                <div style="margin-left:156px;width:80%;"><textarea name="product"  id="ck_content" disabled="true"><?php echo $partner_product?></textarea></div>
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