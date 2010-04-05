<?php
 #
 # Uye parola veritabanindaki ad/soyad/e-posta hanesini, uyetakip veritabanindakine gore gunceller
 #

 require('../ayarlar.inc.php');

 # Uye veritabanindan bilgilerini cekelim
 $dblink = @mysql_pconnect(HOST,USER,PASS) or die(mysql_error());
 mysql_query('SET NAMES utf8');
 mysql_select_db(DB) or die(mysql_error());
 $query = 'SELECT uye_ad,uye_soyad,alias FROM uyeler WHERE artik_uye_degil=0';
 $result = mysql_query($query) or die(mysql_error());
 $rowno = mysql_num_rows($result);
 
 # Uye parola veritabanina yazalim
 mysql_select_db(DB_PWD) or die(mysql_error());

 while($rowno--)
  {
   $row = mysql_fetch_array($result);
   $parts = explode('@', $row['alias']);

   $query = 'UPDATE members SET name="' . $row['uye_ad'] . '",lastname="' . $row['uye_soyad'] . '", email="' . $row['alias'] . '" WHERE lotr_alias = "' . $parts[0] . '";';

   mysql_query($query) or die(mysql_error());
  }
 mysql_close($dblink);

 echo "Uyetakip -> lkd-uye ad-soyad-eposta guncellenmesi tamamlandi";
?>
