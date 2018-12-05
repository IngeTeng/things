<?php
/**
 * 产品列表  user_list.php
 *
 * @version       v0.01
 * @create time   2016-11-14
 * @update time   2016-11-15
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */
require_once('admin_init.php');
require_once('admincheck.php');
/*
$POWERID        = '7001';
Admin::checkAuth($POWERID, $ADMINAUTH);
require_once('product_init.php');*/
$FLAG_TOPNAV    = "role";

$FLAG_LEFTMENU  = 'product_list';



if(!empty($_GET['title']))
    $s_title  = safeCheck($_GET['title'], 0);
else
    $s_title  = '';

if(!empty($_GET['cateid']))
    $s_cateid  = safeCheck($_GET['cateid']);
else
    $s_cateid  = 0;



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="author" content="Neptune工作室" />
    <title>商品 - 商品设置 - 管理系统 </title>
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

            //添加商品
            $('#addproduct').click(function () {
                location.href = 'product_add.php';
            });

            $('#downloadproduct').click(function () {
                location.href = 'product_download.php';
            });
            //查询
            $('#searchproduct').click(function(){

                
                s_cateid        = $('#search_cateid').val();
                s_title         = $('#search_title').val();
                location.href='index.php?cateid='+s_cateid+'&title='+s_title;
            });

            //删除商品
            $(".delete").click(function () {
                var thisid = $(this).parent('td').find('#productid').val();
                layer.confirm('确认删除？该产品的评论信息也将删除', {
                        btn: ['确认', '取消']
                    }, function () {
                        var index = layer.load(0, {shade: false});
                        $.ajax({
                            type: 'POST',
                            data: {
                                id: thisid
                            },
                            dataType: 'json',
                            url: 'product_do.php?act=del',
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
             $(".see").mouseover(function(){
                    layer.tips('查看详情', $(this), {
                        tips: [4, '#3595CC'],
                        time: 500
                    });
                });
    
            $(".editinfo").mouseover(function(){
                layer.tips('修改', $(this), {
                    tips: [4, '#3595CC'],
                    time: 500
                });
            });

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
    <?php include('role_menu.inc.php');?>
        <div id="maincontent">
            <div id="position">当前位置：<a href="index.php">分销商管理</a> > 分销商设置</div>
            <div id="handlelist">
                <?php
                //初始化
                $phone     = $PARTNER->getPhone();
                $totalcount= Product::search_phone(0, 0, $phone,$s_cateid,$s_title, 1);
                $shownum   = 5;
                $pagecount = ceil($totalcount / $shownum);
                $page      = getPage($pagecount);//点击页码之后在这函数里面获取页码
                $rows      = Product::search_phone($page, $shownum,$phone, $s_cateid,$s_title);
                ?>
    
              <!--   <input class="order-input" placeholder="产品分类"  name="search_cateid" id="search_cateid" value="<?php echo $s_cateid?>" style="width:15%;height:16px;" type="text"> -->
                

                <select name="search_cateid" id="search_cateid" class="select-option" style="width:15%;height:30px;">
                        <?php
                            $rc = Category::getList();
                            $cateids = Category::getOptions($rc);
                                if(!empty($cateids)){
                                    $keys=array_keys($cateids);
                                    foreach($keys as $key){

                                        echo '<option value="'.$key.'"';
                                        if($s_cateid == $key) echo ' selected ';
                                        echo '>'.$cateids[$key].'</option>';
                                    }
                                }
                        ?>
                    </select> 


                <input class="order-input" placeholder="商品名称"  name="search_title" id="search_title" value="<?php echo $s_title?>" style="width:20%;height:16px;" type="text">

                <input style="margin-left:10px" class="btn-handle" id="searchproduct" value="查询" type="button">

               <!--  <span class="table_info"><input type="button" class="btn-handle" id="downloadproduct" value="下载商品信息"/></span> -->
                <span class="table_info"><input type="button" class="btn-handle" id="addproduct" value="添 加"/></span>
                <div>
                </div>
            </div>
            <div class="tablelist" >
            <table>
                <tr>
                    <th>商品图片</th>
                    <th>商品名称</th>
                    <th>商品分类</th>
                    <th>商品原价</th>
                    <th>是否促销</th>
                    <th>商品促销价</th>
                    <th>物流单价</th>
                    <th>商品库存量</th>
                    <th>是否热卖</th>
                    <th>是否新品</th>
                    <th>添加时间</th>
                    <th>操作</th>
                </tr>
                <?php

                $i=1;
                //  var_dump($rows);
                if(!empty($rows)){//如果列表不为空
                    foreach($rows as $row){
                        $pic            = $HTTP_PATH.$row['pic'];
                        //$add_role_cate  = Product::getAdd_role_cateName($row['add_role_cate']);
                        $createtime     = date('Y-m-d H:m', $row['createtime']);
                        $issale         = product::getStateName($row['issale']);
                        $isnew          = product::getStateName($row['isnew']);
                        $ishot          = product::getStateName($row['ishot']);
                        $cateid = Category::getInfoById($row['cateid']);

                        //$ishot          = Product::getHotName($row['ishot']);
                       // $isnew          = Product::getNewName($row['isnew']);
                        //确守根据openid查询用户的操作
                        //商品分类名查询
                        echo '<tr>          
                                            <td class="center">
                                                <div id="wrap">
                                                    <a href="'.$pic.'" class="framer">
                                                         <img src="'.$pic.'" width="100" height="100" />
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="center">'.$row['title'].'</td>
                                            <td class="center">'.$cateid['title'].'</td>
                                            <td class="center">'.$row['price'].'</td>
                                            <td class="center">'.$issale.'</td>
                                            <td class="center">'.$row['sale_price'].'</td>
                                            <td class="center">'.$row['post_price'].'</td>
                                            <td class="center">'.$row['num'].'</td>
                                            <td class="center">'.$ishot.'</td>
                                            <td class="center">'.$isnew.'</td>
                                            <td class="center">'.$createtime.'</td> 
                                                        
                                            <td class="center">
                                                <a class="see" href="comment_list.php?productid='.$row['id'].'"><img src="images/dot_see.png"/></a>  
                                                <a class="editinfo" href="product_edit.php?id='.$row['id'].'"><img src="images/dot_edit.png"/></a> 
                                                <a class="delete" href="javascript:void(0);"><img src="images/dot_del.png"/></a>
                                                <input type="hidden" id="productid" value="'.$row['id'].'"/>
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
