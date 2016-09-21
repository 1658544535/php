<?php
/**
 * 修复
 */
define('HN1', true);
require_once('../global.php');
include_once(APP_INC . 'db.php');

$act = isset($_GET['act']) ? trim($_GET['act']) : '';

switch($act){
    case 'address'://修复发货地址
        set_time_limit(0);
        $total = 0;
        $errShips = array();//更新失败
        $sucShips = array();//更新成功

        //获取统一操作者
        $uname = 'dingdan@taozhumab2c001';
        $sql = "SELECT * FROM `sys_login` WHERE `loginname`='{$uname}'";
        $oper = $db->get_row($sql);

        //需要修复的订单
        $orderCond = '`order_type`=1 AND `order_status`=3';
        $orders = array();
        $sql = 'SELECT `id`,`order_id`,`consignee_address` FROM `user_order_ship` WHERE `order_id` IN (SELECT `id` FROM `user_order` WHERE '.$orderCond.')';
        $rs = $db->get_results($sql);
        $db->query('BEGIN');
        foreach($rs as $v){
            if(!empty($v->order_id) && !empty($v->consignee_address)){//收货地址为空的不修改
                try{
                    $sql = "UPDATE `user_order` SET `consignee_address`='".addslashes($v->consignee_address)."',`update_by`='{$oper->id}' WHERE `id`={$v->order_id} AND {$orderCond}";
                    $num = $db->query($sql);
                    if($num === false){
                        echo $sql.'<br />';
                        $errShips[] = "order_id【{$v->order_id}】；order_ship_id【{$v->id}】";
                    }else{
                        $total += $num;
                        $sucShips[] = "{$v->id}|{$v->order_id}";
                    }
                }catch(Exception $e){
                    echo $sql;
                    $db->query('ROLLBACK');
                    die();
                }
            }
        }

        define('CUR_ROOT', dirname(__FILE__));
        $logDir = CUR_ROOT.'/logs/repair/';
        !file_exists($logDir) && mkdir($logDir, 0777, true);
        $logfile = $logDir.'address.'.date('Y-m-d_His', time());
        !empty($errShips) && file_put_contents($logfile.'.err.log', implode("\r\n", $errShips));
        !empty($sucShips) && file_put_contents($logfile.'.success.log', implode("\r\n", $sucShips));
        $db->query('COMMIT');
        echo '成功数量：'.count($sucShips).'<br />';
        echo '失败数量：'.count($errShips);
        break;

    case 'time'://修复发货时间
        set_time_limit(0);
        $errShips = array();//更新失败
        $sucShips = array();//更新成功
        $page = intval($_GET['p']);
        $pagesize = 100;//每次处理的数量
        $haveCount = $page * $pagesize;//已处理的数量

        $cond = "(`sendDate` IS NULL OR `sendDate`='') AND `order_status`=3 AND `order_type`=1";

        $sql = "SELECT COUNT(*) FROM `user_order` WHERE {$cond}";
        $total = $db->get_var($sql);

        //获取需要修改的订单
        $sql = "SELECT `id`,`create_date` FROM `user_order` WHERE {$cond} ORDER BY `id` ASC LIMIT {$page},{$pagesize}";
        $orders = $db->get_results($sql);

        foreach($orders as $v){
            $sendtime = genSendDate($v->create_date);
            if($sendtime != ''){
                $sql = "UPDATE `user_order` SET `sendDate`='{$sendtime}' WHERE `id`={$v->id}";
                $num = $db->query($sql);
                if($num === false){
                    $errShips[] = $v->id;
                }else{
                    $sucShips[] = $v->id;
                }
            }
        }

        $txtTime = isset($_GET['t']) ? trim($_GET['t']) : date('Y-m-d_His', time());
        define('CUR_ROOT', dirname(__FILE__));
        $logDir = CUR_ROOT.'/logs/repair/';
        !file_exists($logDir) && mkdir($logDir, 0777, true);
        $logfile = $logDir.'sendtime.'.$txtTime;
        !empty($errShips) && file_put_contents($logfile.'.err.log', implode("\r\n", $errShips)."\r\n", FILE_APPEND);
        !empty($sucShips) && file_put_contents($logfile.'.success.log', implode("\r\n", $sucShips)."\r\n", FILE_APPEND);

        $curOpCount = count($orders);
        $sucShipCount = count($sucShips);
        $errShipCount = count($errShips);
        $hadOpCount = $page*$pagesize+$curOpCount;
        echo '剩余需要处理的数量：'.$total.'<br />';
        echo '已处理数量：'.$hadOpCount.'<br />';
        echo '本次需处理数量：'.$curOpCount.'<br />';
        echo '本次处理成功：'.$sucShipCount.'<br />';
        echo '本次处理失败：'.$errShipCount.'<br />';
        echo '本次未处理：'.($curOpCount-$sucShipCount-$errShipCount).'<br />';
        if($curOpCount < $pagesize){
            echo '处理完成';
        }else{
            echo '处理未完成，请不要刷新页面...';
            $html = '<script language="javascript">location.href="repair.php?act=time&t='.$txtTime.'&p='.($page+1).'"</script>';
            echo $html;
            exit();
        }
        exit();
        break;

    case 'user_order_ship':

		define('CUR_ROOT', dirname(__FILE__));
	    $logDir = CUR_ROOT.'/logs/repair/';
	    !file_exists($logDir) && mkdir($logDir, 0777, true);
	    $logfile = $logDir.'orders_'.date('Y-m-d_His', time());

    	$orderCond = '`order_type`=1 AND `order_status`=3';

		// 获取user_order_ship中地址为空的记录列表
		$sql = "SELECT `id`,`order_id`,`logistics_name`,`logistics_no` FROM `user_order_ship` WHERE `consignee`='' AND `consignee_address`='' AND `status`=1 ORDER BY `id` DESC LIMIT 3000";
		$orders = $db->get_results($sql);

		if ( $orders != NULL )
		{
			//$db->query('BEGIN');
			foreach( $orders as $order )
			{
				// 查找临时表中指定快递名和快递单号的信息
				$sql = "SELECT `id`,`address`,`consignee` FROM `logistics_list_temp` WHERE `logistics_name`='{$order->logistics_name}' AND `logistics_no`='{$order->logistics_no}'";
				$ship_info = $db->get_results($sql);

				if ( $ship_info != NULL )
				{
					$ship_info = $ship_info[0];

					try{
						// 更新user_order的地址信息
	                    $sql = "UPDATE `user_order` SET `consignee`='".addslashes($ship_info->consignee)."',`consignee_address`='".addslashes($ship_info->address)."' WHERE `id`={$order->order_id} AND {$orderCond}";
	                    $num = $db->query($sql);
	                    if($num === false)
	                    {
	                        $errShips[] = "{$sql}\r\norder_id【{$order->order_id}】；order_ship_id【{$order->id}】";
	                    }
	                    else
	                    {
	                    	// 更新user_order_ship的地址信息
	                    	$sql = "UPDATE `user_order_ship` SET `consignee`='".addslashes($ship_info->consignee)."',`consignee_address`='".addslashes($ship_info->address)."' WHERE `id`={$order->id} AND `order_id`={$order->order_id}";
	                    	$num = $db->query($sql);

	                    	if($num === false)
	                    	{
		                        $errShips[] = "{$sql}\r\norder_id【{$order->order_id}】；order_ship_id【{$order->id}】";
		                    }
		                    else
		                    {
	                        	$total += $num;
	                        	$sucShips[] = "{$order->id}|{$order->order_id}";
	                    	}
	                    }
	                }catch(Exception $e){
	                    echo $sql;
	                    $db->query('ROLLBACK');
	                    die();
	                }
				}
				else
				{
					$sql = "UPDATE `logistics_list_temp` SET `status`=0 WHERE `logistics_name`='{$order->logistics_name}' AND `logistics_no`='{$order->logistics_no}'";
	                $num = $db->query($sql);
					$errShips[] = "快递信息没有对应的订单信息\r\norder_id【{$order->order_id}】；order_ship_id【{$order->id}】\r\nlogistics_name【{$order->logistics_name}】；logistics_no【{$order->logistics_no}】";
				}
			}

	        !empty($errShips) && file_put_contents($logfile.'.err.log', implode("\r\n", $errShips));
	        !empty($sucShips) && file_put_contents($logfile.'.success.log', implode("\r\n", $sucShips));
	        $db->query('COMMIT');
	        echo '成功数量：'.count($sucShips).'<br />';
	        echo '失败数量：'.count($errShips);
		}
		else
		{
			 file_put_contents($logfile.'.err.log', '您查找的记录为空！');
		}


    break;

    default:
        die('操作失败');
        break;
}

function testPS($data){
    echo '<pre>'.print_r($data, true).'</pre>';
    die;
}

function genSendDate($createDate){
    $sendtime = '';
    $createtime = strtotime($createDate);
    list($day, $time) = explode(' ', $createDate);
    if(($createtime >= strtotime($day.' 0:0:0')) && ($createtime < strtotime($day.' 17:00:00'))){//0:0 - 17:0 下单，17:0 - 17:30 发货
        $sendtime = $day.' 17:'.rand(1,30).':'.rand(1,60);
    }elseif(($createtime >= strtotime($day.' 17:00:00')) && ($createtime < strtotime($day.' 22:00:00'))){//17:0 - 22:0 下单，22:0 - 22:30 发货
        $sendtime = $day.' 22:'.rand(1,30).':'.rand(1,60);
    }
    return $sendtime;
}
