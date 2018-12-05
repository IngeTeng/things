<?php

/**
 * table_partner.class.php 分销商表
 *
 * @version       $Id$ v0.01
 * @createtime    2016/11/14
 * @updatetime    2016/11/17
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

class Table_partner extends Table{

    /**
     * Table_partner::struct()  数组转换
     *
     * @param array $data
     *
     * @return $r
     */
    static protected function struct($data){
        $r = array();

        $r['id']            = $data['partner_id'];
        $r['name']          = $data['partner_name'];
        $r['company']       = $data['partner_company'];
        $r['nikname']       = $data['partner_nikname'];
        $r['openid']        = $data['partner_openid'];
        $r['account']       = $data['partner_account'];
        $r['password']      = $data['partner_password'];
        $r['salt']          = $data['partner_salt'];
        $r['state']         = $data['partner_state'];
        $r['phone']         = $data['partner_phone'];
        $r['address']       = $data['partner_address'];//微信昵称
        $r['qrcode']        = $data['partner_qrcode'];//性别
        $r['product']       = $data['partner_product'];//电话号码
        $r['state1']        = $data['partner_state1'];//消息状态1
        $r['state2']        = $data['partner_state2'];//消息状态2
        $r['createtime']    = $data['partner_createtime'];//注册时间
        return $r;
    }


    /**
     * Table_partner::getInfoByAccount() 根据账号获取详情
     * 
     * @param string $acount 账号
     * 
     * @return
     */
    static public function getInfoByAccount($account){
        global $mypdo;
        
        $account = $mypdo->sql_check_input(array('string', $account));
        
        $sql = "select * from ".$mypdo->prefix."partner where partner_account = $account limit 1";
        
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
     * Table_partner::getInfoByPhone() 根据账号获取详情
     * 
     * @param string $acount 账号
     * 
     * @return
     */
    static public function getInfoByPhone($phone){
        global $mypdo;
        
        $phone = $mypdo->sql_check_input(array('string', $phone));
        
        $sql = "select * from ".$mypdo->prefix."partner where partner_phone = $phone limit 1";
       // var_dump($sql);
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
     * Table_partner::getInfoById()
     *
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        global $mypdo;

        $id = $mypdo->sql_check_input(array('number', $id));

        $sql = "select * from ".$mypdo->prefix."partner where partner_id = $id limit 1";

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
     * Table_partner::getInfoByOpenid()
     *
     * @param mixed $id
     * @return
     */
    static public function getInfoByOpenid($openid){
        global $mypdo;

        $openid = $mypdo->sql_check_input(array('string', $openid));

        $sql = "select * from ".$mypdo->prefix."partner where partner_openid = $openid limit 1";

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
     * Table_partner::getNameById()
     *
     * @param mixed $id
     * @return
     */
    static public function getNameById($id){
        global $mypdo;

        $id = $mypdo->sql_check_input(array('number', $id));

        $sql = "select partner_name from ".$mypdo->prefix."partner where partner_id = $id limit 1";

        $r = $mypdo->sqlQuery($sql);
        if($r){
            return $r;
        }else{
            return 0;
        }
    }


    /**
     * Table_partner::add() 添加用户
     *
     * @param array $Attr
     * $Attr数组键：name,sex,phone,idcard,birth,photo
     *
     * @return
     */
    static public function add($Attr){
        global $mypdo;

        $time               = time();
        $name               = $Attr['name'];
        $nikname            = $Attr['nikname'];
        $openid             = $Attr['openid'];
        $phone              = $Attr['phone'];
        $address            = $Attr['address'];
        $qrcode             = $Attr['qrcode'];
        $product            = $Attr['product'];
        $company            = $Attr['company'];

        $param = array (
            'partner_name'          => array('string', $name),
            'partner_nikname'       => array('string', $nikname),
            'partner_openid'        => array('string', $openid),
            //'partner_account'       => array('string', $account),
            //'partner_password'      => array('string', $password),
            //'partner_salt'          => array('string', $salt),
            'partner_company'       => array('string',$company),
            'partner_phone'         => array('number', $phone),
            'partner_address'       => array('string', $address),
            'partner_qrcode'        => array('string', $qrcode),
            'partner_product'       => array('string', $product),
            'partner_createtime'    => array('number', $time)
        );

        return $mypdo->sqlinsert($mypdo->prefix.'partner', $param);
    }


    /**
     * Table_partner::edit() 修改用户信息
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
        $name               = $Attr['name'];
        $company            = $Attr['company'];
        $nikname            = $Attr['nikname'];
        $openid             = $Attr['openid'];
        $account            = $Attr['account'];
        $password           = $Attr['password'][0];
        $salt               = $Attr['password'][1];
        $state              = $Attr['state'];
        $phone              = $Attr['phone'];
        $address            = $Attr['address'];
        $qrcode             = $Attr['qrcode'];
        $product            =$Attr['product'];
        $company            = $Attr['company'];


        $param = array (
            'partner_name'          => array('string', $name),
            'partner_company'       => array('string', $company),
            'partner_nikname'       => array('string', $nikname),
            'partner_openid'        => array('string', $openid),
            'partner_account'       => array('string', $account),
            'partner_password'      => array('string', $password),
            'partner_salt'          => array('string', $salt),
            'partner_state'         => array('number', $state),
            'partner_phone'         => array('number', $phone),
            'partner_address'       => array('string', $address),
            'partner_qrcode'        => array('string', $qrcode),
            'partner_product'       => array('string', $product),
            'partner_company'       => array('string',$company)
        );
        $where = array(
            'partner_id'        => array('number', $id)
        );

        return $mypdo->sqlupdate($mypdo->prefix.'partner', $param, $where);
    }

/**
     * Table_partner::edit() 修改用户信息
     *
     * @param int   $id
     * @param array $Attr
     * $Attr数组键：name,sex,phone,idcard,birth,photo
     *
     * @return
     */
    static public function edit_nopass($id, $Attr){
        global $mypdo;

//        $time      = time(); edit的时候不能再获取时间 否则就会刷新注册时间
        $name               = $Attr['name'];
        $company            = $Attr['company'];
        $nikname            = $Attr['nikname'];
        $openid             = $Attr['openid'];
        $state              = $Attr['state'];
        $phone              = $Attr['phone'];
        $address            = $Attr['address'];
        $qrcode             = $Attr['qrcode'];
        $product            =$Attr['product'];
        $company            = $Attr['company'];


        $param = array (
            'partner_name'          => array('string', $name),
            'partner_company'       => array('string', $company),
            'partner_nikname'       => array('string', $nikname),
            'partner_openid'        => array('string', $openid),
            'partner_state'         => array('number', $state),
            'partner_phone'         => array('number', $phone),
            'partner_address'       => array('string', $address),
            'partner_qrcode'        => array('string', $qrcode),
            'partner_product'       => array('string', $product),
            'partner_company'       => array('string',$company)
        );
        $where = array(
            'partner_id'        => array('number', $id)
        );

        return $mypdo->sqlupdate($mypdo->prefix.'partner', $param, $where);
    }

     /**
     * Table_partner::edit() 修改用户信息
     *
     * @param int   $id
     * @param array $Attr
     * $Attr数组键：name,sex,phone,idcard,birth,photo
     *
     * @return
     */
    static public function update_msg($roleid, $id,$Attr){
        global $mypdo;

        if($id==6){
            $param = array (
            'partner_state1'        => array('number', $Attr['state1'])
            );
        }
        if($id==7){
            $param = array (
            'partner_state2'        => array('number', $Attr['state2'])
            );
        }


        $where = array(
            'partner_id'        => array('number', $roleid)
        );

        return $mypdo->sqlupdate($mypdo->prefix.'partner', $param, $where);
    }
    /**
     * Table_partner::del() 删除用户信息
     *
     * @param mixed $id
     * @return
     */
    static public function del($id){
        global $mypdo;

        $where = array(
            'partner_id' => array('number', $id)
        );

        return $mypdo->sqldelete($mypdo->prefix.'partner', $where);
    }
    /**
     * Table_partner::search() 用户搜索
     *
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function getAllList(){
        global $mypdo, $mylog;

        $sql = "select * from ".$mypdo->prefix."partner where 1=1 ";
        
            $sql .= " order by partner_id asc";

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
      * Table_partner::updatePwd() 修改密码
      * 
      * @param Integer $id        管理员ID
      * @param array   $newpass   新密码及salt
      * 
      * @return
      */
     static public function updatePwd($id, $newpass){
        
        global $mypdo;

        //修改参数
        $param = array(
            "partner_password" => array('string', $newpass[0]),
            "partner_salt"     => array('string', $newpass[1])
        );
        //where条件
        $where = array(
            "partner_id" => array('number', $id)
        );
        //返回结果
        $r = $mypdo->sqlupdate($mypdo->prefix.'partner', $param, $where);
        return $r;
    }

    /**
     * Table_partner::lastID() 得到最后一条插入ID
     *
     * @return
     */
    static public function lastID(){
        global $mypdo;
        $sql = "select MAX(partner_id) from ".$mypdo->prefix."partner  ";
        $r = $mypdo->sqlQuery($sql);
        return $r;

    }
    /**
     * Table_partner::search() 用户搜索
     *
     * @param integer $page
     * @param integer $pagesize
     * @return
     */
    static public function search($page = 1, $pagesize = 10, $company='', $nikname = '', $phone = '',  $count = 0){
        global $mypdo, $mylog;

        $page     = $mypdo->sql_check_input(array('number', $page));
        $pagesize = $mypdo->sql_check_input(array('number', $pagesize));
        $company = "%$company%";
        $nikname = "%$nikname%";
        $phone ="%$phone%";
        $company    = $mypdo->sql_check_input(array('string', $company));
        $nikname    = $mypdo->sql_check_input(array('string', $nikname));
        $phone =    $mypdo->sql_check_input(array('string', $phone));
        $startrow = ($page - 1) * $pagesize;
        $sql = "select * from ".$mypdo->prefix."partner where 1=1 ";
        $sql .= " and partner_company like $company ";
        $sql .= " and partner_name like $nikname ";
        $sql .= " and partner_phone like $phone ";


        if($count){

            $r = $mypdo->sqlQuery($sql);
            return count($r);

        }else{
            $sql .= " order by partner_id desc limit $startrow, $pagesize";
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