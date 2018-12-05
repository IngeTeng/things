<?php

/**
 * table_predict.class.php 表
 *
 * @version       $Id$ v0.01
 * @createtime    2016/11/14
 * @updatetime
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

class Table_pay extends Table{

    /**
     * Table_predict::struct()  数组转换
     *
     * @param array $data
     *
     * @return $r
     */
    static protected function struct($data){
        $r = array();

        $r['id']                    = $data['pay_id'];
        $r['openid']                = $data['pay_openid'];
        $r['money']                = $data['pay_money'];
        $r['shengyuan']             = $data['pay_shengyuan'];
        $r['danwei']                = $data['pay_danwei'];
        $r['createtime']            = $data['pay_createtime'];
        return $r;
    }

    static public function add($Attr){ 
        global $mypdo;
        
        $time           = time();
        $openid         = $Attr['openid'];
        $money          = $Attr['money'];
        $shengyuan      = $Attr['shengyuan'];
        $danwei         = $Attr['danwei'];
        $createtime     = $Attr['createtime'];

        $param = array (
            'pay_openid'        => array('string', $openid),
            'pay_money'        => array('number', $money),
            'pay_shengyuan'       => array('string', $shengyuan),
            'pay_danwei'    => array('string', $danwei),
            'pay_createtime'    => array('string', $createtime)
            
            
        );
            
        return $mypdo->sqlinsert($mypdo->prefix.'pay', $param); 
    }


     /**
     * Table_predict::search()搜索
     *
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function search($page = 1, $pagesize = 10,  $shengyuan = '', $danwei = '', $count = 0){
        global $mypdo, $mylog;
        
        $page     = $mypdo->sql_check_input(array('number', $page));
        $pagesize = $mypdo->sql_check_input(array('number', $pagesize));
        
        $shengyuan = "%$shengyuan%";
        $shengyuan    = $mypdo->sql_check_input(array('string', $shengyuan));

        $danwei = "%$danwei%";
        $danwei    = $mypdo->sql_check_input(array('string', $danwei));
        
        $startrow = ($page - 1) * $pagesize;
        
        $sql = "select * from ".$mypdo->prefix."pay where 1=1 ";
        
  
        $sql .= " and pay_shengyuan like $shengyuan ";
         $sql .= " and pay_danwei like $danwei ";
        
        
        if($count){
            
            $r = $mypdo->sqlQuery($sql);
            return count($r);

        }else{
            $sql .= " order by pay_id desc limit $startrow, $pagesize";
              // var_dump($sql);
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