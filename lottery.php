<?php
/**
 * 抽奖入口
 * Date: 2015/7/17
 * Time: 10:22
 */
define('HN1', true);
require_once('./global.php');

$user = $_SESSION['userinfo'];

require_once(LOGIC_ROOT.'lotteryBean.php');

$objLot = new lotteryBean();
$objLot->db = $db;
$objLot->setting = require_once( SCRIPT_ROOT.'lottery_setting.php');

$lotInfo = $objLot->get(1);
$curTime = time();

$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

$action = intval($act);
switch($action){
    case 1://抽奖
        if(!$lotInfo){
            ajaxResponse(false, '活动已停止');
        }elseif(!$lotInfo->status){
            ajaxResponse(false, '活动没有开始');
        }elseif($lotInfo->start_time > $curTime){
            ajaxResponse(false, '活动尚未开始');
        }elseif($lotInfo->end_time < $curTime){
            ajaxResponse(false, '活动已经结束');
        }elseif(empty($user)){
            ajaxResponse(false, '请先登录');
        }elseif(empty($user->openid)){
            ajaxResponse(false, '请先关注');
        }else{
            $uid = $user->id;
            !$uid && ajaxResponse(false, '没登录');
            !$objLot->can_lottery($uid) && ajaxResponse(false, '今天的抽奖机会已用完');
            $prize = $objLot->lottery();
            $prizeVal = '';
            $hbLogInfo = array();
            switch($prize['type']){
                case 0://微信红包
                    //红包金额
//                    $money = mt_rand($prize['data']['money']['min']*100, $prize['data']['money']['max']*100)/100;
//                    $prize['data']['prize'] .= '，金额：'.$money;
                    $_url = 'http://weixinm2c.taozhuma.com/hongbao.php?uid='.$user->openid;
                    $prizeVal = get_url_data_from_wx($_url);
                    $hbLogInfo = array(
                        'money' => is_numeric($prizeVal) ? $prizeVal : 0,
                        'remark' => '抽奖获得',
                    );
                    break;
                case 1://优惠券
                    $cpnId = $prize['data']['cpn_id'];
                    require_once(SCRIPT_ROOT.'logic/couponBean.php');
                    $objCpn = new couponBean();
                    $objCpn->db = $db;

                    //根据类型和内容获取优惠券信息(暂时) Start
                    $cpnData = array('type'=>2);
                    switch($cpnId){
                        case 1://5元
                            $cpnData['content'] = array('m'=>'5');
                            break;
                        case 2://10元
                            $cpnData['content'] = array('m'=>'10');
                            break;
                    }
                    if(!empty($cpnData['content'])){
                        $cpnData['content'] = json_encode($cpnData['content']);
                        $cpnInfo = $objCpn->getByInfo($cpnData);
                        $cpnId = $cpnInfo->coupon_id;
                    }
                    $cpnExtParam = array('starttime'=>$curTime, 'endtime'=>$curTime+86400*15, 'source'=>4);//收到后15天内有效
                    //根据类型和内容获取优惠券信息(暂时) End

                    $objCpn->bind_user($uid, $cpnId, $cpnNo, $cpnExtParam);
                    $prizeVal = $cpnNo;
                    break;
                case 2://转发攒运气
                    break;
                default:
                    break;
            }
            require_once(SCRIPT_ROOT.'logic/lottery_logBean.php');
            $objLog = new lottery_logBean();
            $objLog->db = $db;
            $objLog->add(array('uid'=>$uid, 'prize'=>$prize['data']['prize'], 'ptype'=>$prize['type'], 'pval'=>$prizeVal));
            $data = array(
                'pos' => $prize['data']['pos'],
                'prize' => $prize['data']['prize'],
                'ptype' => $prize['type'],
            );
            if(!empty($hbLogInfo)){
                require_once SCRIPT_ROOT.'logic/hongbao_logBean.php';
                $objHBL = new hongbao_logBean();
                $objHBL->db = $db;
                $objHBL->add($uid, $hbLogInfo);
            }
            ajaxResponse(true, '', $data);
        }
        break;
    case 2://转发
        $objLot->add_forward_log($user->id);
        break;
    default://界面
        $canLot = $user->id ? $objLot->can_lottery($user->id) : false;
        include 'tpl/lottery_web.php';
        break;
}

?>