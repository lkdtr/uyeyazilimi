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
if (($ewCurSec & ewAllowsearch) <> ewAllowsearch) header("Location: duyurularlist.php");
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

//get action
$a = @$_POST["a"];
switch ($a) {
	case "S": // arama kriteri

	//  detayli arama
	$search_criteria = "";

	// field "DuyuruBaslik"
	$x_DuyuruBaslik = @$_POST["x_DuyuruBaslik"];
	$z_DuyuruBaslik = @$_POST["z_DuyuruBaslik"];
	if (is_array($x_DuyuruBaslik)) $x_DuyuruBaslik = implode(",", $x_DuyuruBaslik);
	$x_DuyuruBaslik = (get_magic_quotes_gpc() ? stripslashes($x_DuyuruBaslik) : $x_DuyuruBaslik);
	$z_DuyuruBaslik = implode(",", $z_DuyuruBaslik);
	$z_DuyuruBaslik = (get_magic_quotes_gpc() ? stripslashes($z_DuyuruBaslik) : $z_DuyuruBaslik);
	if ($x_DuyuruBaslik <> "") {
		$srchFld = $x_DuyuruBaslik;
		$this_search_criteria = "x_DuyuruBaslik=" . urlencode($srchFld);
		$this_search_criteria .= "&z_DuyuruBaslik=" . urlencode($z_DuyuruBaslik);
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

	// field "DuyuruText"
	$x_DuyuruText = @$_POST["x_DuyuruText"];
	$z_DuyuruText = @$_POST["z_DuyuruText"];
	if (is_array($x_DuyuruText)) $x_DuyuruText = implode(",", $x_DuyuruText);
	$x_DuyuruText = (get_magic_quotes_gpc() ? stripslashes($x_DuyuruText) : $x_DuyuruText);
	$z_DuyuruText = implode(",", $z_DuyuruText);
	$z_DuyuruText = (get_magic_quotes_gpc() ? stripslashes($z_DuyuruText) : $z_DuyuruText);
	if ($x_DuyuruText <> "") {
		$srchFld = $x_DuyuruText;
		$this_search_criteria = "x_DuyuruText=" . urlencode($srchFld);
		$this_search_criteria .= "&z_DuyuruText=" . urlencode($z_DuyuruText);
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

	// field "DuyuruAktif"
	$x_DuyuruAktif = @$_POST["x_DuyuruAktif"];
	$z_DuyuruAktif = @$_POST["z_DuyuruAktif"];
	if (is_array($x_DuyuruAktif)) $x_DuyuruAktif = implode(",", $x_DuyuruAktif);
	$x_DuyuruAktif = (get_magic_quotes_gpc() ? stripslashes($x_DuyuruAktif) : $x_DuyuruAktif);
	$z_DuyuruAktif = implode(",", $z_DuyuruAktif);
	$z_DuyuruAktif = (get_magic_quotes_gpc() ? stripslashes($z_DuyuruAktif) : $z_DuyuruAktif);
	if ($x_DuyuruAktif <> "") {
		$srchFld = $x_DuyuruAktif;
		$this_search_criteria = "x_DuyuruAktif=" . urlencode($srchFld);
		$this_search_criteria .= "&z_DuyuruAktif=" . urlencode($z_DuyuruAktif);
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

	// field "DuyuruTur"
	$x_DuyuruTur = @$_POST["x_DuyuruTur"];
	$z_DuyuruTur = @$_POST["z_DuyuruTur"];
	if (is_array($x_DuyuruTur)) $x_DuyuruTur = implode(",", $x_DuyuruTur);
	$x_DuyuruTur = (get_magic_quotes_gpc() ? stripslashes($x_DuyuruTur) : $x_DuyuruTur);
	$z_DuyuruTur = implode(",", $z_DuyuruTur);
	$z_DuyuruTur = (get_magic_quotes_gpc() ? stripslashes($z_DuyuruTur) : $z_DuyuruTur);
	if ($x_DuyuruTur <> "") {
		$srchFld = $x_DuyuruTur;
		$this_search_criteria = "x_DuyuruTur=" . urlencode($srchFld);
		$this_search_criteria .= "&z_DuyuruTur=" . urlencode($z_DuyuruTur);
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
			header("Location: duyurularlist.php" . "?" . $search_criteria);
		}
		break;
}

// baglanti hazirlaniyor...
$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB);
?>
<?php include ("header.php") ?>
<p><br><br><a href="duyurularlist.php">Listeye Dön</a></a></p>
<script language="JavaScript" src="ew.js"></script>
<script language="JavaScript" src="popcalendar.js"></script>
<script language="JavaScript">
<!-- start Javascript
_editor_url = "";                     // URL to htmlarea files
var win_ie_ver = parseFloat(navigator.appVersion.split("MSIE")[1]);
if (navigator.userAgent.indexOf('Mac')        >= 0) { win_ie_ver = 0; }
if (navigator.userAgent.indexOf('Windows CE') >= 0) { win_ie_ver = 0; }
if (navigator.userAgent.indexOf('Opera')      >= 0) { win_ie_ver = 0; }
if (win_ie_ver >= 5.5) {
  document.write('<scr' + 'ipt src="' +_editor_url+ 'editor.js" language="JavaScript"></scr' + 'ipt>');
} else { document.write('<scr'+'ipt>function editor_generate() { return false; }</scr'+'ipt>'); }

// end JavaScript -->
</script>
<script language="JavaScript">
<!-- start Javascript
function  EW_checkMyForm(EW_this) {
return true;
}

// end JavaScript -->
</script>
<form onSubmit="return EW_checkMyForm(this);"  action="duyurularsrch.php" method="post">
<p>
<input type="hidden" name="a" value="S">
<table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Duyuru Baslik&nbsp;</td>
<td bgcolor="#F5F5F5">
<input type="hidden" name="z_DuyuruBaslik[]" value="LIKE,'%,%'">benzer
&nbsp;</td>
<td bgcolor="#F5F5F5"><textarea name="x_DuyuruBaslik" cols="50" rows="5"><?php echo @$x_DuyuruBaslik ?></textarea>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Duyuru Text&nbsp;</td>
<td bgcolor="#F5F5F5">
<input type="hidden" name="z_DuyuruText[]" value="LIKE,'%,%'">benzer
&nbsp;</td>
<td bgcolor="#F5F5F5"><textarea name="x_DuyuruText" cols="50" rows="20"><?php echo @$x_DuyuruText ?></textarea><script language="JavaScript1.2">editor_generate('x_DuyuruText');</script>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Duyuru Aktif&nbsp;</td>
<td bgcolor="#F5F5F5">
<input type="hidden" name="z_DuyuruAktif[]" value="LIKE,'%,%'">benzer
&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="radio" name="x_DuyuruAktif" value="<?php echo htmlspecialchars("Aktif"); ?>"><?php echo "Aktif"; ?>
<input type="radio" name="x_DuyuruAktif" value="<?php echo htmlspecialchars("Pasif"); ?>"><?php echo "Pasif"; ?>
&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Duyuru Tur&nbsp;</td>
<td bgcolor="#F5F5F5"><select name="z_DuyuruTur[]">
<option value="=,','">=</option>
<option value="<>,','"><></option>
<option value="<,','"><</option>
<option value="<=,','"><=</option>
<option value=">,','">></option>
<option value=">=,','">>=</option>
<option value="LIKE,'%,%'">benzer</option>
<option value="NOT LIKE,'%,%'">benzemez</option>
<option value="LIKE,',%'">baþlangýcý</option>
</select>
&nbsp;</td>
<td bgcolor="#F5F5F5"><?php
$x_DuyuruTurList = "<select name=\"x_DuyuruTur\"><option value=\"\">Lütfen Seçiniz</option>";
$x_DuyuruTurList .= "<option value=\"" . htmlspecialchars("LKD Genel Kurul Raporu") . "\"";
if (@$x_DuyuruTur == "LKD Genel Kurul Raporu") {
	$x_DuyuruTurList .= " selected";
}
$x_DuyuruTurList .= ">" . "LKD Genel Kurul Raporu" . "</option>";
$x_DuyuruTurList .= "<option value=\"" . htmlspecialchars("LKD YK Çalýþma Raporu") . "\"";
if (@$x_DuyuruTur == "LKD YK Çalýþma Raporu") {
	$x_DuyuruTurList .= " selected";
}
$x_DuyuruTurList .= ">" . "LKD YK Çalýþma Raporu" . "</option>";
$x_DuyuruTurList .= "<option value=\"" . htmlspecialchars("Çalýþma Grubu Raporu") . "\"";
if (@$x_DuyuruTur == "Çalýþma Grubu Raporu") {
	$x_DuyuruTurList .= " selected";
}
$x_DuyuruTurList .= ">" . "Çalýþma Grubu Raporu" . "</option>";
$x_DuyuruTurList .= "<option value=\"" . htmlspecialchars("LKD Genel Duyuru") . "\"";
if (@$x_DuyuruTur == "LKD Genel Duyuru") {
	$x_DuyuruTurList .= " selected";
}
$x_DuyuruTurList .= ">" . "LKD Genel Duyuru" . "</option>";
$x_DuyuruTurList .= "<option value=\"" . htmlspecialchars("Denetleme Kurulu Raporu") . "\"";
if (@$x_DuyuruTur == "Denetleme Kurulu Raporu") {
	$x_DuyuruTurList .= " selected";
}
$x_DuyuruTurList .= ">" . "Denetleme Kurulu Raporu" . "</option>";
$x_DuyuruTurList .= "<option value=\"" . htmlspecialchars("Diðer Duyuru Konularý") . "\"";
if (@$x_DuyuruTur == "Diðer Duyuru Konularý") {
	$x_DuyuruTurList .= " selected";
}
$x_DuyuruTurList .= ">" . "Diðer Duyuru Konularý" . "</option>";
$x_DuyuruTurList .= "</select>";
echo $x_DuyuruTurList;
?>
&nbsp;</td>
</tr>
</table>
<p>
<input type="submit" name="Action" value="Ara">
</form>
<?php include ("footer.php") ?>
<?php
mysql_close($conn);
?>
