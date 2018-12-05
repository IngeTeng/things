<?php 
require('../../conn.php');
require('../../config.inc.php');
require('../../wx_config.php');
require($LIB_PATH.'address.class.php');
require($LIB_TABLE_PATH.'table_address.class.php');

$id = $_GET['addressid'];
//var_dump($id);
try {
    $r = table_address::getInfoById($id);
    $address_id                     = $r['id'];
    $address_name                   = $r['name'];
    $address_phone                  = $r['phone']; 
    $address_address                = $r['address'];
    $address_area                   = $r['area'];
    $address_postcode               = $r['postcode'];
   
} catch(MyException $e){
    echo $e->getMessage();
    exit();
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>修改收货地址</title>
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
//添加
        $('#btn_submit').click(function(){
                    //start数据检查                 
                   
                    var name           = $('input[name=name]').val();
                    var phone          = $('input[name=phone]').val();
                    var area           = $('input[name=area]').val();
                    var address        = $('input[name=address]').val();
                    var postcode       = $('input[name=postcode]').val();

                    if(name == ''){
                        layer.msg('请输入收货人姓名');
                        return false;
                    }
                    if(phone == ''){
                        layer.msg('请输入收货人联系方式');
                        return false;
                    }
                    if(area == ''){
                        layer.msg('请输入地区信息');
                        return false;
                    }
                    if(address == ''){
                        layer.msg('情输入详细的街道信息');
                        return false;
                    }
            
                     //end数据检查
                    
                    $.ajax({
                        type : 'POST',
                        data : {
                            name               : name,
                            phone              : phone,
                            area               : area,
                            address            : address,
                            postcode           : postcode,
                            id                 : <?php echo $address_id?>
                            
                        },
                        dataType : 'json',
                        url      : 'address_do.php?act=edit',
                        success  : function(data){
                            console.log('success');
                            var code = data.code;
                            var msg  = data.msg;
                            switch(code){
                                case 1:
                                    layer.msg(msg ,function(index){
                                        location.href = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/address.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect';
                                    });
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
            <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/address.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect" class="">
                <i class="am-header-icon am-icon-chevron-left"></i>
            </a>
        </div>
        <!--主标题-->
        <h1 class="am-header-title">
            <a href="#" class="">
                修改收货地址
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
    <div class="cart-panel">
        <div class="am-form-group am-form-icon">
            <i class="am-icon-user" style="color:#329cd9"></i>
            <input type="text" name="name"  value="<?php echo $address_name?>" class="am-form-field  my-radius" placeholder="收货人姓名">
        </div>
        <div class="am-form-group am-form-icon">
            <i class="am-icon-phone" style="color:#f09513"></i>
            <input type="text" name="phone"  value="<?php echo $address_phone?>" class="am-form-field  my-radius" placeholder="请输入11位手机号码">
        </div>
        <div class="am-form-group am-form-icon">
            <i class="am-icon-map-marker" style="color:#e88888"></i>
            <input type="text" name="area"  value="<?php echo $address_area?>" class="am-form-field  my-radius" placeholder="请输入地区，例如河南、郑州">
        </div>
        <div class="am-form-group am-form-icon">
            <i class="am-icon-home" style="color:#329cd9"></i>
            <input type="text" name="address"  value="<?php echo $address_address?>" class="am-form-field  my-radius" placeholder="街道详细信息">
        </div>
        <div class="am-form-group am-form-icon">
            <i class="am-icon-envelope" style="color:#e9c740"></i>
            <input type="text" name="postcode"  value="<?php echo $address_postcode?>" class="am-form-field  my-radius" placeholder="请输入邮箱号码">
        </div>
        <p class="am-text-center"><button type="submit" id="btn_submit" class="am-btn am-btn-danger am-radius">确认</button></p>
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
