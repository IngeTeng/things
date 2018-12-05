<?php
require('../../conn.php');
require('../../wx_config.php');
require($LIB_PATH.'product.class.php');
require($LIB_TABLE_PATH.'table_product.class.php');
require($LIB_PATH.'partner.class.php');
require($LIB_TABLE_PATH.'table_partner.class.php');
require($LIB_PATH.'comment.class.php');
require($LIB_TABLE_PATH.'table_comment.class.php');
require($LIB_PATH.'cart.class.php');
require($LIB_TABLE_PATH.'table_cart.class.php');
$userInfo = getUserInfo();
$cartNum = table_cart::getCountByOpenId($userInfo['openid']);
//var_dump($cartNum);
if(!empty($_GET['productid'])){
    $s_productid  = safeCheck($_GET['productid']);
}else{
    $s_productid  = 0;
}
    $product_info = Product::getInfoById($s_productid);
    $partner_info = table_partner::getInfoByPhone($product_info['add_phone']);
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>商品详情页</title>
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
//动态修改

function checkIsInteger(str)
{
  //如果为空，则通过校验
  if(str == "")
    return true;
     if(/^(\-?)(\d+)$/.test(str))
       return true;
     else
       return false;
}
var errordialog=function(c){
    alert(c)
}
//检验商品数量
function checkCounts(id) {
    var Counts = $("#" + id).val();
    if (Counts == "") {
        errordialog("请填写数量!");
        return false;
    }
    else if (!checkIsInteger(Counts)) {
        errordialog("商品数量不是整数!");
        return false;
    }
    else if (Counts < 1) {
        errordialog("商品数量不能小于1!");
        return false;
    }
    else {
        return true;
    }
}
function addQty(){
    checkCounts('txtQty');
    var qty = parseInt($('#txtQty').val());
    $('#txtQty').val(qty+1);
}
function subtractQty(){
    checkCounts('txtQty');
    var qty = parseInt($('#txtQty').val());
    if(qty <=1){
        errordialog("商品数量不能小于1");
        return;
    }
    $('#txtQty').val(qty-1);
}


