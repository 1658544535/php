<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$ageIndex = intval($_POST['age']);
	empty($ageIndex) && redirect($_SERVER['HTTP_REFERER'], '参数错误');

	$_SESSION[SESS_K_PARTIN]['age'] = $ageIndex;
	$_SESSION[SESS_K_STEP] = 1;
	redirect(__CURRENT_ROOT_URL__.'/?act=2');
}

$ageList = array();
foreach($gOptions as $k => $v){
	$ageList[] = array(
		'index' => $k,
		'name' => $v['age'],
	);
}

$_SESSION[SESS_K_JOIN] = true;
include_once(CURRENT_TPL_DIR.'step1_tpl.php');
?>