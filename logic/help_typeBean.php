<?php
if ( !defined('HN1') ) die("no permission");

class help_typeBean
{
	function get_type_list( $db,$type )
	{
		echo $strSQL = "SELECT `id`, `name` FROM `help_type` WHERE `pid`=$type";
		return $db->get_results($strSQL);
	}
}
?>
