<?php
/**
 * 转盘抽奖
 */
define('HN1', true);
require_once('./global.php');

//IS_USER_LOGIN();
$isLogin = $bLogin;

$lotData = __getTurntableInfo();
$lotInfo = $lotData['data'];

$act = CheckDatas('act', '');
switch($act){
	case 'lottery'://抽奖
        !$isLogin && ajaxReturn(0, '请先登录');
	    switch($lotData['state']){
            case 1:case 3:
                ajaxReturn(4, '活动已结束');
                break;
            case 2:
                ajaxReturn(3, '活动未开始');
                break;
            case 4:
                ajaxReturn(5, '今日名额已完');
                break;
        }

		$chance = apiData('getTurntableNumApi.do', array('uid'=>$userid));
		$chance = (empty($chance) || !$chance['success']) ? 0 : $chance['result'];
		!$chance && ajaxReturn(2, '您的机会已用完');

		$mdlLog = M('wxhd_luck_draw_log');
		
		//当前第几次参与
		$hadJoinNum = $mdlLog->getCount(array('uid'=>$userid, 'hd_id'=>$lotInfo['id'], 'is_real'=>1));
		$curJoinNum = $hadJoinNum+1;
		
		$success = false;
		$mdlLog->startTrans();

		//获取抽中奖品
        $winItemIndex = null;
		if(in_array($curJoinNum, array(1,2))){
			$lotItems = __getItems($lotInfo['id'], $curJoinNum);
			$itemIndexes = array();
			foreach($lotItems as $k => $v){
				$itemIndexes[] = $k;
			}
			shuffle($itemIndexes);
			$winItemIndex = $itemIndexes[0];
		}
		if(is_null($winItemIndex)){
			$lotItems = __getItems($lotInfo['id']);
			$ratios = array();
			foreach($lotItems as $k => $v){
				$ratios[$k] = $v['ratio'];
			}
			$winItemIndex = __getRand($ratios);
		}
		$prize = $lotItems[$winItemIndex];

		$sql = 'UPDATE `wxhd_turntable_item` SET `join_num`=`join_num`+1 WHERE `id`='.$prize['id'];
		if($db->query($sql)){
			$logData = array(
				'uid' => $userid,
				'loginname' => $user->loginname,
				'openid' => $user->openid,
				'hd_id' => $lotInfo['id'],
				'item_id' => $prize['id'],
				'item_type' => $prize['type'],
				'item_name' => $prize['name'],
				'item_value' => $prize['item_value'],
				'time' => time(),
				'status' => 1,
				'is_prize' => $prize['is_prize'],
				'is_virtual' => $prize['is_virtual'],
                'is_real' => 1,
			);
			($mdlLog->add($logData) !== false) && $success = true;
		}
		if($success){
			$updateChance = apiData('turntNumMinusApi.do', array('uid'=>$userid));
			if(empty($updateChance) || !$updateChance['success'] || ($updateChance['result'] == 0)){
				$success = false;
			}
		}

		if($success){
			$mdlLog->commit();
			ajaxReturn(1, $prize['name'], array('angle'=>$prize['angle']));
		}else{
			$mdlLog->rollback();
			ajaxReturn(4, '活动已结束');
		}

		break;
	case 'send'://发放
		error_reporting(E_ALL);
		if($isLogin){
			$sql = 'SELECT * FROM `wxhd_luck_draw_log` WHERE `hd_id`='.$lotInfo['id'].' AND `uid`='.$userid.' AND `item_type`=1 AND `status`=1 AND `is_real`=1 ORDER BY `time` ASC';
			$list = $db->get_results($sql, ARRAY_A);
			$count = count($list);
			if($count > 1){
				$time = time();
				$_dir = LOG_INC.'wxhb_turntable/';
				!file_exists($_dir) && mkdir($_dir, 0777, true);
				$logFile = $_dir.date('Y-m-d', $time).'.txt';

				$hongbao = array(
					'sendName' => '拼得好',
					'num' => 1,
					'wishing' => '恭喜中奖',
					'activityName' => '抽奖红包',
					'remark' => '拼得好祝恭喜您抽中红包',
				);

				try{
                    include_once('./wxpay/lib/WxHongBao.Api.php');
                    $hbApi = new WxHongBaoApi();
                    $mdlSendLog = new Model($db, 'wxhb_send_log');
                    $endIndex = ($count % 2 == 0) ? ($count-1) : floor($count/2)*2;
                    for($i=0; $i<=$endIndex; $i++){
                        $hongbao['openid'] = $list[$i]['openid'];
                        $hongbao['amount'] = $list[$i]['item_value'];

                        $result = $hbApi->sendRedPack($hongbao);
                        if($result['return_code'] != 'SUCCESS'){
                            $content = "帐号[{$list[$i]['loginname']}]，openid[{$hongbao['openid']}]抽中“{$list[$i]['item_name']}”，抽奖记录ID：{$list[$i]['id']}，发放红包失败[return_code:{$result['return_code']}]：{$result['return_msg']}";
                        }elseif($result['result_code'] != 'SUCCESS'){
                            $content = "帐号[{$list[$i]['loginname']}]，openid[{$hongbao['openid']}]抽中“{$list[$i]['item_name']}”，抽奖记录ID：{$list[$i]['id']}，发放红包失败[result_code:{$result['err_code']}]：{$result['err_code_des']}";
                        }else{
                            $content = "帐号[{$list[$i]['loginname']}]，openid[{$hongbao['openid']}]抽中“{$list[$i]['item_name']}”，抽奖记录ID：{$list[$i]['id']}，发放红包成功";
                            file_put_contents($logFile, "【".date('Y-m-d H:i:s', $time)."】{$content}\r\n", FILE_APPEND);
                            $sql = 'UPDATE `wxhd_luck_draw_log` SET `status`=2 WHERE `id`='.$list[$i]['id'];
                            if($db->query($sql) === false){
                                $content = "帐号[{$list[$i]['loginname']}]，openid[{$hongbao['openid']}]抽中“{$list[$i]['item_name']}”，抽奖记录ID：{$list[$i]['id']}，发放红包成功，更改发放状态失败";
                            }else{
                                $content = "帐号[{$list[$i]['loginname']}]，openid[{$hongbao['openid']}]抽中“{$list[$i]['item_name']}”，抽奖记录ID：{$list[$i]['id']}，发放红包成功，更改发放状态成功";
                            }
                            $sendLog = array(
                                're_openid' => $result['re_openid'],
                                'total_amount' => $result['total_amount']/100,
                                'send_listid' => $result['send_listid'],
                                'mch_billno' => $result['mch_billno'],
                                'time' => $time,
                                'source' => 1,
                            );
                            $mdlSendLog->add($sendLog);
                        }
                        file_put_contents($logFile, "【".date('Y-m-d H:i:s', $time)."】{$content}\r\n", FILE_APPEND);
                    }
                }catch(Exception $e){
                    $content = "帐号[{$user->loginname}]，openid[{$user->openid}]触发发放红包失败，原因：{$e->getMessage()}[{$e->getCode()}]";
                    file_put_contents($logFile, "【".date('Y-m-d H:i:s', $time)."】{$content}\r\n", FILE_APPEND);
                }
			}
		}
		break;
    case 'list'://获奖列表
        $persize = 50;
        $page = CheckDatas('page', 1);
        $page = Max(1, $page);
        $mdlLog = M('wxhd_luck_draw_log');
        $cond = array('hd_id'=>$lotInfo['id']);
        $order = array('time'=>'desc');
        $rs = $mdlLog->gets($cond, 'loginname,time,item_name', $order, $page, $persize);
        $list = array();
        foreach($rs['DataSet'] as $v){
            $list[] = array(
                'mobile' => replaceStrToStar($v->loginname, 3, 4),
                'time' => date('y-m-d H:i', $v->time),
                'prize' => $v->item_name,
            );
        }
        echo json_encode($list);
        exit();
        break;
    case 'log': // 参与记录页面
    	include_once('tpl/turntable_log_web.php');
        exit();
        break;
    case 'ajax_log'://参与记录
        $persize = 10;
        $page = CheckDatas('page', 1);
        $page = max(1, $page);
        $mdlLog = M('wxhd_luck_draw_log');
        $cond = array('hd_id'=>$lotInfo['id'], 'uid'=>$userid);
        $order = array('time'=>'desc');
        $rs = $mdlLog->gets($cond, 'time,item_name,status', $order, $page, $persize);
        $list = array();
        $statusMap = array(1=>'未发放', 2=>'已发放', 3=>'待发货', 4=>'已发货');
        foreach($rs['DataSet'] as $v){
            $list[] = array(
                'time' => date('y-m-d H:i', $v->time),
                'prize' => $v->item_name,
                'status' => $statusMap[$v->status],
            );
        }
        // echo json_encode($list);
        echo ajaxJson( 1,'获取成功',$list, $page);
        exit();
        break;
	default:
	    $inviterId = intval($_GET['inviterid']);
        $inviterId && $_SESSION['turntable_inviterid'] = $inviterId;

        //剩余机会次数
		$chance = apiData('getTurntableNumApi.do', array('uid'=>$userid));
		$chance = (empty($chance) || !$chance['success']) ? 0 : $chance['result'];

		//剩余名额
        $reWinnerNum = 0;
        $items = __getItems($lotInfo['id']);
        foreach($items as $v){
            $reWinnerNum += ($v['num'] - $v['join_num']);
        }

        //微信分享脚本
        $wxJsTicket = $objWX->getJsTicket();
        $wxShareInviteUrl = $site.'turntable.php?inviterid='.$userid;
        $wxShareCBUrl = 'http://'.$_SERVER['HTTP_HOST'].(($_SERVER['SERVER_PORT'] == '80') ? '' : ':'.$_SERVER['SERVER_PORT']).$_SERVER['REQUEST_URI'];
        $wxJsSign = $objWX->getJsSign($wxShareCBUrl);
        $wxShareParam = array(
            'appId' => $wxJsSign['appId'],
            'timestamp' => $wxJsSign['timestamp'],
            'nonceStr' => $wxJsSign['nonceStr'],
            'signature' => $wxJsSign['signature'],
        );

        if(!$isLogin){
            $curLotStatus = 100;//未登录
        }else{
            //0正常，1没有信息，2未开始，3已结束，4当日参与数满
            $curLotStatus = $lotData['state'];
        }

		include_once('tpl/turntable_web.php');
		break;
}

