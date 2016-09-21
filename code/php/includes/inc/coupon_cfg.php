<?php
/**
 * 优惠券类型设置相关信息
 */
return array(
    'new_member' => array(//新人
        '1-10' => array(//规则类型-面额
            'type' => 1,//规则类型
            'source' => 1,//来源类型
            'content' => array(//规则
                'om' => '68',//可使用的订单金额
                'm' => '10',//面额
            ),
            'valid_type' => 'delay',//有效期类型，delay延期(已获得的时间为开始时间)
            'valid_end' => 30,//valid_type为delay时，此值为延期天数
        ),
        '1-20' => array(//规则类型-面额
            'type' => 1,//规则类型
            'source' => 1,//来源类型
            'content' => array(//规则
                'om' => '128',//可使用的订单金额
                'm' => '20',//面额
            ),
            'valid_type' => 'delay',//有效期类型，delay延期(已获得的时间为开始时间)
            'valid_end' => 30,//valid_type为delay时，此值为延期天数
        ),
        '1-50' => array(//规则类型-面额
            'type' => 1,//规则类型
            'source' => 1,//来源类型
            'content' => array(//规则
                'om' => '268',//可使用的订单金额
                'm' => '50',//面额
            ),
            'valid_type' => 'delay',//有效期类型，delay延期(已获得的时间为开始时间)
            'valid_end' => 30,//valid_type为delay时，此值为延期天数
        ),
    ),
    'first_order' => array(//首单
        '1-10' => array(//规则类型-面额
            'type' => 1,//规则类型
            'source' => 2,//来源类型
            'content' => array(//规则
                'om' => '68',//可使用的订单金额
                'm' => '10',//面额
            ),
            'valid_type' => 'delay',//有效期类型，delay延期(已获得的时间为开始时间)
            'valid_end' => 30,//valid_type为delay时，此值为延期天数
        ),
        '1-20' => array(//规则类型-面额
            'type' => 1,//规则类型
            'source' => 2,//来源类型
            'content' => array(//规则
                'om' => '128',//可使用的订单金额
                'm' => '20',//面额
            ),
            'valid_type' => 'delay',//有效期类型，delay延期(已获得的时间为开始时间)
            'valid_end' => 30,//valid_type为delay时，此值为延期天数
        ),
        '1-50' => array(//规则类型-面额
            'type' => 1,//规则类型
            'source' => 2,//来源类型
            'content' => array(//规则
                'om' => '268',//可使用的订单金额
                'm' => '50',//面额
            ),
            'valid_type' => 'delay',//有效期类型，delay延期(已获得的时间为开始时间)
            'valid_end' => 30,//valid_type为delay时，此值为延期天数
        ),
    ),
    'holiday' => array(//节日
        '1-10' => array(//规则类型-面额
            'type' => 1,//规则类型
            'source' => 3,//来源类型
            'content' => array(//规则
                'om' => '68',//可使用的订单金额
                'm' => '10',//面额
            ),
            'valid_type' => 'delay',//有效期类型，delay延期(已获得的时间为开始时间)
            'valid_end' => 30,//valid_type为delay时，此值为延期天数
        ),
        '1-20' => array(//规则类型-面额
            'type' => 1,//规则类型
            'source' => 3,//来源类型
            'content' => array(//规则
                'om' => '128',//可使用的订单金额
                'm' => '20',//面额
            ),
            'valid_type' => 'delay',//有效期类型，delay延期(已获得的时间为开始时间)
            'valid_end' => 30,//valid_type为delay时，此值为延期天数
        ),
        '1-50' => array(//规则类型-面额
            'type' => 1,//规则类型
            'source' => 3,//来源类型
            'content' => array(//规则
                'om' => '268',//可使用的订单金额
                'm' => '50',//面额
            ),
            'valid_type' => 'delay',//有效期类型，delay延期(已获得的时间为开始时间)
            'valid_end' => 30,//valid_type为delay时，此值为延期天数
        ),
    ),
    'interaction' => array(//互动
        '1-10' => array(//规则类型-面额
            'type' => 1,//规则类型
            'source' => 4,//来源类型
            'content' => array(//规则
                'om' => '68',//可使用的订单金额
                'm' => '10',//面额
            ),
            'valid_type' => 'delay',//有效期类型，delay延期(已获得的时间为开始时间)
            'valid_end' => 30,//valid_type为delay时，此值为延期天数
        ),
        '1-20' => array(//规则类型-面额
            'type' => 1,//规则类型
            'source' => 4,//来源类型
            'content' => array(//规则
                'om' => '128',//可使用的订单金额
                'm' => '20',//面额
            ),
            'valid_type' => 'delay',//有效期类型，delay延期(已获得的时间为开始时间)
            'valid_end' => 30,//valid_type为delay时，此值为延期天数
        ),
        '1-50' => array(//规则类型-面额
            'type' => 1,//规则类型
            'source' => 4,//来源类型
            'content' => array(//规则
                'om' => '268',//可使用的订单金额
                'm' => '50',//面额
            ),
            'valid_type' => 'delay',//有效期类型，delay延期(已获得的时间为开始时间)
            'valid_end' => 30,//valid_type为delay时，此值为延期天数
        ),
    ),
);