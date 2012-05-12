CREATE TABLE `ew_oauth_token` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sns` varchar(64) NOT NULL DEFAULT '',
  `sns_user_id` varchar(64) NOT NULL DEFAULT '',
  `access_token` varchar(128) NOT NULL DEFAULT '',
  `secret_token` varchar(128) NOT NULL DEFAULT '',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `ew_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(16) NOT NULL DEFAULT '',
  `username` varchar(100) NOT NULL DEFAULT '',
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `ew_user_oauth_token` (
  `user_id` int(11) unsigned NOT NULL,
  `oauth_token_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`oauth_token_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `ew_user_profile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sex` char(1) NOT NULL DEFAULT 'm',
  `birth` int(11) unsigned NOT NULL,
  `country` varchar(50) NOT NULL DEFAULT '',
  `city` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(20) NOT NULL DEFAULT '',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;