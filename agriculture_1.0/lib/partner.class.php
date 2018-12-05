<?php

/**
 * partner.class.php 用户类
 *
 * @version       v0.01
 * @create time   2016/11/14
 * @update time   2016/11/17
 * @author        IngeTeng
 * @copyright     Neptune工作室
 */

class Partner {

    public $id = 0;                
    public $account = '';              
    public function __construct($id = 0) {
        if(!empty($id)) {
            $partner = self::getInfoById($id);
            if($partner){
                $this->id      = $partner['id'];
                $this->account = $partner['account'];
                $this->name    = $partner['name'];
                $this->openid  = $partner['openid'];
                $this->phone   = $partner['phone'];
            }else{
                throw new MyException('分销商不存在', 902);
            }
        }
    }

    /**
     * Partner::getInfoById()
     *
     * @param mixed $id
     * @return
     */
    static public function getInfoById($id){
        if(empty($id)) throw new MyException('ID不能为空', 101);

        return Table_partner::getInfoById($id);
    }
    /**
     * Partner::getNameById()
     *
     * @param mixed $id
     * @return
     */
    static public function getNameById($id){
        if(empty($id)) throw new MyException('ID不能为空', 101);

        return Table_partner::getNameById($id);
    }

    /**
     * Admin::login() 管理员登录
     * 
     * @param string  $account   账号
     * @param string  $password  密码
     * @param integer $cookie    
     * 
     * @return
     */
    public function login($account, $password, $cookie = 0){
        
        if(empty($account))throw new MyException('账号不能为空', 101);
        if(empty($password))throw new MyException('密码不能为空', 102);

        //检查账号
        $partnerinfo = Table_partner::getInfoByAccount($account);
        if($partnerinfo == 0) {
            //不让用户准确知道是账号错误
            throw new MyException('账号或密码错误', 104);
        }

        //验证密码
        $password = self::buildPassword($password, $partnerinfo['salt']);
        if($password[0] == $partnerinfo['password']){
            //登录成功
            $this->id         = $partnerinfo['id'];
            $this->account    = $partnerinfo['account'];
            
            //设置cookie;
            if($cookie) $this->buildCookie();

            //设置session
            self::setSession(1, $this->id);
            
            return action_msg('登录成功', 1);//登陆成功
        }else{
             throw new MyException('账号或密码错误', 104);
        }
    }


    /**
     * Partner::buildCookie()   设置登陆cookie
     * 
     * @return void
     */
    private function buildCookie(){
        global $cookie_PARTNER, $cookie_PARTNERCODE;
        
        $cookie_time = time()+(3600*24*7);//7天

        setcookie($cookie_PARTNER, $this->id, $cookie_time);
        setcookie($cookie_PARTNERCODE, self::getCookieCode($this->id, $this->account,$this->gid), $cookie_time);
    }

    //消除cookie
    static private function rebuildCookie(){
        global $cookie_PARTNER, $cookie_PARTNERCODE;

        setcookie($cookie_PARTNER, '', time()-3600);
        setcookie($cookie_PARTNERCODE, '', time()-3600);
    }
    
    //生成cookie校验码
    static private function getCookieCode($id = 0, $account = ''){
        if(empty($id))throw new MyException('ID不能为空', 101);
        if(empty($account))throw new MyException('账号不能为空', 102);

        return md5(md5($account).md5($id));//校验码算法
    }
    /**
     * Admin::setSession()   设置登陆Session
     * 
     * @param $type  1--记录Session  2--清除记录
     * @return void
     */
    static private function setSession($type, $id = 0){
        global $session_PARTNER;
        
        if($type == 1){
            if(empty($id))throw new MyException('ID不能为空', 101);
            $_SESSION[$session_PARTNER]    = $id;
        }else{
            $_SESSION[$session_PARTNER]    = 0;
        }
    }

    /**
     * Admin::logout()  退出登录
     * 
     * @return void
     */
    static public function logout(){
        

        self::setSession(2);
        self::rebuildCookie();

    }
    
