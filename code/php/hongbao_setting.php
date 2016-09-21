<?php
	// 中奖概率算法
	function get_rand( $arrPro )
	{
		$result = "";

		$proSum = array_sum( $arrPro );

		foreach( $arrPro as $key=>$proCur )
		{
			$randNum = mt_rand( 1, $proSum );

			if ( $randNum <= $proCur )
			{
				$result = $key;
				break;
			}
			else
			{
				$proSum -= $proCur;
			}
		}

		unset( $arrPro );

		return $result;
	}

	// 中奖与中奖的类型对应参数
	$arrPro = array( '1'=>85, '2'=>14, '3'=>1 );

	// 获取中奖的类型
	$type = get_rand($arrPro);

	// 获取到要发红包的金额
	switch ( $type )
	{
		case 1:
			$amount = rand( 100, 1000 );
		break;

		case 2:
			$amount = rand( 1000, 10000 );
		break;

		case 3:
			$amount = rand( 10000, 20000 );
		break;
	}

?>
