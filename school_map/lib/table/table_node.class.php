<?php

/**
 * table_node.class.php 表
 *
 * @version       $Id$ v0.01
 * @createtime    2016/11/14
 * @updatetime
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

class Table_node extends Table{

    /**
     * Table_node::struct()  数组转换
     *
     * @param array $data
     *
     * @return $r
     */
    static protected function struct($data){
        $r = array();

        $r['id']                = $data['node_id'];
        $r['title']             = $data['node_title'];//节点名称
        $r['jing']              = $data['node_jing'];//经度信息
        $r['wei']               = $data['node_wei'];//纬度信息
        $r['createtime']        = $data['node_createtime'];//创建时间
        return $r;
    }

    /**
     * Table_node::getInfoById()
     *
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        global $mypdo;

        $id = $mypdo->sql_check_input(array('number', $id));

        $sql = "select * from ".$mypdo->prefix."node where node_id = $id limit 1";

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
     * Table_node::add() 添加
     *
     * @param array $Attr
     * 
     *
     * @return
     */
    static public function add($Attr){
        global $mypdo;

        $title              = $Attr['title'];
        $jing               = $Attr['jing'];
        $wei                = $Attr['wei'];
        $createtime         = time();

        $param = array (
            'node_title'             => array('string',$title),
            'node_jing'              => array('string', $jing),
            'node_wei'               => array('string', $wei),
            'node_createtime'        => array('number',$createtime)

        );
//        var_dump($param);

        return $mypdo->sqlinsert($mypdo->prefix.'node', $param);
    }


    /**
     * Table_node::edit() 修改
     * @param int   $id
     * @param array $Attr
     * 
     *
     * @return
     */
    static public function edit($id, $Attr){
        global $mypdo;

         $title              = $Attr['title'];
         $jing               = $Attr['jing'];
         $wei                = $Attr['wei'];

        $param = array (

             'node_title'             => array('string',$title),
             'node_jing'              => array('string', $jing),
             'node_wei'               => array('string', $wei)
        
        );
        $where = array(
            'node_id'        => array('number', $id)
        );

        return $mypdo->sqlupdate($mypdo->prefix.'node', $param, $where);
    }

    /**
     * Table_node::del() 删除
     *
     * @param mixed $id
     * @return
     */
    static public function del($id){
        global $mypdo;

        $where = array(
            'node_id' => array('number', $id)
        );

        return $mypdo->sqldelete($mypdo->prefix.'node', $where);
    }
    /**
     * Table_node::getList()    节点列表
     * 
     * @param int $page         当前页
     * @param int $pagesize     每页数量
     * @return
     */
    static public function getList(){
        global $mypdo;
        
        $sql = "select * from ".$mypdo->prefix."node where 1=1 ";
        $sql .= " order by node_id desc  ";
               
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
     * Table_node::search()搜索
     *
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function search($page = 1, $pagesize = 10, $title='' ,$count = 0){
        global $mypdo, $mylog;

        $page     = $mypdo->sql_check_input(array('number', $page));
        $pagesize = $mypdo->sql_check_input(array('number', $pagesize));

        $title = "%$title%";
        $title  = $mypdo->sql_check_input(array('string', $title));

        $startrow = ($page - 1) * $pagesize;
        $sql = "select * from ".$mypdo->prefix."node where 1=1 ";
        $sql .= " and node_title like $title ";
        //var_dump($sql);
        if($count){

            $r = $mypdo->sqlQuery($sql);
            return count($r);

        }else{
            $sql .= " order by node_id desc limit $startrow, $pagesize";

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