<?php

/**
 * product_init.php 商品管理初始化文件
 *
 * @version       v0.02
 * @create time   2014/7/24
 * @update time   2016/3/27
 * @author        IngeTeng
 */

//商品表单
require($LIB_PATH.'product.class.php');
require($LIB_TABLE_PATH.'table_product.class.php');
//商品分类表
require($LIB_PATH.'category.class.php');
require($LIB_TABLE_PATH.'table_category.class.php');
//购物车表
require($LIB_PATH.'cart.class.php');
require($LIB_TABLE_PATH.'table_cart.class.php');
//评论表
require($LIB_PATH.'comment.class.php');
require($LIB_TABLE_PATH.'table_comment.class.php');