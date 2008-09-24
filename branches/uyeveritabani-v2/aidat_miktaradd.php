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
if (($ewCurSec & ewAllowadd) <> ewAllowadd) header("Location: aidat_miktarlist.php");
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

// get action
$a = @$_POST["a"];
if (empty($a)) {
	$key = @$_GET["key"];
	if ($key <> "")	{
		$a = "C"; // kayit klonlama olayi
	} else{
		$a = "I"; // bos kayit goster
	}
}

// baglanti hazirlaniyor...
$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB);
switch ($a) {
	case "C": // gosterilecek bir kayit  var
		$tkey = "" . $key . "";
		$strsql = "SELECT * FROM aidat_miktar WHERE aidat_id=" . $tkey;
		$rs = mysql_query($strsql);
		if (mysql_num_rows($rs) == 0) {
			ob_end_clean();
			header("Location: aidat_miktarlist.php");
		} else {
			$row = mysql_fetch_array($rs);

		// degerleri ayir...
			$x_yil = @$row["yil"];
			$x_miktar = @$row["miktar"];
		}
		mysql_free_result($rs);
		break;
	case "A": // ekleme

		// form degerleri...
		$x_aidat_id = @$_POST["x_aidat_id"];
		$x_yil = @$_POST["x_yil"];
		$x_miktar = @$_POST["x_miktar"];

		// degerleri array'e atalim

		// yil
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_yil) : $x_yil;
		$theValue = ($theValue != "") ? intval($theValue) : "NULL";
		$fieldList["yil"] = $theValue;

		// miktar
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_miktar) : $x_miktar;
		$theValue = ($theValue != "") ? intval($theValue) : "NULL";
		$fieldList["miktar"] = $theValue;

		// vt ye yazma zamani
		$strsql = "INSERT INTO aidat_miktar (";
		$strsql .= implode(",", array_keys($fieldList));
		$strsql .= ") VALUES (";
		$strsql .= implode(",", array_values($fieldList));
		$strsql .= ")";
	 	mysql_query($strsql, $conn) or die(mysql_error());
		mysql_close($conn);
		ob_end_clean();
		header("Location: aidat_miktarlist.php");
		break;
}
?>
<?php include ("header.php") ?>
<p><br><br><a href="aidat_miktarlist.php">Listeye Dön</a></p>
<script language="JavaScript" src="ew.js"></script>
<script language="JavaScript">
<!-- start Javascript
function  EW_checkMyForm(EW_this) {
if (EW_this.x_yil && !EW_hasValue(EW_this.x_yil, "TEXT" )) {
            if (!EW_onError(EW_this, EW_this.x_yil, "TEXT", "Geçersiz Bir Yýl Girdiniz!"))
                return false;
        }
if (EW_this.x_yil && !EW_checkinteger(EW_this.x_yil.value)) {
        if (!EW_onError(EW_this, EW_this.x_yil, "TEXT", "Geçersiz Bir Yýl Girdiniz!"))
            return false;
        }
if (EW_this.x_miktar && !EW_hasValue(EW_this.x_miktar, "TEXT" )) {
            if (!EW_onError(EW_this, EW_this.x_miktar, "TEXT", "Miktar Girmediniz veya Geçersiz Bir Miktar Girdiniz."))
                return false;
        }
if (EW_this.x_miktar && !EW_checkinteger(EW_this.x_miktar.value)) {
        if (!EW_onError(EW_this, EW_this.x_miktar, "TEXT", "Miktar Girmediniz veya Geçersiz Bir Miktar Girdiniz."))
            return false;
        }
return true;
}

// end JavaScript -->
</script>
<form onSubmit="return EW_checkMyForm(this);"  action="aidat_miktaradd.php" method="post">
<p>
<input type="hidden" name="a" value="A">
<table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">aidat id&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="hidden" name="x_aidat_id" value="<?php echo htmlspecialchars(@$x_aidat_id); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">yil&nbsp;</td>
<td bgcolor="#F5F5F5"><?php if (empty($x_yil)) { $x_yil = 0; } // varsayilan degeri belirle... ?><input type="text" name="x_yil" size="10" maxlength="4" value="<?php echo htmlspecialchars(@$x_yil); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">miktar&nbsp;</td>
<td bgcolor="#F5F5F5"><?php if (empty($x_miktar)) { $x_miktar = 0; } // varsayilan degeri belirle... ?><input type="text" name="x_miktar" size="30" value="<?php echo htmlspecialchars(@$x_miktar); ?>">&nbsp;</td>
</tr>
</table>
<p>
<input type="submit" name="Action" value="EKLE">
</form>
<?php include ("footer.php") ?>