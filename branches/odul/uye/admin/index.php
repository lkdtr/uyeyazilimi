<?php

// baslatici
require('baslatici.php');

// yarisma ayarla
if( $_GET[yarismaAyarla] ){
	$sonuc = $db->get(array('table'=>'yarismalar', 'where'=>array('anahtar'=>$_GET[yarismaAyarla])));
	$_SESSION[yarismaNo] = $sonuc[no];
	header('Location: '.$_SERVER[HTTP_REFERER]);
	exit;
}

// modulu yukleyelim
$sayfaIcerigi = moduleLoader(array(
	'module'  => $_GET[modul],
	'dir'     => 'modules',
	'allowed' => 'yorumlar adaylar kategoriler icerik yarismalar',
	'default' => 'yarismalar'
));


// onaylanmamis yorum sayisi
$sonuc = $db->all(array(
	'table'  => 'yorumlar',
	'select' => 'count(no) as sayi',
	'where'  => array('yarisma'=>$Y[no], 'aktif'=>0)
));
$onaylanmamisYorumSayisi = $sonuc[0][sayi];


// onaylanmamis aday sayisi
$sonuc = $db->all(array(
	'table'  => 'adaylar',
	'select' => 'count(no) as sayi',
	'where'  => array('yarisma'=>$Y[no], 'aktif'=>0)
));
$onaylanmamisAdaySayisi = $sonuc[0][sayi];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Yılın Penguenleri Yönetim Arayüzü</title>
	<link rel="stylesheet" type="text/css" media="screen" href="../css/admin.css" />
</head>
<body>
	<div class="interface">
		<div class="header">
			<h1>Yönetim</h1>
		</div>
		<div class="menu">
			<ul>
				<li <?=($module == 'yorumlar'    ? 'class="selected"':'')?>><a href="?modul=yorumlar">Yorumlar<?=( $onaylanmamisYorumSayisi ? ' ('. $onaylanmamisYorumSayisi .')':'' );?></a></li>
				<li <?=($module == 'adaylar'     ? 'class="selected"':'')?>><a href="?modul=adaylar">Adaylar<?=( $onaylanmamisAdaySayisi ? ' ('. $onaylanmamisAdaySayisi .')':'' );?></a></li>
				<li <?=($module == 'kategoriler' ? 'class="selected"':'')?>><a href="?modul=kategoriler">Kategoriler</a></li>
				<li <?=($module == 'icerik'      ? 'class="selected"':'')?>><a href="?modul=icerik">İçerik</a></li>
				<li <?=($module == 'yarismalar'  ? 'class="selected"':'')?>><a href="?modul=yarismalar">Yarışmalar</a></li>
			</ul>
		</div>
		<div class="siteSelect">
			Yarışma : <?=$yarismalar->select('onChange="window.top.location = \'?yarismaAyarla=\' + this.value;"', false, $Y[anahtar]);?>
		</div>
		<div id="content">
			<?=$sayfaIcerigi;?>
		</div>
		<div class="footer">
			Yılın Penguenleri Yöentim Arayüzü | Mehmet Fatih YILDIZ 2009 &copy;
		</div>
	</div>
</body>
</html>
