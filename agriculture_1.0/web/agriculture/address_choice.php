<?php 
require('../../conn.php');
require('../../config.inc.php');
require('../../wx_config.php');
$userInfo = getUserInfo();

?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>收货地址管理</title>
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
function isInteger(obj) {
 return obj%1 === 0
}

function  return_address(){
    obj = document.getElementsByName("address");
    check_val = [];
    for(k in obj){
        if(obj[k].checked)
            check_val.push(obj[k].value);
    }
    //console.log(check_val);
    //console.log(check_val[0]);
    //console.log(check_val[1]);
    //(check_val);
    //alert(isInteger(check_val));
    if(isInteger(check_val)){
        location.href='https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/order.php");?>?addressid='+check_val+'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect';
    }else{
        layer.msg('只能选择一个地址');
    }
}
$(function(){
        $('#am-icon-times').click(function () {
               /* location.href = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/address_edit.php");?>?addressid=<?php echo $address['id'];?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect';*/
               var thisid = $(this).parent('li').find('#addressid').val();
               console.log(thisid+'success');
                $.ajax({
                            type: 'POST',
                            data: {
                                id: thisid
                            },
                            dataType: 'json',
                            url: 'address_do.php?act=del',
                            success: function (data) {
                                //layer.close(index);

                                code = data.code;
                                msg = data.msg;
                                switch (code) {
                                    case 1: 
                                        $("#li-"+thisid).remove();
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
                收货地址管理
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
    <ul class="am-list am-list-border">
        <!-- begin 此处循环 -->
        <?php 
            $addresss = table_address::getInfoByOpenid_front($userInfo['openid']);
            //var_dump($addresss);
            if(!empty($addresss)){

                foreach ($addresss as $address) {
                    # code...
                    if(strlen($address['address'])>10){
                    $address['address'] = mb_substr($address['address'] , 0,8,'utf-8').'...';
                    }
                    echo '<li id="li-'.$address['id'].'" class="am-cf am-vertical-align-middle">
            <input type="checkbox" name="address" value ="'.$address['id'].'" class="am-fl" style="margin-left: 10px">
            <span style="font-size: 15px;margin-left: 20px" class="am-fl">
                '.$address['area'].'&nbsp&nbsp'.$address['address'].'<br>
                '.$address['name'].'&nbsp&nbsp;'.$address['phone'].'
            </span>
            
           <a class="am-fr" id="am-icon-times" ><i class="am-icon-times"></i></a>

          <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/address_edit.php").'?addressid='.$address['id'].'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"  class="am-fr" id="am-icon-edit"><i class="am-icon-edit"></i></a>
          <input type="hidden" id="addressid" value="'.$address['id'].'"/>
        </li>';
                }
            }
        ?>
        
       <!--  end -->

        <li class="am-cf">
            <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/address_add.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"><i class="am-icon-plus-circle"></i><span class="am-text-primary"> 新增收货地址</span></a>

        </li>
    </ul>
    <p class="am-text-center"><button type="submit" class="am-btn am-btn-danger am-radius" onclick="return_address()">保存</button></p>

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
