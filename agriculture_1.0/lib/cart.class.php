<?php

/**
 * cart.class.php 购物车类
 *
 * @version       v0.01
 * @create time   2016/11/16
 * @update time
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

class Cart {

    public $id     = 0;
    public $status = 0;

    public function __construct() {
    }

    /**
     * Cart::getInfoById()
     *
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        if(empty($id)) throw new MyException('ID不能为空', 101);

        return Table_cart::getInfoById($id);
    }
    /**
     * Cart::getInfoByOpenId()
     *
     * @param mixed $id
     * @return
     */
    static public function getInfoByOpenId($openid){
        if(empty($openid)) throw new MyException('openid不能为空', 101);

        return Table_cart::getInfoByOpenId($openid);
    }

    /**
     * Cart::add()
     *
     * @param array $cartAttr
     * 
     *
     * @return void
     */
    static public function add($cartAttr = array()){

        //添加和修改的操作校验相同。所以单独做个函数
        $okAttr = self::checkCartInputParam($cartAttr);
        $repeat = Table_cart::checkInfoByProduct($cartAttr['openid'],$cartAttr['productid']);
        if($repeat) throw new MyException('该商品已在购物车中', 104);
        $rs = Table_cart::add($okAttr);
        if($rs >= 0){
            return action_msg('已加入购物车', 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }


    /**
     * Cart::edit()
     *
     * @param mixed $id
     * @param array $cartAttr
     * 
     *
     * @return
     */
    static public function edit($id, $cartAttr){

        if(empty($id)) throw new MyException('ID不能为空', 100);

        //$okAttr = self::checkCartInputParam($cartAttr);

        $rs = Table_cart::edit($id, $cartAttr);
        if($rs >= 0){
            //$cart = table_cart::getInfoById($id);
            //$msg = $cart['productnum'];
            $msg = '成功修改';
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }

    /**
     * Cart::checkCartInputParam()
     *
     * @param array $cartAttr
     *
     * @return void
     */
    static private function checkCartInputParam($cartAttr){
        if(empty($cartAttr) || !is_array($cartAttr)) throw new MyException('参数错误', 100);

        if(empty($cartAttr['productid'])) throw new MyException('请选择商品', 201);
        if(empty($cartAttr['productnum'])) throw new MyException('请选择商品数量', 202);
        if(empty($cartAttr['openid'])) throw new MyException('未获取到用户信息', 202);
    
        return $cartAttr;
    }



    /**
     * Cart::del()
     *
     * @param mixed $id
     * @return
     */
    static public function del($id){

        if(empty($id))throw new MyException('ID不能为空', 101);
        $cart = table_cart::getInfoById($id);
        $product = table_product::getInfoById($cart['productid']);
        $rs = Table_cart::del($id);
        if($rs == 1){

            $msg = '删除成功!';
            $res[0]= $cart['productnum'];
            $res[1] = $product['price'];
            $res[2] = $product['sale_price'];
            $res[3] = $product['issale'];
            return action_msg_res($msg, 1,$res);
        }else{
            throw new MyException('操作失败', 102);
        }
    }
   
    /**
     * Cart::search()
     *
     * @param integer $page
     * @param integer $pagesize
     * @param integer $choose//0 代表护工 1代表月嫂
     * @param integer $name//要查找的名字
     * @param integer $count //是否仅作统计 1 - 统计
     * @return
     */
    static public function search($page = 1, $pagesize = 10,  $nikname = '',  $count = 0){
        if(!preg_match('/^\d+$/', $page)) $page = 1;
        if(!preg_match('/^\d+$/', $pagesize)) $pagesize = 10;

        return Table_cart::search($page, $pagesize, $nikname, $count);
    }


}
?>