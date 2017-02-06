<?php
/**
 * 基类
 */
class Base{
    protected $assigns = array();

    /**
     * 提示成功跳转
     *
     * @param string $msg 提示信息
     * @param string $url 跳转地址
     * @param integer $second 等待秒数
     */
    protected function success($msg='', $url=null, $second=3){
        $this->jump(true, $url, $msg, $second);
    }

    /**
     * 提示失败跳转
     *
     * @param string $msg 提示信息
     * @param string $url 跳转地址
     * @param integer $second 等待秒数
     */
    protected function error($msg='', $url=null, $second=3){
        $this->jump(false, $url, $msg, $second);
    }

    /**
     * 提示跳转
     *
     * @param boolean $status 状态
     * @param string $msg 提示信息
     * @param string $url 跳转地址
     * @param integer $second 等待秒数
     */
    protected function jump($status, $url, $msg=null, $second=3){
        is_null($url) && $url = $_SERVER['HTTP_REFERER'];
        if($second > 0) {
            $assign = array('status'=>$status, 'url'=>$url, 'msg'=>$msg, 'second'=>$second);
            renderTpl('tips', $assign);
        }else{
            header('location:'.$url);
        }
        exit();
    }

    /**
     * 设置要传递给模板的变量
     *
     * @param string $name 变量名
     * @param mixed $value 变量值
     */
    protected function assign($name, $value){
        $this->assigns[$name] = $value;
    }

    /**
     * 渲染模板
     *
     * @param string $tpl 模板名
     */
    protected function renderTpl($tpl){
        renderTpl($tpl, $this->assigns);
    }

    /**
     * 返回异步请求
     *
     * @param integer $state 状态码
     * @param string $msg 信息
     * @param array $data 额外数据
     */
    protected function ajaxResponse($state, $msg, $data=array()){
        $info = array('state'=>$state, 'msg'=>$msg);
        !empty($data) && $info = array_merge($info, $data);
        echo json_encode($info);
        exit();
    }
}