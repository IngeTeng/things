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

$FLAG_LEFTMENU  = 'order_detail_list';

if(!empty($_GET['payid'])){
    $s_payid  = safeCheck($_GET['payid'],0);
}else{
    $s_payid  = '';
}

if(!empty($_GET['state'])){
    $s_state  = safeCheck($_GET['state']);
}else{
    $s_state  = 0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="author" content="Neptune工作室" />
    <title>订单详情 - 订单设置 - 管理系统 </title>
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

            //查询
            $('#searchorder_detail').click(function(){

                s_payid           = $('#search_payid').val();
                s_state           = $('#search_state').val();
                location.href='order_detail_list.php?payid='+s_payid+'&state='+s_state;
            });

            //删除商品
            $(".delete").click(function () {
                var thisid = $(this).parent('td').find('#order_detailid').val();
                layer.confirm('确认删除该订单信息吗？删除可能会造成平台混乱', {
                        btn: ['确认', '取消']
                    }, function () {
                        var index = layer.load(0, {shade: false});
                        $.ajax({
                            type: 'POST',
                            data: {
                                id: thisid
                            },
                            dataType: 'json',
                            url: 'order_detail_do.php?act=del',
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
                var thisid = $(this).parent('td').find('#order_detail_id').val();
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
                            url: 'order_detail_do.php?act=post',
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
             $(".post").mouseover(function(){
                    layer.tips('确认发货', $(this), {
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
    <?php include('order_menu.inc.php');?>
        <div id="maincontent">
            <div id="position">当前位置：<a href="order_detail_list.php">订单管理</a> > 订单设置</div>
            <div id="handlelist">
                <?php
                //初始化
                $totalcount= Order_detail::search(0, 0,  $s_state, $s_payid, 1);
                $shownum   = 10;
                $pagecount = ceil($totalcount / $shownum);
                $page      = getPage($pagecount);//点击页码之后在这函数里面获取页码
                $rows      = Order_detail::search($page, $shownum,  $s_state, $s_payid);
                ?>
    
                
                <select name="search_state" id="search_state" class="select-option" style="width:10%;height:30px;" >
                    <option value="0" <?php if($s_state == 0) echo 'selected'?>>所有状态</option>
                    <option value="1" <?php if($s_state == 1) echo 'selected'?>>待付款</option>
                    <option value="2" <?php if($s_state == 2) echo 'selected'?>>待发货</option>
                    <option value="3" <?php if($s_state == 3) echo 'selected'?>>已发货</option>
                    <option value="4" <?php if($s_state == 4) echo 'selected'?>>交易完成</option>
                </select>
                <input class="order-input" placeholder="订单号查询"  name="search_payid" id="search_payid" value="<?php echo $s_payid?>" style="width:20%;height:16px;" type="text">


                <input style="margin-left:10px" class="btn-handle" id="searchorder_detail" value="查询" type="button">
                <div>
                </div>
            </div>
            <div class="tablelist" >
            <table>
                <tr>
                    <th>订单号</th>
                    <th>商品图片</th>
                    <th>商品名称</th>
                    <th>商品原价格</th>
                    <th>促销价格</th>
                    <th>物流单价</th>
                    <th>购买数量</th>
                    <th>订单总额</th>
                    <th>收货人姓名</th>
                    <th>收货人电话</th>
                    <th>收货地址</th>
                    <th>销售店铺</th>
                    <th>订单状态</th>
                    <th>操作</th>
                </tr>
                <?php

                $i=1;
                //  var_dump($rows);
                if(!empty($rows)){//如果列表不为空
                    foreach($rows as $row){
            
                        //$product              = Product::getInfoById($row['productid']);
                        //$pic                  = $HTTP_PATH.$product['pic'];
                        $state                = Order_detail::getStateName($row['state']);
                        $order_info           = Order::getInfoByPayid($row['payid']);
                        $partner              = table_partner::getInfoByPhone($row['product_add_phone']);
                        $company              = $partner['company'].':'.$partner['name'];
                        if(empty($partner)){
                            $admin = table_admin::getInfoByPhone($row['product_add_phone']);
                            //var_dump($admin);
                            $company = '延鑫平台:'.$admin['name'];
                        }

                        echo '<tr>          
                        
                                            <td class="center">'.$row['payid'].'</td>
                                            <td class="center">
                                                <div id="wrap">
                                                    <a href="'.$HTTP_PATH.$row['product_img'].'" class="framer">
                                                         <img src="'.$HTTP_PATH.$row['product_img'].'" width="50" height="50" />
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="center">'.$row['product_title'].'</td>
                                            <td class="center">'.$row['product_price'].'</td>
                                            <td class="center">'.$row['product_sale_price'].'</td>
                                             <td class="center">'.$row['product_post_price'].'</td>
                                            <td class="center">'.$row['num'].'</td>
                                            <td class="center">'.$row['total'].'</td>
                                            <td class="center">'.$order_info['address_name'].'</td>
                                            <td class="center">'.$order_info['address_phone'].'</td>
                                            <td class="center">'.$order_info['address_area'].$order_info['address'].'</td>
                                            <td class="center">'.$company.'</td>
                                            <td class="center">'.$state.'</td>
                                                        
                                            <td class="center">
                                            <a class="post" href="javascript:void(0);"><img src="images/dot_post.png"/></a>
                                                <input type="hidden" id="order_detail_id" value="'.$row['id'].'"/>
                                            <a class="delete" href="javascript:void(0);"><img src="images/dot_del.png"/></a>
                                                <input type="hidden" id="order_detailid" value="'.$row['id'].'"/>
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
