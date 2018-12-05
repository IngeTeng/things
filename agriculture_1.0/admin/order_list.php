<?php
/**
 * 订单列表  order_list.php
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

$FLAG_LEFTMENU  = 'order_list';

if(!empty($_GET['nikname'])){
    $s_nikname  = safeCheck($_GET['nikname'], 0);
}else{
    $s_nikname  = '';
}

if(!empty($_GET['pay_id'])){
    $s_pay_id  = safeCheck($_GET['pay_id'], 0);
}else{
    $s_pay_id  = '';
}





?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="author" content="Neptune工作室" />
    <title>订单 - 订单设置 - 管理系统 </title>
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


            $('#downloadorder').click(function () {
                location.href = 'order_download.php';
            });
            //查询
            $('#searchorder').click(function(){

                s_nikname           = $('#search_nikname').val();
        
                s_pay_id            = $('#search_pay_id').val();
                location.href='order_list.php?nikname='+s_nikname+'&pay_id='+s_pay_id;
            });

            //删除商品
            $(".delete").click(function () {
                var thisid = $(this).parent('td').find('#orderid').val();
                layer.confirm('确认删除该订单信息吗？删除该信息可能造成平台混乱', {
                        btn: ['确认', '取消']
                    }, function () {
                        var index = layer.load(0, {shade: false});
                        $.ajax({
                            type: 'POST',
                            data: {
                                id: thisid
                            },
                            dataType: 'json',
                            url: 'order_do.php?act=del',
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



            //发货
            $(".post").click(function () {
                var thisid = $(this).parent('td').find('#order_id').val();
                layer.confirm('确认要发货吗？', {
                        btn: ['确认', '取消']
                    }, function () {
                        var index = layer.load(0, {shade: false});
                        $.ajax({
                            type: 'POST',
                            data: {
                                id: thisid
                            },
                            dataType: 'json',
                            url: 'order_do.php?act=post',
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
                    layer.tips('订单详情', $(this), {
                        tips: [4, '#3595CC'],
                        time: 500
                    });
                });
    
            $(".post").mouseover(function(){
                layer.tips('发货', $(this), {
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
    <?php include('order_menu.inc.php');?>
        <div id="maincontent">
            <div id="position">当前位置：<a href="order_list.php">订单管理</a> > 订单设置</div>
            <div id="handlelist">
                <?php
                //初始化
                $totalcount= Order::search(0, 0,  $s_pay_id,$s_nikname, 1);
                $shownum   = 5;
                $pagecount = ceil($totalcount / $shownum);
                $page      = getPage($pagecount);//点击页码之后在这函数里面获取页码
                $rows      = Order::search($page, $shownum, $s_pay_id,$s_nikname);
                ?>
    
             

             <input class="order-input" placeholder="订单号"  name="search_pay_id" id="search_pay_id" value="<?php echo $s_pay_id?>" style="width:20%;height:16px;" type="text">

            <input class="order-input" placeholder="微信昵称"  name="search_nikname" id="search_nikname" value="<?php echo $s_nikname?>" style="width:20%;height:16px;" type="text">


                <input style="margin-left:10px" class="btn-handle" id="searchorder" value="查询" type="button">

               <span class="table_info"><input type="button" class="btn-handle" id="downloadorder" value="下载订单信息"/></span>
                <div>
                </div>
            </div>
            <div class="tablelist" >
            <table>
                <tr>
                    <th>订单号</th>
                    <th>微信识别码</th>
                    <th>微信昵称</th>
                    <th>收货人姓名</th>
                    <th>联系方式</th>
                    <th width="20%">收货地址</th>
                    <th>订单状态</th>
                    <th>添加时间</th>
                    <th>操作</th>
                </tr>
                <?php

                $i=1;
                //  var_dump($rows);
                if(!empty($rows)){//如果列表不为空
                    foreach($rows as $row){
                        $createtime           = date('Y-m-d H:m', $row['createtime']);
                        //$order_detail         = Order_detail::getInfoById($row['pay_id']);
                        //$address              = Address::getInfoById($row['addressid']);

                         $state              = Order::getStateName($row['state']);
                        echo '<tr>          
                        
                                            <td class="center">'.$row['pay_id'].'</td>
                                            <td class="center">'.$row['openid'].'</td>
                                            <td class="center">'.$row['nikname'].'</td>
                                            <td class="center">'.$row['address_name'].'</td>
                                            <td class="center">'.$row['address_phone'].'</td>
                                            <td class="center">'.$row['address_area'].'<br>'.$row['address'].'</td>
                                           <td class="center">'.$state.'</td>
                                            <td class="center">'.$createtime.'</td> 
                                                        
                                            <td class="center">                            <a class="see" href="order_detail_list.php?payid='.$row['pay_id'].'"><img src="images/dot_see.png"/></a>   
            
                                                <a class="delete" href="javascript:void(0);"><img src="images/dot_del.png"/></a>
                                                <input type="hidden" id="orderid" value="'.$row['pay_id'].'"/>
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
