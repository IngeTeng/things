<?php

/**
 * node.class.php 节点类
 *
 * @version       v0.01
 * @create time   2016/11/16
 * @update time
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

class Node {

    public $id     = 0;
    public $status = 0;

    public function __construct() {
    }

    /**
     * Node::getInfoById()
     *
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        if(empty($id)) throw new MyException('ID不能为空', 101);

        return Table_node::getInfoById($id);
    }


    /**
     * Node::add()
     *
     * @param array $cartAttr
     * 
     *
     * @return void
     */
    static public function add($nodeAttr = array()){

        //添加和修改的操作校验相同。所以单独做个函数
        $okAttr = self::checkNodeInputParam($nodeAttr);

        $rs = Table_node::add($okAttr);
        if($rs >= 0){
            return action_msg('添加成功', 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }


    /**
     * Node::edit()
     *
     * @param mixed $id
     * @param array $cartAttr
     * 
     *
     * @return
     */
    static public function edit($id, $nodeAttr){

        if(empty($id)) throw new MyException('ID不能为空', 100);

        $okAttr = self::checkNodeInputParam($nodeAttr);

        $rs = Table_node::edit($id, $okAttr);

        if($rs >= 0){
            $msg = '修改成功!';
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }

    /**
     * Node::checkNodeInputParam()
     *
     * @param array $cartAttr
     *
     * @return void
     */
    static private function checkNodeInputParam($nodeAttr){
        if(empty($nodeAttr) || !is_array($nodeAttr)) throw new MyException('参数错误', 100);
        if(empty($nodeAttr['title'])) throw new MyException('节点名称不能为空', 201);
        if(empty($nodeAttr['jing'])) throw new MyException('经度不能为空', 202);
        if(empty($nodeAttr['wei'])) throw new MyException('纬度不能为空', 203);
        return $nodeAttr;
    }



    /**
     * Node::del()
     *
     * @param mixed $id
     * @return
     */
    static public function del($id){

        if(empty($id))throw new MyException('ID不能为空', 101);

        $rs = Table_node::del($id);
        if($rs == 1){

            $msg = '删除成功!';

            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 102);
        }
    }
    /**
     * Node::getList()
     * 
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function getList(){
        
        
        return Table_node::getList();
    }
    /**
     * Node::search()
     *
     * @param integer $page
     * @param integer $pagesize
     * @param integer $choose//0 代表护工 1代表月嫂
     * @param integer $name//要查找的名字
     * @param integer $count //是否仅作统计 1 - 统计
     * @return
     */
    static public function search($page = 1, $pagesize = 10,  $title = '',  $count = 0){
        if(!preg_match('/^\d+$/', $page)) $page = 1;
        if(!preg_match('/^\d+$/', $pagesize)) $pagesize = 10;

        return Table_node::search($page, $pagesize, $title, $count);
    }


}
?>