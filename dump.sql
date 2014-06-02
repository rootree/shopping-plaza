# ************************************************************
# Shopping-plaza.ru SQL dump
#
# Database: magaz
# Generation Time: 2014-05-15 14:19:43 +0000
# ************************************************************

SET NAMES 'utf8';
SET CHARACTER SET utf8;

# Dump of table blocked_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `blocked_users`;

CREATE TABLE `blocked_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(300) DEFAULT NULL,
  `ip` varchar(50) DEFAULT NULL,
  `agent` varchar(300) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `moder_id` int(11) DEFAULT NULL,
  `firm_id` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index` (`email`(255)),
  KEY `index2` (`agent`(255),`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table cats
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cats`;

CREATE TABLE `cats` (
  `cat_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `firm_id` smallint(5) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `sort` smallint(5) unsigned NOT NULL,
  `url_link` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `desc` text,
  `relatedId` int(11) DEFAULT NULL,
  PRIMARY KEY (`cat_id`),
  KEY `FK_cats` (`firm_id`),
  KEY `index1` (`url_link`,`firm_id`,`status`),
  KEY `index2` (`cat_id`,`status`),
  KEY `index3` (`firm_id`,`status`,`sort`,`title`),
  KEY `index4` (`firm_id`,`status`),
  KEY `index5` (`firm_id`,`sort`),
  CONSTRAINT `FK_cats` FOREIGN KEY (`firm_id`) REFERENCES `firms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table catssub
# ------------------------------------------------------------

DROP TABLE IF EXISTS `catssub`;

CREATE TABLE `catssub` (
  `catsub_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` smallint(5) unsigned NOT NULL,
  `firm_id` smallint(5) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `sort` smallint(5) unsigned NOT NULL,
  `url_link` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `desc` text,
  `relatedId` int(11) DEFAULT NULL,
  PRIMARY KEY (`catsub_id`),
  KEY `FK_catssub` (`firm_id`),
  KEY `index1` (`url_link`,`firm_id`,`status`),
  KEY `index2` (`catsub_id`,`status`),
  KEY `index3` (`firm_id`,`status`,`sort`,`title`),
  KEY `index4` (`firm_id`,`status`),
  KEY `index5` (`cat_id`,`firm_id`),
  KEY `index6` (`firm_id`,`sort`),
  CONSTRAINT `FK_catssub` FOREIGN KEY (`firm_id`) REFERENCES `firms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table comment_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `comment_items`;

CREATE TABLE `comment_items` (
  `coment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `coment_type` tinyint(4) NOT NULL,
  `content` text,
  `firm_id` smallint(5) unsigned DEFAULT NULL,
  `item_id` smallint(5) unsigned DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `name` varbinary(150) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `mail` varchar(150) DEFAULT NULL,
  `agent` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`coment_id`),
  KEY `index1` (`coment_type`,`item_id`,`firm_id`,`status`),
  KEY `index2` (`firm_id`,`status`,`coment_type`),
  KEY `index3` (`coment_id`,`firm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text,
  `firm_id` int(10) unsigned NOT NULL,
  `moder_id` int(10) unsigned NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `order_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table delivery
# ------------------------------------------------------------

DROP TABLE IF EXISTS `delivery`;

CREATE TABLE `delivery` (
  `del_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(500) DEFAULT NULL,
  `firm_id` smallint(5) unsigned NOT NULL,
  `sort` smallint(5) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `conditions` text,
  `cost` float unsigned DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`del_id`),
  KEY `index1` (`cost`,`type`,`firm_id`,`status`),
  KEY `index2` (`firm_id`,`del_id`,`status`),
  KEY `index3` (`sort`),
  KEY `index4` (`del_id`,`firm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table feedback
# ------------------------------------------------------------

DROP TABLE IF EXISTS `feedback`;

CREATE TABLE `feedback` (
  `fb_id` int(11) NOT NULL AUTO_INCREMENT,
  `fb_date` datetime DEFAULT NULL,
  `fb_questing` text,
  `fb_ansver` text,
  `fb_ansver_date` datetime DEFAULT NULL,
  `fb_title` varchar(255) DEFAULT NULL,
  `fb_name` varchar(255) DEFAULT NULL,
  `fb_email` varchar(255) DEFAULT NULL,
  `fb_ip` varchar(255) DEFAULT NULL,
  `firm_id` smallint(5) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `moder_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`fb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 


# Dump of table feedback_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `feedback_history`;

CREATE TABLE `feedback_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `moder_id` smallint(5) unsigned NOT NULL,
  `fb_id` int(10) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table fields
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fields`;

CREATE TABLE `fields` (
  `field_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(266) NOT NULL,
  `sort` smallint(5) unsigned NOT NULL,
  `firm_id` smallint(5) unsigned NOT NULL,
  `catsub_id` smallint(5) unsigned NOT NULL,
  `excel` tinyint(1) unsigned DEFAULT '0',
  `relatedTitle` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`field_id`),
  KEY `index1` (`catsub_id`,`firm_id`),
  KEY `index2` (`catsub_id`,`firm_id`,`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table firms
# ------------------------------------------------------------

DROP TABLE IF EXISTS `firms`;

CREATE TABLE `firms` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `domain` varchar(50) DEFAULT NULL,
  `cat` smallint(5) unsigned NOT NULL,
  `city` varchar(100) NOT NULL,
  `skype` varchar(100) DEFAULT NULL,
  `mail` varchar(300) DEFAULT NULL,
  `icq` varchar(100) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `fax` varchar(100) DEFAULT NULL,
  `tele` varchar(300) DEFAULT NULL,
  `worktime` varchar(100) DEFAULT NULL,
  `mainpage` text,
  `shownews` tinyint(1) unsigned NOT NULL,
  `showfirstpro` tinyint(1) unsigned NOT NULL,
  `new_orders` smallint(5) unsigned NOT NULL,
  `new_feedback` smallint(5) unsigned NOT NULL,
  `welcomepage` tinyint(1) unsigned NOT NULL,
  `showcatalog` tinyint(1) unsigned NOT NULL,
  `show` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `meta` varchar(400) DEFAULT NULL,
  `mailo` varchar(100) DEFAULT NULL,
  `title_firm` varchar(255) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `template` varchar(50) NOT NULL,
  `urik` text,
  `code_inside` text,
  `prices` text,
  `mail_inside` text,
  `sms_title` varchar(11) DEFAULT NULL,
  `sms_settings` smallint(6) DEFAULT '0',
  `sms_number` varchar(11) DEFAULT NULL,
  `comment_settings` tinyint(4) DEFAULT '0',
  `sales` tinyint(1) unsigned DEFAULT '1',
  `enabled` tinyint(1) unsigned DEFAULT '1',
  `createDate` datetime NOT NULL,
  `meta_name` varchar(100) DEFAULT NULL,
  `meta_text` varchar(300) DEFAULT NULL,
  `main_phone` varchar(600) DEFAULT NULL,
  `YML` varchar(300) DEFAULT NULL,
  `YMLenabled` tinyint(1) DEFAULT '0',
  `YMLprogress` tinyint(4) DEFAULT '0',
  `descFirm` text,
  `api_key` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index` (`domain`),
  KEY `index1` (`api_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table images
# ------------------------------------------------------------

DROP TABLE IF EXISTS `images`;

CREATE TABLE `images` (
  `img_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) unsigned NOT NULL,
  `for_item` smallint(5) unsigned NOT NULL,
  `img_size` int(10) unsigned NOT NULL,
  `firm_id` smallint(5) unsigned NOT NULL,
  `img_hash` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`img_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table moders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `moders`;

CREATE TABLE `moders` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_mail` varchar(250) DEFAULT NULL,
  `user_right` smallint(1) DEFAULT NULL,
  `user_word` varchar(32) DEFAULT NULL,
  `user_name` varchar(60) DEFAULT NULL,
  `firm_id` smallint(5) unsigned NOT NULL,
  `confirmed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `confirmed_code` varchar(32) NOT NULL DEFAULT '0',
  `user_status` tinyint(1) unsigned NOT NULL,
  `user_mail_new` varchar(250) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `index1` (`confirmed_code`),
  KEY `index2` (`firm_id`,`user_status`),
  KEY `index3` (`user_id`,`firm_id`),
  KEY `index4` (`user_status`,`user_mail`,`firm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table news
# ------------------------------------------------------------

DROP TABLE IF EXISTS `news`;

CREATE TABLE `news` (
  `news_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `annonce` text NOT NULL,
  `content` text,
  `firm_id` smallint(5) unsigned NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `url_link` varchar(255) NOT NULL,
  PRIMARY KEY (`news_id`),
  KEY `index1` (`firm_id`),
  KEY `index2` (`firm_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table order
# ------------------------------------------------------------

DROP TABLE IF EXISTS `order`;

CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `total` float DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `firm_id` smallint(5) unsigned NOT NULL,
  `devivery` tinyint(3) unsigned NOT NULL,
  `payment` tinyint(3) unsigned NOT NULL,
  `moder_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `paymentInfo` text,
  `deliveryInfo` text,
  `user_mail` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index1` (`firm_id`,`user_mail`),
  KEY `index2` (`id`,`firm_id`,`user_mail`),
  KEY `index3` (`payment`),
  KEY `index4` (`devivery`),
  KEY `index5` (`firm_id`,`status`,`date`),
  KEY `index6` (`id`,`firm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 


# Dump of table order_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `order_history`;

CREATE TABLE `order_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `moder_id` smallint(5) unsigned NOT NULL,
  `order_id` int(10) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table order_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `order_items`;

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `it_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index1` (`it_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table pages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `page_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `firm_id` smallint(5) unsigned NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `url_link` varchar(255) NOT NULL,
  `sort` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`page_id`),
  KEY `index1` (`page_id`,`firm_id`),
  KEY `index` (`url_link`,`firm_id`),
  KEY `index2` (`firm_id`),
  KEY `index3` (`firm_id`,`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table partners
# ------------------------------------------------------------

DROP TABLE IF EXISTS `partners`;

CREATE TABLE `partners` (
  `partner_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `annonce` text NOT NULL,
  `firm_id` smallint(5) unsigned NOT NULL,
  `tel` varchar(300) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `fax` varchar(300) DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `www` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`partner_id`),
  KEY `index` (`firm_id`),
  KEY `index2` (`partner_id`,`firm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table pay_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pay_type`;

CREATE TABLE `pay_type` (
  `pay_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(500) DEFAULT NULL,
  `firm_id` smallint(5) unsigned NOT NULL,
  `sort` smallint(5) unsigned NOT NULL,
  `client_type` tinyint(3) unsigned NOT NULL,
  `field_type` tinyint(3) unsigned NOT NULL,
  `conditions` text,
  `delivery` smallint(5) unsigned NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`pay_id`),
  KEY `NewIndex1` (`delivery`),
  KEY `index1` (`firm_id`,`delivery`,`status`),
  KEY `index2` (`firm_id`,`pay_id`,`status`),
  KEY `index3` (`pay_id`,`firm_id`),
  CONSTRAINT `FK_pay_type` FOREIGN KEY (`delivery`) REFERENCES `delivery` (`del_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table product_cost
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product_cost`;

CREATE TABLE `product_cost` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `moder_id` smallint(5) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `coster` float unsigned NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table product_fields
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product_fields`;

CREATE TABLE `product_fields` (
  `product_id` smallint(5) unsigned NOT NULL,
  `field_id` smallint(5) unsigned NOT NULL,
  `field_value` text,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `NewIndex1` (`product_id`,`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table product_imgs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product_imgs`;

CREATE TABLE `product_imgs` (
  `product_id` smallint(5) unsigned NOT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `img_size` int(10) unsigned NOT NULL,
  `firm_id` smallint(5) unsigned NOT NULL,
  `favorite` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `img_hash` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index1` (`product_id`,`firm_id`),
  KEY `index` (`product_id`,`favorite`),
  KEY `index2` (`product_id`,`favorite`,`firm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table product_link
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product_link`;

CREATE TABLE `product_link` (
  `link_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `link` varchar(300) DEFAULT NULL,
  `firm_id` int(10) unsigned NOT NULL,
  `create_date` datetime DEFAULT NULL,
  PRIMARY KEY (`link_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table products
# ------------------------------------------------------------

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `product_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(300) DEFAULT NULL,
  `price` float unsigned NOT NULL,
  `cat_id` smallint(5) unsigned NOT NULL,
  `catsub_id` smallint(5) unsigned NOT NULL,
  `firm_id` smallint(5) unsigned NOT NULL,
  `desc` text,
  `discount` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `new` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `week` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `unic` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `counter` smallint(5) NOT NULL DEFAULT '1',
  `metric` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `viewed` smallint(5) unsigned NOT NULL DEFAULT '0',
  `weight` float unsigned NOT NULL DEFAULT '0',
  `desc_mini` text,
  `moder_id` int(10) unsigned NOT NULL DEFAULT '0',
  `url_link` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `arcitule` varchar(30) DEFAULT NULL,
  `price1` float unsigned DEFAULT '0',
  `price2` float unsigned DEFAULT '0',
  `price3` float unsigned DEFAULT '0',
  `price4` float unsigned DEFAULT '0',
  `price5` float unsigned DEFAULT '0',
  `searchingId` int(11) DEFAULT NULL,
  `source` tinyint(1) DEFAULT '0',
  `replace` varchar(300) DEFAULT NULL,
  `replace_to` varchar(300) DEFAULT NULL,
  `robot_updated` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `NewIndex1` (`firm_id`,`arcitule`),
  KEY `FK_products` (`firm_id`),
  KEY `catalog` (`firm_id`,`status`),
  KEY `catalog2` (`firm_id`,`status`,`counter`,`title`(255)),
  KEY `per_page` (`cat_id`,`firm_id`,`status`),
  KEY `index2` (`product_id`,`firm_id`,`status`),
  KEY `index3` (`url_link`,`firm_id`,`status`),
  KEY `index4` (`cat_id`,`firm_id`,`status`,`catsub_id`),
  KEY `index5` (`firm_id`,`cat_id`,`catsub_id`,`product_id`),
  KEY `index6` (`searchingId`,`firm_id`),
  KEY `index7` (`product_id`,`firm_id`),
  KEY `index8` (`source`,`status`,`firm_id`,`product_id`),
  CONSTRAINT `FK_products` FOREIGN KEY (`firm_id`) REFERENCES `firms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 

DROP TABLE IF EXISTS `recommends`;

CREATE TABLE `recommends` (
  `recommend_product` int(10) unsigned NOT NULL,
  `product` int(10) unsigned NOT NULL,
  `firm_id` int(10) unsigned NOT NULL,
  KEY `index` (`product`,`firm_id`),
  KEY `recommend_product` (`recommend_product`,`product`,`firm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table referers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `referers`;

CREATE TABLE `referers` (
  `firm_id` int(10) unsigned NOT NULL,
  `referer` varchar(150) NOT NULL,
  `counter` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`firm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table responce
# ------------------------------------------------------------

DROP TABLE IF EXISTS `responce`;

CREATE TABLE `responce` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firm_id` smallint(5) unsigned NOT NULL,
  `moderId` smallint(5) unsigned NOT NULL,
  `annonce` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(3) unsigned NOT NULL,
  `typer` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table satellites
# ------------------------------------------------------------

DROP TABLE IF EXISTS `satellites`;

CREATE TABLE `satellites` (
  `satellite_product` int(10) unsigned NOT NULL,
  `product` int(10) unsigned NOT NULL,
  `firm_id` int(10) unsigned NOT NULL,
  KEY `index` (`product`,`firm_id`),
  KEY `index1` (`satellite_product`,`product`,`firm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table searchinger
# ------------------------------------------------------------

DROP TABLE IF EXISTS `searchinger`;

CREATE TABLE `searchinger` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firm_id` smallint(5) unsigned NOT NULL,
  `request` varchar(266) NOT NULL,
  `dat` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table shop_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shop_users`;

CREATE TABLE `shop_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_mail` varchar(250) DEFAULT NULL,
  `user_word` varchar(32) DEFAULT NULL,
  `user_name` varchar(60) DEFAULT NULL,
  `firm_id` smallint(5) unsigned NOT NULL,
  `confirmed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `confirmed_code` varchar(32) NOT NULL DEFAULT '0',
  `user_mail_new` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `index1` (`user_mail`,`user_word`),
  KEY `index2` (`user_mail`),
  KEY `index3` (`user_id`,`firm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sms_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sms_history`;

CREATE TABLE `sms_history` (
  `toNumber` varchar(15) DEFAULT NULL,
  `content` varchar(250) DEFAULT NULL,
  `firm_id` smallint(5) unsigned DEFAULT NULL,
  `code` smallint(5) unsigned DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table users_phone
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users_phone`;

CREATE TABLE `users_phone` (
  `phone` varchar(300) DEFAULT NULL,
  `firm_id` int(10) unsigned NOT NULL,
  `date` datetime DEFAULT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index1` (`firm_id`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table vacancy
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vacancy`;

CREATE TABLE `vacancy` (
  `vacancy_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `responsibilities` text NOT NULL,
  `requirements` text,
  `conditions` text,
  `employment_type` tinyint(3) unsigned NOT NULL,
  `wage_level` float NOT NULL,
  `experience_required` tinyint(3) unsigned NOT NULL,
  `firm_id` smallint(5) unsigned NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `tel` varchar(100) DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`vacancy_id`),
  KEY `index1` (`firm_id`),
  KEY `index2` (`vacancy_id`,`firm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 
