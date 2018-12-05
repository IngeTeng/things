<?php
/**
 * 工单列表  submit_list.php
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
require_once('order_init.php');
$FLAG_TOPNAV    = "order";

$FLAG_LEFTMENU  = 'submit_list';

if(!empty($_GET['only'])){
    $s_only  = safeCheck($_GET['only'], 0);
}else{
    $s_only  = '';
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="author" content="Neptune工作室" />
    <title>工单 - 工单设置 - 管理系统 </title>
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
            //添加工单
            $('#addsubmit').click(function () {
                location.href = 'submit_add.php';
            });
            //查询
            $('#searchsubmit').click(function(){

                s_only              = $('#search_only').val();
               
                location.href='submit_list.php?only='+s_only;
            });

            //删除
            $(".delete").click(function () {
                var thisid = $(this).parent('td').find('#submitid').val();
                layer.confirm('确认删除该工地单信息吗？', {
                        btn: ['确认', '取消']
                    }, function () {
                        var index = layer.load(0, {shade: false});
                        $.ajax({
                            type: 'POST',
                            data: {
                                id: thisid
                            },
                            dataType: 'json',
                            url: 'submit_do.php?act=del',
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




             /*$(".see").mouseover(function(){
                    layer.tips('订单详情', $(this), {
                        tips: [4, '#3595CC'],
                        time: 500
                    });
                });*/
    
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
    <?php include('order_menu.inc.php');?>
        <div id="maincontent">
            <div id="position">当前位置：<a href="submit_list.php">工单管理</a> > 工单设置</div>
            <div id="handlelist">
                <?php
                //初始化
                $totalcount= Submit::search(0, 0, $s_only, 1);
                $shownum   = 10;
                $pagecount = ceil($totalcount / $shownum);
                $page      = getPage($pagecount);//点击页码之后在这函数里面获取页码
                $rows      = Submit::search($page, $shownum, $s_only);
                ?>
    

             <input class="order-input" placeholder="工单号"  name="search_only" id="search_only" value="<?php echo $s_only?>" style="width:20%;height:16px;" type="text">


                <input style="margin-left:10px" class="btn-handle" id="searchsubmit" value="查询" type="button">
                <span class="table_info">
                    <input type="button" class="btn-handle" id="addsubmit" value="添 加"/>
                </span>
                <div>
                </div>
            </div>
            <div class="tablelist" >
            <table>
                <tr>
                    <th>工单号</th>
                    <th>微信识别码</th>
                    <th>微信昵称</th>
                    <th>提问内容</th>
                    <th>回答内容</th>
                    <th>工单状态</th>
                    <th>添加时间</th>
                    <th>操作</th>
                </tr>
                <?php

                $i=1;
                //  var_dump($rows);
                if(!empty($rows)){//如果列表不为空
                    foreach($rows as $row){
                        $createtime           = date('Y-m-d H:m', $row['createtime']);
                        $userInfo             = User::getInfoByOpenid($row['openid']);
                        if(empty($row['replay'])){
                            $state = '待处理';
                        }else{
                            $state = '已处理';
                        }
                        if(strlen($row['desc'])>20){
                            $row['desc'] = mb_substr($row['desc'] , 0,20,'utf-8').'...';
                        }
                        if(strlen($row['replay'])>20){
                            $row['replay'] = mb_substr($row['replay'] , 0,20,'utf-8').'...';
                        }
                        echo '<tr>          
                        
                                            <td class="center">'.$row['only'].'</td>
                                            <td class="center">'.$row['openid'].'</td>
                                            <td class="center">'.$row['nikname'].'</td>
                                            <td class="center">'.$row['desc'].'</td>
                                            <td class="center">'.$row['replay'].'</td>

                                            <td class="center">'.$state.'</td>
                                            <td class="center">'.$createtime.'</td> 
                                                        
                                            <td class="center">
                                               <a class="editinfo" href="submit_edit.php?id='.$row['id'].'"><img src="images/dot_edit.png"/></a> 
                                                <a class="delete" href="javascript:void(0);"><img src="images/dot_del.png"/></a>
                                                <input type="hidden" id="submitid" value="'.$row['id'].'"/>
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
