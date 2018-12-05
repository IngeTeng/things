<?php

/**
 * table_banner.class.php 首页图片类
 *
 * @version       $Id$ v0.01
 * @createtime    2016/4/16
 * @updatetime    
 * @author        jt
 * @copyright     Neptune工作室
 */

class Table_banner extends Table{
    
    /**
     * Table_banner::struct()  数组转换
     * 
     * @param array $data
     * 
     * @return $r
     */
    static protected function struct($data){
        $r = array();
     
        $r['id']                    = $data['banner_id'];
        $r['pic']                   = $data['banner_pic'];//首页图片图片
       
        return $r;
    }

    /**
     * Table_banner::getInfoById()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        global $mypdo;
        
        $id = $mypdo->sql_check_input(array('number', $id));
        
        $sql = "select * from ".$mypdo->prefix."banner where banner_id = $id limit 1";
        
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
     * Table_banner::edit() 修改首页图片信息
     * 
     * @param int   $id
     * @param array $Attr
     * $Attr数组键：weixin_openid, name, hospital, section, position, desc, phone, createtime
     * 
     * @return
     */
    static public function edit($id, $Attr){ 
        global $mypdo;

        $pic                    = $Attr['pic'];
    

       $param = array (
          
            'banner_pic'               => array('string', $pic)

            );
        $where = array(
            'banner_id'                => array('number', $id)
        );
            
        return $mypdo->sqlupdate($mypdo->prefix.'banner', $param, $where); 
    }



    

    
    /**
     * Table_banner::getList()    医生列表
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
        
        $sql = "select * from ".$mypdo->prefix."banner where 1=1 ";
        /*if(!empty($sort)) {
            $sql .= " and banner_sort = $sort ";
        }
        if(!empty($status)) {
            $sql .= " and banner_status = $status ";
        }*/
        $sql .= " order by banner_id desc limit $startrow, $pagesize";
               
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
     * Table_banner::getAllList()    医生列表
     * 
     * @param int $page         当前页
     * @param int $pagesize     每页数量
     * @return
     */
    static public function getAllList(){
        global $mypdo;
        
        
        $sql = "select * from ".$mypdo->prefix."banner where 1=1 ";
        /*if(!empty($sort)) {
            $sql .= " and banner_sort = $sort ";
        }
        if(!empty($status)) {
            $sql .= " and banner_status = $status ";
        }*/
        $sql .= " order by banner_id desc";
               
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
      * Table_banner::getCount()  医生数量统计
      * 
      * @return
      */
     static public function getCount(){
        global $mypdo;
        
        $sql = "select count(*) as ct from ".$mypdo->prefix."banner where 1=1";

        $r = $mypdo->sqlQuery($sql);
        if($r){
            return $r[0]['ct'];
        }else{
            return 0;
        }
    }
    

    




}
?>