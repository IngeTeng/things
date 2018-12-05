<?php
/**
 * @Author: anchen
 * @Date:   2017-05-09 10:11:34
 * @Last Modified by:   anchen
 * @Last Modified time: 2017-05-09 10:13:21
 */
$salt = 123456;
echo $salt;
$pwd = 123456;
echo '<br>';
$pwd_new = md5(md5($pwd).$salt);
echo $pwd_new;