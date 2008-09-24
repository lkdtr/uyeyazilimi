<?php
	/*
	 *  LKD Uye Veritabani
	 *  Copyright (C) 2004  R. Tolga KORKUNCKAYA (tolga@mavibilgisayar.com)
	 *
	 *  This program is free software; you can redistribute it and/or modify
	 *  it under the terms of the GNU General Public License as published by
	 *  the Free Software Foundation; either version 2 of the License, or
	 *  (at your option) any later version.
	 *
	 *  This program is distributed in the hope that it will be useful,
	 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
	 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 *  GNU Library General Public License for more details.
	 *
	 *  You should have received a copy of the GNU General Public License
	 *  along with this program; if not, write to the Free Software
	 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
	 */

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
	
$sql1 = "SELECT kayit_tarihi,eposta1 FROM uyeler WHERE uye_id='".$x_UyeId."'";
$rs1 = mysql_query($sql1);
$row1 = @mysql_fetch_array($rs1);
$x_EmailOfTheUser = $row1["eposta1"];
$KayitTarihi = $row1["kayit_tarihi"];

// Yapilmis olmasi gereken toplam miktari aldiralim
$strsql = "SELECT SUM(miktar) FROM aidat_miktar WHERE yil >= '". $KayitTarihi ."'";
$rs = mysql_query($strsql);
$Gecici = @mysql_fetch_array($rs);
$Toplam = $Gecici[0];

// 2002'den once gecerli olan bir tuzuk maddesi ile ilgili odeme
// Detaylar icin Doruk Fisek lutfen ;)
if( $KayitTarihi <= 2002 )
	$Toplam += 5; // YTL

//echo $strsql; // SQL cumlesini debug etmek icin commenti kaldirin
//$rs = mysql_query($strsql);
//$totalRecs = intval(@mysql_num_rows($rs));

//

if( $Toplam > $x_AidatToplam) {
?>
<form method="post">
<table align="center" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
<tr><td colspan="2" align="center"><h2>Yapmadýðýnýz Ödemeleriniz Var!</h2></td></tr>
<tr bgcolor="#466176">
<td><b><font color="#ffffff">Yapýlmýþ Olmasý Gereken Ödemeler Toplamý</font></b></td>
<td><b><font color="#ffffff">Þimdiye Kadar Ödenen</font></b></td>
</tr>

<tr bgcolor="<?php echo $bgcolor; ?>">
  <td>
   <?php 
   echo "<a target=\"_blank\" href=\"odemeler.php?tarih=$KayitTarihi\">". FormatCurrency($Toplam,0,-2,-2,-2) ."</a>"; 
   ?>
  </td>
 <td><?php echo FormatCurrency($x_AidatToplam,0,-2,-2,-2); ?></td>
</tr>
 
<tr><td align="right"><b>Yapmanýz Gereken Toplam Aidat Ödemesi :</b></td><td><?php echo FormatCurrency($Toplam-$x_AidatToplam,0,-2,-2,-2);?></td></tr>
</table>
</form>
<?php } else { // Ödemeler tamam ise ?>
<table align="center" width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
<tr><td colspan="2" align="center"><h2>Yapmadýðýnýz Ödeme Bulunmuyor</h2></td></tr>
</table>

<? } ?>
