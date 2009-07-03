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
if (($ewCurSec & ewAllowedit) <> ewAllowedit) header("Location: bildirilerlist.php");
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
	header("Location: bildirilerlist.php");
}

// get action
$a = @$_POST["a"];
if (empty($a)) {
	$a = "I";	//display with input box
}

// get fields from form
$x_BildiriID = @$_POST["x_BildiriID"];
$x_BildiriBaslik = @$_POST["x_BildiriBaslik"];
$x_BildiriText = @$_POST["x_BildiriText"];
$x_BildiriTarih = @$_POST["x_BildiriTarih"];
$x_BildiriAktif = @$_POST["x_BildiriAktif"];
$x_StatikSayfa = @$_POST["x_StatikSayfa"];
$x_BildiriURL = @$_POST["x_BildiriURL"];
$x_BildiriTur = @$_POST["x_BildiriTur"];

// baglanti hazirlaniyor...
$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB);
               mysql_query("SET NAMES 'utf8'");

switch ($a)
{
	case "I": // gosterilecek bir kayit  var
		$tkey = "" . $key . "";
		$strsql = "SELECT * FROM bildiriler WHERE BildiriID=" . $tkey;
		$rs = mysql_query($strsql) or die(mysql_error());
		if (!($row = mysql_fetch_array($rs))) {
     	ob_end_clean();
			header("Location: bildirilerlist.php");
		}

		// degerleri ayir...
		$x_BildiriID = @$row["BildiriID"];
		$x_BildiriBaslik = @$row["BildiriBaslik"];
		$x_BildiriText = @$row["BildiriText"];
		$x_BildiriTarih = @$row["BildiriTarih"];
		$x_BildiriAktif = @$row["BildiriAktif"];
		$x_StatikSayfa = @$row["StatikSayfa"];
		$x_BildiriURL = @$row["BildiriURL"];
		$x_BildiriTur = @$row["BildiriTur"];
		mysql_free_result($rs);
		break;
	case "U": // update
		$tkey = "" . $key . "";

		// form degerleri...
		$x_BildiriID = @$_POST["x_BildiriID"];
		$x_BildiriBaslik = @$_POST["x_BildiriBaslik"];
		$x_BildiriText = @$_POST["x_BildiriText"];
		$x_BildiriTarih = @$_POST["x_BildiriTarih"];
		$x_BildiriAktif = @$_POST["x_BildiriAktif"];
		$x_StatikSayfa = @$_POST["x_StatikSayfa"];
		$x_BildiriURL = @$_POST["x_BildiriURL"];
		$x_BildiriTur = @$_POST["x_BildiriTur"];

		// degerleri array'e atalim

		// BildiriBaslik
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_BildiriBaslik) : $x_BildiriBaslik;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["BildiriBaslik"] = $theValue;

		// BildiriText
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_BildiriText) : $x_BildiriText;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["BildiriText"] = $theValue;

		// BildiriTarih
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_BildiriTarih) : $x_BildiriTarih;
		$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
		$fieldList["BildiriTarih"] = $theValue;

		// BildiriAktif
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_BildiriAktif) : $x_BildiriAktif;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["BildiriAktif"] = $theValue;

		// StatikSayfa
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_StatikSayfa) : $x_StatikSayfa;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["StatikSayfa"] = $theValue;

		// BildiriURL
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_BildiriURL) : $x_BildiriURL;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["BildiriURL"] = $theValue;

		// BildiriTur
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_BildiriTur) : $x_BildiriTur;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["BildiriTur"] = $theValue;

		// update
		$updateSQL = "UPDATE bildiriler SET ";
		foreach ($fieldList as $key=>$temp) {
			$updateSQL .= "$key = $temp, ";
		}
		if (substr($updateSQL, -2) == ", ") {
			$updateSQL = substr($updateSQL, 0, strlen($updateSQL)-2);
		}
		$updateSQL .= " WHERE BildiriID=".$tkey;
  	$rs = mysql_query($updateSQL, $conn) or die(mysql_error());
		ob_end_clean();
		header("Location: bildirilerlist.php");
}
?>
<?php include ("header.php") ?>
<p><br><br><a href="bildirilerlist.php">Listeye Dön</a></p>
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
if (EW_this.x_BildiriBaslik && !EW_hasValue(EW_this.x_BildiriBaslik, "TEXT" )) {
            if (!EW_onError(EW_this, EW_this.x_BildiriBaslik, "TEXT", "Bildirinin Başlığı Nedir?"))
                return false;
        }
