<?php

/**
 * table_submit.class.php 商品表
 *
 * @version       $Id$ v0.01
 * @createtime    2016/4/16
 * @updatetime    
 * @author        jt
 * @copyright     Neptune工作室
 */

class Table_submit extends Table{
    
    /**
     * Table_submit::struct()  数组转换
     * 
     * @param array $data
     * 
     * @return $r
     */
    static protected function struct($data){
        $r = array();
     
        $r['id']                    = $data['submit_id'];
        $r['only']                  = $data['submit_only'];//工单号
        $r['openid']                = $data['submit_openid'];//微信识别吗
        $r['nikname']               = $data['submit_nikname'];//昵称
        $r['desc']                  = $data['submit_desc'];//用户问题
        $r['replay']                = $data['submit_replay'];//回复
        $r['createtime']            = $data['submit_createtime'];//添加时间
        return $r;
    }

    /**
     * Table_submit::getInfoById()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        global $mypdo;
        
        $id = $mypdo->sql_check_input(array('number', $id));
        
        $sql = "select * from ".$mypdo->prefix."submit where submit_id = $id limit 1";
        
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
     * Table_submit::getInfoByOpenid()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoByOpenid($openid){
        global $mypdo;
        
        $openid = $mypdo->sql_check_input(array('string', $openid));
        
        $sql = "select * from ".$mypdo->prefix."submit where 1=1 ";
        if(!empty($openid)){
          $sql.=" and submit_openid = $openid";
        }
        $sql .= " order by submit_id desc";
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
    
    /**
     * Table_submit::add() 添加医生
     * 
     * @param array $Attr
     * $Attr数组键：weixin_openid, name, hospital, section, position, desc, phone ,createtime
     * 
     * @return
     */
    static public function add($Attr){ 
        global $mypdo;
        

        $createtime             = time();
        $only                   = date('YmdHis').rand(1000,9999);     //算法计算所得
        $openid                 = $Attr['openid'];
        $nikname                = $Attr['nikname'];
        $desc                   = $Attr['desc'];

        $param = array (
            'submit_only'               => array('number', $only),
            'submit_openid'             => array('string', $openid),
            'submit_nikname'            => array('string', $nikname),
            'submit_desc'               => array('string', $desc),
            'submit_createtime'         => array('number', $createtime)
            
        );
        //var_dump($param);
        return $mypdo->sqlinsert($mypdo->prefix.'submit', $param); 
    }

    
    /**
     * Table_submit::edit() 修改信息
     * 
     * @param int   $id
     * @param array $Attr
     * $Attr数组键：weixin_openid, name, hospital, section, position, desc, phone, createtime
     * 
     * @return
     */
    static public function edit($id, $Attr){ 
        global $mypdo;
        
        $replay                   = $Attr['replay'];
    

       $param = array (
            
            'submit_replay'              => array('string', $replay),

            );
        $where = array(
            'submit_id'                => array('number', $id)
        );
            
        return $mypdo->sqlupdate($mypdo->prefix.'submit', $param, $where); 
    }

    /**
     * Table_submit::del() 删除工单信息
     * 
     * @param mixed $id
     * @return
     */
    static public function del($id){
        global $mypdo;
        
        $where = array(
            'submit_id' => array('number', $id)
        );

        return $mypdo->sqldelete($mypdo->prefix.'submit', $where);
    }

    
    
    /**
     * Table_submit::getList()    工单列表
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
        
        $sql = "select * from ".$mypdo->prefix."submit where 1=1 ";
        /*if(!empty($sort)) {
            $sql .= " and news_sort = $sort ";
        }
        if(!empty($status)) {
            $sql .= " and news_status = $status ";
        }*/
        $sql .= " order by submit_id desc limit $startrow, $pagesize";
               
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
     * Table_submit::getAllList()    工单列表
     * 
     * @param int $page         当前页
     * @param int $pagesize     每页数量
     * @return
     */
    static public function getAllList(){
        global $mypdo;
        
        
        $sql = "select * from ".$mypdo->prefix."submit where 1=1 ";
        /*if(!empty($sort)) {
            $sql .= " and news_sort = $sort ";
        }
        if(!empty($status)) {
            $sql .= " and news_status = $status ";
        }*/
        $sql .= " order by submit_id desc";
               
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
      * Table_submit::getCount()  工单数量统计
      * 
      * @return
      */
     static public function getCount(){
        global $mypdo;
        
        $sql = "select count(*) as ct from ".$mypdo->prefix."submit where 1=1";

        $r = $mypdo->sqlQuery($sql);
        if($r){
            return $r[0]['ct'];
        }else{
            return 0;
        }
    }
    
    
    /**
     * Table_submit::search() 工单搜索
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */

    static public function search($page = 1, $pagesize = 10 ,$only='',$count = 0){
        global $mypdo, $mylog;
        
        $page     = $mypdo->sql_check_input(array('number', $page));
        $pagesize = $mypdo->sql_check_input(array('number', $pagesize));



        $only        = "%$only%";
        $only        = $mypdo->sql_check_input(array('string', $only));

        
        
        $startrow = ($page - 1) * $pagesize;
        
        $sql = "select * from ".$mypdo->prefix."submit where 1=1 ";
       

        $sql .= " and submit_only like $only ";
        if($count){
            
            $r = $mypdo->sqlQuery($sql);
            return count($r);

        }else{
            $sql .= " order by submit_id desc limit $startrow, $pagesize";
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