<?php
if ( !defined('HN1') ) die("no permission");

class productBean
{
	function search($db,$page,$per,$status=0,$range_s='',$condition='',$keys='',$type='0')
	{
		$sql = "select * from ".PRODUCT_TABLE." where id>0";
			if($status > -1){
				$sql .= " and status ='".$status."'";
			}
			if($range_s!=''){
				$sql .= " and range_s like '%".$range_s."%'";
			}
			if($keys != ''){
				$sql .= " and name like '%".$keys."%'";
			}
//			if($type >0){
//				$sql .= " and category_id = '".$type."'";
//			}
		$sql.=" order by id desc";
		//echo $sql;
		$pager = get_pager_data($db,$sql,$page,$per);
		return $pager;
	}


  function searchs($db,$page,$per,$type=-1,$userid=-1)
	{
		$sql = "select * from ".PRODUCT_TABLE." where id>0 and status=1";
			if($type > -1){
				$sql .= " and product_type_ids like '%".$type."%'";
			}
            if($userid > -1){
				$sql .= " and user_id = '".$userid."'";
			}
			$sql.=" order by sorting asc,id desc";

//		echo $sql;
		$pager = get_pager_data($db,$sql,$page,$per);
		return $pager;
	}

	function search_lists($db,$page,$per,$pid=-1,$status=-1)
	{
//		$sql = "select * from ".PRODUCT_TABLE." where id>0 and status=1";
        $sql = "select a.*,b.pid from ".PRODUCT_TABLE." as a join product_type as b on a.product_type_id=b.id";

			if($pid > -1){
				$sql .= " and b.pid = '".$pid."'";
			}
			if($status > -1){
				$sql .= " and status ='".$status."'";
			}

		$sql.=" order by sorting asc,id desc";

		echo $sql;

		$pager = get_pager_data($db,$sql,$page,$per);
		return $pager;
	}



	function get_results($db,$keys)
	{
		$sql = "select * from ".PRODUCT_TABLE;
		if($keys!='')
		{
			$sql.=" where classid=".$keys;
		}
		$sql.=" order by sorting asc,product_id desc";
		$list = $db->get_results($sql);
		return $list;
	}

	function get_results_search($db,$key)
	{
		$sql = "select * from ".PRODUCT_TABLE." where product_name like '%".$key."%' and status=1 order by sorting asc,id desc";
		return $db->get_results($sql);
	}

	function get_results_userid($db,$uid)
	{
		 $sql = "select * from ".PRODUCT_TABLE." where user_id = '".$uid."' and status=1 order by sorting asc,id desc";
		return $db->get_results($sql);
	}

	function get_similar_product($db,$product_id)
	{
		$sql = "select * from ".PRODUCT_TABLE." as a where a.id <> '".$product_id."' and a.product_type_id = (select b.product_type_id from ".PRODUCT_TABLE." as b where a.product_type_id!=6 and a.product_type_ids not like '%:0:%' and b.id = '".$product_id."') and a.status=1 order by rand(),id desc limit 6";
		return $db->get_results($sql);
	}

	// 功能：获取指定为下架的商品
	function detail($db,$id)
	{
		$sql = "select * from ".PRODUCT_TABLE." where id = {$id}";
		$obj = $db->get_row($sql);
		return $obj;
	}

	// 功能：获取指定的商品
    function details($db,$id)
	{
		$sql = "select * from ".PRODUCT_TABLE." where id = {$id}";
		return $db->get_row($sql);

	}

	function get_results_productid($db,$product_id){
		$sql = "select * from ".PRODUCT_TABLE." where id='".$product_id."'";
		return $db->get_row($sql);
	}

	function deletedate($db,$id)
	{
		$db->query("delete from ".PRODUCT_TABLE." where product_id in (".implode(",",$id).")");
		return true;
	}

