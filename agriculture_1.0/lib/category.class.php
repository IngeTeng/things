<?php

/**
 * cate.class.php 套餐分类
 *
 * @version       v0.01
 * @create time   2016/04/16
 * @update time   
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

class Category {
    public  $id    = 0;   //ID
    public function __construct($id = 0) {

        if(empty($id)) {
            throw new MyException('ID不能为空', 901);
        }else{
            $cate = self::getInfoById($id);
            if($cate){
                $this->id  = $id;
            }else{
                throw new MyException('该分类不存在', 902);
            }
            
        }
    }
    
    /**
     *Imgcate::getInfoById()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
       
        
        return Table_category::getInfoById($id);
        
    }
    
    /**
     * Category::add()
     * 
     * @param array $categoryAttr
     * $combo_Attr数组键： name, desc,   createtime
     * 
     * @return void
     */
    static public function add($categoryAttr = array()){
        
        //参数较多，校验较多。而且添加和修改的操作校验相同。所以单独做个函数
        $okAttr = self::checkCategoryInputParam($categoryAttr);
        $title = Table_category::getInfoByName($categoryAttr['title'],$categoryAttr['parent']);
        if($title) throw new MyException('该分类已存在', 104);
        $rs = Table_category::add($okAttr);

        if($rs > 0){
            //记录管理员日志log表
            $msg = '成功添加分类('.$okAttr['title'].')';
            Adminlog::add($msg);
            
            return action_msg('添加分类成功', 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }
    
    
    /**
     * Category::edit()
     * 
     * @param mixed $id
     * @param array $categoryAttr
     * $imgcateAttr数组键： name, desc 
     * 
     * @return
     */
    static public function edit($id, $categoryAttr){
        
        if(empty($id)) throw new MyException('ID不能为空', 100);
        $title = Table_category::getInfoByName($categoryAttr['title'],$categoryAttr['parent']);
        if($title && $title['id'] != $id) throw new MyException('该分类已存在', 104);
        $okAttr = self::checkCategoryInputParam($categoryAttr);
        
        $rs = Table_category::edit($id, $okAttr);
        
        if($rs >= 0){
            $msg = '成功修改分类信息('.$id.')';
            Adminlog::add($msg);
            
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }
    
    /**
     * Category::checkCategoryInputParam()
     * 
     * @param array $combo_cateAttr
     * 
     * @return void
     */
    static private function checkCategoryInputParam($CategoryAttr){
        if(empty($CategoryAttr) || !is_array($CategoryAttr)) throw new MyException('参数错误', 100);
        
        if(empty($CategoryAttr['title'])) throw new MyException('分类名称不能为空', 201);

       /* $name = Table_combo_cate::getInfoByName($combo_cateAttr['name']);
        if($name) throw new MyException('该分类已存在', 104);
        if(empty($combo_cateAttr['money'])) throw new MyException('套餐金额不能为空', 202);*/
        //if(empty($combo_cateAttr['parent']==-1)) throw new MyException('上级分类不能为空',       
        return $CategoryAttr;
    }

    /**
     * Category::getList()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function getList(){
        
        
        return Table_category::getList();
    }
    
    /**
     * Category::getCount()
     * 
     * @param integer $sort
     * @param integer $status
     * @return
     */
    static public function getCount(){
        
        return Table_category::getCount();
    }
    

    
    
    /**
     * Category::del()
     * 
     * @param mixed $id
     * @return
     */
    static public function del($id){

        if(empty($id))throw new MyException('ID不能为空', 101);

        if(self::getCategoryCount($id) > 0)  throw new MyException('该分类下套餐。请先删除套餐。', 103);

       if(self::getCategory_Count($id) > 0)  throw new MyException('该分类有其他分类。请先删除分类。', 103);
        
        $rs = Table_category::del($id);
        if($rs == 1){
            //TODO 删除图片分类
            
            $msg = '删除商品分类('.$id.')成功!';
            Adminlog::add($msg);
            
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 102);
        }
    }
    
    
    /**
     * Category::search()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @param integer $sort
     * @param integer $status
     * @param integer $count //是否仅作统计 1 - 统计
     * @return
     */
    static public function search($page = 1, $pagesize = 10, $title='',$count = 0){
   
        if(!preg_match('/^\d+$/', $page)) $page = 1;
        if(!preg_match('/^\d+$/', $pagesize)) $pagesize = 10;
        
        return Table_category::search($page, $pagesize, $title,$count);
    }



    static public function getTree($cates , $parent=0){

        $tree =[];
        if(!empty($cates)) {
            foreach ($cates as $cate) {
                if ($cate['parent'] == $parent) {

                    $tree[] = $cate;
                    $tree = array_merge($tree, self::getTree($cates, $cate['id']));
                }
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
        $options = ['顶级分类'];
        foreach ($tree as $cate) {
            # code...
            $options[$cate['id']] = $cate['title'];
        }
        return $options;
    }

   static  public function getTreeLsit($data){

        $tree = self::getTree($data);
        return $tree = self::setPrefix($tree);

    }

    /**
     * Table_category::getcategoryCount() 数量
     * 
     * @param integer $gid   管理员组ID
     * 
     * @return
     */
    static public function getCategoryCount($id = 0){

        return Table_category::getCategoryCount($id);
    }

    /**
     * Table_category::getCategory_Count() 分类数量
     * 
     * @param integer $gid   管理员组ID
     * 
     * @return
     */
    static public function getCategory_Count($id = 0){

        return Table_category::getCategory_Count($id);
    }

}
?>