    /**
     * Partner::checkLogin()  检查是否登录
     * 
     * @return
     */
    static public function checkLogin(){
        global $session_PARTNER;
        global $cookie_PARTNER, $cookie_PARTNERCODE;
        
        //是否存在session
        if(@$_SESSION[$session_PARTNER]){
            return true;
        }
        
        //不存在session则检查是否有cookie
        $cid   = $_COOKIE[$cookie_PARTNER];
        if(empty($cid)){
            return false;
        }
        
        //检查cookie数据是否对应，防止伪造
        $vcode = $_COOKIE[$cookie_PARTNERCODE];
        $partner = Table_partner::getInfoById($cid);
        
        if(!$partner) {
            //cookie数据不正确，清理掉
            self::rebuildCookie();
            return false;
        }

        $code = self::getCookieCode($cid, $partner['account']);
        
        if($vcode != $code){
            //cookie数据不正确，清理掉
            self::rebuildCookie();
            return false;
        }

        //cookie数据正确，重写Session
        self::setSession(1, $cid);
        return true;
    }
    
    /**
     * Partner::getSession() 获得Session
     * 
     * @return 
     */
    static public function getSession(){
        global $session_PARTNER;

        return $_SESSION[$session_PARTNER];
    }
    public function getAccount(){
        return $this->account;
    }

