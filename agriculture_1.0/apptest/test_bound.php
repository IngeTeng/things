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

//var_dump($arr);die;

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
//var_dump($jsonStr);
unset($_POST);
$HTTP_RAW_POST_DATA = $jsonStr;




include('../method/app_bound.php');




?>