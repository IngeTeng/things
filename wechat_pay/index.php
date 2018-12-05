<?php 

echo '<pre>';

print_r(urlencode('http://www.yanxin325.com/wechat_pay/js_pay.php'));

echo '</pre>';

?>

<!DOCTYPE html>
<html>
<head>
	<title>nav</title>
</head>
<body>
<a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf1b0a589ad02add5&redir
ect_uri=<?php echo urlencode('http://www.yanxin325.com/wechat_pay/js_pay.php');?>&response_type=code&scope=snsapi_base&state=ccc#wecha
t_redirect">获取openid的链接</a>
</body>
</html>
