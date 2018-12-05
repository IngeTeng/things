<?php

/**
 * table_order.class.php 订单表
 *
 * @version       $Id$ v0.01
 * @createtime    2016/4/16
 * @updatetime    
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

class Table_order extends Table{
    
    /**
     * Table_order::struct()  数组转换
     * 
     * @param array $data
     * 
     * @return $r
     */
    static protected function struct($data){
        $r = array();
     
        $r['id']                     = $data['order_id'];
        $r['pay_id']                 = $data['order_pay_id'];
        $r['openid']                 = $data['order_openid'];
        $r['nikname']                = $data['order_nikname'];
        $r['addressid']              = $data['order_addressid'];//健康知识
        $r['address_name']           = $data['order_address_name'];//健康知识
        $r['address_phone']          = $data['order_address_phone'];//健康知识
        $r['address_area']           = $data['order_address_area'];//健康知识
        $r['address']                = $data['order_address'];//健康知识
        $r['state']                  = $data['order_state'];//详细介绍
        $r['createtime']             = $data['order_createtime'];//添加时间 
        return $r;
    }

    /**
     * Table_order::getInfoById()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        global $mypdo;
        
        $id = $mypdo->sql_check_input(array('number', $id));
        
        $sql = "select * from ".$mypdo->prefix."order where order_id = $id limit 1";
        
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
     * Table_order::getInfoByPayid()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoByPayid($payid){
        global $mypdo;
        
        $payid = $mypdo->sql_check_input(array('string', $payid));
        
        $sql = "select * from ".$mypdo->prefix."order where order_pay_id = $payid limit 1";
        
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
     * Table_order::add() 添加信息
     * 
     * @param array $Attr
     * $Attr数组键：name, desc,createtime
     * 
     * @return
     */
    static public function add($Attr){ 
        global $mypdo;
    
        $createtime           = time();
        $pay_id               = $Attr['pay_id'];
        $nikname              = $Attr['nikname'];
        $openid               = $Attr['openid'];
        $addressid            = $Attr['addressid'];
        $address_name         = $Attr['address_name'];
        $address_phone        = $Attr['address_phone'];
        $address_area         = $Attr['address_area'];
        $address              = $Attr['address'];
        $state                = $Attr['state'];

        $param = array (

            'order_pay_id'              => array('string', $pay_id),
            'order_nikname'             => array('string', $nikname),
            'order_openid'              => array('string', $openid),
            'order_addressid'           => array('number', $addressid),
            'order_address_name'        => array('string', $address_name),
            'order_address_phone'       => array('number', $address_phone),
            'order_address_area'        => array('string', $address_area),
            'order_address'             => array('string', $address),
            'order_state'               => array('number', $state),
            'order_createtime'          => array('number', $createtime)
        );
            
        return $mypdo->sqlinsert($mypdo->prefix.'order', $param); 
    }

    
    /**
     * Table_order::edit() 修改信息
     * 
     * @param int   $id
     * @param array $Attr
     * $Attr数组键： name,  desc
     * 
     * @return
     */
    static public function edit($pay_id, $Attr){ 
        global $mypdo;
        
        $state                = $Attr['state'];
        $createtime                 = time();
    

       $param = array (
        
            'order_state'               => array('number', $state),
            'order_createtime'          => array('number', $createtime)
            );
        $where = array(
            'order_pay_id'                  => array('string', $pay_id)
        );
            
        return $mypdo->sqlupdate($mypdo->prefix.'order', $param, $where); 
    }



    /**
     * Table_order::post() 发货信息
     * 
     * @param int   $id
     * @param array $Attr
     * $Attr数组键： name,  desc
     * 
     * @return
     */
    static public function post($id){ 
        global $mypdo;
        
        $state                = 4;
    

       $param = array (

            'order_state'               => array('number', $state)
            
            );
        $where = array(
            'order_id'                  => array('number', $id)
        );
            
        return $mypdo->sqlupdate($mypdo->prefix.'order', $param, $where); 
    }

    /**
     * Table_order::del() 删除信息
     * 
     * @param mixed $id
     * @return
     */
    static public function del($payid){
        global $mypdo;
        
        $where = array(
            'order_pay_id' => array('string', $payid)
        );
        //var_dump('success');
        return $mypdo->sqldelete($mypdo->prefix.'order', $where);
    }

    
   
    
    /**
     * Table_order::getList()    健康知识列表
     * 
     * @param int $page         当前页
     * @param int $pagesize     每页数量
     * @return
     */
    static public function getList(){
        global $mypdo;
        
        $sql = "select * from ".$mypdo->prefix."order where 1=1 ";
        $sql .= " order by order_id desc  ";
               
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
      * Table_order::getCount()  数量统计
      * 
      * @return
      */
     static public function getCount(){
        global $mypdo;
        
        $sql = "select count(*) as ct from ".$mypdo->prefix."order where 1=1";

        $r = $mypdo->sqlQuery($sql);
        if($r){
            return $r[0]['ct'];
        }else{
            return 0;
        }
    }
    
    
    /**
     * Table_order::search() 搜索
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */

    static public function search($page = 1, $pagesize = 10 , $pay_id='', $nikname='',$count = 0){
        global $mypdo, $mylog;
        
        $page     = $mypdo->sql_check_input(array('number', $page));
        $pagesize = $mypdo->sql_check_input(array('number', $pagesize));
        
        $pay_id = "%$pay_id%";
        $pay_id    = $mypdo->sql_check_input(array('string', $pay_id));
        
        $nikname = "%$nikname%";
        $nikname = $mypdo->sql_check_input(array('string', $nikname));
        
        $startrow = ($page - 1) * $pagesize;
        
        $sql = "select * from ".$mypdo->prefix."order where 1=1 ";
        
        $sql .= " and order_pay_id like $pay_id ";
        $sql .= " and order_nikname like $nikname ";
        if($count){
            
            $r = $mypdo->sqlQuery($sql);
            return count($r);

        }else{
            $sql .= " order by order_id desc limit $startrow, $pagesize";
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