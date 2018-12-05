<?php  
  
//例子1，简单crul获得网页内容，  
//01 在命令行cmd、  
//02 cd -d D:\wamp\test  
//03 php -f curl_url.php  
  
/*$curl = curl_init("http://www.baidu.com"); 
curl_exec($curl); 
curl_close($curl);*/  
  
  
  
//例子2，将请求处理存入文件  
$curlobj = curl_init();  
curl_setopt($curlobj,CURLOPT_URL,"http://cs.qhu.edu.cn/jqtz/28706.htm");  
curl_setopt($curlobj,CURLOPT_RETURNTRANSFER,true); //请求结果不直接打印  
$output = curl_exec($curlobj);  
curl_close($curlobj);  

/*//将请求结果写入文件  
$myfile = fopen("curl_html.txt", "w") or die("Unable to open file!");  
$preg1 =  '/<ul class="notice">(.*?)<\/ul>/is';
 preg_match_all( $preg1, $output, $res ,PREG_SET_ORDER );
//var_dump($res[0][1]);
//
$preg2 = '/<li>(.*?)<\/li>/is';
preg_match_all( $preg2, $res[0][1], $ress ,PREG_SET_ORDER );
//var_dump($ress);
$preg3 = '/<div class="date">(.*?)<\/div>/is';
preg_match_all( $preg3, $ress[0][1], $resss ,PREG_SET_ORDER );
//var_dump($resss[0][0]);
$preg4 = '/<span>(.*?)<\/span>/is';
preg_match_all( $preg4, $resss[0][1], $ressss ,PREG_SET_ORDER );
//var_dump($ressss[0][1]);
//$txt = $output;  直接存储到文件  
//$txt = str_replace("百度","屌丝",$res); //处理结果集后存储到文件  
$preg5 = '/<a .*?href="(.*?)".*?>/is';
preg_match_all($preg5, $res[0][1], $links, PREG_SET_ORDER);
var_dump($links[0][1]);exit; 
*/
$preg1 = '/<div class="article" style="min-height:300px;">(.*?)<\/div>/is';
preg_match_all( $preg1, $output, $res ,PREG_SET_ORDER );

$preg1 = '/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i';
preg_match_all( $preg1, $res[0][1], $ress ,PREG_SET_ORDER );
//var_dump($ress[1][1]);exit;
$ext = substr($ress[1][1],2);
$content = 'http://cs.qhu.edu.cn'.$ext;
$str = '<img src="'.$content.'"></img>';
var_dump($str);exit;
fwrite($myfile, $res);  
fclose($myfile);  