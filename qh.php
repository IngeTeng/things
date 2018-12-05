<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">
    <title>青海大学校园地图</title>
    <link rel="stylesheet" href="http://cache.amap.com/lbs/static/main1119.css"/>
    <style type="text/css">
        .info-title {
            color: white;
            font-size: 14px;
            background-color:blue;
            line-height: 26px;
            padding: 0px 0 0 6px;
            font-weight: lighter;
            letter-spacing: 1px
        }
        .info-content {
            font: 12px Helvetica, 'Hiragino Sans GB', 'Microsoft Yahei', '微软雅黑', Arial;
            padding: 4px;
            color: #666666;
            line-height: 23px;
        }
        .info-content img {
            float: left;
            margin: 3px;
        }
    </style>
    <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=7f8a305ca28c52b6e412e8fd365e438e&plugin=AMap.AdvancedInfoWindow"></script>
    <script type="text/javascript" src="http://cache.amap.com/lbs/static/addToolbar.js"></script>
</head>
<body>
<div id="container"></div>
<div class="button-group">
    <input type="button" class="button" value="在附近搜索" onclick="infowindow1.open(map,lnglat)"/>
    <input type="button" class="button" value="在附近找" onclick="infowindow2.open(map,lnglat)"/>
    <input type="button" class="button" value="路线规划" onclick="infowindow3.open(map,lnglat)"/>
</div>
<script type="text/javascript">
    var lnglat = [101.749418,36.72543];
    
    var map = new AMap.Map('container', {
        resizeEnable: true,
        center: lnglat,
        zoom: 17
    });
    var marker = new AMap.Marker({
        position: lnglat
    });
    marker.setMap(map);

    var content='<div class="info-title">青海大学校园地图</div><div class="info-content">' +
           
           
            '<a target="_blank" href = "http://mobile.amap.com/"></a></div>';
    var  infowindow1 = new AMap.AdvancedInfoWindow({
        content: content,
        offset: new AMap.Pixel(0, -30)
    });
    var  infowindow2 = new AMap.AdvancedInfoWindow({
        content: content,
        asOrigin: false,
        asDestination: false,
        offset: new AMap.Pixel(0, -30)
    });
    var  infowindow3 = new AMap.AdvancedInfoWindow({
        content: content,
        placeSearch: false,
        asDestination: false,
        offset: new AMap.Pixel(0, -30)
    });
</script>
</body>
</html>