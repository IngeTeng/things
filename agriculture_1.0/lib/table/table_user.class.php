<?php

/**
 * table_user.class.php 用户表
 *
 * @version       $Id$ v0.01
 * @createtime    2016/11/14
 * @updatetime    2016/11/17
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

class Table_user extends Table{

    /**
     * Table_user::struct()  数组转换
     *
     * @param array $data
     *
     * @return $r
     */
    static protected function struct($data){
        $r = array();

        $r['id']         = $data['user_id'];
        $r['nikname']    = $data['user_nikname'];//微信昵称
        $r['sex']        = $data['user_sex'];//性别
        $r['openid']     = $data['user_openid'];
        $r['createtime'] = $data['user_createtime'];//注册时间
        $r['img']        = $data['user_img'];//用户头像
        $r['state1']     = $data['user_state1'];//用户头像
        $r['state2']     = $data['user_state2'];//用户头像
        $r['state3']     = $data['user_state3'];//用户头像
        $r['state4']     = $data['user_state4'];//用户头像
        $r['state5']     = $data['user_state5'];//用户头像
        return $r;
    }

    /**
     * Table_user::getInfoById()
     *
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        global $mypdo;

        $id = $mypdo->sql_check_input(array('number', $id));

        $sql = "select * from ".$mypdo->prefix."user where user_id = $id limit 1";

        $rs = $mypdo->sqlQuery($sql);
        if($rs){
            $r = array();
            foreach($rs as $key => $val){
                $r[$key] = self::struct($val);
            }
            return $r[0];
        }else{
            return 0;
        }
    }
    /**
     * Table_user::getNameById()
     *
     * @param mixed $id
     * @return
     */
    static public function getNameById($id){
        global $mypdo;

        $id = $mypdo->sql_check_input(array('number', $id));

        $sql = "select user_nikname from ".$mypdo->prefix."user where user_id = $id limit 1";

        $r = $mypdo->sqlQuery($sql);
        if($r){
            return $r;
        }else{
            return 0;
        }
    }

     /**
         * Table_user::getInfoByOpenid()
         *
         * @param mixed $id
         * @return
         */
        static public function getInfoByOpenid($openid){
            global $mypdo;

            $openid = $mypdo->sql_check_input(array('string', $openid));

            $sql = "select * from ".$mypdo->prefix."user where user_openid = $openid limit 1";
            
            $rs = $mypdo->sqlQuery($sql);
        if($rs){
            $r = array();
            foreach($rs as $key => $val){
                $r[$key] = self::struct($val);
            }
            return $r;
        }else{
            return 0;
        }
        }

        /**
         * Table_user::getInfoByNikname()
         *
         * @param mixed $id
         * @return
         */
        static public function getInfoByNikname($nikname){
            global $mypdo;
            $nikname = "%$nikname%";
            $nikname = $mypdo->sql_check_input(array('string', $nikname));

            $sql = "select * from ".$mypdo->prefix."user where user_nikname like $nikname limit 1";

            $r = $mypdo->sqlQuery($sql);
            if($r){
                return $r;
            }else{
                return 0;
            }
        }
    /**
     * Table_user::add() 添加用户
     *
     * @param array $Attr
     * $Attr数组键：name,sex,phone,idcard,birth,photo
     *
     * @return
     */
    static public function add($Attr){
        global $mypdo;

        $time           = time();
        $nikname        = $Attr['nikname'];
        $sex            = $Attr['sex'];
        $img            = $Attr['img'];
        $openid         =$Attr['openid'];

        $param = array (
            'user_nikname'     => array('string', $nikname),
            'user_sex'         => array('number', $sex),
            'user_img'         => array('string', $img),
            'user_openid'      => array('string', $openid),
            'user_createtime'  => array('number', $time)
        );

        return $mypdo->sqlinsert($mypdo->prefix.'user', $param);
    }


    /**
     * Table_user::edit() 修改用户信息
     *
     * @param int   $id
     * @param array $Attr
     * $Attr数组键：name,sex,phone,idcard,birth,photo
     *
     * @return
     */
    static public function edit($id, $Attr){
        global $mypdo;

//        $time      = time(); edit的时候不能再获取时间 否则就会刷新注册时间
        $nikname     = $Attr['nikname'];
        $sex         = $Attr['sex'];
        $img         = $Attr['img'];
        $openid      = $Attr['openid'];

        $param = array (
            'user_nikname'       => array('string', $nikname),
            'user_sex'           => array('number', $sex),
            'user_openid'        => array('string', $openid),
            'user_img'           => array('string', $img)
//            'user_createtime'   => array('number', $time)
        );
        $where = array(
            'user_id'        => array('number', $id)
        );

        return $mypdo->sqlupdate($mypdo->prefix.'user', $param, $where);
    }


    /**
     * Table_user::edit() 修改用户信息
     *
     * @param int   $id
     * @param array $Attr
     * $Attr数组键：name,sex,phone,idcard,birth,photo
     *
     * @return
     */
    static public function update_msg($userid, $id,$userAttr){
        global $mypdo;
        //var_dump($userAttr);
        if($id==1){
            $param = array (
            'user_state1'        => array('number', $userAttr['state1'])
            );
        }
        if($id==2){
            $param = array (
            'user_state2'        => array('number', $userAttr['state2'])
            );
        }

        if($id==3){
            $param = array (
            'user_state3'        => array('number', $userAttr['state3'])
            );
        }
        if($id==4){
            $param = array (
            'user_state4'        => array('number', $userAttr['state4'])
            );
        }
        if($id==5){
            $param = array (
            'user_state5'        => array('number', $userAttr['state5'])
            );
        }
        $where = array(
            'user_id'        => array('number', $userid)
        );

        return $mypdo->sqlupdate($mypdo->prefix.'user', $param, $where);
    }
    /**
     * Table_news::del() 删除用户信息
     *
     * @param mixed $id
     * @return
     */
    static public function del($id){
        global $mypdo;

        $where = array(
            'user_id' => array('number', $id)
        );

        return $mypdo->sqldelete($mypdo->prefix.'user', $where);
    }
    /**
     * Table_user::search() 用户搜索
     *
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function getAllList(){
        global $mypdo, $mylog;

        $sql = "select * from ".$mypdo->prefix."user where 1=1 ";
        
            $sql .= " order by user_id desc";

            $rs = $mypdo->sqlQuery($sql);
            if($rs){
                $r = array();
                foreach($rs as $key => $val){
                    $r[$key] = self::struct($val);
                }
                return $r;
            }else{
                return 0;
            }

        


    }
    /**
     * Table_user::search() 用户搜索
     *
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function search($page = 1, $pagesize = 10,  $nikname = '',  $count = 0){
        global $mypdo, $mylog;

        $page     = $mypdo->sql_check_input(array('number', $page));
        $pagesize = $mypdo->sql_check_input(array('number', $pagesize));

        $nikname = "%$nikname%";
        $nikname    = $mypdo->sql_check_input(array('string', $nikname));
        $startrow = ($page - 1) * $pagesize;
        $sql = "select * from ".$mypdo->prefix."user where 1=1 ";
        $sql .= " and user_nikname like $nikname ";


        if($count){

            $r = $mypdo->sqlQuery($sql);
            return count($r);

        }else{
            $sql .= " order by user_id desc limit $startrow, $pagesize";
            //var_dump($sql);
            $rs = $mypdo->sqlQuery($sql);
            if($rs){
                $r = array();
                foreach($rs as $key => $val){
                    $r[$key] = self::struct($val);
                }
                return $r;
            }else{
                return 0;
            }

        }


    }

}
?>