$(function(){

  $('#jionCart').click(function(){
   
      var num =parseInt($('#txtQty').val());
      //$('#cartNum').html(<?php echo $carNum;?>+1);
      //console.log(num);
      $.ajax({
                    type : 'POST',
                    data : {
                        productid       : '<?php echo $s_productid;?>',
                        productnum      : num,
                        product_pic     : '<?php echo $product_info['pic'];?>',
                        product_price   : '<?php echo $product_info['price'];?>',
                        product_title   : '<?php echo $product_info['title'];?>',
                        openid          : '<?php echo $userInfo['openid'];?>',
                        nikname         : '<?php echo $userInfo['nickname'];?>'
                        
                       
                    },
                    dataType : 'json',
                    url      : 'join_cart.php',
                    success  : function(data){
                      console.log('success');
                        var code = data.code;
                        var msg  = data.msg;
                        switch(code){
                            case 1:
                            $('#cartNum').html(<?php echo $cartNum;?>+1);
                            layer.msg(msg);
                                 /*layer.msg(msg, function(index){
                                                //location.href = "<?php echo $urlnext;?>";
                                                
                                                });*/
                                break;
                            default:
                                layer.msg(msg);
                        }
                    }
                });
    });

  $('#buynow').click(function(){
        var num =parseInt($('#txtQty').val());
        var productid       = '<?php echo $s_productid;?>';
        var productnum      = num;
        var openid          = '<?php echo $userInfo['openid'];?>';
          location.href = 'order_buy.php?productid='+productid+'&productnum='+productnum+'&openid='+openid;

  });
  
});
</script>
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
                商品详情
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
    <!-- 轮播图 -->
    <div data-am-widget="slider" class="am-slider am-slider-a1" data-am-slider='{&quot;directionNav&quot;:false}' >
        <ul class="am-slides">
            <li>
                <img src="<?php echo $HTTP_PATH.$product_info['pic'];?>">
            </li>
            <!-- <li>
                <img src="http://s.amazeui.org/media/i/demos/bing-2.jpg">
            </li>
            <li>
                <img src="http://s.amazeui.org/media/i/demos/bing-3.jpg">
            </li>
            <li>
                <img src="http://s.amazeui.org/media/i/demos/bing-4.jpg">
            </li> -->
        </ul>
    </div>
    <div class="gray-panel">
        <div class="paoduct-title-panel">
            <h1 class="product-h1" id="product"><?php echo $product_info['title']?></h1>
            <p><!-- <span class="am-fr product-title-gray-text">销量：2220</span> --><span class="am-fr product-title-gray-text">库存：<?php echo $product_info['num'];?></span><span class="bold">价格：</span><span class="red2">￥<?php 
                if($product_info['issale']){
                    echo $product_info['sale_price'];
                }else{
                    echo $product_info['price'];
                }
            ?></span></p>
        </div>
        <div class="my-search-title-panel">
            <p class="my-search-titp-p am-text-sm bold am-fl">选择商品数量</p>
            <div style="overflow:hidden">
            <form class="am-form-inline" role="form">
                <button type="button" class="am-btn am-btn-default" style="float:left" onClick="subtractQty();" ><i class="am-icon-minus"></i></button>
                <input type="number" name="txtQty" id="txtQty" class="am-form-field txt-qty am-text-center am-text-sm" value="1" style=" width:60px; margin-right:0px; height:37px; display:inline; float:left">
                <button type="button" class="am-btn am-btn-default" style="float:left" onClick="addQty();"><i class="am-icon-plus"></i></button>
            </form>
            </div>
            <hr data-am-widget="divider" style="" class="am-divider-default am-margin-bottom-sm"/>
            <!--<div>-->
                <!--<ul class="am-avg-sm-2 am-text-center">-->
                    <!--<li class="am-text-center am-padding-sm"><button type="button" class="am-btn am-btn-success am-btn-block am-radius">加入购物车</button></li>-->
                    <!--<li class="am-text-center am-padding-sm"><button type="button" class="am-btn am-btn-danger am-btn-block am-radius">立即购买</button></li>-->
                <!--</ul>-->
            <!--</div>-->
        </div>
        <div class="paoduct-title-panel">
            <h2 class="product-h1">商家信息</h2>
            <p><span class="product-title-gray-text"><i class="am-icon-star"></i> <?php 
              if($product_info['add_role_cate']==1){
                echo '延鑫平台自营店';
              }else{
                echo $partner_info['company'];
              }
            ?></span></p>
            <hr data-am-widget="divider" style="" class="am-divider-default am-margin-bottom-sm"/>
            <div style="overflow:hidden">
            <ul class="am-avg-sm-2 am-text-center am-padding-bottom-sm">
                <li class="am-text-center"><a href="product_list.php"><i class=" am-icon-list"></i> 查看全部商品</a></li>
                <li class="am-text-center"><a href="product_list.php?phone=<?php echo $partner_info['phone'];?>"><i class=" am-icon-bank"></i> 进店逛逛</a></li>
            </ul>
            </div>
        </div>
    </div>
            <!-- 商品详情 -->
        
        <div data-am-widget="tabs" class="am-tabs am-tabs-d2">
          <ul class="am-tabs-nav am-cf">
            <li class="am-active">
              <a href="[data-tab-panel-0]">图文详情</a>
            </li>
            <li class="">
              <a href="[data-tab-panel-1]">用户评价</a>
            </li>
          </ul>
          <div class="am-tabs-bd">
              <div data-tab-panel-0 class="am-tab-panel am-active">
                  <!-- <img src="http://s.amazeui.org/media/i/demos/bing-1.jpg" class="am-img-responsive"> -->
                  <?php echo $product_info['desc'];?>
              </div>
              <div data-tab-panel-1 class="am-tab-panel ">
                  <div class="am-cf am-padding-sm" >
                      <ul class="am-comments-list am-comments-list-flip">


              <?php 
                //查询相关商品的评价
                $comment_infos = table_comment::getInfoByProductid($s_productid);
                if(!empty($comment_infos)) {
                    foreach($comment_infos as $comment_info) {
                      $userInfo = table_user::getInfoByOpenid($comment_info['openid']);
                      $pic = $userInfo['0']['img'];
                      $createtime     = date('Y-m-d H:m', $comment_info['createtime']);


                echo ' <li class="am-comment">
                              <a href="">
                                  <img class="am-comment-avatar" src="'.$pic.'" alt=""/> <!-- 头像 -->
                              </a>

                              <div class="am-comment-main">
                                  <header class="am-comment-hd">
                                      <div class="am-comment-meta">
                                          <a href="#link-to-user" class="am-comment-author">'.$comment_info['nikname'].'</a>
                                          <time datetime="2013-07-27T04:54:29-07:00" title="发表时间" class="am-fr">'.$createtime.'</time>
                                      </div>
                                  </header>
                                  <div class="am-comment-bd am-text-sm">
                                    '.$comment_info['desc'].'
                                  </div>
                              </div>
                          </li>
                          ';
                        }
                      }
              ?>
                         

                      </ul>
                  </div>
              </div>
        </div>
        </div>

    <footer data-am-widget="footer" class="am-footer am-footer-default" data-am-footer="{  }">
        <hr data-am-widget="divider" style="" class="am-divider am-divider-default"/>
        <div class="am-footer-miscs ">
            <p>CopyRight©2014 AllMobilize Inc.</p>
            <p>京ICP备13033158</p>
        </div>
    </footer>
    <!--底部-->
    <div data-am-widget="navbar" class="am-navbar am-cf" id="">
        <ul class="am-navbar-nav am-cf am-avg-sm-4 shop-footer">
            <li><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/cart.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"><i class="am-icon-lg am-icon-shopping-cart"></i><span class="am-badge am-round am-badge-danger" id="cartNum" ><?php echo $cartNum?></span></a></li>
            <li ><a type ="button" href="#" id="jionCart">加入购物车</a></li>
            <li><a href="#" id="buynow">立即购买</a></li>
        </ul>
        <script type="text/javascript">
            function showFooterNav(){
                $("#footNav").toggle();
            }

      

        </script>
    </div>
</div>
</body>
</html>
