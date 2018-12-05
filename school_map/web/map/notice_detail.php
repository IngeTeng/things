<?php 
 require('../../conn.php');
 require('../../config.inc.php');

 $id = safeCheck($_GET['id']);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>资讯公告</title>
    <meta name="description" content="Dragonfruit is one of the free HTML5 Templates from templatemo. It is a parallax layout with jQuery slider, events, and timeline." />
    <meta name="author" content="templatemo">
    <!-- Favicon-->
    <link rel="shortcut icon" href="favicon.png" />
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

    <script type="text/javascript">

            $(".blog_post_view_img").addClass("carousel-inner img-responsive img-rounded");


    </script>>
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
           <!--  <li><a href="index.php"><i class="glyphicon glyphicon-home"></i> &nbsp; 首页</a></li> -->
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
<div class="copyrights">Collect from </div>

<div id="templatemo_about" class="container_wapper">
  <div class="row_1">
                <div class="container">
                    <div class="row">
                        <article class="span12">
                            <div class="blog_post_view">
                                <h4><a href="index.php">返回首页</a> > 资讯公告</h4>
                                <div style="height:10px ;"></div>

                                <?php 

                                    $notice = Notice::getInfoById($id);
                                    

                                    echo '
                                
                                <h2><p class="testim">'.$news['title'].'</p></h2>
                                <p>'.$notice['desc'].'</p> 
                                <br/><br/>';
                                ?>
                                

                               <!--  <div class="post_info_wrapper">
                                   <div class="row">
                                       <div class="span6 post_info_tags">
                                           <h6>提示小信息: <a href="#">文本小连接</a>, <a href="#">文本连接</a></h6>
                                       </div>
                                       <div class="span6 post_info_comments">
                                           <h6><a href="#"><span>评论次数</span> (0)</a></h6>
                                       </div>
                                   </div>
                               </div> -->
                            </div>
                        </article>
                    </div>
                </div>
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