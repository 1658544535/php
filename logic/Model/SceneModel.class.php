<?php
/**
 * 场景模型
 */
class SceneModel extends Model
{
	 public function __construct($db, $table=''){
        $table = 'scene';
        parent::__construct($db, $table);
    }

	/**
	 *  获取场景列表
	 */
	public function getSceneList()
	{
		//$objScene = $SceneModel->getAll( array('status'=>1, 'activity_id'=>array('!='=>'1')  ), array('id','image','end_time','name','activity_id'), '`sorting` ASC, `id` DESC' );
		$objScene = $this->getAll( array('status'=>1, 'activity_id'=>array('!='=>'1'),'_string_'=>"DATE_FORMAT( `end_time`,'%Y-%m-%d') >= DATE_FORMAT( NOW(),'%Y-%m-%d')"  ), '*', '`sorting` ASC, `id` DESC' );
		$date_tip = '';

		foreach( $objScene as $k=>$Rs )
		{
			$arrData[$Rs->id] = $Rs;
			$date = DataTip( $Rs->end_time );
			$arrData[$Rs->id]->date_tip = $date['date_tip'];
		}

		return $arrData;
	}

	/**
	 * 	获取场景详情
	 */
	public function getSceneInfo( $nSceneID )
	{
		$objSceneList = $this->getSceneList();
		return isset($objSceneList[$nSceneID]) ? $objSceneList[$nSceneID] : NULL;
	}

	/**
	 *	 获取场景产品
	 */
	public function getSceneProductData( $nSceneID )
	{
		$arrData = NULL;
		$strSQL  = "SELECT
						( SELECT `image` FROM `product` WHERE `id`=sp.`product_id`) as `image`,
						sp.`title`,
						sp.`introduction`,
						sp.`product_id`,
						sp.`good_id`,
						sp.`is_introduce`,
						ag.`active_price`,
						ag.`sell_price`
					FROM
						`scene_product`  as sp,
						`activity_goods` as ag
					WHERE
						sp.`good_id`=ag.`id`
					AND
						sp.`scene_id`={$nSceneID}
					ORDER BY
						sp.`id` DESC";

		$arrRs 	 = $this->query($strSQL);

		if ( $arrRs != NULL )
		{
			foreach( $arrRs as $k=>$Rs )
			{
				if ( $Rs->is_introduce == 1 )
				{
					$arrData['introduce'][$k] = $Rs;
				}
				else if ( $Rs->is_introduce == 0 )
				{
					$arrData['no_introduce'][$k] = $Rs;
				}
			}
		}

		return $arrData;
	}

	/**
	 *  获取场景列表(过滤相关信息)
	 */
	public function getSceneList4Filter()
	{
		$objScene = $this->getAll( array('status'=>1, 'type'=>1, 'isdelete'=>0, '_string_'=>"DATE_FORMAT( `end_time`,'%Y-%m-%d') >= DATE_FORMAT( NOW(),'%Y-%m-%d')"  ), '*', '`sorting` ASC,`create_date` DESC' );

		foreach( $objScene as $k=>$Rs )
		{
			$arrData[$Rs->id] = $Rs;
			$date = DataTip( $Rs->end_time );
			$arrData[$Rs->id]->date_tip = $date['date_tip'];
		}

		return $arrData;
	}
}
?>