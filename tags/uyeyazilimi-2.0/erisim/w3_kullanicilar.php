<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<title>W3</title>
<link type="text/css" rel="stylesheet" href="w3.css">
<script type="text/javascript">
function onay (wid,id) {
if(confirm(" Bu kullanici bu W3'ten silinecek !! \n  Devam etmek istediginizden Emin misiniz ?")) {
	document.location = 'w3_kullanicilar.php?islem=sil&wid='+wid+'&uid='+id;
} else {
	return false;
}
}
</script>
</head><body>
<br><br><hr width="50%"><div align="center"><a href="w3_listele.php"><img src="images/lkdw3.gif" border="0" alt="Banner"></a></div><hr width="50%">
<div align="center">
<?php
require_once 'w3_baglanti.php';     
// KULLANICI LISTELEME ISLEMLERI
$sorgu			= mysql_query('SELECT uyeler.uye_id,uyeler.uye_ad,uyeler.uye_soyad FROM
w3_erisim ,uyeler WHERE w3_erisim.w3_id='.$_GET['wid'].' AND w3_erisim.uye_id = uyeler.uye_id');
$yer			= mysql_query('SELECT w3.w3_isim FROM w3 WHERE w3.w3_id='.$_GET['wid']);
$my				= mysql_result($yer,0); 
switch($_GET['islem']) {
	default:	
if(mysql_num_rows($sorgu) == 0)
{
	echo "<hr width=\"50%\"><font face='verdana' size='2' color='red'><b>Kayit Bulunamadi !</b></font><hr width=\"50%\">\n";
} else {
	echo "<div align=\"center\"><font face=\"Tahoma\" color=\"red\" size=\"3\">Islem Yapilan Bolum : <b>".$my."</b></font></div>";
	echo "<table border='0' cellpadding=\"5\" cellspacing=\"3\">\n";
	echo "<tr bgcolor=\"#c2c2c2\">\n";
	echo "<td>#</td>\n";
	echo "<td>Isim</td>\n";
	echo "<td>Soyad</td>\n";
	echo "<td>Sil</td>\n";
	echo "</tr>\n";
while(list($id,$isim,$soyad) = mysql_fetch_array($sorgu))
{
	if($counter % 2 == 0) {	echo "<tr bgcolor=\"#b0c4de\">\n"; } else { echo "<tr bgcolor=\"#d3d3d3\">\n"; }
	echo "<td>".$id."</td>\n";
	echo "<td>".$isim."</td>\n";
	echo "<td>".$soyad."</td>\n";
	echo "<td><img src=\"images/sil.gif\" style=\"border:0\" onClick=\"onay(".$_GET['wid'].",".$id.");\" alt=\"sil\"></td>\n";
	echo "</tr>\n";
	$counter++;	
}
echo "</table><hr width=\"50%\">";
}
// YENI KULLANICI KAYIT FORMU
	$sorgu		= mysql_query('SELECT uyeler.uye_id,uyeler.uye_ad,uyeler.uye_soyad FROM uyeler');
	echo "<form name='kullaniciEkle' action=\"w3_kullanicilar.php?islem=kaydet&amp;wid=".$_GET['wid']."\" method='POST'>";
	echo "<font face='verdana' size='2' color='green'><b>Yeni Kullanici Ekle:</b></font><br>";
	echo "<select name='w3ekle'>";
	while(list($id,$ad,$soyad) = mysql_fetch_array($sorgu)) {
		echo "<option value='".$id."'>".$ad." ".$soyad."</option>\n";
	}
	echo "</select>";
	echo "<img src='images/ekle.gif' border='0' onClick='javascript:document.kullaniciEkle.submit()' alt=\"gonder\">";
	echo "</form><hr width=\"50%\">";
	break;
// YENI KULLANICI KAYIT ISLEMI
	case 'kaydet':
if($_POST['w3ekle'] != "" &&  $_GET['wid'] != "") {
	$sqldenetle	= mysql_query("SELECT w3_erisim.w3_id FROM w3_erisim WHERE w3_erisim.uye_id =".$_POST['w3ekle']." AND w3_erisim.w3_id=".$_GET['wid']);
	if(mysql_num_rows($sqldenetle) != 0) {
		echo "<script>alert('Bu kullanici veritabanında mevcut!'); document.location='w3_kullanicilar.php?wid=".$_GET['wid']."'</script>";
		exit();
	}
	$yeniSorgu	= mysql_query("INSERT INTO w3_erisim (w3_id,uye_id)  VALUES ('".$_GET['wid']."','".$_POST['w3ekle']."')");
	$kimSorgu	= mysql_query("SELECT uyeler.uye_ad,uyeler.uye_soyad,w3.w3_isim FROM uyeler,w3 WHERE uyeler.uye_id='".$_POST['w3ekle']."' and w3.w3_id=".$_GET['wid']);
	while(list($ad,$soyad,$w3) = mysql_fetch_array($kimSorgu)) {
		$islem	= "<b>".$ad." ".$soyad."</b> kullanicisi <b>".$w3."</b> alanına eklendi.";
	}
	$log		= mysql_query("INSERT INTO w3_log (`islemci`,`islem`,`zaman`,`tur`) VALUES ('".$_SERVER['REMOTE_USER']."','".$islem."',NOW(),0)");
	if(!$yeniSorgu || !$log)
	{
		echo mysql_error()."<br><hr width=\"50%\">";
	} else {
		echo "<script>alert('Kullanici basariyla eklendi'); document.location='w3_kullanicilar.php?wid=".$_GET['wid']."'</script>";
	}
}
	break;
// KULLANICI SILME ISLEMLERI
	case 'sil':
if($_GET['wid'] != "" && $_GET['uid'] != "") {
	$sorguSil	= mysql_query('DELETE FROM w3_erisim WHERE w3_erisim.w3_id='.$_GET['wid'].' AND w3_erisim.uye_id ='.$_GET['uid']);
	$kimSorgu	= mysql_query("SELECT uyeler.uye_ad,uyeler.uye_soyad,w3.w3_isim FROM uyeler,w3 WHERE uyeler.uye_id='".$_GET['uid']."' and w3.w3_id=".$_GET['wid']);
	while(list($ad,$soyad,$w3) = mysql_fetch_array($kimSorgu)) {
		$islem	= "<b>".$ad." ".$soyad."</b> kullanicisi <b>".$w3."</b>  alanından silindi.";
	}
	$log		= mysql_query("INSERT INTO w3_log (`islemci`,`islem`,`zaman`,`tur`) VALUES ('".$_SERVER['REMOTE_USER']."','".$islem."',NOW(),1)");
	if(!$sorguSil || !$log) {
		echo mysql_error();
	} else {
		echo "<script>alert('Kullanici basariyla silindi'); document.location='w3_kullanicilar.php?wid=".$_GET['wid']."'</script>";
	}
}
	break;
}
?>
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
