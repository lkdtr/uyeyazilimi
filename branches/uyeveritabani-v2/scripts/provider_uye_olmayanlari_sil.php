<?php
 #
 # Postfix'in provider veritabani forwarders tablosundan artik uye olmayan uyeleri siler
 #

 require('../db.php');

 # Uye veritabanindan e-posta bilgilerini cekelim
 $dblink = @mysql_pconnect(HOST,USER,PASS) or die(mysql_error());
 mysql_select_db(DB,$dblink) or die(mysql_error());
 $query = 'SELECT alias FROM uyeler WHERE artik_uye_degil = 1';
 $result = mysql_query($query) or die(mysql_error());
 $rowno = mysql_num_rows($result);
 mysql_close($dblink);
 
 # Postfix veritabanina baglanip ayrilan uyeleri silelim
 $dblink = @mysql_pconnect(HOST_MAIL,USER_MAIL,PASS_MAIL) or die(mysql_error());
 mysql_select_db(DB_MAIL, $dblink);

 while($rowno--)
  {
   $row = mysql_fetch_array($result);

   $query = 'DELETE FROM forwardings WHERE source = "' . $row['alias'] . '"';
   mysql_query($query) or die(mysql_error());
  }
 mysql_close($dblink);
?>
