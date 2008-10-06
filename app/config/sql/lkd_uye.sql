-- phpMyAdmin SQL Dump
-- version 2.11.7
-- http://www.phpmyadmin.net
--
-- Anamakine: localhost
-- Üretim Zamanı: 07 Ekim 2008 saat 02:02:07
-- Sunucu sürümü: 5.0.51
-- PHP Sürümü: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Veritabanı: `lkd_uye`
--

-- --------------------------------------------------------

--
-- Tablo yapısı: `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `uye_no` int(10) unsigned default NULL,
  `tckimlikno` char(11) collate utf8_turkish_ci default NULL,
  `name` varchar(30) collate utf8_turkish_ci default NULL,
  `lastname` varchar(30) collate utf8_turkish_ci default NULL,
  `gender` char(1) collate utf8_turkish_ci default NULL,
  `date_of_birth` date default NULL,
  `lotr_alias` varchar(65) collate utf8_turkish_ci default NULL,
  `password` char(32) collate utf8_turkish_ci default NULL,
  `member_type` enum('member','treasurer','board_member') collate utf8_turkish_ci default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `members_unique1` (`uye_no`),
  KEY `members_unique2` (`tckimlikno`),
  KEY `members_unique3` (`lotr_alias`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo yapısı: `password_confirmations`
--

CREATE TABLE IF NOT EXISTS `password_confirmations` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `member_id` int(10) unsigned NOT NULL,
  `hash` char(32) collate utf8_turkish_ci default NULL,
  `created` timestamp NULL default NULL,
  PRIMARY KEY  (`id`),
  KEY `password_confirmations_FKIndex1` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo yapısı: `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `member_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `payments_FKIndex1` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo yapısı: `personal_informations`
--

CREATE TABLE IF NOT EXISTS `personal_informations` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `member_id` int(10) unsigned NOT NULL,
  `email` varchar(30) collate utf8_turkish_ci default NULL,
  `email_2` varchar(30) collate utf8_turkish_ci default NULL,
  `address` varchar(200) collate utf8_turkish_ci default NULL,
  `city` varchar(60) collate utf8_turkish_ci default NULL,
  `country` varchar(60) collate utf8_turkish_ci default 'Türkiye',
  `home_number` varchar(25) collate utf8_turkish_ci default NULL,
  `mobile_number` varchar(25) collate utf8_turkish_ci default NULL,
  `work_number` varchar(25) collate utf8_turkish_ci default NULL,
  `current_school_company` varchar(60) collate utf8_turkish_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `contact_information_FKIndex1` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo yapısı: `preferences`
--

CREATE TABLE IF NOT EXISTS `preferences` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `member_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `preferences_FKIndex1` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo yapısı: `registration_informations`
--

CREATE TABLE IF NOT EXISTS `registration_informations` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `member_id` int(10) unsigned NOT NULL,
  `registration_year` year(4) default NULL,
  `registration_decision_number` int(10) unsigned default NULL,
  `registration_decision_date` date default NULL,
  `photos_for_documents` tinyint(1) default NULL,
  `registration_form` tinyint(1) default NULL,
  `notes` text collate utf8_turkish_ci,
  PRIMARY KEY  (`id`),
  KEY `membership_information_FKIndex1` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;
