<?php

// Sayfayi Include edenlerin olasi Uye_Id aktarimlarini yakala
if( $_GET["x_uye_id"] ) 
	$x_UyeId = $_GET["x_uye_id"];
else if ( $_SESSION["uy_status_UserID"] )
	$x_UyeId = $_SESSION["uy_status_UserID"];
else if ( $_GET["IsimFilter"] )
	$x_UyeId = $_GET["IsimFilter"];
else 
	$x_UyeId = $_GET["key"];

if( $x_UyeId == "" )
	return;
	
$sql1 = "SELECT kayit_tarihi,ayrilma_tarihi,eposta1 FROM uyeler WHERE uye_id='".$x_UyeId."'";
$rs1 = mysql_query($sql1);
$row1 = @mysql_fetch_array($rs1);
$x_EmailOfTheUser = $row1["eposta1"];
$KayitTarihi = $row1["kayit_tarihi"];
$AyrilmaTarihi = $row1["ayrilma_tarihi"];

// Yapilmis olmasi gereken toplam miktari aldiralim
if($AyrilmaTarihi)
 $strsql = "SELECT SUM(miktar) FROM aidat_miktar WHERE yil BETWEEN '". $KayitTarihi ."' AND '". $AyrilmaTarihi . "'";
else
 $strsql = "SELECT SUM(miktar) FROM aidat_miktar WHERE yil >= '". $KayitTarihi ."'";
$rs = mysql_query($strsql);
$Gecici = @mysql_fetch_array($rs);
$Toplam = $Gecici[0];

// 2002 ve oncesinde dernekte giris aidati aliniyordu
if( $KayitTarihi <= 2002 )
	$Toplam += 5; // YTL

if( $Toplam > $x_AidatToplam) {
?>
<form method="post">
<table align="center" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
<tr><td colspan="2" align="center"><h2>Yapmadığınız Ödemeleriniz Var!</h2></td></tr>
<tr bgcolor="#466176">
<td><b><font color="#ffffff">Yapılmış Olması Gereken Ödemeler Toplamı</font></b></td>
<td><b><font color="#ffffff">Şimdiye Kadar Ödenen</font></b></td>
</tr>

<tr bgcolor="<?php echo $bgcolor; ?>">
  <td>
   <?php 
   echo "<a target=\"_blank\" href=\"aidat_dokumu.php?tarih=$KayitTarihi\">". FormatCurrency($Toplam,0,-2,-2,-2) ."</a>"; 
   ?>
  </td>
 <td><?php echo FormatCurrency($x_AidatToplam,0,-2,-2,-2); ?></td>
</tr>
 
<tr><td align="right"><b>Yapmanız Gereken Toplam Aidat Ödemesi :</b></td><td><?php echo FormatCurrency($Toplam-$x_AidatToplam,0,-2,-2,-2);?></td></tr>
</table>
</form>
<?php } else { // Ödemeler tamam ise ?>
<table align="center" width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
<tr><td colspan="2" align="center"><h2>Yapmadığınız Ödeme Bulunmuyor</h2></td></tr>
</table>

<? } ?>