	function create($db,$objParam)
	{
		$strSQL  = "INSERT INTO ".USER_CART_TABLE." (
					`user_id`,
					`shop_id`,
					`product_id`,
					`product_name`,
					`product_image`,
					`stock_price`,
					`num`,
					`channel`,
					`create_date`,
					`update_date`,
					`postage_type`,
					`weight`,
					`sku_link_id`
				) values (
					{$objParam->user_id},
					{$objParam->shop_id},
					{$objParam->product_id},
					'{$objParam->product_name}',
					'{$objParam->product_image}',
					'{$objParam->stock_price}',
					{$objParam->num},
					'{$objParam->channel}',
					'{$objParam->create_date}',
					'{$objParam->update_date}',
					'{$objParam->postage_type}',
					'{$objParam->weight}',
					IF( $objParam->sku_link_id>0,$objParam->sku_link_id,null)
				)";
		$db->query($strSQL);
		return $db->insert_id;
	}

	function update($packge=-1,$weight=null,$name=null,$title=null,$model=null,$image=null,$category_id=-1,$category_id2=-1,$category_big=-1,$price=null,$price_old=null,$status=-1,$viewed=-1,$description=null,$sorting=-1,$hot=-1,$inventory=-1,$unit=null,$standard=null,$brand=null,$origin_place=null,$range_s=null,$distribution_date=null,$integral=-1,$random=-1,$sell_number=-1,$db,$id)
	{
		$update_values="";
		if($packge>-1){
			$update_values.="packge='".$packge."',";
		}
		if($weight!=null){
			$update_values.="weight='".$weight."',";
		}
		if($name!=null){
			$update_values.="name='".$name."',";
		}
		if($title!=null){
			$update_values.="title='".$title."',";
		}
		if($model!=null){
			$update_values.="model='".$model."',";
		}
		if($image!=null){
			$update_values.="image='".$image."',";
		}
		if($category_id>-1){
			$update_values.="category_id='".$category_id."',";
		}
		if($category_id2>0){
			$update_values.="category_id2='".$category_id2."',";
		}
		if($category_big>0){
			$update_values.="category_big='".$category_big."',";
		}
		if($price!=null){
			$update_values.="price='".$price."',";
		}
		if($price_old!=null){
			$update_values.="price_old='".$price_old."',";
		}
		if($status>0){
			$update_values.="status='".$status."',";
		}
		if($viewed>0){
			$update_values.="viewed='".$viewed."',";
		}
		if($description!=null){
			$update_values.="description='".$description."',";
		}
		if($sorting>0){
			$update_values.="sorting='".$sorting."',";
		}
		if($hot>-1){
			$update_values.="hot='".$hot."',";
		}
		if($inventory>0){
			$update_values.="inventory='".$inventory."',";
		}
		if($unit!=null){
			$update_values.="unit='".$unit."',";
		}
		if($standard!=null){
			$update_values.="standard='".$standard."',";
		}
		if($brand!=null){
			$update_values.="brand='".$brand."',";
		}
		if($origin_place!=null){
			$update_values.="origin_place='".$origin_place."',";
		}
		if($range_s!=null){
			$update_values.="range_s='".$range_s."',";
		}
		if($distribution_date!=null){
			$update_values.="distribution_date='".$distribution_date."',";
		}
		if($integral>0){
			$update_values.="integral='".$integral."',";
		}
		if($random>0){
			$update_values.="random='".$random."',";
		}
		if($sell_number>-1){
			$update_values.="sell_number='".$sell_number."',";
		}
		$db->query("update ".PRODUCT_TABLE." set ".substr($update_values,0,$update_values.strlen-1)." where product_id=".$id);
		return true;
	}


	function updatestate($db,$id,$state)
	{
		if($state==0){
			$c_state=1;
		}else if($state==1){
			$c_state=0;
		}
		$db->query("update ".PRODUCT_TABLE." set status='".($c_state)."' where product_id in (".implode(",",$id).")");
		return true;
	}


	function update_viewed($db,$product_id){
		$sql = "update ".PRODUCT_TABLE." set hits=hits+1 where id='".$product_id."'";

		$db->query($sql);
		return true;
	}


	/*
	 * 	功能：更新销售量
	 * */
	function update_sell_number($db,$number,$product_id){
		$sql = "update ".PRODUCT_TABLE." set sell_number=sell_number+".$number." where id='".$product_id."'";
		$db->query($sql);
		return true;
	}



	// 获取 72小时内 上传的产品
	function get_today_product($db)
	{
		//$sql = "SELECT * FROM " . PRODUCT_TABLE . " WHERE  UNIX_TIMESTAMP(NOW()) - 3600 * 24 < UNIX_TIMESTAMP(`create_date`);";
		$sql = "SELECT * FROM " . PRODUCT_TABLE . " WHERE `status`=1 AND `product_type_id`!=6 AND `product_type_ids`not like '%:0:%' AND  UNIX_TIMESTAMP(NOW()) - 3600 * 72 < UNIX_TIMESTAMP(`create_date`) ORDER BY `id` DESC;";
		return $db->get_results($sql);
	}


	/*
	 * 获取产品的销售记录
	 * 参数:
	 * $pid:产品id
	 * $Sales:电商销量
	 * $sell_num:总销量
	 * */
	function get_sell_num($db,$pid)
	{
		$sql = "select ifnull(sum(num),0) as sell_num from user_order_detail left join user_order uo on uo.id=order_id where product_id={$pid} and uo.order_status>=2";
		$Sales = $db->get_var("select ifnull(sum(num),0) from ele_order where product_id={$pid}");
		$sell_num = $db->get_row($sql)->sell_num + $Sales;		//(产品销量+电商销量)
		return $sell_num;
	}


