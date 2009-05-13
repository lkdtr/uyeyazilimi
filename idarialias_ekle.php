<html>
<head>
<title>İdari e-posta adresi ekleme</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>

<p align=center><font color=red>Dikkat! Buradan sadece idari e-posta adresi ekleyiniz, üyelerin e-posta adresleri üye yazılımı tarafından eklenir. Buradan eklerseniz karışıklığa yol açabilir</font></p>

<form method="post" action="idarialias_ekle_kaydet.php">

<div align=center><center>
 <table border=0 width=100%>
  <tr>
   <td bgcolor=red><font color=yellow>Adres</font></td>
   <td bgcolor=red><font color=yellow>Varış Merkezleri</font></td>
  </tr>

<?php
 echo "<tr><td><input type=text name=source></td><td><input type=text name=destination></td></tr>";
?>
 </table>
 <input type="submit" value="Kaydet">
</center></div>
</form>
</body>
</html>
