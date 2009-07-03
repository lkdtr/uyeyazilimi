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
if (($ewCurSec & ewAllowedit) <> ewAllowedit) header("Location: duyurularlist.php");
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
	header("Location: duyurularlist.php");
}

// get action
$a = @$_POST["a"];
if (empty($a)) {
	$a = "I";	//display with input box
}

// get fields from form
$x_DuyuruID = @$_POST["x_DuyuruID"];
$x_DuyuruBaslik = @$_POST["x_DuyuruBaslik"];
$x_DuyuruOzet = @$_POST["x_DuyuruOzet"];
$x_DuyuruText = @$_POST["x_DuyuruText"];
$x_DuyuruTarih = @$_POST["x_DuyuruTarih"];
$x_DuyuruSonTarih = @$_POST["x_DuyuruSonTarih"];
$x_DuyuruAktif = @$_POST["x_DuyuruAktif"];
$x_StatikSayfa = @$_POST["x_StatikSayfa"];
$x_DuyuruTur = @$_POST["x_DuyuruTur"];

// baglanti hazirlaniyor...
$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB);
               mysql_query("SET NAMES 'utf8'");

switch ($a)
{
	case "I": // gosterilecek bir kayit  var
		$tkey = "" . $key . "";
		$strsql = "SELECT * FROM duyurular WHERE DuyuruID=" . $tkey;
		$rs = mysql_query($strsql) or die(mysql_error());
		if (!($row = mysql_fetch_array($rs))) {
     	ob_end_clean();
			header("Location: duyurularlist.php");
		}

		// degerleri ayir...
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
	case "U": // update
		$tkey = "" . $key . "";

		// form degerleri...
		$x_DuyuruID = @$_POST["x_DuyuruID"];
		$x_DuyuruBaslik = @$_POST["x_DuyuruBaslik"];
		$x_DuyuruOzet = @$_POST["x_DuyuruOzet"];
		$x_DuyuruText = @$_POST["x_DuyuruText"];
		$x_DuyuruTarih = @$_POST["x_DuyuruTarih"];
		$x_DuyuruSonTarih = @$_POST["x_DuyuruSonTarih"];
		$x_DuyuruAktif = @$_POST["x_DuyuruAktif"];
		$x_DuyuruTur = @$_POST["x_DuyuruTur"];

		// check file size
		$EW_MaxFileSize = @$_POST["EW_MaxFileSize"];
		if (!empty($_FILES["x_StatikSayfa"]["size"])) {
			if (!empty($EW_MaxFileSize) && $_FILES["x_StatikSayfa"]["size"] > $EW_MaxFileSize) {
				die("Max. file upload size exceeded");
			}
		}
		$a_x_StatikSayfa = @$_POST["a_x_StatikSayfa"];

		// degerleri array'e atalim

		// DuyuruBaslik
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_DuyuruBaslik) : $x_DuyuruBaslik;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["DuyuruBaslik"] = $theValue;

		// DuyuruOzet
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_DuyuruOzet) : $x_DuyuruOzet;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["DuyuruOzet"] = $theValue;

		// DuyuruText
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_DuyuruText) : $x_DuyuruText;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["DuyuruText"] = $theValue;

		// DuyuruTarih
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_DuyuruTarih) : $x_DuyuruTarih;
		$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
		$fieldList["DuyuruTarih"] = $theValue;

		// DuyuruSonTarih
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_DuyuruSonTarih) : $x_DuyuruSonTarih;
		$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
		$fieldList["DuyuruSonTarih"] = $theValue;

		// DuyuruAktif
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_DuyuruAktif) : $x_DuyuruAktif;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["DuyuruAktif"] = $theValue;

		// StatikSayfa
		if ($a_x_StatikSayfa == "2") { // remove
			$fieldList["StatikSayfa"] = "NULL";
			$fieldList["StatikSayfa"] = "NULL";
		} else if ($a_x_StatikSayfa == "3") { // update
			if (is_uploaded_file($_FILES["x_StatikSayfa"]["tmp_name"])) {
     		$destfile = addslashes(dirname($_SERVER["PATH_TRANSLATED"])) . "/uye_resimleri/" . $_FILES["x_StatikSayfa"]["name"];
     		if (!move_uploaded_file($_FILES["x_StatikSayfa"]["tmp_name"], $destfile)) // dosyayi yerine gonderelim...
     			die("You didn't upload a file or the file couldn't be moved to" . $destfile);
				$theName = (!get_magic_quotes_gpc()) ? addslashes($_FILES["x_StatikSayfa"]["name"]) : $_FILES["x_StatikSayfa"]["name"];
				$fieldList["StatikSayfa"] = " '" . $theName . "'";
				unlink($_FILES["x_StatikSayfa"]["tmp_name"]);
			}
		}

		// DuyuruTur
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_DuyuruTur) : $x_DuyuruTur;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["DuyuruTur"] = $theValue;

		// update
		$updateSQL = "UPDATE duyurular SET ";
		foreach ($fieldList as $key=>$temp) {
			$updateSQL .= "$key = $temp, ";
		}
		if (substr($updateSQL, -2) == ", ") {
			$updateSQL = substr($updateSQL, 0, strlen($updateSQL)-2);
		}
		$updateSQL .= " WHERE DuyuruID=".$tkey;
  	$rs = mysql_query($updateSQL, $conn) or die(mysql_error());
		ob_end_clean();
		header("Location: duyurularlist.php");
}
?>
<?php include ("header.php") ?>
<p><br><br><a href="duyurularlist.php">Listeye Dön</a></p>
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
if (EW_this.x_DuyuruBaslik && !EW_hasValue(EW_this.x_DuyuruBaslik, "TEXTAREA" )) {
            if (!EW_onError(EW_this, EW_this.x_DuyuruBaslik, "TEXTAREA", "Duyuru için Başlık Girmelisiniz!"))
                return false;
        }
