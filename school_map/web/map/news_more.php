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
    <ul>
        <li class="templatemo_banner_slide_01">
            <div class="slide_caption">
                <h1></h1>
                <p></p>
            </div>
        </li>
        <!-- <li class="templatemo_banner_slide_02">
            <div class="slide_caption">
                <h1>FLAGPOOL is a brand of Flag S.p.A.</h1>
                <p>The Italian PVC LINER for fashion swimming pool plain colours</p>
            </div>
        </li>
        <li class="templatemo_banner_slide_03">
            <div class="slide_caption">
                <h1>Colors</h1>
                <p>All the available colours for FLAGPOOL NG11 the waterproofing liner for your swimming pool</p>
            </div>
        </li>
        <li class="templatemo_banner_slide_04">
            <div class="slide_caption">
                <h1>FLAGPOOL is a brand of Flag S.p.A.</h1>
                <p>The Italian PVC LINER for fashion swimming pool plain colours</p>
            </div>
        </li> -->
    </ul>
</div>
</a>

<div id="templatemo_mobile_menu">
        <ul class="nav nav-pills nav-stacked">
            <!-- <li><a href="index.php"><i class="glyphicon glyphicon-home"></i> &nbsp; 首页</a></li> -->
        </ul>
</div>
<div class="container_wapper">
    <div id="templatemo_banner_menu">
        <div class="container-fluid">
            <div class="col-xs-4 templatemo_logo">
                <a rel="nofollow" href="../../qh.php">
                    <img src="images/logo2.png" id="logo_img" alt="dragonfruit free html5 template" />

                </a>
            </div>
            <div class="col-sm-8 hidden-xs">
                <!-- <ul class="nav nav-justified">
                    <li><a href="index.php">首页</a></li>
                    <li><a href="about.php">走进浪格</a></li>
                    <li><a href="pro.php">产品介绍</a></li>
                    <li><a href="jishu.php">技术参数</a></li>
                    <li><a href="index.php">联系我们</a></li>
                    <li><a href="#templatemo_Italiano">Italiano</a></li>
                    <li><a href="#templatemo_English">English</a></li>
                </ul> -->
            </div>
            <div class="col-xs-8 visible-xs">
                <a href="#" id="mobile_menu"><span class="glyphicon glyphicon-th-list"></span></a>
            </div>
        </div>
    </div>
</div>
 <h4><a href="index.php">返回首页</a> > 计科风采</h4>


<div id="templatemo_events" class="container_wapper">
    <div class="container-fluid">
        <h1>计科风采</h1>
        <?php 

            $news = table_news::getAllList();

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