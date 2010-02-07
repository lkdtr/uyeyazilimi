<?php
@require('uye_bilgi_config.inc.php');    // veritabanı erisim bilgileri

$uye = $_SERVER['PHP_AUTH_USER'];    // kullanici adi

# Uye veritabanina baglanip, guncellemeleri yapalim
$baglanti_uye =mysql_connect(HOST,USER,PASS);
@mysql_select_db(DB,$baglanti_uye);
@mysql_query("SET NAMES 'utf8'",$baglanti_uye);
$uyeGuncelle='UPDATE uyeler SET eposta1 = "' . mysql_real_escape_string(@strip_tags($_POST['txt_mail1'])) . '",
                          eposta2 = "' . mysql_real_escape_string(@strip_tags($_POST['txt_mail2'])) .'",
                          Telefon1 = "' . mysql_real_escape_string(@strip_tags($_POST['txt_telefon1'])) .'",
                          Telefon2 = "' . mysql_real_escape_string(@strip_tags($_POST['txt_telefon2'])) .'",
                          sehir = "' . mysql_real_escape_string(@strip_tags($_POST['txt_sehir'])) .'",
                          liste_uyeligi = "' . mysql_real_escape_string(@strip_tags($_POST['txt_liste'])) .'",
                          gonullu = "' . mysql_real_escape_string(@strip_tags($_POST['txt_gonullu'])) .'",
                          kimlik_gizli = "' . mysql_real_escape_string(@strip_tags($_POST['txt_kimlik'])) .'",
                          oylama = "' . mysql_real_escape_string(@strip_tags($_POST['txt_oylama'])) .'",
                          trac_listesi = "' . mysql_real_escape_string(@strip_tags($_POST['txt_trac'])) .'"
        WHERE alias="' . $uye . '@linux.org.tr"';
$uyeGuncelleSorgu = mysql_query($uyeGuncelle,$baglanti_uye);

# E-posta aliaslarinin bulundugu tabloyu guncelleyelim
@mysql_select_db(DB_MAIL,$baglanti_uye);
$mailGuncelle = 'UPDATE forwardings SET destination = "' . mysql_real_escape_string(@strip_tags($_POST['txt_mail1'])) . '" WHERE source="'. $uye . '@linux.org.tr"';
$mailGuncelleSorgu = mysql_query($mailGuncelle,$baglanti_uye);
@mysql_close($baglanti_uye);

if($uyeGuncelleSorgu)
 $mesaj = "Bilgileriniz başarıyla güncellendi.";
else
 $mesaj = "Bilgi güncellemesinde bir hata oluştu.";

header("Location: uye_bilgi.php?mesaj=$mesaj"); // yonlendirmeyi bilgi_php ye yapip mesaji orada gosterelim
?>
