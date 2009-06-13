<?php
@require('db.php'); //veri tabanı bilgilerini bu dosyadan çektiğimi varsayıyorum.
$baglanti =mysql_connect(HOST,USER,PASS);
@mysql_select_db(DB,$baglanti);
@mysql_set_charset('utf8',$baglanti);
@mysql_connect(HOST_MAIL,USER_MAIL,PASS_MAIL);
@mysql_select_db(DB_MAIL);


$slug = $_SERVER['PHP_AUTH_USER'];
$uyeBilgi = 'SELECT eposta1,alias FROM uyeler WHERE alias="' .$slug .'@linux.org.tr"';
$rs = mysql_query($uyeBilgi) or die (mysql_error());
$eskimail= mysql_fetch_assoc($rs);

$updateUye='UPDATE uyeler SET eposta1 = "' . mysql_real_escape_string(@strip_tags($_POST['txt_mail1'])) . '",
                          eposta2 = "' . mysql_real_escape_string(@strip_tags($_POST['txt_mail2'])) .'",
                          Telefon1 = "' . mysql_real_escape_string(@strip_tags($_POST['txt_telefon1'])) .'",
                          Telefon2 = "' . mysql_real_escape_string(@strip_tags($_POST['txt_telefon2'])) .'",
                          sehir = "' . mysql_real_escape_string(@strip_tags($_POST['txt_sehir'])) .'",
                          liste_uyeligi = "' . mysql_real_escape_string(@strip_tags($_POST['txt_liste'])) .'",
                          gonullu = "' . mysql_real_escape_string(@strip_tags($_POST['txt_gonullu'])) .'",
                          kimlik_gizli = "' . mysql_real_escape_string(@strip_tags($_POST['txt_kimlik'])) .'",
                          oylama = "' . mysql_real_escape_string(@strip_tags($_POST['txt_oylama'])) .'",
                          trac_listesi = "' . mysql_real_escape_string(@strip_tags($_POST['txt_trac'])) .'"
        WHERE alias="' . $slug . '@linux.org.tr"';

$updateMail = 'UPDATE forwardings SET source="'. $slug .'@linux.org.tr" WHERE destination = "'. $eskimail[eposta1].'"';
$resultMail = mysql_query($updateMail) or die (mysql_error());

?>
