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
if (($ewCurSec & ewAllowsearch) <> ewAllowsearch) header("Location: uyelerlist.php");
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

//get action
$a = @$_POST["a"];
switch ($a) {
	case "S": // arama kriteri

	//  detayli arama
	$search_criteria = "";

	// field "uye_id"
	$x_uye_id = @$_POST["x_uye_id"];
	$z_uye_id = @$_POST["z_uye_id"];
	if (is_array($x_uye_id)) $x_uye_id = implode(",", $x_uye_id);
	$x_uye_id = (get_magic_quotes_gpc() ? stripslashes($x_uye_id) : $x_uye_id);
	$z_uye_id = implode(",", $z_uye_id);
	$z_uye_id = (get_magic_quotes_gpc() ? stripslashes($z_uye_id) : $z_uye_id);
	if ($x_uye_id <> "") {
		$srchFld = $x_uye_id;
		$this_search_criteria = "x_uye_id=" . urlencode($srchFld);
		$this_search_criteria .= "&z_uye_id=" . urlencode($z_uye_id);
	} else {
		$this_search_criteria = "";
	}
	if ($this_search_criteria <> "" ) {
		if ($search_criteria == "") {
			$search_criteria = $this_search_criteria;
		} else {
			$search_criteria .= "&" . $this_search_criteria;
		}
	}

	// field "uye_ad"
	$x_uye_ad = @$_POST["x_uye_ad"];
	$z_uye_ad = @$_POST["z_uye_ad"];
	if (is_array($x_uye_ad)) $x_uye_ad = implode(",", $x_uye_ad);
	$x_uye_ad = (get_magic_quotes_gpc() ? stripslashes($x_uye_ad) : $x_uye_ad);
	$z_uye_ad = implode(",", $z_uye_ad);
	$z_uye_ad = (get_magic_quotes_gpc() ? stripslashes($z_uye_ad) : $z_uye_ad);
	if ($x_uye_ad <> "") {
		$srchFld = $x_uye_ad;
		$this_search_criteria = "x_uye_ad=" . urlencode($srchFld);
		$this_search_criteria .= "&z_uye_ad=" . urlencode($z_uye_ad);
	} else {
		$this_search_criteria = "";
	}
	if ($this_search_criteria <> "" ) {
		if ($search_criteria == "") {
			$search_criteria = $this_search_criteria;
		} else {
			$search_criteria .= "&" . $this_search_criteria;
		}
	}

	// field "uye_soyad"
	$x_uye_soyad = @$_POST["x_uye_soyad"];
	$z_uye_soyad = @$_POST["z_uye_soyad"];
	if (is_array($x_uye_soyad)) $x_uye_soyad = implode(",", $x_uye_soyad);
	$x_uye_soyad = (get_magic_quotes_gpc() ? stripslashes($x_uye_soyad) : $x_uye_soyad);
	$z_uye_soyad = implode(",", $z_uye_soyad);
	$z_uye_soyad = (get_magic_quotes_gpc() ? stripslashes($z_uye_soyad) : $z_uye_soyad);
	if ($x_uye_soyad <> "") {
		$srchFld = $x_uye_soyad;
		$this_search_criteria = "x_uye_soyad=" . urlencode($srchFld);
		$this_search_criteria .= "&z_uye_soyad=" . urlencode($z_uye_soyad);
	} else {
		$this_search_criteria = "";
	}
	if ($this_search_criteria <> "" ) {
		if ($search_criteria == "") {
			$search_criteria = $this_search_criteria;
		} else {
			$search_criteria .= "&" . $this_search_criteria;
		}
	}

	// field "eposta1"
	$x_eposta1 = @$_POST["x_eposta1"];
	$z_eposta1 = @$_POST["z_eposta1"];
	if (is_array($x_eposta1)) $x_eposta1 = implode(",", $x_eposta1);
	$x_eposta1 = (get_magic_quotes_gpc() ? stripslashes($x_eposta1) : $x_eposta1);
	$z_eposta1 = implode(",", $z_eposta1);
	$z_eposta1 = (get_magic_quotes_gpc() ? stripslashes($z_eposta1) : $z_eposta1);
	if ($x_eposta1 <> "") {
		$srchFld = $x_eposta1;
		$this_search_criteria = "x_eposta1=" . urlencode($srchFld);
		$this_search_criteria .= "&z_eposta1=" . urlencode($z_eposta1);
	} else {
		$this_search_criteria = "";
	}
	if ($this_search_criteria <> "" ) {
		if ($search_criteria == "") {
			$search_criteria = $this_search_criteria;
		} else {
			$search_criteria .= "&" . $this_search_criteria;
		}
	}

	// field "eposta2"
	$x_eposta2 = @$_POST["x_eposta2"];
	$z_eposta2 = @$_POST["z_eposta2"];
	if (is_array($x_eposta2)) $x_eposta2 = implode(",", $x_eposta2);
	$x_eposta2 = (get_magic_quotes_gpc() ? stripslashes($x_eposta2) : $x_eposta2);
	$z_eposta2 = implode(",", $z_eposta2);
	$z_eposta2 = (get_magic_quotes_gpc() ? stripslashes($z_eposta2) : $z_eposta2);
	if ($x_eposta2 <> "") {
		$srchFld = $x_eposta2;
		$this_search_criteria = "x_eposta2=" . urlencode($srchFld);
		$this_search_criteria .= "&z_eposta2=" . urlencode($z_eposta2);
	} else {
		$this_search_criteria = "";
	}
	if ($this_search_criteria <> "" ) {
		if ($search_criteria == "") {
			$search_criteria = $this_search_criteria;
		} else {
			$search_criteria .= "&" . $this_search_criteria;
		}
	}

	// field "alias"
	$x_alias = @$_POST["x_alias"];
	$z_alias = @$_POST["z_alias"];
	if (is_array($x_alias)) $x_alias = implode(",", $x_alias);
	$x_alias = (get_magic_quotes_gpc() ? stripslashes($x_alias) : $x_alias);
	$z_alias = implode(",", $z_alias);
	$z_alias = (get_magic_quotes_gpc() ? stripslashes($z_alias) : $z_alias);
	if ($x_alias <> "") {
		$srchFld = $x_alias;
		$this_search_criteria = "x_alias=" . urlencode($srchFld);
		$this_search_criteria .= "&z_alias=" . urlencode($z_alias);
	} else {
		$this_search_criteria = "";
	}
	if ($this_search_criteria <> "" ) {
		if ($search_criteria == "") {
			$search_criteria = $this_search_criteria;
		} else {
			$search_criteria .= "&" . $this_search_criteria;
		}
	}
		if ($search_criteria <> "") {
			header("Location: uyelerlist.php" . "?" . $search_criteria);
		}
		break;
}

