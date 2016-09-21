<?php
define('HN1', true);
define('DEBUG_TEST', false);
define('CURRENT_ADMIN_ROOT', dirname(__FILE__).'/');
define('CURRENT_ROOT', CURRENT_ADMIN_ROOT.'../');
require_once(CURRENT_ROOT.'../h5_global.php');

define('CURRENT_TPL_DIR', CURRENT_ADMIN_ROOT.'tpl/');

//本地开发配置
$__devCfg = CURRENT_ROOT.'local_dev_config.php';
file_exists($__devCfg) && include_once($__devCfg);

define('__CURRENT_ADMIN_URL__', $site.'h5/ability/admin');
define('__CURRENT_PAGE_URL__', __CURRENT_ADMIN_URL__.'/partin.php');

$gOptions = include_once(CURRENT_ROOT.'option.php');

//表头各领域
$optionTop = array_slice($gOptions, 0, 1);
$optionTop = $optionTop[0]['fields'];
$fieldItems = array();
foreach($optionTop as $_index => $_field){
    $fieldItems[$_index] = array('name'=>$_field['name']);
}





$page = intval($_GET['page']);
$page = max(1, $page);
$perpage = 20;


$objPartin = M('h5_ability_partin');


$url = "partin.php?act=list";


$sql = "SELECT * FROM `h5_ability_partin` WHERE 1=1  ";




$age_index   = $_REQUEST['age_index'] == null ? '' : $_REQUEST['age_index'];

if($age_index !=''){
    $sql .= " and age_index =".$age_index;
    $url .= "&age_index={$age_index}";




$start_time   = $_REQUEST['startTime'] == null ? '' : $_REQUEST['startTime'];


    $starttime = strtotime($start_time);




$end_time   = $_REQUEST['endTime'] == null ? '' : $_REQUEST['endTime'];


    $endtime = strtotime($end_time);




if($start_time > 0){
    $sql .= " and time >=".$starttime;
    $url .= "&startTime={$start_time}";
}
if($end_time > 0){
    $sql .= ' and time <='.$endtime;
    $url .= "&endTime={$end_time}";
}

}
else
{
    $start_time   = $_REQUEST['startTime'] == null ? '' : $_REQUEST['startTime'];


    $starttime = strtotime($start_time);




   $end_time   = $_REQUEST['endTime'] == null ? '' : $_REQUEST['endTime'];


    $endtime = strtotime($end_time);




if($start_time > 0){
    $sql .= " and time >=".$starttime;
    $url .= "&startTime={$start_time}";
}
if($end_time > 0){
    $sql .= ' and time <='.$endtime;
    $url .= "&endTime={$end_time}";
}

}

$url .= "&page=";
$sql .= " ORDER BY time DESC";

$partin = $objPartin->query($sql,false, true, $page, $perpage);








$totalScore = array();
if(!empty($partin)){
    foreach($gOptions as $aIndex => $_age){
        foreach($_age['fields'] as $fIndex => $_field){
            foreach($_field['items'] as $iIndex => $_item){
                if(isset($totalScore[$aIndex][$fIndex])){
                    $totalScore[$aIndex][$fIndex] += $_item['score'];
                }else{
                    $totalScore[$aIndex][$fIndex] = $_item['score'];
                }
            }
        }
    }
}

$uids = array();
$partinIds = array();
$list = array();
foreach($partin['DataSet'] as $v){
    $uids[] = $v->user_id;
    $partinIds[] = $v->id;
    $list[$v->id] = $v;

}

//用户
$userList = array();
if(!empty($uids)){
    $objWxUser = M('h5_ability_wxuser');
    $rs = $objWxUser->getAll(array('__IN__'=>array('id'=>$uids)), 'id,openid,nickname', array(), '', ARRAY_A);
    foreach($rs as $v){
        $userList[$v['id']] = $v;
    }
}

//测试记录
if(!empty($partinIds)){
    $fieldScore = array();
    $objPartItem = M('h5_ability_partitem');
    $rs = $objPartItem->getAll(array('__IN__'=>array('partin_id'=>$partinIds)), '*', array(), '', ARRAY_A);
    foreach($rs as $v){
        $_score = $gOptions[$list[$v['partin_id']]->age_index]['fields'][$v['field_index']]['items'][$v['item_index']]['score'];
        if(isset($fieldScore[$v['partin_id']][$list[$v['partin_id']]->age_index][$v['field_index']])){
            $fieldScore[$v['partin_id']][$list[$v['partin_id']]->age_index][$v['field_index']] += $_score;
        }else{
            $fieldScore[$v['partin_id']][$list[$v['partin_id']]->age_index][$v['field_index']] = $_score;
        }
    }
    foreach($list as $v){
        $ratio = array();
        foreach($totalScore[$v->age_index] as $_findex => $_score){
            if(isset($fieldScore[$v->id][$v->age_index][$_findex])){
                $_ratio = round($fieldScore[$v->id][$v->age_index][$_findex]/$_score, 3);
                $_ratio *= 100;
                $ratio[$_findex] = ceil($_ratio);
            }else{
                $ratio[$_findex] = 0;
            }
        }
        $list[$v->id]->ratio = $ratio;
    }
}



//ps($list);
require_once(CURRENT_TPL_DIR.'header.php');
require_once(CURRENT_TPL_DIR.'partin.php');

function ps($msg){
    echo '<pre>'.print_r($msg, true).'</pre>';
}