    public function getId(){
        return $this->id;
    }
    public function getPhone(){
        return $this->phone;
    }
    public function getName(){
        return $this->name;
    }
    /**
     * Partner::add()
     *
     * @param array $userAttr
     * $userAttr数组键：photo,name,sex,phone,idcard,birth
     *
     * @return void
     */
    static public function add($partnerAttr = array()){

        //添加和修改的操作校验相同。所以单独做个函数
        $okAttr = self::checkInputaddParam($partnerAttr);

        $rs = Table_partner::add($okAttr);

        if($rs > 0){
            //记录管理员日志log表
            /*$msg = '成功添加分销商('.$okAttr['name'].')';
            Adminlog::add($msg);*/

            return action_msg('已提交申请', 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }


    /**
     * Partner::edit()
     *
     * @param mixed $id
     * @param array $userAttr
     * $userAttr数组键：photo,name,sex,phone,idcard,birth
     *
     * @return
     */
    static public function edit($id, $partnerAttr){

        if(empty($id)) throw new MyException('ID不能为空', 100);

        $okAttr = self::checkInputeditParam($id,$partnerAttr);
        $rs = Table_partner::edit($id, $okAttr);

        if($rs >= 0){
            $msg = '成功修改分销商('.$id.')';
            Adminlog::add($msg);

            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }

    /**
     * Partner::edit()
     *
     * @param mixed $id
     * @param array $userAttr
     * $userAttr数组键：photo,name,sex,phone,idcard,birth
     *
     * @return
     */
    static public function edit_nopass($id, $partnerAttr){

        if(empty($id)) throw new MyException('ID不能为空', 100);

        $okAttr = self::checkInputedit_nopassParam($id,$partnerAttr);
        $rs = Table_partner::edit_nopass($id, $okAttr);

        if($rs >= 0){
            $msg = '成功修改分销商('.$id.')';
            Adminlog::add($msg);

            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }
     /**
     * Partner::edit()
     *
     * @param mixed $id
     * @param array $userAttr
     * $userAttr数组键：photo,name,sex,phone,idcard,birth
     *
     * @return
     */
    static public function update_msg($roleid,$id, $Attr){

        if(empty($roleid)) throw new MyException('ID不能为空', 100);

        $rs = Table_partner::update_msg($roleid, $id, $Attr);

        if($rs >= 0){
            $msg = '成功修改经销商信息('.$roleid.')';
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }
    /**
     * Partner::checkUserInputaddParam()
     *
     * @param array $userAttr
     *
     * @return void
     */
    static private function checkInputaddParam($partnerAttr){
        if(empty($partnerAttr) || !is_array($partnerAttr)) throw new MyException('参数错误', 100);
        if(empty($partnerAttr['name'])) throw new MyException('真实姓名不能为空', 201);
        if(empty($partnerAttr['nikname'])) throw new MyException('微信呢称不能为空', 201);
        if(empty($partnerAttr['openid'])) throw new MyException('微信识别码不能为空', 201);
        //if(empty($partnerAttr['account'])) throw new MyException('登陆账号不能为空', 201);
        /*//生成密码
        if(ParamCheck::is_weakPwd($partnerAttr['password'])) throw new MyException('密码太弱', 103);
        $partnerAttr['password'] = self::buildPassword($partnerAttr['password']);*/
        
        if(empty($partnerAttr['address'])) throw new MyException('详细地址不能为空', 202);
        if(empty($partnerAttr['qrcode'])) throw new MyException('转账二维码不能为空', 202);
        $partnerAttr['product'] = ckReplace($partnerAttr['product']);
        if(!empty($partnerAttr['phone'])){
            if(!is_mobile($partnerAttr['phone'])){
                throw new MyException('电话格式不正确', 206);
            }
        }
        return $partnerAttr;
    }

    /**
     * Partner::checkUserInputeditParam()
     *
     * @param array $userAttr
     *
     * @return void
     */
    static private function checkInputeditParam($id,$partnerAttr){
        if(empty($partnerAttr) || !is_array($partnerAttr)) throw new MyException('参数错误', 100);
        if(empty($partnerAttr['name'])) throw new MyException('真实姓名不能为空', 201);
        if(empty($partnerAttr['nikname'])) throw new MyException('微信呢称不能为空', 201);
        if(empty($partnerAttr['openid'])) throw new MyException('微信识别码不能为空', 201);
        if(empty($partnerAttr['account'])) throw new MyException('登陆账号不能为空', 201);
        //生成密码
        //$partnerAttr['password'] = self::buildPassword($partnerAttr['password']);
        //生成密码
        if(ParamCheck::is_weakPwd($partnerAttr['password'])) throw new MyException('密码太弱', 103);
        $partnerAttr['password'] = self::buildPassword($partnerAttr['password']);
        self::checkParamState($partnerAttr['state']);
        if(empty($partnerAttr['address'])) throw new MyException('详细地址不能为空', 202);
        if(empty($partnerAttr['qrcode'])) throw new MyException('转账二维码不能为空', 202);
        if(!empty($partnerAttr['phone'])){
            if(!is_mobile($partnerAttr['phone'])){
                throw new MyException('电话格式不正确', 206);
            }
        }

        $partner = Table_partner::getInfoById($id);
        if(empty($partner)) throw new MyException('分销商不存在', 104);

        //验证账号是否改变，如果改变则需要检查账号的重复性
        if($partner['account'] != $partnerAttr['account']){
            $partner2 = Table_partner::getInfoByAccount($partnerAttr['account']);
            if($partner2) throw new MyException('账号已经存在', 105);
        }

        return $partnerAttr;
    }

    /**
     * Partner::checkUserInputeditParam()
     *
     * @param array $userAttr
     *
     * @return void
     */
    static private function checkInputedit_nopassParam($id,$partnerAttr){
        if(empty($partnerAttr) || !is_array($partnerAttr)) throw new MyException('参数错误', 100);
        if(empty($partnerAttr['name'])) throw new MyException('真实姓名不能为空', 201);
        if(empty($partnerAttr['nikname'])) throw new MyException('微信呢称不能为空', 201);
        if(empty($partnerAttr['openid'])) throw new MyException('微信识别码不能为空', 201);
    
        self::checkParamState($partnerAttr['state']);
        if(empty($partnerAttr['address'])) throw new MyException('详细地址不能为空', 202);
        if(empty($partnerAttr['qrcode'])) throw new MyException('转账二维码不能为空', 202);
        if(!empty($partnerAttr['phone'])){
            if(!is_mobile($partnerAttr['phone'])){
                throw new MyException('电话格式不正确', 206);
            }
        }
        $partner = Table_partner::getInfoById($id);
        if(empty($partner)) throw new MyException('分销商不存在', 104);


        return $partnerAttr;
    }
    /**
     * Partner::buildPassword()  生成密码
     * 
     * @param string $pwd   原始密码
     * @param string $salt  密码Salt
     * @return 
     */
    static private function buildPassword($pwd, $salt = ''){

        if(empty($pwd))throw new MyException('密码不能为空', 101);
        if(empty($salt)) $salt = randcode(10, 4);//生成Salt

        $pwd_new = md5(md5($pwd).$salt);//加密算法

        return array($pwd_new, $salt);
    }
    /**
     * Partner::resetPwd()  重置密码
     * @param integer  $id   ID
     * @param string  $newpass   新密码
     * 
     * @return
     */
    static public function resetPwd($id, $newpass){
        
        if(empty($id))throw new MyException('管理员ID不能为空', 101);
        if(empty($newpass))throw new MyException('新的密码不能为空', 102);

        if(ParamCheck::is_weakPwd($newpass)) throw new MyException('新密码太弱', 103);

        $pass = self::buildPassword($newpass);

        $rs = Table_partner::updatePwd($id, $pass);

        if($rs == 1){
            $msg = '分销商('.$id.')密码成功重置为'.$newpass.'。';
            Adminlog::add($msg);

            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 104);
        }
    }

    
    public function updatePwd_partner($oldpwd, $newpwd,$id){

        if(empty($oldpwd))throw new myException('旧密码不能为空', 101);
        if(empty($newpwd))throw new myException('新密码不能为空', 102);
        if(ParamCheck::is_weakPwd($newpwd)) throw new myException('新密码太弱', 104);
        $partner = self::getInfoById($id);
        //验证密码是否正确
        $oldpass = self::buildPassword($oldpwd, $partner['salt']);
        if($oldpass[0] != $partner['password']){
            throw new myException('旧密码错误', 103);
        }

        //产生新密码
        $newpass = self::buildPassword($newpwd);

        //修改密码
        
        $rs = Table_partner::updatePwd($id, $newpass);
        if($rs == 1){
            $msg = '修改密码成功';

            //Adminlog::add($msg);
            return action_msg($msg, 1);
        }else{
            throw new myException('操作失败', 444);
        }
    }
    /**
     * Partner::updatePwd()      修改密码
     * 
     * @param string  $oldpwd   旧密码
     * @param string  $newpwd   新密码
     * 
     * @return
     */
    public function updatePwd($oldpwd, $newpwd){

        if(empty($oldpwd))throw new myException('旧密码不能为空', 101);
        if(empty($newpwd))throw new myException('新密码不能为空', 102);
        if(ParamCheck::is_weakPwd($newpwd)) throw new myException('新密码太弱', 104);
        $partner = self::getInfoById($this->id);
        //验证密码是否正确
        $oldpass = self::buildPassword($oldpwd, $partner['salt']);
        if($oldpass[0] != $partner['password']){
            throw new myException('旧密码错误', 103);
        }

        //产生新密码
        $newpass = self::buildPassword($newpwd);

        //修改密码
        
        $rs = Table_partner::updatePwd($this->id, $newpass);
        if($rs == 1){
            $msg = '修改密码成功';

            //Adminlog::add($msg);
            return action_msg($msg, 1);
        }else{
            throw new myException('操作失败', 444);
        }
    }
    /**
     * Partner::checkParamSex()
     *
     * @param mixed $sex
     * @return void
     */
    static private function checkParamState($state){
        if(!preg_match('/^-?\d+$/', $state)) throw new MyException('state必须为整数', 101);
        if(!self::getStateName($state))  throw new MyException('状态不存在', 102);
    }

    /**
     * Partner::getSexName()
     *
     * @param mixed $sex
     * @return
     */
    static public function getStateName($state){
        switch($state){
            case 1:
                return '已审核';
                break;

            case 0:
                return '待审核';
                break;

            default:
                return false;
                break;
        }
    }

    /**
     * Partner::del()
     *
     * @param mixed $id
     * @return
     */
    static public function del($id){

        if(empty($id))throw new MyException('ID不能为空', 101);

        $rs = Table_partner::del($id);
        if($rs == 1){

            $msg = '删除分销商('.$id.')成功!';
            Adminlog::add($msg);

            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 102);
        }
    }

  /**
     * Partner::getAllList()
     *
     * @param integer $page
     * @param integer $pagesize
     * @param integer $count //是否仅作统计 1 - 统计
     * @return
     */
    static public function getAllList(){
       

        return Table_partner::getAllList();
    }
    /**
     * Partner::search()
     *
     * @param integer $page
     * @param integer $pagesize
     * @param integer $count //是否仅作统计 1 - 统计
     * @return
     */
    static public function search($page = 1, $pagesize = 10, $company = '', $nikname = '', $phone='' ,$count = 0){
        if(!preg_match('/^\d+$/', $page)) $page = 1;
        if(!preg_match('/^\d+$/', $pagesize)) $pagesize = 10;

        return Table_partner::search($page, $pagesize,$company, $nikname, $phone,$count);
    }
}
?>