<?php
/**
 * 订单详情字段判断
 * Created by PhpStorm.
 * User: Jasper
 * Date: 2016/12/2 0002
 * Time: 14:17
 */

if($OrderDetail['result']['source'] != 5 && $OrderDetail['result']['source'] != 7) {
    if ($OrderDetail['result']['isSuccess'] == 2) {
        $statusTitle = '拼团失败';
        $statusState = '未成团，退款中';
        $statusTips  = '未成团，退款中';
        $statusImg   = 8;
        if ($OrderDetail['result']['refPriStatus'] == 2) {
            $statusState = '未成团，退款成功';
            $statusTips  = '未成团，退款成功';
            $statusImg   = 7;
        };
    }

    switch ($OrderDetail['result']['orderStatus']) {
        case 1:
            if ($OrderDetail['result']['isCancel'] == 0) {
                $statusTitle = '确认订单';
                $statusState = '等待买家付款';
                $statusTips  = '待支付';
                $statusImg   = 2;
            }
            if ($OrderDetail['result']['isCancel'] == 1) {
                $statusTitle = '交易已取消';
                $statusState = '交易已取消';
                $statusTips  = '交易已取消';
                $statusImg   = 5;
            }
            break;
        case 2:
            if ($OrderDetail['result']['isSuccess'] ==1) {
                $statusTitle = '拼团成功';
                $statusState = '拼团成功，等待卖家发货！';
                $statusTips  = '已成团，待发货';
                $statusImg   = 1;
            }
            if ($OrderDetail['result']['isSuccess'] ==0) {
                $statusTitle = '拼团中';
                $statusState = '拼团还未成功，赶快召唤小伙伴！';
                $statusTips  = '拼团中';
                $statusImg   = 4;
            }
            break;
        case 3:
            $statusTitle = '待收货';
            $statusState = '卖家已发货';
            $statusTips  = '待收货';
            $statusImg   = 4;
            break;
        case 4:
            $statusTitle = '已签收';
            $statusState = '交易成功！';
            $statusTips  = '已签收';
            $statusImg   = 6;
            break;
    }
}

if ($OrderDetail['result']['source'] == 7 || $OrderDetail['result']['source'] == 5 ) {

    $titleArr = array(
        1 => '确认订单',
        2 => '拼团中',
        3 => '拼团失败',
        4 => '拼团失败',
        5 => '交易已取消',
        6 => '未中奖',
        7 => '未中奖',
        9 => '已签收',
        10=> '拼团成功',
        11=> '待收货',
        12=> '待开奖'
    );

    $stateArr = array(
        1 => '等待买家付款',
        2 => '拼团还未成功，赶快召唤小伙伴！',
        3 => '未成团，退款中',
        4 => '未成团，已退款',
        5 => '交易已取消',
        6 => '未中奖，返款中',
        7 => '未中奖，已返款',
        9 => '交易成功！',
        10=> '拼团成功，等待卖家发货！',
        11=> '卖家已发货',
        12=> '已成团，待开奖'
    );

    $tipsArr = array(
        1 => '待支付',
        2 => '拼团中',
        3 => '未成团，退款中',
        4 => '未成团，已退款',
        5 => '交易已取消',
        6 => '未中奖，返款中',
        7 => '未中奖，已返款',
        9 => '已签收',
        10=> '已中奖，待发货',
        11=> '待收货',
        12=> '已成团，待开奖'
    );

    $statusTitle = $titleArr[$OrderDetail['result']['orderStatus']];
    $statusState = $stateArr[$OrderDetail['result']['orderStatus']];
    $statusTips  = $tipsArr[$OrderDetail['result']['orderStatus']];
    $statusImg   = getStatusImg($OrderDetail['result']['orderStatus']);

    if ($OrderDetail['result']['source'] ==7) {
        if ($OrderDetail['result']['orderStatus'] ==3) {
            $statusState = '未成团，已退款';
            $statusTips  = '未成团，已退款';
        } elseif ($OrderDetail['result']['orderStatus'] ==6) {
            $statusState = '未中奖，已返款';
            $statusTips  = '未中奖，已返款';
        }
    }

}

/*
 * 根据状态返回相应的状态北京图片
 * 用于免费抽奖
 * @param $status 订单状态 $OrderDetail['result']['orderStatus']
 * @return int 状态图片标识
 */
function getStatusImg($status = ''){
    if (empty($status)) return false;
    $imgArr = array(
        1  => 2,
        2  => 4,
        3  => 8,
        4  => 7,
        5  => 5,
        6  => 7,
        7  => 7,
        9  => 6,
        10 => 1,
        11 => 3,
        12 => 4,
    );
    return $imgArr[$status];
}

?>