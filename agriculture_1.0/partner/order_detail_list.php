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

/*$POWERID        = '7001';
Admin::checkAuth($POWERID, $ADMINAUTH);
require_once('order_init.php');*/
$FLAG_TOPNAV    = "role";

$FLAG_LEFTMENU  = 'order_detail_list';

if(!empty($_GET['payid'])){
    $s_payid  = safeCheck($_GET['payid']);
}else{
    $s_payid  = '';
}

if(!empty($_GET['state'])){
    $s_state  = safeCheck($_GET['state']);
}else{
    $s_state  = 0;
}

if(!empty($_GET['begin_time'])){
    $s_begin_time  = safeCheck($_GET['begin_time'],0);
}else{
    $s_begin_time  = 0;
}

if(!empty($_GET['end_time'])){
    $s_end_time  = safeCheck($_GET['end_time'],0);
}else{
    $s_end_time  = 0;
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
    <script src="laydate/laydate.js"></script>
    <script src="js/Vague.js"></script>
  
    <script type="text/javascript">
        $(function() {

            //查询
            $('#searchorder_detail').click(function(){

                s_payid           = $('#search_payid').val();
                s_state           = $('#search_state').val();
                s_begin_time      = $('#begin_time').val();
                s_end_time        = $('#end_time').val();
                location.href='order_detail_list.php?payid='+s_payid+'&state='+s_state+'&begin_time='+s_begin_time+'&end_time='+s_end_time;
            });


            //日期组件
                laydate({
                    elem: '#begin_time', //需显示日期的元素选择器
                    event: 'click', //触发事件
                    format: 'YYYY-MM-DD hh:mm:ss', //日期格式
                    //format: 'YYYY', //日期格式
                    istime: true, //是否开启时间选择
                    isclear: true, //是否显示清空
                    istoday: true, //是否显示今天
                    issure: true, //是否显示确认
                    festival:true, //是否显示节日
                    //min: '1900-01-01 00:00:00', //最小日期
                    //max: '2099-12-31 23:59:59', //最大日期
                    //start: '2014-6-15 23:00:00',    //开始日期
                    //fixed: false, //是否固定在可视区域
                    //zIndex: 99999999, //css z-index
                    choose: function(dates){ //选择好日期的回调
                    }
                });


                 laydate({
                    elem: '#end_time', //需显示日期的元素选择器
                    event: 'click', //触发事件
                    format: 'YYYY-MM-DD hh:mm:ss', //日期格式
                    //format: 'YYYY', //日期格式
                    istime: true, //是否开启时间选择
                    isclear: true, //是否显示清空
                    istoday: true, //是否显示今天
                    issure: true, //是否显示确认
                    festival: true, //是否显示节日
                    //min: '1900-01-01 00:00:00', //最小日期
                    //max: '2099-12-31 23:59:59', //最大日期
                    //start: '2014-6-15 23:00:00',    //开始日期
                    //fixed: false, //是否固定在可视区域
                    //zIndex: 99999999, //css z-index
                    choose: function(dates){ //选择好日期的回调
                    }
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
    <?php include('role_menu.inc.php');?>
        <div id="maincontent">
            <div id="position">当前位置：<a href="order_detail_list.php">订单管理</a> > 订单设置</div>
            <div id="handlelist">
                <?php
                //初始化
                $phone     = $PARTNER->getPhone();
                $totalcount= table_order_detail::search_phone(0, 0,  $s_state,$phone, $s_payid,$s_begin_time, $s_end_time, 1);
                $shownum   = 10;
                $pagecount = ceil($totalcount / $shownum);
                $page      = getPage($pagecount);//点击页码之后在这函数里面获取页码
                $rows      = table_order_detail::search_phone($page, $shownum,  $s_state,$phone, $s_payid ,$s_begin_time, $s_end_time);
                ?>
    
                
                <select name="search_state" id="search_state" class="select-option" style="width:10%;height:30px;" >
                    <option value="0" <?php if($s_state == 0) echo 'selected'?>>所有状态</option>
                    <option value="1" <?php if($s_state == 1) echo 'selected'?>>待付款</option>
                    <option value="2" <?php if($s_state == 2) echo 'selected'?>>待发货</option>
                    <option value="3" <?php if($s_state == 3) echo 'selected'?>>已发货</option>
                    <option value="4" <?php if($s_state == 4) echo 'selected'?>>交易完成</option>
                </select>
                <input class="order-input" placeholder="订单号查询"  name="search_payid" id="search_payid" value="<?php echo $s_payid?>" style="width:20%;height:16px;" type="text">
                
                <input  type="text" placeholder="选择起始时间" class="order-input" style="width:15%;height:16px;"  name="begin_time" id="begin_time" value="<?php echo $begin_time;?>" />

                <input  type="text" placeholder="选择终止时间" class="order-input" style="width:15%;height:16px;"  name="end_time" id="end_time" value="<?php echo $end_time;?>"/>

                <input style="margin-left:10px" class="btn-handle" id="searchorder_detail" value="查询" type="button">
                
                 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;  &nbsp;&nbsp; &nbsp;  &nbsp;&nbsp; &nbsp;  
                 <lable  type="text"   style="width:15%;height:20px;" id="total_money"></lable>
                   
                <span class="table_info">
                   
                    <input type="button" class="btn-handle" id="total" value="合计"/>
                </span>
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
                    <th>订单状态</th>
                    <th>操作</th>
                </tr>
                <?php

                $i=1;
                //  var_dump($rows);
                if(!empty($rows)){//如果列表不为空
                    foreach($rows as $row){
            
                        $pic                  = $HTTP_PATH.$row['product_img'];
                        $state                = Order_detail::getStateName($row['state']);
                        $order_info           = Order::getInfoByPayid($row['payid']);
                        $total = $total+$row['total'];
                        $total = number_format($total , 2);
                        echo '<tr>          
                        
                                            <td class="center">'.$row['payid'].'</td>
                                            <td class="center">
                                                <div id="wrap">
                                                    <a href="'.$pic.'" class="framer">
                                                         <img src="'.$pic.'" width="50" height="50" />
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
  <script type="text/javascript">
  $(function(){
         $('#total').click(function(){

                s_total             = '<?php echo $total;?>';
                console.log(s_total);
                //s_pay_id            = $('#search_pay_id').val();
                //location.href='order_list.php?nikname='+s_nikname+'&pay_id='+s_pay_id;
                $('#total_money').html(s_total+'元');
            });
  });
  </script>
</body>
</html>
