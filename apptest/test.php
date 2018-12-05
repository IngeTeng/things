<?php
header("content-type:text/html;charset=utf-8");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>错误码信息表</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: "Open Sans", sans-serif;
        }

        body {
            padding: 20px 0 0 200px;
            color: red;
        }

        form {
            margin: 5px 0 30px 50px;
            color: #363636;
        }
        form p{
            line-height: 30px;
        }
        form input{

        }
        .title {
            margin: 30px 0;
            font-size: 54px;
            color: #333333;
        }
    </style>
</head>
<body>

<div>
    <p class="title">农伴API调试</p>
</div>
用户注册：
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="register"/></p>
    <p>name：<input type="text" name="name" value="张三"/></p>
    <p>birthday：<input type="text" name="birthday" value="1492090664"/></p>
    <p>sex：<input type="text" name="sex" value="1"/></p>
    <p>province_id：<input type="text" name="province_id：" value="2"/></p>
    <p>city_id：<input type="text" name="city_id" value="3"/></p>
    <p>country_id：<input type="text" name="country_id" value="2"/></p>
    <p>town_id：<input type="text" name="town_id" value="4"/></p>
    <p>village_id：<input type="text" name="village_id" value="4"/></p>
    <p>address：<input type="text" name="address" value="陕西省宝鸡市"/></p>
    <p>farm_name1：<input type="text" name="farm_title1" value="小麦"/></p>
    <p>farm_value1：<input type="text" name="farm_value1" value="1500"/></p>
    <p>farm_name2：<input type="text" name="farm_title2" value="大豆"/></p>
    <p>farm_value2：<input type="text" name="farm_value2" value="200"/></p>
    <p>farm_name3：<input type="text" name="farm_title3" value="种子"/></p>
    <p>farm_value3：<input type="text" name="farm_value3" value="50"/></p>
    
    <p>asset_title1：<input type="text" name="asset_title1" value="牛"/></p>
    <p>asset_value1：<input type="text" name="asset_value1" value="15"/></p>
    <p>asset_title2：<input type="text" name="asset_title2" value="羊"/></p>
    <p>asset_value2：<input type="text" name="asset_value2" value="20"/></p>

    <p>pwd：<input type="text" name="pwd" value="admin"/></p>
    <p>question：<input type="text" name="question" value="母亲的生日"/></p>
    <p>answer：<input type="text" name="answer" value="93年"/></p>
    <p>phone：<input type="text" name="phone" value="18628601884"/></p>
    <p><input type="submit" value="submit"></p>
</form>


根据团购id查询对应商品：
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="teambuy_get_goods_by_type"/></p>
    <p>uid：<input type="text" name="uid" value="15"/></p>
    <p>type_id：<input type="text" name="type_id" value="32"/></p>
    <p><input type="submit" value="submit"></p>
</form>

团购首页：
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="teambuy_home_page"/></p>
    <p>uid：<input type="text" name="uid" value="15"/></p>
    <p><input type="submit" value="submit"></p>
</form>
order_to_return:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="order_to_return"/></p>
    <p>uid：<input type="text" name="uid" value="6"/></p>
    <p><input type="submit" value="submit"></p>
</form>

商品详情：
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="product_detail"/></p>
    <p>uid：<input type="text" name="uid" value="15"/></p>
    <p>goods_id：<input type="text" name="goods_id" value="205"/></p>
    <p><input type="submit" value="submit"></p>
</form>

按品牌搜索：
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="goods_by_brand"/></p>
    <p>uid：<input type="text" name="uid" value="77"/></p>
    <p>brand：<input type="text" name="brand" value="开心农场"/></p>
    <p>type：<input type="text" name="type" value="4"/></p>
    <p>pagesize：<input type="text" name="pagesize" value="10"/></p>
    <p><input type="submit" value="submit"></p>
</form>


搜索：
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="search"/></p>
    <p>uid：<input type="text" name="uid" value="15"/></p>
    <p>page：<input type="text" name="page" value="0"/></p>
    <p>pagesize：<input type="text" name="pagesize" value="5"/></p>
    <p>content：<input type="text" name="content" value="啦"/></p>
    <p>type：<input type="text" name="type" value="1"/></p>
    <p><input type="submit" value="submit"></p>
