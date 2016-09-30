
<?php
define('HN1', true);
require_once('./global.php');

$name  = CheckDatas( 'name', '' );
$page           = max(1, intval($_POST['page']));

$search = apiData('searchAll.do', array('name'=>$name,'pageNo'=>$page,'sorting'=>1));

$footerNavActive = 'search';
include_once('tpl/search_product_web.php');
?>