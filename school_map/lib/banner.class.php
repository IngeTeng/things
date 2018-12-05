<?php

/**
 * banner.class.php 首页图片类
 *
 * @version       v0.01
 * @create time   2016/04/16
 * @update time   
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */
class Banner {
    
    public function __construct() {
    }
    
    /**
     *banner::getInfoById()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        if(empty($id)) throw new MyException('ID不能为空', 101);
        
        return Table_banner::getInfoById($id);
    }
    
    
    /**
     * banner::edit()
     * 
     * @param mixed $id
     * @param array $bannerAttr
     * $bannerAttr数组键：weixin_openid, name, hospital, section, position, desc, phone
     * 
     * @return
     */
    static public function edit($id, $bannerAttr){
        
        if(empty($id)) throw new MyException('ID不能为空', 100);
    
        
        $rs = Table_banner::edit($id, $bannerAttr);
        
        if($rs >= 0){
            $msg = '成功修改首页图片信息('.$id.')';
            Adminlog::add($msg);
            
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }

   
    
    
     

    /**
     * banner::getList()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function getList($page = 1, $pagesize = 10,$count=0){
        
        if(!preg_match('/^\d+$/', $page)) $page = 1;
        if(!preg_match('/^\d+$/', $pagesize)) $pagesize = 10;
        
        return Table_banner::getList($page, $pagesize,$count=0);
    }

    /**
     *banner::getAllList()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function getAllList(){
        
        
        return Table_banner::getAllList();
    }
    
    /**
     * banner::getCount()
     * 
     * @param integer $sort
     * @param integer $status
     * @return
     */
    static public function getCount(){
        
        return Table_banner::getCount();

    }
    
    
    /**
     * banner::del()
     * 
     * @param mixed $id
     * @return
     */
    static public function del($id){

        if(empty($id))throw new MyException('ID不能为空', 101);

        
        
        $rs = Table_banner::del($id);
        if($rs == 1){
            //TODO 删除首页图片将图片删除
            
            $msg = '删除首页图片('.$id.')成功!';
            Adminlog::add($msg);
            
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 102);
        }
    }
    
    


}
?>