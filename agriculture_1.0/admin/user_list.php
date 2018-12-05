<?php
/**
 * 用户列表  user_list.php
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
$FLAG_LEFTMENU  = 'user_list';

if(!empty($_GET['nikname'])){
    $s_nikname  = safeCheck($_GET['nikname'], 0);
}else{
    $s_nikname  = '';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="author" content="Neptune工作室" />
    <title>用户 - 用户设置 - 管理系统 </title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <link rel="stylesheet" href="css/form.css" type="text/css" />
    <link rel="stylesheet" href="css/boxy.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery.Framer.css" type="text/css" />
    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.Framer.js"></script>
    <script type="text/javascript" src="js/layer/layer.js"></script>
    <script type="text/javascript" src="js/common.js"></script>
    <script src="js/Vague.js"></script>
    <script type="text/javascript">
        $(function() {
            //添加用户
            $('#adduser').click(function () {
                location.href = 'user_add.php';
            });

            $('#downloaduser').click(function () {
                location.href = 'user_download.php';
            });
            //查询
            $('#searchuser').click(function(){

                s_nikname  = $('#search_nikname').val();

                location.href='user_list.php?nikname='+s_nikname;
            });
            //删除用户
            $(".delete").click(function () {
                var thisid = $(this).parent('td').find('#userid').val();
                layer.confirm('确认删除该用户信息吗？', {
                        btn: ['确认', '取消']
                    }, function () {
                        var index = layer.load(0, {shade: false});
                        $.ajax({
                            type: 'POST',
                            data: {
                                id: thisid
                            },
                            dataType: 'json',
                            url: 'user_do.php?act=del',
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
            <div id="position">当前位置：<a href="user_list.php">用户管理</a> > 用户设置</div>
            <div id="handlelist">
                <?php
                //初始化
                $totalcount= User::search(0, 0, $s_nikname,  1);
                $shownum   = 5;
                $pagecount = ceil($totalcount / $shownum);
                $page      = getPage($pagecount);//点击页码之后在这函数里面获取页码
                $rows      = User::search($page, $shownum, $s_nikname);
                ?>
                <!-- <input type="button" class="btn-handle" href="javascript:" id="adduser" value="添 加"> -->
                 <input type="button" class="btn-handle" href="javascript:" id="downloaduser" value="下载用户信息">
                
                <input class="order-input" placeholder="用户微信昵称"  name="search_nikname" id="search_nikname" value="<?php echo $s_nikname?>" style="width:15%;height:16px;" type="text">
                <input style="margin-left:10px" class="btn-handle" id="searchuser" value="查询" type="button">
                <span class="table_info">共<?php echo $totalcount;?>条数据</span>
                <div>
                </div>
            </div>
            <div class="tablelist">
            <table>
                <tr>
                    <th>用户头像</th>
                    <th>微信昵称</th>
                    <th>微信识别码</th>
                    <th>性别</th>
                    <th>注册时间</th>
                    <th>操作</th>
                </tr>
                <?php

                $i=1;
                //  var_dump($rows);
                if(!empty($rows)){//如果列表不为空
                    foreach($rows as $row){
                        $img     = $row['img'];
                        $createtime = date('Y-m-d H:m', $row['createtime']);
                        $sex = User::getSexName($row['sex']);
                        echo '<tr>          
                                            <td class="center">
                                            <img src="'.$img.'" width="65" height="50" />
                                            </td>
                            
                                            <td class="center">'.$row['nikname'].'</td>
                                            <td class="center">'.$row['openid'].'</td>
                                            <td class="center">'.$sex.'</td>                                     
                                            <td class="center">'.$createtime.'</td>                                 
                                            <td class="center">                                             
                                                <a class="delete" href="javascript:void(0);"><img src="images/dot_del.png"/></a>
                                                <input type="hidden" id="userid" value="'.$row['id'].'"/>
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
</body>
</html>