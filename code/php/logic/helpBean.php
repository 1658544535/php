<?php
if ( !defined('HN1') ) die("no permission");

class helpBean
{

	function get_type_list( $db,$type )
	{
		$strSQL = "SELECT * FROM `help` WHERE `type_id`=$type";
		return $db->get_results($strSQL);
	}

	function get_content( $db,$id )
	{
		$strSQL = "SELECT * FROM `help` WHERE `id`=$id ";
		return $db->get_row($strSQL);
	}
}
?>
