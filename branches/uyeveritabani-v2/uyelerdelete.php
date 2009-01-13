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
$ew_SecTable[0] = 12;
$ew_SecTable[1] = 13;
$ew_SecTable[2] = 8;
$ew_SecTable[3] = 15;

// tablo haklari
$ewCurSec = 0; // baslangic Sec degeri
$ewCurIdx = intval(@$_SESSION["uy_status_UserLevel"]);
if ($ewCurIdx == -1) { //
	$ewCurSec = 31;
} elseif ($ewCurIdx > 0 && $ewCurIdx <= 4) {
	$ewCurSec = $ew_SecTable[$ewCurIdx-1];
}
if (($ewCurSec & ewAllowdelete) <> ewAllowdelete) header("Location: uyelerlist.php");
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
	header("Location: uyelerlist.php");
}
$sqlKey = "id=" . "" . $key . "";

// get action
$a = @$_POST["a"];
if (empty($a)) {
	$a = "I";	// display
}

// baglanti hazirlaniyor...
$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB, $conn);
mysql_query("SET NAMES 'utf8'", $conn);
switch ($a)
{
	case "I": // display
		$strsql = "SELECT * FROM uyeler WHERE " . $sqlKey;
    if (@$_SESSION["uy_status_UserLevel"] <> -1) {  // yonetici degil!
			$strsql = $strsql . " AND (uye_id = " . @$_SESSION["uy_status_UserID"] . ")";
    }
		$rs = mysql_query($strsql, $conn) or die(mysql_error());
		if (mysql_num_rows($rs) == 0) {
			ob_end_clean();
			header("Location: uyelerlist.php");
		}
		break;
	case "D": // delete
		// alias icin kaydi silmeden bir alias'i alalim - dfisek - hizli/kirli cozum
		$strsql = "SELECT alias FROM uyeler WHERE " . $sqlKey;
		if (@$_SESSION["uy_status_UserLevel"] <> -1) { // yonetici degil!
			$strsql = $strsql . " AND (uye_id = " . @$_SESSION["uy_status_UserID"] . ")";
		}
		$rs = mysql_query($strsql, $conn) or die(mysql_error());
		$row = mysql_fetch_array($rs);
		
		// Uye baska tabloya aliniyor - LKD - YK Istegi (19.10.2006)
#		$sorgu = "INSERT INTO silinmis_uyeler "
		$sorgu = "INSERT INTO silinen_uyeler "
			." SELECT *,'". trim(addslashes($_POST["neden"])) ."',NOW() FROM uyeler WHERE $sqlKey";
		mysql_query($sorgu, $conn) or die(mysql_error());
		
		// uye kaydini silelim
		$strsql = "DELETE FROM uyeler WHERE " . $sqlKey;
		if (@$_SESSION["uy_status_UserLevel"] <> -1) { // yonetici degil!
			$strsql = $strsql . " AND (uye_id = " . @$_SESSION["uy_status_UserID"] . ")";
		}
		$rs =	mysql_query($strsql, $conn) or die(mysql_error());
		mysql_close($conn);
		
		// alias'ini da alias tablosundan silmeli - dfisek - hizli/kirli cozum
		$alias = $row[alias] . '@linux.org.tr';
                $conn_mail = mysql_connect(HOST_MAIL, USER_MAIL, PASS_MAIL);
		mysql_select_db(DB_MAIL, $conn_mail);
                mysql_query("SET NAMES 'utf8'", $conn_mail);
		$strsql = "DELETE FROM forwardings WHERE source = '$alias'";
		$rs = mysql_query($strsql, $conn_mail) or die(mysql_error());		
		mysql_close($conn_mail);
		
		ob_end_clean();
		header("Location: uyelerlist.php");
		break;
}
?>
<?php include ("header.php") ?>
<p><br><br><a href="uyelerlist.php">Listeye Dön</a></p>
<form action="uyelerdelete.php" method="post">
<p>
<input type="hidden" name="a" value="D">
<input type="hidden" name="key" value="<?php echo $key; ?>">
<table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
<tr bgcolor="#466176">
<td><font color="#FFFFFF">uye id&nbsp;</td>
<td><font color="#FFFFFF">uye ad&nbsp;</td>
<td><font color="#FFFFFF">uye soyad&nbsp;</td>
<td><font color="#FFFFFF">eposta 1&nbsp;</td>
<td><font color="#FFFFFF">eposta 2&nbsp;</td>
<td><font color="#FFFFFF">alias&nbsp;</td>
<td><font color="#FFFFFF">sehir&nbsp;</td>
</tr>
<?php
$recCount = 0;
while ($row = mysql_fetch_array($rs)) {
	$recCount = $recCount++;
	$bgcolor = "#FFFFFF"; // tablolarin ilk row rengi
	if ($recCount % 2 <> 0 ) {
		$bgcolor="#F5F5F5"; // alternatif row rengi
	}
	$x_id = @$row["id"];
	$x_uye_id = @$row["uye_id"];
	$x_uye_ad = @$row["uye_ad"];
	$x_uye_soyad = @$row["uye_soyad"];
	$x_eposta1 = @$row["eposta1"];
	$x_eposta2 = @$row["eposta2"];
	$x_alias = @$row["alias"];
	$x_cinsiyet = @$row["cinsiyet"];
	$x_kurum = @$row["kurum"];
	$x_gorev = @$row["gorev"];
	$x_mezuniyet = @$row["mezuniyet"];
	$x_mezuniyet_yil = @$row["mezuniyet_yil"];
	$x_mezuniyet_bolum = @$row["mezuniyet_bolum"];
	$x_is_addr = @$row["is_addr"];
	$x_semt = @$row["semt"];
	$x_sehir = @$row["sehir"];
	$x_pkod = @$row["pkod"];
	$x_PassWord = @$row["PassWord"];
	$x_Resim = @$row["Resim"];
?>
<tr bgcolor="<?php echo $bgcolor; ?>">
<td>
<?php echo $x_uye_id; ?>&nbsp;
</td>
<td>
<?php echo $x_uye_ad; ?>&nbsp;
</td>
<td>
<?php echo $x_uye_soyad; ?>&nbsp;
</td>
<td>
<?php echo $x_eposta1; ?>&nbsp;
</td>
<td>
<?php echo $x_eposta2; ?>&nbsp;
</td>
<td>
<?php echo $x_alias; ?>&nbsp;
</td>
<td>
<?php echo $x_sehir; ?>&nbsp;
</td>
</tr>
<?php
}
mysql_free_result($rs);
mysql_close($conn);
?>
<tr bgcolor="<?php echo $bgcolor; ?>">
 <td colspan=2 align="right"><b>Silinme Nedeni</b></td>
 <td colspan=3 align="center"><textarea cols=45 name="neden"></textarea></td>
 <td colspan=2 align="center"><input type="submit" name="Action" value="Silmeyi Onaylayın"></td>
</table>
<p>
</form>
<?php include ("footer.php") ?>
