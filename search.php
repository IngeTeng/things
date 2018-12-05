<?php
/**
 * @Author: anchen
 * @Date:   2017-03-26 22:16:25
 * @Last Modified by:   anchen
 * @Last Modified time: 2017-03-26 23:06:30
 */
$keyword = $_GET['keyword'];
//获得关键字后进行处理
//echo stristr("Helloworld!","!");
$row[0]='admin';
$row[1]='billy';
$row[2]='caa';
$row[3]='jams';
if(!empty($keyword)){
    $k=0;
    for( $i=0 ; $i<sizeof($row);$i++){

        if(stristr($row[$i],$keyword)){    
            
            $attr[$k] = $row[$i];
             ++$k;
        }
        
    }
}


$attr=json_encode($attr);
echo $attr;
