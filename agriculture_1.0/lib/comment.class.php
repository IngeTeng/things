<?php

/**
 * comment.class.php 评论类
 *
 * @version       v0.01
 * @create time   2016/11/16
 * @update time
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

class Comment {

    public $id     = 0;
    public $status = 0;

    public function __construct() {
    }

    /**
     * Comment::getInfoById()
     *
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        if(empty($id)) throw new MyException('ID不能为空', 101);

        return Table_comment::getInfoById($id);
    }
    /**
     * Comment::getInfoByOpenId()
     *
     * @param mixed $id
     * @return
     */
    static public function getInfoByOpenId($openid){
        if(empty($openid)) throw new MyException('openid不能为空', 101);

        return Table_comment::getInfoByOpenId($openid);
    }

    /**
     * Comment::getInfoByOpenId()
     *
     * @param mixed $id
     * @return
     */
    static public function getInfoByOrder_detailid($order_detailid){
        if(empty($order_detailid)) throw new MyException('openid不能为空', 101);

        return Table_comment::getInfoByOrder_detailid($order_detailid);
    }
    /**
     * Comment::add()
     *
     * @param array $cartAttr
     * 
     *
     * @return void
     */
    static public function add($commentAttr = array()){

        //添加和修改的操作校验相同。所以单独做个函数
        $okAttr = self::checkCommentInputParam($commentAttr);

        $rs = Table_comment::add($okAttr);
        if($rs >= 0){
            return action_msg('添加成功', 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }


    /**
     * Comment::edit()
     *
     * @param mixed $id
     * @param array $cartAttr
     * 
     *
     * @return
     */
    static public function edit($id, $commentAttr){

        if(empty($id)) throw new MyException('ID不能为空', 100);

        $okAttr = self::checkCommentInputParam($commentAttr);

        $rs = Table_comment::edit($id, $okAttr);

        if($rs >= 0){
            $msg = '修改成功!';
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }

    /**
     * Comment::checkCommentInputParam()
     *
     * @param array $cartAttr
     *
     * @return void
     */
    static private function checkCommentInputParam($commentAttr){
        if(empty($commentAttr) || !is_array($commentAttr)) throw new MyException('参数错误', 100);

        if(empty($commentAttr['openid'])) throw new MyException('未获取到用户信息', 201);
        if(empty($commentAttr['nikname'])) throw new MyException('未获取到用户的昵称', 202);
        if(empty($commentAttr['order_detailid'])) throw new MyException('订单详情不能为空', 202);
        if(empty($commentAttr['productid'])) throw new MyException('商品不能为空', 202);
        if(empty($commentAttr['product_title'])) throw new MyException('商品名称不能为空', 202);
        return $commentAttr;
    }



    /**
     * Comment::del()
     *
     * @param mixed $id
     * @return
     */
    static public function del($id){

        if(empty($id))throw new MyException('ID不能为空', 101);

        $rs = Table_comment::del($id);
        if($rs == 1){

            $msg = '删除成功!';

            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 102);
        }
    }
   
    /**
     * Comment::search()
     *
     * @param integer $page
     * @param integer $pagesize
     * @param integer $choose//0 代表护工 1代表月嫂
     * @param integer $name//要查找的名字
     * @param integer $count //是否仅作统计 1 - 统计
     * @return
     */
    static public function search($page = 1, $pagesize = 10,  $nikname = '', $product_title='',$productid='', $count = 0){
        if(!preg_match('/^\d+$/', $page)) $page = 1;
        if(!preg_match('/^\d+$/', $pagesize)) $pagesize = 10;

        return Table_comment::search($page, $pagesize, $nikname,  $product_title,$productid,$count);
    }


}
?>