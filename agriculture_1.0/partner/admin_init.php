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
//商品管理
require($LIB_PATH.'product.class.php');
require($LIB_TABLE_PATH.'table_product.class.php');
//商品分类
require($LIB_PATH.'category.class.php');
require($LIB_TABLE_PATH.'table_category.class.php');
//商品评价
require($LIB_PATH.'comment.class.php');
require($LIB_TABLE_PATH.'table_comment.class.php');
//订单管理
require($LIB_PATH.'order.class.php');
require($LIB_TABLE_PATH.'table_order.class.php');
//订单管理
require($LIB_PATH.'order_detail.class.php');
require($LIB_TABLE_PATH.'table_order_detail.class.php');
//分销商表单
require($LIB_PATH.'partner.class.php');
require($LIB_TABLE_PATH.'table_partner.class.php');
?>