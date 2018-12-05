<?php
/**
 * 公告处理  notice_do.php
 *
 * @version       v0.01
 * @create time   2016/11/14
 * @update time
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

require_once('admin_init.php');
require_once('admincheck.php');


$POWERID = '7001';//权限
Admin::checkAuth($POWERID, $ADMINAUTH);


$act = safeCheck($_GET['act'], 0);

function set_date($month , $day){
    if($month=='一月'){
        $month_num = '01';
    }
    if($month=='二月'){
        $month_num = '02';
    }
    if($month=='三月'){
        $month_num = '03';
    }
    if($month=='四月'){
        $month_num = '04';
    }
    if($month=='五月'){
        $month_num = '05';
    }
    if($month=='六月'){
        $month_num = '06';
    }
    if($month=='七月'){
        $month_num = '07';
    }
    if($month=='八月'){
        $month_num = '08';
    }
    if($month=='九月'){
        $month_num = '09';
    }
    if($month=='十月'){
        $month_num = '10';
    }
    if($month=='十一月'){
        $month_num = '11';
    }
    if($month=='十二月'){
        $month_num = '12';
    }
    $date = '2017'.'-'.$month_num.'-'.$day;
    $datestamp = strtotime($date);
    //var_dump($date);exit;
    return $datestamp;
}

function spider($url){
        $curlobj = curl_init();  
        curl_setopt($curlobj,CURLOPT_URL,$url);  
        curl_setopt($curlobj,CURLOPT_RETURNTRANSFER,true); //请求结果不直接打印  
        $output = curl_exec($curlobj);  
        curl_close($curlobj);  
        return $output;
}



function data_set(){
        /*$curlobj = curl_init();  
        curl_setopt($curlobj,CURLOPT_URL,"http://cs.qhu.edu.cn");  
        curl_setopt($curlobj,CURLOPT_RETURNTRANSFER,true); //请求结果不直接打印  
        $output = curl_exec($curlobj);  
        curl_close($curlobj);  */
        $output = spider("http://cs.qhu.edu.cn");
        //var_dump($output);exit;
        //begin 标题
        //将请求结果写入文件  
        //$myfile = fopen("curl_html.txt", "w") or die("Unable to open file!");  

        $preg1 =  '/<ul class="notice">(.*?)<\/ul>/is';
        preg_match_all( $preg1, $output, $res ,PREG_SET_ORDER );
        //var_dump($res[0][1]);
        //
        $preg2 = '/<li>(.*?)<\/li>/is';
        preg_match_all( $preg2, $res[0][1], $ress ,PREG_SET_ORDER );
        //var_dump($ress);
        $preg3 = '/<div class="mes">(.*?)<\/div>/is';
        preg_match_all( $preg3, $ress[0][1], $resss ,PREG_SET_ORDER );

        $preg4 = '/<a href="[^"]*"[^>]*>(.*)<\/a>/';
        preg_match_all( $preg4, $resss[0][1], $ressss ,PREG_SET_ORDER );
        $title = $ressss[0][1];
        //var_dump($title);exit;
        //end 
        //begin月份
        $preg3_month = '/<div class="date">(.*?)<\/div>/is';
        preg_match_all( $preg3_month, $ress[0][1], $resss_month ,PREG_SET_ORDER );
        $preg4_month = '/<p>(.*?)<\/p>/is';
        preg_match_all( $preg4_month, $resss_month[0][1], $ressss_month ,PREG_SET_ORDER );
        //var_dump($ressss_month[0][1]);
        $month = $ressss_month[0][1];
        $month=trim($month);
        //var_dump($month);exit;
        //end
        //begin日期
        //
        
        $preg4_day = '/<span>(.*?)<\/span>/is';
        preg_match_all( $preg4_day, $resss_month[0][1], $ressss_day ,PREG_SET_ORDER );
        //var_dump($ressss_day[0][1]);exit;
        $day = $ressss_day[0][1];
        //end
        //begin超链接
        $preg5_link = '/<a .*?href="(.*?)".*?>/is';
        preg_match_all($preg5_link, $res[0][1], $ress_links, PREG_SET_ORDER);
        $link = $ress_links[0][1];
        //var_dump($link);exit; 
        $link = 'http://cs.qhu.edu.cn/'.$link;
        //end
        //内容详情页
        $detail = spider($link);
        $preg_detail1 = '/<div class="article" style="min-height:300px;">(.*?)<\/div>/is';
        preg_match_all( $preg_detail1, $detail, $res_detail ,PREG_SET_ORDER );

        $preg_detail2 = '/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i';
        preg_match_all( $preg_detail2, $res_detail[0][1], $ress_detail ,PREG_SET_ORDER );
        $content = '';
        for($i=0 ; $i<count($ress_detail); $i++){
            $ext = substr($ress_detail[$i][1],2);
            //var_dump($ext);exit;
            $img = 'http://cs.qhu.edu.cn'.$ext;
            $content = $content.'<img src="'.$img.'" style="height:1119px; width:792px"></img><br>';

        } 
        //echo $content;exit;
        //var_dump($arr);exit;
        $datestamp = set_date($month , $day);
        //var_dump($datestamp);exit;
        $noticeAttr['title']  = $title;
        $noticeAttr['abstract']  = $title;
        //var_dump($newsAttr);exit;
        $noticeAttr['desc']  = $content;
        $noticeAttr['createtime']  = $datestamp;
        $noticeAttr['admin'] = '系统更新';
        //var_dump($noticeAttr);exit;
        return $noticeAttr;

    }


switch($act){
    case 'add'://添加

        $title            = safeCheck($_POST['title'],0);
        $abstract         = $_POST['abstract'];
        $desc             = $_POST['desc'];
        $admin            = $ADMIN->getName();
        //构造需要传递的数组参数
        $noticeAttr = array(

            'title'              => $title,
            'desc'               => $desc,
            'abstract'           => $abstract,
            'admin'              => $admin
        
        );

        try {
            $rs = Notice::add($noticeAttr);
            echo $rs;
        }catch (MyException $e){

            echo $e->jsonMsg();
        }

        break;

    case 'edit'://编辑
        $id               = safeCheck($_POST['id']);
        $title            = safeCheck($_POST['title'],0);
        $desc             = $_POST['desc'];
        $abstract         = $_POST['abstract'];

        //构造需要传递的数组参数
        $noticeAttr = array(

            'title'              => $title,
            'desc'               => $desc,
            'abstract'           => $abstract
 

        );

        try {
            $rs = Notice::edit($id, $noticeAttr);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;


    case 'del'://删除
        $id = safeCheck($_POST['id']);

        try {
            $rs = Notice::del($id);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;

    case 'update'://更新操作
        //$id = safeCheck($_POST['id']);
        $noticeAttr = data_set();
        //var_dump($noticeAttr);exit;
        try {
            $rs = Notice::update($noticeAttr);
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }

        break;
}
?>