</form>

search_by_content：
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="search_by_content"/></p>
    <p>uid：<input type="text" name="uid" value="77"/></p>
    <p>page：<input type="text" name="page" value="1"/></p>
    <p>pagesize：<input type="text" name="pagesize" value="5"/></p>
    <p>content：<input type="text" name="content" value=""/></p>
    <p>brand：<input type="text" name="brand" value="20"/></p>
    <p>price_id：<input type="text" name="price_id" value="-1"/></p>
    <p>promotion：<input type="text" name="promotion" value="-1"/></p>
    <p>seller：<input type="text" name="seller" value="-1"/></p>
    <p>goods_type：<input type="text" name="goods_type" value="-1"/></p>
    <p>crop_type：<input type="text" name="crop_type" value="-1"/></p>
    <p>type：<input type="text" name="type" value="-1"/></p>
    <p><input type="submit" value="submit"></p>
</form>


search_type：
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="search_type"/></p>
    <p><input type="submit" value="submit"></p>
</form>


user_info_complete：
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="user_info_complete"/></p>
    <p>uid：<input type="text" name="uid" value="77"/></p>
    <p>name：<input type="text" name="name" value="123"/></p>
    <p>flag：<input type="text" name="flag" value="1"/></p>
    <p>pass_code：<input type="text" name="pass_code" value=""/></p>
    <p>marry：<input type="text" name="marry" value="0"/></p>
    <p>range：<input type="text" name="range" value=""/></p>
    <p>level：<input type="text" name="level" value="0"/></p>
    <p>position：<input type="text" name="position" value=""/></p>
    <p>ci_id：<input type="text" name="ci_id" value="0"/></p>
    <p>co_id：<input type="text" name="co_id" value="0"/></p>
    <p>t_id：<input type="text" name="t_id" value="0"/></p>
    <p>v_id：<input type="text" name="v_id" value=""/></p>
    <p>addr_detail：<input type="text" name="addr_detail" value=""/></p>
    <p><input type="submit" value="submit"></p>
</form>

goods_temai：
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="goods_temai"/></p>
    <p>uid：<input type="text" name="uid" value="15"/></p>
    <p>page：<input type="text" name="page" value="0"/></p>
    <p>pagesize：<input type="text" name="pagesize" value="5"/></p>
    <p>type：<input type="text" name="type" value="1"/></p>
    <p><input type="submit" value="submit"></p>
</form>

充值并支付（模拟调用回调接口）：
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="recharge_and_pay"/></p>
    <p>uid：<input type="text" name="uid" value="190"/></p>
    <p>money：<input type="text" name="money" value="1000"/></p>
    <p><input type="submit" value="submit"></p>
</form>


首页：
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="home_product"/></p>
    <p>uid：<input type="text" name="uid" value="15"/></p>
    <p><input type="submit" value="submit"></p>
</form>


钱包支付：
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="wallet_pay"/></p>
    <p>uid：<input type="text" name="uid" value="15"/></p>
    <p>订单号：<input type="text" name="orderid" value="a146036953415404"/></p>
    <p>支付密码：<input type="text" name="password" value="1000"/></p>
    <p><input type="submit" value="submit"></p>
</form>
确认订单：
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="affirm_order1"/></p>
    <p>uid：<input type="text" name="uid" value="15"/></p>
    <p><input type="submit" value="submit"></p>
</form>


查看钱包明细：
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="consumer_details"/></p>
    <p>uid：<input type="text" name="uid" value="15"/></p>
    <p><input type="submit" value="submit"></p>
</form>

获取验证码：
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="send_consume_sms_code"/></p>
    <p>uid：<input type="text" name="uid" value="15"/></p>
    <p><input type="submit" value="submit"></p>
</form>
设置支付密码：
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="set_consume_password"/></p>
    <p>uid：<input type="text" name="uid" value="15"/></p>
    <p>pwd：<input type="text" name="password" value="1000"/></p>
    <p>code：<input type="text" name="code" value="1000"/></p>
    <p><input type="submit" value="submit"></p>
</form>

充值：
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="recharge"/></p>
    <p>uid：<input type="text" name="uid" value="15"/></p>
    <p>money：<input type="text" name="money" value="1000"/></p>
    <p><input type="submit" value="submit"></p>
