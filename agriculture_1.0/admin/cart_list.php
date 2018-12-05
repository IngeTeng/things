<?php
/**
 * 购物车列表  cart_list.php
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

$FLAG_LEFTMENU  = 'cart_list';



if(!empty($_GET['nikname'])){
    $s_nikname  = safeCheck($_GET['nikname']);
}else{
    $s_nikname  = '';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="author" content="Neptune工作室" />
    <title>购物车 - 购物车设置 - 管理系统 </title>
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
            $('#searchcart').click(function(){

                s_nikname        = $('#search_nikname').val();
                location.href='cart_list.php?nikname='+s_nikname;
            });

            //删除购物车
            $(".delete").click(function () {
                var thisid = $(this).parent('td').find('#cartid').val();
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
                            url: 'cart_do.php?act=del',
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
            <div id="position">当前位置：<a href="cart_list.php">购物车管理</a> > 分销商设置</div>
            <div id="handlelist">
                <?php
                //初始化
                $totalcount= Cart::search(0, 0,  $s_nikname, 1);
                $shownum   = 10;
                $pagecount = ceil($totalcount / $shownum);
                $page      = getPage($pagecount);//点击页码之后在这函数里面获取页码
                $rows      = Cart::search($page, $shownum,$s_nikname);
                ?>
    
              <!--   <input class="order-input" placeholder="产品分类"  name="search_cateid" id="search_cateid" value="<?php echo $s_cateid?>" style="width:15%;height:16px;" type="text"> -->
                

                <input class="order-input" placeholder="用户昵称"  name="search_nikname" id="search_nikname" value="<?php echo $s_nikname?>" style="width:20%;height:16px;" type="text">


                <input style="margin-left:10px" class="btn-handle" id="searchcart" value="查询" type="button">

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
                    <th>商品数量</th>
                    <th>商品单格</th>
                    <th>微信昵称</th>
                    <th>微信识别码</th>
                    <th>添加时间</th>
                    <th>操作</th>
                </tr>
                <?php

                $i=1;
                //  var_dump($rows);
                if(!empty($rows)){//如果列表不为空
                    foreach($rows as $row){
                        $product        = Product::getInfoById($row['productid']);

                        $pic           = $HTTP_PATH.$row['product_pic'];
                        //$title          = $product['title'];
                        if($product['issale']){
                            $price      = $product['sale_price'];
                        }else{
                            $price      = $product['price'];

                        }
                        if(empty($product)){
                            $price      = '此商品已删除！';
                        }
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
                                            <td class="center">'.$row['product_title'].'</td>
                                            <td class="center">×'.$row['productnum'].'</td>
                                            <td class="center">'.$price.'</td>
                                            <td class="center">'.$row['nikname'].'</td>
                                            <td class="center">'.$row['openid'].'</td>
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
