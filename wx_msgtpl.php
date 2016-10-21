<?php
define('HN1', true);
//require_once ('global.php');

error_reporting(E_ALL);

header("content-type: text/html; charset=utf-8");
session_start();
date_default_timezone_set('Asia/Shanghai'); 							// 设置默认时区

define('SYS_ROOT', dirname(__FILE__).'/');
define('APP_INC', dirname(__FILE__) . '/includes/inc/');
define('LIB_ROOT', dirname(__FILE__) . '/includes/lib/');
define('LOG_INC', dirname(__FILE__) . '/logs/');

define('API_URL', 'http://pdh.choupinhui.net/v3.5');
include_once(APP_INC.'config.php');
include_once(APP_INC.'functions.php');

//不配送的省份id，甘肃 海南 内蒙古 宁夏 青海 西藏 新疆
$unSendProviceIds = array(29,22,6,31,27,32);

//微信相关配置信息(用于微信类)
$wxOption = array(
    'appid' => $app_info['appid'],
    'appsecret' => $app_info['secret'],
    'token' => $app_info['token'] ? $app_info['token'] : 'weixin',
    'encodingaeskey' => $app_info['encodingaeskey'] ? $app_info['encodingaeskey'] : '',
);
include_once(LIB_ROOT.'/Weixin.class.php');
include_once(LIB_ROOT.'/weixin/errCode.php');
$objWX = new Weixin($wxOption);

