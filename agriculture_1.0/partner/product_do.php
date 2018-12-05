<?php
    /**
     * 商品处理  product_do.php
     *
     * @version       v0.03
     * @create time   2014-9-4
     * @update time   2016/3/25
     * @author        IngeTeng
     * @copyright     Neptune工作室
     */
    require_once('admin_init.php');
    require_once('admincheck.php');
    require($LIB_PATH.'cart.class.php');
    require($LIB_TABLE_PATH.'table_cart.class.php');
    //require_once('product_init.php');

/*    $POWERID = '7001';//权限
    Admin::checkAuth($POWERID, $ADMINAUTH);*/

    $act = safeCheck($_GET['act'], 0);
    switch($act){
        case 'add'://添加套餐
            $cateid                 = strCheck($_POST['cateid']);
            $title                  = strCheck($_POST['title'],0);
            $num                    = strCheck($_POST['num']);
            $pic                    = strCheck($_POST['pic'],0);
            $price                  = strCheck($_POST['price']);
            $post_price             = strCheck($_POST['post_price'],0);
            $issale                 = strCheck($_POST['issale']);
            $ishot                  = strCheck($_POST['ishot']);
            $isnew                  = strCheck($_POST['isnew']);
            $sale_price             = strCheck($_POST['sale_price']);
            $desc                   = $_POST['desc'];
            $add_role               = $PARTNER->getName();
            $add_phone              = $PARTNER->getPhone();
            $add_role_cate          = 2;        //代表平台管理员操作

            //构造需要传递的数组参数
            $productAttr = array(
                
                'cateid'            => $cateid,
                'title'             => $title,
                'num'               => $num,
                'pic'               => $pic,
                'price'             => $price,
                'post_price'        => $post_price,
                'issale'            => $issale,
                'ishot'             => $ishot,
                'isnew'             => $isnew,
                'sale_price'        => $sale_price,
                'desc'              => $desc,
                'add_role'          => $add_role,
                'add_phone'         => $add_phone,
                'add_role_cate'     => $add_role_cate
               
                );

          
            try {
            
                $rs = Product::add($productAttr);
                echo $rs;
            }catch (MyException $e){
                echo $e->jsonMsg();
            }
            break;
            
        case 'edit'://编辑预约信息

            $id                     = strCheck($_POST['id']);
            $cateid                 = strCheck($_POST['cateid']);
            $title                  = strCheck($_POST['title'],0);
            $num                    = strCheck($_POST['num']);
            $pic                    = strCheck($_POST['pic'],0);
            $price                  = strCheck($_POST['price']);
            $post_price             = strCheck($_POST['post_price'],0);
            $issale                 = strCheck($_POST['issale']);
            $ishot                  = strCheck($_POST['ishot']);
            $isnew                  = strCheck($_POST['isnew']);
            $sale_price             = strCheck($_POST['sale_price']);
            $desc                   = $_POST['desc'];

            //构造需要传递的数组参数
            $productAttr = array(
                

                'cateid'            => $cateid,
                'title'             => $title,
                'num'               => $num,
                'pic'               => $pic,
                'price'             => $price,
                'post_price'        => $post_price,
                'issale'            => $issale,
                'ishot'             => $ishot,
                'isnew'             => $isnew,
                'sale_price'        => $sale_price,
                'desc'              => $desc
                );          
            try {
                $rs = Product::edit($id, $productAttr);
                echo $rs;
            }catch (MyException $e){
                echo $e->jsonMsg();
            }
            break;
            
        case 'del'://删除套餐
            $id = safeCheck($_POST['id']);
            
            try {
                $order_detail = Order_detail::getInfoByProductid($id);
            
                if($order_detail){
                $comments = Comment::getInfoByOrder_detailid($order_detail['id']);
                //var_dump($comments);
                 if(!empty($comments)){//如果列表不为空
                    foreach($comments as $comment){
                            $rss = Comment::del($comment['id']);
                    }
                }
               }
               $cartAttr = array(
                'ischecked'     => 0

                    );
               table_cart::edit_ischecked($id,$cartAttr);
                $rs = Product::del($id);
                
                echo $rs;
            }catch (MyException $e){
                echo $e->jsonMsg();
            }
            break;


        case 'close'://关闭交易
            $id = safeCheck($_POST['id']);
            
            try {
                $rs = Product::close($id);
                echo $rs;
            }catch (MyException $e){
                echo $e->jsonMsg();
            }
            break;

        
    }
?>