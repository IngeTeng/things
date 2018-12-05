<?php

/**
 * table_news.class.php 新闻类
 *
 * @version       $Id$ v0.01
 * @createtime    2016/4/16
 * @updatetime    
 * @author        jt
 * @copyright     Neptune工作室
 */

class Table_news extends Table{
    
    /**
     * Table_news::struct()  数组转换
     * 
     * @param array $data
     * 
     * @return $r
     */
    static protected function struct($data){
        $r = array();
     
        $r['id']                    = $data['news_id'];
        $r['pic']                   = $data['news_pic'];//新闻图片
        $r['title']                 = $data['news_title'];//新闻标题
        $r['desc']                  = $data['news_desc'];//图文详情
        $r['admin']                 = $data['news_admin'];//新闻添加者
        $r['createtime']            = $data['news_createtime'];//添加时间
        return $r;
    }

    /**
     * Table_news::getInfoById()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        global $mypdo;
        
        $id = $mypdo->sql_check_input(array('number', $id));
        
        $sql = "select * from ".$mypdo->prefix."news where news_id = $id limit 1";
        
        $rs = $mypdo->sqlQuery($sql);
        if($rs){
            $r = array();
            foreach($rs as $key => $val){
                $r[$key] = self::struct($val);
            }
            return $r[0];
        }else{
            return 0;
        }
    }

    
    /**
     * Table_news::add() 添加新闻
     * 
     * @param array $Attr
     * $Attr数组键：weixin_openid, name, hospital, section, position, desc, phone ,createtime
     * 
     * @return
     */
    static public function add($Attr){ 
        global $mypdo;
        

        $createtime             = time();
        $title                  = $Attr['title'];
        $desc                   = $Attr['desc'];
        $pic                    = $Attr['pic'];
        $admin                  = $Attr['admin'];

        $param = array (
            'news_title'             => array('string', $title),
            'news_pic'               => array('string', $pic),
            'news_admin'             => array('string', $admin),
            'news_desc'              => array('string', $desc),
            'news_createtime'        => array('number', $createtime)
            
        );
        //var_dump($param);
        return $mypdo->sqlinsert($mypdo->prefix.'news', $param); 
    }

    
    /**
     * Table_news::edit() 修改新闻信息
     * 
     * @param int   $id
     * @param array $Attr
     * $Attr数组键：weixin_openid, name, hospital, section, position, desc, phone, createtime
     * 
     * @return
     */
    static public function edit($id, $Attr){ 
        global $mypdo;

        $title                  = $Attr['title'];
        $desc                   = $Attr['desc'];
        $pic                    = $Attr['pic'];
    

       $param = array (
           'news_title'             => array('string', $title),
            'news_pic'               => array('string', $pic),
            'news_desc'              => array('string', $desc)

            );
        $where = array(
            'news_id'                => array('number', $id)
        );
            
        return $mypdo->sqlupdate($mypdo->prefix.'news', $param, $where); 
    }



    /**
     * Table_news::del() 删除医生信息
     * 
     * @param mixed $id
     * @return
     */
    static public function del($id){
        global $mypdo;
        
        $where = array(
            'news_id' => array('number', $id)
        );

        return $mypdo->sqldelete($mypdo->prefix.'news', $where);
    }

    

    
    /**
     * Table_news::getList()    医生列表
     * 
     * @param int $page         当前页
     * @param int $pagesize     每页数量
     * @return
     */
    static public function getList($page = 1, $pagesize = 10,$count=0){
        global $mypdo;
        
        $page     = $mypdo->sql_check_input(array('number', $page));
        $pagesize = $mypdo->sql_check_input(array('number', $pagesize));
        $startrow = ($page - 1) * $pagesize;
        
        $sql = "select * from ".$mypdo->prefix."news where 1=1 ";
        /*if(!empty($sort)) {
            $sql .= " and news_sort = $sort ";
        }
        if(!empty($status)) {
            $sql .= " and news_status = $status ";
        }*/
        $sql .= " order by news_id desc limit $startrow, $pagesize";
               
        $rs = $mypdo->sqlQuery($sql);
        if($rs){
            $r = array();
            foreach($rs as $key => $val){
                $r[$key] = self::struct($val);
            }
            return $r;
        }else{
            return 0;
        }
    }

    /**
     * Table_news::getAllList()    医生列表
     * 
     * @param int $page         当前页
     * @param int $pagesize     每页数量
     * @return
     */
    static public function getAllList(){
        global $mypdo;
        
        
        $sql = "select * from ".$mypdo->prefix."news where 1=1 ";
        /*if(!empty($sort)) {
            $sql .= " and news_sort = $sort ";
        }
        if(!empty($status)) {
            $sql .= " and news_status = $status ";
        }*/
        $sql .= " order by news_id desc";
               
        $rs = $mypdo->sqlQuery($sql);
        if($rs){
            $r = array();
            foreach($rs as $key => $val){
                $r[$key] = self::struct($val);
            }
            return $r;
        }else{
            return 0;
        }
    }
    
    
    /**
      * Table_news::getCount()  医生数量统计
      * 
      * @return
      */
     static public function getCount(){
        global $mypdo;
        
        $sql = "select count(*) as ct from ".$mypdo->prefix."news where 1=1";

        $r = $mypdo->sqlQuery($sql);
        if($r){
            return $r[0]['ct'];
        }else{
            return 0;
        }
    }
    
    
    /**
     * Table_news::search() 商品搜索
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */

    static public function search($page = 1, $pagesize = 10 ,$title='',$count = 0){
        global $mypdo, $mylog;
        
        $page     = $mypdo->sql_check_input(array('number', $page));
        $pagesize = $mypdo->sql_check_input(array('number', $pagesize));


        $title    = "%$title%";
        $title    = $mypdo->sql_check_input(array('string', $title));
        
        $startrow = ($page - 1) * $pagesize;
        
        $sql = "select * from ".$mypdo->prefix."news where 1=1 ";
       
        $sql .= " and news_title like $title ";
        if($count){
            
            $r = $mypdo->sqlQuery($sql);
            return count($r);

        }else{
            $sql .= " order by news_id desc limit $startrow, $pagesize";
            //var_dump($sql);
            $rs = $mypdo->sqlQuery($sql);
            if($rs){
                $r = array();
                foreach($rs as $key => $val){
                    $r[$key] = self::struct($val);
                }
                return $r;
            }else{
                return 0;
            } 
            
        }
        
        
    }

    




}
?>