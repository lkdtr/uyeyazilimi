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
if (($ewCurSec & ewAllowdelete) <> ewAllowdelete) header("Location: odemelerlist.php");
?>
<?php if (@$_SESSION["uy_status_UserID"] == "" && @$_SESSION["uy_status_UserLevel"] <> -1 ) header("Location: login.php"); ?>
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

// single delete record
$key = @$_GET["key"];
if (empty($key)) {
	$key = @$_POST["key"];
}
if (empty($key)) {
	header("Location: odemelerlist.php");
}
$sqlKey = "id=" . "" . $key . "";

// get action
$a = @$_POST["a"];
if (empty($a)) {
	$a = "I";	// display
}

// baglanti hazirlaniyor...
$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB);
switch ($a)
{
	case "I": // display
		$strsql = "SELECT * FROM odemeler WHERE " . $sqlKey;
    if (@$_SESSION["uy_status_UserLevel"] <> -1) {  // yonetici degil!
			$strsql = $strsql . " AND (uye_id = " . @$_SESSION["uy_status_UserID"] . ")";
    }
		$rs = mysql_query($strsql, $conn) or die(mysql_error());
		if (mysql_num_rows($rs) == 0) {
			ob_end_clean();
			header("Location: odemelerlist.php");
		}
		break;
	case "D": // delete
		$strsql = "DELETE FROM odemeler WHERE " . $sqlKey;
		if (@$_SESSION["uy_status_UserLevel"] <> -1) { // yonetici degil!
			$strsql = $strsql . " AND (uye_id = " . @$_SESSION["uy_status_UserID"] . ")";
		}
		$rs =	mysql_query($strsql) or die(mysql_error());
		mysql_close($conn);
		ob_end_clean();
		header("Location: odemelerlist.php");
		break;
}
?>
<?php include ("header.php") ?>
<p><br><br><a href="odemelerlist.php">Listeye Dön</a></p>
<form action="odemelerdelete.php" method="post">
<p>
<input type="hidden" name="a" value="D">
<input type="hidden" name="key" value="<?php echo $key; ?>">
<table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
<tr bgcolor="#466176">
<td><font color="#FFFFFF">uye id&nbsp;</td>
<td><font color="#FFFFFF">miktar&nbsp;</td>
<td><font color="#FFFFFF">tur&nbsp;</td>
<td><font color="#FFFFFF">tarih&nbsp;</td>
</tr>
<?php
$recCount = 0;
while ($row = mysql_fetch_array($rs)) {
	$recCount = $recCount++;	
	$bgcolor = "#FFFFFF"; // tablolarin ilk row rengi
	if ($recCount % 2 <> 0 ) {
		$bgcolor="#F5F5F5"; // alternatif row rengi
	}
	$x_uye_id = @$row["uye_id"];
	$x_miktar = @$row["miktar"];
	$x_tur = @$row["tur"];
	$x_id = @$row["id"];
	$x_tarih = @$row["tarih"];
	$x_notlar = @$row["notlar"];
	$x_odemeyolu = @$row["odemeyolu"];
	$x_makbuz = @$row["makbuz"];
?>
<tr bgcolor="<?php echo $bgcolor; ?>">
<td>
<?php
if (!is_null($x_uye_id)) {
	$sqlwrk = "SELECT * FROM uyeler";
	$sqlwrk .= " WHERE uye_id = " . $x_uye_id;
	$rswrk = mysql_query($sqlwrk);
	if ($rswrk && $rowwrk = mysql_fetch_array($rswrk)) {
		echo $rowwrk["eposta1"];
	}
	@mysql_free_result($rswrk);
}
?>
&nbsp;
</td>
<td>
<div align="right"><?php echo (is_numeric($x_miktar)) ? FormatCurrency($x_miktar,0,-2,-2,-2) : $x_miktar; ?></div>&nbsp;
</td>
<td>
<?php
switch ($x_tur) {
	case "aidat":
		echo "Üye Aidatý";
		break;
	case "bagis":
		echo "Baðýþ";
		break;
	case "diger":
		echo "Diðer";
		break;
}
?>
&nbsp;
</td>
<td>
<?php echo FormatDateTime($x_tarih,7); ?>&nbsp;
</td>
</tr>
<?php
}
mysql_free_result($rs);
mysql_close($conn);
?>
</table>
<p>
<input type="submit" name="Action" value="Silmeyi Onaylayýn">
</form>
<?php include ("footer.php") ?>
