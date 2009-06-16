<?php
@require('db.php'); //veri tabanı bilgilerini bu dosyadan çektiğimi varsayıyorum.
$baglanti_uye =mysql_connect(HOST,USER,PASS);
@mysql_select_db(DB,$baglanti_uye);
@mysql_set_charset('utf8',$baglanti_uye);
$baglanti_postfix=mysql_connect(HOST_MAIL,USER_MAIL,PASS_MAIL);
@mysql_select_db(DB_MAIL,$baglanti_postfix);
@mysql_set_charset('utf8',$baglanti_postfix);

$uye = $_SERVER['PHP_AUTH_USER'];
$uyeBilgi = 'SELECT eposta1,alias FROM uyeler WHERE alias="' .$uye .'@linux.org.tr"';
$uyeBilgiSorgu = mysql_query($uyeBilgi,$baglanti_uye) or die (mysql_error());
$eskimail= mysql_fetch_assoc($uyeBilgiSorgu);

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

$mailGuncelle = 'UPDATE forwardings SET source="'. $uye .'@linux.org.tr" WHERE destination = "'. $eskimail[eposta1].'"';
$mailGuncelleSorgu = mysql_query($mailGuncelle,$baglanti_postfix) or die (mysql_error());

if($mailGuncelleSorgu && $uyeBilgiSorgu)
{
	$mesaj = "Güncelleme başarılı.";
	header("Location: uye_bilgi.php?mesaj=$mesaj"); // yonlendirmeyi bilgi_php ye yapip mesaji orada gosterelim
}

?>
