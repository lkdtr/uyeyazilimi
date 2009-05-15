<?php
@require('db.php'); //veri tabanı bilgilerini bu dosyadan çektiğimi varsayıyorum.

/* üye bilgileri */
$new_pass1 = $_POST[text_sifre1];
$new_pass2 = $_POST[text_sifre2];
if($new_pass1 == $new_pass2)
{

$new_pass = md5($new_pass1);
$query='UPDATE * FROM uyeler SET PassWord = "' . $new_pass . '" WHERE alias="' . $slug . '@linux.org.tr" ';
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
