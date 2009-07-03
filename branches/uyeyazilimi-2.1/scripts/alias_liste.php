<?php
 
 $dblink = @mysql_pconnect(localhost,"****","****");
 mysql_select_db("uyetakip",$dblink);

 $result = mysql_query("SELECT alias FROM uyeler WHERE uye_id < 10000");
 $rowno = mysql_num_rows($result);

 while($rowno--) 
  {
   $row = mysql_fetch_row($result);
   echo "$row[0]@linux.org.tr<br>";
  }
?>
