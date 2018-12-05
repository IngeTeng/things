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
if($partner['state']==1){
    $cate = '高级加盟商';
    $cateid = 3;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>会员中心</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp" />
<link rel="stylesheet" href="amazeui/css/amazeui.min.css"/>
<link rel="stylesheet" href="default/style.css"/>
<script src="amazeui/js/jquery.min.js"></script>
<script src="amazeui/js/amazeui.min.js"></script>
</head>

<body>
<div class="container">
    <header data-am-widget="header" class="am-header am-header-default my-header">
        <!--首页-->
        <div class="am-header-left am-header-nav">
            <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/home.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect" class="">
                <i class="am-header-icon am-icon-chevron-left"></i>
            </a>
        </div>
        <!--主标题-->
        <h1 class="am-header-title">
            <a href="#" class="">
                会员中心
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
            <p>会员名字： <span class="red"><?php echo $userInfo['nickname']?></span></p>
            <p>会员等级：<span class="red"><?php echo $cate;?></span></p>
        </div>
    </div>
    <!--我的订单-->
    <div class="am-cf uchome-apps">
        <div class="am-panel-hd"><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/order_list.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect">我的订单</a></div>
        <ul class="am-avg-sm-4 uchome-apps-ul">
            <li><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/order_list.php");?>?choice=1&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"><p class="imgp"><img src="default/dfk.png" class="am-img-responsive" /></p><p class="namep">待付款</p></a></li>
            <li><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/order_list.php");?>?choice=2&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"><p class="imgp"><img src="default/dfh.png" class="am-img-responsive" /></p><p class="namep">待发货</p></a></li>
            <li><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/order_list.php");?>?choice=3&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"><p class="imgp"><img src="default/dsh.png" class="am-img-responsive" /></p><p class="namep">待收货</p></a></li>
            <li><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/order_list.php");?>?choice=4&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"><p class="imgp"><img src="default/dtk.png" class="am-img-responsive" /></p><p class="namep">已完成</p></a></li>
        </ul>
    </div>
    <div class="mg10">
        <!--其他菜单-->
        <ul class="am-list am-list-border">
            <li><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/cart.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"><i class="am-icon-shopping-cart am-icon-fw"></i> 我的购物车 <i class="am-fr am-icon-caret-right"></i></a></li>
            <li><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/msg.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"><i class="am-icon-volume-up am-icon-fw"></i> 消息提醒设置 <i class="am-fr am-icon-caret-right"></i></a></li>
            <li><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/submit_list.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"><i class="am-icon-list-alt am-icon-fw"></i> 提交工单 <i class="am-fr am-icon-caret-right"></i></a></li>
        </ul>

        <ul class="am-list am-list-border">
            <li><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/address.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"><i class="am-icon-map-marker am-icon-fw"></i> 收货地址管理 <i class="am-fr am-icon-caret-right"></i></a></li>
            <?php if($cateid==2):?>
            <!-- <li><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/partner_list.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"><i class="am-icon-group am-icon-fw"></i> 经销商管理 <i class="am-fr am-icon-caret-right"></i></a></li> -->
            <?php endif;?>
            <?php if($cateid!=1):?>
            <li><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/shop_list.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"><i class="am-icon-gift am-icon-fw"></i> 商品列表 <i class="am-fr am-icon-caret-right"></i></a></li>
            <?php endif;?>
        </ul>
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
