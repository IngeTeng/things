<?php

// $keys = array_keys($_POST);
// $values = array_values($_POST);
// 
// var_dump($keys);
// var_dump($values);


//这是为生成json的数组
$arr = array();
$arr['appkey'] = "001";
$arr['sn'] = "89860089261479375945";
$arr['timestamp'] = time();
$arr['rtimes'] = "1";
$arr['method'] = $_POST['method'];
unset($_POST['method']);
$arr['request'] = $_POST;

//var_dump($arr['request']['farm_title1']);die;
$arr['request']['farm'] = array(
         array(
            "name" => $arr['request']['farm_title1'],
            "value" => $arr['request']['farm_value1'],

            ),
        array(
            "name" => $arr['request']['farm_title2'],
            "value" => $arr['request']['farm_value2'],
            ),

    );
$arr['request']['asset'] = array(
        array(
            "title" => $arr['request']['asset_title1'],
            "value" => $arr['request']['asset_value1'],

            ),
         array(
            "title" => $arr['request']['asset_title2'],
            "value" => $arr['request']['asset_value2'],
            ),

    );


//生成sign

$request = $_POST;


$keys1 = array_keys($arr);
$values1 = array_values($arr);
$count1 = count($keys1);

$keys2 = array_keys($request);
$values2 = array_values($request);
$count2 = count($keys2);

$str = array();
$j = 0;
for($i = 0; $i < $count1; $i ++)	{
	if(strcmp($keys1[$i],"request")){
		$str[$j]=$keys1[$i]."=".$values1[$i]; 
		$j++;
	}else{
		for($k = 0; $k < $count2; $k ++){
			$str[$j]=$keys2[$k]."=".$values2[$k];
			//echo $str[$j]."<br>";
			$j ++;
		}
	}
}
sort($str,SORT_STRING);

$count = count($str);
$rst = "";
for($i = 0; $i < $j; $i ++)	{
	$rst .= $str[$i].'&';
}
$secret="secret=753159842564855248546518489789";
$rst .= $secret;//字符串连接成功

$arr['sign'] = md5($rst);

//

$jsonStr = json_encode($arr);
//var_dump($jsonStr); exit;
unset($_POST);
$HTTP_RAW_POST_DATA = $jsonStr;
var_dump($jsonStr);



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
$url="http://112.124.3.197:8011/app/method/app_bound.php?method=".$arr['method'];
//var_dump($jsonStr);

$res = post_data($url ,$jsonStr);
var_dump($res);



?>