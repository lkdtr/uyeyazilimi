
-- --------------------------------------------------------

--
-- Tablo yapısı: `aidat_miktar`
--

CREATE TABLE IF NOT EXISTS `aidat_miktar` (
  `aidat_id` int(3) NOT NULL auto_increment,
  `yil` int(4) NOT NULL default '0',
  `miktar` int(10) NOT NULL default '0',
  PRIMARY KEY  (`aidat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo yapısı: `odemeler`
--

CREATE TABLE IF NOT EXISTS `odemeler` (
  `uye_id` int(7) NOT NULL default '0',
  `miktar` int(10) NOT NULL default '0',
  `tarih` date NOT NULL default '0000-00-00',
  `tur` enum('aidat','bagis','diger') NOT NULL default 'aidat',
  `id` int(11) NOT NULL auto_increment,
  `notlar` text,
  `odemeyolu` varchar(255) NOT NULL default '',
  `makbuz` varchar(255) default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo yapısı: `uyeler`
--

CREATE TABLE IF NOT EXISTS `uyeler` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `uye_id` int(7) unsigned NOT NULL default '0',
  `uye_ad` varchar(99) NOT NULL default '',
  `uye_soyad` varchar(99) NOT NULL default '',
  `eposta1` varchar(255) NOT NULL default '',
  `eposta2` varchar(255) default '',
  `kayit_tarihi` int(4) unsigned NOT NULL default '0',
  `alias` varchar(100) default NULL,
  `cinsiyet` enum('e','m') NOT NULL default 'e',
  `kurum` varchar(255) default NULL,
  `gorev` varchar(255) default NULL,
  `mezuniyet` varchar(100) default NULL,
  `mezuniyet_yil` varchar(4) default NULL,
  `mezuniyet_bolum` varchar(100) default NULL,
  `is_addr` text,
  `semt` varchar(100) default NULL,
  `sehir` varchar(255) default NULL,
  `pkod` varchar(5) default NULL,
  `PassWord` varchar(100) default NULL,
  `Resim` varchar(255) NOT NULL default '',
  `Telefon1` varchar(20) default NULL,
  `Telefon2` varchar(20) default NULL,
  `TCKimlikNo` varchar(15) default NULL,
  `Uye_karar_no` int(11) unsigned default NULL,
  `Uye_karar_tarih` date default NULL,
  `vesikalik_foto` tinyint(1) unsigned default '0',
  `Uye_formu` varchar(255) NOT NULL default '',
  `Notlar` text,
  `liste_uyeligi` tinyint(1) unsigned default '1',
  `gonullu` tinyint(1) unsigned NOT NULL default '1',
  `artik_uye_degil` tinyint(1) unsigned NOT NULL default '0',
  `oylama` tinyint(1) unsigned NOT NULL default '1',
  `trac_listesi` tinyint(1) unsigned NOT NULL default '0',
  `haber_alinamiyor` tinyint(1) unsigned NOT NULL default '0',
  `kimlik_gizli` tinyint(1) unsigned NOT NULL default '0',
  `kimlik_durumu` enum('Var/İstemiyor','İstiyor','Dijital Fotoğraf Bekleniyor','Basılacak','Basıldı','Güncel Adres Bekleniyor','Postaya Verilecek') NOT NULL default 'Var/İstemiyor',
  `ayrilma_tarihi` int(4) unsigned NOT NULL,
  `Ayrilma_karar_no` int(11) unsigned NOT NULL,
  `Ayrilma_karar_tarih` date NOT NULL,
  `kayit_acilis_tarih` DATETIME NULL ,
  `kayit_kapanis_tarih` DATETIME NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `TCKimlikNo` (`TCKimlikNo`,`Uye_karar_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