if (EW_this.x_DuyuruTarih && !EW_hasValue(EW_this.x_DuyuruTarih, "TEXT" )) {
            if (!EW_onError(EW_this, EW_this.x_DuyuruTarih, "TEXT", "Duyuru Ne zaman Aktif Olacak?"))
                return false;
        }
if (EW_this.x_DuyuruTarih && !EW_checkeurodate(EW_this.x_DuyuruTarih.value)) {
        if (!EW_onError(EW_this, EW_this.x_DuyuruTarih, "TEXT", "Duyuru Ne zaman Aktif Olacak?"))
            return false;
        }
if (EW_this.x_DuyuruSonTarih && !EW_hasValue(EW_this.x_DuyuruSonTarih, "TEXT" )) {
            if (!EW_onError(EW_this, EW_this.x_DuyuruSonTarih, "TEXT", "Duyuru Ne Zaman Pasif Olacak!"))
                return false;
        }
if (EW_this.x_DuyuruSonTarih && !EW_checkeurodate(EW_this.x_DuyuruSonTarih.value)) {
        if (!EW_onError(EW_this, EW_this.x_DuyuruSonTarih, "TEXT", "Duyuru Ne Zaman Pasif Olacak!"))
            return false;
        }
if (EW_this.x_DuyuruAktif && !EW_hasValue(EW_this.x_DuyuruAktif, "RADIO" )) {
            if (!EW_onError(EW_this, EW_this.x_DuyuruAktif, "RADIO", "Duyuru Aktif mi Pasif mi?"))
                return false;
        }
if (EW_this.x_DuyuruTur && !EW_hasValue(EW_this.x_DuyuruTur, "SELECT" )) {
            if (!EW_onError(EW_this, EW_this.x_DuyuruTur, "SELECT", "Duyuru Türünü Belirleyiniz."))
                return false;
        }
return true;
}

