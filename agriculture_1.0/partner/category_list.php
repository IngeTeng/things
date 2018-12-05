<?php
    /**
     * 商品分类表 （无限极分类）  category_list.php
     *
     * @version       v0.03
     * @create time   2014-8-3
     * @update time   2016/3/26
     * @author        IngeTeng
     * @copyright     Neptune工作室
     */
    require_once('admin_init.php');
    require_once('admincheck.php');
   

   /* $POWERID        = '7001';//权限
    Admin::checkAuth($POWERID, $ADMINAUTH);*/

     //加载所需的类
    //require_once('product_init.php');

    $FLAG_TOPNAV    = "role";
    $FLAG_LEFTMENU  = 'category_list';
     //获得参数后，率先检查参数的合法性
    //搜索参数
    if(!empty($_GET['title'])) 
        $s_title = strCheck($_GET['title'],0);
    else
        $s_title = '';
   $r = Category::getList();
        

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="author" content="Neptune工作室" />
        <title>商品分类列表 -  管理系统 </title>
        <link rel="stylesheet" href="css/style.css" type="text/css" />
        <link rel="stylesheet" href="css/form.css" type="text/css" />
        <!-- <link rel="stylesheet" href="css/boxy.css" type="text/css" /> -->
        <link rel="stylesheet" href="css/jquery.Framer.css" type="text/css" />
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/jquery.Framer.js"></script>
        <script type="text/javascript" src="js/layer/layer.js"></script>
        <script type="text/javascript" src="js/common.js"></script>
         <script src="js/Vague.js"></script>
        <script type="text/javascript">
            $(function(){
                //添加按钮
                $('#btn_addcategory').click(function(){
                    location.href = 'category_add.php';
                });
                
                //查询
               $('#searchcategory').click(function(){
                
                    s_title            = $('#search_category_title').val();
                   location.href='category_list.php?title='+s_title;                 
                });
                
                //删除评价
                $(".delete").click(function(){
                    var thisid = $(this).parent('td').find('#category_id').val();
                    layer.confirm('确认删除该分类吗？', {
                        btn: ['确认','取消']
                        }, function(){
                            var index = layer.load(0, {shade: false});
                            $.ajax({
                                type : 'POST',
                                data : {
                                    id : thisid
                                },
                                dataType : 'json',
                                url      : 'category_do.php?act=del',
                                success  : function(data){
                                    layer.close(index);
                                    
                                    var code = data.code;
                                    var msg  = data.msg;
                                    switch(code){
                                        case 1:
                                            layer.alert(msg, {icon: 6}, function(index){
                                                location.reload();
                                            });
                                            break;
                                        default:
                                            layer.alert(msg, {icon: 5});
                                    }
                                }
                            });
                        }, function(){}
                    );
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
                <div id="position">当前位置：<a href="category_list.php">分类管理</a> &gt; 分类列表</div>
                <div id="handlelist">
                    
                    <span class="table_info"><input type="button" class="btn-handle" id="btn_addcategory" value="添 加"/></span>
                </div>
                    
                <div class="tablelist">
                    <table>
                        <tr>
                            <th>分类名称</th>
                            <th>分类图片</th>
                            <th>上级分类</th>
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                         <?php
                    //初始化 
                    $rows1 = Category::getTreeLsit($r);
                    $totalcount= count($rows1);
                    $shownum   = 5;
                    $pagecount = ceil($totalcount / $shownum);
                    $page      = getPage($pagecount);
                    $rows      = page_array($shownum,$page,$rows1,0);
                       

                            $i=1;
                           //$r = category::getList();
                           
                            if(!empty($rows)){//如果列表不为空
                                foreach($rows as $row){
                
                                    $pic    = $HTTP_PATH.$row['pic'];
                                    $createtime = date('Y-m-d H:i:s', $row['createtime']);
                                    $parent = Category::getInfoById($row['parent']);
                                    if($parent==0){
                                         $parent = array(
                                            'title'              => '顶级分类' 
                                            );
                                    }
                            
                                    echo '<tr>
                                            <td class="left">'.$row['title'].'</td>
                                            <td class="center">
                                                <div id="wrap">
                                                    <a href="'.$pic.'" class="framer">
                                                         <img src="'.$pic.'" width="60" height="60" />
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="center">'.$parent['title'].'</td>
                                            <td class="center">'.$createtime.'</td>
                
                                            <td class="center">
                                                
                                                <a class="editinfo" href="category_edit.php?id='.$row['id'].'"><img src="images/dot_edit.png"/></a> 
                                                <a class="delete" href="javascript:void(0);"><img src="images/dot_del.png"/></a>
                                                <input type="hidden" id="category_id" value="'.$row['id'].'"/>
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
            </div></div>
            <div class="clear"></div>
        <?php include('footer.inc.php');?>
          <script src="js/sample.js"></script>
    </body>
</html>
