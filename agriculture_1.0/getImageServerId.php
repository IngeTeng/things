<?php
/**
 * @Author: anchen
 * @Date:   2017-01-19 11:21:01
 * @Last Modified by:   anchen
 * @Last Modified time: 2017-03-28 12:34:24
 */
require('conn.php');
require_once('wx_config.php');
require($LIB_PATH.'partner.class.php');
require($LIB_TABLE_PATH.'table_partner.class.php');
require($LIB_PATH.'user.class.php');
require($LIB_TABLE_PATH.'table_user.class.php');

$media_id=$_POST['serverId'];
$name = $_POST['name'];
$nikname = $_POST['nikname'];
$openid=$_POST['openid'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$product = $_POST['product'];
$company = $_POST['company'];

$access_token= getWxAccessToken();
function getmedia($access_token,$media_id){
        $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$media_id;
        if (!file_exists("./userfiles/partner/")) {
            mkdir("./userfiles/partner/", 0777, true);
        }
        $fileName = 'userfiles/partner/'.date('YmdHis').rand(1000,9999).'.jpg';
        $targetName='./'.$fileName;
        $ch = curl_init($url); // 初始化
        $fp = fopen($targetName, 'wb'); // 打开写入
        curl_setopt($ch, CURLOPT_FILE, $fp); // 设置输出文件的位置，值是一个资源类型
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        return $fileName;
    }
$qrcode = getmedia($access_token,$media_id);
$partnerAttr = array(

            'name'          => $name,
            'nikname'       => $nikname,
            'openid'        => $openid,
            'phone'         => $phone,
            'address'       => $address,
            'product'       => $product,
            'qrcode'        => $qrcode,
            'company'       => $company
        );

 try {
        $rs = Partner::add($partnerAttr);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
    }