$openid = trim($_GET['openid']);
$act = $_GET['act'];
switch($act){
    case 'pay'://支付
        $orderId = intval($_GET['oid']);
        $orderInfo = apiData('orderdetail.do', array('oid'=>$orderId));
        $result = '';
        if($orderInfo['success']){
            $orderInfo = $orderInfo['result'];
            $data = array(
                'touser' => $openid,
                'template_id' => 'HijtVshBey8vWEiheh97ih_VCMndYZv28ouP2lnyTa0',
                'url' => $site,//.'order_detail.php?oid='.$orderId,
                'topcolor' => '#000',
                'data' => array(
                    'first' => array(
                        'value' => '恭喜您支付成功！',
                        'color' => '#000',
                    ),
                    'keyword1' => array(
                        'value' => $orderInfo['productInfo']['orderPrice'],
                        'color' => '#000',
                    ),
                    'keyword2' => array(
                        'value' => $orderInfo['productInfo']['productName'],
                        'color' => '#000',
                    ),
                    'remark' => array(
                        'value' => '[重磅]提前双十一，全场玩具7.7！好玩低价，预购从速>>',
                        'color' => '#f00',
                    ),
                ),
            );

            $sendResult = $objWX->sendTemplateMessage($data);
            if($sendResult !== false){
                $result = json_encode($sendResult);
            }
        }
        echo $result;
        break;
    case 'open'://开团
        $orderId = intval($_GET['oid']);
        $orderInfo = apiData('orderdetail.do', array('oid'=>$orderId));
        $result = '';
        if($orderInfo['success']){
            $orderInfo = $orderInfo['result'];
            $data = array(
                'touser' => $openid,
                'template_id' => 'q6Kaj6ncMMCNAXWniidB8yH0AOgdSjuQ_b3J9dreWiI',
                'url' => $site,//.'order_detail.php?oid='.$orderId,
                'topcolor' => '#000',
                'data' => array(
                    'first' => array(
                        'value' => '恭喜您开团成功！',
                        'color' => '#000',
                    ),
                    'keyword1' => array(
                        'value' => $orderInfo['productInfo']['orderPrice'],
                        'color' => '#000',
                    ),
                    'keyword2' => array(
                        'value' => $orderInfo['productInfo']['productName'],
                        'color' => '#000',
                    ),
                    'keyword3' => array(
                        'value' => $orderInfo['addressInfo']['consignee'].' '.$orderInfo['addressInfo']['tel'].' '.$orderInfo['addressInfo']['address'],
                        'color' => '#000',
                    ),
                    'keyword4' => array(
                        'value' => $orderInfo['orderInfo']['orderNo'],
                        'color' => '#000',
                    ),
                    'remark' => array(
                        'value' => '[重磅]提前双十一，全场玩具7.7！好玩低价，预购从速>>',
                        'color' => '#ff0000',
                    ),
                ),
            );

            $sendResult = $objWX->sendTemplateMessage($data);
            if($sendResult !== false){
                $result = json_encode($sendResult);
            }
        }
        echo $result;
        break;
    case 'join'://拼团
        $orderId = intval($_GET['oid']);
        $orderInfo = apiData('orderdetail.do', array('oid'=>$orderId));
        $result = '';
        if($orderInfo['success']){
            $orderInfo = $orderInfo['result'];
            $data = array(
                'touser' => $openid,
                'template_id' => 'JUakJR3M_mE7MnrDGf_1kbWsmNAjTnUb458XYwn6aSM',
                'url' => $site,//.'groupon_join.php?aid='.$orderInfo['attendId'],
                'topcolor' => '#000',
                'data' => array(
                    'first' => array(
                        'value' => '恭喜您拼团成功！我们将尽快为你发货。',
                        'color' => '#000',
                    ),
                    'keyword1' => array(
                        'value' => $orderInfo['orderInfo']['orderNo'],
                        'color' => '#000',
                    ),
                    'keyword2' => array(
                        'value' => $orderInfo['productInfo']['orderPrice'],
                        'color' => '#000',
                    ),
                    'remark' => array(
                        'value' => '[重磅]提前双十一，全场玩具7.7！好玩低价，预购从速>>',
                        'color' => '#f00',
                    ),
                ),
            );

            $sendResult = $objWX->sendTemplateMessage($data);
            if($sendResult !== false){
                $result = json_encode($sendResult);
            }
        }
        echo $result;
        break;
    case 'delivery'://发货
        $result = '';
        $orderId = intval($_GET['oid']);
        $orderInfo = apiData('orderdetail.do', array('oid'=>$orderId));
        if($orderInfo['success']){
            $orderInfo = $orderInfo['result'];
            if($orderInfo['orderStatus'] == 3){
                $data = array(
                    'touser' => $openid,
                    'template_id' => 'EGztXez9id31kHrJZo6i-pY6523kx15PDgvC80Qw658',
                    'url' => $site,//.'order_detail.php?oid='.$orderId,
                    'topcolor' => '#000',
                    'data' => array(
                        'first' => array(
                            'value' => '您购买的商品已经发货啦！',
                            'color' => '#000',
                        ),
                        'keyword1' => array(
                            'value' => $orderInfo['orderInfo']['logisticsName'],
                            'color' => '#000',
                        ),
                        'keyword2' => array(
                            'value' => $orderInfo['orderInfo']['logisticsNo'],
                            'color' => '#000',
                        ),
                        'keyword3' => array(
                            'value' => $orderInfo['productInfo']['productName'],
                            'color' => '#000',
                        ),
                        'keyword4' => array(
                            'value' => $orderInfo['productInfo']['number'],
                            'color' => '#000',
                        ),
                        'remark' => array(
                            'value' => '[重磅]提前双十一，全场玩具7.7！好玩低价，预购从速>>',
                            'color' => '#f00',
                        ),
                    ),
                );

                $sendResult = $objWX->sendTemplateMessage($data);
                if($sendResult !== false){
                    $result = json_encode($sendResult);
                }
            }
        }
        break;
    case 'refund'://退款
        $result = '';
        $orderId = intval($_GET['oid']);
        $uid = intval($_GET['uid']);
        $refundInfo = apiData('refundDetails.do', array('oid'=>$orderId, 'uid'=>$uid));
        if($refundInfo['success']){
            $refundInfo = $refundInfo['result'];
            $orderInfo = apiData('orderdetail.do', array('oid'=>$orderId));
            $typeMap = array(1=>'仅退款', 2=>'退货退款');
            $data = array(
                'touser' => $openid,
                'template_id' => '-ufIIBoIsqG6QOFo7N8N19n3jBx9Lguyi7VqAITE8kU',
                'url' => $site,//.'groupon_join.php?aid='.$orderInfo['attendId'],
                'topcolor' => '#000',
                'data' => array(
                    'first' => array(
                        'value' => '退款成功！',
                        'color' => '#000',
                    ),
                    'keyword1' => array(
                        'value' => $refundInfo['refundPrice'],
                        'color' => '#000',
                    ),
                    'keyword2' => array(
                        'value' => $typeMap[$refundInfo['type']],
                        'color' => '#000',
                    ),
                    'keyword3' => array(
                        'value' => $refundInfo['refundType'],
                        'color' => '#000',
                    ),
                    'keyword4' => array(
                        'value' => '',
                        'color' => '#000',
                    ),
                    'keyword5' => array(
                        'value' => $orderInfo['result']['orderInfo']['orderNo'],
                        'color' => '#000',
                    ),
                    'remark' => array(
                        'value' => '[重磅]提前双十一，全场玩具7.7！好玩低价，预购从速>>',
                        'color' => '#f00',
                    ),
                ),
            );

            $sendResult = $objWX->sendTemplateMessage($data);
            if($sendResult !== false){
                $result = json_encode($sendResult);
            }
        }
        break;
}
?>