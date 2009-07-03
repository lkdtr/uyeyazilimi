<?php
// lkd-uye uyelerini tek seferde metin dosyasindan aktarip veritabaninda eslemek icin -- dfisek // 07-02-2006

 $lines = file('lkd-uye.list');

 //$dblink = @mysql_pconnect(localhost,"****","****");
 //mysql_select_db("uyetakip",$dblink);

 foreach ($lines as $line_num => $line)
  {
   $line = rtrim($line);
   $query = 'UPDATE uyeler SET liste_uyeligi = 1 WHERE eposta1 = "' . $line . '";<br>';
   echo $query;
  }

?>
