<?php

/**
 * order_detail.class.php 订单详情类
 *
 * @version       v0.01
 * @create time   2016/04/16
 * @update time   
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

class Order_detail {
    
    public function __construct() {
    }
    
    /**
     *Order_detail::getInfoById()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        if(empty($id)) throw new MyException('ID不能为空', 101);
        
        return Table_order_detail::getInfoById($id);
    }
    
    /**
     *Order_detail::getInfoById()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoByPayId($payid){
        if(empty($payid)) throw new MyException('ID不能为空', 101);
        
        return Table_order_detail::getInfoByPayId($payid);
    }

    /**
     *Order_detail::getInfoByProductid()
     * 
     * @param mixed $id
     * @return
     */
    static public function getInfoByProductid($productid){
        if(empty($productid)) throw new MyException('ID不能为空', 101);
        
        return Table_order_detail::getInfoByProductid($productid);
    }
    /**
     * Order_detail::add()
     * 
     * @param array $order_detailAttr
     * $orderAttr数组键：name, desc, createtime
     * 
     * @return void
     */
    static public function add($order_detailAttr = array()){
        
        //参数较多，校验较多。而且添加和修改的操作校验相同。所以单独做个函数
        $okAttr = self::checkOrder_detailInputParam($order_detailAttr);

        $rs = Table_order_detail::add($okAttr);

        if($rs > 0){
            
            return action_msg('购买成功', 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }
    
    
    /**
     * Order_detail::edit()
     * 
     * @param mixed $id
    * @param array $orderAttr
     * $knowledgeAttr数组键：name, desc, createtime
     * 
     * @return
     */
    static public function edit($id, $order_detailAttr){
        
        if(empty($id)) throw new MyException('ID不能为空', 100);
        
        //$okAttr = self::checkOrder_detailInputParam($order_detailAttr);
        
        $rs = Table_order_detail::edit($id, $order_detailAttr);
        
        if($rs >= 0){
            $msg = '订单修改成功('.$id.')';
            
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }

    /**
     * Order_detail::post()
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
        
        $rs = Table_order_detail::post($id);
        
        if($rs >= 0){
            $msg = '确认发货成功('.$id.')';
            
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }

    /**
     * Order_detail::sure()
     * 
     * @param mixed $id
    * @param array $orderAttr
     * $knowledgeAttr数组键：name, desc, createtime
     * 
     * @return
     */
    static public function sure($id){
        
        if(empty($id)) throw new MyException('ID不能为空', 100);
        
        //$okAttr = self::checkOrderInputParam($orderAttr);
        
        $rs = Table_order_detail::sure($id);
        
        if($rs >= 0){
            $msg = '已确认收货';
            
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
    static private function checkOrder_detailInputParam($order_detailAttr){
        if(empty($order_detailAttr) || !is_array($order_detailAttr)) throw new MyException('参数错误', 100);
        
        if(empty($order_detailAttr['payid'])) throw new MyException('订单号不能为空', 201);
        if(empty($order_detailAttr['num'])) throw new MyException('昵称不能为空', 201);
        if(empty($order_detailAttr['product_img'])) throw new MyException('商品图片不能为空', 201);
        if(empty($order_detailAttr['product_title'])) throw new MyException('地址信息不能为空', 201);
        if(empty($order_detailAttr['product_price'])) throw new MyException('商品价格不能为空', 201);

       
        return $order_detailAttr;
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
                return '待发货';
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
     * Order_detail::getList()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function getList(){
        
        
        return Table_order_detail::getList();
    }
    
    
    /**
     * Order_detail::getCount()
     * 
     * @param integer $sort
     * @param integer $status
     * @return
     */
    static public function getCount(){
        
        return Table_order_detail::getCount();
    }
    
    /**
     * Order_detail::del()
     * 
     * @param mixed $id
     * @return
     */
    static public function del($id){

        if(empty($id))throw new MyException('ID不能为空', 101);
        
        $rs = Table_order_detail::del($id);
        if($rs == 1){
            //TODO 删除新闻将图片删除
            
            $msg = '删除订单成功!';
            
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 102);
        }
    }
    
    
    /**
     * Order_detail::search()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @param integer $sort
     * @param integer $status
     * @param integer $count //是否仅作统计 1 - 统计
     * @return
     */
    static public function search($page = 1, $pagesize = 10 , $state =0 ,$payid='',$count = 0){
        
        if(!preg_match('/^\d+$/', $page)) $page = 1;
        if(!preg_match('/^\d+$/', $pagesize)) $pagesize = 10;
        
        return Table_order_detail::search($page, $pagesize, $state,$payid ,$count);
    }

    /**
     * Order_detail::search_phone()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @param integer $sort
     * @param integer $status
     * @param integer $count //是否仅作统计 1 - 统计
     * @return
     */
    static public function search_phone($page = 1, $pagesize = 10 , $state =0 , $phone='',$payid='',$count = 0){
        
        if(!preg_match('/^\d+$/', $page)) $page = 1;
        if(!preg_match('/^\d+$/', $pagesize)) $pagesize = 10;
        
        return Table_order_detail::search_phone($page, $pagesize, $state,$phone='',$payid ,$count);
    }

    /**
     * Order_detail::search_phone()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @param integer $sort
     * @param integer $status
     * @param integer $count //是否仅作统计 1 - 统计
     * @return
     */
    static public function search_record($page = 1, $pagesize = 10 ,  $phone=0,$year=0,$count = 0){

        if(!preg_match('/^\d+$/', $page)) $page = 1;
        if(!preg_match('/^\d+$/', $pagesize)) $pagesize = 10;
        return Table_order_detail::search_record($page, $pagesize, $phone,$year ,$count);
    }
}
?>