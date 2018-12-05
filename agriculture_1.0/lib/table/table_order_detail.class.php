<?php

/**
 * table_order_detail.class.php 订单详情表
 *
 * @version       $Id$ v0.01
 * @createtime    2016/4/16
 * @updatetime    
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

class Table_order_detail extends Table{
    
    /**
     * Table_order_detail::struct()  数组转换
     * 
     * @param array $data
     * 
     * @return $r
     */
    static protected function struct($data){
        $r = array();
     
        $r['id']                 = $data['order_detail_id'];
        $r['openid']             = $data['order_detail_openid'];
        $r['payid']              = $data['order_detail_payid'];//订单ID
        $r['num']                = $data['order_detail_num'];//商品数量
        $r['productid']          = $data['order_detail_productid'];//商品ID
        $r['product_img']        = $data['order_detail_product_img'];//商品ID
        $r['product_title']      = $data['order_detail_product_title'];//商品名称
        $r['product_price']      = $data['order_detail_product_price'];//价格
        $r['product_sale_price'] = $data['order_detail_product_sale_price'];//促销价格
        $r['product_post_price'] = $data['order_detail_product_post_price'];//物流金额
        $r['product_add_phone']  = $data['order_detail_product_add_phone'];//物流金额
        $r['total']              = $data['order_detail_total'];//物流金额
        $r['state']              = $data['order_detail_state'];//详细订单状态
        $r['createtime']         = $data['order_detail_createtime'];//时间
        return $r;
    }

    /**
     * Table_order_detail::getInfoById()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        global $mypdo;
        
        $id = $mypdo->sql_check_input(array('number', $id));
        
        $sql = "select * from ".$mypdo->prefix."order_detail where order_detail_id = $id limit 1";
       
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
     * Table_order_detail::getInfoByOpenid()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoByOpenid($openid){
        global $mypdo;
        
        $openid = $mypdo->sql_check_input(array('string', $openid));
        
        $sql = "select * from ".$mypdo->prefix."order_detail where order_detail_openid = $openid ";

       $sql .= " order by order_detail_id desc";

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
     * Table_order_detail::getInfoByOpenid_state()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoByOpenid_state($openid,$state){
        global $mypdo;
        
        $openid = $mypdo->sql_check_input(array('string', $openid));
        $state = $mypdo->sql_check_input(array('number', $state));
        
        $sql = "select * from ".$mypdo->prefix."order_detail where order_detail_openid = $openid ";

        $sql .= " and order_detail_state = $state ";
        
        $sql .= " order by order_detail_id desc";

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
     * Table_order_detail::getInfoByPayId()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoByPayId($payid){
        global $mypdo;
        
        //$payid = "%$payid%";
        $payid = $mypdo->sql_check_input(array('string', $payid));
        
        $sql = "select * from ".$mypdo->prefix."order_detail where order_detail_payid = $payid ";
   
        //$rs = $mypdo->sqlQuery($sql);
     
        $sql .= " order by order_detail_id desc";

        $rs = $mypdo->sqlQuery($sql);
            //var_dump($sql);
           //var_dump($rs);
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
     * Table_order_detail::getInfoByProductid()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoByProductid($productid){
        global $mypdo;
        
        //$id = $mypdo->sql_check_input(array('number', $productid));
        if($productid){
        
        $sql = "select * from ".$mypdo->prefix."order_detail where order_detail_productid = $productid ";
        }else{
        $sql = "select * from ".$mypdo->prefix."order_detail where order_detail_productid = 0";
        }
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
     * Table_order_detail::add() 添加
     * 
     * @param array $Attr
     * $Attr数组键：questionid, user_openid, doctor_openid, path, cateid, createtime
     * 
     * @return
     */
    static public function add($Attr){ 
        global $mypdo;
        
        $openid               = $Attr['openid'];
        $payid                = $Attr['payid'];
        $num                  = $Attr['num'];
        $productid            = $Attr['productid'];
        $product_img          = $Attr['product_img'];
        $product_title        = $Attr['product_title'];
        $product_price        = $Attr['product_price'];
        $product_sale_price   = $Attr['product_sale_price'];
        $product_post_price   = $Attr['product_post_price'];
        $product_add_phone    = $Attr['product_add_phone'];
        $total                = $Attr['total'];
        $state                = $Attr['state'];
        $createtime           = time();
      

        $param = array (
            'order_detail_openid'                    => array('string', $openid),
            'order_detail_payid'                    => array('string', $payid),
            'order_detail_num'                      => array('number', $num),
            'order_detail_productid'                => array('string', $productid),
            'order_detail_product_img'              => array('string', $product_img),
            'order_detail_product_title'            => array('string', $product_title),
            'order_detail_product_price'            => array('number', $product_price),
            'order_detail_product_sale_price'       => array('string', $product_sale_price),
            'order_detail_product_post_price'       => array('string', $product_price),
            'order_detail_product_add_phone'        => array('number', $product_add_phone),
            'order_detail_total'                    => array('number', $total),
            'order_detail_state'                    => array('number', $state),
            'order_detail_createtime'               => array('number', $createtime)
            
        );
            
        return $mypdo->sqlinsert($mypdo->prefix.'order_detail', $param); 
    }

    
    /**
     * Table_order_detail::edit() 修改
     * 
     * @param int   $id
      * @param array $Attr
     * $Attr数组键：questionid, user_openid, doctor_openid, path, cateid, createtime
     * 
     * @return
     */
    static public function edit($id, $Attr){ 
        global $mypdo;
        
        
        $state                = $Attr['state'];
    

       $param = array (
             
             'order_detail_state'                    => array('number', $state)
            );
        $where = array(
                'order_detail_id'                => array('number', $id)
        );
            
        return $mypdo->sqlupdate($mypdo->prefix.'order_detail', $param, $where); 
    }



    /**
     * Table_order_detail::del() 删除
     * 
     * @param mixed $id
     * @return
     */
    static public function del($id){
        global $mypdo;
        
        $where = array(
            'order_detail_id' => array('number', $id)
        );

        return $mypdo->sqldelete($mypdo->prefix.'order_detail', $where);
    }

    /**
     * Table_order_detail::post() 发货信息
     * 
     * @param int   $id
     * @param array $Attr
     * $Attr数组键： name,  desc
     * 
     * @return
     */
    static public function post($id){ 
        global $mypdo;
        
        $state                = 3;
    

       $param = array (

            'order_detail_state'               => array('number', $state)
            
            );
        $where = array(
            'order_detail_id'                  => array('number', $id)
        );
            
        return $mypdo->sqlupdate($mypdo->prefix.'order_detail', $param, $where); 
    }


     /**
     * Table_order_detail::sure() 确认收货
     * 
     * @param int   $id
     * @param array $Attr
     * $Attr数组键： name,  desc
     * 
     * @return
     */
    static public function sure($id){ 
        global $mypdo;
        
        $state                = 4;
    

       $param = array (

            'order_detail_state'               => array('number', $state)
            
            );
        $where = array(
            'order_detail_id'                  => array('number', $id)
        );
            
        return $mypdo->sqlupdate($mypdo->prefix.'order_detail', $param, $where); 
    }
    
    /**
     * Table_order_detail::getList()    列表
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
        
        $sql = "select * from ".$mypdo->prefix."order_detail where 1=1 ";
        /*if(!empty($sort)) {
            $sql .= " and news_sort = $sort ";
        }
        if(!empty($status)) {
            $sql .= " and news_status = $status ";
        }*/
        $sql .= " order by img_id desc limit $startrow, $pagesize";
               
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
      * Table_order_detail::getCount()  数量统计
      * 
      * @return
      */
     static public function getCount(){
        global $mypdo;
        
        $sql = "select count(*) as ct from ".$mypdo->prefix."order_detail where 1=1";

        $r = $mypdo->sqlQuery($sql);
        if($r){
            return $r[0]['ct'];
        }else{
            return 0;
        }
    }
    
    
    /**
     * Table_order_detail::search() 医生搜索
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */

    static public function search($page = 1, $pagesize = 10 ,$state=0, $payid='',$count = 0){
        global $mypdo, $mylog;
        
        $page     = $mypdo->sql_check_input(array('number', $page));
        $pagesize = $mypdo->sql_check_input(array('number', $pagesize));
        $state    = $mypdo->sql_check_input(array('number', $state));
        
        $payid = "%$payid%";
       
        $payid  = $mypdo->sql_check_input(array('string', $payid));
        
        $startrow = ($page - 1) * $pagesize;
        
        $sql = "select * from ".$mypdo->prefix."order_detail where 1=1 ";
       
        if(!empty($state)) {
            $sql .= " and order_detail_state = $state ";
        }
        $sql .= " and order_detail_payid like $payid ";
        if($count){
            
            $r = $mypdo->sqlQuery($sql);
            return count($r);

        }else{
            $sql .= " order by order_detail_id desc limit $startrow, $pagesize";
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

    /**
     * Table_order_detail::search() 医生搜索
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */

    static public function search_record($page = 1, $pagesize = 10 ,$phone='', $begin_time=0, $end_time=0 , $count = 0){
        global $mypdo, $mylog;
        
        $page     = $mypdo->sql_check_input(array('number', $page));
        $pagesize = $mypdo->sql_check_input(array('number', $pagesize));

        //$phone = "%$phone%";
       
        

        $begin_time  = $mypdo->sql_check_input(array('number', $begin_time));

        $end_time  = $mypdo->sql_check_input(array('number', $end_time));

        $startrow = ($page - 1) * $pagesize;

        
        $sql = "select * from ".$mypdo->prefix."order_detail where 1=1 ";
       
        if(!empty($begin_time)) {

            $begin = strtotime($begin_time);

            $sql .= "  and order_detail_createtime > $begin ";

        }

        if(!empty($end_time)){

            $end = strtotime($end_time);

            $sql .= "  and order_detail_createtime < $end ";
        }
        if(!empty($phone)){
            $phone  = $mypdo->sql_check_input(array('string', $phone));
            $sql .= " and order_detail_product_add_phone = $phone ";
        }
        $sql .= " and order_detail_state <> 1 ";

        if($count){
            
            $r = $mypdo->sqlQuery($sql);
            return count($r);

        }else{
            $sql .= " order by order_detail_id desc limit $startrow, $pagesize";
            //var_dump($sql);
            //exit;
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

    /**
     * Table_order_detail::search_phone() 医生搜索
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */

    static public function search_phone($page = 1, $pagesize = 10 ,$state=0,$phone='', $payid='', $begin_time = 0, $end_time = 0,$count = 0){
        global $mypdo, $mylog;
        
        $page     = $mypdo->sql_check_input(array('number', $page));
        $pagesize = $mypdo->sql_check_input(array('number', $pagesize));
        $state    = $mypdo->sql_check_input(array('number', $state));
        
        $begin_time  = $mypdo->sql_check_input(array('number', $begin_time));

        $end_time  = $mypdo->sql_check_input(array('number', $end_time));


        $payid = "%$payid%";
       
        $payid  = $mypdo->sql_check_input(array('string', $payid));

        $phone = "%$phone%";
       
        $phone  = $mypdo->sql_check_input(array('string', $phone));
        
        $startrow = ($page - 1) * $pagesize;

        
        $sql = "select * from ".$mypdo->prefix."order_detail where 1=1 ";

        if(!empty($begin_time)) {

            $begin = strtotime($begin_time);

            $sql .= "  and order_detail_createtime > $begin ";

        }

        if(!empty($end_time)){

            $end = strtotime($end_time);

            $sql .= "  and order_detail_createtime < $end ";
        }
       
        if(!empty($state)) {
            $sql .= " and order_detail_state = $state ";
        }
        $sql .= " and order_detail_payid like $payid ";

        $sql .= " and order_detail_product_add_phone like $phone ";
        if($count){
            
            $r = $mypdo->sqlQuery($sql);
            return count($r);

        }else{
            $sql .= " order by order_detail_id desc limit $startrow, $pagesize";
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