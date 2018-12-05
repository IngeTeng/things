<?php

/**
 * table_address.class.php 地址表
 *
 * @version       $Id$ v0.01
 * @createtime    2016/11/14
 * @updatetime
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

class Table_address extends Table{

    /**
     * Table_comment::struct()  数组转换
     *
     * @param array $data
     *
     * @return $r
     */
    static protected function struct($data){
        $r = array();

        $r['id']                = $data['address_id'];
        $r['openid']            = $data['address_openid'];//用户OPENID
        $r['nikname']           = $data['address_nikname'];//昵称
        $r['name']              = $data['address_name'];//姓名
        $r['phone']             = $data['address_phone'];//电话
        $r['address']           = $data['address_address'];//详细地址
        $r['area']              = $data['address_area'];//区域
        $r['postcode']          = $data['address_postcode'];//邮政编码
        $r['createtime']        = $data['address_createtime'];//时间
        return $r;
    }

    /**
     * Table_address::getInfoById()
     *
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        global $mypdo;

        $id = $mypdo->sql_check_input(array('number', $id));

        $sql = "select * from ".$mypdo->prefix."address where address_id = $id limit 1";

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
     * Table_address::getInfoByOpenId()
     *
     * @param mixed $id
     * @return
     */
    static public function getInfoByOpenId($openid){
        global $mypdo;

        $openid = $mypdo->sql_check_input(array('string', $openid));

        $sql = "select * from ".$mypdo->prefix."address where address_openid = $openid limit 1";

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
     * Table_address::getInfoByOpenId()
     *
     * @param mixed $id
     * @return
     */
    static public function getInfoByOpenId_front($openid){
        global $mypdo;

        $openid = $mypdo->sql_check_input(array('string', $openid));

        $sql = "select * from ".$mypdo->prefix."address where address_openid = $openid ";
        $sql .=" order by address_id desc ";
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
     * Table_address::add() 添加
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
        $name               = $Attr['name'];
        $phone              = $Attr['phone'];
        $address            = $Attr['address'];
        $area               = $Attr['area'];
        $postcode           = $Attr['postcode'];
        $createtime         = time();

        $param = array (
            'address_openid'            => array('string',$openid),
            'address_nikname'           => array('string', $nikname),
            'address_name'              => array('string', $name),
            'address_phone'             => array('number', $phone),
            'address_address'           => array('string', $address),
            'address_area'              => array('string', $area),
            'address_postcode'          => array('number', $postcode),
            'address_createtime'        => array('number',$createtime)

        );
//        var_dump($param);

        return $mypdo->sqlinsert($mypdo->prefix.'address', $param);
    }


    /**
     * Table_address::edit() 修改
     * @param int   $id
     * @param array $Attr
     * 
     *
     * @return
     */
    static public function edit($id, $Attr){
        global $mypdo;


            $name               = $Attr['name'];
            $phone              = $Attr['phone'];
            $address            = $Attr['address'];
            $area               = $Attr['area'];
            $postcode           = $Attr['postcode'];

        $param = array (

             'address_name'              => array('string', $name),
             'address_phone'             => array('number', $phone),
             'address_address'           => array('string', $address),
             'address_area'              => array('string', $area),
             'address_postcode'          => array('number', $postcode)
        
        );
        $where = array(
            'address_id'            => array('number', $id)
        );

        return $mypdo->sqlupdate($mypdo->prefix.'address', $param, $where);
    }

    /**
     * Table_address::del() 删除
     *
     * @param mixed $id
     * @return
     */
    static public function del($id){
        global $mypdo;

        $where = array(
            'address_id' => array('number', $id)
        );

        return $mypdo->sqldelete($mypdo->prefix.'address', $where);
    }

    /**
     * Table_address::search()搜索
     *
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function search($page = 1, $pagesize = 10, $nikname = '',$name = '',$phone = '',  $count = 0){
        global $mypdo, $mylog;

        $page     = $mypdo->sql_check_input(array('number', $page));
        $pagesize = $mypdo->sql_check_input(array('number', $pagesize));

        $nikname = "%$nikname%";
        $name = "%$name%";
        $phone = "%$phone%";
        $nikname   = $mypdo->sql_check_input(array('string', $nikname));
        $name   = $mypdo->sql_check_input(array('string', $name));
        $phone   = $mypdo->sql_check_input(array('string', $phone));

        $startrow = ($page - 1) * $pagesize;
        $sql = "select * from ".$mypdo->prefix."address where 1=1 ";
        $sql .= " and address_nikname like $nikname ";
        $sql .= " and address_name like $name ";
        $sql .= " and address_phone like $phone ";

        if($count){

            $r = $mypdo->sqlQuery($sql);
            return count($r);

        }else{
            $sql .= " order by address_id desc limit $startrow, $pagesize";

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