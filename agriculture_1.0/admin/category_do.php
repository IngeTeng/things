<?php
    /**
     * 商品分类信息处理  category_do.php
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
    
    require_once('product_init.php');
    $act = safeCheck($_GET['act'], 0);
    switch($act){
        case 'add'://添加分类
            $title              = strCheck($_POST['title'],0);
            $pic                = strCheck($_POST['pic'],0);
            $parent             = strCheck($_POST['parent']);
            //构造需要传递的数组参数
            $categoryAttr = array(
                
                'title'              => $title,
                'pic'                => $pic,
                'parent'             => $parent
             
                );
            try {
                $rs = Category::add($categoryAttr);
                echo $rs;
            }catch (MyException $e){
                echo $e->jsonMsg();
            }
            break;
            
        case 'edit'://编辑分类信息
            $id                 = strCheck($_POST['id']);
            $title              = strCheck($_POST['title'],0);
            $pic                = strCheck($_POST['pic'],0);
            $parent             = strCheck($_POST['parent']);       

            //构造需要传递的数组参数
            $categoryAttr = array(
                
                'title'              => $title,
                'pic'                => $pic,
                'parent'             => $parent
        
                );
            try {
                $rs = Category::edit($id, $categoryAttr);
                echo $rs;
            }catch (MyException $e){
                echo $e->jsonMsg();
            }
            break;
            
        case 'del'://删除分类
            $id = safeCheck($_POST['id']);
            
            try {
                $rs = Category::del($id);
                echo $rs;
            }catch (MyException $e){
                echo $e->jsonMsg();
            }
            break;
        
    }
?>