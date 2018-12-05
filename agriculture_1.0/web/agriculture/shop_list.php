<?php
require('../../conn.php');
require('../../config.inc.php');
require('../../wx_config.php');
$openid = getOpenid();
$admin = table_admin::getInfoByOpenid($openid);
if(!empty($admin)){
    $phone = $admin['phone'];
    $cate = 1;
}
$partner = table_partner::getInfoByOpenid($openid);
if(!empty($partner)){
   $phone = $partner['phone'];
   $cate = 2;
}


?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>商品信息</title>
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
        $('#am-icon-times').click(function () {
            console.log('success');
               /* location.href = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/address_edit.php");?>?addressid=<?php echo $address['id'];?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect';*/
               var thisid = $(this).parent('td').find('#productid').val();
               console.log(thisid+'success');
                $.ajax({
                            type: 'POST',
                            data: {
                                id: thisid
                            },
                            dataType: 'json',
                            url: 'shop_do.php?act=del',
                            success: function (data) {
                                //layer.close(index);

                                code = data.code;
                                msg = data.msg;
                                switch (code) {
                                    case 1: 
                                        $("#tr-"+thisid).remove();
                                        layer.msg(msg);
                                        break;
                                    default:
                                        layer.msg(msg);
                                }
                            }
                        });
            });

});
</script>
<body>
<div class="container">
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
                商品信息
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
        <table class="am-table am-table-striped am-table-hover comm-table">
       <!--  <ul data-am-widget="gallery" class="am-gallery am-avg-sm-3 am-avg-md-3 am-avg-lg-4 am-gallery-default" data-am-gallery="{ pureview: true }" > -->
            <tbody>

        <?php 

        $products = table_product::getInfoByPhone($phone);

        if(!empty($products)){

            foreach ($products as $product) {
                # code...
                if($product['issale']){
                    $price = $product['sale_price'];
                }else{
                    $price = $product['price'];
                }
                $pic    = $HTTP_PATH.$product['pic'];
                echo '<tr id="tr-'.$product['id'].'" data-am-widget="gallery" class="am-gallery am-avg-sm-3 am-avg-md-3 am-avg-lg-4 am-gallery-default" data-am-gallery="{ pureview: true }">
                <td style="width: 20%"><img src="'.$pic.'" class="am-img-responsive"></td>
                <td style="width: 30%">'.$product['title'].'</td>
                <td style="width: 10%">'.$price.'</td>
                <td style="width: 20%">销量：231</td>
                <td style="width: 20%">
                   <a href="shop_edit.php?id='.$product['id'].'&phone='.$phone.'&cate='.$cate.'" class="am-badge am-badge-secondary am-radius"><i class="am-icon-edit"></i></a> 
                    <a id="am-icon-times" class="am-badge am-badge-secondary am-radius"><i class="am-icon-times"></i></a>
                    <input type="hidden" id="productid" value="'.$product['id'].'"/>
                </td>

            </tr>';
            }
        }

        ?>
         <!--    <tr>
             <td style="width: 20%"><img src="default/img3.jpg" class="am-img-responsive"></td>
             <td style="width: 30%">商品A</td>
             <td style="width: 10%">￥30</td>
             <td style="width: 20%">销量：231</td>
             <td style="width: 20%">
                <a href="" class="am-badge am-badge-secondary am-radius"><i class="am-icon-edit"></i></a> 
                 <a href="" class="am-badge am-badge-secondary am-radius"><i class="am-icon-times"></i></a>
             </td>
         </tr> -->
            </tbody>
        </table>

    </div>
    <!-- <ul class="am-list am-list-border">
        <li class="am-cf">
            <a href=""><i class="am-icon-plus-circle"></i><span class="am-text-primary"> 添加商品</span></a>
        </li>
    </ul> -->
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
