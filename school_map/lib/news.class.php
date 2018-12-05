<?php

/**
 * news.class.php 新闻类
 *
 * @version       v0.01
 * @create time   2016/04/16
 * @update time   
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */
class News {
    
    public function __construct() {
    }
    
    /**
     *news::getInfoById()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        if(empty($id)) throw new MyException('ID不能为空', 101);
        
        return Table_news::getInfoById($id);
    }
    
    /**
     * news::add()
     * 
     * @param array $newsAttr
     * $newsAttr数组键：weixin_openid, name, hospital, section, position, desc, phone,  createtime
     * 
     * @return void
     */
    static public function add($newsAttr = array()){
        
        //参数较多，校验较多。而且添加和修改的操作校验相同。所以单独做个函数
        $okAttr = self::checkNewsInputParam($newsAttr);

        $rs = Table_news::add($okAttr);

        if($rs > 0){
            //记录管理员日志log表
            $msg = '成功添加新闻('.$okAttr['title'].')';
            Adminlog::add($msg);
            
            return action_msg('添加新闻成功', 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }


     /**
     * news::update()
     * 
     * @param array $newsAttr
     * $newsAttr数组键：weixin_openid, name, hospital, section, position, desc, phone,  createtime
     * 
     * @return void
     */
    static public function update($newsAttr = array()){
        
        $$newsAttr = spider();

        $rs = Table_news::update($newsAttr);

        if($rs > 0){
            //记录管理员日志log表
            $msg = '成功添加新闻('.$okAttr['title'].')';
            Adminlog::add($msg);
            
            return action_msg('添加新闻成功', 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }
    
    
    /**
     * news::edit()
     * 
     * @param mixed $id
     * @param array $newsAttr
     * $newsAttr数组键：weixin_openid, name, hospital, section, position, desc, phone
     * 
     * @return
     */
    static public function edit($id, $newsAttr){
        
        if(empty($id)) throw new MyException('ID不能为空', 100);
        
        $okAttr = self::checkNewsInputParam($newsAttr);
        
        $rs = Table_news::edit($id, $okAttr);
        
        if($rs >= 0){
            $msg = '成功修改新闻信息('.$id.')';
            Adminlog::add($msg);
            
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }

   
    
    /**
     * news::checknewsInputParam()
     * 
     * @param array $newsAttr
     * 
     * @return void
     */
    static private function checkNewsInputParam($newsAttr){
        if(empty($newsAttr) || !is_array($newsAttr)) throw new MyException('参数错误', 100);
        if(empty($newsAttr['title'])) throw new MyException('新闻标题不能为空', 201);
        if(empty($newsAttr['pic'])) throw new MyException('新闻图片不能为空', 201);
        $newsAttr['desc'] = ckReplace($newsAttr['desc']);//      
        return $newsAttr;
    }
     

    /**
     * news::getList()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function getList($page = 1, $pagesize = 10,$count=0){
        
        if(!preg_match('/^\d+$/', $page)) $page = 1;
        if(!preg_match('/^\d+$/', $pagesize)) $pagesize = 10;
        
        return Table_news::getList($page, $pagesize,$count=0);
    }

    /**
     *news::getAllList()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function getAllList(){
        
        
        return Table_news::getAllList();
    }
    
    /**
     * news::getCount()
     * 
     * @param integer $sort
     * @param integer $status
     * @return
     */
    static public function getCount(){
        
        return Table_news::getCount();

    }
    
    
    /**
     * news::del()
     * 
     * @param mixed $id
     * @return
     */
    static public function del($id){

        if(empty($id))throw new MyException('ID不能为空', 101);

        
        
        $rs = Table_news::del($id);
        if($rs == 1){
            //TODO 删除新闻将图片删除
            
            $msg = '删除新闻('.$id.')成功!';
            Adminlog::add($msg);
            
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 102);
        }
    }
    
    
    /**
     * news::search()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @param integer $sort
     * @param integer $status
     * @param integer $count //是否仅作统计 1 - 统计
     * @return
     */
    static public function search($page = 1, $pagesize = 10, $title='', $count = 0){

        if(!preg_match('/^\d+$/', $page)) $page = 1;
        if(!preg_match('/^\d+$/', $pagesize)) $pagesize = 10;
        
        return Table_news::search($page, $pagesize,$title,$count);
    }


}
?>