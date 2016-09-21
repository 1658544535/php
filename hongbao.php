<?php
define('HN1', true);
require_once('./global.php');

require_once SCRIPT_ROOT . './wxpay/inc_hongbao.php';

$openid = isset( $_REQUEST['uid'] ) ? $_REQUEST['uid'] : '';
$act 	= isset( $_REQUEST['act'] ) ? $_REQUEST['act'] : '';

if ( $openid == "" )
{
	echo -1;
}
else
{
	$HongBao = new HongBao();


	switch ( $act )
	{
		case 'group':
			//$HongBao->set_val( 'openid', $openid );
			$HongBao->set_val( 'openid', 'o6MuHtwL7s7gntl6xYmXHikcD6zQ' );
			$HongBao->set_val( 'total_amount', rand( 100,100 ) );
			$HongBao->set_val( 'total_num', '3' );
			$arrXmlData = $HongBao->sendgroupredpack();
			echo $arrXmlData['total_amount'];
		break;

		default:		// 现金红包
			$HongBao->set_val( 'openid', $openid );
			//$HongBao->set_val( 'openid', 'o6MuHtwL7s7gntl6xYmXHikcD6zQ' );
		    $HongBao->set_val( 'total_amount', rand( 100,100) );
			$arrXmlData = $HongBao->sendredpack();
			echo $arrXmlData['total_amount'];
		break;

	}

}
?>
