<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>高考搜校通</title>
    <meta name="description" content="overview & stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="css/index.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link href="css/bootstrap-responsive.css" rel="stylesheet" />
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/weui.min.css" rel="stylesheet">
    <link href="css/input.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/font-awesome.min.css" />
    <link href="css/font-awesome.css" rel="stylesheet" />
    <style type="text/css">
        *{margin:0;padding:0;outline:none;}
        body{padding:20px;font:12px "微软雅黑";background:#FFF;}
        ul li{list-style:none;}
        #schoolName{width:200px;height:30px;line-height:30px;border:1px solid #ccc;padding:0 8px;cursor:pointer;font-size:12px;}
        .provinceSchool{display:none;position:absolute;width:580px;height:auto;border:1px solid #72B9D7;}
        .provinceSchool .title{width:100%;height:30px;background:#72B9D7;cursor:move;}
        .provinceSchool .title span{margin-left:10px;font-weight:600;color:#FFF;line-height:30px;}
        .provinceSchool .proSelect{width:550px;text-align:center;padding:15px 0;}
        .provinceSchool .proSelect select{width:190px;}
        .provinceSchool .proSelect span{padding-left:10px;}
        .provinceSchool .proSelect input{display:none;}
        .provinceSchool .schoolList{width:550px;height:180px;padding:10px 0;overflow-y:auto;border:1px solid #ddd;}
        .provinceSchool .schoolList ul{width:510px;clear:both;}
        .provinceSchool .schoolList ul span.entertext{display:block;height:180px;font:normal 16px/180px 'microsoft yahei';color:#999;}
        .provinceSchool .schoolList ul li{float:left;text-align:center;width:160px;margin:5px;height:25px;line-height:25px;cursor:pointer;background:#fafafa;border-radius:3px;}
        .provinceSchool .schoolList ul li.DoubleWidthLi{overflow:hidden;}
        .provinceSchool .schoolList ul li:hover{background:#72B9D7;color:#fff;}
        .provinceSchool .button{width:100%;height:40px;margin-top:8px;}
        .provinceSchool .button button{float:right;height:30px;margin-right:15px;padding:2px 15px;background:#72B9D7;border:none;color:#FFF;font-weight:600;cursor:pointer;border-radius:3px;}
        .provinceSchool .button button:hover{background:#2e90bd;}
    </style>


</head>
<body>
<div class="sxttitle">搜校通</div>
<div class="sxttip">全国首款根据高考分数匹配大学及专业智能系统</div>
<div class="sxttip">你的考分能上啥大学、啥专业，搜校通，扫一扫</div>
<div  style="margin-top: 40px" align="center" >

    <form class="form-inline" role="form" >
        <div class="form-group" >
            <label class="form-label">考生分数</label>&nbsp;&nbsp;&nbsp;
            <input type="number" style="width: 175px" class="form-control" name="score" id="score" value="" placeholder="请输入您的高考分数">
        </div>
    </form>


    <form class="form-inline" role="form" >
        <table>
            <tr>
                <div class="form-group">
                    <th><label class="form-label">文科/理科</label>&nbsp;&nbsp;&nbsp;</th>
                    <th>
                        <select name="kelei" style="width:185px;" id="kelei" class="form-control" value="1">
                            <option value=1>理科</option>
                            <option value=2>文科</option>
                        </select>
                    </th>
                </div>
            </tr>
        </table>
    </form>
    <form class="form-inline" role="form" >
        <table>
            <tr>
                <div class="form-group">
                    <th>
                        <label class="form-label">生源地</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th>
                        <input type="text" style="width: 175px" class="form-control" name="telnum" id="telnum" value="陕西省" ></th>
                </div>
            </tr>
        </table>
    </form>
    <form class="form-inline" role="form" >
        <div class="form-group">
            <table>
                <tr>
                    <div class="form-group">
                        <th>
                            <label class="form-label">拟报考地</label>&nbsp;&nbsp;&nbsp;</th>
                        <th>
                            <div class="proSelect" >
                                <select style="width:190px;" class="form-control" id="schoolPro"></select>
                            </div>
                        </th>
                    </div>
                </tr>
                </table>
            </div>
    </form>


    <form class="form-inline" role="form">
        <div class="form-group">
            <table>
                <tr>
                    <th>
                        <label class="form-label">拟报大学</label>&nbsp;&nbsp;&nbsp;</th>
                    <th>
                        <div class="schoolList">
                            <select style="width:190px;" class="form-control" id="school"></select>
                        </div>
                    </th>
                </tr>
            </table>
        </div>
    </form>
    <div  id = "btnsubmit" class="weui_opr_area" style="margin-top: 35px;">
        <p class="weui_btn_area">
        <div class="weui_btn weui_btn_primary yes" style="position:relative;top:10px;background-color:#00BEEE;">点击查询</div>
        </p>
    </div>
    </div>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/school.js"></script>
<script type="text/javascript" src="js/sxt.js"></script>
</body>
</html>