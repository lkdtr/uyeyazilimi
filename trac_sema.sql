
-- --------------------------------------------------------

--
-- Table structure for table `attachment`
--

CREATE TABLE IF NOT EXISTS `attachment` (
  `type` text NOT NULL,
  `id` text NOT NULL,
  `filename` text NOT NULL,
  `size` int(11) default NULL,
  `time` int(11) default NULL,
  `description` text,
  `author` text,
  `ipnr` text,
  PRIMARY KEY  (`type`(111),`id`(111),`filename`(111))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_cookie`
--

CREATE TABLE IF NOT EXISTS `auth_cookie` (
  `cookie` text NOT NULL,
  `name` text NOT NULL,
  `ipnr` text NOT NULL,
  `time` int(11) default NULL,
  PRIMARY KEY  (`cookie`(111),`ipnr`(111),`name`(111))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `component`
--

CREATE TABLE IF NOT EXISTS `component` (
  `name` text NOT NULL,
  `owner` text,
  `description` text,
  PRIMARY KEY  (`name`(255))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `enum`
--

CREATE TABLE IF NOT EXISTS `enum` (
  `type` text NOT NULL,
  `name` text NOT NULL,
  `value` text,
  PRIMARY KEY  (`type`(166),`name`(166))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `milestone`
--

CREATE TABLE IF NOT EXISTS `milestone` (
  `name` text NOT NULL,
  `due` int(11) default NULL,
  `completed` int(11) default NULL,
  `description` text,
  PRIMARY KEY  (`name`(255))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `node_change`
--

CREATE TABLE IF NOT EXISTS `node_change` (
  `rev` text NOT NULL,
  `path` text NOT NULL,
  `node_type` text,
  `change_type` text NOT NULL,
  `base_path` text,
  `base_rev` text,
  PRIMARY KEY  (`rev`(20),`path`(255),`change_type`(2)),
  KEY `node_change_rev_idx` (`rev`(20))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `username` text NOT NULL,
  `action` text NOT NULL,
  PRIMARY KEY  (`username`(166),`action`(166))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE IF NOT EXISTS `report` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `author` text,
  `title` text,
  `query` text,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `revision`
--

CREATE TABLE IF NOT EXISTS `revision` (
  `rev` text NOT NULL,
  `time` int(11) default NULL,
  `author` text,
  `message` text,
  PRIMARY KEY  (`rev`(20)),
  KEY `revision_time_idx` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE IF NOT EXISTS `session` (
  `sid` text NOT NULL,
  `authenticated` int(11) NOT NULL default '0',
  `last_visit` int(11) default NULL,
  PRIMARY KEY  (`sid`(166),`authenticated`),
  KEY `session_last_visit_idx` (`last_visit`),
  KEY `session_authenticated_idx` (`authenticated`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `session_attribute`
--

CREATE TABLE IF NOT EXISTS `session_attribute` (
  `sid` text NOT NULL,
  `authenticated` int(11) NOT NULL default '0',
  `name` text NOT NULL,
  `value` text,
  PRIMARY KEY  (`sid`(111),`authenticated`,`name`(111))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `system`
--

CREATE TABLE IF NOT EXISTS `system` (
  `name` text NOT NULL,
  `value` text,
  PRIMARY KEY  (`name`(255))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE IF NOT EXISTS `ticket` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type` text,
  `time` int(11) default NULL,
  `changetime` int(11) default NULL,
  `component` text,
  `severity` text,
  `priority` text,
  `owner` text,
  `reporter` text,
  `cc` text,
  `version` text,
  `milestone` text,
  `status` text,
  `resolution` text,
  `summary` text,
  `description` text,
  `keywords` text,
  PRIMARY KEY  (`id`),
  KEY `ticket_time_idx` (`time`),
  KEY `ticket_status_idx` (`status`(255))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=115 ;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_change`
--

CREATE TABLE IF NOT EXISTS `ticket_change` (
  `ticket` int(11) NOT NULL default '0',
  `time` int(11) NOT NULL default '0',
  `author` text,
  `field` text NOT NULL,
  `oldvalue` text,
  `newvalue` text,
  PRIMARY KEY  (`ticket`,`time`,`field`(111)),
  KEY `ticket_change_ticket_idx` (`ticket`),
  KEY `ticket_change_time_idx` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_custom`
--

CREATE TABLE IF NOT EXISTS `ticket_custom` (
  `ticket` int(11) NOT NULL default '0',
  `name` text NOT NULL,
  `value` text,
  PRIMARY KEY  (`ticket`,`name`(166))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `version`
--

CREATE TABLE IF NOT EXISTS `version` (
  `name` text NOT NULL,
  `time` int(11) default NULL,
  `description` text,
  PRIMARY KEY  (`name`(255))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wiki`
--

CREATE TABLE IF NOT EXISTS `wiki` (
  `name` text NOT NULL,
  `version` int(11) NOT NULL default '0',
  `time` int(11) default NULL,
  `author` text,
  `ipnr` text,
  `text` text,
  `comment` text,
  `readonly` int(11) default NULL,
  PRIMARY KEY  (`name`(166),`version`),
  KEY `wiki_time_idx` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