/*
 * 用于首页TOP排行（根据销量排序）
 */
    function search_from_sell_number($db,$page='1' )
	{
		$page = ($page-1) * 10;
//		$sql = "SELECT `id`,`image`,`product_name`,`distribution_price`,`sell_number` FROM ".PRODUCT_TABLE." WHERE `status`=1 AND `sell_number`>0  AND `product_type_ids` NOT LIKE '%:0:%' ORDER BY `sell_number` DESC,`id` DESC LIMIT $page ,10";
		$sql = "select t.postage_type as postageType,t.weight as weight,t.unit as unit,(select name from synthetical_dict where value=t.unit and type = 'unit') as unitName,us.name as shopName, t.product_sketch as productSketch,t.product_num as productNum,t.discount as discount,t.recommend as recommend,t.brand as brand,t.texture as texture,t.age as age,t.product_function as productFunction,t.location as location,t.is_power as isPower,t.pack as pack,t.is_hotsale as isHotsale, t.id as id,t.user_id as userId,u.name as userName,t.product_no as productNo,t.product_type_id as productTypeId,pt.name as productTypeName,substring_index(substring_index(t.product_type_ids,':',2),':',-1) as productTypeIds, t.product_name as productName,t.product_name_en as productNameEn,t.distribution_price as distributionPrice,t.selling_price as sellingPrice,t.lowest_price as lowestPrice,t.minimum as minimum,t.content as content, t.ladder_price as ladderPrice,t.image as image,t.qrcode as qrcode,t.hits as hits,t.is_introduce as isIntroduce,(select name from sys_dict where value=t.is_introduce and type = 'yes_no') as isIntroduceName,t.sorting as sorting,t.status as status,(select name from sys_dict where value=t.status and type = 'status') as statusName,(select address from user_shop where user_id = t.user_id) as userAddress,t.create_by as createBy,t.create_date as createDate,t.update_by as updateBy, t.update_date as updateDate,t.remarks as remarks,t.version as version,t.sell_number as sellNumber,t.is_new as isNew,(select name from sys_dict where value=t.is_new and type = 'yes_no') as isNewName , (select name from synthetical_dict where value=t.is_hotsale and type = 'is_hotsale') as isHotsaleName, (select name from sys_dict where value=t.postage_type and type = 'yes_no') as postageTypeName from product t left join sys_login u on t.user_id = u.id left join product_type pt on t.product_type_id = pt.id left join user_shop us on t.user_id = us.user_id where 1=1 and t.status=1 and us.status=1 and (t.product_type_ids!=':0:' and t.product_type_id!=6) and sell_number+base_number > 0 order by sell_number+base_number desc, id desc limit {$page} ,10";
		return $db->get_results($sql);
	}


	/*搜索商品列表*/
	function get_search_list($db,$page,$per,$key)
	{
		$sql = "select * from ".PRODUCT_TABLE." where id>0 and status=1 and product_type_id!=6 and product_type_ids not like '%:0:%'";

		if($key!='')
		{
			$sql .= " and product_name  like '%".$key."%'";
		}
		$pager = get_pager_data($db,$sql,$page,$per);

		return $pager;
	}

	/*
	 * 功能：获取每日新品的记录
	 * */
	function get_product_news( $db,$page=1,$pageCount=20 )
	{
		$page = ($page-1) * 20;
		$sql = "SELECT `id`,`image`,`product_name`,`distribution_price`,`sell_number` FROM ".PRODUCT_TABLE." WHERE `status`=1 AND `product_type_id`!=6 AND `product_type_ids` NOT LIKE '%:0:%' ORDER BY `id` DESC LIMIT {$page},{$pageCount}";
		return $db->get_results($sql);
	}

	/*
	 * 功能：获取产品列表
	 * */
	function search_list($db,$page,$page_num,$type=-1,$product_type=-1,$key)
	{
		$page = ( $page - 1 ) * $page_num;

		$sql = "SELECT `id`,`image`,`product_name`,`distribution_price`,`sell_number` FROM ".PRODUCT_TABLE." WHERE `status`=1 AND `product_type_id`!=6 AND `product_type_ids` NOT LIKE '%:0:%'";

		if($type > -1)
		{
			$sql .= " AND `product_type_ids` LIKE '%:".$type.":%'";
		}

		if(is_array($product_type))
		{
			$sql .= " AND `product_type_id` IN ('".implode("','", $product_type)."')";
		}
		elseif($product_type > -1)
		{
			$sql .= " AND `product_type_id` = '".$product_type."'";
		}

        if($key!='')
        {
			$sql .= " AND `product_name` LIKE '%".$key."%'";
		}

		$sql.=" ORDER BY `id` DESC LIMIT {$page},{$page_num}";

		return $db->get_results($sql);
	}


	/*
	 * 功能：获取该产品的颜色属性
	 *
	 * @param integer $aid 活动id，-1不限
	 * */
	function get_sku_color_list( $db, $pid, $aid=-1)
	{
		$arr = null;
		$strSQL = "SELECT `Id`,`attribute`,`value`,`image` FROM `sku_attribute` WHERE `status`=1 AND `Id` in ( SELECT `sku_color_id` FROM `product_sku_link` as psl WHERE `product_id`={$pid} AND `status`=1";
		($aid >= 0) && $strSQL .= ' AND `activity_id`='.$aid;
		$strSQL .= ")";
		$rs 	= $db->get_results( $strSQL );

		if ( $rs != null )
		{
			foreach( $rs as $info )
			{
				$arr[$info->Id] = $info;
			}
		}

		return $arr;
	}

	/*
	 * 功能：获取该产品的颜色属性
	 *
	 * @param integer $aid 活动id，-1不限
	 * */
	function get_sku_format_list( $db, $pid, $aid=-1)
	{
		$arr = null;
		$strSQL = "SELECT `Id`,`attribute`,`value`,`image` FROM `sku_attribute` WHERE `status`=1 AND `Id` in ( SELECT `sku_format_id` FROM `product_sku_link` as psl WHERE `product_id`={$pid} AND `status`=1";
		($aid >= 0) && $strSQL .= ' AND `activity_id`='.$aid;
		$strSQL .= ")";
		$rs = $db->get_results( $strSQL );

		if ( $rs != null )
		{
			foreach( $rs as $info )
			{
				$arr[$info->Id] = $info;
			}
		}
		return $arr;
	}

	/*
	 * 功能：获取该产品是否存在sku
	 * */
	function get_product_has_sku( $db, $pid, $activeId=-1)
	{
		$strSQL = "SELECT count(*) FROM `product_sku_link` WHERE `product_id`={$pid}";
		($activeId >= 0) && $strSQL .= ' AND `activity_id`='.$activeId;
		$total  = $db->get_var( $strSQL );
		return ( $total > 0 ) ? true : false;
	}


	/*
	 * 功能：获取该产品是否包含SKU
	 * */
	function get_product_sku_info( $db, $pid,$sku_color_id,$sku_format_id )
	{
		$strSQL = "SELECT * FROM `product_sku_link` WHERE `product_id`={$pid} AND `sku_color_id`={$sku_color_id} AND `sku_format_id`={$sku_format_id}";
		return $db->get_row( $strSQL );
	}

	/*
	 * 功能：获取产品sku描述
	 * */
	function get_product_sku_desc($db, $sku_attr)
	{
		$str_attr 	= implode( ',',$sku_attr );
		$strSQL 	= "SELECT `Id`,`attribute`,`value`,`image` FROM `sku_attribute` WHERE `status`=1 AND `Id` in ({$str_attr})";
		$rs 		= $db->get_results( $strSQL );
		return $rs;
	}

	/*
	 * 功能：获取与商品和SKU匹配的对应SKU列表
	 * */
	function get_sku_type_from_sku_id( $db, $pid, $type, $sku_id )
	{
		$strWhere = '';

		if ( $type == 1 )	// 获取颜色列表
		{
			$strSQL = "SELECT `Id` FROM `sku_attribute` WHERE `status`=1 AND `Id` in ( SELECT `sku_color_id` FROM `product_sku_link` as psl WHERE `product_id`={$pid} AND `sku_format_id`={$sku_id} AND `status`=1)";
		}
		else
		{
			$strSQL = "SELECT `Id` FROM `sku_attribute` WHERE `status`=1 AND `Id` in ( SELECT `sku_format_id` FROM `product_sku_link` as psl WHERE `product_id`={$pid} AND `sku_color_id`={$sku_id} AND `status`=1)";
		}

		$rs = $db->get_results( $strSQL );

		foreach( $rs as $info )
		{
			$arr[$info->Id] = $info;
		}

		return $arr;
	}

	/*
	 * 功能：获取与SKU相关的产品价格
	 * */
	function get_sku_product_price( $db, $pid, $sku_color_id, $sku_format_id )
	{
		if ( $sku_color_id == ""  || $sku_format_id == "" )
		{
			$strSQL = "SELECT `ladder_price` FROM `product` WHERE `id`={$pid}";
		}
		else
		{
			$strSQL = "SELECT `price` FROM `product_sku_link` WHERE `sku_color_id`={$sku_color_id} AND `sku_format_id`={$sku_format_id} AND `product_id`={$pid}";
		}

		return $db->get_var( $strSQL );
	}

	/*
	 * 根据product_sku_id获取库存量
	 * */
	function get_product_stock( $db, $product_sku_id )
	{
		$strSQL = "SELECT `stock` FROM `product_sku_link` WHERE `Id`={$product_sku_id}";
		return $db->get_var($strSQL);
	}

	/**
	 * 获取产品有效的sku信息
	 *
	 * @param object $db 数据库句柄
	 * @param string $type 类型，color颜色，format规则
	 * @param integer $pid 产品id
	 * @param integer $skuid sku id
	 * @param integer $aid 活动id
	 * @return array
	 */
	public function getValidSku($db, $type, $pid, $skuid, $aid=0){
		$list = array();
		$types = array('color'=>array('get'=>'sku_color_id','set'=>'sku_format_id'), 'format'=>array('get'=>'sku_format_id','set'=>'sku_color_id'));
		$strSQL = "SELECT * FROM `sku_attribute` WHERE `status`=1 AND `Id` in ( SELECT `{$types[$type]['get']}` FROM `product_sku_link` as psl WHERE `product_id`={$pid} AND `{$types[$type]['set']}`={$skuid} AND `status`=1 AND `stock`>0 AND `activity_id`={$aid})";
		$rs = $db->get_results( $strSQL );
		foreach($rs as $info){
			$list[$info->id] = $info;
		}
		return $list;
	}

	/**
	 * 获取产品对应的sku信息
	 *
	 * @param object $db 数据库句柄
	 * @param integer $pid 产品id
	 * @param integer $scid sku颜色id
	 * @param integer $sfid sku规格id
	 * @param integer $aid 活动id
	 * @return object
	 */
	public function getSkuInfo($db, $pid, $scid, $sfid, $aid){
		$sql = 'SELECT * FROM `product_sku_link` WHERE `product_id`='.$pid.' AND `sku_color_id`='.$scid.' AND `sku_format_id`='.$sfid.' AND `activity_id`='.$aid;
		return $db->get_row($sql);
	}

	/**
	 * 根据sku id获取sku信息
	 *
	 * @param object $db 数据库句柄
	 * @param integer $skuid sku id
	 * @return object
	 */
	public function getSkuById($db, $skuid){
		$sql = 'SELECT * FROM `product_sku_link` WHERE `Id`='.$skuid;
		return $db->get_row($sql);
	}

	/**
	 * 根据sku id获取多个sku信息
	 *
	 * @param object $db 数据库句柄
	 * @param array $skuids sku id
	 * @return array
	 */
	public function getSkusById($db, $skuids){
		$list = array();
		if(!empty($skuids)){
			$sql = 'SELECT * FROM `product_sku_link` WHERE `Id` IN ('.implode(',', $skuids).')';
			$list = $db->get_results($sql);
		}
		return $list;
	}
}
?>
