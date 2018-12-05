<?php
    /**
     * 建议 suggest_list.php
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
    require($LIB_PATH.'suggest.class.php');
    require($LIB_TABLE_PATH.'table_suggest.class.php');

    $FLAG_TOPNAV    = "content";
    $FLAG_LEFTMENU  = 'suggest_list';
     //获得参数后，率先检查参数的合法性
    //搜索参数
    if(!empty($_GET['name'])) {
        $s_name = strCheck($_GET['name'],0);
    }else{
        $s_name = '';
    }

    if(!empty($_GET['phone'])) {
        $s_phone = strCheck($_GET['phone'],0);
    }else{
        $s_phone = '';
    }
        

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="author" content="Neptune工作室" />
        <title>留言列表 -  管理系统 </title>
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
                /*$('#btn_addsuggest').click(function(){
                    location.href = 'suggest_add.php';
                });*/
                
                //查询
               $('#searchsuggest').click(function(){
                
                    s_name            = $('#search_name').val();
                    s_phone            = $('#search_phone').val();
                   location.href='suggest_list.php?name='+s_name+'&phone='+s_phone;                 
                });
                
                //删除评价
                $(".delete").click(function(){
                    var thisid = $(this).parent('td').find('#suggestid').val();
                    layer.confirm('确认删除该留言吗？', {
                        btn: ['确认','取消']
                        }, function(){
                            var index = layer.load(0, {shade: false});
                            $.ajax({
                                type : 'POST',
                                data : {
                                    id : thisid
                                },
                                dataType : 'json',
                                url      : 'suggest_do.php?act=del',
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
                <div id="position">当前位置：<a href="suggest_list.php">留言管理</a> &gt; 留言列表</div>
                <div id="handlelist">
                     <?php
                //初始化
                $totalcount= Suggest::search(0, 0,  $s_name,$s_phone,  1);
                $shownum   = 10;
                $pagecount = ceil($totalcount / $shownum);
                $page      = getPage($pagecount);//点击页码之后在这函数里面获取页码
                $rows      = Suggest::search($page, $shownum,$s_name , $s_phone );
                ?>

                <input class="order-input" placeholder="姓名"  name="search_name" id="search_name" value="<?php echo $s_name?>" style="width:20%;height:16px;" type="text">

                <input class="order-input" placeholder="电话"  name="search_phone" id="search_phone" value="<?php echo $s_phone?>" style="width:20%;height:16px;" type="text">

                <input style="margin-left:10px" class="btn-handle" id="searchsuggest" value="查询" type="button">
                    <!-- <span class="table_info"><input type="button" class="btn-handle" id="btn_addsuggest" value="添 加"/></span> -->
                </div>
                    
                <div class="tablelist">
                    <table>
                        <tr>
                            <th>留言者姓名</th>
                            <th>留言者电话</th>
                            <th>留言内容</th>
                            <th>留言时间</th>
                            <th>操作</th>
                        </tr>
                        <?php

                $i=1;
                //  var_dump($rows);
                if(!empty($rows)){//如果列表不为空
                    foreach($rows as $row){
                       
                        $createtime     = date('Y-m-d H:m', $row['createtime']);
                         if(strlen($row['desc'])>20){
                            $row['desc'] = mb_substr($row['desc'] , 0,20,'utf-8').'...';
                        }
                        echo '<tr>          
                        
                                            <td class="center">'.$row['name'].'</td>
                                            <td class="center">'.$row['phone'].'</td>
                                            <td class="center">'.$row['desc'].'</td>

                                            <td class="center">'.$createtime.'</td> 
                                                        
                                            <td class="center">
                                            <a class="see" href="suggest_see.php?id='.$row['id'].'"><img src="images/dot_see.png"/></a>                      
                                                <a class="delete" href="javascript:void(0);"><img src="images/dot_del.png"/></a>
                                                <input type="hidden" id="suggestid" value="'.$row['id'].'"/>
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
