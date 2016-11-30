<?php
/*
 * 消息入口
 */
define('HN1', true);
require_once('./global.php');

$act = CheckDatas('act', '');

switch ($act) {
    case 'scroll':

        include_once ('./tpl/msg_scroll_tpl.php');
        break;
    case 'detail':

        include_once ('./tpl/msg_detail_tpl.php');
        break;
    default:
        include_once ('./tpl/msg_list_tpl.php');
        break;
}

$footerNavActive = 'msg';
?>