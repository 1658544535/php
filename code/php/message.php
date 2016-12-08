<?php
/*
 * 消息入口
 */
define('HN1', true);
require_once('./global.php');

$act = CheckDatas('act', '');

switch ($act) {
    case 'scroll': //无限滚动
        $messageType = CheckDatas('type', 0);

        include_once ('./tpl/message/msg_scroll_tpl.php');
        break;
    case 'detail': //消息详情

        include_once ('./tpl/message/msg_detail_tpl.php');
        break;
    default: //消息列表
        $getMessageList = apiData('myNoticeApi.do', array('userId' => $userid));
        if ($getMessageList['success'] != false) {
            $MessageList = $getMessageList['result'];
        }
        include_once ('./tpl/message/msg_list_tpl.php');
        break;
}

$footerNavActive = 'msg';
?>