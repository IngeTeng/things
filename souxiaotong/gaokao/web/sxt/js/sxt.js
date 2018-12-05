//province;
//proSchool;
//学校名称 激活状态
$("#schoolName").focus(function(){
    var top = $(this).position().top+$(this).height()+2;
    var left = $(this).position().left;
    $("div[class='provinceSchool']").css({top:top,left:left});
    $("div[class='provinceSchool']").show();
});
//初始化省下拉框
var provinceArray = "";
var provicneSelectStr = "";
for(var i=0,len=province.length;i<len;i++){
    provinceArray = province[i];
    provicneSelectStr = provicneSelectStr + "<option value='"+provinceArray[0]+"'>"+provinceArray[1]+"</option>"
}
$("div[class='proSelect'] select").html(provicneSelectStr);


//初始化学校列表
var selectPro = $("div[class='proSelect'] select").val();
var schoolUlStr = "";
var schoolListStr = new String(proSchool[selectPro]);
var schoolListArray = schoolListStr.split(",");

schoolListArray.sort();

var tempSchoolName = "";
for(var i=0,len=schoolListArray.length;i<len;i++){
    tempSchoolName = schoolListArray[i];
    // if(tempSchoolName.length>13){
    //   schoolUlStr = schoolUlStr + "<li class='DoubleWidthLi' title="+schoolListArray[i]+">"+schoolListArray[i]+"</li>"
    // }else {
    //   schoolUlStr = schoolUlStr + "<li>"+schoolListArray[i]+"</li>"
    // }
    schoolUlStr = schoolUlStr + "<option value='"+schoolListArray[i]+"'>"+schoolListArray[i]+"</option>"

}
$("div[class='schoolList'] select").html(schoolUlStr);

//省切换事件
$("div[class='proSelect'] select").change(function(){
    if("99"!=$(this).val()){
        $("div[class='proSelect'] span").show();
        $("div[class='proSelect'] input").hide();
        schoolUlStr = "";
        schoolListStr = new String(proSchool[$(this).val()]);
        schoolListArray = schoolListStr.split(",");
        for(var i=0,len=schoolListArray.length;i<len;i++){
            tempSchoolName = schoolListArray[i];
            // if(tempSchoolName.length>13){
            //   schoolUlStr = schoolUlStr + "<li class='DoubleWidthLi' title="+schoolListArray[i]+">"+schoolListArray[i]+"</li>"
            // }else {
            //   schoolUlStr = schoolUlStr + "<li>"+schoolListArray[i]+"</li>"
            // }
            schoolUlStr = schoolUlStr + "<option value='"+schoolListArray[i]+"'>"+schoolListArray[i]+"</option>"

        }
        $("div[class='schoolList'] select").html(schoolUlStr);
    }
    // else {
    //   $("div[class='schoolList'] ul").html("<span class='entertext'>请在输入框内手动输入学校！</span>");
    //   $("div[class='proSelect'] span").hide();
    //   $("div[class='proSelect'] input").show();
    // }
});
//学校列表mouseover事件
//            $("div[class='schoolList'] ul li").live("mouseover",function(){
//                $(this).css("background-color","#72B9D7");
//            });
//学校列表mouseout事件
//            $("div[class='schoolList'] ul li").live("mouseout",function(){
//                $(this).css("background-color","");
//            });
//学校列表点击事件
//            $("div[class='schoolList'] ul li").live("click",function(){
//                $("#schoolName").val($(this).html());
//                $("div[class='provinceSchool']").hide();
//            });
//按钮点击事件
//            $("div[class='button'] button").live("click",function(){
//                var flag = $(this).attr("flag");
//                if("0"==flag){
//                    $("div[class='provinceSchool']").hide();
//                }else if("1"==flag){
//                    var selectPro = $("div[class='proSelect'] select").val();
//                    if("99"==selectPro){
//                        $("#schoolName").val($("div[class='proSelect'] input").val());
//                    }
//                    $("div[class='provinceSchool']").hide();
//                }
//            });

//针对苹果手机和安卓机的兼容
    $(document).on("click touchstart", "#btnsubmit", function () {
        console.log("haha");
        var _score = $("#score").val();
        var _schoolPro = $("#schoolPro option:selected").text();
        var _kelei = $("#kelei option:selected").text();
        var _school = $("#school").val();
        $.ajax({
            type:"post",
            url:"./yuce.html",
            data:{
                score: _score,
                kelei: _kelei,
                schoolPro: _schoolPro,
                school: _school
            },
            dataType:"json",
            success:function(data){
                var code = data.code;
                var msg = data.msg;
                switch (code) {
                    case 1:
                        layer.alert(msg, {icon: 6, shade: false}, function (index) {
                            parent.location.reload();
                        });
                        break;
                    default:
                        layer.alert(msg, {icon: 5});
                }
            }
        })

    });


