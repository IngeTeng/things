<?php
/**
 * 评论商品列表  comment_list.php
 *
 * @version       v0.01
 * @create time   2016-11-14
 * @update time   2016-11-15
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */
require_once('admin_init.php');
require_once('admincheck.php');

$POWERID        = '7001';
Admin::checkAuth($POWERID, $ADMINAUTH);


require_once('product_init.php');
$FLAG_TOPNAV    = "shop";

$FLAG_LEFTMENU  = 'comment_list';



if(!empty($_GET['nikname'])){
    $s_nikname  = safeCheck($_GET['nikname'],0);
}else{
    $s_nikname  = '';
}

if(!empty($_GET['product_title'])){
    $s_product_title  = safeCheck($_GET['product_title'],0);
}else{
    $s_product_title  = '';
}

if(!empty($_GET['productid'])){
    $s_productid  = safeCheck($_GET['productid'],0);
}else{
    $s_productid  = '';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="author" content="Neptune工作室" />
    <title>评论 - 商品设置 - 管理系统 </title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <link rel="stylesheet" href="css/form.css" type="text/css" />
    <link rel="stylesheet" href="css/boxy.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery.Framer.css" type="text/css" />
    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.Framer.js"></script>
    <script type="text/javascript" src="js/layer/layer.js"></script>
    <script type="text/javascript" src="js/common.js"></script>
    <script src="js/Vague.js"></script>
  
    <script type="text/javascript">
        $(function() {

            //查询
            $('#searchcomment').click(function(){

                s_nikname              = $('#search_nikname').val();
                s_product_title        = $('#search_product_title').val();
                location.href='comment_list.php?nikname='+s_nikname+'&product_title='+s_product_title;
            });

            //删除评论
            $(".delete").click(function () {
                var thisid = $(this).parent('td').find('#commentid').val();
                layer.confirm('确认删除该产品信息吗？', {
                        btn: ['确认', '取消']
                    }, function () {
                        var index = layer.load(0, {shade: false});
                        $.ajax({
                            type: 'POST',
                            data: {
                                id: thisid
                            },
                            dataType: 'json',
                            url: 'comment_do.php?act=del',
                            success: function (data) {
                                layer.close(index);

                                code = data.code;
                                msg = data.msg;
                                switch (code) {
                                    case 1:
                                        layer.alert(msg, {icon: 6}, function (index) {
                                            location.reload();
                                        });
                                        break;
                                    default:
                                        layer.alert(msg, {icon: 5});
                                }
                            }
                        });
                    }, function () {
                    }
                );
            });
            /* $(".see").mouseover(function(){
                    layer.tips('查看详情', $(this), {
                        tips: [4, '#3595CC'],
                        time: 500
                    });
                });*/
    
            /*$(".editinfo").mouseover(function(){
                layer.tips('修改', $(this), {
                    tips: [4, '#3595CC'],
                    time: 500
                });
            });*/

            $(".delete").mouseover(function(){
                layer.tips('删除', $(this), {
                    tips: [4, '#3595CC'],
                    time: 500
                });
            });
        });
    </script>
</head>
<body>
<div id="header">
    <?php include('top.inc.php');?>
    <?php include('nav.inc.php');?>
</div>
<div id="container">
    <?php include('shop_menu.inc.php');?>
        <div id="maincontent">
            <div id="position">当前位置：<a href="comment_list.php">评论管理</a> > 分销商设置</div>
            <div id="handlelist">
                <?php
                //初始化
                $totalcount= Comment::search(0, 0,  $s_nikname, $s_product_title,$s_productid, 1);
                $shownum   = 10;
                $pagecount = ceil($totalcount / $shownum);
                $page      = getPage($pagecount);//点击页码之后在这函数里面获取页码
                $rows      = Comment::search($page, $shownum,$s_nikname ,$s_product_title , $s_productid);
                ?>
    
              <!--   <input class="order-input" placeholder="产品分类"  name="search_cateid" id="search_cateid" value="<?php echo $s_cateid?>" style="width:15%;height:16px;" type="text"> -->
                

                <input class="order-input" placeholder="用户昵称"  name="search_nikname" id="search_nikname" value="<?php echo $s_nikname?>" style="width:20%;height:16px;" type="text">
                <input class="order-input" placeholder="商品名称"  name="search_product_title" id="search_product_title" value="<?php echo $s_product_title?>" style="width:20%;height:16px;" type="text">

                <input style="margin-left:10px" class="btn-handle" id="searchcomment" value="查询" type="button">

               <!--  <span class="table_info"><input type="button" class="btn-handle" id="downloadproduct" value="下载商品信息"/></span> -->
               <!--  <span class="table_info"><input type="button" class="btn-handle" id="addproduct" value="添 加"/></span> -->
                <div>
                </div>
            </div>
            <div class="tablelist" >
            <table>
                <tr>
                    <th>商品图片</th>  
                    <th>商品名称</th>
                    <th>用户头像</th>
                    <th>微信昵称</th>
                    <th>微信识别码</th>
                    <th>评论内容</th>
                    <th>添加时间</th>
                    <th>操作</th>
                </tr>
                <?php

                $i=1;
                //  var_dump($rows);
                if(!empty($rows)){//如果列表不为空
                    foreach($rows as $row){
                        $order_detail   = Order_detail::getInfoById($row['order_detailid']);
                        $userinfo       = table_user::getInfoByOpenid($row['openid']);
                        
                        $product        = Product::getInfoById($order_detail['productid']);
                        $pic            = $HTTP_PATH.$product['pic'];
                        $photo          = $userinfo['0']['img'];
                        //var_dump($photo);
                        $title          = $row['product_title'];
                        $createtime     = date('Y-m-d H:m', $row['createtime']);
        
                        //$ishot          = Product::getHotName($row['ishot']);
                       // $isnew          = Product::getNewName($row['isnew']);
                        //确守根据openid查询用户的操作
                        //商品分类名查询
                        echo '<tr>          
                                            <td class="center">
                                                <div id="wrap">
                                                    <a href="'.$pic.'" class="framer">
                                                         <img src="'.$pic.'" width="40" height="40" />
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="center">'.$title.'</td>
                                              <td class="center">
                                                         <img src="'.$photo.'" width="40" height="40" />
                                            </td>
                                            <td class="center">'.$row['nikname'].'</td>
                                            <td class="center">'.$row['openid'].'</td>
                                            <td class="center">'.$row['desc'].'</td>
                                            <td class="center">'.$createtime.'</td> 
                                                        
                                            <td class="center">                     
                                                <a class="delete" href="javascript:void(0);"><img src="images/dot_del.png"/></a>
                                                <input type="hidden" id="cartid" value="'.$row['id'].'"/>
                                            </td>
                                        </tr>
                                    ';
                        $i++;
                    }
                }else{
                    echo '<tr><td class="center" colspan="8">没有数据</td></tr>';
                }
                ?>


            </table>
        </div>
            <div id="pagelist">
            <div class="pageinfo">
                <span class="table_info">共<?php echo $totalcount;?>条数据，共<?php echo $pagecount;?>页</span>
            </div>
            <?php
            if($pagecount>1){
                echo dspPages(getPageUrl(), $page, $shownum, $totalcount, $pagecount);
            }
            ?>
        </div>
        </div>
    <div class="clear"></div>
</div>
<?php include('footer.inc.php');?>
  <script src="js/sample.js"></script>
</body>
</html>
