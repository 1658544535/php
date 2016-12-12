<?php
/*
 * 消息入口
 */
define('HN1', true);
require_once('./global.php');

$act = CheckDatas('act', '');

switch ($act) {
    /*---------------------------------------------------------------------------
        --  瀑布流信息无限加载
     ---------------------------------------------------------------------------*/
    case 'scroll':
        $messageType = CheckDatas('type', 0);
        include_once ('./tpl/message/msg_scroll_tpl.php');
        break;
    /*---------------------------------------------------------------------------
        --  消息详情
     ---------------------------------------------------------------------------*/
    case 'detail':
        include_once ('./tpl/message/msg_detail_tpl.php');
        break;
    /*---------------------------------------------------------------------------
        --  消息列表
     ---------------------------------------------------------------------------*/
    default:
        $getMessageList = apiData('myNoticeApi.do', array('userId' => $userid));
        if ($getMessageList['success'] != false) {
            $MessageList = $getMessageList['result'];
        }
        include_once ('./tpl/message/msg_list_tpl.php');
        break;
}

$footerNavActive = 'msg';
?>