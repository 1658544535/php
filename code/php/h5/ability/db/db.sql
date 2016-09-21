/**
 * 微信用户表
 * 2016-08-05 16:49:27
 * Will
 */
CREATE TABLE `h5_ability_wxuser`(
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
    `openid` VARCHAR(64) NOT NULL DEFAULT '' COMMENT '微信openid',
    `nickname` VARCHAR(80) NOT NULL DEFAULT '' COMMENT '昵称',
    `sex` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '性别，0未知1男2女',
    `country` VARCHAR(30) NOT NULL DEFAULT '' COMMENT '国家',
    `province` VARCHAR(80) NOT NULL DEFAULT '' COMMENT '省份',
    `city` VARCHAR(80) NOT NULL DEFAULT '' COMMENT '城市',
    `headimgurl` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '头像',
    `privilege` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '用户特权信息，json 数组，如微信沃卡用户为（chinaunicom）',
    `unionid` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '只有在用户将公众号绑定到微信开放平台帐号后，才会出现该字段',
    PRIMARY KEY (`id`),
    KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信用户表';

/**
 * 用户参与记录表
 * 2016-08-05 17:05:01
 * Will
 */
CREATE TABLE `h5_ability_partin`(
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
    `user_id` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '参与用户id',
    `age_index` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '年龄范围索引',
    `time` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '参与时间',
    `goods_click_num` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '商品点击数量',
    PRIMARY KEY (`id`),
    KEY `user` (`user_id`),
    KEY `age` (`age_index`),
    KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户参与记录表';

/**
 * 用户参与选择项表
 * 2016-08-08 10:31:29
 * Will
 */
CREATE TABLE `h5_ability_partitem`(
    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
    `partin_id` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '参与记录id',
    `field_index` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '领域索引',
    `item_index` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '指标索引',
    `score` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分值',
    PRIMARY KEY (`id`),
    KEY `partin_id` (`partin_id`),
    KEY `field` (`field_index`),
    KEY `item` (`item_index`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户参与选择项表';

/**
 * 商品点击统计表
 * 2016-08-09 14:52:48
 * Will
 */
CREATE TABLE `h5_ability_goods_click`(
    `user_id` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id',
    `partin_id` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '参与记录id',
    `goods_id` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '商品id',
    `time` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '点击时间',
    KEY `user` (`user_id`),
    KEY `partin` (`partin_id`),
    KEY `goods` (`goods_id`),
    KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品点击统计表';

/**
 * 用户操作状态表
 * 2016-08-09 13:22:39
 * Will
 */
CREATE TABLE `h5_ability_opstatus`(
    `user_id` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id',
    `restart` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '重新开始测试，0否1是',
    PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户操作状态表';