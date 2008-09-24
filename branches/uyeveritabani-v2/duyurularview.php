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
$key = @$_GET["key"];
if (empty($key)) {
	 $key = @$_POST["key"];
}
if (empty($key)) {
	// burayý deðiþtirdim
	// anahtar yoksa giriþte çaðrýlýyor demektir
	// $key i -1 yapýyorum
	//header("Location: duyurularlist.php");
	$key = -1;
}

// get action
$a = @$_POST["a"];
if (empty($a)) {
	$a = "I";	//display with input box
}

// baglanti hazirlaniyor...
$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB);
switch ($a)
{
	case "I": // gosterilecek bir kayit  var
		$tkey = "" . $key . "";
		if($key != -1) {
			$strsql = "SELECT * FROM duyurular WHERE DuyuruID=" . $tkey;
			$rs = mysql_query($strsql,$conn) or die(mysql_error());
			if (mysql_num_rows($rs) == 0 ) {
				header("Location:duyurularlist.php");
			}
		} else {
			$strsql = "SELECT * FROM duyurular ORDER BY DuyuruSonTarih DESC LIMIT 0,1";
                        $rs = mysql_query($strsql,$conn) or die(mysql_error());	
		}

		// degerleri ayir...
		$row = mysql_fetch_array($rs);
		$x_DuyuruID = @$row["DuyuruID"];
		$x_DuyuruBaslik = @$row["DuyuruBaslik"];
		$x_DuyuruOzet = @$row["DuyuruOzet"];
		$x_DuyuruText = @$row["DuyuruText"];
		$x_DuyuruTarih = @$row["DuyuruTarih"];
		$x_DuyuruSonTarih = @$row["DuyuruSonTarih"];
		$x_DuyuruAktif = @$row["DuyuruAktif"];
		$x_StatikSayfa = @$row["StatikSayfa"];
		$x_DuyuruTur = @$row["DuyuruTur"];
		mysql_free_result($rs);
		break;
}
?>
<?php include ("header.php") ?>
<p align="right"><br><br><a href="duyurularlist.php">Tüm Duyurularýn Listesi</a>&nbsp;&nbsp;</p>
<p>
<form>
<table width="70%" border="0" align="center" cellpadding="4" cellspacing="1">
<tr>
<td class="flyoutHeading"><?php echo str_replace(chr(10), "<br>" ,@$x_DuyuruBaslik . "") ?></td>
</tr>
<tr>
  <td><?php
switch ($x_DuyuruTur) {
case "LKD Genel Kurul Raporu":
		echo "LKD Genel Kurul Raporu";
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
?></td>
  </tr>
<tr>
  <td><?php echo FormatDateTime($x_DuyuruTarih,7); ?></td>
  </tr>
<tr>
  <td><?php echo FormatDateTime($x_DuyuruSonTarih,7); ?></td>
  </tr>
<tr>
<td><BLOCKQUOTE><?php echo str_replace(chr(10), "<br>" ,@$x_DuyuruOzet . "") ?></BLOCKQUOTE></td>
</tr>
<tr>
<td><BLOCKQUOTE><?php echo str_replace(chr(10), "<br>" ,@$x_DuyuruText . "") ?></BLOCKQUOTE></td>
</tr>
<tr>
<td></td>
</tr>
<tr>
<td><?php if (!is_null($x_StatikSayfa)) { ?>
  <a href="uye_resimleri/<?php echo @$x_StatikSayfa; ?>" target="blank"><?php echo @$x_StatikSayfa; ?></a>
  <?php } ?></td>
</tr>
</table>
</form>
<p>
<?php include ("footer.php") ?>
