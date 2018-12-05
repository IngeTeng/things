<?php

/**
 * table_category.class.php 分类表
 *
 * @version       $Id$ v0.01
 * @createtime    2016/4/16
 * @updatetime    
 *  @author        IngeTeng
 * @copyright     Neptune工作室
 */

class Table_category extends Table{
    
    /**
     * Table_category::struct()  数组转换
     * 
     * @param array $data
     * 
     * @return $r
     */
    static protected function struct($data){
        $r = array();
     
        $r['id']                 = $data['category_id'];
        $r['title']              = $data['category_title'];//分类名称
        $r['pic']                = $data['category_pic'];//图片
        $r['parent']             = $data['category_parent'];//分类上一级分类
        $r['createtime']         = $data['category_createtime'];//添加时间 
        return $r;
    }

    /**
     * Table_category::getInfoById()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        global $mypdo;
        
        $id = $mypdo->sql_check_input(array('number', $id));
        
        $sql = "select * from ".$mypdo->prefix."category where category_id = $id limit 1";
        
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
     * Table_category::getInfoByParent()
     *
     * @param mixed $parent
     * @return
     */
    static public function getInfoByParent($parent){
        global $mypdo;

        $parent = $mypdo->sql_check_input(array('number', $parent));

        $sql = "select * from ".$mypdo->prefix."category where category_parent = $parent";
        $sql .= " order by category_id desc";

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
     * Table_category::add() 添加分类
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
        $pic                   = $Attr['pic'];
        $parent                = $Attr['parent'];

        $param = array (

            'category_title'            => array('string', $title),
            'category_pic'              => array('string', $pic),
            'category_parent'           => array('number', $parent),
            'category_createtime'       => array('number', $createtime)
        );
            
        return $mypdo->sqlinsert($mypdo->prefix.'category', $param); 
    }

    
    /**
     * Table_category::edit() 修改分类信息
     * 
     * @param int   $id
     * @param array $Attr
     * $Attr数组键： name,  desc
     * 
     * @return
     */
    static public function edit($id, $Attr){ 
        global $mypdo;
        
        $title                = $Attr['title'];
        $pic                  = $Attr['pic'];
        $parent               = $Attr['parent'];
    

       $param = array (
            'category_title'            => array('string', $title),
            'category_pic'              => array('string', $pic),
            'category_parent'           => array('number', $parent)
            );
        $where = array(
            'category_id'              => array('number', $id)
        );
            
        return $mypdo->sqlupdate($mypdo->prefix.'category', $param, $where); 
    }

    /**
     * Table_category::del() 删除分类信息
     * 
     * @param mixed $id
     * @return
     */
    static public function del($id){
        global $mypdo;
        
        $where = array(
            'category_id' => array('number', $id)
        );

        return $mypdo->sqldelete($mypdo->prefix.'category', $where);
    }

    
   
    
    /**
     * Table_category::getList()    分类列表
     * 
     * @param int $page         当前页
     * @param int $pagesize     每页数量
     * @return
     */
    static public function getList($page=1 , $pagesize=10){
        global $mypdo;
        
    
        $sql = "select * from ".$mypdo->prefix."category where 1=1 ";
    
        $sql .= " order by category_id desc ";
        
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
      * Table_category::getCount()  分类数量统计
      * 
      * @return
      */
     static public function getCount(){
        global $mypdo;
        
        $sql = "select count(*) as ct from ".$mypdo->prefix."category where 1=1";

        $r = $mypdo->sqlQuery($sql);
        if($r){
            return $r[0]['ct'];
        }else{
            return 0;
        }
    }
    
    
    /**
     * Table_category::search() 分类搜索
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
        
        $sql = "select * from ".$mypdo->prefix."category where 1=1 ";
        $sql .= " and category_title like $title ";
    
        if($count){
            
            $r = $mypdo->sqlQuery($sql);

            return count($r);

        }else{
            $sql .= " order by category_id asc limit $startrow, $pagesize";
          
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
                $val['title'] = str_repeat($p, $num).$val['title'];
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
            $options[$cate['id']] = $cate['title'];
        }
        return $options;
    }

   static  public function getTreeLsit($data){

        $tree = self::getTree($data);
        var_dump($tree);
        return $tree = self::setPrefix($tree);

    }


 /**
     * Table_category::getInfoByName() 根据名称查询分类详情
     * 
     * @param string $groupname  管理员组名
     * 
     * @return
     */
    static public function getInfoByName($title,$parent){
        global $mypdo;
        
        $title = $mypdo->sql_check_input(array('string', $title));
        $parent= $mypdo->sql_check_input(array('number', $parent));
        $sql = "select * from ".$mypdo->prefix."category where category_title = $title and category_parent=$parent limit 1";
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
     * Table_category::getCombo_cateCount() 套餐总数
     * 
     * @param interger $id   管理组ID
     * 
     * @return
     */
    static public function getCategoryCount($id){
        global $mypdo;
        
        $id = $mypdo->sql_check_input(array('number', $id));

        $sql = "select count(*) as ct from ".$mypdo->prefix."product where product_cateid = $id";
        $r = $mypdo->sqlQuery($sql);
        if($r){
            return $r[0]['ct'];
        }else{
            return -1;
        }
    }


     /**
     * Table_combo_cate::getCategory_Count() 分类总数
     * 
     * @param interger $id   管理组ID
     * 
     * @return
     */
    static public function getCategory_Count($id){
        global $mypdo;
        
        $id = $mypdo->sql_check_input(array('number', $id));

        $sql = "select count(*) as ct from ".$mypdo->prefix."category where category_parent = $id";
        $r = $mypdo->sqlQuery($sql);
        if($r){
            return $r[0]['ct'];
        }else{
            return -1;
        }
    }
    

}
?>