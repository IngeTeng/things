<?php
    /**
     * 路径处理  link_do.php
     *
     * @version       v0.03
     * @create time   2014-9-4
     * @update time   2016/3/25
     * @author        IngeTeng
     * @copyright     Neptune工作室
     */
    require_once('admin_init.php');
    require_once('admincheck.php');
    

    $POWERID = '7001';//权限
    Admin::checkAuth($POWERID, $ADMINAUTH);
    
    require($LIB_PATH.'link.class.php');
    require($LIB_TABLE_PATH.'table_link.class.php');

    $act = safeCheck($_GET['act'], 0);
    switch($act){
        case 'add'://添加分类
            $title              = strCheck($_POST['title'],0);
            $node_id            = strCheck($_POST['node_id']);
            $node               = Node::getInfoById($node_id);
            $node_title         = $node['title'];
            $node_jing          = $node['jing'];
            $node_wei           = $node['wei'];
            $parent             = strCheck($_POST['parent']);
            //构造需要传递的数组参数
            $linkAttr = array(
                
                'title'                 => $title,
                'node_id'               => $node_id,
                'node_title'            => $node_title,
                'node_jing'             => $node_jing,
                'node_wei'              => $node_wei,
                'parent'                => $parent
             
                );
            try {
                $rs = Link::add($linkAttr);
                echo $rs;
            }catch (MyException $e){
                echo $e->jsonMsg();
            }
            break;
            
        case 'edit'://编辑分类信息
            $id                 = strCheck($_POST['id']);
            $title              = strCheck($_POST['title'],0);
            $node_id            = strCheck($_POST['node_id']);
            $node               = Node::getInfoById($node_id);
            $node_title         = $node['title'];
            $node_jing          = $node['jing'];
            $node_wei           = $node['wei'];
            $parent             = strCheck($_POST['parent']);
            //构造需要传递的数组参数
            $linkAttr = array(
                
                'title'                 => $title,
                'node_id'               => $node_id,
                'node_title'            => $node_title,
                'node_jing'             => $node_jing,
                'node_wei'              => $node_wei,
                'parent'                => $parent
        
                );
            try {
                $rs = Link::edit($id, $linkAttr);
                echo $rs;
            }catch (MyException $e){
                echo $e->jsonMsg();
            }
            break;
            
        case 'del'://删除分类
            $id = safeCheck($_POST['id']);
            
            try {
                $rs = Link::del($id);
                echo $rs;
            }catch (MyException $e){
                echo $e->jsonMsg();
            }
            break;
        
    }
?>