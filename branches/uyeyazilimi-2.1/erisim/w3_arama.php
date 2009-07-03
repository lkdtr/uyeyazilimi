<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<title>W3</title>
<link type="text/css" rel="stylesheet" href="w3.css">
</head>
<script type="text/javascript">
function ara() {
	ifade 	= document.getElementById('ifade').value;
	if(ifade == "") {
		alert("Lütfen gerekli kısmı doldurunuz !");
	} else {
		document.w3arama.submit();
	}
}
</script>
<body>
<br><br><hr width="50%">
<div align="center">
<a href="w3_listele.php"><img src="images/lkdw3.gif" border="0" alt="banner"></a>
</div><hr width="50%">
<div align="center">
<?php
require_once 'w3_baglanti.php';
$gorev			= array('Kullanici Ekleme','Kullanici Silme','W3 Ekleme','W3 Silme','W3 Guncelleme');
$islem			= empty($_GET["islem"]) ? "" : htmlspecialchars($_GET["islem"]);
if($islem == "ara") {
		// ARAMA ISLEMI
	$tur		= empty($_POST["tur"]) ? "" : htmlspecialchars($_POST["tur"]);
	$ifade		= empty($_POST["ifade"]) ? "" : htmlspecialchars($_POST["ifade"]);
	echo "<table border='0' cellpadding=\"5\" cellspacing=\"3\">\n";
	echo "<tr bgcolor=\"#c2c2c2\">\n";
	echo "<td>Islemi Gerceklestiren Kisi</td>\n";
	echo "<td>Yapilan Islem</td>\n";
	echo "<td>Tarih</td>\n";
	echo "<td>Gorev</td>\n";
	echo "</tr>";
		// TUR SWITCH
	switch($tur) {
	case 'zaman':
		//  ZAMAN ICIN ARAMA
	$araSQL		= mysql_query("SELECT islemci,islem,zaman,tur FROM w3_log WHERE zaman LIKE '".$ifade."%'");
	while(list($islemci,$islem,$zaman,$tur) = mysql_fetch_array($araSQL)) {
	if($counter % 2 == 0) {	echo "<tr bgcolor=\"#b0c4de\">"; } else { echo "<tr bgcolor=\"#d3d3d3\">"; }
	if($islemci == "") { $islemci = "Belirtilmemiş"; }
	echo "<td>".$islemci."</td>";
	echo "<td>".$islem."</td>";
	echo "<td>".$zaman."</td>";
	echo "<td>".$gorev[$tur]."</td>";
	echo "</tr>";
	$counter++;
	}
	echo "</table>";
		//  ZAMAN ICIN ARAMA SONU
	break;
	
	case 'kayit':
		//  KAYITLARDAKI ARAMA
	$araSQL		= mysql_query("SELECT islemci,islem,zaman,tur FROM w3_log WHERE islem LIKE '%".$ifade."%'");
	while(list($islemci,$islem,$zaman,$tur) = mysql_fetch_array($araSQL)) {
	if($counter % 2 == 0) {	echo "<tr bgcolor=\"#b0c4de\">"; } else { echo "<tr bgcolor=\"#d3d3d3\">"; }
	if($islemci == "") { $islemci = "Belirtilmemiş"; }
	echo "<td>".$islemci."</td>";
	echo "<td>".$islem."</td>";
	echo "<td>".$zaman."</td>";
	echo "<td>".$gorev[$tur]."</td>";
	echo "</tr>";
	$counter++;
	}
	echo "</table>";
		//  KAYITLARDAKI ARAMA SONU
	break;
	
	case 'kullanici':
		//  KULLANICI ICIN ARAMA
	if($ifade == 0) { 
	$araSQL		= mysql_query("SELECT islemci,islem,zaman,tur FROM w3_log ");
	} else {
	$araSQL		= mysql_query("SELECT islemci,islem,zaman,tur FROM w3_log WHERE islemci ='".$ifade."'");
	}
	while(list($islemci,$islem,$zaman,$tur) = mysql_fetch_array($araSQL)) {
	if($counter % 2 == 0) {	echo "<tr bgcolor=\"#b0c4de\">"; } else { echo "<tr bgcolor=\"#d3d3d3\">"; }
	if($islemci == "") { $islemci = "Belirtilmemiş"; }
	echo "<td>".$islemci."</td>";
	echo "<td>".$islem."</td>";
	echo "<td>".$zaman."</td>";
	echo "<td>".$gorev[$tur]."</td>";
	echo "</tr>";
	$counter++;
	}
	echo "</table>";
		//  KULLANICI ICIN ARAMA SONU
	break;
	}
		// TUR SWITCH SONU
		// ARAMA ISLEMI SONU
} else {
		// ARAMA FORMU
	echo 	"<form name=\"w3arama\" action=\"?islem=ara\" method=\"POST\">";
	echo 	"<b>Aranacak İfadeyi Giriniz</b><br><br>";
	echo 	"<input type=\"text\" id=\"ifade\" name=\"ifade\"><br><br>";
	echo 	"Kullanici<input type=\"radio\" id=\"tur\" name=\"tur\" value=\"kullanici\" checked=\"checked\">";
	echo 	"Kayit<input type=\"radio\" id=\"tur\" name=\"tur\" value=\"kayit\">";
	echo 	"Zaman<input type=\"radio\" id=\"tur\" name=\"tur\" value=\"zaman\">";
	echo	"<br><br><img src=\"images/arama.gif\" border=\"0\" onClick=\"ara()\">";
	echo 	"</form>";
		// ARAMA FORMU SONU
}
?>
<br>
<hr width="50%">
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
</body>
</html>
