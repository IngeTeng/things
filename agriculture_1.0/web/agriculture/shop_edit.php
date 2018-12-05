<?php
require('../../conn.php');
/*require('../../config.inc.php');
require('../../wx_config.php');*/
require($LIB_PATH.'product.class.php');
require($LIB_TABLE_PATH.'table_product.class.php');
$phone = $_GET['phone'];
$cate = $_GET['cate'];
$id = $_GET['id'];
try {
    $r = Product::getInfoById($id);
    $product_id                     = $r['id'];
    $product_cateid                 = $r['cateid'];
    $product_title                  = $r['title']; 
    $product_num                    = $r['num'];
    $product_pic                    = $r['pic'];
    $product_price                  = $r['price'];
    $product_post_price             = $r['post_price'];
    $product_issale                 = $r['issale'];
    $product_ishot                  = $r['ishot'];
    $product_isnew                  = $r['isnew'];
    $product_sale_price             = $r['sale_price'];
} catch(MyException $e){
    echo $e->getMessage();
    exit();
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>修改商品</title>
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
    <script type="text/javascript">
    $(function(){
    /*    if(<?php echo $product_issale;?>==1){
            $("#issale1").attr("checked", "checked");
        }else{
            $("#issale2").attr("checked", "checked");
        }
         if(<?php echo $product_ishot;?>){
            $("#ishot1").attr("checked", "checked");
        }else{
            $("#ishot2").attr("checked", "checked");
        }
        if(<?php echo $product_isnew;?>){
            $("#isnew1").attr("checked", "checked");
        }else{
            $("#isnew2").attr("checked", "checked");
        }*/

       
         function get($r){  
            var value='';  
            var radio = document.getElementsByName($r);  
            for(var i = 0;i<radio.length;i++)  
            {  
                if(radio[i].checked==true)  
                {value = radio[i].value;  
                break;}  
            }  
        //alert(value);  
         return value;
        }  

                //修改商品
                $('#btn_submit').click(function(){
                    //console.log('success');
                    //start数据检查                 
                    var cateid         = "<?php echo $product_cateid;?>"
                    var title          = $('input[name=title]').val();
                    var num            = $('input[name=num]').val();
                    var pic            = "<?php echo $product_pic;?>"
                    var price          = $('input[name=price]').val();
                    var post_price     = $('input[name=post_price]').val();
                    var issale         = get("issale");
                    var ishot          = get("ishot");;
                    var isnew          = get("isnew");
                    var sale_price     = $('input[name=sale_price]').val();

        
    
                    if(cateid == '0'){
                        layer.msg('商品分类不能为空');
                        return false;
                    }
                    if(title == ''){
                        layer.msg('商品名称不能为空');
                        return false;
                    }
                    if(num == ''){
                        layer.msg('商品库存量不能为空');
                        return false;
                    }
                    if(pic == ''){
                        layer.msg('商品图片不能为空');
                        return false;
                    }
                    if(price == ''){
                        layer.msg('商品价格不能为空');
                        return false;
                    }
                    if(issale == ''){
                        layer.msg('是否促销不能为空');
                        return false;
                    }
                    if(ishot == ''){
                        layer.msg('是否热卖不能为空');
                        return false;
                    }
                    if(isnew == ''){
                        layer.msg('是否新品不能为空');
                        return false;
                    }
                    
                
                     //end数据检查
                    
                    $.ajax({
                        type : 'POST',
                        data : {
                            cateid             : cateid,
                            title              : title,
                            num                : num,
                            pic                : pic,
                            price              : price,
                            post_price         : post_price,
                            issale             : issale,
                            ishot              : ishot,
                            isnew              : isnew,
                            sale_price         : sale_price,
                            id                 : <?php echo $product_id?>
                    
                          
                        },
                        dataType : 'json',
                        url      : 'shop_do.php?act=edit',
                        success  : function(data){
                            console.log('success');
                            var code = data.code;
                            var msg  = data.msg;
                            console.log(code);
                            console.log(msg);

                            switch(code){
                                case 1:

                                    //layer.msg(msg);
                                    layer.msg(msg,function(index){
                                        location.href = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/shop_list.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect';


                                    });
                                    /*layer.alert(msg, {icon: 6,shade: false}, function(index){
                                        location.href = 'shop_list';
                                    });*/
                                    
                                    break;
                                default:
                                    layer.msg(msg);
                            }
                        }
                    });
                    
                });
    });
    </script>
</head>

<body>
<div class="container">
    <header data-am-widget="header" class="am-header am-header-default my-header">
        <!--首页-->
        <div class="am-header-left am-header-nav">
            <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/shop_list.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect" class="">
                <i class="am-header-icon am-icon-chevron-left"></i>
            </a>
        </div>
        <!--主标题-->
        <h1 class="am-header-title">
            <a href="#" class="">
                修改商品
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
        <div class="am-cf" style="margin-bottom: 10px">
            <div class="am-u-sm-4">
                商品图片

            </div>
            <div class="am-u-sm-8">
                <img src="<?php echo $HTTP_PATH.$product_pic;?>" alt="" class="am-img-responsive">
                <!-- <div class="am-form-group am-form-file">
                    <div>
                        <button type="button" class="am-btn am-btn-default am-btn-sm">
                            <i class="am-icon-image" style="color:#78c3ca"></i> 上传图片</button>
                    </div>
                    <input type="file" id="doc-ipt-file-2">
                </div> -->
            </div>
        </div>
        <div class="am-cf" style="margin-bottom: 10px">
            <div class="am-u-sm-4">
                商品名称：
            </div>
            <div class="am-u-sm-8">
                <input type="text" name="title" value="<?php echo $product_title;?>" class="" id="doc-ipt-email-1" placeholder="输入商品名称">
            </div>
        </div>
        <div class="am-cf" style="margin-bottom: 10px">
            <div class="am-u-sm-4">
                商品价格：
            </div>
            <div class="am-u-sm-8">
                <input type="text" name="price" value="<?php echo $product_price;?>" class="" id="doc-ipt-email-1" placeholder="输入商品价格">
            </div>
        </div>
        <div class="am-cf" style="margin-bottom: 10px">
            <div class="am-u-sm-4">
                促销价格：
            </div>
            <div class="am-u-sm-8">
                <input type="text" name="sale_price" value="<?php echo $product_sale_price;?>" class="" id="doc-ipt-email-1" placeholder="输入商品促销价格">
            </div>
        </div>
        <div class="am-cf" style="margin-bottom: 10px">
            <div class="am-u-sm-4">
                物流单价：
            </div>
            <div class="am-u-sm-8">
                <input type="text" name="post_price" value="<?php echo $product_post_price;?>" class="" id="doc-ipt-email-1" placeholder="输入商品物流单价">
            </div>
        </div>
        <div class="am-cf" style="margin-bottom: 10px">
            <div class="am-u-sm-4">
                商品库存
            </div>
            <div class="am-u-sm-8">
                <input type="text" name="num" class="" value="<?php echo $product_num;?>" id="doc-ipt-email-1" placeholder="输入商品库存">
            </div>
        </div>
        <div class="am-cf" style="margin-bottom: 10px">
            <div class="am-u-sm-4">
                是否促销：
            </div>
            <div class="am-u-sm-8" >

                <input type="radio" name="issale" value="1" id="issale1"  <?php if($product_issale == 1) echo ' checked ';?>> 是
                <input type="radio" name="issale" value="0" id="issale2" <?php if($product_issale == 0) echo ' checked ';?> > 否
            </div>
        </div>
        <div class="am-cf" style="margin-bottom: 10px">
            <div class="am-u-sm-4">
                是否热卖：
            </div>
            <div class="am-u-sm-8">
    
                <input type="radio" name="ishot" value="1" id="ishot1" <?php if($product_ishot == 1) echo ' checked ';?>> 是
                <input type="radio" name="ishot" value="0" id="ishot2" <?php if($product_ishot == 0) echo ' checked ';?>> 否
            </div>
        </div>
        <div class="am-cf" style="margin-bottom: 10px">
            <div class="am-u-sm-4">
                是否新品：
            </div>
            <div class="am-u-sm-8">

                <input type="radio" name="isnew" value="1" id="isnew1" <?php if($product_isnew == 1) echo ' checked ';?>> 是
                <input type="radio" name="isnew" value="0" id="isnew2" <?php if($product_isnew == 0) echo ' checked ';?>> 否
            </div>
        </div>
        

        <!-- <div class="am-cf" style="margin-bottom: 10px">
            <div class="am-u-sm-4">
                商品详情
            </div>
            <div class="am-u-sm-8">
                <div class="am-form-group">
                    <textarea class="" rows="5" id="doc-ta-1"></textarea>
                </div>
            </div>
        </div> -->
        <p class="am-text-center" \><button type="submit" id="btn_submit" class="am-btn am-btn-danger am-radius">保存</button></p>


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
