<?php
// kayit tarihlerini bir seferde csv'den import etmek icin -- dfisek // 24-07-2004
 
 $dblink = @mysql_pconnect(localhost,"****","***");
 mysql_select_db("uyetakip",$dblink);

 $fcontents = file ("temp.csv");
 $i = 0;

 while($fcontents[$i]) 
  {
   $temp = explode(",","$fcontents[$i]");
   $result = mysql_query("UPDATE uyeler SET kayit_tarihi = '$temp[1]' WHERE uye_id = $temp[0]");
   $i++;
  }
?>
