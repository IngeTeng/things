<?php

/**
 * table_notice.class.php 公告类
 *
 * @version       $Id$ v0.01
 * @createtime    2016/4/16
 * @updatetime    
 * @author        jt
 * @copyright     Neptune工作室
 */

class Table_notice extends Table{
    
    /**
     * Table_notice::struct()  数组转换
     * 
     * @param array $data
     * 
     * @return $r
     */
    static protected function struct($data){
        $r = array();
     
        $r['id']                    = $data['notice_id'];
        $r['title']                 = $data['notice_title'];//公告标题
        $r['desc']                  = $data['notice_desc'];//图文详情
        $r['abstract']              = $data['notice_abstract'];//图文详情
        $r['admin']                 = $data['notice_admin'];//公告添加者
        $r['createtime']            = $data['notice_createtime'];//添加时间
        return $r;
    }

    /**
     * Table_notice::getInfoById()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        global $mypdo;
        
        $id = $mypdo->sql_check_input(array('number', $id));
        
        $sql = "select * from ".$mypdo->prefix."notice where notice_id = $id limit 1";
        
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
     * Table_notice::add() 添加新闻
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
        $admin                  = $Attr['admin'];
        $abstract               = $Attr['abstract'];

        $param = array (
            'notice_title'             => array('string', $title),
            'notice_admin'             => array('string', $admin),
            'notice_desc'              => array('string', $desc),
            'notice_abstract'          => array('string', $abstract),
            'notice_createtime'        => array('number', $createtime)
            
        );
        //var_dump($param);
        return $mypdo->sqlinsert($mypdo->prefix.'notice', $param); 
    }

    
    /**
     * Table_notice::edit() 修改新闻信息
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
        $abstract               = $Attr['abstract'];
    

       $param = array (
           'notice_title'             => array('string', $title),
           'notice_abstract'          => array('string', $abstract),
            'notice_desc'              => array('string', $desc)

            );
        $where = array(
            'notice_id'                => array('number', $id)
        );
            
        return $mypdo->sqlupdate($mypdo->prefix.'notice', $param, $where); 
    }



    /**
     * Table_notice::del() 删除医生信息
     * 
     * @param mixed $id
     * @return
     */
    static public function del($id){
        global $mypdo;
        
        $where = array(
            'notice_id' => array('number', $id)
        );

        return $mypdo->sqldelete($mypdo->prefix.'notice', $where);
    }

    

    
    /**
     * Table_notice::getList()    医生列表
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
        
        $sql = "select * from ".$mypdo->prefix."notice where 1=1 ";
        /*if(!empty($sort)) {
            $sql .= " and notice_sort = $sort ";
        }
        if(!empty($status)) {
            $sql .= " and notice_status = $status ";
        }*/
        $sql .= " order by notice_id desc limit $startrow, $pagesize";
               
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
     * Table_notice::getAllList()    医生列表
     * 
     * @param int $page         当前页
     * @param int $pagesize     每页数量
     * @return
     */
    static public function getAllList(){
        global $mypdo;
        
        
        $sql = "select * from ".$mypdo->prefix."notice where 1=1 ";
        /*if(!empty($sort)) {
            $sql .= " and notice_sort = $sort ";
        }
        if(!empty($status)) {
            $sql .= " and notice_status = $status ";
        }*/
        $sql .= " order by notice_id desc";
               
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
      * Table_notice::getCount()  医生数量统计
      * 
      * @return
      */
     static public function getCount(){
        global $mypdo;
        
        $sql = "select count(*) as ct from ".$mypdo->prefix."notice where 1=1";

        $r = $mypdo->sqlQuery($sql);
        if($r){
            return $r[0]['ct'];
        }else{
            return 0;
        }
    }
    
    
    /**
     * Table_notice::search() 商品搜索
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
        
        $sql = "select * from ".$mypdo->prefix."notice where 1=1 ";
       
        $sql .= " and notice_title like $title ";
        if($count){
            
            $r = $mypdo->sqlQuery($sql);
            return count($r);

        }else{
            $sql .= " order by notice_id desc limit $startrow, $pagesize";
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