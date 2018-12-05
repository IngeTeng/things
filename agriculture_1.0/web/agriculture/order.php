<?php 
require('../../conn.php');
require('../../config.inc.php');
require('../../wx_config.php');

$userInfo = getUserInfo();
$products = table_cart::getInfoByOpenId_ischecked($userInfo['openid'] , 1);

if(!empty($products)){
    $i=0;
    foreach($products as $product){
        //var_dump($product['productid']);
        $productInfo = table_product::getInfoById($product['productid']);
        //var_dump($productInfo);
        $productInfo_id =$productInfo['id']; 
        if($productInfo['issale']){
             $price = $productInfo['sale_price'];
             //var_dump($price);
        }else{
            $price =  $productInfo['price'];
            //var_dump($price);
        }
            $total_amount+=$price*$product['productnum'];
            $total_post += $productInfo['post_price']*$product['productnum'];
            //var_dump($total_amount);
            //var_dump($price);
            //var_dump($product['productnum']);
            $product_detail[$i]['id'] = $productInfo['id'];
            $product_detail[$i]['num'] = $product['productnum'];
            $product_detail[$i]['total'] = $product['productnum']*($productInfo['post_price']+$price);
            $i++;

    }
    $total_amount = number_format($total_amount , 2);
    $total_post = number_format($total_post , 2);

}


if(empty($_GET['addressid'])){
    $addresss =table_address::getInfoByOpenid_front($userInfo['openid']); 
    $addressid = $addresss[0]['id'];
    
}else{
    $addressid = $_GET['addressid'];
    
   
}
if(empty($addressid)){
    $addressInfo ='';
}else{
    $addressInfo = table_address::getInfoById($addressid);
}

