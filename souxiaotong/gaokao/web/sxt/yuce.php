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
    
</style>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/school.js"></script>
    <script type="text/javascript">
//        $(function() {
//            //下拉框1
//            $('#order_status1').bootstrapSelect({
//                data: [{id: 1, text: 'lzx'}, {id: 2, text: 'lsl'}],
//                //url:'',
//                downBorder: true,
//                multiple: true,//多选
//                onSelect: function (val, rec) {
//                }
//            });
//            //下拉框2
//            $('#order_status2').bootstrapSelect({
//                onSelect: function (val, rec) {
//                    console.log($('#order_status2').bootstrapSelect('getTextForVal', 'lzx2'));//根据文本获取值
//                }
//            });
//        });


    //alert(typeof schoolListArray)
    // schoolListArray.sort(function(param1, param2){
    //   return !(param1.substr(0, 1).localeCompare(param2.substr(0, 1)));
    // });
    // for (var i = 0,len=schoolListArray.length; i <len-1; i++) {
    //  for(var j=i+1;j<len;j++){
 //                      //获取第一个值和后一个值比较
 //            var cur = schoolListArray[i];

 //            if(cur.charCodeAt(0)<schoolListArray[j].charCodeAt(0)){
                
 //                      // 因为需要交换值，所以会把后一个值替换，我们要先保存下来
 //                var index = schoolListArray[j];
 //                        // 交换值
 //                schoolListArray[j] = cur;
 //                schoolListArray[i] = index;
 //            }
 //        }
    // }
   
    </script>

</head>
<body>
<div class="sxttitle">搜校通</div>
<div class="sxttip">全国首款根据高考分数匹配大学及专业智能系统</div>
<div class="sxttip">你的考分能上啥大学、啥专业，搜校通，扫一扫</div>
<div  style="margin-top: 20px" align="center" >
<div style="margin-top: 10px; font-size: 24px; color: #00BEEE" >预测结果</div>

<br>
<form class="form-inline" role="form" >
<div class="form-group" >
    <label class="form-label">考生分数:</label>&nbsp;&nbsp;
    <input type="text" style="width: 45px" class="form-control" name="score" id="score" value="666" >&nbsp;&nbsp;&nbsp;&nbsp;
    <label class="form-label">文科/理科:</label>&nbsp;&nbsp;
    <input type="text" style="width: 45px" class="form-control" name="kelei" id="kelei" value="理科" >
    <br><br>
    <label class="form-label">拟报大学:</label>&nbsp;&nbsp;
    <input type="text" style="width: 125px" class="form-control" name="school" id="school" value="西安电子科技大学" >
</div>
</form>
<table  cellspacing=0 cellpadding=2 >
    <tr>
        <th>
           <label class="form-label">2016</label>
        </th>
        <th>
        <label class="form-label">最低分</label>
        </th>
        <th>
         <label class="form-label">平均分</label>
        </th>
        <th>
         <label class="form-label">最高分</label>
        </th>
    </tr>
    <tr>
        <th>

        </th>
        <th>
            400
        </th>
        <th>
            435
        </th>
        <th>
            600
        </th>
    </tr>
    <tr>
        <th>
            专业:
        </th>
        <th>
            法律
        </th>
        <th>
            录取概率
        </th>
        <th>
            70%
        </th>
    </tr>
</table>
<br>
<a >要想看到更多, 点我哦!</a>
   
   

</body>
</html>