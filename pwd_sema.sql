CREATE TABLE IF NOT EXISTS `members` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `uye_no` int(10) unsigned default NULL,
  `name` varchar(30) collate utf8_turkish_ci default NULL,
  `lastname` varchar(30) collate utf8_turkish_ci default NULL,
  `lotr_alias` varchar(65) collate utf8_turkish_ci default NULL,
  `password` varchar(32) collate utf8_turkish_ci default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `members_unique1` (`uye_no`),
  KEY `members_unique2` (`lotr_alias`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci ;
