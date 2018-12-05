<?php
require('../../conn.php');
require('../../config.inc.php');
require('../../wx_config.php');
require($LIB_PATH.'category.class.php');
require($LIB_TABLE_PATH.'table_category.class.php');
require($LIB_PATH.'product.class.php');
require($LIB_TABLE_PATH.'table_product.class.php');
require($LIB_PATH.'user.class.php');
require($LIB_TABLE_PATH.'table_user.class.php');
require($LIB_PATH.'partner.class.php');
require($LIB_TABLE_PATH.'table_partner.class.php');
$userInfo = getUserInfo();
//var_dump($openid);
$user=table_user::getInfoByOpenid($userInfo['openid']);
if(empty($user)){
    //var_dump($userInfo);
    //var_dump($userInfo['nickname']);
    $tmpStr = json_encode($userInfo['nickname']);  
    $tmpStr = preg_replace("#(\\\ud[0-9a-f]{3})|(\\\ue[0-9a-f]{3})#ie","",$tmpStr); //将emoji的去掉
    $nickname = json_decode($tmpStr, true);  
    $userAttr = array(
                    'img'        =>$userInfo['headimgurl'],
                    'nikname'    =>$nickname,
                    'sex'        =>$userInfo['sex'],
                    'openid'     =>$userInfo['openid'],
                    'createtime' =>$userInfo['createtime']
                    );
    //var_dump($userAttr);
    //exit;
    $res=User::add_front($userAttr);
    //var_dump($res);
}else{
    //var_dump('111');
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
<script type="text/javascript">
       
$(function() {
    
    //查询
    $('#search_product').click(function(){

        s_title       = $('#search_title').val();
        location.href='search_list.php?title='+s_title;
    });

        document.getElementById("search_cate").onchange=hs1;   // 监听select  option事情
        function hs1(){
        //var s_parentid = <?php echo $parentid;?>;
        s_parentid=document.getElementById("search_cate").value; 
        console.log(s_parentid);
        //location.href = 'home.php?parentid='+s_parentid;
        if(s_parentid==-1){

        }else{
        $.ajax({
                        type : 'POST',
                        data : {
                            
                            parentid             : s_parentid
                            
                          
                        },
                        dataType : 'json',
                        url      : 'home_do.php',
                        success  : function(data){
                            console.log('sucess');
                            location.href = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?php echo $appid;?>&redirect_uri=<?php echo urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/home.php");?>?parentid='+s_parentid+'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect';
                        }
                    });
        }
    }


});
</script>
<body>
<div class="container">
    <header data-am-widget="header" class="am-header am-header-default my-header">
        <!--首页-->
        <div class="am-header-left am-header-nav">
            <a href="#" class="">
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
                <input type="text" class="am-form-field am-radius" name="title" id="search_title"  placeholder="搜索">
                <span class="am-input-group-btn">
                <button class="am-btn am-radius" type="button"  id="search_product"><span class="am-icon-search"></span></button>
              </span>
            </div>
        </div>
    </div>
    <!-- banner轮播图 -->
    <div data-am-widget="slider" class="am-slider am-slider-a1" data-am-slider='{&quot;directionNav&quot;:false}' >
        <ul class="am-slides">
            <li>
                <img src="pic/banner1.jpg">
            </li>
            <li>
                <img src="pic/banner2.jpg">
            </li>
            <li>
                <img src="pic/banner3.jpg">
            </li>
            <li>
                <img src="pic/banner4.jpg">
            </li>
        </ul>
    </div>
    <div class="am-cf am-g">
        <!--分类和推荐分类-->
        <div class="am-input-group mg10">
            <span class="am-input-group-label">分类</span>
                <select data-am-selected class="am-form-field" id="search_cate">
                <option value="-1">请选择分类</option>
            <?php 

                $row_cates = table_category::getInfoByParent(0);
                //var_dump($row_cates);
                if(!empty($row_cates)) {
                        foreach($row_cates as $row_cate) {
                            $rs = table_category::getInfoByParent($row_cate['id']);
                            $str = '';
                            if(!empty($rs)){
                                foreach ($rs as $r){                        
                                    $str .= $r['title'].'+';
                                }
                                 $str = rtrim($str,'+');
                            }      
                    echo '<option name="parentid" value="'.$row_cate['id'].'" >'.$row_cate['title'].'</option >';  
                    } 
                }else{
                    echo '<option >暂无分类</option>';
                }              
            ?>
            <!-- <select data-am-selected class="am-form-field">
                <option value="a">推荐分类</option>
                <option value="b" selected>推荐分类</option>
                <option value="o">产品分类</option>
                <option value="m">分类二</option>
                <option value="d" disabled>分类三</option>
            </select> -->
                    </select>
        </div>
        <div class="mg10">
            <!-- <ul data-am-widget="gallery" class="am-gallery am-avg-sm-3 am-avg-md-3 am-avg-lg-4 am-gallery-default" data-am-gallery="{ pureview: true }" > -->
                <ul data-am-widget="gallery" class="am-gallery am-avg-sm-3 am-avg-md-3 am-avg-lg-4 am-gallery-default"  >
                <?php 


                    if(!empty($_GET['parentid'])){
                        $parentid  = safeCheck($_GET['parentid']);
                        //var_dump($parentid);
                    }
                    else{
                        $parentid  = 1;
                    }
                    $row_son_cates = table_category::getInfoByParent($parentid);
                    if(!empty($row_son_cates)) {
                        foreach($row_son_cates as $row_son_cate) {
                            $pic    = $HTTP_PATH.$row_son_cate['pic'];
                    echo '<li>
                                <div class="am-gallery-item">
                                    <a href="search_list.php?cate='.$row_son_cate['id'].'" class="good-item">
                                        <img src="'.$pic.'"  alt="农贸复合肥"/>
                                        <h3 class="am-gallery-title">'.$row_son_cate['title'].'</h3>
                                    </a>
                                </div>
                

                         </li>';
                        }

                    }
                ?>

                <!-- <li>
                    <div class="am-gallery-item">
                        <a href="" class="good-item">
                            <img src="default/img2.jpg"  alt="农贸复合肥"/>
                            <h3 class="am-gallery-title">农贸复合肥</h3>
                            <div class="am-gallery-desc red">￥89.00</div>
                        </a>
                    </div>
                
                
                </li> -->
            </ul>
        </div>
        <!--热销产品-->
        <div class="am-panel am-panel-default am-panel-warning mg10">
            <div class="am-panel-hd"><a href="#" class="am-text-warning">热销产品</a></div>
            <div class="am-panel-bd">
                <ul data-am-widget="gallery" class="am-gallery am-avg-sm-3 am-avg-md-3 am-avg-lg-4 am-gallery-default" >
                    <?php 
                    $ishot_rows = table_product::getInfoByIshot(1);

                     if(!empty($ishot_rows)) {
                        foreach($ishot_rows as $ishot_row) {
                            $ishot_pic    = $HTTP_PATH.$ishot_row['pic'];
                            //var_dump($issale_row);
    
                    echo '<li>
                            <div class="am-gallery-item">
                                <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/product_detail.php").'?productid='.$ishot_row['id'].'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect" class="good-item">
                                    <img src="'.$ishot_pic.'"  alt="农贸复合肥"/>
                                    <h3 class="am-gallery-title">'.$ishot_row['title'].'</h3>
                                <div class="am-gallery-desc red">￥'.$ishot_row['price'].'</div>
                                </a>
                            </div>
                        </li>';
                        }

                     }
                    ?>

            
                </ul>

            </div>
        </div>
        <div class="am-panel am-panel-default am-panel-warning mg10">
            <div class="am-panel-hd"><a href="#" class="am-text-warning">促销产品</a></div>
            <div class="am-panel-bd">
                <ul data-am-widget="gallery" class="am-gallery am-avg-sm-3 am-avg-md-3 am-avg-lg-4 am-gallery-default"  >
                   <?php 
                    $issale_rows = table_product::getInfoByIssale(1);

                     if(!empty($issale_rows)) {
                        foreach($issale_rows as $issale_row) {
                            $issale_pic    = $HTTP_PATH.$issale_row['pic'];
                            //var_dump($issale_row);
    
                    echo '<li>
                            <div class="am-gallery-item">
                                <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/product_detail.php").'?productid='.$issale_row['id'].'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect" class="good-item">
                                    <img src="'.$issale_pic.'"  alt="农贸复合肥"/>
                                    <h3 class="am-gallery-title">'.$issale_row['title'].'</h3>
                                <div class="am-gallery-desc red">￥'.$issale_row['sale_price'].'</div>
                                </a>
                            </div>
                        </li>';
                        }

                     }
                    ?>
                </ul>

            </div>
        </div>
        <div class="am-panel am-panel-default am-panel-warning mg10">
            <div class="am-panel-hd"><a href="#" class="am-text-warning">新品上市</a></div>
            <div class="am-panel-bd">
                <ul data-am-widget="gallery" class="am-gallery am-avg-sm-3 am-avg-md-3 am-avg-lg-4 am-gallery-default"  >
                    <?php 
                    $isnew_rows = table_product::getInfoByIsnew(1);

                     if(!empty($isnew_rows)) {
                        foreach($isnew_rows as $isnew_row) {
                            $isnew_pic    = $HTTP_PATH.$isnew_row['pic'];
                            //var_dump($issale_row);
    
                    echo '<li>
                            <div class="am-gallery-item">
                                <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode("http://www.yanxin325.com/agriculture_1.0/web/agriculture/product_detail.php").'?productid='.$isnew_row['id'].'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect" class="good-item">
                                    <img src="'.$isnew_pic.'"  alt="农贸复合肥"/>
                                    <h3 class="am-gallery-title">'.$isnew_row['title'].'</h3>
                                <div class="am-gallery-desc red">￥'.$isnew_row['price'].'</div>
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

     <!-- <ul class="com-box am-avg-sm-2"> -->
     <!-- <ul class="com-box ">
     <h3>加盟商列表</h3> -->
     <div class="am-panel am-panel-default am-panel-warning mg10">
            <div class="am-panel-hd"><a href="#" class="am-text-warning">加盟商列表</a></div>
        <ul class="com-box ">
        <li class="am-text-left">
            


            <?php
             $partners = partner::getAllList();
        if(!empty($partners)){
            
            foreach ($partners as $partner) {
                if($partner['state']==1){
                    $str = $partner['company'].':'.$partner['product'];
                echo '
            
            <p><a href="product_list.php?phone='.$partner['phone'].'">'.$str.'&nbsp;&nbsp;'.$partner['phone'].'</a></p>
            
        ';
            }
        }
         }


            ?>
            
        </li>
        </ul>
      </div>
        <!-- </li>
        
            </ul>  -->
    
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
