CREATE TABLE IF NOT EXISTS `members` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `uye_no` int(10) unsigned default NULL,
  `name` varchar(30) collate utf8_turkish_ci default NULL,
  `lastname` varchar(30) collate utf8_turkish_ci default NULL,
  `lotr_alias` varchar(65) collate utf8_turkish_ci default NULL,
  `password` varchar(32) collate utf8_turkish_ci default NULL,
  `email` varchar(78) collate utf8_turkish_ci default NULL,
  `privilege` tinyint(3) unsigned default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `members_unique1` (`uye_no`),
  KEY `members_unique3` (`lotr_alias`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci ;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `password_confirmations` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `member_id` int(10) unsigned NOT NULL default '0',
  `hash` char(32) collate utf8_turkish_ci default NULL,
  `created` timestamp NULL default NULL,
  PRIMARY KEY  (`id`),
  KEY `password_confirmations_FKIndex1` (`member_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci ;
