<?php
/**
 * @Author: anchen
 * @Date:   2017-04-13 18:33:22
 * @Last Modified by:   anchen
 * @Last Modified time: 2017-04-13 21:12:19
 */
//'http://112.124.3.197:8011/app/method/app_bound.php?method=order_to_pay'
//
//
//ok
/*$uri = "http://112.124.3.197:8011/app/method/app_bound.php?method=order_to_pay";
$data = array (
        'name' => 'tanteng' 
// 'password' => 'password'
);
 
$ch = curl_init ();
// print_r($ch);
curl_setopt ( $ch, CURLOPT_URL, $uri );
curl_setopt ( $ch, CURLOPT_POST, 1 );
curl_setopt ( $ch, CURLOPT_HEADER, 0 );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
$return = curl_exec ( $ch );
curl_close ( $ch );
 
print_r($return);*/

$data = json_encode(array('a'=>1, 'b'=>2));  
function post_data($url , $data_string )
    {
      $ch = curl_init();  
        curl_setopt($ch, CURLOPT_POST, 1);  
        curl_setopt($ch, CURLOPT_URL, $url);  
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
            'Content-Type: application/json; charset=utf-8',  
            'Content-Length: ' . strlen($data_string))  
        );  
        ob_start();  
        curl_exec($ch);  
        $return_content = ob_get_contents();  
        ob_end_clean();  
  
        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
        return array($return_code, $return_content);  
       
    }
$url="http://112.124.3.197:8011/app/method/app_bound_test.php?method=order_to_pay";
//var_dump($jsonStr);

$res = post_data($url ,$data);
//include('../method/app_bound.php');
var_dump($res);