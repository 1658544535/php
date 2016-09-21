<?php
/**
 * 专场模型
 */
class SpecialModel extends Model
{
	 public function __construct($db, $table=''){
        $table = 'special_show';
        parent::__construct($db, $table);
    }

	/**
	 *	功能：获取首页专场列表
	 */
	public function getHomeData()
	{
		$strSQL  = "SELECT
						ss.`id`,
						ss.`discount_type`,
						ss.`discount_context`,
						ss.`title`,
						ss.`banner`,
						ss.`activity_id`,
						ss.`end_time`
					FROM
						`special_show` as ss
					WHERE
						unix_timestamp(ss.`end_time`) >= unix_timestamp()
					AND
						ss.`status`=4
					ORDER BY
						ss.`sorting` DESC,
						ss.id DESC";
		$arrRs 	 = $this->query($strSQL);

		if ( $arrRs == NULL )
		{
			return NULL;
		}

		foreach( $arrRs as $k=>$Rs )
		{
			$arrData[$k] 		 = $Rs;
			$arrData[$k]->tip 	 =  '';
			$date_num 			 = floor((strtotime($Rs->end_time) - time())/86400);
			$arrData[$k]->enable = 1;

			if ( $date_num < 0 )
			{
				$arrData[$k]->enable = 0;
			}

			$arrData[$k]->date_tip = $this->getDateTipDesc( $date_num );

			$arrActivityTipDesc 		= $this->getActivityTipDesc( $Rs->discount_type, $Rs->discount_context );
			$arrData[$k]->discount_info = $arrActivityTipDesc['discount_info'];
			$arrData[$k]->tip			= $arrActivityTipDesc['tip'];
		}

		return $arrData;
	}

	/**
	 *	功能：通过商品分类获取专场列表
	 */
	public function getCategoryData( $cid )
	{
		$strSQL  = "SELECT
						`id`,
						`title`,
						`banner`,
						`discount_type`,
						`discount_context`,
						`end_time`,
						`discount`,
						`activity_id`
					FROM
						`special_show`
					WHERE
						unix_timestamp(`end_time`) >= unix_timestamp()
					AND
						(`main_category1`={$cid}
					OR
						`main_category2`={$cid})
					AND
						`status`=4
					ORDER BY
						`special_show`.`sorting`  DESC,
					    `special_show`.id DESC";

		$arrRs 	 = $this->query($strSQL);

		if ( $arrRs == NULL )
		{
			return NULL;
		}

		foreach( $arrRs as $k=>$Rs )
		{
			$arrData[$k] 		= $Rs;
			$arrData[$k]->tip 	= '';
			$date_num 			= floor((strtotime($Rs->end_time) - time())/86400);
			$arrData[$k]->enable = 1;

			if ( $date_num < 0 )
			{
				$arrData[$k]->enable = 0;
			}
			$arrData[$k]->date_tip = $this->getDateTipDesc( $date_num );

			$arrActivityTipDesc 		= $this->getActivityTipDesc( $Rs->discount_type, $Rs->discount_context );
			$arrData[$k]->discount_info = $arrActivityTipDesc['discount_info'];
			$arrData[$k]->tip			= $arrActivityTipDesc['tip'];
		}

		return $arrData;
	}

