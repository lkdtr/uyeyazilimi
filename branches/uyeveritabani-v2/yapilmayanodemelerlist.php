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
$ewCurSec = 0; // baslangic guvenlik degeri
$ewCurIdx = intval(@$_SESSION["uy_status_UserLevel"]);
if ($ewCurIdx == -1) { //
	$ewCurSec = 31;
} elseif ($ewCurIdx > 0 && $ewCurIdx <= 1) {
	$ewCurSec = $ew_SecTable[$ewCurIdx-1];
}
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
$displayRecs = 50;
$recRange = 10;
$dbwhere = "";
$masterdetailwhere = "";
$searchwhere = "";
$a_search = "";
$b_search = "";
$whereClause = "";

$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB);
// adamin kayit oldugu yýl seçiliyor
if(!isset($_GET["key"]))
	$x_UyeId = $_SESSION["uy_status_UserID"];
else
	$x_UyeId = $_GET["key"];
$sql = "SELECT kayit_tarihi FROM uyeler WHERE uye_id='".$x_UyeId."'";
$rs = mysql_query($sql);
$row = @mysql_fetch_array($rs);

$yapilmayan = array();
for($year=$row[0];$year<=date("Y");$year++) {
	// odeme yapmadýðý yýllar diziye atýlýyor
	$strsql = "SELECT count(*) FROM odemeler WHERE uye_id='".$x_UyeId."' AND tarih LIKE '".$year."%' AND tur='aidat'";
	$rs = mysql_query($strsql);
	$row1 = @mysql_fetch_array($rs);
	if($row1[0] == 0)
		$yapilmayan[] = $year;
}
if(count($yapilmayan) == 0)
	header("Location: duyurularview.php");	
//echo $strsql; // SQL cumlesini debug etmek icin commenti kaldirin
//$rs = mysql_query($strsql);
//$totalRecs = intval(@mysql_num_rows($rs));

//
?>
<?php include ("header.php") ?>
<form method="post">
<table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
<tr><td colspan="4" align="center"><b>Yapmadýðýnýz Ödemeleriniz Var!</b></td></tr>
<tr bgcolor="#466176">
<td>uye id</td>
<td>miktar</td>
<td>tur</td>
<td>tarih</td>
</tr>
<?php

$recActual = 0;
foreach($yapilmayan as $key => $val) {
	$recCount++;
	if ($recCount >= $startRec)	{
		$recActual++;
		$bgcolor = "#FFFFFF"; // tablolarin ilk row rengi
		if (($recCount % 2) <> 0)	{ // alternatif row rengi
			$bgcolor = "#F5F5F5";
		}

		/************************************************************/
		// --
		$key = @$row["id"];
		$x_uye_id = @$row["uye_id"];
		$x_miktar = 10000000;
		$x_tur = "aidat";
		$x_id = @$row["id"];
		$x_tarih = $val;
		$x_notlar = @$row["notlar"];
		$x_odemeyolu = @$row["odemeyolu"];
		$x_makbuz = @$row["makbuz"];
//		$x_miktar_toplam = $x_miktar++;
		/************************************************************/
?>
<tr bgcolor="<?php echo $bgcolor; ?>">
<td>
<?php
 echo $x_UyeId;
?>
&nbsp;</td>
<td><div align="right"><?php echo (is_numeric($x_miktar)) ? FormatCurrency($x_miktar,0,-2,-2,-2) : $x_miktar; ?></div>&nbsp;</td>
<td><?php
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
&nbsp;</td>
<td><?php echo $x_tarih; ?>&nbsp;</td>
</tr>
<?php
	}
}
?>
<tr><td colspan="3" align="right"><b>Toplam Yapmaniz Gereken Aidat Odemesi :</b></td><td><?php echo FormatCurrency((count($yapilmayan)*10000000),0,-2,-2,-2);?></td></tr>
</table>
</form>
<?php

// baglantiyi kes ve result bosalt
@mysql_free_result($rs);
mysql_close($conn);
?>
<?php include ("footer.php") ?>
