<?php
/**
 * @Author: anchen
 * @Date:   2017-05-27 13:15:24
 * @Last Modified by:   anchen
 * @Last Modified time: 2017-05-27 13:16:51
 */
require_once 'Classes/PHPExcel.php';
require_once 'Classes/PHPExcel/IOFactory.php';
require_once 'Classes/PHPExcel/Reader/Excel2007.php';
$objReader = PHPExcel_IOFactory::createReader('Excel2007');//use excel2007 for 2007 format 
$objReader->setReadDataOnly(true); 
//var_dump($objReader);
$objPHPExcel = $objReader->load('11.xlsx');
var_dump($objPHPExcel);