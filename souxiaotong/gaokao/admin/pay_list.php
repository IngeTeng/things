<?php
/**
 * 节点表  water_level_csv_list.php
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


require($LIB_TABLE_PATH.'table_pay.class.php');

$FLAG_TOPNAV    = "data";

$FLAG_LEFTMENU  = 'pay_list';



if(!empty($_GET['shengyuan'])){
    $s_shengyuan  = safeCheck($_GET['shengyuan'],0);
}else{
    $s_shengyuan  = '';
}

if(!empty($_GET['danwei'])){
    $s_danwei  = safeCheck($_GET['danwei'],0);
}else{
    $s_danwei  = '';
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="author" content="Neptune工作室" />
    <title>交易列表 - 数据设置 - 管理系统 </title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <link rel="stylesheet" href="css/form.css" type="text/css" />
    <link rel="stylesheet" href="css/boxy.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery.Framer.css" type="text/css" />
    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.Framer.js"></script>
    <script type="text/javascript" src="js/layer/layer.js"></script>
    <script type="text/javascript" src="js/common.js"></script>
    <script src="laydate/laydate.js"></script>
    <script src="js/Vague.js"></script>
  
    <script type="text/javascript">
        $(function() {

            //查询
            $('#searchpay').click(function(){

                s_danwei           = $('input[name=danwei]').val();
                s_shengyuan             = $('input[name=shengyuan]').val();
                
                
                location.href='pay_list.php?danwei='+s_danwei+'&shengyuan='+s_shengyuan;
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
    <?php include('data_menu.inc.php');?>
        <div id="maincontent">
            <div id="position">当前位置：<a href="pay_list.php">数据管理</a> > 内容设置</div>
            <div id="handlelist">
                <?php
                //初始化
                $totalcount= Table_pay::search(0, 0,  $s_shengyuan , $s_danwei,  1);
                $shownum   = 10;
                $pagecount = ceil($totalcount / $shownum);
                $page      = getPage($pagecount);//点击页码之后在这函数里面获取页码
                $rows      = Table_pay::search($page, $shownum,$s_shengyuan , $s_danwei );
                ?>
                
                 <input name="shengyuan" type="text" placeholder="请输入生源地标识"  class="text-input input-length-10" id="begin_time" value="<?php echo $s_shengyuan;?>" style="width:15%;height:25px;"/>

                  <input name="danwei" type="text" placeholder="请输入单位标识" class="text-input input-length-10" id="danwei" value="<?php echo $s_danwei;?>" style="width:15%;height:25px;"/>

                <input style="margin-left:10px" class="btn-handle" id="searchpay" value="查询" type="button">

                
                    <div>

               <!--  <span class="table_info"><input type="button" class="btn-handle" id="downloadproduct" value="下载商品信息"/></span> -->
              <!--  <span class="table_info"><input type="button" class="btn-handle" id="addwater_level_csv" value="添 加"/></span> -->
                <div>
                </div>
            </div>
            <br>
            <div class="tablelist" >
            <table>
                <tr>
                    <th>用户微信标识</th>  
                    <th>交易金额</th>
                    <th>生源地标识</th>
                    <th>单位标识</th>
                    <th>交易时间</th>
                    
                </tr>
                <?php

                $i=1;
                //  var_dump($rows);
                if(!empty($rows)){//如果列表不为空
                    foreach($rows as $row){
                       
                        $createtime     = date('Y-m-d H:m', $row['createtime']);
        
                        echo '<tr>          
                        
                                            <td class="center">'.$row['openid'].'</td>
                                            <td class="center">'.$row['money'].'</td>
                                            <td class="center">'.$row['shengyuan'].'</td>
                                            <td class="center">'.$row['danwei'].'</td>
                                            <td class="center">'.$createtime.'</td> 
                                                        
                                            
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
