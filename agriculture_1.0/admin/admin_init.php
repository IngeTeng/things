<?php

/**
 * admin_init.php 管理端初始化文件
 *
 * @version       v0.02
 * @create time   2014/7/24
 * @update time   2016/3/27
 * @author        IngeTeng
 */

require('../init.php');

//加载Admin相关类
require($LIB_PATH.'admin.class.php');
require($LIB_TABLE_PATH.'table_admin.class.php');
require($LIB_PATH.'admingroup.class.php');
require($LIB_TABLE_PATH.'table_admingroup.class.php');
require($LIB_PATH.'adminlog.class.php');
require($LIB_TABLE_PATH.'table_adminlog.class.php');
//用户表单
require($LIB_PATH.'user.class.php');
require($LIB_TABLE_PATH.'table_user.class.php');
//分销商表单
require($LIB_PATH.'partner.class.php');
require($LIB_TABLE_PATH.'table_partner.class.php');
?>