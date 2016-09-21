<?php

define('HN1', true);
require_once('./global.php');

require_once  LOGIC_ROOT.'productBean.php';
require_once  LOGIC_ROOT.'sys_loginBean.php';
require_once  LOGIC_ROOT.'product_typeBean.php';
$minfo = $_REQUEST['minfo'] == null ? '' : $_REQUEST['minfo'];

$user = $_SESSION['userinfo'];
if($openid != null){
	$userid = $user->id;
}else{
	redirect("login?dir=product");
	return;
}

$page = $_GET['page'] == null ? 1 : intval($_GET['page']);
$type = $_GET['type'] == null ? -1 : intval($_GET['type']);
$is_new = $_GET['is_new'] == null ? 0 : intval($_GET['is_new']);
$sell = $_GET['sell'] == null ? 0 : intval($_GET['sell']);
$is_introduce = $_GET['is_introduce'] == null ? 0 : intval($_GET['is_introduce']);

$ib = new productBean();
$sb = new sys_loginBean();
$pb = new product_typeBean();
$productList = $ib->searchs($db,$page,10,$type,$userid);
$obj_user = $sb->detail($db,$userid);
$cateeeeeegory_id=$pb->search($db,$page,40,$classid);
include "tpl/supply_product_web.php";
?>
