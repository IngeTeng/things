<?php

/**
 * notice.class.php 公告类
 *
 * @version       v0.01
 * @create time   2016/04/16
 * @update time   
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */
class Notice {
    
    public function __construct() {
    }
    
    /**
     *notice::getInfoById()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        if(empty($id)) throw new MyException('ID不能为空', 101);
        
        return Table_notice::getInfoById($id);
    }
    
    /**
     * notice::add()
     * 
     * @param array $noticeAttr
     * $noticeAttr数组键：weixin_openid, name, hospital, section, position, desc, phone,  createtime
     * 
     * @return void
     */
    static public function add($noticeAttr = array()){
        
        //参数较多，校验较多。而且添加和修改的操作校验相同。所以单独做个函数
        $okAttr = self::checkNoticeInputParam($noticeAttr);

        $rs = Table_notice::add($okAttr);

        if($rs > 0){
            //记录管理员日志log表
            $msg = '成功添加公告('.$okAttr['title'].')';
            Adminlog::add($msg);
            
            return action_msg('添加公告成功', 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }
      /**
     * notice::update()
     * 
     * @param array $newsAttr
     * $newsAttr数组键：weixin_openid, name, hospital, section, position, desc, phone,  createtime
     * 
     * @return void
     */
    static public function update($noticeAttr = array()){
        

        $rs = Table_notice::add($noticeAttr);

        if($rs > 0){
            //记录管理员日志log表
            $msg = '成功添加公告('.$okAttr['title'].')';
            Adminlog::add($msg);
            
            return action_msg('添加公告成功', 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }
    
    /**
     * notice::edit()
     * 
     * @param mixed $id
     * @param array $noticeAttr
     * $noticeAttr数组键：weixin_openid, name, hospital, section, position, desc, phone
     * 
     * @return
     */
    static public function edit($id, $noticeAttr){
        
        if(empty($id)) throw new MyException('ID不能为空', 100);
        
        $okAttr = self::checkNoticeInputParam($noticeAttr);
        
        $rs = Table_notice::edit($id, $okAttr);
        
        if($rs >= 0){
            $msg = '成功修改公告信息('.$id.')';
            Adminlog::add($msg);
            
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }

   
    
    /**
     * notice::checknoticeInputParam()
     * 
     * @param array $noticeAttr
     * 
     * @return void
     */
    static private function checknoticeInputParam($noticeAttr){
        if(empty($noticeAttr) || !is_array($noticeAttr)) throw new MyException('参数错误', 100);
        if(empty($noticeAttr['title'])) throw new MyException('公告标题不能为空', 201);
        if(empty($noticeAttr['abstract'])) throw new MyException('公告摘要不能为空', 201);

        $noticeAttr['abstract']   = cutstr($noticeAttr['abstract'], 140, 0);
        $noticeAttr['abstract']   = HTMLEncode($noticeAttr['abstract']);//
        $noticeAttr['desc'] = ckReplace($noticeAttr['desc']);//      
        return $noticeAttr;
    }
     

    /**
     * notice::getList()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function getList($page = 1, $pagesize = 10,$count=0){
        
        if(!preg_match('/^\d+$/', $page)) $page = 1;
        if(!preg_match('/^\d+$/', $pagesize)) $pagesize = 10;
        
        return Table_notice::getList($page, $pagesize,$count=0);
    }

    /**
     *notice::getAllList()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function getAllList(){
        
        
        return Table_notice::getAllList();
    }
    
    /**
     * notice::getCount()
     * 
     * @param integer $sort
     * @param integer $status
     * @return
     */
    static public function getCount(){
        
        return Table_notice::getCount();

    }
    
    
    /**
     * notice::del()
     * 
     * @param mixed $id
     * @return
     */
    static public function del($id){

        if(empty($id))throw new MyException('ID不能为空', 101);

        
        
        $rs = Table_notice::del($id);
        if($rs == 1){
            //TODO 删除新闻将图片删除
            
            $msg = '删除公告('.$id.')成功!';
            Adminlog::add($msg);
            
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 102);
        }
    }
    
    
    /**
     * notice::search()
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
        
        return Table_notice::search($page, $pagesize,$title,$count);
    }


}
?>