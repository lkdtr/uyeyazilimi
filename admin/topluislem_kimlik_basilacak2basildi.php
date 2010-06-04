<?php
    require('ayarlar.inc.php');
    require('fonksiyonlar.inc.php');
    
    veritabani_baglantisi_kur();

    if($_GET['ok'])    // onay alindi, islemi yapalim
    {
        $sorgu = 'UPDATE uyeler SET kimlik_durumu = "Basıldı" WHERE kimlik_durumu = "Basılacak" AND artik_uye_degil = 0';
        $sonuc = mysql_query($sorgu) or die(mysql_error());
        header('Location: uyelerlist.php');
    }

    $sorgu = 'SELECT id, uye_id, uye_ad, uye_soyad, alias, Resim FROM uyeler WHERE kimlik_durumu = "Basılacak" AND artik_uye_degil = 0';
    $sonuc = mysql_query($sorgu) or die(mysql_error());
    $sonuc_sayisi = mysql_num_rows($sonuc);

    include('header.inc.php');

    if($sonuc_sayisi)
    {
        echo '<p>&nbsp;</p><p align="center">Aşağıdaki ' . $sonuc_sayisi . ' üyenin <u>Kimlik Durumu</u> alanı <i>Basılacak</i> iken, <b>Basıldı</b> olarak değiştirilecek.</p><p align="center"><a href="' . $_SERVER['SCRIPT_NAME'] . '?ok=1">Tamam</a></p>';

        uyeler_tablo_gosterimi($sonuc);
    }
    else
        echo '<p>&nbsp;</p><p align="center"><u>Kimlik Durumu</u> alanı <i>Basılacak</i> olan hiç üye bulunmuyor.</p><p>&nbsp;</p>';

    include('footer.inc.php');
?>
