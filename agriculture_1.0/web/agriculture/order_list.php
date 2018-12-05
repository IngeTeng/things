<?php 
require('../../conn.php');
require('../../config.inc.php');
require('../../wx_config.php');
$userInfo = getUserInfo();
$cate = '普通会员';
$cateid = 1;
//var_dump($userInfo['openid']);
$admin = table_admin::getInfoByOpenid($userInfo['openid']);
if(!empty($admin)){
    $cate = '延鑫管理员';
    $cateid = 2;
}
$partner = table_partner::getInfoByOpenid($userInfo['openid']);
//var_dump($partner);
if(!empty($partner)){
    $cate = '高级分销商';
    $cateid = 3;
}
if(!empty($_GET['choice'])){
    $choice = $_GET['choice'];
}else{
    $choice =0;
}

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>我的订单</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="amazeui/css/amazeui.min.css"/>
    <link rel="stylesheet" href="default/style.css"/>
    <script src="amazeui/js/jquery.min.js"></script>
    <script type="text/javascript" src="../../admin/js/layer/layer.js"></script>
    <script src="amazeui/js/amazeui.min.js"></script>
    <script>
        $(function() {
            $('#doc-my-tabs').tabs();
        })

        function cancel_order(id){
            
            $.ajax({
                            type: 'POST',
                            data: {
                                id: id,
                                openid : '<?php echo $userInfo['openid'];?>'
                            },
                            dataType: 'json',
                            url: 'order_do.php?act=del',
                            success: function (data) {
                                //layer.close(index);

                                code = data.code;
                                msg = data.msg;
                                switch (code) {
                                    case 1: 
                                    console.log('success');
                                        //$("#divid-"+id).remove();
                                        //$("#divid+"+id).remove();
                                        //delete_all(id);
                                       // document.getElementById("refresh").innerHTML='<div id="doc-my-tabs"></div>';
                                        layer.msg(msg);
                                       location.href = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/order_list.php");?>?choice=1&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect';
                                        
                                        break;
                                    default:
                                        layer.msg(msg);
                                }
                            }
                        });

        }

        function sureGet(id){
             $.ajax({
                            type: 'POST',
                            data: {
                                id: id,
                                openid : '<?php echo $userInfo['openid'];?>'
                            },
                            dataType: 'json',
                            url: 'order_do.php?act=sure',
                            success: function (data) {
                                //layer.close(index);

                                code = data.code;
                                msg = data.msg;
                                switch (code) {
                                    case 1: 
                                    console.log('success');
                                        //$("#divid-"+id).remove();
                                        //$("#divid+"+id).remove();
                                        //delete_all(id);
                                       // document.getElementById("refresh").innerHTML='<div id="doc-my-tabs"></div>';
                                        layer.msg(msg);
                                       location.href = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/order_list.php");?>?choice=4&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect';
                                        
                                        break;
                                    default:
                                        layer.msg(msg);
                                }
                            }
                        });

        }

        function comment(order_detailid,productid){
            var openid = "<?php echo $userInfo['openid'];?>";
            var nikname = "<?php echo $userInfo['nickname'];?>";
            location.href = "comment_add.php?openid="+openid+'&nikname='+nikname+'&order_detailid='+order_detailid+'&productid='+productid;
        }

        function gotopay(productid , productnum ,order_detailid){
            var openid = "<?php echo $userInfo['openid'];?>";
            location.href = 'order_buy.php?productid='+productid+'&productnum='+productnum+'&openid='+openid+'&repay=1'+'&order_detailid='+order_detailid;
        }


    </script>
</head>

