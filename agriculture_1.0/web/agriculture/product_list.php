<?php
require('../../conn.php');
require($LIB_PATH.'category.class.php');
require($LIB_TABLE_PATH.'table_category.class.php');
require($LIB_PATH.'product.class.php');
require($LIB_TABLE_PATH.'table_product.class.php');

if(!empty($_GET['phone'])){
    $s_phone  = safeCheck($_GET['phone']);
    $s_cate_name="店铺商品";
}else{
    $s_phone  = 0;
    $s_cate_name="全部商品";
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>首页</title>
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
                <i class="am-header-icon am-icon-home"></i>
            </a>
        </div>
        <!--主标题-->
        <h1 class="am-header-title">
            <a href="#" class="">
                农贸商城
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
    <!--搜索-->
    <div class="gray-panel">
        <div class="my-search-title-panel">
            <div class="am-input-group">
                <input type="text" class="am-form-field am-radius" placeholder="搜索">
                <span class="am-input-group-btn">
                <button class="am-btn am-radius" type="button" id="searchproduct"><span class="am-icon-search"></span></button>
              </span>
            </div>
        </div>
    </div>

    <div class="am-cf am-g">
        <!--热销产品-->
        <div class="am-panel am-panel-default am-panel-warning mg10">
            <div class="am-panel-hd"><a href="#" class="am-text-warning"><?php echo $s_cate_name;?></a></div>
            <div class="am-panel-bd">
                <ul data-am-widget="gallery" class="am-gallery am-avg-sm-3 am-avg-md-3 am-avg-lg-4 am-gallery-default"  >
                    <?php 
                    $rows = table_product::getInfoByPhone($s_phone);
                    //var_dump($rows);
                     if(!empty($rows)) {
                        foreach($rows as $row) {
                            $pic    = $HTTP_PATH.$row['pic'];
                            //var_dump($issale_row);
    
                    echo '<li>
                            <div class="am-gallery-item">
                                <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/product_detail.php").'?productid='.$row['id'].'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect" class="good-item">
                                    <img src="'.$pic.'"  alt="农贸复合肥"/>
                                    <h3 class="am-gallery-title">'.$row['title'].'</h3>
                                <div class="am-gallery-desc red">￥'.$row['sale_price'].'</div>
                                </a>
                            </div>
                        </li>';
                        }

                     }
                    ?>

            
                </ul>

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
        <li class="on">
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