</form>

查看钱包：
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="look_wallet"/></p>
    <p>uid：<input type="text" name="uid" value="15"/></p>
    <p><input type="submit" value="submit"></p>
</form>

get_checknum:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="get_checknum"/></p>
    <p>手机号：<input type="text" name="mobile" value="13149230139"/></p>
    <p>类型：<input type="text" name="type" value=1/></p>
    <p><input type="submit" value="submit"></p>
</form>

get_country:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="get_country"/></p>
    <p>市级id：<input type="text" name="ci_id" value="17"/></p>
    <p><input type="submit" value="submit"></p>
</form>

get_city:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="get_city"/></p>
    <p>type：<input type="text" name="type" value="2"/></p>
    <p>uid：<input type="text" name="uid" value="8"/></p>

    <p><input type="submit" value="submit"></p>
</form>

get_country:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="get_country"/></p>
    <p>type：<input type="text" name="type" value="2"/></p>
    <p>uid：<input type="text" name="uid" value="8"/></p>
    <p>ci_id：<input type="text" name="ci_id" value="8"/></p>
    <p><input type="submit" value="submit"></p>
</form>

get_town:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="get_town"/></p>
    <p>type：<input type="text" name="type" value="2"/></p>
    <p>uid：<input type="text" name="uid" value="8"/></p>
    <p>co_id：<input type="text" name="co_id" value="8"/></p>
    <p><input type="submit" value="submit"></p>
</form>

get_village:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="get_village"/></p>
    <p>type：<input type="text" name="type" value="2"/></p>
    <p>uid：<input type="text" name="uid" value="8"/></p>
    <p>co_id：<input type="text" name="co_id" value="138"/></p>
    <p>t_id：<input type="text" name="t_id" value="8"/></p>
    <p><input type="submit" value="submit"></p>
</form>

have_password:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="have_password"/></p>
    <p>uid：<input type="text" name="uid" value="8"/></p>

    <p><input type="submit" value="submit"></p>
</form>

product_look:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="product_look"/></p>
    <p>uid：<input type="text" name="uid" value="9"/></p>
    <p>goods_id：<input type="text" name="goods_id" value="9"/></p>
    <p><input type="submit" value="submit"></p>
</form>

product_info:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="product_info"/></p>
    <p>uid：<input type="text" name="uid" value="22"/></p>
    <p>goods_id：<input type="text" name="goods_id" value="286"/></p>
    <p><input type="submit" value="submit"></p>
</form>

stock_query:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="stock_query"/></p>
    <p>uid：<input type="text" name="uid" value="23"/></p>
    <p>goods_id：<input type="text" name="goods_id" value="286"/></p>
    <p><input type="submit" value="submit"></p>
</form>

order_query:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="order_query"/></p>
    <p>uid：<input type="text" name="uid" value="23"/></p>
    <p>ord_id：<input type="text" name="ord_id" value="A16222582"/></p>
    <p><input type="submit" value="submit"></p>
</form>

order_to_pay:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="order_to_pay"/></p>
    <p>uid：<input type="text" name="uid" value="9"/></p>
    <p><input type="submit" value="submit"></p>
</form>

logistics_barcode:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="logistics_barcode"/></p>
    <p>barcode：<input type="text" name="barcode" value="918433042235"/></p>
    <p><input type="submit" value="submit"></p>
</form>

logistics_detail:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="logistics_detail"/></p>
    <p>uid：<input type="text" name="uid" value=""/></p>
    <p>ord_id：<input type="text" name="ord_id" value=""/></p>
    <p><input type="submit" value="submit"></p>
</form>

order_goods_detail:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="order_goods_detail"/></p>
    <p>uid：<input type="text" name="uid" value=""/></p>
    <p>ord_id：<input type="text" name="ord_id" value=""/></p>
    <p><input type="submit" value="submit"></p>
</form>

get_remarked_order:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="get_remarked_order"/></p>
    <p>uid：<input type="text" name="uid" value=""/></p>
    <p><input type="submit" value="submit"></p>
</form>

get_remark_order:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="get_remark_order"/></p>
    <p>uid：<input type="text" name="uid" value=""/></p>
    <p><input type="submit" value="submit"></p>
</form>

