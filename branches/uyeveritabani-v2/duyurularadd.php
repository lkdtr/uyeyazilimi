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
if (($ewCurSec & ewAllowadd) <> ewAllowadd) header("Location: duyurularlist.php");
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
        mysql_query("SET NAMES 'utf8'");

switch ($a) {
	case "C": // gosterilecek bir kayit  var
		$tkey = "" . $key . "";
		$strsql = "SELECT * FROM duyurular WHERE DuyuruID=" . $tkey;
		$rs = mysql_query($strsql);
		if (mysql_num_rows($rs) == 0) {
			ob_end_clean();
			header("Location: duyurularlist.php");
		} else {
			$row = mysql_fetch_array($rs);

		// degerleri ayir...
			$x_DuyuruBaslik = @$row["DuyuruBaslik"];
			$x_DuyuruOzet = @$row["DuyuruOzet"];
			$x_DuyuruText = @$row["DuyuruText"];
			$x_DuyuruTarih = @$row["DuyuruTarih"];
			$x_DuyuruSonTarih = @$row["DuyuruSonTarih"];
			$x_DuyuruAktif = @$row["DuyuruAktif"];
			$x_StatikSayfa = @$row["StatikSayfa"];
			$x_DuyuruTur = @$row["DuyuruTur"];
		}
		mysql_free_result($rs);
		break;
	case "A": // ekleme

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
			if (is_uploaded_file($_FILES["x_StatikSayfa"]["tmp_name"])) {
     		$destfile = addslashes(dirname($_SERVER["PATH_TRANSLATED"])) . "/uye_resimleri/" . $_FILES["x_StatikSayfa"]["name"];
     		if (!move_uploaded_file($_FILES["x_StatikSayfa"]["tmp_name"], $destfile)) // dosyayi yerine gonderelim...
     			die("You didn't upload a file or the file couldn't be moved to" . $destfile);
				$theName = (!get_magic_quotes_gpc()) ? addslashes($_FILES["x_StatikSayfa"]["name"]) : $_FILES["x_StatikSayfa"]["name"];
				$fieldList["StatikSayfa"] = " '" . $theName . "'";
				unlink($_FILES["x_StatikSayfa"]["tmp_name"]);
			}

		// DuyuruTur
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_DuyuruTur) : $x_DuyuruTur;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["DuyuruTur"] = $theValue;

		// vt ye yazma zamani
		$strsql = "INSERT INTO duyurular (";
		$strsql .= implode(",", array_keys($fieldList));
		$strsql .= ") VALUES (";
		$strsql .= implode(",", array_values($fieldList));
		$strsql .= ")";
	 	mysql_query($strsql, $conn) or die(mysql_error());
		mysql_close($conn);
		ob_end_clean();
		header("Location: duyurularlist.php");
		break;
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
<form onSubmit="return EW_checkMyForm(this);"  action="duyurularadd.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="EW_MaxFileSize" value="2000000">
<p>
<input type="hidden" name="a" value="A">
<table border="0" align="center" cellpadding="4" cellspacing="1">
<tr>
<td valign="top">
<TABLE width="100%"  border="1" cellpadding="3" bordercolor="#CCCCCC">
  <TR>
    <TD bgcolor="#f4f4f4">Duyuru Tarih</TD>
    <TD bgcolor="#f4f4f4"><?php if (empty($x_DuyuruTarih)) { $x_DuyuruTarih = 0000-00-00; } // varsayilan degeri belirle... ?>
