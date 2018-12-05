<?php

/**
 * order.class.php 订单类
 *
 * @version       v0.01
 * @create time   2016/04/16
 * @update time   
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

class Order {
    
    public function __construct() {
    }
    
    /**
     *Order::getInfoById()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        if(empty($id)) throw new MyException('ID不能为空', 101);
        
        return Table_order::getInfoById($id);
    }

    /**
     *Order::getInfoByPayid()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoByPayid($payid){
        if(empty($payid)) throw new MyException('PayID不能为空', 101);
        
        return Table_order::getInfoByPayid($payid);
    }
    
    /**
     * Order::add()
     * 
     * @param array $orderAttr
     * $orderAttr数组键：name, desc, createtime
     * 
     * @return void
     */
    static public function add($orderAttr = array()){
        
        //参数较多，校验较多。而且添加和修改的操作校验相同。所以单独做个函数
        $okAttr = self::checkOrderInputParam($orderAttr);

        $rs = Table_order::add($okAttr);

        if($rs > 0){
            
            return action_msg('购买成功', 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }
    
    
    /**
     * Oredr::edit()
     * 
     * @param mixed $id
    * @param array $orderAttr
     * $knowledgeAttr数组键：name, desc, createtime
     * 
     * @return
     */
    static public function edit($pay_id, $orderAttr){
        
        if(empty($pay_id)) throw new MyException('ID不能为空', 100);
        
        
        $rs = Table_order::edit($pay_id, $orderAttr);
        
        if($rs >= 0){
            $msg = '支付成功';
            
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }
    

    /**
     * Oredr::post()
     * 
     * @param mixed $id
    * @param array $orderAttr
     * $knowledgeAttr数组键：name, desc, createtime
     * 
     * @return
     */
    static public function post($id){
        
        if(empty($id)) throw new MyException('ID不能为空', 100);
        
        //$okAttr = self::checkOrderInputParam($orderAttr);
        
        $rs = Table_order::post($id);
        
        if($rs >= 0){
            
            $msg = '确认发货成功('.$id.')';
            
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }

    /**
     * order::checkOrderInputParam()
     * 
     * @param array $orderAttr
     * 
     * @return void
     */
    static private function checkOrderInputParam($orderAttr){
        if(empty($orderAttr) || !is_array($orderAttr)) throw new MyException('参数错误', 100);
        
        if(empty($orderAttr['nikname'])) throw new MyException('昵称不能为空', 201);
        if(empty($orderAttr['address_area'])) throw new MyException('区域信息不能为空', 201);
        if(empty($orderAttr['address'])) throw new MyException('地址信息不能为空', 201);
        if(empty($orderAttr['address_name'])) throw new MyException('收货人不能为空', 201);
        if(empty($orderAttr['address_phone'])) throw new MyException('收货人电话不能为空', 201);
       
        return $orderAttr;
    }

     /**
     * Order::getStateName()
     *
     * @param mixed $sort
     * @return
     */
    static public function getStateName($state){
        switch($state){
            case 1:
                return '待付款';
                break;

            case 2:
                return '已付款';
                break;

            case 3:
                return '已发货';
                break;

            case 4:
                return '交易完成';
                break;

            default:
                return false;
                break;
        }
    }

     /**
     * Order::getList()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function getList(){
        
        
        return Table_order::getList();
    }
    
    
    /**
     * Order::getCount()
     * 
     * @param integer $sort
     * @param integer $status
     * @return
     */
    static public function getCount(){
        
        return Table_order::getCount();
    }
    
    /**
     * Order::del()
     * 
     * @param mixed $id
     * @return
     */
    static public function del($payid){

        if(empty($payid))throw new MyException('ID不能为空', 101);
        
        $rs = Table_order::del($payid);
        if($rs == 1){
            //TODO 删除新闻将图片删除
            
            $msg = '删除订单('.$payid.')成功!';
            
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 102);
        }
    }
    
    
    /**
     * Order::search()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @param integer $sort
     * @param integer $status
     * @param integer $count //是否仅作统计 1 - 统计
     * @return
     */
    static public function search($page = 1, $pagesize = 10 ,$pay_id='', $nikname ='',$count = 0){
        
        if(!preg_match('/^\d+$/', $page)) $page = 1;
        if(!preg_match('/^\d+$/', $pagesize)) $pagesize = 10;
        
        return Table_order::search($page, $pagesize,  $pay_id , $nikname,$count);
    }
}
?>