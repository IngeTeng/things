<?php
/**
 * 添加用户  user_edit.php
 *
 * @version       v0.01
 * @create time   2016/11/14
 * @update time
 * @author        ty
 * @copyright
 */
require_once('admin_init.php');
require_once('admincheck.php');

$POWERID        = '7001';//权限
Admin::checkAuth($POWERID, $ADMINAUTH);

$FLAG_TOPNAV    = "role";
$FLAG_LEFTMENU  = 'user_list';

//获得参数后，率先检查参数的合法性
$id = safeCheck($_GET['id']);
try {
    $r = User::getInfoById($id);
    $user_id               = $r['id'];
    $user_nikname          = $r['nikname'];
    $user_sex              = $r['sex'];
    $user_img              = $r['img'];
    $user_openid           = $r['openid'];
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
    <title>编辑用户 - 用户管理 - 管理系统 </title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <link rel="stylesheet" href="css/form.css" type="text/css" />
    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="js/layer/layer.js"></script>
    <script type="text/javascript" src="js/common.js"></script>
    <script type="text/javascript" src="js/upload.js"></script>
    <script src="laydate/laydate.js"></script>
    <script type="text/javascript">
        $(function(){
            //文件上传
            $('.fileinput').on('change', 'input[type=file]', function(){
                $('.fileloading').html('<img src="images/loading.gif" width="24" height="24"/> 上传中...');
                ajaxFileUpload();
                return false;
            });
            function ajaxFileUpload(){
                var uploadUrl = 'user_photoupload.php';//处理文件

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
                                $('input[name=img]').val(msg);
                                $('#picpreview').html('<img src="'+msg+'" width="100"/>');
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
                //start数据检查
                var img             = $('input[name=img]').val();
                var nikname         = $('input[name=nikname]').val();
                var openid          = $('input[name=openid]').val();
                var sex             = $('#user_sex').val();


                if(img == ''){
                    layer.msg('请上传图片');
                    return false;
                }
                if(nikname == ''){
                    layer.msg('微信呢称不能为空');
                    return false;
                }
                if(openid == ''){
                    layer.msg('微信识别号不能为空');
                    return false;
                }
                if(sex == ''){
                    layer.msg('请选择性别');
                    return false;
                }
                //end数据检查

                $.ajax({
                    type : 'POST',
                    data : {
                        img             : img,
                        nikname         : nikname,
                        sex             : sex,
                        openid          :openid,
                        id         : <?php echo $user_id?>
                    },
                    dataType : 'json',
                    url      : 'user_do.php?act=edit',
                    success  : function(data){

                        var code = data.code;
                        var msg  = data.msg;
                        switch(code){
                            case 1:
                                layer.alert(msg, {icon: 6,shade: false}, function(index){
                                    location.href = 'user_list.php';
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
    <?php include('role_menu.inc.php');?>
    <div id="maincontent">
        <div id="position">当前位置：<a href="user_list.php">用户管理</a> &gt; 添加用户</div>
        <div id="formlist">

            <p>
                        <label>头像图片</label>
                        <input name="img" type="text" value="<?php echo $user_img?>" readonly="readonly" class="text-input input-length-30 readonlyinput" value=""/>
                        <span class="warn-inline">*</span>
                        <span class="fileinput">更换图片
                            <input type="file" name="picfile" id="picfile" />
                        </span>
                        <span class="fileloading"></span>
                        <span class="warn-block">* 文件格式：jpg。文件大小：<200KB。图片尺寸：宽200px高150px。</span>
                        <span class="warn-block" id="picpreview"><img src="<?php echo$user_img?>" width="100"/></span>
                    </p>
            <p>
                <label>微信昵称</label>
                <input name="nikname" type="text" class="text-input input-length-10" value="<?php echo $user_nikname?>"/>
                <span class="warn-inline">*</span>
            </p>
             <p>
                <label>微信识别号</label>
                <input name="openid" type="text" class="text-input input-length-30" value="<?php echo $user_openid?>"/>
                <span class="warn-inline">*</span>
            </p>
            <p>
                <label>性别</label>
                <select name="sex" class="select-option" id="user_sex">
                    <option value="0" <?php if($user_sex == 0) echo ' selected ';?>>女</option>
                    <option value="1" <?php if($user_sex == 1) echo ' selected ';?>>男</option>
                </select>
            </p>
            <p>
                <label>&nbsp;</label>
                <input type="button" class="btn_submit" value="提交修改" />
            </p>
        </div>

    </div>
    <div class="clear"></div>
</div>
<?php include('footer.inc.php');?>
</body>
</html>