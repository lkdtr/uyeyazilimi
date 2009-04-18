-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Anamakine: localhost
-- Üretim Zamanı: 18 Nisan 2009 saat 10:35:18
-- Sunucu sürümü: 5.1.30
-- PHP Sürümü: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Veritabanı: `betauye`
--

-- --------------------------------------------------------

--
-- Tablo yapısı: `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) unsigned NOT NULL,
  `lotr_alias` varchar(65) COLLATE utf8_turkish_ci DEFAULT NULL,
  `password` char(32) COLLATE utf8_turkish_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `accounts_FKIndex1` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo yapısı: `leave_details`
--

CREATE TABLE IF NOT EXISTS `leave_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) unsigned NOT NULL,
  `leave_year` year(4) NOT NULL,
  `leave_decision_date` date NOT NULL,
  `leave_decision_number` int(10) unsigned NOT NULL,
  `note` text COLLATE utf8_turkish_ci,
  PRIMARY KEY (`id`),
  KEY `Table_10_FKIndex1` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo yapısı: `maillists`
--

CREATE TABLE IF NOT EXISTS `maillists` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `maillist_name` varchar(200) COLLATE utf8_turkish_ci DEFAULT NULL,
  `maillist_address` varchar(200) COLLATE utf8_turkish_ci DEFAULT NULL,
  `maillist_description` text COLLATE utf8_turkish_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo yapısı: `maillists_members`
--

CREATE TABLE IF NOT EXISTS `maillists_members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) unsigned NOT NULL,
  `list_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lists_members_FKIndex1` (`list_id`),
  KEY `lists_members_FKIndex2` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo yapısı: `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uye_no` int(10) unsigned DEFAULT NULL,
  `tckimlikno` char(11) COLLATE utf8_turkish_ci DEFAULT NULL,
  `name` varchar(30) COLLATE utf8_turkish_ci DEFAULT NULL,
  `lastname` varchar(30) COLLATE utf8_turkish_ci DEFAULT NULL,
  `gender` char(1) COLLATE utf8_turkish_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `member_type` enum('member','treasurer','board_member') COLLATE utf8_turkish_ci DEFAULT NULL,
  `member_card_status` enum('Ýstemiyor','Ýstiyor','Güncel Adres Bekleniyor','Dijital Fotoðraf Bekleniyor','Basýlacak','Baskýya Gitti','Postaya Verilecek') COLLATE utf8_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `members_unique1` (`uye_no`),
  KEY `members_unique2` (`tckimlikno`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo yapısı: `membership_fees`
--

CREATE TABLE IF NOT EXISTS `membership_fees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fee_year` year(4) DEFAULT NULL,
  `yearly_fee_amount` float DEFAULT NULL,
  `enterence_fee` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo yapısı: `password_confirmations`
--

CREATE TABLE IF NOT EXISTS `password_confirmations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL,
  `hash` char(32) COLLATE utf8_turkish_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `password_confirmations_FKIndex1` (`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo yapısı: `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) unsigned NOT NULL,
  `amount` float DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_method` enum('elden','havale','kredi_karti','bilinmiyor') COLLATE utf8_turkish_ci DEFAULT NULL,
  `receipt_number` varchar(15) COLLATE utf8_turkish_ci DEFAULT NULL,
  `note` text COLLATE utf8_turkish_ci,
  PRIMARY KEY (`id`),
  KEY `payments_FKIndex1` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo yapısı: `personal_information`
--

CREATE TABLE IF NOT EXISTS `personal_information` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) unsigned NOT NULL,
  `email` varchar(30) COLLATE utf8_turkish_ci DEFAULT NULL,
  `email_2` varchar(30) COLLATE utf8_turkish_ci DEFAULT NULL,
  `lotr_fwd_email` varchar(30) COLLATE utf8_turkish_ci DEFAULT NULL,
  `address` varchar(200) COLLATE utf8_turkish_ci DEFAULT NULL,
  `city` varchar(60) COLLATE utf8_turkish_ci DEFAULT NULL,
  `country` varchar(60) COLLATE utf8_turkish_ci DEFAULT 'Türkiye',
  `home_number` varchar(25) COLLATE utf8_turkish_ci DEFAULT NULL,
  `mobile_number` varchar(25) COLLATE utf8_turkish_ci DEFAULT NULL,
  `work_number` varchar(25) COLLATE utf8_turkish_ci DEFAULT NULL,
  `current_school_company` varchar(60) COLLATE utf8_turkish_ci DEFAULT NULL,
  `latest_school_graduated` varchar(60) COLLATE utf8_turkish_ci DEFAULT NULL,
  `latest_year_graduated` year(4) DEFAULT NULL,
  `job_assignment` varchar(60) COLLATE utf8_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_information_FKIndex1` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo yapısı: `preferences`
--

CREATE TABLE IF NOT EXISTS `preferences` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `preferences_FKIndex1` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo yapısı: `registration_details`
--

CREATE TABLE IF NOT EXISTS `registration_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) unsigned NOT NULL,
  `registration_year` year(4) DEFAULT NULL,
  `registration_decision_number` int(10) unsigned DEFAULT NULL,
  `registration_decision_date` date DEFAULT NULL,
  `photos_for_documents` tinyint(1) DEFAULT NULL,
  `registration_form` tinyint(1) DEFAULT NULL,
  `note` text COLLATE utf8_turkish_ci,
  PRIMARY KEY (`id`),
  KEY `membership_information_FKIndex1` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;
