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
//var_dump($partner['id']);
if($partner['state']==1){
    $cate = '高级经销商';
    $cateid = 3;
}

$user = User::getInfoByOpenid($userInfo['openid']);
//var_dump($user);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>消息设置</title>
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
    //检查选中状态
    function condition(id){
            obj = document.getElementsByName("checked-"+id);
            check_val = [];
            for(k in obj){
                if(obj[k].checked)
                    check_val.push(obj[k].value);
            }
            return check_val;
        }
    function  check(id,role){
        check_val = condition(id);
        //alert(check_val);
        if(role=='user'){
            var roleid = '<?php echo $user['0']['id'];?>';
        }else{
            var roleid = '<?php echo $partner['id'];?>';
        }
        if(!isEmpty(check_val)){
            $.ajax({
                            type: 'POST',
                            data: {
                                roleid    : roleid,
                                id        : id,
                                state     : 2
                            },
                            dataType: 'json',
                            url: 'msg_do.php?act='+role,
                            success: function (data) {
                                //layer.close(index);

                                code = data.code;
                                msg = data.msg;
                                res = data.res;
                                switch (code) {
                                    case 1: 
                                        
                                        break;
                                    default:
                                        //layer.msg(msg);
                                }
                            }
                        });
       }else{   
            $.ajax({
                            type: 'POST',
                            data: {
                                roleid    : roleid,
                                id   : id,
                                state: 1

                            },
                            dataType: 'json',
                            url: 'msg_do.php?act='+role,
                            success: function (data) {
                                //layer.close(index);

                                code = data.code;
                                msg = data.msg;
                                res = data.res;
                                switch (code) {
                                    case 1: 
                                        
                                        //$("#li-"+thisid).remove();
                                        //layer.msg(msg);
                                        //console.log(res);
                                        
                                        break;
                                    default:
                                        //layer.msg(msg);
                                }
                            }
                        });
       }
    }

    function isEmpty(value) {
            return (Array.isArray(value) && value.length === 0) 
            || (Object.prototype.isPrototypeOf(value) && Object.keys(value).length === 0);
}


    </script>

</head>

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
                消息设置
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
    <div class="am-panel am-panel-danger mg10">
        <div class="am-panel-hd"><a href="#" class="am-text-danger">商城消息提醒</a></div>
        <div>
            <ul class="am-list am-list-border">
                <li><a > 订单提交通知
                    <div class="am-fr" style="width: 3rem">
                        <div class="bg_con">
                            <input id="checked-1" type="checkbox" name="checked-1" class="switch" 
                            <?php
                             if($user['0']['state1']==2)
                            { 
                                echo 'checked="checked"';

                            }
                            ?>  onclick="check(1,'user')" value="1"/>
                            <label for="checked-1"></label>
                        </div>
                    </div>
                </a></li>
                <li><a > 订单取消通知
                    <div class="am-fr" style="width: 3rem">
                        <div class="bg_con">
                            <input id="checked-2" type="checkbox" name="checked-2" class="switch" 
                            <?php
                             if($user['0']['state2']==2)
                            { 
                                echo 'checked="checked"';

                            }
                            ?> 
                             onclick="check(2,'user')" value="2"/>
                            <label for="checked-2"></label>
                        </div>
                    </div>
                </a></li>
                <li><a > 订单发货通知
                    <div class="am-fr" style="width: 3rem">
                        <div class="bg_con">
                            <input id="checked-3" type="checkbox" name="checked-3" class="switch" 
                            <?php
                             if($user['0']['state3']==2)
                            { 
                                echo 'checked="checked"';

                            }
                            ?> 
                            onclick="check(3,'user')" value="3"/>
                            <label for="checked-3"></label>
                        </div>
                    </div>
                </a></li>
                <li><a > 确认收货通知
                    <div class="am-fr" style="width: 3rem">
                        <div class="bg_con">
                            <input id="checked-4" type="checkbox" name="checked-4" class="switch" 
                            <?php
                             if($user['0']['state4']==2)
                            { 
                                echo 'checked="checked"';

                            }
                            ?> 
                    
                            onclick="check(4,'user')" value="4"/>
                            <label for="checked-4"></label>
                        </div>
                    </div>
                </a></li>
                <li><a > 工单处理通知
                    <div class="am-fr" style="width: 3rem">
                        <div class="bg_con">
                            <input id="checked-5" type="checkbox" name="checked-5" class="switch" 
                            <?php
                             if($user['0']['state5']==2)
                            { 
                                echo 'checked="checked"';

                            }
                            ?> 
                            onclick="check(5,'user')" value="5" />
                            <label for="checked-5"></label>
                        </div>
                    </div>
                </a></li>
            </ul>
        </div>
    </div>

    <?php if($cateid==3):?>
    <div class="am-panel am-panel-danger mg10">
        <div class="am-panel-hd"><a href="#" class="am-text-danger">经销商消息提醒</a></div>
        <div>
            <ul class="am-list am-list-border">
                <li><a > 平台打款通知
                    <div class="am-fr" style="width: 3rem">
                        <div class="bg_con">
                            <input id="checked-6" type="checkbox" name="checked-6" class="switch" 
                            <?php
                             if($partner['state1']==2)
                            { 
                                echo 'checked="checked"';

                            }
                            ?> 
                            onclick="check(6,'partner')" value="6"/>

                            <label for="checked-6"></label>
                        </div>
                    </div>
                </a></li>
                <li><a > 成为经销商通知
                    <div class="am-fr" style="width: 3rem">
                        <div class="bg_con">
                            <input id="checked-7" type="checkbox" name="checked-7" class="switch" 

                            <?php
                             if($partner['state2']==2)
                            { 
                                echo 'checked="checked"';

                            }
                            ?> 
                            onclick="check(7,'partner')" value="7" />
                            <label for="checked-7"></label>
                        </div>
                    </div>
                </a></li>
            </ul>
        </div>
    </div>
<?php endif;?>
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
