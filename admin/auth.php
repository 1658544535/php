<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/16 0016
 * Time: 17:07
 */
include_once('global.php');

$account = array('username' => 'admin', 'passwd' => 'admin123');

switch ($act) {
    case 'login':
        if (isset($_POST) && !empty($_POST)) {
            if ($_POST['username'] == $account['username'] && $_POST['passwd'] == $account['passwd']) {
                $_SESSION['admin_login'] = true;
                Header("Location:index.php");
            } else {
                echo '<script>alert("账号密码错误");</script>';
            }
        }
        include_once ('tpl/menu_login.php');
        break;
    case 'logout':
        $_SESSION['admin_login'] = false;
        Header("Location:auth.php?act=login");
//        echo '<script>window.location.href="auth.php?act=login"</script>';
        break;
    default:
        Header("Location:auth.php?act=login");
//        echo '<script>window.location.href="auth.php?act=login"</script>';
        break;
}

if (!empty($_SESSION['admin_login'])){
//    echo '<script>window.location.href="index.php"</script>';
    Header("Location:index.php");
    exit;
}