<?php

/**
 * table_product.class.php 商品表
 *
 * @version       $Id$ v0.01
 * @createtime    2016/4/16
 * @updatetime    
 * @author        jt
 * @copyright     Neptune工作室
 */

class Table_product extends Table{
    
    /**
     * Table_product::struct()  数组转换
     * 
     * @param array $data
     * 
     * @return $r
     */
    static protected function struct($data){
        $r = array();
     
        $r['id']                    = $data['product_id'];
        $r['cateid']                = $data['product_cateid'];//分类号
        $r['title']                 = $data['product_title'];//商品名称
        $r['desc']                  = $data['product_desc'];//图文详情
        $r['num']                   = $data['product_num'];//库存
        $r['pic']                   = $data['product_pic'];//商品图片
        $r['price']                 = $data['product_price'];//商品价格
        $r['post_price']            = $data['product_post_price'];//物流单价
        $r['issale']                = $data['product_issale'];//是否促销
        $r['ishot']                 = $data['product_ishot'];//是否热卖
        $r['isnew']                 = $data['product_isnew'];//是否新品
        $r['sale_price']            = $data['product_sale_price'];//促销价格
        $r['add_role']              = $data['product_add_role'];//添加商品的人name
        $r['add_phone']             = $data['product_add_phone'];//添加商品的人的电话
        $r['add_role_cate']         = $data['product_add_role_cate'];//添加者类型
        $r['createtime']            = $data['product_createtime'];//添加时间
        return $r;
    }

