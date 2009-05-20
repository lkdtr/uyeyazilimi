<?php
@require('db.php'); //veri tabanı bilgilerini bu dosyadan çektiğimi varsayıyorum.
@mysql_connect(HOST,USER,PASS);
@mysql_select_db(DB);

$slug = $_SERVER['PHP_AUTH_USER'];

$query='UPDATE uyeler SET eposta1 = "' . @strip_tags($_POST['txt_mail1']) . '",
                          eposta2 = "' . @strip_tags($_POST['txt_mail2']) .'",
                          Telefon1 = "' . @strip_tags($_POST['txt_telefon1']) .'",
                          Telefon2 = "' . @strip_tags($_POST['txt_telefon2']) .'",
                          sehir = "' . @strip_tags($_POST['txt_sehir']) .'",
                          liste_uyeligi = "' . @strip_tags($_POST['txt_liste']) .'",
                          gonullu = "' . @strip_tags($_POST['txt_gonullu']) .'",
                          kimlik_gizli = "' . @strip_tags($_POST['txt_kimlik']) .'",
                          oylama = "' . @strip_tags($_POST['txt_oylama']) .'",
                          trac_listesi = "' . @strip_tags($_POST['txt_trac']) .'"
        WHERE alias="' . $slug . '@linux.org.tr" ';
$result = mysql_query($query);
if($result)
{
    echo "Bilgileriniz güncellenmiştir";
}
else
{
    echo "Bilgileriniz güncellenirken bir sorun oluştu";
}

?>
