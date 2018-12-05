<?php
/**
 * @Author: anchen
 * @Date:   2017-04-14 14:15:28
 * @Last Modified by:   anchen
 * @Last Modified time: 2017-04-14 14:53:38
 */
function http_curl($url){
        //获取imooc
        //1.初始化curl
        $ch = curl_init();
        //$url = 'http://www.baidu.com';
        //2.设置curl的参数
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($curl , CURLOPT_SSL_VERIFYPEER ,FALSE);
        curl_setopt($curl , CURLOPT_SSL_VERIFYHOST , FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //3.采集
        $output = curl_exec($ch);
        //4.关闭
        curl_close($ch);
        return $output;
    }
//$data = http_curl("compressed.tracemonkey-pldi-09.pdf");
$data =  http_curl("http://www.yanxin325.com/test/generic/web/compressed.tracemonkey-pldi-09.pdf");
echo $data;

