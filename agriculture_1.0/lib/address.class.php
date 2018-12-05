<?php

/**
 * address.class.php 地址类
 *
 * @version       v0.01
 * @create time   2016/11/16
 * @update time
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

class Address {

    public $id     = 0;
    public $status = 0;

    public function __construct() {
    }

    /**
     * Address::getInfoById()
     *
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        if(empty($id)) throw new MyException('ID不能为空', 101);

        return Table_address::getInfoById($id);
    }
    /**
     * Address::getInfoByOpenId()
     *
     * @param mixed $id
     * @return
     */
    static public function getInfoByOpenId($openid){
        if(empty($openid)) throw new MyException('openid不能为空', 101);

        return Table_address::getInfoByOpenId($openid);
    }

    /**
     * Address::add()
     *
     * @param array $cartAttr
     * 
     *
     * @return void
     */
    static public function add($addressAttr = array()){

        //添加和修改的操作校验相同。所以单独做个函数
        $okAttr = self::checkAddressInputParam($addressAttr);

        $rs = Table_address::add($okAttr);
        if($rs >= 0){
            return action_msg('添加成功', 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }


    /**
     * Address::edit()
     *
     * @param mixed $id
     * @param array $cartAttr
     * 
     *
     * @return
     */
    static public function edit($id, $addressAttr){

        if(empty($id)) throw new MyException('ID不能为空', 100);

        $okAttr = self::checkAddressInputParam($addressAttr);

        $rs = Table_address::edit($id, $okAttr);

        if($rs >= 0){
            $msg = '修改成功!';
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }

    /**
     * Comment::checkAddressInputParam()
     *
     * @param array $cartAttr
     *
     * @return void
     */
    static private function checkAddressInputParam($addressAttr){
        if(empty($addressAttr) || !is_array($addressAttr)) throw new MyException('参数错误', 100);

        if(empty($addressAttr['name'])) throw new MyException('收货人姓名不能为空', 202);
        if(!empty($addressAttr['phone'])){
            if(!is_mobile($addressAttr['phone'])){
                throw new MyException('电话格式不正确', 206);
            }
        }
        if(empty($addressAttr['address'])) throw new MyException('详细地址不能为空', 202);
        if(empty($addressAttr['area'])) throw new MyException('未获取到用户的地域信息', 202);
        if(empty($addressAttr['postcode'])) throw new MyException('邮政编码不能为空', 202);
    
        return $addressAttr;
    }



    /**
     * Address::del()
     *
     * @param mixed $id
     * @return
     */
    static public function del($id){

        if(empty($id))throw new MyException('ID不能为空', 101);

        $rs = Table_address::del($id);
        if($rs == 1){

            $msg = '删除成功!';

            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 102);
        }
    }
   
    /**
     * Address::search()
     *
     * @param integer $page
     * @param integer $pagesize
     * @param integer $choose//0 代表护工 1代表月嫂
     * @param integer $name//要查找的名字
     * @param integer $count //是否仅作统计 1 - 统计
     * @return
     */
    static public function search($page = 1, $pagesize = 10,  $nikname = '',$name = '',$phone = '',  $count = 0){
        if(!preg_match('/^\d+$/', $page)) $page = 1;
        if(!preg_match('/^\d+$/', $pagesize)) $pagesize = 10;

        return Table_address::search($page, $pagesize, $nikname,$name,$phone, $count);
    }


}
?>