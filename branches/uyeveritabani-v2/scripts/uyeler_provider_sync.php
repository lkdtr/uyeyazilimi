<?php
 #
 # Postfix'in provider veritabani forwarders tablosunu uyetakip veritabaninin uyeler tablosundaki verilere gore gunceller
 #

 require('../db.php');

 # Uye veritabanindan e-posta bilgilerini cekelim
 $dblink = @mysql_pconnect(HOST,USER,PASS) or die(mysql_error());
 mysql_select_db(DB,$dblink) or die(mysql_error());
 $query = 'SELECT alias,eposta1 FROM uyeler WHERE artik_uye_degil = 0';
 $result = mysql_query($query) or die(mysql_error());
 $rowno = mysql_num_rows($result);
 mysql_close($dblink);
 
 # Postfix veritabanina baglanip bilgileri guncelleyelim, eger yoksa adres ekleyelim
 $dblink = @mysql_pconnect(HOST_MAIL,USER_MAIL,PASS_MAIL) or die(mysql_error());
 mysql_select_db(DB_MAIL, $dblink);

 while($rowno--)
  {
   $row = mysql_fetch_array($result);

   $query = 'REPLACE INTO forwardings VALUES ("' . $row['alias'] . '", "' . $row['eposta1'] . '")';
   mysql_query($query) or die(mysql_error());
  }
 mysql_close($dblink);
?>
