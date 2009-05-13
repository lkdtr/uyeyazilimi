<?php
 require ('idarialias_config.inc.php');
 
 $dblink = mysql_connect(HOST, USERNAME, PASSWORD) or die('Veritabanına bağlanamadım');
 mysql_select_db(DATABASE) or die('Veritabanını seçemedim');

 $query = "SELECT * FROM forwardings WHERE source NOT LIKE '%.%@%'";
 $result = mysql_query($query);
 $rowno = mysql_num_rows($result);
?>

<html>
<head>
<title>İdari e-postaların listesi</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>

<p align=center><a href="idarialias_ekle.php">Yeni idari e-posta ekle</a></p>

<?php
 echo "<p align=center>Toplam $rowno alias bulunuyor</p>";
 echo '<div align=center><center><table border=0 width=100%><tr><td bgcolor=red><font color=yellow>Adres</font></td><td bgcolor=red><font color=yellow>Varış Merkezleri</font></td><td bgcolor=red width=20>&nbsp;</td></tr>';
 while($rowno--)
  {
   $row = mysql_fetch_array($result);
   echo "<tr><td>$row[source]</td><td>$row[destination]</td><td><a href=idarialias_duzenle.php?source=$row[source]>Düzenle</a></td></tr>";
  }
 echo '</table></center></div>';
?>

</body>
</html>
