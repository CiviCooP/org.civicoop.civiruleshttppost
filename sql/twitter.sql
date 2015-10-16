CREATE TABLE `civirule_twitter_action` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary key ID',
  `description` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Description of twitter account',
  `twitter_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Twitter name',
  `consumer_key` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Consumer key',
  `consumer_secret` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Consumer secret',
  `access_token` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Access token',
  `access_secret` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Access secret',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci