CREATE TABLE `tmall` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) NOT NULL DEFAULT '0' COMMENT '对应b2c的产品id',
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '天猫链接地址',
  `price` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '产品价格',
  `addtime` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY pid(`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='链接记录表';


CREATE TABLE `tmall_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `pid` bigint(20) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `b_price` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'b2c商品价格',
  `t_price` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '天猫商品价格',
  `old_b_price` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'b2c商品原价',
  `old_t_price` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '天猫商品原价',
  `addtime` datetime DEFAULT NULL COMMENT '添加时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：0为正常，1为差别',
  PRIMARY KEY (`id`),
  KEY pid(`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='对比结果记录表';


/* =============新增字段============= */
ALTER TABLE `tmall` ADD COLUMN `visit` tinyint(1) DEFAULT '0' COMMENT '标识';