// end JavaScript -->
</script>
<form onSubmit="return EW_checkMyForm(this);"  action="duyurularedit.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="EW_MaxFileSize" value="2000000">
<p>
<input type="hidden" name="a" value="U">
<input type="hidden" name="key" value="<?php echo $key; ?>">
<table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Duyuru ID&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="hidden" name="x_DuyuruID" value="<?php echo htmlspecialchars(@$x_DuyuruID); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Duyuru Baslik&nbsp;</td>
<td bgcolor="#F5F5F5"><textarea name="x_DuyuruBaslik" cols="50" rows="5"><?php echo @$x_DuyuruBaslik ?></textarea>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Duyuru Ozet&nbsp;</td>
<td bgcolor="#F5F5F5"><textarea name="x_DuyuruOzet" cols="50" rows="10"><?php echo @$x_DuyuruOzet ?></textarea>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Duyuru Text&nbsp;</td>
<td bgcolor="#F5F5F5"><textarea name="x_DuyuruText" cols="50" rows="20"><?php echo @$x_DuyuruText ?></textarea><script language="JavaScript1.2">editor_generate('x_DuyuruText');</script>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Duyuru Tarih&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_DuyuruTarih" value="<?php echo FormatDateTime(@$x_DuyuruTarih,7); ?>">&nbsp;<input type="image" src="images/ew_calendar.gif" alt="Pick a Date" onClick="popUpCalendar(this, this.form.x_DuyuruTarih,'dd/mm/yyyy');return false;">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Duyuru Son Tarih&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_DuyuruSonTarih" value="<?php echo FormatDateTime(@$x_DuyuruSonTarih,7); ?>">&nbsp;<input type="image" src="images/ew_calendar.gif" alt="Pick a Date" onClick="popUpCalendar(this, this.form.x_DuyuruSonTarih,'dd/mm/yyyy');return false;">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Duyuru Aktif&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="radio" name="x_DuyuruAktif"<?php if ($x_DuyuruAktif == "Aktif") { echo " checked"; } ?> value="<?php echo htmlspecialchars("Aktif"); ?>"><?php echo "Aktif"; ?>
<input type="radio" name="x_DuyuruAktif"<?php if ($x_DuyuruAktif == "Pasif") { echo " checked"; } ?> value="<?php echo htmlspecialchars("Pasif"); ?>"><?php echo "Pasif"; ?>
&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Statik Sayfa&nbsp;</td>
<td bgcolor="#F5F5F5"><?php if (!is_null($x_StatikSayfa)) { ?>
<input type="radio" name="a_x_StatikSayfa" value="1" checked>Olduğu gibi bırak&nbsp;<input type="radio" name="a_x_StatikSayfa" value="2">Çıkar&nbsp;<input type="radio" name="a_x_StatikSayfa" value="3">Değiştir<br>
<?php } else { ?>
<input type="hidden" name="a_x_StatikSayfa" value="3">
<?php } ?>
<input type="file" name="x_StatikSayfa" onChange="if (this.form.a_x_StatikSayfa[2]) this.form.a_x_StatikSayfa[2].checked=true;">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Duyuru Tur&nbsp;</td>
<td bgcolor="#F5F5F5"><?php
$x_DuyuruTurList = "<select name=\"x_DuyuruTur\"><option value=\"\">Lütfen Seçiniz</option>";
$x_DuyuruTurList .= "<option value=\"" . htmlspecialchars("LKD Uye Sistemi") . "\"";
if (@$x_DuyuruTur == "LKD Uye Sistemi") {
	$x_DuyuruTurList .= " selected";
}
$x_DuyuruTurList .= ">" . "LKD Uye Sistemi" . "</option>";
$x_DuyuruTurList .= "<option value=\"" . htmlspecialchars("LKD YK Çalışma Raporu") . "\"";
if (@$x_DuyuruTur == "LKD Uye Sistemi") {
	$x_DuyuruTurList .= " selected";
}
$x_DuyuruTurList .= ">" . "LKD YK Çalışma Raporu" . "</option>";
$x_DuyuruTurList .= "<option value=\"" . htmlspecialchars("Çalışma Grubu Raporu") . "\"";
if (@$x_DuyuruTur == "Çalışma Grubu Raporu") {
	$x_DuyuruTurList .= " selected";
}
$x_DuyuruTurList .= ">" . "Çalışma Grubu Raporu" . "</option>";
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
$x_DuyuruTurList .= "<option value=\"" . htmlspecialchars("Diğer Duyuru Konuları") . "\"";
if (@$x_DuyuruTur == "Diğer Duyuru Konuları") {
	$x_DuyuruTurList .= " selected";
}
$x_DuyuruTurList .= ">" . "Diğer Duyuru Konuları" . "</option>";
$x_DuyuruTurList .= "</select>";
echo $x_DuyuruTurList;
?>
&nbsp;</td>
</tr>
</table>
<p>
<input type="submit" name="Action" value="EDIT">
</form>
<?php include ("footer.php") ?>
