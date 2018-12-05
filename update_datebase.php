<?php
/**
 * @Author: anchen
 * @Date:   2017-05-09 10:16:07
 * @Last Modified by:   anchen
 * @Last Modified time: 2017-05-10 11:58:28
 */
$mysql_server_name='localhost'; //改成自己的mysql数据库服务器
 
$mysql_username='root'; //改成自己的mysql数据库用户名
 
$mysql_password='root'; //改成自己的mysql数据库密码
 
$mysql_database='flood'; //改成自己的mysql数据库名

 
$conn=mysqli_connect($mysql_server_name,$mysql_username,$mysql_password , $mysql_database) or die("error connecting") ; //连接数据库
 
//mysqli_query($conn,"set names 'utf8'"); //数据库输出编码 应该与你的数据库编码保持一致.南昌网站建设公司百恒网络PHP工程师建议用UTF-8 国际标准编码.
 
//mysqli_select_db($conn, $mysql_database); //打开数据库

$sql ="select * from flood_water_level_csv "; //SQL语句
mysqli_query($conn,$sql);
 
$result = mysqli_query($conn,$sql); //查询
$rows=mysqli_fetch_all($result);

foreach ($rows as $row) {
    # code...
    $timestamp = strtotime($row['2']);
    updatetime($conn,$row['0'],$timestamp);

}

 

 function updatetime($conn , $wid , $timestamp){
    $sql_up ="update  flood_water_level_csv set water_level_csv_Water_date = '$timestamp' where water_level_csv_id = $wid"; 
    $bool = mysqli_query($conn,$sql_up);
    var_dump($bool);
 }