<INPUT type="text" name="x_DuyuruTarih" value="<?php echo FormatDateTime(@$x_DuyuruTarih,7); ?>">
&nbsp;
  <INPUT name="image" type="image" onClick="popUpCalendar(this, this.form.x_DuyuruTarih,'dd/mm/yyyy');return false;" src="images/ew_calendar.gif" alt="Pick a Date">      </TD>
  </TR>
  <TR>
    <TD bgcolor="#f4f4f4">Duyuru Son Tarih</TD>
    <TD bgcolor="#f4f4f4"><?php if (empty($x_DuyuruSonTarih)) { $x_DuyuruSonTarih = 2004-01-01; } // varsayilan degeri belirle... ?>
      <input type="text" name="x_DuyuruSonTarih" value="<?php echo FormatDateTime(@$x_DuyuruSonTarih,7); ?>">
      &nbsp;
      <input name="image2" type="image" onClick="popUpCalendar(this, this.form.x_DuyuruSonTarih,'dd/mm/yyyy');return false;" src="images/ew_calendar.gif" alt="Pick a Date">
      </TD>
  </TR>
  <TR>
    <TD bgcolor="#f4f4f4">Duyuru Statu </TD>
    <TD bgcolor="#f4f4f4">
	  <?php if (empty($x_DuyuruAktif)) { $x_DuyuruAktif = Pasif; } // varsayilan degeri belirle... ?>
      <input type="radio" name="x_DuyuruAktif"<?php if ($x_DuyuruAktif == "Aktif") { echo " checked"; } ?> value="<?php echo htmlspecialchars("Aktif"); ?>">
      <?php echo "Aktif"; ?>
      <input type="radio" name="x_DuyuruAktif"<?php if ($x_DuyuruAktif == "Pasif") { echo " checked"; } ?> value="<?php echo htmlspecialchars("Pasif"); ?>">
      <?php echo "Pasif"; ?> &nbsp;
      <input type="radio" name="x_DuyuruAktif"<?php if ($x_DuyuruAktif == "Gizli") { echo " checked"; } ?> value="<?php echo htmlspecialchars("Gizli"); ?>">
      <?php echo "Gizli"; ?>
	  </TD>
  </TR>
  <TR>
    <TD bgcolor="#f4f4f4">Statik Sayfa</TD>
    <TD bgcolor="#f4f4f4"><?php $x_StatikSayfa = ""; // temizlik ?>
      <input type="file" name="x_StatikSayfa"></TD>
  </TR>
  <TR>
    <TD bgcolor="#f4f4f4">Duyuru Tur</TD>
    <TD bgcolor="#f4f4f4"><?php
$x_DuyuruTurList = "<select name=\"x_DuyuruTur\"><option value=\"\">Lütfen Seçiniz</option>";
$x_DuyuruTurList .= "<option value=\"" . htmlspecialchars("LKD Uye Sistemi") . "\"";
if (@$x_DuyuruTur == "LKD Uye Sistemi") {
	$x_DuyuruTurList .= " selected";
}
$x_DuyuruTurList .= ">" . "LKD Genel Kurul Raporu" . "</option>";
$x_DuyuruTurList .= "<option value=\"" . htmlspecialchars("LKD YK Çalışma Raporu") . "\"";
if (@$x_DuyuruTur == "LKD YK Çalışma Raporu") {
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
?></TD>
  </TR>
  <TR>
    <TD colspan="2" bgcolor="#f4f4f4"><TEXTAREA name="x_DuyuruBaslik" cols="50" rows="3"><?php echo @$x_DuyuruBaslik ?></TEXTAREA></TD>
    </TR>
  <TR>
    <TD colspan="2" bgcolor="#f4f4f4"><TEXTAREA name="x_DuyuruOzet" cols="50" rows="10"><?php echo @$x_DuyuruOzet ?></TEXTAREA></TD>
    </TR>
  <TR>
    <TD colspan="2" bgcolor="#f4f4f4"><TEXTAREA name="x_DuyuruText" cols="50" rows="20"><?php echo @$x_DuyuruText ?></TEXTAREA>
      <SCRIPT language="JavaScript1.2">editor_generate('x_DuyuruText');</SCRIPT></TD>
    </TR>
  <TR align="right">
    <TD colspan="2" bgcolor="#f4f4f4"><INPUT type="submit" name="Action" value="BELGE DUYURU EKLE"></TD>
    </TR>
</TABLE>  </td>
</tr>
</table>
<p>
</form>
<?php include ("footer.php") ?>