/**
 * 获取转盘活动信息
 * 
 * @return array
 *      state 状态码，0正常，1没有信息，2未开始，3已结束，4当日参与数满
 *      data 活动信息数据
 */
function __getTurntableInfo(){
	global $db;

	$return = array('state'=>1, 'data'=>array());
	$time = time();
//	$sql = 'SELECT * FROM `wxhd_turntable` WHERE `status`=1 AND `verify`=1 AND `start_time`<='.$time.' AND `end_time`>='.$time.' ORDER BY `start_time` ASC LIMIT 1';
    $sql = 'SELECT * FROM `wxhd_turntable` WHERE `status`=1 AND `verify`=1 ORDER BY `start_time` ASC LIMIT 1';
	$info = $db->get_row($sql, ARRAY_A);
	if(!empty($info)){
	    if($info['start_time'] > $time){
	        $return['state'] = 2;
        }elseif($info['end_time'] < $time){
	        $return['state'] = 3;
        }else{
            if($info['per_day_number'] != -10){//判断每日参与数
                $feTime = getFirstEndTime($time);
                $sql = 'SELECT COUNT(*) FROM `wxhd_turntable` WHERE `start_time`<='.$feTime['first'].' AND `end_time`>='.$feTime['end'];
                if($db->get_var($sql) >= $info['per_day_number']){
                    $return['state'] = 4;
                }
            }else{
                $return['state'] = 0;
                $return['data'] = $info;
            }
        }
    }
	return $return;
}

/**
 * 根据概率随机抽取
 *
 * @param array $arr 奖品概率信息，array(奖品数组索引 => 概率)
 * @return integer
 */
function __getRand($arr){
	$result = '';
	//概率数组的总概率精度
	$sum = array_sum($arr);
	$sum = floor($sum);

	//概率数组循环
	foreach($arr as $key => $cur){
		$randNum = mt_rand(0, $sum);
		if($randNum <= $cur){
			$result = $key;
			break;
		}else{
			$sum -= $cur;
		}
	}
	unset($arr);

	return $result;
}

/**
 * 获取奖项
 *
 * @param integer $hdId 活动id
 * @return array
 */
function __getItems($hdId, $joinNum=null){
	global $db;
	$sql = 'SELECT * FROM `wxhd_turntable_item` WHERE `turntable_id`='.$hdId.' AND `status`=1 AND `verify`=1 AND `num`>`join_num`';
	!is_null($joinNum) && $sql .= " AND `win_index` LIKE ',{$joinNum},'";
	$sql .= ' FOR UPDATE';
	$items = $db->get_results($sql, ARRAY_A);
	return $items;
}
?>