<body>
<div class="container" >
    <header data-am-widget="header" class="am-header am-header-default my-header">
        <!--首页-->
        <div class="am-header-left am-header-nav">
            <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/self.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect" class="">
                <i class="am-header-icon am-icon-chevron-left"></i>
            </a>
        </div>
        <!--主标题-->
        <h1 class="am-header-title">
            <a href="#" class="">
                我的订单
            </a>
        </h1>
        <!--右侧侧边栏-->
        <div class="am-header-right am-header-nav">
            <a href="#right-link" class="" data-am-offcanvas="{target: '#doc-oc-demo3'}">
                <i class="am-header-icon am-icon-bars"></i>
            </a>
            <!-- 侧边栏内容 -->
            <div id="doc-oc-demo3" class="am-offcanvas">
                <div class="am-offcanvas-bar am-offcanvas-bar-flip">
                    <div class="am-offcanvas-content">
                        <ul class="un-style-list">
                            <li><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/home.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect">首页</a></li>
                            <li><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/partner.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect">成为经销商</a></li>
                            <li><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/cart.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect.php">购物车</a></li>
                            <li><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/self.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect">个人中心</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--会员信息-->
    <div class="uchome-info">
        <div class="uchome-info-uimg">
            <img src="<?php echo $userInfo['headimgurl'];?>" />
        </div>
        <div class="uchome-info-uinfo">
            <p>会员名字：<span class="red"><?php echo $userInfo['nickname']?></span></p>
            <p>会员等级：<span class="red"><?php echo $cate;?></span></p>

                <!-- <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/order_list_sale.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect" class="am-btn am-btn-success am-btn-sm am-round am-fr order-by">销售订单</a> -->
        </div>
    </div>
    <!--订单菜单-->
    <div id="refresh">
    <div class="am-tabs" id="doc-my-tabs">
        <ul class="am-tabs-nav am-nav am-nav-tabs am-nav-justify uchome-nav">

            <li <?php if($choice==0){ echo  'class="am-active"';}?>><a href="">全部</a></li>
            <li <?php if($choice==1){ echo  'class="am-active"';}?>><a href="">待付款</a></li>
            <li <?php if($choice==2){ echo  'class="am-active"';}?>><a href="">待发货</a></li>
            <li <?php if($choice==3){ echo  'class="am-active"';}?>><a href="">待收货</a></li>
            <li <?php if($choice==4){ echo  'class="am-active"';}?>><a href="">已完成</a></li>
        </ul>
        <div class="am-tabs-bd">

            <!-- 全部 -->
            <div <?php if($choice==0){ 
                            echo  'class="am-tab-panel am-active"';
                            }else{
                                echo 'class="am-tab-panel "';
                            }


            ?>>
                <?php 
                    $order_details_all = table_order_detail::getInfoByOpenid($userInfo['openid']);
                    //var_dump($order_details);
                    foreach ($order_details_all as $order_detail_all) {
                        # code...
                        $order_all            = Order::getInfoByPayid($order_detail_all['payid']);
                        $state                = Order_detail::getStateName($order_detail_all['state']);
                        $pic                  = $HTTP_PATH.$order_detail_all['product_img'];
                        $time                 = date('Y-m-d H:m', $order_all['createtime']);
                        $product              = Product::getInfoById($order_detail_all['productid']);
                        //var_dump($product);
                        if($product['issale']){
                            $price = number_format($product['sale_price'] , 2);
                        }else{
                            $price = number_format($product['price'] , 2);
                        }
                            //var_dump($price);
                        $total                = number_format($price*$order_detail_all['num'] , 2);


                        echo '<div class="withdrawals-panel " >
                                <p class="groupby-t-p"><span class="am-fr am-text-warning">'.$state.'</span>订单号：'.$order_detail_all['payid'].'</p>
                                <hr class="am-divider am-divider-default am-cf">
                                    <div class="groupby-img-panle"><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/product_detail.php").'?productid='.$product['id'].'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"><img src="'.$pic.'" class="am-img-responsive"></a></div>
                                        <div class="groupby-info-panle">
                                            <h3><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/product_detail.php").'?productid='.$product['id'].'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect">'.$order_detail_all['title'].'</a></h3>
                                            <p>单价：<span class="red2 bold">'.$price.'</span> 元&nbsp; &nbsp;&nbsp;数量：'.$order_detail_all['num'].'</p>
                                            <p>收货人：'.$order_all['address_name'].'&nbsp; &nbsp;&nbsp;电话：'.$order_all['address_phone'].'</p>
                                            <p>收货地址：<span class="am-text-primary">'.$order_all['address_area'].$order_all['address'].'</span></p>
                                            <p>时间：<span class="am-text-success">'.$time.'</span></p>
                                            <p class="am-text-right">共 <span class="red2 bold">'.$order_detail_all['num'].'</span>件&nbsp; &nbsp;&nbsp;实付：￥<span class="red2 bold">'.$total.'</span>元</p>
                                            ';
                            if($order_detail_all['state']==1){
                                echo ' <p><a href="#" class="am-btn am-btn-primary am-btn-xs am-btn-success am-radius" onClick="cancel_order('.$order_detail_all['id'].')" >取消订单</a>&nbsp; &nbsp;&nbsp;<a href="#" class="am-btn am-btn-primary am-btn-xs am-btn-danger am-radius" onClick="gotopay('.$order_detail_daifukuan['productid'].','.$order_detail_daifukuan['num'].','.$order_detail_daifukuan['id'].')">去付款</a></p>
                                    
                                        </div>
                                </div>
                            ';

                            }
                            if($order_detail_all['state']==2){
                                echo '
                                        </div>
                                </div>
                            ';
                            }
                            if($order_detail_all['state']==3){
                                echo '<p><a href="#" class="am-btn am-btn-primary am-btn-xs am-btn-danger am-radius" onclick="sureGet('.$order_detail_all['id'].')">确认收货</a></p>
                                    
                                        </div>
                                </div>
                            ';
                            }
                            if($order_detail_all['state']==4){
                                $comment = table_comment::getInfoByOrder_detailid($order_detail_all['id']);
                                if(empty($comment)){

                                    echo '<p><a href="#" class="am-btn am-btn-primary am-btn-xs am-btn-success am-radius" onClick="comment('.$order_detail_all['id'].','.$order_detail_all['productid'].')">评价商品</a></p>
                                    
                                        </div>
                                </div>
                         ';
                                }else{
                                    echo '<p><a href="#" class="am-btn am-btn-primary am-btn-xs am-btn-success am-radius" >已评论</a></p>
                                    
                                        </div>
                                </div>
                         ';
                                }
                                
                            }

                            
                    }


                ?>

        
                </div>
            <!-- <div class="withdrawals-panel">
                    <p class="groupby-t-p"><span class="am-fr am-text-warning">待付款</span>订单号：123456789</p>
                    <hr class="am-divider am-divider-default am-cf">
                    <div class="groupby-img-panle"><a href="#"><img src="default/img3.jpg" class="am-img-responsive"></a></div>
                    <div class="groupby-info-panle">
                        <h3><a href="#">某某商品</a></h3>
                        <p>单价：<span class="red2 bold">23</span> 元&nbsp; &nbsp;&nbsp;数量：3</p>
                        <p>收货人：小李&nbsp; &nbsp;&nbsp;电话：13112341234</p>
                        <p>收货地址：<span class="am-text-primary">陕西省某某市某某区某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某</span></p>
                        <p>时间：<span class="am-text-success">2015-06-07 18:27</span></p>
                        <p class="am-text-right">共 <span class="red2 bold">2</span>件&nbsp; &nbsp;&nbsp;实付：￥<span class="red2 bold">69</span>元</p>
                        <p><a href="#" class="am-btn am-btn-primary am-btn-xs am-btn-success am-radius">取消订单</a> <a href="#" class="am-btn am-btn-primary am-btn-xs am-btn-danger am-radius">订单详情</a></p>
                </div>
            </div>
                    </div> -->
            
            <!-- 待付款 -->
            <div <?php if($choice==1){ 
                            echo  'class="am-tab-panel am-active"';
                            }else{
                                echo 'class="am-tab-panel "';
                            }

            ?>>
            <?php 
                $order_detail_daifukuans = table_order_detail::getInfoByOpenid_state($userInfo['openid'],1);
                //var_dump($order_details_daifukuan);
                foreach ($order_detail_daifukuans as $order_detail_daifukuan) {
                    # code...
                        $order_daifukuan      = Order::getInfoByPayid($order_detail_daifukuan['payid']);
                        $state                = Order_detail::getStateName($order_detail_daifukuan['state']);
                        $pic                  = $HTTP_PATH.$order_detail_daifukuan['product_img'];
                        $time                 = date('Y-m-d H:m', $order_daifukuan['createtime']);
                        $product              = Product::getInfoById($order_detail_daifukuan['productid']);
                        //var_dump($product);
                        if($product['issale']){
                            $price = number_format($product['sale_price'] , 2);
                        }else{
                            $price = number_format($product['price'] , 2);
                        }
                            //var_dump($price);
                        $total                = number_format($price*$order_detail_daifukuan['num'] , 2);


                        echo '<div class="withdrawals-panel " >
                                <p class="groupby-t-p"><span class="am-fr am-text-warning">'.$state.'</span>订单号：'.$order_detail_daifukuan['payid'].'</p>
                                <hr class="am-divider am-divider-default am-cf">
                                <div class="groupby-img-panle"><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/product_detail.php").'?productid='.$product['id'].'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"><img src="'.$pic.'" class="am-img-responsive"></a></div>
                                <div class="groupby-info-panle">
                                    <h3><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/product_detail.php").'?productid='.$product['id'].'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect">'.$order_detail_daifukuan['product_title'].'</a></h3>
                                    <p>单价：<span class="red2 bold">'.$price.'</span> 元&nbsp; &nbsp;&nbsp;数量：'.$order_detail_daifukuan['num'].'</p>
                                    <p>收货人：'.$order_daifukuan['address_name'].'&nbsp; &nbsp;&nbsp;电话：'.$order_daifukuan['address_phone'].'</p>
                                    <p>收货地址：<span class="am-text-primary">'.$order_daifukuan['address_area'].$order_daifukuan['address'].'</span></p>
                                    <p>时间：<span class="am-text-success">'.$time.'</span></p>
                                    <p class="am-text-right">共 <span class="red2 bold">'.$order_detail_daifukuan['num'].'</span>件&nbsp; &nbsp;&nbsp;实付：￥<span class="red2 bold">'.$total.'</span>元</p>
                        <p><a href="#" class="am-btn am-btn-primary am-btn-xs am-btn-success am-radius" onClick="cancel_order('.$order_detail_daifukuan['id'].')" >取消订单</a>&nbsp; &nbsp;&nbsp;<a href="#" class="am-btn am-btn-primary am-btn-xs am-btn-danger am-radius" onClick="gotopay('.$order_detail_daifukuan['productid'].','.$order_detail_daifukuan['num'].','.$order_detail_daifukuan['id'].')">去付款</a></p>
                    </div>
                </div>';
                }

            ?>
            </div>


            <!-- 待发货 -->
            <div <?php if($choice==2){ 
                            echo  'class="am-tab-panel am-active"';
                            }else{
                                echo 'class="am-tab-panel "';
                            }

            ?>>

                <?php  

                $order_detail_daifahuos = table_order_detail::getInfoByOpenid_state($userInfo['openid'],2);
                //var_dump($order_details_daifukuan);
                foreach ($order_detail_daifahuos as $order_detail_daifahuo) {
                    # code...
                        $order_daifahuo      = Order::getInfoByPayid($order_detail_daifahuo['payid']);
                        $state                = Order_detail::getStateName($order_detail_daifahuo['state']);
                        $pic                  = $HTTP_PATH.$order_detail_daifahuo['product_img'];
                        $time                 = date('Y-m-d H:m', $order_daifahuo['createtime']);
                        $product              = Product::getInfoById($order_detail_daifahuo['productid']);
                        //var_dump($product);
                        if($product['issale']){
                            $price = number_format($product['sale_price'] , 2);
                        }else{
                            $price = number_format($product['price'] , 2);
                        }
                            //var_dump($price);
                        $total                = number_format($price*$order_detail_daifahuo['num'] , 2);
                        echo '<div class="withdrawals-panel">
                                <p class="groupby-t-p"><span class="am-fr am-text-warning">'.$state.'</span>订单号：'.$order_detail_daifahuo['payid'].'</p>
                                <hr class="am-divider am-divider-default am-cf">
                                <div class="groupby-img-panle"><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/product_detail.php").'?productid='.$product['id'].'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"><img src="'.$pic.'" class="am-img-responsive"></a></div>
                                <div class="groupby-info-panle">
                                    <h3><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/product_detail.php").'?productid='.$product['id'].'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect">'.$order_detail_daifahuo['product_title'].'</a></h3>
                                    <p>单价：<span class="red2 bold">'.$price.'</span> 元&nbsp; &nbsp;&nbsp;数量：'.$order_detail_daifahuo['num'].'</p>
                                    <p>收货人：'.$order_daifahuo['address_name'].'&nbsp; &nbsp;&nbsp;电话：'.$order_daifahuo['address_phone'].'</p>
                                    <p>收货地址：<span class="am-text-primary">'.$order_daifahuo['address_area'].$order_daifahuo['address'].'</span></p>
                                    <p>时间：<span class="am-text-success">'.$time.'</span></p>
                                    <p class="am-text-right">共 <span class="red2 bold">'.$order_detail_daifahuo['num'].'</span>件&nbsp; &nbsp;&nbsp;实付：￥<span class="red2 bold">'.$total.'</span>元</p>
                    </div>
                </div>';
                }

                ?>  
                <!-- <ul class="am-pagination am-pagination-centered">
                    <li class="am-disabled"><a href="#">«</a></li>
                    <li class="am-active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">»</a></li>
                </ul> -->
            </div>
        </div>
                <!-- <div class="withdrawals-panel">
                    <p class="groupby-t-p"><span class="am-fr am-text-warning">待付款</span>订单号：123456789</p>
                    <hr class="am-divider am-divider-default am-cf">
                    <div class="groupby-img-panle"><a href="#"><img src="default/img3.jpg" class="am-img-responsive"></a></div>
                    <div class="groupby-info-panle">
                        <h3><a href="#">某某商品</a></h3>
                        <p>单价：<span class="red2 bold">23</span> 元&nbsp; &nbsp;&nbsp;数量：3</p>
                        <p>收货人：小李&nbsp; &nbsp;&nbsp;电话：13112341234</p>
                        <p>收货地址：<span class="am-text-primary">陕西省某某市某某区某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某某</span></p>
                        <p>时间：<span class="am-text-success">2015-06-07 18:27</span></p>
                        <p class="am-text-right">共 <span class="red2 bold">2</span>件&nbsp; &nbsp;&nbsp;实付：￥<span class="red2 bold">69</span>元</p>
                        <p><a href="#" class="am-btn am-btn-primary am-btn-xs am-btn-success am-radius">取消订单</a> <a href="#" class="am-btn am-btn-primary am-btn-xs am-btn-danger am-radius">订单详情</a></p>
                    </div>
                </div>
                <ul class="am-pagination am-pagination-centered">
                    <li class="am-disabled"><a href="#">«</a></li>
                    <li class="am-active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">»</a></li>
                </ul>
                            </div>
                        </div> -->

        <!-- 待收货 -->
    <div class="am-tabs-bd">
        <div <?php if($choice==3){ 
                            echo  'class="am-tab-panel am-active"';
                            }else{
                                echo 'class="am-tab-panel "';
                            }

            ?>>

                <?php  

                $order_detail_daishouhuos = table_order_detail::getInfoByOpenid_state($userInfo['openid'],3);
                //var_dump($order_details_daifukuan);
                foreach ($order_detail_daishouhuos as $order_detail_daishouhuo) {
                    # code...
                        $order_daishouhuo      = Order::getInfoByPayid($order_detail_daishouhuo['payid']);
                        $state                = Order_detail::getStateName($order_detail_daishouhuo['state']);
                        $pic                  = $HTTP_PATH.$order_detail_daishouhuo['product_img'];
                        $time                 = date('Y-m-d H:m', $order_daishouhuo['createtime']);
                        $product              = Product::getInfoById($order_detail_daishouhuo['productid']);
                        //var_dump($product);
                        if($product['issale']){
                            $price = number_format($product['sale_price'] , 2);
                        }else{
                            $price = number_format($product['price'] , 2);
                        }
                            //var_dump($price);
                        $total                = number_format($price*$order_detail_daishouhuo['num'] , 2);
                        echo '<div class="withdrawals-panel">
                                <p class="groupby-t-p"><span class="am-fr am-text-warning">'.$state.'</span>订单号：'.$order_detail_daishouhuo['payid'].'</p>
                                <hr class="am-divider am-divider-default am-cf">
                                <div class="groupby-img-panle"><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/product_detail.php").'?productid='.$product['id'].'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"><img src="'.$pic.'" class="am-img-responsive"></a></div>
                                <div class="groupby-info-panle">
                                    <h3><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/product_detail.php").'?productid='.$product['id'].'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect">'.$order_detail_daishouhuo['product_title'].'</a></h3>
                                    <p>单价：<span class="red2 bold">'.$price.'</span> 元&nbsp; &nbsp;&nbsp;数量：'.$order_detail_daishouhuo['num'].'</p>
                                    <p>收货人：'.$order_daishouhuo['address_name'].'&nbsp; &nbsp;&nbsp;电话：'.$order_daishouhuo['address_phone'].'</p>
                                    <p>收货地址：<span class="am-text-primary">'.$order_daishouhuo['address_area'].$order_daishouhuo['address'].'</span></p>
                                    <p>时间：<span class="am-text-success">'.$time.'</span></p>
                                    <p class="am-text-right">共 <span class="red2 bold">'.$order_detail_daishouhuo['num'].'</span>件&nbsp; &nbsp;&nbsp;实付：￥<span class="red2 bold">'.$total.'</span>元</p>
                                    <p><a href="#" class="am-btn am-btn-primary am-btn-xs am-btn-danger am-radius" onclick="sureGet('.$order_detail_daishouhuo['id'].')">确认收货</a></p>
                    </div>
                </div>';
                }

                ?>  
                <!-- <ul class="am-pagination am-pagination-centered">
                    <li class="am-disabled"><a href="#">«</a></li>
                    <li class="am-active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">»</a></li>
                </ul> -->
           
            </div>
            <!-- 已完成 -->
        
            <div <?php if($choice==4){ 
                            echo  'class="am-tab-panel am-active"';
                            }else{
                                echo 'class="am-tab-panel "';
                            }

            ?>>

                <?php  

                $order_detail_yiwanchengs = table_order_detail::getInfoByOpenid_state($userInfo['openid'],4);
                //var_dump($order_details_daifukuan);
                foreach ($order_detail_yiwanchengs as $order_detail_yiwancheng) {
                    # code...
                        $order_yiwancheng    = Order::getInfoByPayid($order_detail_yiwancheng['payid']);
                        $state                = Order_detail::getStateName($order_detail_yiwancheng['state']);
                        $pic                  = $HTTP_PATH.$order_detail_yiwancheng['product_img'];
                        $time                 = date('Y-m-d H:m', $order_yiwancheng['createtime']);
                        $product              = Product::getInfoById($order_detail_yiwancheng['productid']);
                        //var_dump($product);
                        if($product['issale']){
                            $price = number_format($product['sale_price'] , 2);
                        }else{
                            $price = number_format($product['price'] , 2);
                        }
                            //var_dump($price);
                        $total                = number_format($price*$order_detail_yiwancheng['num'] , 2);
                        echo '<div class="withdrawals-panel">
                                <p class="groupby-t-p"><span class="am-fr am-text-warning">'.$state.'</span>订单号：'.$order_detail_yiwancheng['payid'].'</p>
                                <hr class="am-divider am-divider-default am-cf">
                                <div class="groupby-img-panle"><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/product_detail.php").'?productid='.$product['id'].'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"><img src="'.$pic.'" class="am-img-responsive"></a></div>
                                <div class="groupby-info-panle">
                                    <h3><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/product_detail.php").'?productid='.$product['id'].'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect">'.$order_detail_yiwancheng['product_title'].'</a></h3>
                                    <p>单价：<span class="red2 bold">'.$price.'</span> 元&nbsp; &nbsp;&nbsp;数量：'.$order_detail_yiwancheng['num'].'</p>
                                    <p>收货人：'.$order_yiwancheng['address_name'].'&nbsp; &nbsp;&nbsp;电话：'.$order_yiwancheng['address_phone'].'</p>
                                    <p>收货地址：<span class="am-text-primary">'.$order_yiwancheng['address_area'].$order_yiwancheng['address'].'</span></p>
                                    <p>时间：<span class="am-text-success">'.$time.'</span></p>
                                    <p class="am-text-right">共 <span class="red2 bold">'.$order_detail_yiwancheng['num'].'</span>件&nbsp; &nbsp;&nbsp;实付：￥<span class="red2 bold">'.$total.'</span>元</p>';



                                $comment = table_comment::getInfoByOrder_detailid($order_detail_yiwancheng['id']);
                                if(empty($comment)){

                                    echo '<p><a href="#" class="am-btn am-btn-primary am-btn-xs am-btn-success am-radius" onClick="comment('.$order_detail_yiwancheng['id'].','.$order_detail_yiwancheng['productid'].')">评价商品</a></p>
                                    
                                        </div>
                                </div>
                         ';
                                }else{
                                    echo '<p><a href="#" class="am-btn am-btn-primary am-btn-xs am-btn-success am-radius" >已评论</a></p>
                                    
                                        </div>
                                </div>
                         ';
                                }
                }

                ?>  
                <!-- <ul class="am-pagination am-pagination-centered">
                    <li class="am-disabled"><a href="#">«</a></li>
                    <li class="am-active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">»</a></li>
                </ul> -->


        </div>
    </div>
