<?php

/**
 * table_link.class.php 路径表
 *
 * @version       $Id$ v0.01
 * @createtime    2016/4/16
 * @updatetime    
 *  @author        IngeTeng
 * @copyright     Neptune工作室
 */

class Table_link extends Table{
    
    /**
     * Table_link::struct()  数组转换
     * 
     * @param array $data
     * 
     * @return $r
     */
    static protected function struct($data){
        $r = array();
     
        $r['id']                 = $data['link_id'];
        $r['title']              = $data['link_title'];
        $r['node_id']            = $data['link_node_id'];
        $r['node_title']         = $data['link_node_title'];
        $r['node_jing']          = $data['link_node_jing'];
        $r['node_wei']           = $data['link_node_wei'];
        $r['parent']             = $data['link_parent'];
        $r['createtime']         = $data['link_createtime'];//添加时间 
        return $r;
    }

    /**
     * Table_lin::getInfoById()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        global $mypdo;
        
        $id = $mypdo->sql_check_input(array('number', $id));
        
        $sql = "select * from ".$mypdo->prefix."link where link_id = $id limit 1";
        
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
     * Table_lin::getInfoById()
     * 
     * @param mixed $id
     * @return
     */
    static public function getTitle(){
        global $mypdo;
        
        
        
        $sql = "select link_title from ".$mypdo->prefix."link ";
        
        $rs = $mypdo->sqlQuery($sql);
        //var_dump($rs);
        return $rs;
    }
    
    
    /**
     * Table_link::add() 添加分类
     * 
     * @param array $Attr
     * $Attr数组键：name,money, parent, desc,createtime
     * 
     * @return
     */
    static public function add($Attr){ 
        global $mypdo;
    
        $createtime            = time();
        $title                 = $Attr['title'];
        $node_id               = $Attr['node_id'];
        $node_title            = $Attr['node_title'];
        $node_jing             = $Attr['node_jing'];
        $node_wei              = $Attr['node_wei'];
        $parent                = $Attr['parent'];

        $param = array (

            'link_title'            => array('string', $title),
            'link_node_id'          => array('number', $node_id),
            'link_node_title'       => array('string', $node_title),
            'link_node_jing'        => array('string', $node_jing),
            'link_node_wei'         => array('string', $node_wei),
            'link_parent'           => array('number', $parent),
            'link_createtime'       => array('number', $createtime)
        );
            
        return $mypdo->sqlinsert($mypdo->prefix.'link', $param); 
    }

    
    /**
     * Table_link::edit() 修改分类信息
     * 
     * @param int   $id
     * @param array $Attr
     * $Attr数组键： name,  desc
     * 
     * @return
     */
    static public function edit($id, $Attr){ 
        global $mypdo;
        
        $title                 = $Attr['title'];
        $node_id               = $Attr['node_id'];
        $node_title            = $Attr['node_title'];
        $node_jing             = $Attr['node_jing'];
        $node_wei              = $Attr['node_wei'];
        $parent                = $Attr['parent'];
    

       $param = array (
            'link_title'            => array('string', $title),
            'link_node_id'          => array('number', $node_id),
            'link_node_title'       => array('string', $node_title),
            'link_node_jing'        => array('string', $node_jing),
            'link_node_wei'         => array('string', $node_wei),
            'link_parent'           => array('number', $parent)
            );
        $where = array(
            'link_id'              => array('number', $id)
        );
            
        return $mypdo->sqlupdate($mypdo->prefix.'link', $param, $where); 
    }

