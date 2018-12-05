<?php
require('../../conn.php');
require('../../config.inc.php');
require('../../wx_config.php');
require($LIB_PATH.'partner.class.php');
require($LIB_TABLE_PATH.'table_partner.class.php');
require($LIB_PATH.'user.class.php');
require($LIB_TABLE_PATH.'table_user.class.php');
//获取数字签名
$jsapi_ticket=getJsApiTicket();
$nonceStr = getRandCode();
$time = time();
$url = curPageURL();
$signature = getSignature($jsapi_ticket,$nonceStr,$time,$url);
//获取用户信息
$userInfo = getUserInfo();
$partnerInfo = table_partner::getInfoByOpenid($userInfo['openid']);
/*$user=table_user::getInfoByOpenid($userInfo['openid']);
if(empty($user)){
    //var_dump($userInfo);
    //var_dump($userInfo['nickname']);
    $partnerAttr = array(
                    'img'        =>$userInfo['headimgurl'],
                    'nikname'    =>$userInfo['nickname'],
                    'sex'        =>$userInfo['sex'],
                    'openid'     =>$userInfo['openid'],
                    'createtime' =>$userInfo['createtime']
                    );
    $res=User::add_front($userAttr);
    //var_dump($res);
}else{
    //var_dump('111');
}*/

