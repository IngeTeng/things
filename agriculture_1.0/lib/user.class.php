<?php

/**
 * user.class.php 用户类
 *
 * @version       v0.01
 * @create time   2016/11/14
 * @update time   2016/11/17
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

class User {

    public $id     = 0;
    public $status = 0;

    public function __construct() {
    }

    /**
     * User::getInfoById()
     *
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        if(empty($id)) throw new MyException('ID不能为空', 101);

        return Table_user::getInfoById($id);
    }
    /**
     * User::getNameById()
     *
     * @param mixed $id
     * @return
     */
    static public function getNameById($id){
        if(empty($id)) throw new MyException('ID不能为空', 101);

        return Table_user::getNameById($id);
    }

    /**
     * User::getInfoByOpenid()
     *
     * @param mixed $openid
     * @return
     */
    static public function getInfoByOpenid($openid){
        if(empty($openid)) throw new MyException('openid不能为空', 101);

        return Table_user::getInfoByOpenid($openid);
    }

     /**
     * User::getInfoByNikname()
     *
     * @param mixed $id
     * @return
     */
    static public function getInfoByNikname($nikname){

        Table_user::getInfoByNikname($nikname);

    }

    /**
     * User::add()
     *
     * @param array $userAttr
     * $userAttr数组键：photo,name,sex,phone,idcard,birth
     *
     * @return void
     */
    static public function add($userAttr = array()){

        //添加和修改的操作校验相同。所以单独做个函数
        $okAttr = self::checkUserInputParam($userAttr);

        $rs = Table_user::add($okAttr);

        if($rs > 0){
            //记录管理员日志log表
            $msg = '成功添加用户('.$okAttr['nikname'].')';
            Adminlog::add($msg);

            return action_msg('添加用户成功', 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }


    /**
     * User::add_front()
     *
     * @param array $userAttr
     * $userAttr数组键：photo,name,sex,phone,idcard,birth
     *
     * @return void
     */
    static public function add_front($userAttr = array()){

        //添加和修改的操作校验相同。所以单独做个函数
        $okAttr = self::checkUserInputParam($userAttr);

        $rs = Table_user::add($okAttr);

        if($rs > 0){
            //记录管理员日志log表
            return action_msg('添加用户成功', 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }

    /**
     * User::edit()
     *
     * @param mixed $id
     * @param array $userAttr
     * $userAttr数组键：photo,name,sex,phone,idcard,birth
     *
     * @return
     */
    static public function edit($id, $userAttr){

        if(empty($id)) throw new MyException('ID不能为空', 100);

        $okAttr = self::checkUserInputParam($userAttr);

        $rs = Table_user::edit($id, $okAttr);

        if($rs >= 0){
            $msg = '成功修改用户('.$id.')';
            Adminlog::add($msg);

            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }

     /**
     * User::edit()
     *
     * @param mixed $id
     * @param array $userAttr
     * $userAttr数组键：photo,name,sex,phone,idcard,birth
     *
     * @return
     */
    static public function update_msg($userid,$id, $userAttr){

        if(empty($userid)) throw new MyException('ID不能为空', 100);

        $rs = Table_user::update_msg($userid, $id, $userAttr);

        if($rs >= 0){
            $msg = '成功修改用户信息('.$userid.')';
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }

    /**
     * Report::checkUserInputParam()
     *
     * @param array $userAttr
     *
     * @return void
     */
    static private function checkUserInputParam($userAttr){
        if(empty($userAttr) || !is_array($userAttr)) throw new MyException('参数错误', 100);

        if(empty($userAttr['nikname'])) throw new MyException('微信呢称不能为空', 201);
        if(empty($userAttr['openid'])) throw new MyException('微信识别码不能为空', 201);
        self::checkParamSex($userAttr['sex']);
        if(empty($userAttr['img'])) throw new MyException('头像不能为空', 202);
        return $userAttr;
    }

    /**
     * User::checkParamSex()
     *
     * @param mixed $sex
     * @return void
     */
    static private function checkParamSex($sex){
        if(!preg_match('/^-?\d+$/', $sex)) throw new MyException('status必须为整数', 101);
        if(!self::getSexName($sex))  throw new MyException('状态不存在', 102);
    }

    /**
     * User::getSexName()
     *
     * @param mixed $sex
     * @return
     */
    static public function getSexName($sex){
        switch($sex){
            case 1:
                return '男';
                break;

            case 2:
                return '女';
                break;

            default:
                return false;
                break;
        }
    }

    /**
     * User::del()
     *
     * @param mixed $id
     * @return
     */
    static public function del($id){

        if(empty($id))throw new MyException('ID不能为空', 101);

        $rs = Table_user::del($id);
        if($rs == 1){

            $msg = '删除用户('.$id.')成功!';
            Adminlog::add($msg);

            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 102);
        }
    }

  /**
     * User::getAllList()
     *
     * @param integer $page
     * @param integer $pagesize
     * @param integer $count //是否仅作统计 1 - 统计
     * @return
     */
    static public function getAllList(){
       

        return Table_user::getAllList();
    }
    /**
     * User::search()
     *
     * @param integer $page
     * @param integer $pagesize
     * @param integer $count //是否仅作统计 1 - 统计
     * @return
     */
    static public function search($page = 1, $pagesize = 10,  $nikname = '' ,$count = 0){
        if(!preg_match('/^\d+$/', $page)) $page = 1;
        if(!preg_match('/^\d+$/', $pagesize)) $pagesize = 10;

        return Table_user::search($page, $pagesize, $nikname,$count);
    }
}
?>