</div>
    <!--底部-->
    <footer data-am-widget="footer" class="am-footer am-footer-default" data-am-footer="{  }">
        <hr data-am-widget="divider" style="" class="am-divider am-divider-default"/>
        <div class="am-footer-miscs ">
            <p>CopyRight©2014 AllMobilize Inc.</p>
            <p>京ICP备13033158</p>
        </div>
    </footer>
    <!--底部工具栏-->
    <div data-am-widget="navbar" class="am-navbar am-cf my-nav-footer " id="">
        <ul class="am-navbar-nav am-cf am-avg-sm-4 my-footer-ul">
            <li >
          <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/home.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect" class="">
            <span class="am-icon-home"></span>
            <span class="am-navbar-label">首页</span>
          </a>
        </li>
        <li>
          <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/partner.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect" class="">
            <span class=" am-icon-users"></span>
            <span class="am-navbar-label">成为经销商</span>
          </a>
        </li>
        <li>
          <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/cart.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect" class="">
            <span class=" am-icon-shopping-cart"></span>
            <span class="am-navbar-label">购物车</span>
          </a>
        </li>
        <li class="on">
          <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/self.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect" class="">
            <span class=" am-icon-user"></span>
            <span class="am-navbar-label">个人中心</span>
          </a>
        </li>
        </ul>
        <script>
            function showFooterNav(){
                $("#footNav").toggle();
            }
        </script>
    </div>
</div>
</body>
</html>
