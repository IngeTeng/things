<?php

/**
 * table_suggest.class.php 留言类
 *
 * @version       $Id$ v0.01
 * @createtime    2016/4/16
 * @updatetime    
 * @author        jt
 * @copyright     Neptune工作室
 */

class Table_suggest extends Table{
    
    /**
     * Table_suggest::struct()  数组转换
     * 
     * @param array $data
     * 
     * @return $r
     */
    static protected function struct($data){
        $r = array();
     
        $r['id']                    = $data['suggest_id'];
        $r['name']                  = $data['suggest_name'];//姓名
        $r['phone']                 = $data['suggest_phone'];//点阿虎
        $r['desc']                  = $data['suggest_desc'];//详情
        $r['createtime']            = $data['suggest_createtime'];//添加时间
        return $r;
    }

    /**
     * Table_suggest::getInfoById()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        global $mypdo;
        
        $id = $mypdo->sql_check_input(array('number', $id));
        
        $sql = "select * from ".$mypdo->prefix."suggest where suggest_id = $id limit 1";
        
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
     * Table_suggest::add() 添加新闻
     * 
     * @param array $Attr
     * $Attr数组键：weixin_openid, name, hospital, section, position, desc, phone ,createtime
     * 
     * @return
     */
    static public function add($Attr){ 
        global $mypdo;
        

        $createtime             = time();
        $name                   = $Attr['name'];
        $phone                  = $Attr['phone'];
        $desc                   = $Attr['desc'];

        $param = array (
            'suggest_name'             => array('string', $name),
            'suggest_phone'             => array('number', $phone),
            'suggest_desc'              => array('string', $desc),
            'suggest_createtime'        => array('number', $createtime)
            
        );
        //var_dump($param);
        return $mypdo->sqlinsert($mypdo->prefix.'suggest', $param); 
    }

    


    /**
     * Table_suggest::del() 删除医生信息
     * 
     * @param mixed $id
     * @return
     */
    static public function del($id){
        global $mypdo;
        
        $where = array(
            'suggest_id' => array('number', $id)
        );

        return $mypdo->sqldelete($mypdo->prefix.'suggest', $where);
    }

    

    
    /**
     * Table_suggest::getList()    医生列表
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
        
        $sql = "select * from ".$mypdo->prefix."suggest where 1=1 ";
        /*if(!empty($sort)) {
            $sql .= " and suggest_sort = $sort ";
        }
        if(!empty($status)) {
            $sql .= " and suggest_status = $status ";
        }*/
        $sql .= " order by suggest_id desc limit $startrow, $pagesize";
               
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
     * Table_suggest::getAllList()    医生列表
     * 
     * @param int $page         当前页
     * @param int $pagesize     每页数量
     * @return
     */
    static public function getAllList(){
        global $mypdo;
        
        
        $sql = "select * from ".$mypdo->prefix."suggest where 1=1 ";
        /*if(!empty($sort)) {
            $sql .= " and suggest_sort = $sort ";
        }
        if(!empty($status)) {
            $sql .= " and suggest_status = $status ";
        }*/
        $sql .= " order by suggest_id desc";
               
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
      * Table_suggest::getCount()  医生数量统计
      * 
      * @return
      */
     static public function getCount(){
        global $mypdo;
        
        $sql = "select count(*) as ct from ".$mypdo->prefix."suggest where 1=1";

        $r = $mypdo->sqlQuery($sql);
        if($r){
            return $r[0]['ct'];
        }else{
            return 0;
        }
    }
    
    
    /**
     * Table_suggest::search() 商品搜索
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */

    static public function search($page = 1, $pagesize = 10 ,$name='', $phone=0,$count = 0){
        global $mypdo, $mylog;
        
        $page     = $mypdo->sql_check_input(array('number', $page));
        $pagesize = $mypdo->sql_check_input(array('number', $pagesize));


        $name    = "%$name%";
        $name    = $mypdo->sql_check_input(array('string', $name));
        
        $startrow = ($page - 1) * $pagesize;
        
        $sql = "select * from ".$mypdo->prefix."suggest where 1=1 ";
       
        $sql .= " and suggest_name like $name ";

        if(!empty($phone)){
            $sql .= " and suggest_phone = $phone ";
        }

        if($count){
            
            $r = $mypdo->sqlQuery($sql);
            return count($r);

        }else{
            $sql .= " order by suggest_id desc limit $startrow, $pagesize";
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