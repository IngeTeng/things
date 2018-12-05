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

$FLAG_LEFTMENU  = 'record_list';

if(!empty($_GET['phone'])){
    $s_phone  = safeCheck($_GET['phone'],0);
}else{
    $s_phone  = '';
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
    <title>统计详情 - 统计设置 - 管理系统 </title>
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

                s_phone                     = $('#search_phone').val();
                s_begin_time                = $('#begin_time').val();
                s_end_time                  = $('#end_time').val();
                location.href='record_list.php?phone='+s_phone+'&begin_time='+s_begin_time+'&end_time='+s_end_time;
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
            <div id="position">当前位置：<a href="order_detail_list.php">统计管理</a> > 统计设置</div>
            <div id="handlelist">
            
            <select name="search_phone" id="search_phone" class="select-option" style="width:20%;height:30px;">
                        <option value="0" <?php if($s_phone == '') echo 'selected'?>>经销商列表</option>
                        <?php
                            $partners = table_partner::getAllList();
                            if(!empty($partners)){
                                foreach($partners as $partner){
                                    echo '<option value="'.$partner['phone'].'"';
                                    if($s_phone == $partner['phone']) echo ' selected ';
                                    echo '>'.$partner['company'].'</option>';
                                }
                            }
                        ?>
            </select>
    
                <?php
                //初始化
                $totalcount= table_order_detail::search_record(0, 0,  $s_phone, $s_begin_time, $s_end_time,  1);
                $shownum   = 10;
                $pagecount = ceil($totalcount / $shownum);
                $page      = getPage($pagecount);//点击页码之后在这函数里面获取页码
                $rows      = table_Order_detail::search_record($page, $shownum,  $s_phone, $s_begin_time, $s_end_time );
                ?>
    
                <!-- <input class="order-input" placeholder="经销商电话"  name="search_phone" id="search_phone" value="<?php echo $s_phone;?>" style="width:20%;height:16px;" type="text"> -->

                <input  type="text" placeholder="选择起始时间" class="order-input" style="width:15%;height:16px;"  name="begin_time" id="begin_time" value="<?php echo $begin_time;?>" />

                <input  type="text" placeholder="选择终止时间" class="order-input" style="width:15%;height:16px;"  name="end_time" id="end_time" value="<?php echo $end_time;?>"/>

                <input style="margin-left:10px" class="btn-handle" id="searchorder_detail" value="查询" type="button">
                 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                 <lable  type="text"   style="width:15%;height:20px;" id="total_money"></lable>
                   
                <span class="table_info">
                   
                    <input type="button" class="btn-handle" id="total" value="合计"/>
                </span>
                <div>
                </div>
            </div>
            <div class="tablelist" >
            <table>
                <tr>
                    <th>订单号</th>
                    <th>商品图片</th>
                    <th>商品名称</th>
                    <th>商品分类</th>
                    <th>商品价格</th>
                    <th>物流单价</th>
                    <th>购买数量</th>
                    <th>订单总额</th>
                    <th>经销商店铺</th>
                    <th>转账二维码</th>
                    <th>购买时间</th>
                   <!--  <th>操作</th> -->
                </tr>
                <?php

                $i=1;
             
                if(!empty($rows)){//如果列表不为空
                    foreach($rows as $row){
            
                        $product              = Product::getInfoById($row['productid']);
                        $cate                 = Category::getInfoById($product['cateid']);
                        $state                = Order_detail::getStateName($row['state']);
                        $order_info           = Order::getInfoByPayid($row['payid']);
                        $partner              = table_partner::getInfoByPhone($row['product_add_phone']);
                        $company              = $partner['company'].':'.$partner['name'];
                        if(empty($partner)){
                            $admin = table_admin::getInfoByPhone($row['product_add_phone']);
                            //var_dump($admin);
                            $company = '延鑫平台:'.$admin['name'];
                        }

                        if($product['issale']==1){
                            $price = $product['sale_price'];
                        }else{
                            $price = $product['price'];
                        }

                        $total = $total + $row['total'];
                        $total = number_format($total , 2);
                        $createtime           = date('Y-m-d H:m', $row['createtime']);

                        $qrcode     = $HTTP_PATH.$partner['qrcode'];
                        if(!empty($partner)){
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
                                            <td class="center">'.$cate['title'].'</td>
                                            <td class="center">'.$price.'</td>
                                            <td class="center">'.$row['product_post_price'].'</td>
                                            <td class="center">'.$row['num'].'</td>
                                            <td class="center">'.$row['total'].'</td>
                                            <td class="center">'.$company.'</td>
                                            <td class="center">
                                                <div id="wrap">
                                                    <a href="'.$qrcode.'" class="framer">
                                                        <img src="'.$qrcode.'" width="100" height="100" />
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="center">'.$createtime.'</td>
                                                        
                                        </tr>
                                    ';
                                }else{
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
                                            <td class="center">'.$cate['title'].'</td>
                                            <td class="center">'.$price.'</td>
                                            <td class="center">'.$row['product_post_price'].'</td>
                                            <td class="center">'.$row['num'].'</td>
                                            <td class="center">'.$row['total'].'</td>
                                            <td class="center">'.$company.'</td>
                                            <td class="center">暂无图片</td>
                                            <td class="center">'.$createtime.'</td>
                                                        
                                        </tr>
                                    ';
                                }
                        $i++;
                    }
                }else{
                    echo '<tr><td class="center" colspan="8">没有数据</td></tr>';
                }


                //var_dump($total);
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
