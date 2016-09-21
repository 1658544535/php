<?php
	set_time_limit(0);
	// 生成兑换码库操作

	define('HN1', true);
	define('SCRIPT_ROOT',  dirname(dirname(dirname(__FILE__))).'/game/lower-brain/');

	require_once( SCRIPT_ROOT . 'global.php' );
	require_once ( SCRIPT_ROOT . 'logic/game_brain_exchange_codeBean.php');

	if ( $user_info == null )
	{
		redirect('/login.php');
	}

	$exchange_codeBean = new game_brain_exchange_codeBean();
	$exchange_codeBean->conn = $db;

//	$exchange_codeBean->get_code();

//	// 生成兑换码
//	for( $i=1; $i<33; $i++ )
//	{
//		$val =   '01' . sprintf( "%02d", $i+1 ) . sprintf( "%02d", $i+2 );
//
//		for( $j=01; $j<35; $j++ )
//		{
//			$value = $val . sprintf( "%02d", $j );
//
//			//echo $value . "</br>";
//			//$exchange_codeBean->value = $value;
//			//$exchange_codeBean->creat();
//		}
//	}




//$w = 0;
//$start   = 31;
//$end 	 = 33;
//
//$limit 	 = 33;
//$time 	 = 1;
//
//for( $x=$start; $x<=$end; $x++ )
//{
//	for ( $y=$x+1; $y<=$limit; $y++ )
//	{
//		for ( $z=$y+1; $z<=$limit; $z++ )
//		{
//			for ( $i=$z+1; $i<=$limit; $i++ )
//			{
//				if ( $x!=$y || $x!=$z || $x!=$i || $y!=$z || $y!= $i || $z != $i )
//				{
//					for( $j=1; $j<=16; $j++ )
//					{
//						$value =   sprintf( "%02d", $x ) . sprintf( "%02d", $y ) . sprintf( "%02d", $z ) . sprintf( "%02d", $i ) . sprintf( "%02d", $j );
//						$exchange_codeBean->value = $value;
//						$exchange_codeBean->creat();
//					}
//				}
//			}
//		}
//	}
//}


?>