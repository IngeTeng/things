<?php
require('../wiipu_health/conn.php');

if(!empty($_GET['money']))
	$money = strCheck($_GET['money'],0);
//		$money = $_GET['money'];
	else
		$money = '';

if(!empty($_GET['cateid']))
	$cateid = strCheck($_GET['cateid'],0);
//		$money = $_GET['money'];
	else
		$cateid = '';


?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no,minimal-ui"/>
    <meta name="format-detection" content="telephone=no" searchtype="map"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <title>微信安全支付</title>
	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="js/layer/layer.js"></script>
	<script type="text/javascript">
		$(function(){
			
			function comboadd()
			{	
				var cateid = $('#cateid').val();
				var user_openid = 'om86uuCtU280y5TrTCFLI65rLfI0';
				
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
                        
						//var msg = '插入消费记录成功';
                        switch(code){
						//switch(1){
                            case 1:
                                layer.alert(msg, {icon: 6,shade: false}, function(index){
                                    location.href = "http://lvbu.ckusoft.com/wiipu_health/web/jkyl/my_right.php";
                                });
                                break;
                            default:
                                layer.alert(msg, {icon: 5});
                        }
                    }
                });
                
				 
				 
			}

	
			comboadd();
		});
		
	</script>
</head>
<body>
	<input type="hidden" id="openid" value="<?php echo $openid;?>"/>
	<input type="hidden" id="cateid" value="<?php echo $cateid;?>"/>
</body>
</html>