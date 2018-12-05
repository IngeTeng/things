<?php
    require('../../conn.php');
    require('../../config.inc.php');

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>青海大学校园导航</title>
    <meta name="description" content="Dragonfruit is one of the free HTML5 Templates from templatemo. It is a parallax layout with jQuery slider, events, and timeline." />
    <meta name="author" content="templatemo">
    <!-- Favicon-->
    <link rel="shortcut icon" href="./favicon.png" />		
    <!-- Font Awesome -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Camera -->
    <link href="css/camera.css" rel="stylesheet">
    <!-- Template  -->
    <link href="css/templatemo_style.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
<body>
<a href="../../qh.php">
<div class="banner" id="templatemo_banner_slide">
    <ul >
        
        <li class="templatemo_banner_slide_01" >
        
            <div class="slide_caption">
            
                <h1>Department of Computer Science, Qinghai University</h1>
                <p>Campus navigation can help new students quickly understand the situation of the school</p>
                 
            </div>
         
        </li>
       
       
    </ul>
</div>
</a>
<div id="templatemo_mobile_menu">
        <ul class="nav nav-pills nav-stacked">
            <li><a href="#templatemo_banner_slide"><i class="glyphicon glyphicon-home"></i> &nbsp; 首页</a></li>
           <!--  <li><a href="#templatemo_about"><i class="glyphicon glyphicon-briefcase"></i> &nbsp; 走进浪格</a></li> -->
            <li><a href="#templatemo_events"><i class="glyphicon glyphicon-bullhorn"></i> &nbsp;党团建设</a></li>
            <li><a href="#templatemo_timeline"><i class="glyphicon glyphicon-calendar"></i> &nbsp; 新闻资讯</a></li>
            <li><a href="#templatemo_contact"><i class="glyphicon glyphicon-phone-alt"></i> &nbsp; 联系我们</a></li>
        </ul>
</div>
<div class="container_wapper">
    <div id="templatemo_banner_menu">
        <div class="container-fluid">
            <div class="col-xs-4 templatemo_logo">
            	<a rel="nofollow" href="#">
                <a href="../../qh.php">
                	<img src="images/logo2.png" id="logo_img" alt="dragonfruit free html5 template" />
                </a>
                	
                </a>
            </div>
            <div class="col-sm-8 hidden-xs">
                <ul class="nav nav-justified">
                    <li><a href="#templatemo_banner_slide">首页</a></li>
                   <!--  <li><a href="#templatemo_about">走进浪格</a></li> -->
                    <li><a href="#templatemo_events">党团建设</a></li>
                    <li><a href="#templatemo_timeline">新闻资讯</a></li>
                    <li><a href="#templatemo_contact">联系我们</a></li>
                </ul>
            </div>
            <div class="col-xs-8 visible-xs">
                <a href="#" id="mobile_menu"><span class="glyphicon glyphicon-th-list"></span></a>
            </div>
        </div>
    </div>
</div>

<div id="templatemo_events" class="container_wapper">
    <div class="container-fluid">
        <h1>党团建设</h1>
        <?php 

            $news = table_news::getList(1,4);

            foreach ($news as $new) {
                # code...
            
            $pic = $HTTP_PATH.$new['pic'];
            $createtime = date('Y-m-d H:m' , $new['createtime']);
            echo '<a href="news_detail.php?id='.$new['id'].'">
            <div class="col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-0">
            <div class="event_box_wap event_animate_left">
                <div class="event_box_img">
                    <img src="'.$pic.'" class="img-responsive" alt="Web Design Trends" />
                </div>
                <div class="event_box_caption">
                    <h1>'.$new['title'].'</h1>
                    <p><span class="glyphicon glyphicon-map-marker"></span> '.$new['admin'].' &nbsp;&nbsp; <span class="glyphicon glyphicon-time"></span> '.$createtime.'</p>
                    <p></p>
                </div>
            </div>
        </div>
        </a>
        ';

        }
        ?>

        
        <!-- <div class="col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-0">
            <div class="event_box_wap event_animate_right">
                <div class="event_box_img">
                    <img src="images/templatemo_event_02.jpg" class="img-responsive" alt="Free Bootstrap Seminar" />
                </div>
                <div class="event_box_caption">
                    <h1>57504-MNG Green Mosaic</h1>
                    <p><span class="glyphicon glyphicon-map-marker"></span> Digital Hall, Yangon, Myanmar &nbsp;&nbsp; <span class="glyphicon glyphicon-time"></span> 10:30 AM to 3:30 PM </p>
                    <p>Vestibulum dapibus dolor porttitor urna pretium euismod. Aliquam lobortis enim at lacinia mollis. Curabitur eget sem eros. Duis pulvinar rhoncus lectus, ac hendrerit enim pharetra et.</p>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-0">
            <div class="event_box_wap event_animate_left">
                <div class="event_box_img">
                    <img src="images/templatemo_event_03.jpg" class="img-responsive" alt="" />
                </div>
                <div class="event_box_caption">
                    <h1>57504-MNB Blue Mosaic</h1>
                    <p><span class="glyphicon glyphicon-map-marker"></span> Old Town Center, Mandalay, Myanmar &nbsp;&nbsp; <span class="glyphicon glyphicon-time"></span> 3:30 PM to 6:30 PM </p>
                    <p>Etiam ac ante gravida, pellentesque odio non, facilisis dui. Suspendisse vestibulum justo quis sapien sodales, in pellentesque erat congue.</p>
                </div>
            </div>
        </div>
        <div class="col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-0">
            <div class="event_box_wap event_animate_right">
                <div class="event_box_img">
                    <img src="images/templatemo_event_04.jpg" class="img-responsive" alt="" />
                </div>
                <div class="event_box_caption">
                    <h1>53594-VC Carribean Green</h1>
                    <p><span class="glyphicon glyphicon-map-marker"></span> New Hat, Lashio, Myanmar &nbsp;&nbsp; <span class="glyphicon glyphicon-time"></span> 2:15 PM to 5:15 PM </p>
                    <p>Interdum et malesuada fames ac ante ipsum primis in faucibus. Nunc rutrum urna eget augue placerat sodales. Mauris ut dapibus nisi, eget fringilla lectus.</p>
                </div>
            </div>
        </div> -->

        <div class="col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-0">
            <a href = "news_more.php"><p>更多</p></a>
        </div>



    </div>