if (EW_this.x_BildiriTarih && !EW_hasValue(EW_this.x_BildiriTarih, "TEXT" )) {
            if (!EW_onError(EW_this, EW_this.x_BildiriTarih, "TEXT", "Tarih Seçiniz..."))
                return false;
        }
if (EW_this.x_BildiriTarih && !EW_checkeurodate(EW_this.x_BildiriTarih.value)) {
        if (!EW_onError(EW_this, EW_this.x_BildiriTarih, "TEXT", "Tarih Seçiniz..."))
            return false;
        }
if (EW_this.x_BildiriAktif && !EW_hasValue(EW_this.x_BildiriAktif, "RADIO" )) {
            if (!EW_onError(EW_this, EW_this.x_BildiriAktif, "RADIO", "Bildiri Aktif mi Pasif mi?"))
                return false;
        }
if (EW_this.x_BildiriTur && !EW_hasValue(EW_this.x_BildiriTur, "SELECT" )) {
            if (!EW_onError(EW_this, EW_this.x_BildiriTur, "SELECT", "Bildiri Türünü Seçiniz."))
                return false;
        }
return true;
}

// end JavaScript -->
</script>
<form onSubmit="return EW_checkMyForm(this);"  action="bildirileredit.php" method="post">
<p>
<input type="hidden" name="a" value="U">
<input type="hidden" name="key" value="<?php echo $key; ?>">
<table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Bildiri Baslik&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_BildiriBaslik" size="80" maxlength="255" value="<?php echo htmlspecialchars(@$x_BildiriBaslik); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Bildiri Text&nbsp;</td>
<td bgcolor="#F5F5F5"><textarea name="x_BildiriText" cols="50" rows="20"><?php echo @$x_BildiriText ?></textarea><script language="JavaScript1.2">editor_generate('x_BildiriText');</script>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Bildiri Tarih&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_BildiriTarih" value="<?php echo FormatDateTime(@$x_BildiriTarih,7); ?>">&nbsp;<input type="image" src="images/ew_calendar.gif" alt="Pick a Date" onClick="popUpCalendar(this, this.form.x_BildiriTarih,'dd/mm/yyyy');return false;">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Bildiri Aktif&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="radio" name="x_BildiriAktif"<?php if ($x_BildiriAktif == "Aktif") { echo " checked"; } ?> value="<?php echo htmlspecialchars("Aktif"); ?>"><?php echo "Aktif"; ?>
<input type="radio" name="x_BildiriAktif"<?php if ($x_BildiriAktif == "Pasif") { echo " checked"; } ?> value="<?php echo htmlspecialchars("Pasif"); ?>"><?php echo "Pasif"; ?>
&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Statik Sayfa&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_StatikSayfa" size="30" maxlength="100" value="<?php echo htmlspecialchars(@$x_StatikSayfa); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Bildiri URL&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_BildiriURL" size="30" maxlength="255" value="<?php echo htmlspecialchars(@$x_BildiriURL); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Bildiri Tur&nbsp;</td>
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
$x_BildiriTurList .= "<option value=\"" . htmlspecialchars("Diğer STK Bildirileri") . "\"";
if (@$x_BildiriTur == "Diğer STK Bildirileri") {
	$x_BildiriTurList .= " selected";
}
$x_BildiriTurList .= ">" . "Diğer STK Bildirileri" . "</option>";
$x_BildiriTurList .= "</select>";
echo $x_BildiriTurList;
?>
&nbsp;</td>
</tr>
<tr align="right">
  <td bgcolor="#466176">&nbsp;</td>
  <td bgcolor="#F5F5F5"><INPUT type="submit" name="Action" value="DÜZENLE"></td>
</tr>
</table>
<p>
</form>
<?php include ("footer.php") ?>
