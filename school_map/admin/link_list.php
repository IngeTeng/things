<?php
    /**
     * 路径链表 （无限极分类） link_list.php
     *
     * @version       v0.03
     * @create time   2014-8-3
     * @update time   2016/3/26
     * @author        IngeTeng
     * @copyright     Neptune工作室
     */
    require_once('admin_init.php');
    require_once('admincheck.php');
   

    $POWERID        = '7001';//权限
    Admin::checkAuth($POWERID, $ADMINAUTH);

     //加载所需的类
    require($LIB_PATH.'link.class.php');
    require($LIB_TABLE_PATH.'table_link.class.php');

    $FLAG_TOPNAV    = "route";
    $FLAG_LEFTMENU  = 'link_list';
     //获得参数后，率先检查参数的合法性
    //搜索参数
    if(!empty($_GET['title'])) 
        $s_title = strCheck($_GET['title'],0);
    else
        $s_title = '';
   $r = Link::getList();
        

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="author" content="Neptune工作室" />
        <title>路径列表 -  管理系统 </title>
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
                $('#btn_addlink').click(function(){
                    location.href = 'link_add.php';
                });
                
                //查询
               $('#searchlink').click(function(){
                
                    s_title            = $('#search_link_title').val();
                   location.href='link_list.php?title='+s_title;                 
                });
                
                //删除评价
                $(".delete").click(function(){
                    var thisid = $(this).parent('td').find('#link_id').val();
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
                                url      : 'link_do.php?act=del',
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
            <?php include('link_menu.inc.php');?>
            <div id="maincontent">
                <div id="position">当前位置：<a href="link_list.php">路径管理</a> &gt; 路径列表</div>
                <div id="handlelist">
                    
                    <span class="table_info"><input type="button" class="btn-handle" id="btn_addlink" value="添 加"/></span>
                </div>
                    
                <div class="tablelist">
                    <table>
                        <tr>
                            <th>路线名称</th>
                            <th>节点名称</th>
                            <th>上级节点</th>
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                         <?php
                    //初始化 
                    $rows1 = Link::getTreeLsit($r);
                    $totalcount= count($rows1);
                    $shownum   = 12;
                    $pagecount = ceil($totalcount / $shownum);
                    $page      = getPage($pagecount);
                    $rows      = page_array($shownum,$page,$rows1,0);
                       

                            $i=1;
                           //$r = category::getList();
                           
                            if(!empty($rows)){//如果列表不为空
                                foreach($rows as $row){
                                    //var_dump($row);
                                    $createtime = date('Y-m-d H:i:s', $row['createtime']);
                                    $parent = Link::getInfoById($row['parent']);
                                    if($parent==0){
                                         $parent = array(
                                            'node_title'              => '初始节点' 
                                            );
                                    }
                            
                                    echo '<tr>
                                            <td class="left">'.$row['title'].'</td>
                                            <td class="left">'.$row['node_title'].'</td>
                                            <td class="center">'.$parent['node_title'].'</td>
                                            <td class="center">'.$createtime.'</td>
                
                                            <td class="center">
                                                
                                                <a class="editinfo" href="link_edit.php?id='.$row['id'].'"><img src="images/dot_edit.png"/></a> 
                                                <a class="delete" href="javascript:void(0);"><img src="images/dot_del.png"/></a>
                                                <input type="hidden" id="link_id" value="'.$row['id'].'"/>
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
