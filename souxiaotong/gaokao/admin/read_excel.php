<?php
/**
 * @Author: anchen
 * @Date:   2017-05-27 09:28:34
 * @Last Modified by:   anchen
 * @Last Modified time: 2017-06-02 22:11:29
 */

require_once('admin_init.php');
require_once('admincheck.php');

require($LIB_TABLE_PATH.'table_data.class.php');

require_once 'Classes/PHPExcel.php';
require_once 'Classes/PHPExcel/IOFactory.php';
require_once 'Classes/PHPExcel/Reader/Excel2007.php';
$objReader = PHPExcel_IOFactory::createReader('Excel2007');//use excel2007 for 2007 format 
$objReader->setReadDataOnly(true); 
//var_dump($objReader);
//$filename = $HTTP_PATH.$_GET['fileurl'];
//
function alertMes($mes,$url){
    echo "<script>alert('{$mes}');</script>";
    echo "<script>window.location='{$url}';</script>";
}
if(empty($_GET['fileurl'])){
    alertMes('请重新上传',$HTTP_PATH.'admin/index.php');
}
$filename = '../'.$_GET['fileurl'];
//var_dump($objReader);exit;
//var_dump($filename);exit;
/*$filename = $_GET['fileurl'];*/
//var_dump($filename);
$objPHPExcel = $objReader->load($filename);
//var_dump($objPHPExcel);exit;
//$objPHPExcel = \PHPExcel_IOFactory::load($filename);

 //$filename可以是上传的文件，或者是指定的文件
/*$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); // 取得总行数 
$highestColumn = $sheet->getHighestColumn(); // 取得总列数
$k = 0; */

$objWorksheet = $objPHPExcel->getActiveSheet();//取得总行数
$highestRow = $objWorksheet->getHighestRow();//取得总列数
 //echo 'highestRow='.$highestRow;
//循环读取excel文件,读取一条,插入一条
for($j=2;$j<=$highestRow;$j++)
{

 //获取A列的值
$a = $objPHPExcel->getActiveSheet()->getCell("A".$j)->getValue();
//获取B列的值
$b = $objPHPExcel->getActiveSheet()->getCell("B".$j)->getValue();
//获取C列的值
$c = $objPHPExcel->getActiveSheet()->getCell("C".$j)->getValue();
//获取D列的值
$d = $objPHPExcel->getActiveSheet()->getCell("D".$j)->getValue();
//获取E列的值
$e = $objPHPExcel->getActiveSheet()->getCell("E".$j)->getValue();
//获取F列的值
$f = $objPHPExcel->getActiveSheet()->getCell("F".$j)->getValue();
//获取G列的值
$g = $objPHPExcel->getActiveSheet()->getCell("G".$j)->getValue();
//获取H列的值
$h = $objPHPExcel->getActiveSheet()->getCell("H".$j)->getValue();
//获取I列的值
$i = $objPHPExcel->getActiveSheet()->getCell("I".$j)->getValue();

$arr=array(

        'xuexiao' =>$a,
        'nianfen' =>$b,
        'shengfen' =>$c,
        'kelei' =>$d,
        'zhuanye' =>$e,
        'zhuanyezuidifen' =>$f,
        'zhuanyezuigaofen' =>$g,
        'zhuanyepingjunfen' =>$h,
        'pici' =>$i

    );
//var_dump($arr);exit;

$res = Table_data::add($arr);

 
}
alertMes('上传成功',$HTTP_PATH.'admin/index.php');