    /**
     * Table_product::getInfoById()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        global $mypdo;
        
        $id = $mypdo->sql_check_input(array('number', $id));
        
        $sql = "select * from ".$mypdo->prefix."product where product_id = $id limit 1";
        
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
     * Table_product::getInfoByPhone()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoByPhone($phone){
        global $mypdo;
        
        $phone = $mypdo->sql_check_input(array('number', $phone));
        
        $sql = "select * from ".$mypdo->prefix."product where 1=1 ";
        if(!empty($phone)){
          $sql.=" and product_add_phone = $phone";
        }
        $sql .= " order by product_id desc";
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
     * Table_product::getInfoByCate()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoByCate($cate){
        global $mypdo;
        
        $cate = $mypdo->sql_check_input(array('number', $cate));
        
        $sql = "select * from ".$mypdo->prefix."product where 1=1 ";
        if(!empty($cate)){
          $sql.=" and product_cateid = $cate";
        }
        $sql .= " order by product_id desc";
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
     * Table_product::getInfoByTitle()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoByTitle($title=' '){
        global $mypdo;
    
        $title    = "%$title%";  
        $title    = $mypdo->sql_check_input(array('string', $title));

        $sql = "select * from ".$mypdo->prefix."product where 1=1 ";
        if(!empty($title)){
          $sql.=" and product_title like $title";
        }
        $sql .= " order by product_id desc";
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
     * Table_product::getInfoById()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoByIssale($issale){
        global $mypdo;
        
        $issale = $mypdo->sql_check_input(array('number', $issale));
        
        $sql = "select * from ".$mypdo->prefix."product where product_issale = $issale ";
        $sql .= " order by product_id desc";
        
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
     * Table_product::getInfoByIshot()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoByIshot($ishot){
        global $mypdo;
        
        $ishot = $mypdo->sql_check_input(array('number', $ishot));
        
        $sql = "select * from ".$mypdo->prefix."product where product_ishot = $ishot ";
        $sql .= " order by product_id desc";
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
     * Table_product::getInfoByIsnew()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoByIsnew($isnew){
        global $mypdo;
        
        $isnew = $mypdo->sql_check_input(array('number', $isnew));
        
        $sql = "select * from ".$mypdo->prefix."product where product_isnew = $isnew ";
        
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
     * Table_product::add() 添加医生
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
        $cateid                 = $Attr['cateid'];
        $num                    = $Attr['num'];
        $pic                    = $Attr['pic'];
        $price                  = $Attr['price'];
        $post_price             = $Attr['post_price'];
        $issale                 = $Attr['issale'];
        $ishot                  = $Attr['ishot'];
        $isnew                  = $Attr['isnew'];
        $sale_price             = $Attr['sale_price'];
        $desc                   = $Attr['desc'];
        $add_role               = $Attr['add_role'];
        $add_phone              = $Attr['add_phone'];
        $add_role_cate          = $Attr['add_role_cate'];

        $param = array (
            'product_title'             => array('string', $title),
            'product_cateid'            => array('number', $cateid),
            'product_num'               => array('number', $num),
            'product_pic'               => array('string', $pic),
            'product_price'             => array('number', $price),
            'product_post_price'        => array('string', $post_price),
            'product_issale'            => array('number', $issale),
            'product_ishot'             => array('number', $ishot),
            'product_isnew'             => array('number', $isnew),
            'product_sale_price'        => array('number', $sale_price),
            'product_add_role'          => array('string', $add_role),
            'product_add_phone'         => array('number', $add_phone),
            'product_add_role_cate'     => array('number', $add_role_cate),
            'product_desc'              => array('string', $desc),
            'product_createtime'        => array('number', $createtime)
            
        );
        //var_dump($param);
        return $mypdo->sqlinsert($mypdo->prefix.'product', $param); 
    }

    
    /**
     * Table_product::edit() 修改医生信息
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
        $cateid                 = $Attr['cateid'];
        $num                    = $Attr['num'];
        $pic                    = $Attr['pic'];
        $price                  = $Attr['price'];
        $post_price             = $Attr['post_price'];
        $issale                 = $Attr['issale'];
        $ishot                  = $Attr['ishot'];
        $isnew                  = $Attr['isnew'];
        $sale_price             = $Attr['sale_price'];
        $desc                   = $Attr['desc'];
    

       $param = array (
            'product_title'             => array('string', $title),
            'product_cateid'            => array('number', $cateid),
            'product_num'               => array('number', $num),
            'product_pic'               => array('string', $pic),
            'product_price'             => array('number', $price),
            'product_post_price'        => array('string', $post_price),
            'product_issale'            => array('number', $issale),
            'product_ishot'             => array('number', $ishot),
            'product_isnew'             => array('number', $isnew),
            'product_sale_price'        => array('number', $sale_price),
            'product_desc'              => array('string', $desc),

            );
        $where = array(
            'product_id'                => array('number', $id)
        );
            
        return $mypdo->sqlupdate($mypdo->prefix.'product', $param, $where); 
    }
    /**
     * Table_product::edit() 修改医生信息
     * 
     * @param int   $id
     * @param array $Attr
     * $Attr数组键：weixin_openid, name, hospital, section, position, desc, phone, createtime
     * 
     * @return
     */
    static public function edit_desc($id, $Attr){ 
        global $mypdo;
        $title                  = $Attr['title'];
        $cateid                 = $Attr['cateid'];
        $num                    = $Attr['num'];
        $pic                    = $Attr['pic'];
        $price                  = $Attr['price'];
        $post_price             = $Attr['post_price'];
        $issale                 = $Attr['issale'];
        $ishot                  = $Attr['ishot'];
        $isnew                  = $Attr['isnew'];
        $sale_price             = $Attr['sale_price'];
    

       $param = array (
            'product_title'             => array('string', $title),
            'product_cateid'            => array('number', $cateid),
            'product_num'               => array('number', $num),
            'product_pic'               => array('string', $pic),
            'product_price'             => array('string', $price),
            'product_post_price'        => array('string', $post_price),
            'product_issale'            => array('number', $issale),
            'product_ishot'             => array('number', $ishot),
            'product_isnew'             => array('number', $isnew),
            'product_sale_price'        => array('string', $sale_price),

            );
       //var_dump($param);
        $where = array(
            'product_id'                => array('number', $id)
        );
            
        return $mypdo->sqlupdate($mypdo->prefix.'product', $param, $where); 
    }



