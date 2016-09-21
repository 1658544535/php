<?php
define('HN1', true);
require_once('./global.php');

/*----------------------------------------------------------------------------------------------------
	-- 配置
-----------------------------------------------------------------------------------------------------*/
$ActivityTitleModel = D('ActivityTitle');
$act = CheckDatas( 'act', 'lists' );

switch ( $act )
{
	case 'info':
		/*----------------------------------------------------------------------------------------------------
			-- 获取活动详情
		-----------------------------------------------------------------------------------------------------*/
		$nActivityTimeID 		= CheckDatas( 'aid', 0 );

		if ( (int)$nActivityTimeID == 0 )
		{
			redirect('/');
		}

		// 获取该场景的信息
		$objActivityTimeInfo = $ActivityTitleModel->getActivityTimeInfo( $nActivityTimeID );

		$TitlePic = array(
			2 => $objActivityTimeInfo->titlePicture,
			3 => $objActivityTimeInfo->titlePhoto
		);

		// 获取活动单品记录
		$objActivityTimeProductTop  = $ActivityTitleModel->getActivityTimeProductTop( $nActivityTimeID );

		// 获取单品连接专场记录
		$objActivityTimeProductList = $ActivityTitleModel->getActivityTimeProductList( $nActivityTimeID );

		// 获取总共可以分成的组数
		$group = ceil( count($objActivityTimeProductList) / 4);

		for( $i=1; $i<=$group; $i++ )
		{
			if ( $i > 1 )
			{
				$ActivityTimeProductList[$i]['img']	= $TitlePic[$i];
			}

			for( $k=4*($i-1); $k<= (4*$i)-1; $k++ )
			{
				if ( isset($objActivityTimeProductList[$k]) )
				{
					$ActivityTimeProductList[$i]['Info'][] = $objActivityTimeProductList[$k];
				}
			}
		}

		include_once('tpl/activity_web.php');
	break;

	default:
		/*----------------------------------------------------------------------------------------------------
			-- 获取场景列表
		-----------------------------------------------------------------------------------------------------*/
		$objScene = $SceneModel->getSceneList();
		include_once('tpl/scene_web.php');

}


?>