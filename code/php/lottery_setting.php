<?php
/**
 * 相关设置信息
 * Date: 2015/7/17
 * Time: 11:29
 */
return array(
    //每天可抽奖的次数
    'per_day_num' => 2,

    //每天可无限制抽奖的次数
    'per_day_free_num' => 1,

    //抽奖奖项
    //chance:概率
    //type:-1不中，0微信红包，1优惠券，2转发攒运气
    //cpn_id:优惠券id
    //pos:转盘类型为奖项扇区范围内角度，九宫格类型是奖项位置(左上角为0，顺时针排列)
    //prize:奖品名
    //money:min最小金额，max最大金额
    'prize' => array(
        array('chance'=>30,'type'=>-1,'data'=>array('pos'=>200,'prize'=>'谢谢参与')),
        array('chance'=>2,'type'=>1,'data'=>array('cpn_id'=>2,'pos'=>250,'prize'=>'10元代金券')),
        array('chance'=>30,'type'=>-1,'data'=>array('pos'=>290,'prize'=>'谢谢参与')),
        array('chance'=>2,'type'=>0,'data'=>array('pos'=>340,'prize'=>'红包')),
        array('chance'=>2,'type'=>2,'data'=>array('pos'=>20,'prize'=>'转发攒运气')),
        array('chance'=>2,'type'=>1,'data'=>array('cpn_id'=>1,'pos'=>70,'prize'=>'5元代金券')),
        array('chance'=>30,'type'=>-1,'data'=>array('pos'=>120,'prize'=>'谢谢参与')),
        array('chance'=>2,'type'=>0,'data'=>array('pos'=>160,'prize'=>'红包')),
    ),
);