<?php
/**
 * 公开的控制器
 */
class PublicOp extends Base{
    /**
     * 登录
     */
    public function login(){
        if(IS_POST()){
            $account = array('uname'=>'admin', 'pwd'=>'123456');
            $username = CheckDatas('username');
            $password = CheckDatas('password');
            ($username == '') && ajaxReturn(false, '请输入帐号');
            ($password == '') && ajaxReturn(false, '请输入密码');
            if(($username == $account['uname']) && ($password == $account['pwd'])){
                $admin = array('username'=>$username);
                $_SESSION[SESS_ADMIN_K] = $admin;
                ajaxReturn(true, '登录成功');
            }else{
                ajaxReturn(false, '帐号或密码错误');
            }
        }else{
            !empty($_SESSION[SESS_ADMIN_K]) && redirect(url('Index', 'welcome'));
            renderTpl('login');
        }
    }

    /**
     * 退出
     */
    public function logout(){
        if(isset($_SESSION[SESS_ADMIN_K])) unset($_SESSION[SESS_ADMIN_K]);
        $this->jump(true, url('PublicOp', 'login'), '退出成功');
    }
}