$urlnext="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/partner.php")."&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>加盟</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="amazeui/css/amazeui.min.css"/>
    <link rel="stylesheet" href="default/style.css"/>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script src="amazeui/js/jquery.min.js"></script>
    <script type="text/javascript" src="../../admin/js/layer/layer.js"></script>
    <script src="amazeui/js/amazeui.min.js"></script>
    <script type="text/javascript">
    wx.config({    
    debug: false,    
    appId: '<?php echo $appid;?>',    //正确
    timestamp: '<?php echo $time;?>',          //?
    nonceStr: '<?php echo $nonceStr;?>',    
    signature: '<?php echo $signature;?>',    
    jsApiList: [        
    'chooseImage',    
    'previewImage',    
    'uploadImage',      
    ]    
    });
    // 5 图片接口
    // 5.1 拍照、本地选图
    wx.ready(function () {
    var images = {
        localId: [],
        serverId: []
      };
   
    $("#chooseImage").click(function(){
      wx.chooseImage({
          success: function (res) {
            images.localId = res.localIds;
            console.log(images.localId);
            //$("#chooseImage").attr("src",images.localId);//TODO 这里如果上传多张照片，无法在手机上显示
            alert('已选择 ' + res.localIds.length + ' 张图片');
            //layer.msg('已选择 ' + res.localIds.length + ' 张图片');
            /*wx.previewImage({
                current:images.localId,
                urls: images.localId // 需要预览的图片http链接列表
            });*/
          }
        });
    });

   $("#upload").click(function(){
    if (images.localId.length == 0) {
      //alert('请先使用 chooseImage 接口选择图片');
      layer.msg('请先使用 chooseImage 接口选择图片');
      return;
    }
    var i = 0, length = images.localId.length;
    images.serverId = [];
    function upload() {
      wx.uploadImage({
        localId: images.localId[i],
        success: function (res) {
          i++;
          
          //alert('已上传：' + i + '/' + length);
          layer.msg('已上传：' + i + '/' + length);
          images.serverId.push(res.serverId);
          serverId = res.serverId;

          var name                  = $('input[name=name]').val();
          var phone                 = $('input[name=phone]').val();
          var address               = $('input[name=address]').val();
          var product               = $('input[name=product]').val();
          var company               = $('input[name=company]').val();

           $.ajax({
                        type        : 'POST',
                        data        : {
                                serverId   : serverId,
                                name       : name,
                                nikname    : "<?php echo $userInfo['nickname'];?>",
                                openid     : "<?php echo $userInfo['openid'];?>",
                                phone      : phone,
                                address    : address,
                                product    : product,
                                company    : company

                               
                        },
                        dataType:     'json',
                        url :         '../../getImageServerId.php',
                        success :     function(data){
                                            console.log('sccess');
                                            code = data.code;
                                            msg  = data.msg;
                                            //msg = '2222';
                                            switch(code){
                                                case 1:

                                                //location.href = "<?php echo $urlnext;?>";
                                               layer.msg(msg);
                                                location.href = "<?php echo $urlnext;?>";
                                                    break;
                                                default:
                                                    layer.alert(msg, {icon: 5});
                                            }
                
                                      }
                    });
           //console.log('3333');
          if (i < length) {
            upload();
          }
        },
        fail: function (res) {
          alert(JSON.stringify(res));
        }
      });
    }
    upload();
  });
wx.error(function(res){

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
                加盟
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
    <img src="http://s.amazeui.org/media/i/demos/bing-1.jpg" class="am-img-responsive">
    <div class="mg10">
        <div class="paoduct-title-panel">
        <h2 class="product-h1">加盟本平台三大利好：</h2>
        1、解除高昂房租、店员、大量囤货费用！<br>
       2、解除资金流动停滞之烦恼！<br>
        3、有300-500名分销商为您服务，让您的生意在不知不觉中如日中天!</p>
           <!--  <h2 class="product-h1">经销商特权</h2> -->
          <!--   <ul class="am-list am-list-border">
              <li>
                  <a href="" class="am-cf">
                  <div class="am-u-sm-3">
                      <img src="default/wd.png" alt="" class="am-img-responsive">
                  </div>
                  <div class="am-u-sm-9">
                      <p>独立微店 <br>
                      拥有自己的微店</p>
                  </div>
                  </a>
              </li>
              <li>
                  <a href="" class="am-cf">
                      <div class="am-u-sm-3">
                          <img src="default/yj.png" alt="" class="am-img-responsive">
                      </div>
                      <div class="am-u-sm-9">
                          <p>销售拿佣金</p>
                          <p>微店卖出商品，您可以获得佣金</p>
                      </div>
                  </a>
              </li>
          </ul> -->
        </div>

        <?php if(empty($partnerInfo)): ?>
        <div class="cart-panel">
            <div class="am-form-group am-form-icon">
                <i class="am-icon-user" style="color:#329cd9"></i>
                <input type="text" class="am-form-field  my-radius" name="name" placeholder="姓名">
            </div>
            <div class="am-form-group am-form-icon">
                <i class="am-icon-phone" style="color:#f09513"></i>
                <input type="text" class="am-form-field  my-radius" name="phone" placeholder="请输入11位手机号码">
            </div>
            <div class="am-form-group am-form-icon">
                <i class="am-icon-map-marker" style="color:#e88888"></i>
                <input type="text" class="am-form-field  my-radius"  name="company" placeholder="微店名称">
            </div>
            <div class="am-form-group am-form-icon">
                <i class="am-icon-map-marker" style="color:#e88888"></i>
                <input type="text" class="am-form-field  my-radius"  name="address" placeholder="请输入详细地址">
            </div>
            <div class="am-form-group am-form-icon">
                <i class="am-icon-envelope" style="color:#e9c740"></i>
                <input type="text" class="am-form-field  my-radius" name="product" placeholder="请输入产品信息">
            </div>
             <!-- begin  我自己加的-->
            <!-- <p class="am-text-center" ><img src="default/qrcode.jpg" id="chooseImage" ></p> -->
             <!-- end  我自己加的-->
           <div class="am-form-group am-form-file">
           
              <div>
               
                   <button type="button" class="am-btn am-btn-default am-btn-sm" id="chooseImage">
                       <i class="am-icon-image" style="color:#78c3ca"></i> 上传您的二维码</button>
                       <p>请您先将您微信钱包中的收款二维码截图，然后从相册中选择上传，如有疑问请提交工单或拨打客服热线。</p>
               </div>
                <!-- <input type="file" id="doc-ipt-file-2"> -->
           </div>
            <p class="am-text-center"><button type="submit" id="upload" class="am-btn am-btn-danger am-radius">申请</button></p>
        </div>
        <?php endif;?>

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
        <li class="on">
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
        <li>
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
