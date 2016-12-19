<?php
/**
 * 首页
 */
class Index extends Common{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->assign('admin', $this->admin);
        $this->renderTpl('index');
    }

    public function welcome(){
        echo '<div style="margin:100px 0; text-align:center; font-size:30px;">后台管理</div>';
    }
}