
<?php
@require('db.php'); //veri tabanı bilgilerini bu dosyadan çektiğimi varsayıyorum.
$baglanti_sifre=mysql_connect(HOST,USER,PASS);
@mysql_select_db(DB,$baglanti_sifre);
$uye = $_SERVER['PHP_AUTH_USER'];
/* üye bilgileri */
$yeni_sifre1 = mysql_real_escape_string(@strip_tags($_POST['txt_parola1']));
$yeni_sifre2 = mysql_real_escape_string(@strip_tags($_POST['txt_parola2']));
if($yeni_sifre1 == $yeni_sifre2)
{
$yeni_sifre = md5($yeni_sifre1);
$sifre_guncelle='UPDATE uyeler SET PassWord = "' . $yeni_sifre . '" WHERE alias="' . $uye . '@linux.org.tr" ';
$sonuc = mysql_query($sifre_guncelle,$baglanti_sifre) or die (mysql_error());
    
	if($sonuc)
    {
		$mesaj = "Şifreniz başarı ile değiştirilmiştir"; // yonlendirmeyi bilgi_php ye yapip mesaji orada gosterelim
		header("Location: uye_bilgi.php?mesaj=$mesaj");
    }
}
else
{
    $mesaj =  "Şifreler bir biri ile uyuşmuyor.";
	echo $mesaj;
}
?>
