<?php
if ( !defined('HN1') ) die("no permission");
class product_activityBean
{

	private $db;
    private $setting;

    public function __get($para_name){
        if(isset($this->$para_name)){
            return($this->$para_name);
        }else{
            return(NULL);
        }
    }

    public function __set($para_name, $val){
        $this->$para_name = $val;
    }

/*
 * 用于首页每日10件、限时秒杀、大牌驾到
 *
 */

	function search_from_type($type)
	{
		$strLimit = "";

		if( $type == 1 )
		{
			$strLimit .= "LIMIT 10";
		}

		$sql = "SELECT p2.`id`, p2.`image`,p2.`product_name`,p2.`distribution_price`,p2.`sell_number` FROM  ".PRODUCT_ACTIVITY_TABLE." as p1,".PRODUCT_TABLE." as p2 WHERE p1.product_id = p2.id AND p1.`type`='". $type ."' AND p1.`status`=1 AND p2.`status`=1  ORDER BY p1.`create_date` DESC " . $strLimit;
	   	return $this->db->get_results($sql);
	}

    /**
     * 查找
     *
     * @param array $cond 条件
     * @param integer $page 页数
     * @param integer $perpage 每页数量
     * @return array
     */
    public function search($cond=array(), $page=1, $perpage=20){
        $where = array();
        $page = ($page-1)*$perpage;
        isset($cond['type']) && $where[] = 'pa.`type`='.$cond['type'];
        $sql = 'SELECT p.`id`,p.`image`,p.`product_name`,p.`distribution_price`,p.`sell_number` FROM `'.PRODUCT_ACTIVITY_TABLE.'` AS pa JOIN `'.PRODUCT_TABLE.'` AS p ON pa.`product_id`=p.`id` WHERE 1'.(empty($where) ? '' : ' AND '.implode(' AND ', $where)).' AND pa.`status`=1 ORDER BY pa.`sorting` DESC LIMIT ' . $page . ',' . $perpage;
        return $this->db->get_results($sql);

        //return get_pager_data($this->db, $sql, $page, $perpage);
    }
}
?>