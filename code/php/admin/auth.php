<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/16 0016
 * Time: 17:07
 */
include_once('global.php');

switch ($act) {
    case 'login':

        if (isset($_POST) && !empty($_POST)) {
            if ($_POST['username'] == $account['username'] && $_POST['passwd'] == $account['passwd']) {
                $_SESSION['admin_login'] = true;
                echo '<script>window.location.href="wx_menu.php"</script>';
            }
        }

        include_once ('tpl/menu_login.php');

        break;
    case 'logout':
        $_SESSION['admin_login'] = false;
        echo '<script>window.location.href="auth.php?act=login"</script>';
        break;
    default:
            include_once ('tpl/menu_login.php');
        break;
}