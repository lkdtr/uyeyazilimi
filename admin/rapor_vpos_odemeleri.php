<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>LKD Ãdeme Sistemi</title></head>


<body bgcolor="white">
<?php
require('ayarlar.inc.php');

$link = mysql_connect(HOST, USER, PASS);
if (!$link) {
    die('Bağlantı Hatası! ' . mysql_error());
}
mysql_query("SET NAMES 'utf8'");

mysql_select_db( DB_VPOS );

$queryString = "select * from payments ORDER BY date DESC";
$result = mysql_query($queryString, $link);

if (!$result) {
    die('Sorgu Hatası!: ' . mysql_error());
}
?>
<table border="1" width="100%">
<tr>
<th>ID</th>
<th colspan="2">Ad Soyad</th>
<th>Adres</th>
<th>E-Mail</th>
<th>Sansürlü Kart-No</th>
<th>Tutar</th>
<th>IP Adresi</th>
<th>Tarih</th>
<th>Açıklama</th>
<th>Telefon</th>
</tr>

<?PHP
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	echo '<tr>';
	foreach ($row as $key => $value ) {
		echo '<td>'.$value.'</td>';
	}
	echo '</tr>';
}

mysql_free_result($result);


mysql_close($link);



?>
</table>
</body>
</html>
