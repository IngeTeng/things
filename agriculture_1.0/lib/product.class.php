<?php

/**
 * Product.class.php 商品类
 *
 * @version       v0.01
 * @create time   2016/04/16
 * @update time   
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */
class Product {
    
    public function __construct() {
    }
    
    /**
     *Product::getInfoById()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        if(empty($id)) throw new MyException('ID不能为空', 101);
        
        return Table_product::getInfoById($id);
    }
    
    /**
     * Product::add()
     * 
     * @param array $ProductAttr
     * $ProductAttr数组键：weixin_openid, name, hospital, section, position, desc, phone,  createtime
     * 
     * @return void
     */
    static public function add($productAttr = array()){
        
        //参数较多，校验较多。而且添加和修改的操作校验相同。所以单独做个函数
        $okAttr = self::checkProductInputParam($productAttr);

        $rs = Table_product::add($okAttr);

        if($rs > 0){
            //记录管理员日志log表
            $msg = '成功添加商品('.$okAttr['title'].')';
            //Adminlog::add($msg);
            
            return action_msg('添加商品成功', 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }
    
    
    /**
     * Product::edit()
     * 
     * @param mixed $id
     * @param array $ProductAttr
     * $ProductAttr数组键：weixin_openid, name, hospital, section, position, desc, phone
     * 
     * @return
     */
    static public function edit($id, $productAttr){
        
        if(empty($id)) throw new MyException('ID不能为空', 100);
        
        $okAttr = self::checkProductInputParam($productAttr);
        
        $rs = Table_product::edit($id, $okAttr);
        
        if($rs >= 0){
            $msg = '成功修改商品信息('.$id.')';
            //Adminlog::add($msg);
            
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }

    /**
     * Product::edit()
     * 
     * @param mixed $id
     * @param array $ProductAttr
     * $ProductAttr数组键：weixin_openid, name, hospital, section, position, desc, phone
     * 
     * @return
     */
    static public function edit_desc($id, $productAttr){
        
        if(empty($id)) throw new MyException('ID不能为空', 100);
        
        $okAttr = self::checkProduct_descInputParam($productAttr);
        
        $rs = Table_product::edit_desc($id, $okAttr);
        
        if($rs >= 0){
            $msg = '成功修改商品信息';
            //Adminlog::add($msg,$role);
            
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }
    
    /**
     * Product::checkProductInputParam()
     * 
     * @param array $ProductAttr
     * 
     * @return void
     */
    static private function checkProductInputParam($ProductAttr){
        if(empty($ProductAttr) || !is_array($ProductAttr)) throw new MyException('参数错误', 100);
        if(empty($ProductAttr['title'])) throw new MyException('商品名称不能为空', 201);
        if(empty($ProductAttr['cateid'])) throw new MyException('商品分类不能为空', 201);
        if(empty($ProductAttr['num'])) throw new MyException('商品数量不能为空', 202);
        if(empty($ProductAttr['pic'])) throw new MyException('商品图片不能为空', 203);
        if(empty($ProductAttr['price'])) throw new MyException('商品价格不能为空', 204); 
        $ProductAttr['desc'] = ckReplace($ProductAttr['desc']);//      
        return $ProductAttr;
    }
     /**
     * Product::checkProductInputParam()
     * 
     * @param array $ProductAttr
     * 
     * @return void
     */
    static private function checkProduct_descInputParam($ProductAttr){
        if(empty($ProductAttr) || !is_array($ProductAttr)) throw new MyException('参数错误', 100);
        if(empty($ProductAttr['title'])) throw new MyException('商品名称不能为空', 201);
        if(empty($ProductAttr['cateid'])) throw new MyException('商品分类不能为空', 201);
        if(empty($ProductAttr['num'])) throw new MyException('商品数量不能为空', 202);
        if(empty($ProductAttr['pic'])) throw new MyException('商品图片不能为空', 203);
        if(empty($ProductAttr['price'])) throw new MyException('商品价格不能为空', 204); 
        //$ProductAttr['desc'] = ckReplace($ProductAttr['desc']);//      
        return $ProductAttr;
    }

    /**
     * Product::getList()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function getList($page = 1, $pagesize = 10,$count=0){
        
        if(!preg_match('/^\d+$/', $page)) $page = 1;
        if(!preg_match('/^\d+$/', $pagesize)) $pagesize = 10;
        
        return Table_product::getList($page, $pagesize,$count=0);
    }

    /**
     *Product::getAllList()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function getAllList(){
        
        
        return Table_product::getAllList();
    }
    
    /**
     * Product::getCount()
     * 
     * @param integer $sort
     * @param integer $status
     * @return
     */
    static public function getCount(){
        
        return Table_product::getCount();

    }
    
     /**
     * Product::checkParamCategory()
     * 
     * @param mixed $sort
     * @return void
     */ 
    
    static private function checkParamCategory($cateid){
        if(!preg_match('/^\d+$/', $cateid)) throw new MyException('cateid必须为正整数', 101);
        
        $r = Table_category::getInfoById($cateid);
        if(empty($r)) {
            throw new MyException('分类不存在', 102);
        }
    }
     



    /**
     * Product::getHotName()
     * 
     * @param mixed $status
     * @return
     */
    static public function getStateName($state){
        switch($state){
            case 0:
                return '否';
            break;
            
            case 1:
                return '是';
            break;
    
            default:
                return false;
            break;
        }
    }

    /**
     * Product::getAdd_role_cateName()
     * 
     * @param mixed $status
     * @return
     */
    static public function getAdd_role_cateName($state){
        switch($state){
            case 2:
                return '分销商';
            break;
            
            case 1:
                return '平台管理员';
            break;
    
            default:
                return false;
            break;
        }
    }

    
    /**
     * Product::del()
     * 
     * @param mixed $id
     * @return
     */
    static public function del($id){

        if(empty($id))throw new MyException('ID不能为空', 101);

        
        
        $rs = Table_product::del($id);
        if($rs == 1){
            //TODO 删除新闻将图片删除
            
            $msg = '删除商品('.$id.')成功!';
            //Adminlog::add($msg);
            
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 102);
        }
    }
    /**
     * Product::del()
     * 
     * @param mixed $id
     * @return
     */
    static public function del_front($id){

        if(empty($id))throw new MyException('ID不能为空', 101);

        
        
        $rs = Table_product::del($id);
        if($rs == 1){
            //TODO 删除新闻将图片删除
            
            $msg = '删除商品成功!';
            //Adminlog::add($msg);
            
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 102);
        }
    }
    
    /**
     * Product::search()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @param integer $sort
     * @param integer $status
     * @param integer $count //是否仅作统计 1 - 统计
     * @return
     */
    static public function search($page = 1, $pagesize = 10, $cateid=0, $add_role='',$title='',$count = 0){
        if(!empty($cateid)) {
            self::checkParamCategory($cateid);
        }

        if(!preg_match('/^\d+$/', $page)) $page = 1;
        if(!preg_match('/^\d+$/', $pagesize)) $pagesize = 10;
        
        return Table_product::search($page, $pagesize,$cateid, $add_role,$title,$count);
    }


    static public function search_phone($page = 1, $pagesize = 10, $phone,$cateid=0,$title='',$count = 0){
        if(!empty($cateid)) {
            self::checkParamCategory($cateid);
        }

        if(!preg_match('/^\d+$/', $page)) $page = 1;
        if(!preg_match('/^\d+$/', $pagesize)) $pagesize = 10;
        
        return Table_product::search_phone($page, $pagesize,$phone,$cateid, $title,$count);
    }
}
?>