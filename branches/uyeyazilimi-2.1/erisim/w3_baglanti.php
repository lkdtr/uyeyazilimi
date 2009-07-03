<?php



# SQL Konfigürasyonu

$sqlSunucu			= "*****";

$sqlKullanici		= "*****";

$sqlSifre			= "*****";

$sqlVeritabani		= "*****";



# Log Konfigürasyonu



$sayfalama			= 10;



// Lütfen ellemeyin :)

mysql_connect($sqlSunucu,$sqlKullanici,$sqlSifre) or die ("SQL sunucusuna baglanilamadi");

mysql_select_db($sqlVeritabani) or die("Veritabanýna baglanilamadi.");



?>

