<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<title>W3</title>
<link type="text/css" rel="stylesheet" href="w3.css">
<script type="text/javascript">
function openw3() {
	document.getElementById('w3ekle').style.display = 'block';
	document.forms[0].reset();
	document.getElementById('buton').value = "Ekle";
}
function editw3(isim,adres,dizin,wid) {
	document.getElementById('w3ekle').style.display = 'block';
	document.getElementById('isim').value = isim;
	document.getElementById('adres').value = adres;
	document.getElementById('dizin').value = dizin;
	document.getElementById('buton').value = "Kaydet";
	document.w3.action	= "w3_listele.php?islem=guncelle&wid="+wid;
}
function onay(id) {
if(confirm(" Bu W3'e ait erisim haklari da silinecek !! \n  Devam etmek istediginizden Emin misiniz ?")) {
	document.location = 'w3_listele.php?islem=sil&wid='+id
} else {
	return false;
}
}
</script>
</head><body>
<br><hr width="50%"><div align="center"><a href="w3_listele.php"><img src="images/lkdw3.gif" style="border:0" alt="lkdw3"></a></div><hr width="50%">
<div align="center">
<?php
require_once 'w3_baglanti.php';

$sorgu			= mysql_query('SELECT w3.w3_id,w3.w3_isim,w3.w3_www,w3.w3_fs FROM w3');
switch($_GET["islem"]) {
	default:
if(@mysql_num_rows($sorgu) == 0)
{
	echo "<hr width=\"50%\"><font face='verdana' size='2' color='red'><b>Lütfen Veritabanı bilgilerini kontrol ediniz. !</b></font><hr width=\"50%\">";
} else {
	echo "<table border='0' cellpadding=\"5\" cellspacing=\"3\">\n";
	echo "<tr bgcolor=\"#c2c2c2\">\n";
	echo "<td>#</td>\n";
	echo "<td>Isim</td>\n";
	echo "<td>Adres</td>\n";
	echo "<td>Dizin</td>\n";
	echo "<td>Incele</td>\n";
	echo "<td>Duzenle</td>\n";
	echo "<td>Sil</td>\n";
	echo "</tr>";
while(list($id,$isim,$www,$fs) = mysql_fetch_array($sorgu))
{
	if($counter % 2 == 0) {	echo "<tr bgcolor=\"#b0c4de\" onClick=\"getw3('".$id."');\">"; 
	} else { echo "<tr bgcolor=\"#d3d3d3\">"; }
	echo "<td>".$id."</td>";
	echo "<td>".$isim."</td>";
	if(preg_match('/http\:\/\//',$www)) {
	echo "<td><a href=\"".$www."\">".$www."</a></td>";
	} else {
	echo "<td>".$www."</td>";
	}
	echo "<td>".$fs."</td>";
	echo "<td align='center'><a href=\"w3_kullanicilar.php?wid=".$id."\"><img src=\"images/incele.gif\" style=\"border:0\" alt=\"incele\"></a></td>";
	echo "<td align=\"center\"><img src=\"images/duzenle.gif\" style=\"border:0\" onClick=\"editw3('".$isim."','".$www."','".$fs."','".$id."');\" alt=\"duzenle\"></td>\n";
	echo "<td><img src=\"images/sil.gif\" style=\"border:0\" onClick=\"onay(".$id.");\" alt=\"sil\"></td>\n";
	echo "</tr>";
	$counter++;
}
	echo "</table>";
}
	break;
	case 'yeniEkle':
if($_POST["w3kayit"] == "Ekle" && $_POST["isim"] != "" && $_POST["adres"] != "" && $_POST["dizin"] != "" )
{
	$ad			= htmlspecialchars($_POST["isim"]);
	$url		= htmlspecialchars($_POST["adres"]);
	$fs			= htmlspecialchars($_POST["dizin"]);
	$sorgu		= mysql_query("INSERT INTO w3 (w3_isim,w3_www,w3_fs) VALUES ('".$ad."','".$url."','".$fs."')");
	$islem		= "<b>".$ad."</b> W3 Eklendi. Adres : <b>".$url."</b> , Dizin : <b>".$fs."</b>";
	$log		= mysql_query("INSERT INTO w3_log (`islemci`,`islem`,`zaman`,`tur`) VALUES ('".$_SERVER['REMOTE_USER']."','".$islem."',NOW(),2)");
	if(!$sorgu || !$log) {
		echo "SQL hatası :<hr>".mysql_error();
	} else {
		 echo "<script>alert('W3 Basari ile eklendi.!');document.location = 'w3_listele.php'</script>";
	}
}
	break;
	case 'guncelle':
if($_POST["w3kayit"] == "Kaydet" && $_POST["isim"] != "" && $_POST["adres"] != "" && $_POST["dizin"] != "" && $_GET["wid"] != "" )
{
	$ad			= htmlspecialchars($_POST["isim"]);
	$url		= htmlspecialchars($_POST["adres"]);
	$fs			= htmlspecialchars($_POST["dizin"]);
	$sqlonceki	= mysql_query("SELECT w3.w3_isim,w3.w3_www,w3.w3_fs FROM w3  WHERE w3_id=".$_GET["wid"]);
	$sorgu		= mysql_query("UPDATE w3 SET w3_isim = '".$ad."', w3_www ='".$url."', w3_fs = '".$fs."' WHERE w3_id=".$_GET["wid"]);
	$sqlsonraki	= mysql_query("SELECT w3.w3_isim,w3.w3_www,w3.w3_fs FROM w3  WHERE w3_id=".$_GET["wid"]);
	while(list($ilk_isim,$ilk_www,$ilk_fs) = mysql_fetch_array($sqlonceki)) {
		$ilk	= array($ilk_isim,$ilk_www,$ilk_fs);
	}
	while(list($son_isim,$son_www,$son_fs) = mysql_fetch_array($sqlsonraki)) {
		$son	= array($son_isim,$son_www,$son_fs);
	}
	$islem		= '';
	for($a=0;$a<count($ilk);$a++){
		if($ilk[$a] != $son[$a]) { $islem .= "<b>".$ilk[$a]."</b> alanı <b>".$son[$a]."</b> olarak degistirildi.<br>"; }
	}
	if($islem ==  "") { $islem = "Herhangi bir degisiklik yapilmadi"; }
	$log		= mysql_query("INSERT INTO w3_log (`islemci`,`islem`,`zaman`,`tur`) VALUES ('".$_SERVER['REMOTE_USER']."','".$islem."',NOW(),4)");
	if(!$sorgu || !$log) {
		echo "SQL hatası :<hr>".mysql_error();
	} else {
		echo "<script>alert('W3 Basari ile duzenlendi!');document.location = 'w3_listele.php'</script>";
	}
}
	break;
	case 'sil':
// KULLANICI SILME ISLEMLERI
if($_GET['wid'] != "" ) {
	$wlog				= mysql_query('SELECT w3.w3_isim, w3_erisim.uye_id, uyeler.uye_ad, uyeler.uye_soyad	FROM w3, w3_erisim, uyeler 	WHERE w3.w3_id ='.$_GET['wid'].' AND w3_erisim.w3_id ='.$_GET['wid'].' AND w3_erisim.uye_id = uyeler.uye_id');
	if(!$wlog) {
		echo mysql_error();
		exit();
	}
	$widlog				= mysql_query('SELECT w3.w3_isim FROM w3 WHERE w3.w3_id='.$_GET['wid']);
	$sorguSil			= mysql_query('DELETE FROM w3 WHERE w3.w3_id='.$_GET['wid']);
	$sorguSilTamami     = mysql_query('DELETE FROM w3_erisim WHERE w3_erisim.w3_id='.$_GET['wid']);
	$islem				= "<b>".mysql_result($widlog,0). "</b> alanı kaldırılmıstır.";
	while(list($alan,$id,$ad,$soyad) = mysql_fetch_array($wlog)) {
		$islem			.= "<br><b>".$id."</b> IDli  <b>".$ad." ".$soyad."</b> kullanicisinin <b>".$alan."</b> alanina ait bilgileri silinmistir.";
	}
	$log				= mysql_query("INSERT INTO w3_log (`islemci`,`islem`,`zaman`,`tur`) VALUES ('".$_SERVER['REMOTE_USER']."','".$islem."',NOW(),3)");
	if(!$sorguSil || !$sorguSilTamami || !$log ) {
		echo mysql_error();
	} else {
		echo "<script>alert('W3 basariyla silindi'); document.location='w3_listele.php?wid=".$_GET['wid']."'</script>";
	}
}
	break;
}
?>
<img src="images/yeniw3.gif" alt="Yeni W3 ekle" onClick='openw3();' style="border:0" >
</div>
<div id='w3ekle' style='display:none;'>
<hr width="50%">
<table align="center">
<tr><td align="left">
<form name="w3" action="w3_listele.php?islem=yeniEkle" method="POST">
Adı	:<br>
<input id="isim" type="text" name="isim"><br>
Adres	: <br>
<input id="adres" type="text" name="adres"><br>
Dizin	: <br>
<input id="dizin" type="text" name="dizin"><br>
<input id="buton" type="submit" name="w3kayit" value="Ekle">
<input type="button" onclick="document.getElementById('w3ekle').style.display = 'none';" value="Kapat !">
</form>
</td></tr>
</table>
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
