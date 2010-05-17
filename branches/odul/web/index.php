<?php

// baslatici
require('baslatici.php');

// modulu yukleyelim
$sayfaIcerigi = moduleLoader(array(
	'module'  => $_GET[modul],
	'dir'     => 'modules',
	'allowed' => 'anasayfa yorumlar adaylar aday kategoriler kategori icerik yarismalar askidakiler',
	'default' => 'anasayfa'
));


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title><?=($sayfaBasligi ? $sayfaBasligi.' - ':'');?>Yılın Penguenleri</title>
	<link rel="stylesheet" type="text/css" media="screen" href="/source/css/stil.css" />
</head>
<body class="siteFront">

	<div id="ust">
		<img src="/source/img/ustmenu.gif" border="0" usemap="#Map" />
		<map name="Map" id="Map">
		  <area shape="rect" coords="366,38,623,163"                                  href="/yarisma-<?=$Y[anahtar];?>/" />
		  <area shape="poly" coords="305,215,300,235,353,244,354,231,306,215"         href="/yarisma-<?=$Y[anahtar];?>/hakkinda/" />
		  <area shape="poly" coords="366,229,368,247,418,246,454,242,456,228,409,233" href="/yarisma-<?=$Y[anahtar];?>/kategoriler/" />
		  <area shape="poly" coords="466,222,465,237,504,226,509,217,491,216"         href="/yarisma-<?=$Y[anahtar];?>/adaylar/" />
		  <area shape="poly" coords="516,209,516,223,553,234,555,219,535,213"         href="/yarisma-<?=$Y[anahtar];?>/yontem/" />
		</map>
		<h1><?=$sayfaBasligi;?></h1>
	</div>
	<div id="genislik">
		<div id="arayuz">
			<?=$sayfaIcerigi;?>
			<?
			/*
			Linux ve Özgür Yazılım Şenliği ile yaşıt olan Linux Kullancıları Derneği Yılın Penguenleri ödülleri bu yıl yedinci kez  verildi.<br />
			<br />
			Dernek üyeleri arasında yapılan oylama sonucunda verilen ödüller şöyle :
			<ul>
			  <li>En Çalışkan Penguen: Necati Demir</li>
			  <li>En İyi Kurumsal Kullanıcı: TSK Mehmetçik Vakfı</li>
			  <li>En Başarılı Yerelleştirici: Çağatay Oltulu</li>
			  <li>En İyi Basılı/Görsel İçerik Çalışması: www.ozgurlukicin.com</li>
			  <li>En İyi Özgür Yazılım: Tekir ön muhasebe ve ticari otomasyon</li>
			  <li>En Başarılı Özgür Yazılım Temelli Uygulama Projesi: Odul verilmemesi  kabul edildi.</li>
			</ul>
			*/
			?>
		</div>
	</div>
	<div id="alt">
		<div id="altmenu">
			<?php

			// yarisma suruyorsa
			if( $Y[adim] == 1 ){
				print '<img src="/source/img/altmenu.gif" border="0" usemap="#Map2" />



	<map name="Map2" id="Map2">
				  <area shape="rect" coords="138,127,227,154" href="/yarisma-'.$Y[anahtar].'/multimedya/" />
				  <area shape="poly" coords="17,86,6,123,39,136,88,137,143,124,146,113,116,106,77,100,58,100,15,87" 
href="/yarisma-'.$Y[anahtar].'/aday-goster/" />
		  <area shape="poly" 
coords="98,95,108,61,122,67,138,65,145,79,169,67,193,75,217,79,235,85,229,103,222,118,182,115,150,104,140,106,130,105,100,94" href="/yarisma-'.$Y[anahtar].'/askidakiler/" 
/>
				</map>	
';
			}else{
				// bos alani dolduralim
				print '<div style="width:1px; height: 172px;">&nbsp;</div>';
			}

			?>
			<div id="gectigimizyillar">
				<?php

					foreach($yarismalar->all() as $yarisma){
						print '<a href="/yarisma-'. $yarisma[anahtar] .'/">'.$yarisma[adi].'</a><br />';
					}

				?>
				<br />
			</div>
		</div>
		<div id="tlkdlogo"><a href="http://www.lkd.org.tr" target="_blank"><img src="/source/img/tlkdlogo.gif" /></a></div>
	</div>

</body>
</html>
