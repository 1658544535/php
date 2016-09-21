<?php
if ( !defined('HN1') ) die("no permission");

class promotion_linkBean
{
	public function create( $db, $promotion, $purchaser  )
	{
		$sql = "insert into `promotion_link` ( `promotion`, `purchaser`,`create_time`) values ('".$promotion."','".$purchaser."','".time()."')";
		$db->query($sql);
		$uid = $db->insert_id;
		return $uid;
	}

	public function update( $db, $promotion, $purchaser  )
	{
		$sql = "update `promotion_link` set `status`=1  where `promotion`='". $promotion ."' AND `purchaser`='". $purchaser ."'";
		return $db->query($sql);
	}

}
?>
