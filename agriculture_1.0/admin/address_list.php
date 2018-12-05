<?php
/**
 * 地址列表 address_list.php
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
require_once('order_init.php');
$FLAG_TOPNAV    = "order";

$FLAG_LEFTMENU  = 'address_list';



if(!empty($_GET['nikname'])){
    $s_nikname  = safeCheck($_GET['nikname'], 0);
}else{
    $s_nikname  = '';
}

if(!empty($_GET['name'])){
    $s_name  = safeCheck($_GET['name'],0);
}else{
    $s_name  = '';
}

if(!empty($_GET['phone'])){
    $s_phone  = safeCheck($_GET['phone']);
}else{
    $s_phone = '';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="author" content="Neptune工作室" />
    <title>地址 - 订单设置 - 管理系统 </title>
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

         /*   //添加地址
            $('#addproduct').click(function () {
                location.href = 'product_add.php';
            });

            $('#downloadproduct').click(function () {
                location.href = 'product_download.php';
            });*/
            //查询
            $('#searchaddress').click(function(){

                s_nikname       = $('#search_nikname').val();
                s_name          = $('#search_name').val();
                s_phone         = $('#search_phone').val();
                location.href='address_list.php?nikname='+s_nikname+'&name='+s_name+'&phone='+s_phone;
            });

            //删除
            $(".delete").click(function () {
                var thisid = $(this).parent('td').find('#addressid').val();
                layer.confirm('确认删除该地址信息吗？', {
                        btn: ['确认', '取消']
                    }, function () {
                        var index = layer.load(0, {shade: false});
                        $.ajax({
                            type: 'POST',
                            data: {
                                id: thisid
                            },
                            dataType: 'json',
                            url: 'address_do.php?act=del',
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
             /*$(".see").mouseover(function(){
                    layer.tips('查看详情', $(this), {
                        tips: [4, '#3595CC'],
                        time: 500
                    });
                });
    */
           /* $(".editinfo").mouseover(function(){
                layer.tips('修改', $(this), {
                    tips: [4, '#3595CC'],
                    time: 500
                });
            });*/

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
    <?php include('order_menu.inc.php');?>
        <div id="maincontent">
            <div id="position">当前位置：<a href="address_list.php">地址管理</a> > 分销商设置</div>
            <div id="handlelist">
                <?php
                //初始化
                $totalcount= Address::search(0, 0, $s_nikname, $s_name,$s_phone, 1);
                $shownum   = 15;
                $pagecount = ceil($totalcount / $shownum);
                $page      = getPage($pagecount);//点击页码之后在这函数里面获取页码
                $rows      = Address::search($page, $shownum, $s_nikname, $s_name,$s_phone);
                ?>
    
            
                <input class="order-input" placeholder="微信昵称"  name="search_nikname" id="search_nikname" value="<?php echo $s_nikname?>" style="width:10%;height:16px;" type="text">

                <input class="order-input" placeholder="收货人姓名"  name="search_name" id="search_name" value="<?php echo $s_name?>" style="width:10%;height:16px;" type="text">

                <input class="order-input" placeholder="收货人电话"  name="search_phone" id="search_phone" value="<?php echo $s_phone?>" style="width:10%;height:16px;" type="text">

                <input style="margin-left:10px" class="btn-handle" id="searchaddress" value="查询" type="button">

                <div>
                </div>
            </div>
            <div class="tablelist" >
            <table>
                <tr>
                    <th>微信识别码</th>
                    <th>微信昵称</th>
                    <th>收货人姓名</th>
                    <th>收货人电话</th>
                    <th>收货详细地址</th>
                    <th>收货区域</th>
                    <th>邮政编码</th>
                    <th>添加时间</th>
                    <th>操作</th>
                </tr>
                <?php

                $i=1;
                //  var_dump($rows);
                if(!empty($rows)){//如果列表不为空
                    foreach($rows as $row){

                        $createtime     = date('Y-m-d H:m', $row['createtime']);
        
                        echo '<tr>          
            
                                            <td class="center">'.$row['openid'].'</td>
                                            <td class="center">'.$row['nikname'].'</td>
                                            <td class="center">'.$row['name'].'</td>
                                            <td class="center">'.$row['phone'].'</td>
                                            <td class="center">'.$row['address'].'</td>
                                            <td class="center">'.$row['area'].'</td>
                                            <td class="center">'.$row['postcode'].'</td>
                                            <td class="center">'.$createtime.'</td> 
                                                        
                                            <td class="center">                               
                                                <a class="delete" href="javascript:void(0);"><img src="images/dot_del.png"/></a>
                                                <input type="hidden" id="addressid" value="'.$row['id'].'"/>
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
