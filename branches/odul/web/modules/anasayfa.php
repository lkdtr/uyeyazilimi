<?php

$no = $Y[anasayfa];
if( !$no ) $no = 6; // default anasayfa

// icerik yukleniyor
include('modules/icerik.php');

// baslik
$GLOBALS[sayfaBasligi] = 'Anasayfa';

?>