// baglanti hazirlaniyor...
$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB);
?>
<?php include ("header.php") ?>
<p><br><br><a href="uyelerlist.php">Listeye Dön</a></a></p>
<script language="JavaScript" src="ew.js"></script>
<script language="JavaScript">
<!-- start Javascript
function  EW_checkMyForm(EW_this) {
if (EW_this.x_uye_id && !EW_checkinteger(EW_this.x_uye_id.value)) {
        if (!EW_onError(EW_this, EW_this.x_uye_id, "TEXT", "Incorrect integer - uye id"))
            return false; 
        }
if (EW_this.x_eposta1 && !EW_checkemail(EW_this.x_eposta1.value)) {
        if (!EW_onError(EW_this, EW_this.x_eposta1, "TEXT", "Geçersiz e-posta adresi!"))
            return false; 
        }
if (EW_this.x_eposta2 && !EW_checkemail(EW_this.x_eposta2.value)) {
        if (!EW_onError(EW_this, EW_this.x_eposta2, "TEXT", "Geçersiz e-posta adresi!"))
            return false; 
        }
return true;
}

// end JavaScript -->
</script>
<form onSubmit="return EW_checkMyForm(this);"  action="uyelersrch.php" method="post">
<p>
<input type="hidden" name="a" value="S">
<table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">uye id&nbsp;</td>
<td bgcolor="#F5F5F5">
<input type="hidden" name="z_uye_id[]" value="=,,">=
&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_uye_id" size="30" value="<?php echo htmlspecialchars(@$x_uye_id); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">uye ad&nbsp;</td>
<td bgcolor="#F5F5F5">
<input type="hidden" name="z_uye_ad[]" value="LIKE,'%,%'">benzer
&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_uye_ad" size="30" maxlength="99" value="<?php echo htmlspecialchars(@$x_uye_ad); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">uye soyad&nbsp;</td>
<td bgcolor="#F5F5F5">
<input type="hidden" name="z_uye_soyad[]" value="LIKE,'%,%'">benzer
&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_uye_soyad" size="30" maxlength="99" value="<?php echo htmlspecialchars(@$x_uye_soyad); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">eposta 1&nbsp;</td>
<td bgcolor="#F5F5F5">
<input type="hidden" name="z_eposta1[]" value="LIKE,'%,%'">benzer
&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_eposta1" size="30" maxlength="255" value="<?php echo htmlspecialchars(@$x_eposta1); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">eposta 2&nbsp;</td>
<td bgcolor="#F5F5F5">
<input type="hidden" name="z_eposta2[]" value="LIKE,'%,%'">benzer
&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_eposta2" size="30" maxlength="255" value="<?php echo htmlspecialchars(@$x_eposta2); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">alias&nbsp;</td>
<td bgcolor="#F5F5F5">
<input type="hidden" name="z_alias[]" value="LIKE,'%,%'">benzer
&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_alias" size="30" maxlength="100" value="<?php echo htmlspecialchars(@$x_alias); ?>">&nbsp;</td>
</tr>
</table>
<p>
<input type="submit" name="Action" value="Ara">
</form>
<?php include ("footer.php") ?>
<?php
mysql_close($conn);
?>
