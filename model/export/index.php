<?php
/**
 * 导出数据
 */
set_time_limit(0);
define('ROOT_PATH', dirname(__FILE__));
define('EXPORT_FILE', ROOT_PATH.'/inc/export.txt');

$dbCfg = include_once(ROOT_PATH . '/inc/db_cfg.php');
include_once(ROOT_PATH.'/lib/ez_sql_core.php');
include_once(ROOT_PATH.'/lib/ez_sql_mysql.php');
include_once(ROOT_PATH.'/lib/Model.class.php');

$db = new ezSQL_mysql($dbCfg['user'], $dbCfg['pwd'], $dbCfg['name'], $dbCfg['host']);
$db->query('SET character_set_connection='.$dbCfg['charset'].', character_set_results='.$dbCfg['charset'].', character_set_client=binary');
$Model = new Model($db);

$orderStatus = array(1=>'待付款', 2=>'已付款', 3=>'已发货', 4=>'已确认', 5=>'已评论');
$orderReStatus = array(1=>'审核', 2=>'请退货', 3=>'退货中', 4=>'退货成功', 5=>'退货失败', 6=>'审核不成功', 7=>'退款成功');



//tmpFilterMobiles();

$list = array();
$mobiles = getMobiles();//要导出的手机号
$users = getUser($mobiles);//手机号对应的帐号
$orders = getOrder(array_keys($users));//帐号的订单
$reStatus = getReStatus(array_keys($orders));//订单的退货/退款

foreach($orders as $_order){
    $_order['usermobile'] = $users[$_order['user_id']];
    if(empty($reStatus[$_order['id']])){
        $_order['restatus'] = false;
        $_order['restatus_txt'] = '无';
    }else{
        $_order['restatus'] = true;
        $_order['restatus_txt'] = '有';
    }
    $_order['restatus'] = empty($reStatus[$_order['id']]) ? false : true;
    $list[] = $_order;
}
//echo '<pre>'.print_r($list,true).'</pre>';
//renderResult($list);
genExcel('dingdan', $list);


function getMobiles(){
    $content = file_get_contents(EXPORT_FILE);
    return str2Arr($content);
}

function str2Arr($str){
    $spe = '####';
    $con = str_replace(array("\r\n", "\r", "\n"), array($spe, $spe, $spe), $str);
    $rs = explode($spe, $con);
    $arr = array();
    foreach($rs as $v){
        !empty($v) && $arr[] = $v;
    }
    return $arr;
}

function tmpFilterMobiles(){
    $m = array();
    $content = file_get_contents(EXPORT_FILE);
    $arr = str2Arr($content);
    foreach($arr as $val){
        $tmp = explode('.', $val);
        foreach($tmp as $v){
            $len = strlen($v);
            if($len == 11){
                $m[] = $v;
//            }elseif($len > 11){
//                $tm = substr($v, strpos($v, '1'), 11);
//                is_numeric($tm) && $m[] = $tm;
            }
        }
    }
    echo '数量：'.count($m).'<br />'.implode('<br />', $m);
}

function getOrder($uids){
    global $Model;
    $orders = array();
    if(!empty($uids)){
        $rs = $Model->getAll(array('__IN__'=>array('user_id'=>$uids)), array('user_id'=>'asc'), ARRAY_A, '', 'id,user_id,order_no,fact_price,order_status', 'user_order');
        foreach($rs as $v){
            $orders[$v['id']] = $v;
        }
    }
    return $orders;
}

function getUser($mobiles){
    global $Model;
    $user = array();
    if(!empty($mobiles)){
        $rs = $Model->getAll(array('__IN__'=>array('loginname'=>$mobiles)), array(), ARRAY_A, '', 'id,loginname', 'sys_login');
        foreach($rs as $v){
            $user[$v['id']] = $v['loginname'];
        }
    }
    return $user;
}

function getReStatus($orderIds){
    global $Model;
    $order = array();
    if(!empty($orderIds)){
//        $cond = array('order_id'=>array('IN', '('.implode(',', $orderIds).')'), 're_status'=>array('>', 0), '_logic_'=>'AND');
        $cond = '`order_id` IN ('.implode(',', $orderIds).') AND `re_status`>0';
        $rs = $Model->getAll($cond, array(), ARRAY_A, '', 'order_id,re_status', 'user_order_detail');
        foreach($rs as $v){
            !isset($order[$v['order_id']]) && $order[$v['order_id']] = true;
        }
    }
    return $order;
}

function genExcel($filename, $list){
    global $orderStatus;
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename='.$filename.'.xls');
    header('Pragma: no-cache');
    header('Expires: 0');

    $str = '<table style="vnd.ms-excel.numberformat:@" border="1">';
    $str .= '<tr><th>用户</th><th>订单号</th><th>金额</th><th>状态</th><th>申请退货/退款</th></tr>';
    foreach($list as $v){
        $str .= "<tr><td>{$v['usermobile']}</td><td>{$v['order_no']}</td><td>{$v['fact_price']}</td><td>{$orderStatus[$v['order_status']]}</td><td>{$v['restatus_txt']}</td></tr>";
    }
    $str .= '</table>';
    echo $str;


//    $title = array('用户', '订单号', '金额', '状态', '申请退货/退款');
//    echo iconv('utf-8', 'gbk', implode("\t", $title)), "\n";
//    foreach ($list as $v) {
//        $tmp = array("=\"{$v['usermobile']}\"", "=\"{$v['order_no']}\"", "=\"{$v['fact_price']}\"", $orderStatus[$v['order_status']], $v['restatus_txt']);
//        echo iconv('utf-8', 'gbk', implode("\t", $tmp)), "\n";
//    }
}

function renderResult($list){
    global $orderStatus;
    echo '<table>';
    echo '<tr><th>用户</th><th>订单号</th><th>金额</th><th>状态</th><th>申请退货/退款</th></tr>';
    foreach($list as $v){
//        echo $v['usermobile'].'<br />';
        echo '<tr>';
        echo "<td>{$v['usermobile']}</td><td>{$v['order_no']}</td><td>{$v['fact_price']}</td><td>{$orderStatus[$v['order_status']]}</td><td>{$v['restatus_txt']}</td>";
        echo '</tr>';
//        echo <<<EOF
//            <tr>
//                <td>{$v[usermobile]}</td>
//                <td>{$v[order_no]}</td>
//                <td>{$v[fact_price]}</td>
//                <td>{$orderStatus[$v[order_status]]}</td>
//                <td>{$v[restatus_txt]}</td>
//            </tr>
//EOF;
    }
    echo '</table>';
}
?>