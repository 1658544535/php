<?php
if(!isset($_SESSION[SESS_K_PARTIN]) || empty($_SESSION[SESS_K_PARTIN]) || ($_SESSION[SESS_K_STEP] != 1)){
	redirect(__CURRENT_ROOT_URL__.'/?act=1');
}

$ageIndex = $_SESSION[SESS_K_PARTIN]['age'];
$fields = $gOptions[$ageIndex]['fields'];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$items = array();
	$item = $_POST['item'];

	foreach($item as $v){
		list($_fieldIndex, $_itemIndex) = explode('-', $v);
		$items[] = array(
			'field_index' => $_fieldIndex,
			'item_index' => $_itemIndex,
			'score' => $fields[$_fieldIndex]['items'][$_itemIndex]['score'],
		);
	}

	$objPartin = M('h5_ability_partin');
	$objPartitem = M('h5_ability_partitem');
	$partin = array(
		'user_id' => $_SESSION[SESS_K_USER]['id'],
		'age_index' => $ageIndex,
		'time' => time(),
	);
	$newid = $objPartin->add($partin);
	foreach($items as $v){
		$v['partin_id'] = $newid;
		$objPartitem->add($v);
	}

	$objStatus = M('h5_ability_opstatus');
	$objStatus->modify(array('restart'=>0), array('user_id'=>$_SESSION[SESS_K_USER]['id']));

	$_SESSION[SESS_K_STEP] = 2;
	unset($_SESSION[SESS_K_JOIN]);
	redirect(__CURRENT_ROOT_URL__.'/?act=3');
}

include_once(CURRENT_TPL_DIR.'step2_tpl.php');
?>
