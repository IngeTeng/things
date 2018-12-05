<?php
require('../../conn.php');
require('../../config.inc.php');
require('../../wx_config.php');
require($LIB_PATH.'cart.class.php');
require($LIB_TABLE_PATH.'table_cart.class.php');
require($LIB_PATH.'product.class.php');
require($LIB_TABLE_PATH.'table_product.class.php');
$userInfo = getUserInfo();
//var_dump($userInfo);
$cartInfos = table_cart::getInfoByOpenid($userInfo['openid']);
if(!empty($cartInfos)){
    foreach ($cartInfos as $cartInfo) {
                        # code...
                        $product = table_product::getInfoById($cartInfo['productid']);

                        if($product['issale']){
                            $price = $product['sale_price'];
                        }else{
                            $price = $product['price'];
                        }
                        $total_amount+=$price*$cartInfo['productnum'];
                    }
                     $total_amount = number_format($total_amount , 2);

    }


//$product = table_cart::getInfoByOpenId_ischecked($userInfo['openid'] , 1);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>购物车</title>
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
        //总金额
        var total_amount = <?php 
        if(!empty($total_amount)){
            echo  $total_amount;
        }else{
           echo  0;
        }
         ?>;
        var state = 0;
        //console.log(total_amount);
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
        function addQty(id , price){
            checkCounts('txtQty'+id);
            check_val=document.getElementById("checked-"+id).checked;
            var qty = parseInt($('#txtQty'+id).val());
            $('#txtQty'+id).val(qty+1);
            var qty_now = qty+1;
            //console.log(qty_now);
            //console.log(price);
            var totalprice = qty_now*price;
            //console.log(totalprice);
            if(check_val){
                total_amount = total_amount + price;
            }
            $('#total_amount').html(total_amount);
            $('#totalprice'+id).html(totalprice);
             $.ajax({
                            type: 'POST',
                            data: {
                                id: id,
                            productnum : qty_now
                            },
                            dataType: 'json',
                            url: 'cart_do.php?act=edit',
                            success: function (data) {
                                //layer.close(index);

                                code = data.code;
                                msg = data.msg;
                                switch (code) {
                                    case 1: 
                                    console.log('success');
                                        //$("#li-"+thisid).remove();
                                        //layer.msg(msg);
                                        break;
                                    default:
                                        //layer.msg(msg);
                                }
                            }
                        });
            //选择框
            /*obj = document.getElementsByName("checked");
            check_val = [];
             for(k in obj){
                if(obj[k].checked)
                    check_val.push(obj[k].value);
                }
            console.log(check_val);
            //console.log(check_val[0]);
            //console.log(check_val[1]);
            //alert(check_val);*/
            
        }
        function subtractQty(id , price){
            checkCounts('txtQty'+id);
            check_val=document.getElementById("checked-"+id).checked;
            var qty = parseInt($('#txtQty'+id).val());
            if(qty <=1){
                errordialog("商品数量不能小于1");
                return;
            }
            $('#txtQty'+id).val(qty-1);
            var qty_now = qty-1;
            //console.log(qty_now);
            //console.log(price);
            var totalprice = qty_now*price;
            //console.log(totalprice);
            if(check_val){
            total_amount = total_amount - price;
            }
            $('#total_amount').html(total_amount);
            $('#totalprice'+id).html(totalprice);
            $.ajax({
                            type: 'POST',
                            data: {
                                id: id,
                            productnum : qty_now
                            },
                            dataType: 'json',
                            url: 'cart_do.php?act=edit',
                            success: function (data) {
                                //layer.close(index);

                                code = data.code;
                                msg = data.msg;
                                switch (code) {
                                    case 1: 
                                    console.log('success');
                                        //$("#li-"+thisid).remove();
                                        //layer.msg(msg);
                                        break;
                                    default:
                                        //layer.msg(msg);
                                }
                            }
                        });
            
        }

        function delete_cart(id){
            /*$('#delete'+id).click(function () {*/
            //console.log('success');
               /* location.href = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/address_edit.php");?>?addressid=<?php echo $address['id'];?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect';*/
               var thisid = $('#delete'+id).parent('p').find('#cartid').val();
               //console.log(thisid+'success');
               check_val=document.getElementById("checked-"+id).checked;
               console.log(check_val);
               $.ajax({
                            type: 'POST',
                            data: {
                                id: thisid
                            },
                            dataType: 'json',
                            url: 'cart_do.php?act=del',
                            success: function (data) {
                                //layer.close(index);

                                code = data.code;
                                msg = data.msg;
                                res = data.res;
                                switch (code) {
                                    case 1: 
                                        
                                        $("#li-"+thisid).remove();
                                        layer.msg(msg);
                                        //console.log(res);
                                        if(res[3]==1){
                                            price = res['2'];
                                        }else{
                                            price = res['1'];
                                        }
                                        if(check_val){
                                            total_amount = total_amount - price*res[0];
                                        }
                                    
                                        $('#total_amount').html(total_amount);
                                        break;
                                    default:
                                        layer.msg(msg);
                                }
                            }
                        });
          /*  });*/

    }
        function condition(id){
            obj = document.getElementsByName("checked-"+id);
            check_val = [];
            for(k in obj){
                if(obj[k].checked)
                    check_val.push(obj[k].value);
            }
            return check_val;
        }

       function  check(id,productid){
        /*obj = document.getElementsByName("checked-"+id);
        check_val = [];
        for(k in obj){
            if(obj[k].checked)
                check_val.push(obj[k].value);
        }*/
        //console.log(check_val);
       // alert(check_val);
       // 
       check_val = condition(id);
       if(!isEmpty(check_val)){
            $.ajax({
                            type: 'POST',
                            data: {
                                id        : id,
                                ischecked : 1
                            },
                            dataType: 'json',
                            url: 'cart_do.php?act=select',
                            success: function (data) {
                                //layer.close(index);

                                code = data.code;
                                msg = data.msg;
                                res = data.res;
                                switch (code) {
                                    case 1: 
                                        
                                        /*$("#li-"+thisid).remove();
                                        layer.msg(msg);*/
                                        //console.log(res);
                                        if(res[3]==1){
                                            price = res['2'];
                                        }else{
                                            price = res['1'];
                                        }
                                        total_amount = total_amount + price*res[0];
                                        $('#total_amount').html(total_amount);
                                        break;
                                    default:
                                        layer.msg(msg);
                                }
                            }
                        });
       }else{   
            $.ajax({
                            type: 'POST',
                            data: {
                                id: id,
                                ischecked : 0
                            },
                            dataType: 'json',
                            url: 'cart_do.php?act=select',
                            success: function (data) {
                                //layer.close(index);

                                code = data.code;
                                msg = data.msg;
                                res = data.res;
                                switch (code) {
                                    case 1: 
                                        
                                        /*$("#li-"+thisid).remove();
                                        layer.msg(msg);*/
                                        //console.log(res);
                                        if(res[3]==1){
                                            price = res['2'];
                                        }else{
                                            price = res['1'];
                                        }
                                        total_amount = total_amount - price*res[0];
                                        $('#total_amount').html(total_amount);
                                        break;
                                    default:
                                        layer.msg(msg);
                                }
                            }
                        });
       }
    }

    function isEmpty(value) {
            return (Array.isArray(value) && value.length === 0) 
            || (Object.prototype.isPrototypeOf(value) && Object.keys(value).length === 0);
}

        function pay(){
            console.log('success');
             $.ajax({
                            type: 'POST',
                            data: {
                                openid        : '<?php echo $userInfo['openid'];?>',
                                ischecked : 1
                            },
                            dataType: 'json',
                            url: 'cart_do.php?act=select_topay',
                            success: function (data) {
                                //layer.close(index);
                                console.log(data);
                                code = data.code;
                                msg = data.msg;
                                res = data.res;
                                switch (code) {
                                    case 1: 
                                        
                                        if(res==1){
                                            location.href='https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/order.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect';
                                        }else{
                                            layer.msg(msg);
                                        }
                                        break;
                                    default:
                                        layer.msg(msg);
                                }
                            }
                        });

       }

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
                购物车
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
    <!-- <div class="uchome-info">
        <div class="uchome-info-uimg">
            <img src="default/img1.jpg" />
        </div>
        <div class="uchome-info-uinfo">
            <p>会员名字</p>
            <p>会员等级：<span class="red">普通会员</span></p>
            <p>余额：<span class="red">￥10000.00</span></p>
        </div>
    </div> -->
    <!--订单列表-->
    <div class="am-cf cart-panel">
        <div class="cart-list-panel"> 
            <ul class="am-avg-sm-1 cart-panel-ul">

            <?php 

                $cartInfos = table_cart::getInfoByOpenid($userInfo['openid']);
                //var_dump($cartInfos);
                if(!empty($cartInfos)){

                    foreach ($cartInfos as $cartInfo) {
                        # code...
                        $product = table_product::getInfoById($cartInfo['productid']);
                    if(!empty($product)){
                        if($product['issale']){
                            $price = $product['sale_price'];
                        }else{
                            $price = $product['price'];
                        }
                        $pic = $HTTP_PATH.$product['pic'];
                        //$total_amount=$price*$cartInfo['productnum'];
                        echo '<li id="li-'.$cartInfo['id'].'">
                <div class="am-fl">
                        <input type="checkbox" name="checked-'.$cartInfo['id'].'"  id="checked-'.$cartInfo['id'].'" onclick="check('.$cartInfo['id'].')" checked="checked" value="'.$cartInfo['productid'].' , '.$product['id'].'">
                </div>
                <div class="imgpanel"><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/product_detail.php").'?productid='.$product['id'].'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect"><img src="'.$pic.'" class="am-img-responsive"></a></div>
                <div class="infopanel">
                    <h3><a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/product_detail.php").'?productid='.$product['id'].'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect">'.$product['title'].'</a></h3>
                    <p>单价：<span class="red2 bold">'.$price.'</span> 元</p>
                    <p>总价：<span class="red2 bold" id="totalprice'.$cartInfo['id'].'">￥'.$price*$cartInfo['productnum'].'</span> 元</p>
                    <p>
                    <form class="am-form-inline" role="form">
                    <button type="button" class="am-btn am-btn-default" style="float:left; height:25px;line-height: 25px;padding: 0 8px;" onClick="subtractQty('.$cartInfo['id'].','.$price.');" ><i class="am-icon-minus"></i></button>
                    <input type="number" name="txtQty" id="txtQty'.$cartInfo['id'].'" class="am-form-field txt-qty am-text-center am-text-sm" value="'.$cartInfo['productnum'].'" style=" width:60px; margin-right:0px; height:25px; display:inline; float:left">
                    <button type="button" class="am-btn am-btn-default" style="float:left; height:25px;line-height: 25px;padding: 0 8px;" onClick="addQty('.$cartInfo['id'].','.$price.');"><i class="am-icon-plus"></i></button>
                    
                    </form>
                    </p>
                </div>
                   
                    <p>
                        <span id="delete'.$cartInfo['id'].'" onClick="delete_cart('.$cartInfo['id'].')" class="am-fr"><a class="am-badge am-badge-danger am-round">删除</a>
                        </span>
                        <input type="hidden" id="cartid" value="'.$cartInfo['id'].'"/>
                    </p>
                </li>';
                        }else{
                            $pic = $HTTP_PATH.$cartInfo['product_pic'];
                            echo '<li id="li-'.$cartInfo['id'].'">
                <div class="am-fl">
                        <input type="checkbox" id="checked-'.$cartInfo['id'].'" >
                </div>
                <div class="imgpanel"><a href="#"><img src="'.$pic.'" class="am-img-responsive"></a></div>
                <div class="infopanel">
                    <h3><a href="#">'.$cartInfo['product_title'].'</a></h3>
                    <p>单价：<span class="red2 bold">'.$cartInfo['price'].'</span> 元</p>
                    <p>总价：<span class="red2 bold" id="totalprice'.$cartInfo['id'].'">￥'.$price*$cartInfo['productnum'].'</span> 元</p>
                    <p>
                    <form class="am-form-inline" role="form">
                    <button type="button" class="am-btn am-btn-default" style="float:left; height:25px;line-height: 25px;padding: 0 8px;"  ><i class="am-icon-minus"></i></button>
                    <input type="number" name="txtQty" id="txtQty'.$cartInfo['id'].'" class="am-form-field txt-qty am-text-center am-text-sm" value="'.$cartInfo['productnum'].'" style=" width:60px; margin-right:0px; height:25px; display:inline; float:left">
                    <button type="button" class="am-btn am-btn-default" style="float:left; height:25px;line-height: 25px;padding: 0 8px;" ><i class="am-icon-plus"></i></button>
                    
                    </form>
                    </p>
                </div>
                   
                    <p>
                        <span id="delete'.$cartInfo['id'].'" onClick="delete_cart('.$cartInfo['id'].')" class="am-fr"><a class="am-badge am-badge-danger am-round">删除</a>
                        </span>
                        <input type="hidden" id="cartid" value="'.$cartInfo['id'].'"/>
                    </p>
                    <p>
                    <span calss="am-fr"><a class="am-badge am-badge-danger am-round">已失效</a>
                        </span>
                    
                    </p>
                </li>';
                        }
                    }
                }
            ?>
           <!--  <li>
               <div class="am-fl">
                       <input type="checkbox" checked="checked" value="">
               </div>
               <div class="imgpanel"><a href="#"><img src="default/img3.jpg" class="am-img-responsive"></a></div>
               <div class="infopanel">
                   <h3><a href="#">450ml柔顺丰盈护发素正品</a></h3>
                   <p>品牌：乔治卡罗尔</p>
                   <p>价格：<span class="red2 bold">78.00</span> 元</p>
                   <p>
                   <form class="am-form-inline" role="form">
                   <button type="button" class="am-btn am-btn-default" style="float:left; height:25px;line-height: 25px;padding: 0 8px;" onClick="subtractQty();" ><i class="am-icon-minus"></i></button>
                   <input type="number" name="txtQty" id="txtQty" class="am-form-field txt-qty am-text-center am-text-sm" value="1" style=" width:60px; margin-right:0px; height:25px; display:inline; float:left">
                   <button type="button" class="am-btn am-btn-default" style="float:left; height:25px;line-height: 25px;padding: 0 8px;" onClick="addQty();"><i class="am-icon-plus"></i></button>
                   </form>
                   </p>
               </div>
                  
                   <p><span class="am-fr"><a class="am-badge am-badge-danger am-round">删除</a></span></p>
               </li> -->
           
            
                <!-- <li>
                    <div class="am-fl">
                            <input type="checkbox" value="">
                    </div>
                    <div class="imgpanel"><a href="#"><img src="default/img3.jpg" class="am-img-responsive"></a></div>
                    <div class="infopanel">
                        <h3><a href="#">450ml柔顺丰盈护发素正品</a></h3>
                        <p>品牌：乔治卡罗尔</p>
                        <p>价格：<span class="red2 bold">78.00</span> 元  X <input class="am-input-sm txt-qty" type="number" value="1"></p>
                        <p><span class="am-fr"><a class="am-badge am-badge-danger am-round">删除</a></span>库存：<span class="red2 bold">100</span> 件</p>
                    </div>
                </li>
                <li>
                    <div class="am-fl">
                            <input type="checkbox" checked="checked">
                    </div>
                    <div class="imgpanel"><a href="#"><img src="default/img3.jpg" class="am-img-responsive"></a></div>
                    <div class="infopanel">
                        <h3><a href="#">450ml柔顺丰盈护发素正品</a></h3>
                        <p>品牌：乔治卡罗尔</p>
                        <p>价格：<span class="red2 bold">78.00</span> 元  X <input class="am-input-sm txt-qty" type="number" value="1"></p>
                        <p><span class="am-fr"><a class="am-badge am-badge-danger am-round">删除</a></span>库存：<span class="red2 bold">100</span> 件</p>
                    </div>
                </li>
                <li>
                    <div class="am-fl">
                            <input type="checkbox" value="">
                    </div>
                    <div class="imgpanel"><a href="#"><img src="default/img3.jpg" class="am-img-responsive"></a></div>
                    <div class="infopanel">
                        <h3><a href="#">450ml柔顺丰盈护发素正品</a></h3>
                        <p>品牌：乔治卡罗尔</p>
                        <p>价格：<span class="red2 bold">78.00</span> 元  X <input class="am-input-sm txt-qty" type="number" value="1"></p>
                        <p><span class="am-fr"><a class="am-badge am-badge-danger am-round">删除</a></span>库存：<span class="red2 bold">100</span> 件</p>
                    </div>
                </li> -->
            </ul>
        </div>
    </div>
    <div class="cart_foot am-cf mg10">
        <div class="am-fl">
                <!-- <input type="checkbox" value="">&nbsp;&nbsp;全选 -->
        </div>
        <span class="am-fr">
            合计：<span class="red2 bold" id="total_amount">￥<?php if(!empty($total_amount)){
                echo $total_amount;
                }else{
                echo 0.00;
                }
                ?></span>元
        </span>
    </div>
    <div class="cart-tool">
        <!-- <a class="am-btn am-btn-sm am-btn-success" href="#">
            <i class="am-icon-chevron-left"></i>
            返回
        </a> -->
       <!--  <a class="am-btn am-btn-sm am-btn-warning" href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/order.php");?>&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect">
           <i class="am-icon-shopping-cart"></i> -->
           <a class="am-btn am-btn-sm am-btn-warning" id="btn_pay" onClick="pay()">
            <i class="am-icon-shopping-cart"></i>
            结账
        </a>
    </div>
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
