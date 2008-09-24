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
if (($ewCurSec & ewAllowsearch) <> ewAllowsearch) header("Location: bildirilerlist.php");
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

	// field "BildiriBaslik"
	$x_BildiriBaslik = @$_POST["x_BildiriBaslik"];
	$z_BildiriBaslik = @$_POST["z_BildiriBaslik"];
	if (is_array($x_BildiriBaslik)) $x_BildiriBaslik = implode(",", $x_BildiriBaslik);
	$x_BildiriBaslik = (get_magic_quotes_gpc() ? stripslashes($x_BildiriBaslik) : $x_BildiriBaslik);
	$z_BildiriBaslik = implode(",", $z_BildiriBaslik);
	$z_BildiriBaslik = (get_magic_quotes_gpc() ? stripslashes($z_BildiriBaslik) : $z_BildiriBaslik);
	if ($x_BildiriBaslik <> "") {
		$srchFld = $x_BildiriBaslik;
		$this_search_criteria = "x_BildiriBaslik=" . urlencode($srchFld);
		$this_search_criteria .= "&z_BildiriBaslik=" . urlencode($z_BildiriBaslik);
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

	// field "BildiriText"
	$x_BildiriText = @$_POST["x_BildiriText"];
	$z_BildiriText = @$_POST["z_BildiriText"];
	if (is_array($x_BildiriText)) $x_BildiriText = implode(",", $x_BildiriText);
	$x_BildiriText = (get_magic_quotes_gpc() ? stripslashes($x_BildiriText) : $x_BildiriText);
	$z_BildiriText = implode(",", $z_BildiriText);
	$z_BildiriText = (get_magic_quotes_gpc() ? stripslashes($z_BildiriText) : $z_BildiriText);
	if ($x_BildiriText <> "") {
		$srchFld = $x_BildiriText;
		$this_search_criteria = "x_BildiriText=" . urlencode($srchFld);
		$this_search_criteria .= "&z_BildiriText=" . urlencode($z_BildiriText);
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

	// field "BildiriAktif"
	$x_BildiriAktif = @$_POST["x_BildiriAktif"];
	$z_BildiriAktif = @$_POST["z_BildiriAktif"];
	if (is_array($x_BildiriAktif)) $x_BildiriAktif = implode(",", $x_BildiriAktif);
	$x_BildiriAktif = (get_magic_quotes_gpc() ? stripslashes($x_BildiriAktif) : $x_BildiriAktif);
	$z_BildiriAktif = implode(",", $z_BildiriAktif);
	$z_BildiriAktif = (get_magic_quotes_gpc() ? stripslashes($z_BildiriAktif) : $z_BildiriAktif);
	if ($x_BildiriAktif <> "") {
		$srchFld = $x_BildiriAktif;
		$this_search_criteria = "x_BildiriAktif=" . urlencode($srchFld);
		$this_search_criteria .= "&z_BildiriAktif=" . urlencode($z_BildiriAktif);
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

	// field "BildiriTur"
	$x_BildiriTur = @$_POST["x_BildiriTur"];
	$z_BildiriTur = @$_POST["z_BildiriTur"];
	if (is_array($x_BildiriTur)) $x_BildiriTur = implode(",", $x_BildiriTur);
	$x_BildiriTur = (get_magic_quotes_gpc() ? stripslashes($x_BildiriTur) : $x_BildiriTur);
	$z_BildiriTur = implode(",", $z_BildiriTur);
	$z_BildiriTur = (get_magic_quotes_gpc() ? stripslashes($z_BildiriTur) : $z_BildiriTur);
	if ($x_BildiriTur <> "") {
		$srchFld = $x_BildiriTur;
		$this_search_criteria = "x_BildiriTur=" . urlencode($srchFld);
		$this_search_criteria .= "&z_BildiriTur=" . urlencode($z_BildiriTur);
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
			header("Location: bildirilerlist.php" . "?" . $search_criteria);
		}
		break;
}

// baglanti hazirlaniyor...
$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB);
?>
<?php include ("header.php") ?>
<p><br><br><a href="bildirilerlist.php">Listeye Dön</a></a></p>
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
<form onSubmit="return EW_checkMyForm(this);"  action="bildirilersrch.php" method="post">
<p>
<input type="hidden" name="a" value="S">
<table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Bildiri Baslik&nbsp;</td>
<td bgcolor="#F5F5F5">
<input type="hidden" name="z_BildiriBaslik[]" value="LIKE,'%,%'">benzer
&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_BildiriBaslik" size="30" maxlength="255" value="<?php echo htmlspecialchars(@$x_BildiriBaslik); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Bildiri Text&nbsp;</td>
<td bgcolor="#F5F5F5">
<input type="hidden" name="z_BildiriText[]" value="LIKE,'%,%'">benzer
&nbsp;</td>
<td bgcolor="#F5F5F5"><textarea name="x_BildiriText" cols="50" rows="20"><?php echo @$x_BildiriText ?></textarea><script language="JavaScript1.2">editor_generate('x_BildiriText');</script>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Bildiri Aktif&nbsp;</td>
<td bgcolor="#F5F5F5">
<input type="hidden" name="z_BildiriAktif[]" value="LIKE,'%,%'">benzer
&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="radio" name="x_BildiriAktif" value="<?php echo htmlspecialchars("Aktif"); ?>"><?php echo "Aktif"; ?>
<input type="radio" name="x_BildiriAktif" value="<?php echo htmlspecialchars("Pasif"); ?>"><?php echo "Pasif"; ?>
&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Bildiri Tur&nbsp;</td>
<td bgcolor="#F5F5F5">
<input type="hidden" name="z_BildiriTur[]" value="LIKE,'%,%'">benzer
&nbsp;</td>
<td bgcolor="#F5F5F5"><?php
$x_BildiriTurList = "<select name=\"x_BildiriTur\"><option value=\"\">Lütfen Seçiniz</option>";
$x_BildiriTurList .= "<option value=\"" . htmlspecialchars("LKD Bildirileri") . "\"";
if (@$x_BildiriTur == "LKD Bildirileri") {
	$x_BildiriTurList .= " selected";
}
$x_BildiriTurList .= ">" . "LKD Bildirileri" . "</option>";
$x_BildiriTurList .= "<option value=\"" . htmlspecialchars("Ortak Bildiriler") . "\"";
if (@$x_BildiriTur == "Ortak Bildiriler") {
	$x_BildiriTurList .= " selected";
}
$x_BildiriTurList .= ">" . "Ortak Bildiriler" . "</option>";
$x_BildiriTurList .= "<option value=\"" . htmlspecialchars("Diðer STK Bildirileri") . "\"";
if (@$x_BildiriTur == "Diðer STK Bildirileri") {
	$x_BildiriTurList .= " selected";
}
$x_BildiriTurList .= ">" . "Diðer STK Bildirileri" . "</option>";
$x_BildiriTurList .= "</select>";
echo $x_BildiriTurList;
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
