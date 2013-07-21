<?php
$uye = $_SERVER['PHP_AUTH_USER'];

$yeni_sifre1 = $_POST['txt_parola1'];
$yeni_sifre2 = $_POST['txt_parola2'];

$yeni_sifre = md5($yeni_sifre1);

if (empty($yeni_sifre1))
{
    $mesaj = "Parola alanı boş olamaz.";
}
else if(md5($yeni_sifre1) == md5($yeni_sifre2))
{
 // Veritabani baglantisi
 @require('uye_bilgi_config.inc.php');
 $baglanti_sifre=mysql_connect(HOST,USER,PASS);

 // Uye veritabaninda parola degistirelim
 @mysql_select_db(DB,$baglanti_sifre);
 $sifre_guncelle='UPDATE uyeler SET PassWord = "' . $yeni_sifre . '" WHERE alias="' . $uye . '@linux.org.tr" ';
 $sonuc = mysql_query($sifre_guncelle,$baglanti_sifre) or $mesaj = "Parolanız güncellemesinde bir hata oluştu.";

 // Bir de yeni uye veritabaninda parolayi guncelleyelim
 @mysql_select_db(DB_PWD,$baglanti_sifre);
 $sifre_guncelle='UPDATE members SET password = "' . $yeni_sifre . '" WHERE lotr_alias="' . $uye . '"';
 $sonuc = mysql_query($sifre_guncelle,$baglanti_sifre) or $mesaj = "Parolanız güncellemesinde bir hata oluştu.";
}
else
{
    $mesaj =  "Parolalar birbiriyle uyuşmuyor.";
}

header("Location: uye_bilgi.php?mesaj=$mesaj"); // yonlendirmeyi bilgi_php ye yapip mesaji orada gosterelim
?>
