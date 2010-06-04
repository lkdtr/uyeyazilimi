<?php
    require('ayarlar.inc.php');
    require('fonksiyonlar.inc.php');
    
    veritabani_baglantisi_kur();

    if($_GET['ok'])    // onay alindi, islemi yapalim
    {
        $sorgu = 'UPDATE uyeler SET kimlik_durumu = "Basılacak" WHERE (kimlik_durumu = "İstiyor" OR kimlik_durumu = "Dijital Fotoğraf Bekleniyor") AND Resim != "" AND artik_uye_degil = 0';
        $sonuc = mysql_query($sorgu) or die(mysql_error());
        header('Location: uyelerlist.php');
    }

    $sorgu = 'SELECT id, uye_id, uye_ad, uye_soyad, alias, Resim FROM uyeler WHERE (kimlik_durumu = "İstiyor" OR kimlik_durumu = "Dijital Fotoğraf Bekleniyor") AND Resim != "" AND artik_uye_degil = 0';
    $sonuc = mysql_query($sorgu) or die(mysql_error());
    $sonuc_sayisi = mysql_num_rows($sonuc);

    include('header.inc.php');

    if($sonuc_sayisi)
    {
        echo '<p>&nbsp;</p><p align="center">Aşağıdaki ' . $sonuc_sayisi . ' üyenin <u>Kimlik Durumu</u> alanı <i>İstiyor</i> ya da <i>Dijital Fotoğraf Bekleniyor</i> iken, <b>Basılacak</b> olarak değiştirilecek.</p><p align="center"><a href="' . $_SERVER['SCRIPT_NAME'] . '?ok=1">Tamam</a></p>';

        uyeler_tablo_gosterimi($sonuc);
    }
    else
        echo '<p>&nbsp;</p><p align="center"><u>Kimlik Durumu</u> alanı <i>İstiyor</i> ya da <i>Dijital Fotoğraf Bekleniyor</i> olan ve fotoğrafı bulunan hiç üye bulunmuyor.</p><p>&nbsp;</p>';

    include('footer.inc.php');
?>
