<?php

/**
 * table_comment.class.php 表
 *
 * @version       $Id$ v0.01
 * @createtime    2016/11/14
 * @updatetime
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

class Table_comment extends Table{

    /**
     * Table_comment::struct()  数组转换
     *
     * @param array $data
     *
     * @return $r
     */
    static protected function struct($data){
        $r = array();

        $r['id']                = $data['comment_id'];
        $r['openid']            = $data['comment_openid'];//用户OPENID
        $r['nikname']           = $data['comment_nikname'];//昵称
        $r['order_detailid']    = $data['comment_order_detailid'];//订单详情ID
        $r['productid']         = $data['comment_productid'];//订单详情ID
        $r['product_title']     = $data['comment_product_title'];//订单详情ID
        $r['desc']              = $data['comment_desc'];//nikname
        $r['createtime']        = $data['comment_createtime'];//时间
        return $r;
    }

    /**
     * Table_comment::getInfoById()
     *
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        global $mypdo;

        $id = $mypdo->sql_check_input(array('number', $id));

        $sql = "select * from ".$mypdo->prefix."comment where comment_id = $id limit 1";

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

        $sql = "select * from ".$mypdo->prefix."comment where comment_openid = $openid limit 1";

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
     * Table_cart::getInfoByProductid()
     *
     * @param mixed $id
     * @return
     */
    static public function getInfoByProductid($productid){
        global $mypdo;

        $productid = $mypdo->sql_check_input(array('number', $productid));

        $sql = "select * from ".$mypdo->prefix."comment where comment_productid = $productid limit 1";

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
     * Table_cart::getInfoByOrder_detailid()
     *
     * @param mixed $id
     * @return
     */
    static public function getInfoByOrder_detailid($order_detailid){
        global $mypdo;

        //$order_detailid = $mypdo->sql_check_input(array('string', $order_detailid));

        $sql = "select * from ".$mypdo->prefix."comment where comment_order_detailid = $order_detailid ";

        $rs = $mypdo->sqlQuery($sql);
         $sql .= " order by comment_id desc";

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
     * Table_comment::add() 添加
     *
     * @param array $Attr
     * 
     *
     * @return
     */
    static public function add($Attr){
        global $mypdo;

        $openid             = $Attr['openid'];
        $nikname            = $Attr['nikname'];
        $order_detailid     = $Attr['order_detailid'];
        $productid          = $Attr['productid'];
        $product_title      = $Attr['product_title'];
        $desc               = $Attr['desc'];
        $createtime         = time();

        $param = array (
            'comment_openid'            => array('string',$openid),
            'comment_nikname'           => array('string', $nikname),
            'comment_order_detailid'    => array('number', $order_detailid),
            'comment_productid'         => array('number', $productid),
            'comment_product_title'     => array('string', $product_title),
            'comment_desc'              => array('string',$desc),
            'comment_createtime'        => array('number',$createtime)

        );
//        var_dump($param);

        return $mypdo->sqlinsert($mypdo->prefix.'comment', $param);
    }


    /**
     * Table_comment::edit() 修改
     * @param int   $id
     * @param array $Attr
     * 
     *
     * @return
     */
    static public function edit($id, $Attr){
        global $mypdo;

         $openid             = $Attr['openid'];
         $nikname            = $Attr['nikname'];
         $order_detailid     = $Attr['order_detailid'];
         $desc               = $Attr['desc'];

        $param = array (

             'comment_openid'            => array('string',$openid),
             'comment_nikname'           => array('string', $nikname),
             'comment_order_detailid'    => array('number', $order_detailid),
             'comment_desc'              => array('string',$desc)
        
        );
        $where = array(
            'comment_id'        => array('number', $id)
        );

        return $mypdo->sqlupdate($mypdo->prefix.'comment', $param, $where);
    }

    /**
     * Table_comment::del() 删除
     *
     * @param mixed $id
     * @return
     */
    static public function del($id){
        global $mypdo;

        $where = array(
            'comment_id' => array('number', $id)
        );

        return $mypdo->sqldelete($mypdo->prefix.'comment', $where);
    }

    /**
     * Table_comment::search()搜索
     *
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function search($page = 1, $pagesize = 10, $nikname='',$product_title='', $productid='' ,$count = 0){
        global $mypdo, $mylog;

        $page     = $mypdo->sql_check_input(array('number', $page));
        $pagesize = $mypdo->sql_check_input(array('number', $pagesize));

        $nikname = "%$nikname%";
        $nikname   = $mypdo->sql_check_input(array('string', $nikname));

        $product_title = "%$product_title%";
        $product_title = $mypdo->sql_check_input(array('string', $product_title));

        $productid = "%$productid%";
        $productid = $mypdo->sql_check_input(array('string', $productid));

        $startrow = ($page - 1) * $pagesize;
        $sql = "select * from ".$mypdo->prefix."comment where 1=1 ";
        $sql .= " and comment_nikname like $nikname ";
        $sql .= " and comment_product_title like $product_title ";
        $sql .= " and comment_productid like $productid ";
        //var_dump($sql);
        if($count){

            $r = $mypdo->sqlQuery($sql);
            return count($r);

        }else{
            $sql .= " order by comment_id desc limit $startrow, $pagesize";

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