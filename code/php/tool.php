<?php
/**
 * 工具类相关
 */
define('HN1', true);
require_once('./global.php');

$type = isset($_GET['t']) ? trim($_GET['t']) : '';
switch($type){
    case 'cartnum'://购物车数量
        $result = array('n'=>0);
        if(!empty($openid)){
            $user = $_SESSION['userinfo'];
//            require_once LOGIC_ROOT.'sys_loginBean.php';
//            $sys_login = new sys_loginBean();
//            $user = $sys_login->detail_openid($db, $openid);
            if(!empty($user)){
                require_once LOGIC_ROOT.'user_cartBean.php';
                $objCart = new user_cartBean();
                $count = $objCart->getProductCount($db, $user->id, 2);
                !empty($count) && $result['n'] = $count;
            }
        }
        echo json_encode($result);
        exit();
        break;
}