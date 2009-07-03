<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<title>W3</title>
<link type="text/css" rel="stylesheet" href="w3.css">
</head><body>
<br><br><hr width="50%">
<div align="center">
<a href="w3_listele.php"><img src="images/lkdw3.gif" border="0" alt="banner"></a>
</div><hr width="50%">
<div align="center">
<?php
require_once 'w3_baglanti.php';
$gorev			= array('Kullanici Ekleme','Kullanici Silme','W3 Ekleme','W3 Silme','W3 Guncelleme');
$sf				= empty($_GET["sf"]) ? $sf = 0 : $sf = ($_GET["sf"]-1) * $sayfalama;
$sorgux			= mysql_query("SELECT count(*) FROM w3_log");
$kayitSayisi	= mysql_result($sorgux,0);
if($kayitSayisi == 0) {
	echo "<font face=\"Tahoma\" color=\"red\" size=\"3\"><b><u>Log Kaydı Yok.!</u> <br> Şu andaki Zaman : ". date("j.n.Y H:i:s")."</b></font>";
} else {
$sorgu			= mysql_query("SELECT * FROM w3_log ORDER BY zaman LIMIT ".$sf.",".$sayfalama);
	if($_GET["sf"] != 0) { 
	echo "<font face=\"Verdana\" color=\"red\" size=\"2\"><b> Şu anda <u>".$_GET["sf"]."</u>. sayfanın kayıtları inceleniyor.. </b></font>"; 
	}
	echo "<table border='0' cellpadding=\"5\" cellspacing=\"3\">\n";
	echo "<tr bgcolor=\"#c2c2c2\">\n";
	echo "<td>#</td>\n";
	echo "<td>Islemi Gerceklestiren Kisi</td>\n";
	echo "<td>Yapilan Islem</td>\n";
	echo "<td>Tarih</td>\n";
	echo "<td>Gorev</td>\n";
	echo "</tr>";
while(list($id,$islemci,$islem,$zaman,$tur) = mysql_fetch_array($sorgu)) {
	if($counter % 2 == 0) {	echo "<tr bgcolor=\"#b0c4de\">"; } else { echo "<tr bgcolor=\"#d3d3d3\">"; }
	echo "<td>".$id."</td>";
	if($islemci == "") { $islemci = "Belirtilmemiş"; }
	echo "<td>".$islemci."</td>";
	echo "<td>".$islem."</td>";
	echo "<td>".$zaman."</td>";
	echo "<td>".$gorev[$tur]."</td>";
	echo "</tr>";
	$counter++;
}
	echo "</table>";
$sayfa			= $kayitSayisi / $sayfalama;
for($a=1;$a<$sayfa+1;$a++) {
	echo "<a href=\"w3_log.php?sf=".$a."\">[".$a."]</a>\n";
}
}
?><br>
<a href="w3_listele.php"><img src="images/anasayfa.gif" border="0" alt="Anasayfa"></a>
</div>
<div align="center"><hr width="50%">LKD W3 Web Arayüzü &copy; 2006 Onur Yerlikaya<hr width="50%"></div>
  <p align="center">
    <a href="http://validator.w3.org/check?uri=referer"><img
        src="images/valid-html401.png"
        alt="Valid HTML 4.01 Transitional" height="31" width="88" style="border:0"></a>
     <a href="http://jigsaw.w3.org/css-validator/check/referer">
  <img style="border:0;width:88px;height:31px"
       src="images/vcss.png" 
       alt="Valid CSS!">
 </a>
  </p>
</body>
</html>