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
    <title>添加加盟商 - 加盟商管理 - 管理系统 </title>
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
            $('#submit').click(function(){
                //start数据检查
                var name            = $('input[name=name]').val();
                var company         = $('input[name=company]').val();
                var nikname         = $('input[name=nikname]').val();
                var openid          = $('input[name=openid]').val();
                var account         = $('input[name=account]').val();
                var password        = $('input[name=password]').val();
                var state           = $('#partner_state').val();
                var phone           = $('input[name=phone]').val();
                var address         = $('input[name=address]').val();
                var qrcode          = $('input[name=qrcode]').val();
                var product         = $('input[name=product]').val();


                if(name == ''){
                    layer.msg('真实姓名不能为空');
                    return false;
                }
                if(nikname == ''){
                    layer.msg('微信呢称不能为空');
                    return false;
                }
                if(openid == ''){
                    layer.msg('微信标识码不能为空');
                    return false;
                }
                if(account == ''){
                    layer.msg('加盟商账号不能为空');
                    return false;
                }
                if(password == ''){
                    layer.msg('加盟商密码不能为空');
                    return false;
                }
                if(state == ''){
                    layer.msg('处理状态不能为空');
                    return false;
                }
                if(phone == ''){
                    layer.msg('联系电话不能为空');
                    return false;
                }
                if(address == ''){
                    layer.msg('详细不能为空');
                    return false;
                }
                if(qrcode  == ''){
                    layer.msg('转账二维码不能为空');
                    return false;
                }

                //end数据检查
                $.ajax({
                    type : 'POST',
                    data : {
                        name           : name,
                        company        : company,
                        nikname        : nikname,
                        openid         : openid,
                        account        : account,
                        password       : password,
                        state          : state,
                        phone          : phone,
                        address        : address,
                        qrcode         : qrcode,
                        product        : product,
                        id         : <?php echo $partner_id?>
                    },
                    dataType : 'json',
                    url      : 'partner_do.php?act=edit',
                    success  : function(data){

                        var code = data.code;
                        var msg  = data.msg;
                        switch(code){
                            case 1:
                                layer.alert(msg, {icon: 6,shade: false}, function(index){
                                    location.href = 'partner_list.php';
                                });
                                break;
                            default:
                                layer.alert(msg, {icon: 5});
                        }
                    }
                });

            });


            //修改用户
            $('#edit').click(function(){
                //start数据检查
                var name            = $('input[name=name]').val();
                var company         = $('input[name=company]').val();
                var nikname         = $('input[name=nikname]').val();
                var openid          = $('input[name=openid]').val();
                var state           = $('#partner_state').val();
                var phone           = $('input[name=phone]').val();
                var address         = $('input[name=address]').val();
                var qrcode          = $('input[name=qrcode]').val();
                var product         = $('input[name=product]').val();


                if(name == ''){
                    layer.msg('真实姓名不能为空');
                    return false;
                }
                if(nikname == ''){
                    layer.msg('微信呢称不能为空');
                    return false;
                }
                if(openid == ''){
                    layer.msg('微信标识码不能为空');
                    return false;
                }
                if(state == ''){
                    layer.msg('处理状态不能为空');
                    return false;
                }
                if(phone == ''){
                    layer.msg('联系电话不能为空');
                    return false;
                }
                if(address == ''){
                    layer.msg('详细地址不能为空');
                    return false;
                }
                if(qrcode  == ''){
                    layer.msg('转账二维码不能为空');
                    return false;
                }

                //end数据检查
                $.ajax({
                    type : 'POST',
                    data : {
                        name           : name,
                        company        : company,
                        nikname        : nikname,
                        openid         : openid,
                        state          : state,
                        phone          : phone,
                        address        : address,
                        qrcode         : qrcode,
                        product        : product,
                        id         : <?php echo $partner_id?>
                    },
                    dataType : 'json',
                    url      : 'partner_do.php?act=edit_nopass',
                    success  : function(data){

                        var code = data.code;
                        var msg  = data.msg;
                        switch(code){
                            case 1:
                                layer.alert(msg, {icon: 6,shade: false}, function(index){
                                    location.href = 'partner_list.php';
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
        <div id="position">当前位置：<a href="partner_list.php">加盟商管理</a> &gt; 修改加盟商</div>
        <div id="formlist">
            <p>
                <label>真实姓名</label>
                <input name="name" type="text" class="text-input input-length-20" value="<?php echo $partner_name?>"/>
                <span class="warn-inline">*</span>
            </p>
            <p>
                <label>加盟商店铺名</label>
                <input name="company" type="text" class="text-input input-length-20" value="<?php echo $partner_company?>"/>
                <span class="warn-inline">*</span>
            </p>
            <p>
                <label>微信昵称</label>
                <input name="nikname" type="text" class="text-input input-length-20" value="<?php echo $partner_nikname?>"/>
                <span class="warn-inline">*</span>
            </p>
            <p>
                <label>微信识别号</label>
                <input name="openid" type="text" class="text-input input-length-30" value="<?php echo $partner_openid?>"/>
                <span class="warn-inline">*</span>
            </p>
            <?php if(empty($partner_password)):?>
            <p>
                <label>登陆账号</label>
                <input name="account" type="text" class="text-input input-length-20" value="<?php echo $partner_account?>"/>
                <span class="warn-inline">*</span>
            </p>
            <p>
                <label>登陆密码</label>
                <input name="password" type="text" class="text-input input-length-20" value="<?php echo $partner_password?>"/>
                <span class="warn-inline">*</span>
            </p>
        <?php endif;?>
            <p>
                <label>审核状态</label>
                <select name="state" class="select-option" id="partner_state">
                    <option value="0" <?php if($partner_state == 0) echo ' selected ';?>>待审核</option>
                    <option value="1" <?php if($partner_state == 1) echo ' selected ';?>>已审核</option>
                </select>
            </p>
            <p>
                <label>电话</label>
                <input name="phone" type="text" class="text-input input-length-10" value="<?php echo $partner_phone?>"/>
                <span class="warn-inline">*</span>
            </p>
             <p>
                <label>详细住址</label>
                <input name="address" type="text" class="text-input input-length-30" value="<?php echo $partner_address?>"/>
                <span class="warn-inline">*</span>
            </p>
            
            <p>
                <label>转账二维码</label>
                <input name="qrcode" type="text" value="<?php echo $partner_qrcode?>" readonly="readonly" class="text-input input-length-30 readonlyinput" value=""/>
                <span class="warn-inline">*</span>
                <span class="fileinput">更换图片
                <input type="file" name="picfile" id="picfile" />
                </span>
                <span class="fileloading"></span>
                <span class="warn-block">* 文件格式：jpg。文件大小：<200KB。图片尺寸：宽200px高150px。</span>
                <span class="warn-block" id="picpreview"><img src="<?php echo $HTTP_PATH.$partner_qrcode?>" width="100"/></span>
            </p>
            <p>
             <p>
                <label>预售产品信息</label>
                <input name="product" type="text" class="text-input input-length-30" value="<?php echo $partner_product?>"/>
                <span class="warn-inline">*</span>
            </p>
             <?php if(!empty($partner_password)):?>
            <p>
                <label>&nbsp;</label>
               
                <input type="button" class="btn_submit" id="edit"  value="修  改" />
                
            </p>
        <?php endif;?>

        <?php if(empty($partner_password)):?>
            <p>
                <label>&nbsp;</label>
               
                <input type="button" class="btn_submit" id="submit" value=" 提 交" />
                
            </p>
        <?php endif;?>
        </div>

    </div>
    <div class="clear"></div>
</div>
<?php include('footer.inc.php');?>
</body>
</html>