</div>
<div id="templatemo_timeline" class="container_wapper">
    <h1>资讯公告</h1>
    <div class="container-fluid">

        <?php 

            $notices = table_notice::getList(1,4);
            foreach ($notices as $notice ) {
                # code...
                 $createtime = date('Y-m-d H:m' , $notice['createtime']);
                 $abstract = strip_tags($notice['abstract']);
                 if(strlen($abstract)>100){
                            $abstract = mb_substr($abstract , 0,100,'utf-8').'...';
                        }
        echo '
        <a href="notice_detail.php?id='.$notice['id'].'">
        <div class="time_line_wap">
            <div class="time_line_caption">'.$createtime.'</div>
            <div class="time_line_paragraph">
                <h1>'.$notice['title'].'</h1>
                <p>
                       <span class="glyphicon glyphicon-user"></span> <a href="#">'.$notice['admin'].'</a> &nbsp;&nbsp;
                    
                </p>
                <p>'.$notice['abstract'].'</p>
            </div>
        </div>
        </a>
        ';
            }


        ?>
        
         <div class="time_line_wap">
             <a href = "notice_more.php"><p>更多</p></a>
        </div>
        
    </div>
</div>
<div id="templatemo_contact" class="container_wapper">
    <div class="container-fluid">
        <h1>联系我们</h1>
       <div class="col-md-4">
            <h2>青海大学计算机技术与应用系</h2>
            <!-- <p>友浪为全国各类泳池提供最优质高效的技术服务</p> -->
            <br>
            <p><strong>地址:</strong> 青海省西宁市宁大路251号(810016)<br />
            <strong>联系电话:</strong> 0971-5315609 <br />
            <strong>联系邮箱:</strong> qhujsjx@163.com<br />
          </p>
            <!-- <ul class="list-inline social-link">
                <li>
                    <a href="#"><i class="fa fa-linkedin"></i></a> 
                </li>
                <li>
                    <a href="#"><i class="fa fa-twitter"></i></a> 
                </li>
                <li>
                    <a href="#"><i class="fa fa-facebook"></i></a> 
                </li>
                
                <li>
                    <a href="#"><i class="fa fa-github"></i></a> 
                </li>
                       </ul> -->
        </div>
        <form action="../../admin/suggest_do.php?act=add" method="post" class="col-md-8">
            <div class="row">
               <!--  <div class="col-md-12">
               <h2>免费报价申请</h2>
               </div> -->
                <div class="col-md-6">
                    <p>您的姓名</p>
                    <input type="text" name="name" id="name" placeholder="请输入您的姓名" />
                </div>
                <div class="col-md-6">
                    <p>联系电话</p>
                    <input type="text" name="phone" id="phone" placeholder="请输入您的电话" />
                </div>
                <!--  <div class="col-md-6">
                   <p>项目地址</p>
                   <input type="text" name="name" id="name" placeholder="请输入您的项目地址" />
                                </div>
                                <div class="col-md-6">
                   <p>项目面积(m2)</p>
                   <input type="text" name="email" id="email" placeholder="请输入项目面积" />
                                </div>
                                -->
                <div class="col-md-12">
                    <p>咨询内容</p>
                    <textarea name="desc" id="desc"  placeholder="Write your message here..."></textarea>
                </div>
                <div class="col-xs-6 col-sm-3 col-md-offset-5">
                    <button type="submit">留言</button>
                </div>
               
            </div>
        </form>
    </div>
</div>
<div id="templatemo_footer">
    <div>
        <p>Copyright &copy; 青海大学 | 计算机系 </p>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.singlePageNav.min.js"></script>
<script src="js/unslider.min.js"></script>

<script src="js/templatemo_script.js"></script>
</body>
</html>