<?php
 /*
  Uye yazilimi veritabanindan tum uyelerin alias/isim/e-posta bilgilerini alarak Trac'in veritabanina aktarir.
  Duzenli senkronizasyon icin kullanilacak olursa, biraz daha optimize edilmesi gerekir.
 */

 // veritabani baglantisi
 require('db.php');
 $conn = mysql_connect(HOST, USER, PASS);

 // uyelerin aktarilacak bilgilerini alalim
 mysql_select_db(DB_PWD) or die(mysql_error());
 mysql_query("SET NAMES 'utf8'");
 $query = "SELECT lotr_alias, name, lastname FROM members";
 $uyeler = mysql_query($query);
 $uye_sayisi = mysql_num_rows($uyeler);

 // trac'a bilgileri ekleyelim ya da guncelleyelim
 mysql_select_db(DB_TRAC) or die(mysql_error());
 mysql_query("SET NAMES 'utf8'");
 
 while($uye_sayisi--)
  {
   $uye = mysql_fetch_array($uyeler);

   // bilgilerini guncelleyelim, varsa eksik bilgilerini tamamlayalim
   $query = 'REPLACE INTO session_attribute VALUES ("' . $uye['lotr_alias'] . '", 1, "name", "' . $uye['name'] . ' ' . $uye['lastname'] . '"),
                                                   ("' . $uye['lotr_alias'] . '", 1, "email", "' . $uye['lotr_alias'] . '@linux.org.tr");';
   mysql_query($query) or die($query);

   // uye daha once trac'a giris yapmis mi bakalim, yapmamissa bir de session tablosuna ekleme yapalim
   $query = 'SELECT * FROM session WHERE sid = "' . $uye['lotr_alias'] . '"';
   $result = mysql_query($query);
   if(!mysql_num_rows($result))
    {
     $query = 'INSERT INTO session VALUES ("' . $uye['lotr_alias'] . '", 1, 0)';
     mysql_query($query) or die(mysql_error());
    } 
  }

 mysql_close($conn);

 echo 'OK!';
?>
