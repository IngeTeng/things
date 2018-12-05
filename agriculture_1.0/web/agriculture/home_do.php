<?php
/**
 * @Author: anchen
 * @Date:   2017-03-07 16:15:43
 * @Last Modified by:   anchen
 * @Last Modified time: 2017-03-07 17:27:54
 */
require('../../conn.php');

require($LIB_PATH.'category.class.php');
require($LIB_TABLE_PATH.'table_category.class.php');

$parentid = $_POST['parentid'];
$msg='选择成功';
echo action_msg($msg, 1);
//header('Location:home.php?parentid='.$parentid.'');