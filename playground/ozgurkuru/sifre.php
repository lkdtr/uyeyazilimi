<?php
@require('db.php'); //veri tabanı bilgilerini bu dosyadan çektiğimi varsayıyorum.
@mysql_connect(HOST,USER,PASS);
@mysql_select_db(DB);
$slug = $_SERVER['PHP_AUTH_USER'];
/* üye bilgileri */
$new_pass1 = $_POST['txt_parola1'];
$new_pass2 = $_POST['txt_parola2'];
if($new_pass1 == $new_pass2)
{
$new_pass = md5($new_pass1);
$query='UPDATE uyeler SET PassWord = "' . $new_pass . '" WHERE alias="' . $slug . '@linux.org.tr" ';
$result = mysql_query($query);
    if($query)
    {
        echo "Şifreniz başarı ile değiştirilmiştir";
    }
    else
    {
        echo "Şifreniz değiştirilemedi";
    }
}
else
{
    echo "Şifreler bir biri ile uyuşmuyor.";
}
?>