    /**
     * Table_link::del() 删除分类信息
     * 
     * @param mixed $id
     * @return
     */
    static public function del($id){
        global $mypdo;
        
        $where = array(
            'link_id' => array('number', $id)
        );

        return $mypdo->sqldelete($mypdo->prefix.'link', $where);
    }

    
   
    
    /**
     * Table_link::getList()    分类列表
     * 
     * @param int $page         当前页
     * @param int $pagesize     每页数量
     * @return
     */
    static public function getList($page=1 , $pagesize=10){
        global $mypdo;
        
    
        $sql = "select * from ".$mypdo->prefix."link where 1=1 ";
    
        $sql .= " order by link_id desc ";
        
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
      * Table_link::getCount()  分类数量统计
      * 
      * @return
      */
     static public function getCount(){
        global $mypdo;
        
        $sql = "select count(*) as ct from ".$mypdo->prefix."link where 1=1";

        $r = $mypdo->sqlQuery($sql);
        if($r){
            return $r[0]['ct'];
        }else{
            return 0;
        }
    }

    /**
      * Table_link::getCount()  分类数量统计
      * 
      * @return
      */
     static public function getCount_Bytitle($title=''){
        global $mypdo;
        $title    = "%$title%";
        $sql = "select count(*) as ct from ".$mypdo->prefix."link where 1=1";
         $sql .= " and link_title like $title ";
        $r = $mypdo->sqlQuery($sql);
        if($r){
            return $r[0]['ct'];
        }else{
            return 0;
        }
    }
    /**
     * Table_link::search() 分类搜索
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */

    static public function search_Bytitle( $title=''){
        global $mypdo, $mylog;
        
        
        $title    = "%$title%";
        $title    = $mypdo->sql_check_input(array('string', $title));
        
        $sql = "select * from ".$mypdo->prefix."link where 1=1 ";
        $sql .= " and link_title like $title ";
        //$sql .= " and link_title = $title "
        if($count){
            
            $r = $mypdo->sqlQuery($sql);

            return count($r);

        }else{
            $sql .= " order by link_id asc limit 1 ";
          
            $rs = $mypdo->sqlQuery($sql);
            //$r = Combo_cate::getList();
            //var_dump($rs);
            if($rs){
                $r = array();
                foreach($rs as $key => $val){
                    $r[$key] = self::struct($val);
                }
                //var_dump($r);
                //$r1 = self::getTreeLsit($r);
                //var_dump($r);
                return $r;
            }else{
                return 0;
            } 
            
        }
        
        
    }
    
    /**
     * Table_link::search() 分类搜索
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */

    static public function search($page = 1, $pagesize = 10 ,$title='',$count = 0){
        global $mypdo, $mylog;
        
        $page     = $mypdo->sql_check_input(array('number', $page));
        $pagesize = $mypdo->sql_check_input(array('number', $pagesize));
        
        $title    = "%$title%";
        $title    = $mypdo->sql_check_input(array('string', $title));
        
        $startrow = ($page - 1) * $pagesize;
        
        $sql = "select * from ".$mypdo->prefix."link where 1=1 ";
        $sql .= " and link_title like $title ";
    
        if($count){
            
            $r = $mypdo->sqlQuery($sql);

            return count($r);

        }else{
            $sql .= " order by link_id asc limit $startrow, $pagesize";
          
            $rs = $mypdo->sqlQuery($sql);
            //$r = Combo_cate::getList();
            //var_dump($rs);
            if($rs){
                $r = array();
                foreach($rs as $key => $val){
                    $r[$key] = self::struct($val);
                }
                //var_dump($r);
                //$r1 = self::getTreeLsit($r);
                //var_dump($r);
                return $r;
            }else{
                return 0;
            } 
            
        }
        
        
    }


    static public function getTree($cates , $parent=0){

        $tree =[];
        foreach($cates as $cate){
            if($cate['parent'] == $parent){

                $tree[] = $cate;
                $tree = array_merge($tree , self::getTree($cates , $cate['id']));
            }
        } 
        return $tree;   
    }

    static public function setPrefix($data , $p ="|----"){
            $tree =[];
            $num = 1;
            $prefix = [0 => 1];
            while($val = current($data)){

                $key = key($data);
                //如果是下一级目录就加一
                if($key >0){
                    if($data[$key -1]['parent'] != $val['parent']){
                        $num ++;
                    }
                }
                //如果是同级的目录就不变
                if(array_key_exists($val['parent'], $prefix)){    

                    /*bool array_key_exists ( mixed $key , array $search )
                    $key代表的是检索的关键字
                    $search带检索的数据*/

                    $num = $prefix[$val['parent']];
                    
                }
                $val['node_title'] = str_repeat($p, $num).$val['node_title'];
                $prefix[$val['parent']] = $num;
                $tree[] = $val;
                next($data);
            }
            return $tree;


    } 

   static  public function getOptions($data){

        $tree = self::getTree($data);
        $tree = self::setPrefix($tree);
        $options = ['添加顶级分类'];
        foreach ($tree as $cate) {
            # code...
            $options[$cate['id']] = $cate['node_title'];
        }
        return $options;
    }

   static  public function getTreeLsit($data){

        $tree = self::getTree($data);
        var_dump($tree);
        return $tree = self::setPrefix($tree);

    }


 /**
     * Table_link::getInfoByName() 根据名称查询分类详情
     * 
     * @param string $groupname  管理员组名
     * 
     * @return
     */
    static public function getInfoByName($title,$parent){
        global $mypdo;
        
        $title = $mypdo->sql_check_input(array('string', $title));
        $parent= $mypdo->sql_check_input(array('number', $parent));
        $sql = "select * from ".$mypdo->prefix."link where link_title = $title and link_parent=$parent limit 1";
        $rs  = $mypdo->sqlQuery($sql);
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
     * Table_combo_cate::getlink_Count() 分类总数
     * 
     * @param interger $id   管理组ID
     * 
     * @return
     */
    static public function getLink_Count($id){
        global $mypdo;
        
        $id = $mypdo->sql_check_input(array('number', $id));

        $sql = "select count(*) as ct from ".$mypdo->prefix."link where link_parent = $id";
        $r = $mypdo->sqlQuery($sql);
        if($r){
            return $r[0]['ct'];
        }else{
            return -1;
        }
    }
    

}
?>