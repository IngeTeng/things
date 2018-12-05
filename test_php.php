<?php
/**
 * @Author: anchen
 * @Date:   2017-04-25 21:38:47
 * @Last Modified by:   anchen
 * @Last Modified time: 2017-04-25 21:39:46
 */
$str = '郭碗瓢盆-<span style="color:#f00;">PHP</span>';
$str1 = strip_tags($str);          // 删除所有HTML标签
$str2 = strip_tags($str,'<span>'); // 保留 <span>标签
echo $str1; // 输出 郭碗瓢盆-PHP
echo $str2; // 样式不一样喔