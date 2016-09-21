<?php
define('HN1', true);
require_once('./global.php');

$type = $_GET["type"];

if($type>0&&$type!=''){
    $q=$db->get_results("select * from sys_area where pid = '".$type."' order by id asc");
        $select[] = array("id"=>0,"name"=>"请选择");
   foreach($q as $q0){
        $select[] = array("id"=>$q0->id,"name"=>$q0->name);
    }
    echo json_encode($select);
}
?>
