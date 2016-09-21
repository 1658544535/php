<?php
$goodsUrl = $site.'product_detail?type=3&pid=';

$goodsId = intval($_GET['gid']);

$user = $_SESSION[SESS_K_USER];

$objPartin = M('h5_ability_partin');
$sql = 'SELECT * FROM `h5_ability_partin` WHERE `user_id`='.$user['id'].' ORDER BY `time` DESC';
$partin = $objPartin->query($sql, true);

if(!empty($partin)){
    $objClick = M('h5_ability_goods_click');
    $clickLog = array(
        'user_id' => $user['id'],
        'partin_id' => $partin->id,
        'goods_id' => $goodsId,
        'time' => time(),
    );

    $objClick->add($clickLog);
    $objPartin->modify(array('goods_click_num'=>$partin->goods_click_num+1), array('id'=>$partin->id));
}

redirect($goodsUrl.$goodsId);
?>