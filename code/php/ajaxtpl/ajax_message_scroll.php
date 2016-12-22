<?php
/*
 * 获取瀑布流消息ajax
 */
define('HN1', true);
require_once('../global.php');

$messageType = CheckDatas('type', 0);
$pageNo      = CheckDatas('page',0);

//不同消息类型的获取信息接口名字数组
$apiNameArr  = array(
    1=>'',
    2=>'',
    3=>'userOrderNoticeApi.do',  //用户订单信息
);

$getMessage = apiData($apiNameArr[$messageType], array('userId'=>$userid, 'pageNo'=>$pageNo));

if ($getMessage['success'] != false && $getMessage['result']) {
    $messageList = array_reverse($getMessage['result']);
    foreach ($messageList as $key => $val) {
        $messageList[$key]['url'] = createUrl($val['linkType'], $val['linkParam']);
    }
    $data = ajaxJson(1, '获取成功', $messageList, $pageNo);
} else {
    $data = ajaxJson(0, '获取失败');
}

echo $data;
exit;

/*
 * 根据链接类型生成对应的链接
 * 1-商品详情页，2-订单详情页，3-团详情页，4-首页，5-普通拼团，
 * 6-猜价格，7-免费抽奖，8-专题，9-专题分类，10-77专区，11-0.1夺宝
 * @param int $linkType   类型
 *        int $linkParam  对应的id
 * @return string $url    生成的链接
 */
function createUrl($linkType, $linkParam) {
    switch ($linkType) {
        case 1:
            $url = '/groupon.php?id=' . $linkParam;
            break;
        case 2:
            $url = '/order_detail.php?oid=' . $linkParam;
            break;
        case 3:
            $url = '/groupon_join.php?aid=' . $linkParam;
            break;
        case 4:
            $url = '/';
            break;
        case 5:
            $url = '/groupon.php?id=' . $linkParam;
            break;
        case 6:
            $url = '/product_guess_price.php';
            break;
        case 7:
            $url = '/freedraw.php';
            break;
        case 8:
            $url = '/groupon.php?id=' . $linkParam;
            break;
        case 9:
            $url = '/special.php?id=' . $linkParam;
            break;
        case 10:
            $url = '/groupon.php?id=' . $linkParam;
            break;
        case 11:
            $url = '/groupon.php?id=' . $linkParam;
            break;
        default:
            $url = '#';
            break;
    }
    return $url;
}
?>