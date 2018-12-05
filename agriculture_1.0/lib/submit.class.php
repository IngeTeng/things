<?php

/**
 * Submit.class.php 工单类
 *
 * @version       v0.01
 * @create time   2016/04/16
 * @update time   
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */
class Submit {
    
    public function __construct() {
    }
    
    /**
     *Submit::getInfoById()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        if(empty($id)) throw new MyException('ID不能为空', 101);
        
        return Table_submit::getInfoById($id);
    }
    
    /**
     * Submit::add()
     * 
     * @param array $submitAttr
     * $submitAttr数组键：weixin_openid, name, hospital, section, position, desc, phone,  createtime
     * 
     * @return void
     */
    static public function add($submitAttr = array()){
        
        //参数较多，校验较多。而且添加和修改的操作校验相同。所以单独做个函数
        $okAttr = self::checkSubmitInputParam($submitAttr);

        $rs = Table_submit::add($okAttr);

        if($rs > 0){
            //记录管理员日志log表
            //$msg = '成功提交工单('.$okAttr['id'].')';
            
            return action_msg('成功提交工单', 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }
    
    
    /**
     * submit::edit()
     * 
     * @param mixed $id
     * @param array $submitAttr
     * $submitAttr数组键：weixin_openid, name, hospital, section, position, desc, phone
     * 
     * @return
     */
    static public function edit($id, $submitAttr){
        
        if(empty($id)) throw new MyException('ID不能为空', 100);
        $submitAttr['replay']   = ckReplace($submitAttr['replay']);//    
        $rs = Table_submit::edit($id, $submitAttr);
        
        if($rs >= 0){
            $msg = '成功处理工单('.$id.')';
            Adminlog::add($msg);
            
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }
    
    /**
     * Submit::checkSubmitInputParam()
     * 
     * @param array $SubmitAttr
     * 
     * @return void
     */
    static private function checkSubmitInputParam($submitAttr){
        if(empty($submitAttr) || !is_array($submitAttr)) throw new MyException('参数错误', 100);
        
        if(empty($submitAttr['desc'])) throw new MyException('工单内容不能为空', 100);     
        return $submitAttr;
    }

    /**
     * Submit::getList()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function getList($page = 1, $pagesize = 10,$count=0){
        
        if(!preg_match('/^\d+$/', $page)) $page = 1;
        if(!preg_match('/^\d+$/', $pagesize)) $pagesize = 10;
        
        return Table_submit::getList($page, $pagesize,$count=0);
    }

    /**
     *Submit::getAllList()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function getAllList(){
        
        
        return Table_submit::getAllList();
    }
    
    /**
     * Submit::getCount()
     * 
     * @param integer $sort
     * @param integer $status
     * @return
     */
    static public function getCount(){
        
        return Table_submit::getCount();

    }

     


    
    /**
     * Submit::del()
     * 
     * @param mixed $id
     * @return
     */
    static public function del($id){

        if(empty($id))throw new MyException('ID不能为空', 101);

        
        
        $rs = Table_submit::del($id);
        if($rs == 1){
            //TODO 删除新闻将图片删除
            
            $msg = '删除工单('.$id.')成功!';
            Adminlog::add($msg);
            
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 102);
        }
    }
    
    
    /**
     * Submit::search()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @param integer $sort
     * @param integer $status
     * @param integer $count //是否仅作统计 1 - 统计
     * @return
     */
    static public function search($page = 1, $pagesize = 10, $only='',$count = 0){

        if(!preg_match('/^\d+$/', $page)) $page = 1;
        if(!preg_match('/^\d+$/', $pagesize)) $pagesize = 10;
        
        return Table_submit::search($page, $pagesize,$only,$count);
    }
}
?>