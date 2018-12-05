<?php
    /**
     * 新闻管路 news_list.php
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
    require($LIB_PATH.'news.class.php');
    require($LIB_TABLE_PATH.'table_news.class.php');

    $FLAG_TOPNAV    = "content";
    $FLAG_LEFTMENU  = 'news_list';
     //获得参数后，率先检查参数的合法性
    //搜索参数
    if(!empty($_GET['title'])) 
        $s_title = strCheck($_GET['title'],0);
    else
        $s_title = '';
        

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="author" content="Neptune工作室" />
        <title>新闻列表 -  管理系统 </title>
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
                $('#btn_addnews').click(function(){
                    location.href = 'news_add.php';
                });


                $('#btn_updatenews').click(function(){
                   // location.href = 'news_add.php';
                   // 
                   $.ajax({
                        type : 'POST',
                        data : {
                        },
                        dataType : 'json',
                        url      : 'news_do.php?act=update',
                        success  : function(data){
                            console.log('success');
                            var code = data.code;
                            var msg  = data.msg;
                            switch(code){
                                case 1:
                                    layer.alert(msg, {icon: 6,shade: false}, function(index){
                                        location.href = 'news_list.php';
                                    });
                                    break;
                                default:
                                    layer.alert(msg, {icon: 5});
                            }
                        }
                    });
                });
                
                //查询
               $('#searchnews').click(function(){
                
                    s_title            = $('#search_title').val();
                   location.href='news_list.php?title='+s_title;                 
                });
                
                //删除评价
                $(".delete").click(function(){
                    var thisid = $(this).parent('td').find('#newsid').val();
                    layer.confirm('确认删除该新闻吗？', {
                        btn: ['确认','取消']
                        }, function(){
            
                            $.ajax({
                                type : 'POST',
                                data : {
                                    id : thisid
                                },
                                dataType : 'json',
                                url      : 'news_do.php?act=del',
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
            <?php include('content_menu.inc.php');?>
            <div id="maincontent">
                <div id="position">当前位置：<a href="news_list.php">新闻管理</a> &gt; 新闻列表</div>
                <div id="handlelist">
                     <?php
                //初始化
                $totalcount= News::search(0, 0,  $s_title,  1);
                $shownum   = 10;
                $pagecount = ceil($totalcount / $shownum);
                $page      = getPage($pagecount);//点击页码之后在这函数里面获取页码
                $rows      = News::search($page, $shownum,$s_title );
                ?>

                <input class="order-input" placeholder="新闻标题"  name="search_title" id="search_title" value="<?php echo $s_title?>" style="width:20%;height:16px;" type="text">

                <input style="margin-left:10px" class="btn-handle" id="searchnews" value="查询" type="button">
                    <span class="table_info"><input type="button" class="btn-handle" id="btn_addnews" value="添 加"/></span>

                </div>
                    
                <div class="tablelist">
                    <table>
                        <tr>
                            <th>新闻标题</th>
                            <th>新闻图片</th>
                            <th>新闻添加者</th>
                            <th>新闻添加时间</th>
                            <th>操作</th>
                        </tr>
                        <?php

                $i=1;
                //  var_dump($rows);
                if(!empty($rows)){//如果列表不为空
                    foreach($rows as $row){
                       
                        $createtime     = date('Y-m-d H:m', $row['createtime']);
                        $pic    = $HTTP_PATH.$row['pic'];
                        echo '<tr>          
                        
                                            <td class="center">'.$row['title'].'</td>
                                           <td class="center">
                                                <div id="wrap">
                                                    <a href="'.$pic.'" class="framer">
                                                        <img src="'.$pic.'" width="180" height="100" />
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="center">'.$row['admin'].'</td>
                                            <td class="center">'.$createtime.'</td> 
                                                        
                                            <td class="center">
                                            <a class="editinfo" href="news_edit.php?id='.$row['id'].'"><img src="images/dot_edit.png"/></a>                      
                                                <a class="delete" href="javascript:void(0);"><img src="images/dot_del.png"/></a>
                                                <input type="hidden" id="newsid" value="'.$row['id'].'"/>
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
