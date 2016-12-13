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
            $validCodeDir = SCRIPT_ROOT.'data/validcode/';
            !file_exists($validCodeDir) && mkdir($validCodeDir, 0777, true);
            $flag = createCode(8);
            setcookie('validate_code_flag', $flag);
            $validCodeFile = 'validcode_cookie_'.GetIP().'_'.$flag.'.txt';

			$url 	= APIURL . "getValidCode.do";
			$ch 	= curl_init($url) ;
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; 		// 获取数据返回
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; 		// 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
            curl_setopt($ch, CURLOPT_COOKIEJAR, $validCodeDir.$validCodeFile);
			curl_setopt($ch, CURLOPT_USERAGENT, 'MicroMessenger');
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