user_detail:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="user_detail"/></p>
    <p>uid：<input type="text" name="uid" value=""/></p>
    <p><input type="submit" value="submit"></p>
</form>

user_query:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="user_query"/></p>
    <p>uid：<input type="text" name="uid" value=""/></p>
    <p>phone：<input type="text" name="phone" value=""/></p>
    <p><input type="submit" value="submit"></p>
</form>

pay_affirm:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="pay_affirm"/></p>
    <p>uid：<input type="text" name="uid" value=""/></p>
    <p>ord_id：<input type="text" name="ord_id" value=""/></p>
    <p><input type="submit" value="submit"></p>
</form>

order_to_receive:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="order_to_receive"/></p>
    <p>uid：<input type="text" name="uid" value=""/></p>
    <p><input type="submit" value="submit"></p>
</form>

login:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="login"/></p>
    <p>phone：<input type="text" name="phone" value="15898765670"/></p>
    <p>pwd：<input type="text" name="pwd" value="12345"/></p>
    <p>verify_code：<input type="text" name="verify_code" value="123456"/></p>
    <p><input type="submit" value="submit"></p>
</form>


user_login:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="user_login"/></p>
    <p>phone：<input type="text" name="name" value="孙智鹏"/></p>
    <p>pwd：<input type="text" name="pwd" value="241419"/></p>
    <p>verify_code：<input type="text" name="verify_code" value="123456"/></p>
    <p><input type="submit" value="submit"></p>
</form>


user_change_pwd:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="user_change_pwd"/></p>
    <p>phone：<input type="text" name="name" value="孙智鹏"/></p>
    <p>pwd：<input type="text" name="pwd" value="241419"/></p>
    <p>new_pwd：<input type="text" name="new_pwd" value="111111"/></p>
    <p><input type="submit" value="submit"></p>
</form>


bank_login:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="bank_login"/></p>
    <p>username：<input type="text" name="username" value="塔城银行"/></p>
    <p>pwd：<input type="text" name="pwd" value="d55ce234cbda84ed06e1aa3b35607c59"/></p>
    <p><input type="submit" value="submit"></p>
</form>

coop_login:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="coop_login"/></p>
    <p>username：<input type="text" name="username" value="额敏第一合作社"/></p>
    <p>pwd：<input type="text" name="pwd" value="d55ce234cbda84ed06e1aa3b35607c59"/></p>
    <p><input type="submit" value="submit"></p>
</form>

bank_set_passwd:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="bank_set_passwd"/></p>
    <p>uid：<input type="text" name="uid" value="132"/></p>
    <p>pwd：<input type="text" name="pwd" value="e10adc3949ba59abbe56e057f20f883e"/></p>
    <p>newpwd：<input type="text" name="newpwd" value="d55ce234cbda84ed06e1aa3b35607c59"/></p>
    <p><input type="submit" value="submit"></p>
</form>

coop_set_passwd:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="coop_set_passwd"/></p>
    <p>uid：<input type="text" name="uid" value="132"/></p>
    <p>pwd：<input type="text" name="pwd" value="e10adc3949ba59abbe56e057f20f883e"/></p>
    <p>newpwd：<input type="text" name="newpwd" value="d55ce234cbda84ed06e1aa3b35607c59"/></p>
    <p><input type="submit" value="submit"></p>
</form>

bank_home_info:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="bank_home_info"/></p>
    <p>uid：<input type="text" name="uid" value="132"/></p>
    <p><input type="submit" value="submit"></p>
</form>

bank_get_farmers:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="bank_get_farmers"/></p>
    <p>uid：<input type="text" name="uid" value="132"/></p>
    <p><input type="submit" value="submit"></p>
</form>

bank_get_cooperations:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="bank_get_cooperations"/></p>
    <p>uid：<input type="text" name="uid" value="132"/></p>
    <p><input type="submit" value="submit"></p>
</form>


bank_get_orders:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="bank_get_orders"/></p>
    <p>uid：<input type="text" name="uid" value="132"/></p>
    <p><input type="submit" value="submit"></p>
</form>


bank_get_orders_by_farmer_id:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="bank_get_orders_by_farmer_id"/></p>
    <p>uid：<input type="text" name="uid" value="77"/></p>
    <p><input type="submit" value="submit"></p>
