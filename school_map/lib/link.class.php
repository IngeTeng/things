<?php

/**
 * link.class.php 节点路径
 *
 * @version       v0.01
 * @create time   2016/04/16
 * @update time   
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

class Link {
    public  $id    = 0;   //ID
    public function __construct($id = 0) {

        if(empty($id)) {
            throw new MyException('ID不能为空', 901);
        }else{
            $link = self::getInfoById($id);
            if($link){
                $this->id  = $id;
            }else{
                throw new MyException('该节点不存在', 902);
            }
            
        }
    }
    
    /**
     *Link::getInfoById()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
       
        
        return Table_link::getInfoById($id);
        
    }
    
    /**
     * Link::add()
     * 
     * @param array $linkAttr
     * $combo_Attr数组键： name, desc,   createtime
     * 
     * @return void
     */
    static public function add($linkAttr = array()){
        
        //参数较多，校验较多。而且添加和修改的操作校验相同。所以单独做个函数
        $okAttr = self::checkLinkInputParam($linkAttr);
        $title = Table_link::getInfoByName($linkAttr['title'],$linkAttr['parent']);
        if($title) throw new MyException('该分类已存在', 104);
        $rs = Table_link::add($okAttr);

        if($rs > 0){
            //记录管理员日志log表
            $msg = '成功添加节点路径('.$okAttr['title'].')';
            Adminlog::add($msg);
            
            return action_msg('添加路径成功', 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }
    
    
    /**
     * Link::edit()
     * 
     * @param mixed $id
     * @param array $linkAttr
     * $imgcateAttr数组键： name, desc 
     * 
     * @return
     */
    static public function edit($id, $linkAttr){
        
        if(empty($id)) throw new MyException('ID不能为空', 100);
        $title = Table_link::getInfoByName($linkAttr['title'],$linkAttr['parent']);
        if($title && $title['id'] != $id) throw new MyException('该分类已存在', 104);
        $okAttr = self::checkLinkInputParam($linkAttr);
        
        $rs = Table_link::edit($id, $okAttr);
        
        if($rs >= 0){
            $msg = '成功修改路径信息('.$id.')';
            Adminlog::add($msg);
            
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }
    
    /**
     * Link::checkLinkInputParam()
     * 
     * @param array $combo_cateAttr
     * 
     * @return void
     */
    static private function checkLinkInputParam($LinkAttr){
        if(empty($LinkAttr) || !is_array($LinkAttr)) throw new MyException('参数错误', 100);
        
        if(empty($LinkAttr['title'])) throw new MyException('分类名称不能为空', 201);

       /* $name = Table_combo_cate::getInfoByName($combo_cateAttr['name']);
        if($name) throw new MyException('该分类已存在', 104);
        if(empty($combo_cateAttr['money'])) throw new MyException('套餐金额不能为空', 202);*/
        //if(empty($combo_cateAttr['parent']==-1)) throw new MyException('上级分类不能为空',       
        return $LinkAttr;
    }

    /**
     * Link::getList()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function getList(){
        
        
        return Table_link::getList();
    }
    
    /**
     * Link::getCount()
     * 
     * @param integer $sort
     * @param integer $status
     * @return
     */
    static public function getCount(){
        
        return Table_link::getCount();
    }
    

    
    
    /**
     * Link::del()
     * 
     * @param mixed $id
     * @return
     */
    static public function del($id){

        if(empty($id))throw new MyException('ID不能为空', 101);


       if(self::getLink_Count($id) > 0)  throw new MyException('该路径节点有其他路径节点。请先删除子节点。', 103);
        
        $rs = Table_link::del($id);
        if($rs == 1){
            //TODO 删除图片分类
            
            $msg = '删除路径节点('.$id.')成功!';
            Adminlog::add($msg);
            
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 102);
        }
    }
    
    
    /**
     * Link::search()
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
        
        return Table_link::search($page, $pagesize, $title,$count);
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
        $options = ['初始节点'];
        foreach ($tree as $cate) {
            # code...
            $options[$cate['id']] = $cate['node_title'];
        }
        return $options;
    }

   static  public function getTreeLsit($data){

        $tree = self::getTree($data);
        return $tree = self::setPrefix($tree);

    }

    /**
     * Table_link::getlinkCount() 数量
     * 
     * @param integer $gid   管理员组ID
     * 
     * @return
     */
    static public function getLinkCount($id = 0){

        return Table_link::getLinkCount($id);
    }

    /**
     * Table_link::getLink_Count() 分类数量
     * 
     * @param integer $gid   管理员组ID
     * 
     * @return
     */
    static public function getLink_Count($id = 0){

        return Table_link::getLink_Count($id);
    }

}
?>