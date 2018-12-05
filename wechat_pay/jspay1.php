<?php
require('../wiipu_health/conn.php');
include_once("./WxPay/WxPayPubHelper.php");
include_once("./WxPay/medoo.php");
require($LIB_PATH.'combo_cate.class.php');
require($LIB_TABLE_PATH.'table_combo_cate.class.php');
require($LIB_PATH.'care.class.php');
require($LIB_TABLE_PATH.'table_care.class.php');
require($LIB_PATH.'insurance.class.php');
require($LIB_TABLE_PATH.'table_insurance.class.php');

require($LIB_PATH.'test.class.php');
require($LIB_TABLE_PATH.'table_test.class.php');
require($LIB_PATH.'shoplist.class.php');
require($LIB_TABLE_PATH.'table_shoplist.class.php');

if(!empty($_GET['id']))
	$id = strCheck($_GET['id'],0);
else
	$id = '';

if(!empty($_GET['flag']))
	$flag = strCheck($_GET['flag'],0);
else
	$flag = '';

if(!empty($_GET['couponid']))
	$couponid = strCheck($_GET['couponid']);
else
	$couponid = 0;


//var_dump($flag);var_dump($id);exit();


if($flag == 1){
$row = table_combo_cate::getInfoById($id);
$service = $row['name'];
$money = $row['money'];
}else{
    if($flag == 2){
        $row = table_care::getInfoById($id);
        $service = $row['name'];
		$money  = $row['salary'];
    }else{
		if($flag == 3){
			$row = table_test::getInfoById($id);
			$service = $row['name'];
			$money  = $row['price'];
		}else{
			$row = table_insurance::getInfoById($id);
			$service = $row['name'];
			$money  = $row['price'];
		}
    }

}


if($couponid){
	$couponinfo = Coupon::getInfoById($couponid);
	$fullcut = $couponinfo['fullcut'];
	$account = $couponinfo['account'];
	if($money > $fullcut){
		if($account >= 1){
			$money = $money-$account;
		}else{
			$money = $money*$account;
		}
	}
}

//echo $service;exit();

?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <title>微信安全支付</title>
	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="js/layer/layer.js"></script>
	<script type="text/javascript">
		$(function(){
			
			function recordadd()
            {


                var flag        = $('#flag').val();
                var user_openid = $('#openid').val();




                if (flag == 1){
                    //-----------这里传过来的是购买大套餐的信息
                    var cateid = $('#id').val();

                    $.ajax({
                        type : 'POST',
                        data : {
                            cateid      : cateid,
                            user_openid       : user_openid
                        },
                        dataType : 'json',
                        url      : '../../wiipu_health/admin/weixincombo_do.php?act=add',
                        success  : function(data){

                            var code = data.code;
                            var msg = data.msg;
                            //var msg  = data.weixin_openid;
                            //var msg = '插入消费记录成功';
                            switch(code){
                                //switch(1){
                                case 1:
                                    layer.msg(msg, function(index){
                                        location.href = 'http://lvbu.ckusoft.com/wiipu_health/web/jkyl/my_right.php';
                                    });
                                    break;
                                default:
                                    layer.alert(msg, {icon: 5});
                            }
                        }
                    });
                }else{
                    if(flag == 2){
                        //---------这里传过来的是预约月嫂、护工的信息
                        var careid = $('#id').val();

                        $.ajax({
                            type : 'POST',
                            data : {
                                care_id      : careid,
                                user_openid       : user_openid
                            },
                            dataType : 'json',
                            url      : '../../wiipu_health/admin/weixinwork_do.php?act=add',
                            success  : function(data){

                                var code = data.code;
                                var msg = data.msg;
                                //var msg  = data.weixin_openid;
                                //var msg = '插入消费记录成功';
                                switch(code){
                                    //switch(1){
                                    case 1:
                                        layer.msg(msg, function(index){
                                            location.href = 'http://lvbu.ckusoft.com/wiipu_health/web/jkyl/my_right.php';
                                        });
                                        break;
                                    default:
                                        layer.alert(msg, {icon: 5});
                                }
                            }
                        });
                    }else{
                        if(flag == 3){
                            var testid = $('#id').val();

                            $.ajax({
                                type : 'POST',
                                data : {
                                    test_id      : testid,
                                    user_openid       : user_openid
                                },
                                dataType : 'json',
                                url      : '../../wiipu_health/admin/weixinorder_do.php?act=add',
                                success  : function(data){

                                    var code = data.code;
                                    var msg = data.msg;
                                    //var msg  = data.weixin_openid;
                                    //var msg = '插入消费记录成功';
                                    switch(code){
                                        //switch(1){
                                        case 1:
                                            layer.msg(msg, function(index){
                                                location.href = 'http://lvbu.ckusoft.com/wiipu_health/web/jkyl/my_right.php';
                                            });
                                            break;
                                        default:
                                            layer.alert(msg, {icon: 5});
                                    }
                                }
                            });
                        }else{
                            var insuid = $('#id').val();

                            $.ajax({
                                type : 'POST',
                                data : {
                                    insuid      : insuid,
                                    user_openid       : user_openid
                                },
                                dataType : 'json',
                                url      : '../../wiipu_health/admin/weixinbuyinsu_do.php?act=add',
                                success  : function(data){

                                    var code = data.code;
                                    var msg = data.msg;
                                    //var msg  = data.weixin_openid;
                                    //var msg = '插入消费记录成功';
                                    switch(code){
                                        //switch(1){
                                        case 1:
                                            layer.msg(msg, function(index){
                                                location.href = 'http://lvbu.ckusoft.com/wiipu_health/web/jkyl/my_right.php';
                                            });
                                            break;
                                        default:
                                            layer.alert(msg, {icon: 5});
                                    }
                                }
                            });
                        }

                    }
                }
            }

	
			recordadd();
		});
		
		
	</script>
</head>
<body>
	<input type="hidden" id="openid" value="qweqwe"/>
	<input type="hidden" id="id" value="<?php echo $id;?>"/>
	<input type="hidden" id="flag" value="<?php echo $flag;?>"/>
</body>
</html>