<?php

/**
 * suggest.class.php 留言类
 *
 * @version       v0.01
 * @create time   2016/04/16
 * @update time   
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */
class Suggest {
    
    public function __construct() {
    }
    
    /**
     *suggest::getInfoById()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        if(empty($id)) throw new MyException('ID不能为空', 101);
        
        return Table_suggest::getInfoById($id);
    }
    
    /**
     * suggest::add()
     * 
     * @param array $suggestAttr
     * $suggestAttr数组键：weixin_openid, name, hospital, section, position, desc, phone,  createtime
     * 
     * @return void
     */
    static public function add($suggestAttr = array()){
        
        //参数较多，校验较多。而且添加和修改的操作校验相同。所以单独做个函数
        $okAttr = self::checkSuggestInputParam($suggestAttr);

        $rs = Table_suggest::add($okAttr);

        if($rs > 0){
            //记录管理员日志log表
            //$msg = '成功添加留言('.$okAttr['title'].')';
            //Adminlog::add($msg);
            
            return action_msg('添加留言成功', 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }
    
    

   
    
    /**
     * suggest::checksuggestInputParam()
     * 
     * @param array $suggestAttr
     * 
     * @return void
     */
    static private function checkSuggestInputParam($suggestAttr){
        if(empty($suggestAttr) || !is_array($suggestAttr)) throw new MyException('参数错误', 100);
        if(empty($suggestAttr['name'])) throw new MyException('姓名不能为空', 201);
        if(!empty($suggestAttr['phone'])){
            if(!is_mobile($suggestAttr['phone'])){
                throw new MyException('电话格式不正确', 206);
            }
        }else{
            throw new MyException('电话不能为空', 201);
        } 
        $suggestAttr['desc'] = ckReplace($suggestAttr['desc']);//      
        return $suggestAttr;
    }
     

    /**
     * suggest::getList()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function getList($page = 1, $pagesize = 10,$count=0){
        
        if(!preg_match('/^\d+$/', $page)) $page = 1;
        if(!preg_match('/^\d+$/', $pagesize)) $pagesize = 10;
        
        return Table_suggest::getList($page, $pagesize,$count=0);
    }

    /**
     *suggest::getAllList()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function getAllList(){
        
        
        return Table_suggest::getAllList();
    }
    
    /**
     * suggest::getCount()
     * 
     * @param integer $sort
     * @param integer $status
     * @return
     */
    static public function getCount(){
        
        return Table_suggest::getCount();

    }
    
    
    /**
     * suggest::del()
     * 
     * @param mixed $id
     * @return
     */
    static public function del($id){

        if(empty($id))throw new MyException('ID不能为空', 101);

        
        
        $rs = Table_suggest::del($id);
        if($rs == 1){
            //TODO 删除新闻将图片删除
            
            $msg = '删除留言('.$id.')成功!';
            Adminlog::add($msg);
            
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 102);
        }
    }
    
    
    /**
     * suggest::search()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @param integer $sort
     * @param integer $status
     * @param integer $count //是否仅作统计 1 - 统计
     * @return
     */
    static public function search($page = 1, $pagesize = 10, $name='', $phone='', $count = 0){

        if(!preg_match('/^\d+$/', $page)) $page = 1;
        if(!preg_match('/^\d+$/', $pagesize)) $pagesize = 10;
        
        return Table_suggest::search($page, $pagesize,$name, $phone,$count);
    }


}
?>