	/**
	 *	功能：通过指定专场信息
	 */
	public function getSpecialInfo( $sid, $aid='' )
	{
		$strSQL  = "SELECT
						ss.`id`,
						ss.`user_id`,
						ss.`title`,
						ss.`banner`,
						atime.`begin_time`,
						atime.`end_time`,
						atime.`activity_date`,
						ss.`discount_type`,
						ss.`discount_context`,
						(SELECT `brand_disc` FROM `user_brand` WHERE `brand_id`=ss.user_brand_id LIMIT 1) as brand_desc,
						ss.`activity_id`,
						atime.`type`
					FROM
						`activity_time` as atime
					LEFT JOIN
						`special_show` as ss
					ON
						ss.`activity_id`= atime.`id`
					WHERE
					(
						(
								atime.type =3
							AND
								ss.`activity_id`={$aid}
							AND
								ss.`status`=4
						)
						OR
						(
								atime.type !=3
							AND
								atime.`id`={$aid}
						)
					)
		";

		$arrRs 	 = $this->query($strSQL,true);
		if ( $arrRs == NULL )
		{
			return NULL;
		}

		$arrData 						= $arrRs;
		$arrData->date_info['tip']  	= '活动进行中';
		$arrData->date_info['type'] 	= 1;

		if ( $arrData->type != 0 )
		{
			// 如果是活动专场
			$arrData->tip 			  		= '';
			$date_num 				  		= floor((strtotime($arrRs->end_time) - time())/86400);

			$arrData->date_tip 		  		= $this->getDateTipDesc( $date_num );

			$arrActivityTipDesc 	  		= $this->getActivityTipDesc( $arrRs->discount_type, $arrRs->discount_context );
			$arrData->discount_info   		= $arrActivityTipDesc['discount_info'];
			$arrData->tip			  		= $arrActivityTipDesc['tip'];

			if ( strtotime($arrData->end_time) <= time() )
			{
				$arrData->date_info['tip']  = '活动已过期';
				$arrData->date_info['type'] = 0;
			}
		}
		else
		{
			// 如果是其他活动
			$sdate = $arrData->activity_date .' '. $arrData->begin_time;
			$edate = $arrData->activity_date .' '. $arrData->end_time;
			$now = time();

			if ( strtotime($sdate) > $now )
			{
				$arrData->date_info['tip']  = '活动未开始';
				$arrData->date_info['type'] = 0;
			}
			elseif ( strtotime($edate) < $now )
			{
				$arrData->date_info['tip']  = '活动已结束';
				$arrData->date_info['type'] = 0;
			}
		}

		if ( $arrRs->discount_type > 0 )
		{
			$discount_tip = $this->getActivityTipDesc( $arrRs->discount_type, $arrRs->discount_context );
			$arrRs->discount_tip = $discount_tip['tip'];
		}

		return $arrData;
	}

	/**
	 *	功能：获取指定专场的产品列表
	 */
	public function getSpecialProductList( $aid, $OrderBy )
	{
		$strSQL  = "SELECT
					ag.`active_price`,
					p.`id`,
					p.`product_name`,
					p.`image`
				FROM
					`activity_goods` as ag,
					`product` as p
				WHERE
					ag.`time_id`={$aid}
				AND
					ag.`product_id`=p.`id`
				ORDER BY
					p.{$OrderBy},
					p.`create_date` DESC
				";
		return $this->query($strSQL);
	}


	/**
	 *	通过活动结束时间与当前时间的匹配，获取时间提示描述
	 */
	private function getDateTipDesc( $date_num )
	{
		$date_tip	 	= '';

		if ( $date_num >= 0 )
		{
			if ( $date_num > 30 )
			{
				$date_tip = floor($date_num / 30) . '个月';
			}
			else
			{
				$date_num = $date_num == 0 ? 1 : $date_num;
				$date_tip = $date_num . '天';
			}

			$date_tip = $date_tip;
		}

		return $date_tip;
	}

	/**
	 *	通过活动提示描述
	 */
	private function getActivityTipDesc( $discount_type,$discount_context )
	{
		$discount_info  = '';
		$tip			= '';

		if ( $discount_context != null )
		{
			$data = json_decode( $discount_context, true );
			$discount_info = $data[0];
		}

		if( $discount_type == 1 )
		{
			$tip = '满' . $data[0]['om'] . '元减' . $data[0]['m'] .'元';

		}
		elseif( $discount_type == 2 )
		{
			$tip =  '满' . $data[0]['om'] . '件享受' . $data[0]['m'] .'折';
		}

		return array( 'discount_info'=>$discount_info, 'tip'=>$tip );
	}

}
?>