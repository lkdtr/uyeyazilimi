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
if (($ewCurSec & ewAllowdelete) <> ewAllowdelete) header("Location: bildirilerlist.php");
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

// single delete record
$key = @$_GET["key"];
if (empty($key)) {
	$key = @$_POST["key"];
}
if (empty($key)) {
	header("Location: bildirilerlist.php");
}
$sqlKey = "BildiriID=" . "" . $key . "";

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
		$strsql = "SELECT * FROM bildiriler WHERE " . $sqlKey;
		$rs = mysql_query($strsql, $conn) or die(mysql_error());
		if (mysql_num_rows($rs) == 0) {
			ob_end_clean();
			header("Location: bildirilerlist.php");
		}
		break;
	case "D": // delete
		$strsql = "DELETE FROM bildiriler WHERE " . $sqlKey;
		$rs =	mysql_query($strsql) or die(mysql_error());
		mysql_close($conn);
		ob_end_clean();
		header("Location: bildirilerlist.php");
		break;
}
?>
<?php include ("header.php") ?>
<p><br><br><a href="bildirilerlist.php">Listeye Dön</a></p>
<form action="bildirilerdelete.php" method="post">
<p>
<input type="hidden" name="a" value="D">
<input type="hidden" name="key" value="<?php echo $key; ?>">
<table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
<tr bgcolor="#466176">
<td><font color="#FFFFFF">Bildiri Baslik&nbsp;</td>
<td><font color="#FFFFFF">Bildiri Tarih&nbsp;</td>
<td><font color="#FFFFFF">Bildiri Aktif&nbsp;</td>
<td><font color="#FFFFFF">Statik Sayfa&nbsp;</td>
<td><font color="#FFFFFF">Bildiri Tur&nbsp;</td>
</tr>
<?php
$recCount = 0;
while ($row = mysql_fetch_array($rs)) {
	$recCount = $recCount++;
	$bgcolor = "#FFFFFF"; // tablolarin ilk row rengi
	if ($recCount % 2 <> 0 ) {
		$bgcolor="#F5F5F5"; // alternatif row rengi
	}
	$x_BildiriID = @$row["BildiriID"];
	$x_BildiriBaslik = @$row["BildiriBaslik"];
	$x_BildiriText = @$row["BildiriText"];
	$x_BildiriTarih = @$row["BildiriTarih"];
	$x_BildiriAktif = @$row["BildiriAktif"];
	$x_StatikSayfa = @$row["StatikSayfa"];
	$x_BildiriURL = @$row["BildiriURL"];
	$x_BildiriTur = @$row["BildiriTur"];
?>
<tr bgcolor="<?php echo $bgcolor; ?>">
<td>
<?php echo trim($x_BildiriBaslik); ?>&nbsp;
</td>
<td>
<?php echo FormatDateTime($x_BildiriTarih,7); ?>&nbsp;
</td>
<td>
<?php
switch ($x_BildiriAktif) {
	case "Aktif":
		echo "Aktif";
		break;
	case "Pasif":
		echo "Pasif";
		break;
}
?>
&nbsp;
</td>
<td>
<?php echo $x_StatikSayfa; ?>&nbsp;
</td>
<td>
<?php
switch ($x_BildiriTur) {
case "LKD Bildirileri":
		echo "LKD Bildirileri";
		break;
case "Ortak Bildiriler":
		echo "Ortak Bildiriler";
		break;
case "Diğer STK Bildirileri":
		echo "Diğer STK Bildirileri";
		break;
}
?>
&nbsp;
</td>
</tr>
<?php
}
mysql_free_result($rs);
mysql_close($conn);
?>
</table>
<p>
<input type="submit" name="Action" value="Silmeyi Onaylayın">
</form>
<?php include ("footer.php") ?>