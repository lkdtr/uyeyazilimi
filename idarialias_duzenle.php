<?php
 require ('idarialias_config.inc.php');
 
 $dblink = mysql_connect(HOST, USERNAME, PASSWORD) or die('Veritabanına bağlanamadım');
 mysql_select_db(DATABASE) or die('Veritabanını seçemedim');

 $query = "SELECT * FROM forwardings WHERE source='$_GET[source]'";
 $result = mysql_query($query);
?>

<html>
<head>
<title>İdari e-postaların düzenlenmsi</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>

<form method="post" action="idarialias_kaydet.php">

<div align=center><center>
 <table border=0 width=100%>
  <tr>
   <td bgcolor=red><font color=yellow>Adres</font></td>
   <td bgcolor=red><font color=yellow>Varış Merkezleri</font></td>
  </tr>

<?php
 $row = mysql_fetch_array($result);
 echo "<tr><td>$row[source]</td><td><input type=text name=destination value=\"$row[destination]\"></td></tr>";
 echo "<input type=hidden name=source value=\"$row[source]\">";
?>
 </table>
 <input type="submit" value="Kaydet">
</center></div>
</form>
</body>
</html>
