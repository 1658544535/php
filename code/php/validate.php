<?php
	define('HN1', true);
	require_once ('global.php');

	/*----------------------------------------------------------------------------------------------------
		-- 配置
	-----------------------------------------------------------------------------------------------------*/
	$act  	= CheckDatas( 'act', '' );


	switch( $act )
	{
		/*----------------------------------------------------------------------------------------------------
			-- 极客验证初始化
		-----------------------------------------------------------------------------------------------------*/
		case 'init_geetest':
			$type  		= CheckDatas( 'type', 'json' );

			$url 	= APIURL . "getValidCode.do";
			$ch 	= curl_init($url) ;
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; 		// 获取数据返回
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; 		// 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.47 Safari/536.11');
			$output = curl_exec($ch) ;
			curl_close($ch);

			if ( $type == 'jsonp' )
			{
				$output = 'callback(' . $str . ')';
			}
			echo $output;
		break;
	}

?>
