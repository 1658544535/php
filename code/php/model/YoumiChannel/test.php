<?php

define('HN1', true);
require_once('./global.php');


require_once( MODEL_INC .'UmengChannelModel.class.php' );

	$UmengChannelModel = new UmengChannelModel($db);
	$arr = array(
		array('Email'=>'umeng_channel_1@163.com',  'Name'=>'TaoZhuMa01', 'Password'=>'123456f', 'UmengPassword'=>'' ),
		array('Email'=>'umeng_channel_2@163.com',  'Name'=>'TaoZhuMa02', 'Password'=>'123456f', 'UmengPassword'=>'' ),
		array('Email'=>'umeng_channel_3@163.com',  'Name'=>'TaoZhuMa03', 'Password'=>'123456f', 'UmengPassword'=>'' ),
		array('Email'=>'umeng_channel_4@163.com',  'Name'=>'TaoZhuMa04', 'Password'=>'123456f', 'UmengPassword'=>'' ),
		array('Email'=>'umeng_channel_5@163.com',  'Name'=>'TaoZhuMa05', 'Password'=>'123456f', 'UmengPassword'=>'' ),
		array('Email'=>'umeng_channel_6@163.com',  'Name'=>'TaoZhuMa06', 'Password'=>'123456f', 'UmengPassword'=>'' ),
		array('Email'=>'umeng_channel_7@163.com',  'Name'=>'TaoZhuMa07', 'Password'=>'123456f', 'UmengPassword'=>'' ),
		array('Email'=>'umeng_channel_8@163.com',  'Name'=>'TaoZhuMa08', 'Password'=>'123456f', 'UmengPassword'=>'' ),
		array('Email'=>'umeng_channel_9@163.com',  'Name'=>'TaoZhuMa09', 'Password'=>'123456f', 'UmengPassword'=>'' ),
		array('Email'=>'umeng_channel_10@163.com', 'Name'=>'TaoZhuMa10', 'Password'=>'123456f', 'UmengPassword'=>'' )
	);

	foreach( $arr as $arrParam )
	{
		$UmengChannelModel->add( $arrParam );
	}






?>

