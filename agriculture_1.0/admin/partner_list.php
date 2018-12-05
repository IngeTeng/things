<?php
/**
 * 管理员列表  user_list.php
 *
 * @version       v0.01
 * @create time   2016-11-14
 * @update time   2016-11-15
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */
require_once('admin_init.php');
require_once('admincheck.php');

$POWERID        = '7001';
Admin::checkAuth($POWERID, $ADMINAUTH);

$FLAG_TOPNAV    = "role";
$FLAG_LEFTMENU  = 'partner_list';

if(!empty($_GET['company'])){
    $s_company  = safeCheck($_GET['company'], 0);
}else{
    $s_company  = '';
}

if(!empty($_GET['name'])){
    $s_name  = safeCheck($_GET['name'], 0);
}else{
    $s_name  = '';
}

if(!empty($_GET['phone'])){
    $s_phone  = safeCheck($_GET['phone']);
}else{
    $s_phone  = '';
}

/*    //$length = table_partner::lastID();
    $length[0][0]=14;*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="author" content="Neptune工作室" />
    <title>加盟商 - 加盟商设置 - 管理系统 </title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <link rel="stylesheet" href="css/form.css" type="text/css" />
    <link rel="stylesheet" href="css/boxy.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery.Framer.css" type="text/css" />
    <!-- <link rel="stylesheet" href="css/round_shade.css" type="text/css"/>  -->
    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.Framer.js"></script>
   <!-- <scr ipt type="text/javascript" src="js/content_zoom.js"></script>   -->
    <script type="text/javascript" src="js/layer/layer.js"></script>
    <script type="text/javascript" src="js/common.js"></script>
    <script src="js/Vague.js"></script>
    <script type="text/javascript">
/*$(document).ready(function() {

        for(var i=0 ; i<<?php echo $length[0][0];?>;i++){
        $('#zoom_word_'+i).fancyZoom({width:400, height:200});
            }
});*/
</script>
    <script type="text/javascript">

        $(function() {
            
            //添加用户
            $('#addpartner').click(function () {
                location.href = 'partner_add.php';
            });

            $('#downloadpartner').click(function () {
                location.href = 'partner_download.php';
            });
            //查询
            $('#searchpartner').click(function(){

                s_company  = $('#search_company').val();
                s_name  = $('#search_name').val();
                s_phone  = $('#search_phone').val();
                location.href='partner_list.php?company='+s_company+'&name='+s_name+'&phone='+s_phone;
            });
                //重置密码
                $(".reset").click(function(){
                    var thisid = $(this).parent('td').find('#partnerid').val();
                    layer.confirm('确认重置该加盟商账号的密码吗？', {
                        btn: ['确认','取消']
                        }, function(){
                            var index = layer.load(0, {shade: false});
                            $.ajax({
                                type        : 'POST',
                                data        : {
                                    id:thisid
                                },
                                dataType :    'json',
                                url :         'partner_do.php?act=reset',
                                success : function(data){
                                                layer.close(index);
                                                
                                                code = data.code;
                                                msg  = data.msg;
                                                switch(code){
                                                    case 1:
                                                        layer.alert(msg, {icon: 6}, function(index){
                                                            location.reload();
                                                        });
                                                        break;
                                                    default:
                                                        layer.alert(msg, {icon: 5});
                                                }
                                            }
                            });
                        }, function(){}
                    );
                });
            //删除用户
            $(".delete").click(function () {
                var thisid = $(this).parent('td').find('#partnerid').val();
                layer.confirm('确认删除该加盟商信息吗？', {
                        btn: ['确认', '取消']
                    }, function () {
                        var index = layer.load(0, {shade: false});
                        $.ajax({
                            type: 'POST',
                            data: {
                                id: thisid
                            },
                            dataType: 'json',
                            url: 'partner_do.php?act=del',
                            success: function (data) {
                                layer.close(index);

                                code = data.code;
                                msg = data.msg;
                                switch (code) {
                                    case 1:
                                        layer.alert(msg, {icon: 6}, function (index) {
                                            location.reload();
                                        });
                                        break;
                                    default:
                                        layer.alert(msg, {icon: 5});
                                }
                            }
                        });
                    }, function () {
                    }
                );
            });
             $(".see").mouseover(function(){
                    layer.tips('查看详情', $(this), {
                        tips: [4, '#3595CC'],
                        time: 500
                    });
                });
            $(".reset").mouseover(function(){
                    layer.tips('重置密码', $(this), {
                        tips: [4, '#3595CC'],
                        time: 500
                    });
                });
            $(".editinfo").mouseover(function(){
                layer.tips('修改', $(this), {
                    tips: [4, '#3595CC'],
                    time: 500
                });
            });

            $(".delete").mouseover(function(){
                layer.tips('删除', $(this), {
                    tips: [4, '#3595CC'],
                    time: 500
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
            <div id="position">当前位置：<a href="partner_list.php">加盟商管理</a> > 加盟商设置</div>
            <div id="handlelist">
                <?php
                //初始化
                $totalcount= Partner::search(0, 0,$s_company, $s_name, $s_phone, 1);
                $shownum   = 5;
                $pagecount = ceil($totalcount / $shownum);
                $page      = getPage($pagecount);//点击页码之后在这函数里面获取页码
                $rows      = Partner::search($page, $shownum,$s_company, $s_name,$s_phone);
                ?>
                <!-- <input type="button" class="btn-handle" href="javascript:" id="addpartner" value="添 加"> -->
                 <input type="button" class="btn-handle" href="javascript:" id="downloadpartner" value="下载加盟商信息">

                <input class="order-input" placeholder="加盟商店铺名"  name="search_company" id="search_company" value="<?php echo $s_company?>" style="width:15%;height:16px;" type="text">  

                <input class="order-input" placeholder="加盟商电话"  name="search_phone" id="search_phone" value="<?php echo $s_phone?>" style="width:15%;height:16px;" type="text">

                <input class="order-input" placeholder="加盟商姓名"  name="search_name" id="search_name" value="<?php echo $s_name?>" style="width:15%;height:16px;" type="text">
                <input style="margin-left:10px" class="btn-handle" id="searchpartner" value="查询" type="button">
                <span class="table_info">共<?php echo $totalcount;?>条数据</span>
                <div>
                </div>
            </div>
            <div class="tablelist" >
            <table>
                <tr>
                    <th>加盟商店铺名</th>
                    <th>加盟商姓名</th>
                    <th>微信昵称</th>
                    <th>微信识别码</th>
                    <th>登陆账号</th>
                    <th>电话</th>
                    <th>转账二维码</th>
                    <th>审核状态</th>
                    <th>申请时间</th>
                    <th>操作</th>
                </tr>
                <?php

                $i=1;
                //  var_dump($rows);
                if(!empty($rows)){//如果列表不为空
                    foreach($rows as $row){
                        $qrcode     = $HTTP_PATH.$row['qrcode'];
                        $createtime = date('Y-m-d H:m', $row['createtime']);
                        $state      = Partner::getStateName($row['state']);
                        echo '<tr>          
                                            <td class="center">'.$row['company'].'</td>
                                            <td class="center">'.$row['name'].'</td>
                                            <td class="center">'.$row['nikname'].'</td>
                                            <td class="center">'.$row['openid'].'</td>

                                            <td class="center">'.$row['account'].'</td>
                                            

                                            <td class="center">'.$row['phone'].'</td> 
                                            <td class="center">
                                            <div id="wrap">
                                            <a href="'.$qrcode.'" class="framer">
                                            <img src="'.$qrcode.'" width="100" height="100" />
                                            </a>
                                            </div>
                                            </td>
                                            <td class="center">'.$state.'</td>                                  
                                            <td class="center">'.$createtime.'</td>                                 
                                            <td class="center">                                    <a class="see" href="partner_detail.php?id='.$row['id'].'"><img src="images/dot_see.png"/></a>
                                                <a href="javascript:void(0)" class="reset"><img src="images/dot_reset.png" /></a>         
                                                <a class="editinfo" href="partner_edit.php?id='.$row['id'].'"><img src="images/dot_edit.png"/></a> 
                                                <a class="delete" href="javascript:void(0);"><img src="images/dot_del.png"/></a>
                                                <input type="hidden" id="partnerid" value="'.$row['id'].'"/>
                                            </td>
                                        </tr>
                                    ';
                        $i++;
                    }
                }else{
                    echo '<tr><td class="center" colspan="8">没有数据</td></tr>';
                }
                ?>


            </table>
        </div>
            <div id="pagelist">
            <div class="pageinfo">
                <span class="table_info">共<?php echo $totalcount;?>条数据，共<?php echo $pagecount;?>页</span>
            </div>
            <?php
            if($pagecount>1){
                echo dspPages(getPageUrl(), $page, $shownum, $totalcount, $pagecount);
            }
            ?>
        </div>
        </div>
    <div class="clear"></div>
</div>


<?php include('footer.inc.php');?>
  <script src="js/sample.js"></script>
<!-- <div id="zoom_word_one" style="display:none;">400像素宽度层示例：这里文字内容放大的层的宽度是需要给定值进行控制的，因为图片的高度和宽度可以获取到，而内容不确定的DIV层的高宽是获取不到了，给定高宽值，然后文字内容就会在这块区域内显示。</div> -->
</body>
</html>