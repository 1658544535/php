<?php
	define('HN1', true);
	require_once('./global.php');
	require_once('./wxpay/inc_clickfarm.php');



	$ClickFarm = new ClickFarm();

	$rs = $ClickFarm->getQrCode();

	var_dump($rs);




?>