$pay_id = 'YX'.time().randcode(4,2);
//var_dump($pay_id);
//var_dump($addressInfo['address']);
$product_detail = json_encode($product_detail);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>确认订单</title>
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
</head>
<script type="text/javascript">
$(function(){
    $('#btn_submit').click(function(){
        //order插入
        pay_id = "<?php echo $pay_id;?>";
        openid = "<?php echo $userInfo['openid'];?>";
        nikname = "<?php echo $userInfo['nickname'];?>";
        addressid = "<?php echo $addressid;?>";
        address_name = "<?php echo $addressInfo['name'];?>";
        address_phone =  "<?php echo $addressInfo['phone'];?>";
        address_area    = "<?php echo $addressInfo['area'];?>";
        address    = "<?php echo $addressInfo['address'];?>";
        //var addressid    = "<?php echo $addressid;?>";
        total = "<?php echo $total_amount+$total_post;?>";
        product_detail =  <?php echo $product_detail;?>;
        //console.log(addressid);
        //alert(product);
       if(addressid == ''){
            layer.msg('请选择收货地址');
            return false;
        }
        if(nikname == ''){
            layer.msg('未获取到微信昵称');
        }
        $.ajax({
            type        : 'POST',
            data        : {
                    pay_id          : pay_id,
                    openid          : openid,
                    nikname         : nikname,
                    addressid       : addressid,
                    address_name    : address_name,
                    address_phone   : address_phone,
                    address_area    : address_area,
                    address         : address,
                    product_detail  : product_detail,
                    total           : total,
                    state           : 1
                        },
                        dataType :    'json',
                        url :         'order_do.php?act=add',
                        success :     function(data){
                                            console.log('success');
                                            code = data.code;
                                            msg  = data.msg;
                                            switch(code){
                                                case 1:
                                                location.href='pay.php?total='+total+'&pay_id='+pay_id;
                                                    break;
                                                default:
                                                
                                            }
                                      }
                    });
                
                /*location.href='https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/pay.php");?>?total='+total+'&addressid='+addressid+'&product='+product+'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect';
                });*/
            });
});
</script>
<body>
<div class="container">
    <header data-am-widget="header" class="am-header am-header-default my-header">
        <!--首页-->
        <div class="am-header-left am-header-nav">
            <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/cart.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect" class="">
                <i class="am-header-icon am-icon-chevron-left"></i>
            </a>
        </div>
        <!--主标题-->
        <h1 class="am-header-title">
            <a href="#" class="">
                确认订单
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

    <div class="mg10">
        <!--其他菜单-->
        <ul class="am-list am-list-border">
            <li class="">
                <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/address_choice.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect" class="am-cf"><i class="am-icon-map-marker am-icon-fw am-fl" style="width: 5%"></i>
                <?php if(!empty($addressInfo)):?>
                <span class="am-fl" style="width: 85%;font-size: 15px">收货人：<?php echo $addressInfo['name']?> <br>
                    <?php echo $addressInfo['area'].$addressInfo['address'];?>
                </span>
                <?php endif;?>
                <?php if(empty($addressInfo)):?>
                    <span class="am-fl" style="width: 85%;font-size: 15px">请添加收货地址
                </span>
                <?php endif;?> 
                <i class="am-fr am-icon-caret-right am-fr" style="width: 5%"></i></a>
                
            </li>
        </ul>
    </div>
    <!--订单菜单-->
    <div class="am-cf cart-panel">
        <div class="cart-list-panel">
            <ul class="am-avg-sm-1 cart-panel-ul">
       
            <!-- 循环开始 -->
            <?php 
            $products = table_cart::getInfoByOpenId_ischecked($userInfo['openid'] , 1);

            if(!empty($products)){
                foreach($products as $product){
                    $productInfo = table_product::getInfoById($product['productid']);
                    if(!empty($productInfo)){
                    if($productInfo['issale']){
                        $price = $productInfo['sale_price'];
                        }else{
                        $price =  $productInfo['price'];
                    }
                        $pic = $HTTP_PATH.$productInfo['pic'];
                        $heJi = ($price+$productInfo['post_price'])*$product['productnum'];
                        $heJi = number_format($heJi , 2);

                        echo '<li>
                    <div class="imgpanel"><a href="#"><img src="'.$pic.'" class="am-img-responsive"></a></div>
                    <div class="infopanel"
                        <h3><a href="#">'.$productInfo['title'].'</a></h3>
                        <p>价格：<span class="red2 bold">'.$price.'</span> 元  X '.$product['productnum'].'</p>
                        <p>物流：<span class="red2 bold">'.$productInfo['post_price'].'</span> 元  X '.$product['productnum'].'</p>
                        <p><span class="am-fr"><a class="am-badge am-badge-danger am-round"></a></span>合计：<span class="red2 bold">'.$heJi.'</span>元</p>
                    </div>
                </li>';
                    
                }

            }
        }
            ?>
                <!-- <li>
                    <div class="imgpanel"><a href="#"><img src="default/img3.jpg" class="am-img-responsive"></a></div>
                    <div class="infopanel"
                        <h3><a href="#">450ml柔顺丰盈护发素正品></a></h3>
                        <p>品牌：乔治卡罗尔</p>
                        <p>价格：<span class="red2 bold">78.00</span> 元  X <input class="am-input-sm txt-qty" type="number" value="1"></p>
                        <p><span class="am-fr"><a class="am-badge am-badge-danger am-round">删除</a></span>合计：<span class="red2 bold">60</span>元</p>
                    </div>
                </li>
                <li>
                    <div class="imgpanel"><a href="#"><img src="default/img3.jpg" class="am-img-responsive"></a></div>
                    <div class="infopanel"
                        <h3><a href="#">450ml柔顺丰盈护发素正品></a></h3>
                        <p>品牌：乔治卡罗尔</p>
                        <p>价格：<span class="red2 bold">78.00</span> 元  X <input class="am-input-sm txt-qty" type="number" value="1"></p>
                        <p><span class="am-fr"><a class="am-badge am-badge-danger am-round">删除</a></span>合计：<span class="red2 bold">60</span>元</p>
                    </div>
                </li>
                               循环结束 -->

            </ul>
        </div>
    </div>
    <div class="paoduct-title-panel mg10">
        <p>商品金额：￥<span class="am-text-danger"><?php echo $total_amount;?></span>元</p>
        <p>运费：￥<span class="am-text-warning"><?php echo $total_post;?></span>元</p>
    </div>
    <div class="cart_foot am-cf mg10">
        <span class="am-fr">
            合计：<span class="red2 bold" id="total_amount">￥<?php echo number_format($total_amount+$total_post , 2);?></span>元
        </span>
    </div>
    <div class="cart-tool">
        <!-- <a class="am-btn am-btn-sm am-btn-success" href="#">
            <i class="am-icon-chevron-left"></i>
            取消订单
        </a> -->
        <a class="am-btn am-btn-sm am-btn-warning" href="#" id="btn_submit">
            <i class="am-icon-shopping-cart"></i>
            结账
        </a>
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
            <li>
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
            <li class="on">
                <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/cart.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect" class="">
                    <span class=" am-icon-shopping-cart"></span>
                    <span class="am-navbar-label">购物车</span>
                </a>
            </li>
            <li >
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
