<?php
 #
 # Postfix'in provider veritabani forwarders tablosunu uyetakip veritabaninin uyeler tablosundaki verilere gore gunceller
 #
 # v0.1 - dfisek - 20/04/2005

 $username = '****';
 $password = '****';

 $dblink = @mysql_pconnect(localhost,$username,$password);
 mysql_select_db('uyetakip',$dblink);

 $query = 'SELECT alias,eposta1 FROM uyeler';
 $result = mysql_query($query);
 $rowno = mysql_num_rows($result);

 mysql_select_db('provider', $dblink);

 while($rowno--)
  {
   $row = mysql_fetch_array($result);
   $source = $row[alias] . '@linux.org.tr';
   $destination = $row[eposta1];

   $query = "UPDATE forwardings SET destination = \"$destination\" WHERE source = \"$source\"";
   // $temp = mysql_query($query);

   echo "$query;<br>";
  }

?>