    /**
     * Table_product::del() 删除医生信息
     * 
     * @param mixed $id
     * @return
     */
    static public function del($id){
        global $mypdo;
        
        $where = array(
            'product_id' => array('number', $id)
        );

        return $mypdo->sqldelete($mypdo->prefix.'product', $where);
    }

    
    /**
     * Table_product::updateStatus() 修改状态
     * 
     * @param mixed $id
     * @param mixed $status
     * @return
     */
   /* static public function updateStatus($id, $status){
        global $mypdo;
        
        $where = array(
            'news_id'     => array('number', $id)
        );

        $param = array(
            'news_status' => array('number', $status)
        );
        return $mypdo->sqlupdate($mypdo->prefix.'news', $param, $where);
    }
    */
    
    /**
     * Table_product::getList()    医生列表
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
        
        $sql = "select * from ".$mypdo->prefix."product where 1=1 ";
        /*if(!empty($sort)) {
            $sql .= " and news_sort = $sort ";
        }
        if(!empty($status)) {
            $sql .= " and news_status = $status ";
        }*/
        $sql .= " order by product_id desc limit $startrow, $pagesize";
               
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
     * Table_product::getAllList()    医生列表
     * 
     * @param int $page         当前页
     * @param int $pagesize     每页数量
     * @return
     */
    static public function getAllList(){
        global $mypdo;
        
        
        $sql = "select * from ".$mypdo->prefix."product where 1=1 ";
        /*if(!empty($sort)) {
            $sql .= " and news_sort = $sort ";
        }
        if(!empty($status)) {
            $sql .= " and news_status = $status ";
        }*/
        $sql .= " order by product_id desc";
               
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
      * Table_product::getCount()  医生数量统计
      * 
      * @return
      */
     static public function getCount(){
        global $mypdo;
        
        $sql = "select count(*) as ct from ".$mypdo->prefix."product where 1=1";

        $r = $mypdo->sqlQuery($sql);
        if($r){
            return $r[0]['ct'];
        }else{
            return 0;
        }
    }
    
    
    /**
     * Table_product::search() 商品搜索
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */

    static public function search($page = 1, $pagesize = 10 ,$cateid=0,$add_role='',$title='',$count = 0){
        global $mypdo, $mylog;
        
        $page     = $mypdo->sql_check_input(array('number', $page));
        $pagesize = $mypdo->sql_check_input(array('number', $pagesize));

        $cateid = $mypdo->sql_check_input(array('number', $cateid));

        $add_role    = "%$add_role%";
        $add_role    = $mypdo->sql_check_input(array('string', $add_role));

        $title    = "%$title%";
        $title    = $mypdo->sql_check_input(array('string', $title));
        
        $startrow = ($page - 1) * $pagesize;
        
        $sql = "select * from ".$mypdo->prefix."product where 1=1 ";
       

       if(!empty($cateid)) {
            $sql .= " and product_cateid = $cateid ";
        }

  
        $sql .= " and product_add_role like $add_role ";
        $sql .= " and product_title like $title ";
        if($count){
            
            $r = $mypdo->sqlQuery($sql);
            return count($r);

        }else{
            $sql .= " order by product_id desc limit $startrow, $pagesize";
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



    static public function search_phone($page = 1, $pagesize = 10 ,$phone='',$cateid=0,$title='',$count = 0){
        global $mypdo, $mylog;
        
        $page     = $mypdo->sql_check_input(array('number', $page));
        $pagesize = $mypdo->sql_check_input(array('number', $pagesize));

        $cateid = $mypdo->sql_check_input(array('number', $cateid));

        
        $title    = "%$title%";
        $title    = $mypdo->sql_check_input(array('string', $title));
        
        $startrow = ($page - 1) * $pagesize;
        
        $sql = "select * from ".$mypdo->prefix."product where product_add_phone=$phone ";
       

       if(!empty($cateid)) {
            $sql .= " and product_cateid = $cateid ";
        }

        $sql .= " and product_title like $title ";
        if($count){
            
            $r = $mypdo->sqlQuery($sql);
            return count($r);

        }else{
            $sql .= " order by product_id desc limit $startrow, $pagesize";
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