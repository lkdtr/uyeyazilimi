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
?>
<?php session_start(); ?>
<?php
define("DEFAULT_LOCALE", "tr_TR");
@setlocale(LC_ALL, DEFAULT_LOCALE);
?>
<?php if (@$_SESSION["uy_status"] <> "login") header("Location: login.php") ?>
<?php

// kullanici haklari
define("ewAllowAdd", 1, true);
define("ewAllowDelete", 2, true);
define("ewAllowEdit", 4, true);
define("ewAllowView", 8, true);
define("ewAllowList", 8, true);
define("ewAllowSearch", 8, true);
define("ewAllowAdmin", 16, true);
$ew_SecTable[0] = 8;

// tablo haklari
$ewCurSec = 0; // baslangic Sec degeri
$ewCurIdx = intval(@$_SESSION["uy_status_UserLevel"]);
if ($ewCurIdx == -1) { //
	$ewCurSec = 31;
} elseif ($ewCurIdx > 0 && $ewCurIdx <= 1) {
	$ewCurSec = $ew_SecTable[$ewCurIdx-1];
}
if (($ewCurSec & ewAllowview) <> ewAllowview) header("Location: duyurularlist.php");
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // gecmis zaman olurki
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // herdaim gunceliz
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php include ("db.php") ?>
<?php include ("ayar.php") ?>
<?php
ob_start();

// baglanti hazirlaniyor...
$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB);

// enson duyurular çekiliyor
$x_Limit = 3;
$strsql = "SELECT * FROM duyurular ORDER BY DuyuruID DESC LIMIT 0,$x_Limit";
$rs = mysql_query($strsql,$conn) or die(mysql_error());

		// degerleri ayir...
?>
<?php include ("header.php") ?>
<br><p>
<table width="96%" border="1" align="center" cellpadding="0" cellspacing="5" align="center">
<?php
// while im baþlangýcý
while($row = mysql_fetch_array($rs)) {
$x_DuyuruID = @$row["DuyuruID"];
$x_DuyuruBaslik = @$row["DuyuruBaslik"];
$x_DuyuruOzet = @$row["DuyuruOzet"];
$x_DuyuruText = @$row["DuyuruText"];
$x_DuyuruTarih = @$row["DuyuruTarih"];
$x_DuyuruSonTarih = @$row["DuyuruSonTarih"];
$x_DuyuruAktif = @$row["DuyuruAktif"];
$x_StatikSayfa = @$row["StatikSayfa"];
$x_DuyuruTur = @$row["DuyuruTur"];
?>
<td valign="top" width="33%" height="100%">
	<table border="0" cellspacing="0" cellpadding="2" height="100%" width="100%">
		<tr>
			<td bgcolor="#466176" height="35" width="100%">
				<font color="white"><?php echo str_replace(chr(10), "<br>" ,@$x_DuyuruBaslik . "") ?></font>
			</td>
		<tr>
			<td valign="top"><b>
<?php
switch ($x_DuyuruTur) {
case "LKD Uye Sistemi":
		echo "LKD Üye Sistemi";
		break;
case "LKD YK Çalýþma Raporu":
		echo "LKD YK Çalýþma Raporu";
		break;
case "Çalýþma Grubu Raporu":
		echo "Çalýþma Grubu Raporu";
		break;
case "LKD Genel Duyuru":
		echo "LKD Genel Duyuru";
		break;
case "Denetleme Kurulu Raporu":
		echo "Denetleme Kurulu Raporu";
		break;
case "Diðer Duyuru Konularý":
		echo "Diðer Duyuru Konularý";
		break;
}
?>
			</td>
		</tr>
		<tr>
			<td height="90%" valign="top">
				<?php echo str_replace(chr(10), "<br>" ,@$x_DuyuruOzet . "") ?>
		<tr>
			<td align="right">
				<hr>
				<a href="duyurularview.php?key=<?php echo $x_DuyuruID;?>">Devamý</a>&nbsp;
			</td>
		</tr>
	</table>
</td>
<?php
 }
 // while in bittiði biten yer
?>

</table>
<p>
<?php include ("footer.php") ?>
