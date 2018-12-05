<?php

/**
 * table_cart.class.php 购物车表
 *
 * @version       $Id$ v0.01
 * @createtime    2016/11/14
 * @updatetime
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

class Table_cart extends Table{

    /**
     * Table_cart::struct()  数组转换
     *
     * @param array $data
     *
     * @return $r
     */
    static protected function struct($data){
        $r = array();

        $r['id']                = $data['cart_id'];
        $r['productid']         = $data['cart_productid'];//商品ID
        $r['productnum']        = $data['cart_productnum'];//商品数量
        $r['product_pic']       = $data['cart_product_pic'];//商品图片
        $r['product_price']     = $data['cart_product_price'];//商品价格
        $r['product_title']     = $data['cart_product_title'];//商品名称
        $r['ischecked']         = $data['cart_ischecked'];//商品名称
        $r['openid']            = $data['cart_openid'];//OPENID
        $r['nikname']           = $data['cart_nikname'];//nikname
        $r['createtime']        = $data['cart_createtime'];//时间
        return $r;
    }

    /**
     * Table_cart::getInfoById()
     *
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        global $mypdo;

        $id = $mypdo->sql_check_input(array('number', $id));

        $sql = "select * from ".$mypdo->prefix."cart where cart_id = $id limit 1";

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
     * Table_cart::getInfoByOpenId()
     *
     * @param mixed $id
     * @return
     */
    static public function getInfoByOpenId($openid){
        global $mypdo;

        $openid = $mypdo->sql_check_input(array('string', $openid));

        $sql = "select * from ".$mypdo->prefix."cart where cart_openid = $openid  order by cart_id desc ";

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
     * Table_cart::getInfoByOpenId_ischecked()
     *
     * @param mixed $id
     * @return
     */
    static public function getInfoByOpenId_ischecked($openid , $ischecked){
        global $mypdo;

        $openid = $mypdo->sql_check_input(array('string', $openid));
        $ischecked = $mypdo->sql_check_input(array('number', $ischecked));

        $sql = "select * from ".$mypdo->prefix."cart where 1=1   ";
        if(!empty($openid)){
            $sql .="   and cart_openid = $openid"; 
        }
        if($ischecked==1){
            $sql .= "  and cart_ischecked = $ischecked";
        }
        $sql .= " order by cart_id desc";
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
      * Table_cart::getCount()  数量统计
      * 
      * @return
      */
     static public function getCountByOpenId($openid){
        global $mypdo;
        $openid = $mypdo->sql_check_input(array('string', $openid));
        $sql = "select count(*) as ct from ".$mypdo->prefix."cart where 1=1";
        $sql .=" and cart_openid = $openid";
        $r = $mypdo->sqlQuery($sql);
        if($r){
            return $r[0]['ct'];
        }else{
            return 0;
        }
    }
    static public function checkInfoByProduct($openid,$productid){

        global $mypdo;

        $openid = $mypdo->sql_check_input(array('string', $openid));
        $productid = $mypdo->sql_check_input(array('number', $productid));

        $sql = "select * from ".$mypdo->prefix."cart where cart_openid = $openid and cart_productid= $productid limit 1";

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
     * Table_cart::add() 添加购物车
     *
     * @param array $Attr
     * 
     *
     * @return
     */
    static public function add($Attr){
        global $mypdo;

        $productid          = $Attr['productid'];
        $productnum         = $Attr['productnum'];
        $product_pic        = $Attr['product_pic'];
        $product_price      = $Attr['product_price'];
        $product_title      = $Attr['product_title'];
        $openid             = $Attr['openid'];
        $nikname            = $Attr['nikname'];
        $createtime         = time();

        $param = array (
            'cart_productid'        => array('number',$productid),
            'cart_productnum'       => array('numner', $productnum),
            'cart_product_pic'      => array('string', $product_pic),
            'cart_product_price'    => array('numner', $product_price),
            'cart_product_title'    => array('string', $product_title),
            'cart_openid'           => array('string', $openid),
            'cart_nikname'          => array('string',$nikname),
            'cart_createtime'       => array('number',$createtime)

        );
//        var_dump($param);

        return $mypdo->sqlinsert($mypdo->prefix.'cart', $param);
    }

     /**
     * Table_cart::edit_ischecked() 修改购物车
     *
     * @param array $Attr
     * 
     *
     * @return
     */
    static public function edit_ischecked($id, $Attr){
        global $mypdo;

         $ischecked         = $Attr['ischecked'];
        

        $param = array (


             'cart_ischecked'       => array('numner', $ischecked)
             
        );
        $where = array(
            'cart_id'        => array('number', $id)
        );

        return $mypdo->sqlupdate($mypdo->prefix.'cart', $param, $where);
    }



    /**
     * Table_cart::edit() 修改购物车
     * @param int   $id
     * @param array $Attr
     * 
     *
     * @return
     */
    static public function edit($id, $Attr){
        global $mypdo;

         $productnum         = $Attr['productnum'];
        

        $param = array (


             'cart_productnum'       => array('numner', $productnum)
             
        );
        $where = array(
            'cart_id'        => array('number', $id)
        );

        return $mypdo->sqlupdate($mypdo->prefix.'cart', $param, $where);
    }

    /**
     * Table_cart::del() 删除用户信息
     *
     * @param mixed $id
     * @return
     */
    static public function del($id){
        global $mypdo;

        $where = array(
            'cart_id' => array('number', $id)
        );

        return $mypdo->sqldelete($mypdo->prefix.'cart', $where);
    }

    /**
     * Table_cart::search() 护工搜索
     *
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function search($page = 1, $pagesize = 10, $nikname='',  $count = 0){
        global $mypdo, $mylog;

        $page     = $mypdo->sql_check_input(array('number', $page));
        $pagesize = $mypdo->sql_check_input(array('number', $pagesize));

        $nikname = "%$nikname%";
        $nikname   = $mypdo->sql_check_input(array('string', $nikname));

        $startrow = ($page - 1) * $pagesize;
        $sql = "select * from ".$mypdo->prefix."cart where 1=1 ";
        $sql .= " and cart_nikname like $nikname ";

        if($count){

            $r = $mypdo->sqlQuery($sql);
            return count($r);

        }else{
            $sql .= " order by cart_id desc limit $startrow, $pagesize";

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