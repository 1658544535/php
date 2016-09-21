<?php
if ( !defined('HN1') ) die("no permission");

/**
 *	活动模型类
 */

class ActivityTitleModel extends Model
{
	 public function __construct($db, $table='')
	 {
        $table = 'activity_title';
        parent::__construct($db, $table);
        $this->ProductModel = D('Product');
    }


	/**
	 *	功能：获取活动信息
	 */
	public function getActivityTimeInfo( $nActivityID )
	{
		$strSQL 	= "
						SELECT
							t.id as id,
							t.title as title,
							t.banner as banner,
							t.title_pic as titlePic,
							t.title_picture as titlePicture,
							t.title_photo as titlePhoto,
							t.type as type,
							t.status as status,
							(
								SELECT
									name
								FROM
									sys_dict
								WHERE
									type='status'
								AND
									value=t.status
							) as statusName,
							t.create_by as createBy,
							t.create_date as createDate,
							t.update_by as updateBy,
							t.update_date as updateDate
						FROM
							activity_title t
						WHERE
							1=1
						AND
							t.status = 1
						AND
							t.id = {$nActivityID}
						AND
							t.type = 5
					";

		return $this->query( $strSQL, true );
	}


	/**
	 *	获取活动单品记录
	 */
	public function getActivityTimeProductTop( $nActivityID )
	{
		$strSQL 	= "
						SELECT
						    a.id as productId,
						    a.product_name as productName,
						    a.image as image,
						    b.id as id,
						    b.type as type,
						    b.product_type as productType,
						    b.activity_id as activityId,
						    b.title_id as titleId,
						    g.active_price as activePrice,
							g.sell_price as sellPrice,
							t.title as activityTitle
						FROM
							product_activity b
						LEFT JOIN
							product a
						ON
							a.id = b.product_id
						LEFT JOIN
							activity_goods g
						ON
								g.product_id = b.product_id
							AND
								g.time_id = b.activity_id
						LEFT JOIN
							activity_time t
						ON
							t.id = b.activity_id
						WHERE
							g.status = 1
						AND
							 t.isdelete = '0'
						AND
							t.type = 3
						AND
							b.status = 1
						AND
							a.status = 1
						AND
							b.type = 5
						AND
							b.product_type = 1
						AND
						    b.title_id = {$nActivityID}
						ORDER BY
							b.sorting
						LIMIT  3
					";

		return $this->query( $strSQL );
	}

	/**
	 *	获取单品连接专场记录
	 */
	public function getActivityTimeProductList( $nActivityID )
	{
		$strSQL 	= "
						SELECT
						    a.id as productId,
						    a.product_name as productName,
						    a.image as image,
						    b.id as id,
						    b.type as type,
						    b.product_type as productType,
						    b.activity_id as activityId,
						    b.title_id as titleId,
						    g.active_price as activePrice,
							g.sell_price as sellPrice,
							t.title as activityTitle
						FROM
							product_activity b
						LEFT JOIN
							product a
						ON
							a.id = b.product_id
						LEFT JOIN
							activity_goods g
						ON
								g.product_id = b.product_id
							AND
								g.time_id = b.activity_id
						LEFT JOIN
							activity_time t
						ON
							t.id = b.activity_id
						WHERE
							g.status = 1
						AND
							 t.isdelete = '0'
						AND
							t.type = 3
						AND
							b.status = 1
						AND
							a.status = 1
						AND
							b.type = 5
						AND
							b.product_type = 2
						AND
						    b.title_id = {$nActivityID}
						ORDER BY
							b.sorting
						LIMIT  12
					";

		return $this->query( $strSQL );
	}

}
?>
