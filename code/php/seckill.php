<?php
/**
 * 秒杀列表
 */
define('HN1', true);
require_once('./global.php');
require_once  LOGIC_ROOT.'comBean.php';

$ActivityTimeModel = D( 'ActivityTime' );
$tabIndexs = (int)CheckDatas( 'ti', '' );


// 获取抢购活动信息列表
$tabInfo = $ActivityTimeModel->getSeckillActivityList( $tabIndexs );

$_url	 = '/product_detail.php?type=0&pid=';


/*----------------------------------------------------------------------------------------------------
	-- 获取整合后的抢购活动信息
-----------------------------------------------------------------------------------------------------*/
$cur_time = time();
$i	= 1;

if ( $tabInfo != NULL )
{
	foreach($tabInfo as $_index => $_tab)
	{
		// 判断时间是否过期，如果过期则删除
		if( (  $cur_time < strtotime( $_tab->activity_date . $_tab->end_time ) ) && $i < 5 )
	    {
			if ( $i == 1 )
			{
				$tabInfo[$_index]->tip				= '抢购中';
				$tabInfo[$_index]->actiStateTexts	= '距结束';
				$tabInfo[$_index]->status			= 'doing';
				$tabInfo[$_index]->curOverTimeDiff	= strtotime( $_tab->activity_date . $_tab->end_time ) - $cur_time;
				$tabIndexs = $tabIndexs == 0  ? $_index : $tabIndexs;
			}
			else
			{
				if ( $i == 2 )
				{
					$nextIndexs = $_index;			// 下一活动场次的ID;
				}

				$tabInfo[$_index]->tip				= '即将开抢';
				$tabInfo[$_index]->actiStateTexts	= '距开始';
				$tabInfo[$_index]->status			= 'wait';
				$tabInfo[$_index]->curOverTimeDiff	= strtotime( $_tab->activity_date . $_tab->begin_time ) - $cur_time;
			}

	    	$i++;
	    }
	    else
	    {
	        unset($tabInfo[$_index]);
	    }
	}

	$nowSeckillInfo = $tabInfo[$tabIndexs];


	// 获取指定专场商品列表
	$objSeckillProduct = $ActivityTimeModel->getProductList( $tabIndexs );
}


include "tpl/seckill_web.php";