</form>

coop_home_info:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="coop_home_info"/></p>
    <p>uid：<input type="text" name="uid" value="139"/></p>
    <p><input type="submit" value="submit"></p>
</form>

get_bank_loan_info:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="get_bank_loan_info"/></p>
    <p>uid：<input type="text" name="uid" value="132"/></p>
    <p>start_time：<input type="text" name="start_time" value=""/></p>
    <p>end_time：<input type="text" name="end_time" value=""/></p>

    <p><input type="submit" value="submit"></p>
</form>

get_manager_loan_list:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="get_manager_loan_list"/></p>
    <p>uid：<input type="text" name="uid" value="132"/></p>
    <p>sort_type：<input type="text" name="sort_type" value="1"/></p>

    <p><input type="submit" value="submit"></p>
</form>

get_bank_loan_list:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="get_bank_loan_list"/></p>
    <p>uid：<input type="text" name="uid" value="132"/></p>
    <p>sort_type：<input type="text" name="sort_type" value="1"/></p>

    <p><input type="submit" value="submit"></p>
</form>

get_coop_loan_list:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="get_coop_loan_list"/></p>
    <p>uid：<input type="text" name="uid" value="173"/></p>
    <p>search_content：<input type="text" name="search_content" value=""/></p>
    <p><input type="submit" value="submit"></p>
</form>


get_farmer_loan_list:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="get_farmer_loan_list"/></p>
    <p>uid：<input type="text" name="uid" value="179"/></p>
    <p><input type="submit" value="submit"></p>
</form>


bank_get_manager_list:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="bank_get_manager_list"/></p>
    <p>uid：<input type="text" name="uid" value="132"/></p>
    <p><input type="submit" value="submit"></p>
</form>

get_coop_manager_loan_list:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="get_coop_manager_loan_list"/></p>
    <p>uid：<input type="text" name="uid" value="207"/></p>
    <p><input type="submit" value="submit"></p>
</form>

bank_trade_get_list:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="bank_trade_get_list"/></p>
    <p>uid：<input type="text" name="uid" value="132"/></p>
    <p><input type="submit" value="submit"></p>
</form>

bank_trade_get_detail:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="bank_trade_get_detail"/></p>
    <p>uid：<input type="text" name="uid" value="139"/></p>
    <p><input type="submit" value="submit"></p>
</form>

bank_farmer_get_list:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="bank_farmer_get_list"/></p>
    <p>uid：<input type="text" name="uid" value="132"/></p>
    <p><input type="submit" value="submit"></p>
</form>

coop_order_get_list:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="coop_order_get_list"/></p>
    <p>uid：<input type="text" name="uid" value="139"/></p>
    <p>manager_uid：<input type="text" name="manager_uid" value="179"/></p>
    <p><input type="submit" value="submit"></p>
</form>


coop_loan_get_farmer_info:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="coop_loan_get_farmer_info"/></p>
    <p>uid：<input type="text" name="uid" value="286"/></p>
    <p><input type="submit" value="submit"></p>
</form>


coop_trade_get_list:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="coop_trade_get_list"/></p>
    <p>uid：<input type="text" name="uid" value="139"/></p>
    <p>manager_uid：<input type="text" name="manager_uid" value="179"/></p>
    <p><input type="submit" value="submit"></p>
</form>

coop_trade_get_detail:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="coop_trade_get_detail"/></p>
    <p>uid：<input type="text" name="uid" value="179"/></p>
    <p><input type="submit" value="submit"></p>
</form>


coop_farmer_get_list:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="coop_farmer_get_list"/></p>
    <p>uid：<input type="text" name="uid" value="179"/></p>
    <p><input type="submit" value="submit"></p>
</form>

coop_loan_get_farmer_info:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="coop_loan_get_farmer_info"/></p>
    <p>uid：<input type="text" name="uid" value="63"/></p>
    <p><input type="submit" value="submit"></p>
</form>


coop_get_all_farmer_loan_list:
<form action="./test_bound.php" method="post" target="blank">
    <p><input type="hidden" name="method" value="coop_get_all_farmer_loan_list"/></p>
    <p>uid：<input type="text" name="uid" value="207"/></p>
    <p><input type="submit" value="submit"></p>
</form>


</body>
</html>