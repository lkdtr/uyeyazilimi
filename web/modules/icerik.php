<?php

// parametreler
if(!$no) $no = $_GET[sayfa];
if( !$no ) new error('Sayfa id belirtilmemiş!');

// icerik
$sayfa = $db->get(array(
	'table' => 'icerik',
	'where' => 'no = '.$no
));

//print_r($sayfa);exit;

// kontrol
if( !$sayfa ) new error('Sayfa Bulunamadı!');

// sayfa basligi
$GLOBALS[sayfaBasligi] = $sayfa[baslik];

// icerigi basalim
print $sayfa[kod];

?>