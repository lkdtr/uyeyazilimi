<?php
@require('db.php'); //veri tabanı bilgilerini bu dosyadan çektiğimi varsayıyorum.
@mysql_connect(HOST,USER,PASS);
@mysql_select_db(DB);

$slug = $_SERVER['PHP_AUTH_USER'];

$query='UPDATE uyeler SET eposta1 = "' . $_POST['txt_mail1'] . '", 
                          eposta2 = "' . $_POST['txt_mail2'] .'",
                          Telefon1 = "' . $_POST['txt_telefon1'] .'",
                          Telefon2 = "' . $_POST['txt_telefon2'] .'",
                          sehir = "' . $_POST['txt_sehir'] .'",
                          liste_uyeligi = "' . $_POST['txt_liste'] .'",
                          gonullu = "' . $_POST['txt_gonullu'] .'",
                          kimlik_gizli = "' . $_POST['txt_kimlik'] .'",
                          oylama = "' . $_POST['txt_oylama'] .'",
                          trac_listesi = "' . $_POST['txt_trac'] .'"
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
