<?php

header("Content-type: application/xml");

 function tarih_insancil($tarih)    // veritabanindan gelen tarihi insancil bir hale cevirelim
  {
   setlocale(LC_TIME, 'tr_TR.utf8');
   $tarih_parcalari = explode('-', $tarih);
   return strftime("%e %B %Y", mktime(0, 0, 0, $tarih_parcalari[1], $tarih_parcalari[2], $tarih_parcalari[0]));
  }


 $slug = $_SERVER['PHP_AUTH_USER'];    // kullanici adi
 
 // veritabani baglantisi
 require('db.php');
 $conn = mysql_connect(HOST, USER, PASS);
 
 mysql_select_db(DB) or die(mysql_error());
 mysql_query("SET NAMES 'utf8'");

 // uyenin kisisel bilgilerini alalim
 $query = 'SELECT * FROM uyeler WHERE alias = "' . $slug . '@linux.org.tr"';
 $result = mysql_query($query);
 $user_info = mysql_fetch_array($result);

 // uyenin toplam odemesi gereken aidat miktarini hesaplayalim
 $query = 'SELECT SUM(miktar) FROM aidat_miktar WHERE yil >= '. $user_info['kayit_tarihi'];
 $result = mysql_query($query);
 $odenmesi_gereken_aidat = mysql_result($result,0);
 if ($user_info['kayit_tarihi'] <= 2002)    // 2002 ve oncesinde aidata ek olarak ilk yil dernege giris ucreti aliniyordu
  $odenmesi_gereken_aidat += 5;

 // uyenin aidat odeme toplamini alip, kalan odeme miktarini cikaralim
 $query = 'SELECT SUM(miktar) FROM odemeler WHERE tur="aidat" AND uye_id = ' . $user_info['uye_id'];
 $result = mysql_query($query);
 $odenen_aidat = mysql_result($result,0);
 $aidat_odemesi = $odenmesi_gereken_aidat - $odenen_aidat;

 // veritabanindan alacagimizi aldik
 mysql_close($conn);

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<uye>
    <no><?php echo $user_info['uye_id']; ?></no>
    <ad><?php echo $user_info['uye_ad'] . ' ' . $user_info['uye_soyad']; ?></ad>
    <eposta><?php echo $user_info['eposta1']; ?></eposta>
    <sehir><?php echo $user_info['sehir']; ?></sehir>
    <yil><?php echo $user_info['kayit_tarihi']; ?></yil>
    <gizli><?php
     if( $user_info['kimlik_gizli'] == 1 )
      echo "İstiyor";
     else
      echo "İstemiyor";
?></gizli>
    <kart><?php echo $user_info['kimlik_durumu']; ?></kart>
    <aidat><?php
     if( $aidat_odemesi > 0 )
      echo $aidat_odemesi . ' TL';
     else
      echo "Yok";
?></aidat>
</uye>
