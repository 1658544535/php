<?php
/**
 * 公共控制器(登录后)
 */
class Common extends Base{
    protected $admin;

    public function __construct(){
        $this->admin = $this->getAdmin();
        empty($this->admin) && $this->jump(false, url('publicOp', 'login'), '请先登录', 0);
    }

    protected function getAdmin(){
        return isset($_SESSION[SESS_ADMIN_K]) ? $_SESSION[SESS_ADMIN_K] : array();
    }
}