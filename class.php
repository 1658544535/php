<?php
define('HN1', true);
require_once('./global.php');

$user = $_SESSION['userinfo'];
$return_url = (!isset($_GET['return_url']) || ($_GET['return_url'] == '')) ? '/index' : $_GET['return_url'];

$ProductTypeModel = M('product_type');
$productList1 = $ProductTypeModel->getAll( array( 'status'=>1, 'pid'=> 1), '`id`,`name`', '`sorting` ASC' );
$productList2 = $ProductTypeModel->getAll( array( 'status'=>1, 'pid'=> 2), '`id`,`name`', '`sorting` ASC' );
$productList3 = $ProductTypeModel->getAll( array( 'status'=>1, 'pid'=> 3), '`id`,`name`', '`sorting` ASC' );
$productList4 = $ProductTypeModel->getAll( array( 'status'=>1, 'pid'=> 4), '`id`,`name`', '`sorting` ASC' );
$productList5 = $ProductTypeModel->getAll( array( 'status'=>1, 'pid'=> 5), '`id`,`name`', '`sorting` ASC' );
$productList6 = $ProductTypeModel->getAll( array( 'status'=>1, 'pid'=> 6), '`id`,`name`', '`sorting` ASC' );

$agetype1     = $ProductTypeModel->getAll( array( 'status'=>1, 'age_type'=> 1), '`id`,`name`', '`sorting` ASC' );
$agetype2     = $ProductTypeModel->getAll( array( 'status'=>1, 'age_type'=> 2), '`id`,`name`', '`sorting` ASC' );
$agetype3     = $ProductTypeModel->getAll( array( 'status'=>1, 'age_type'=> 3), '`id`,`name`', '`sorting` ASC' );


include "tpl/class_web_new.php";
?>
