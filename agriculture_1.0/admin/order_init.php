<?php

/**
 * order_init.php 订单管理初始化文件
 *
 * @version       v0.02
 * @create time   2014/7/24
 * @update time   2016/3/27
 * @author        IngeTeng
 */

//地址表单
require($LIB_PATH.'address.class.php');
require($LIB_TABLE_PATH.'table_address.class.php');
//订单表
require($LIB_PATH.'order.class.php');
require($LIB_TABLE_PATH.'table_order.class.php');
//详细订单表
require($LIB_PATH.'order_detail.class.php');
require($LIB_TABLE_PATH.'table_order_detail.class.php');
//提交工单表
require($LIB_PATH.'submit.class.php');
require($LIB_TABLE_PATH.'table_submit.class.php');
