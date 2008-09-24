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
if (($ewCurSec & ewAllowedit) <> ewAllowedit) header("Location: odemelerlist.php");
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
$key = @$_GET["key"];
if (empty($key)) {
	$key = @$_POST["key"];
}
if (empty($key)) {
	header("Location: odemelerlist.php");
}

// get action
$a = @$_POST["a"];
if (empty($a)) {
	$a = "I";	//display with input box
}

// get fields from form
$x_uye_id = @$_POST["x_uye_id"];
$x_miktar = @$_POST["x_miktar"];
$x_tur = @$_POST["x_tur"];
$x_id = @$_POST["x_id"];
$x_tarih = @$_POST["x_tarih"];
$x_notlar = @$_POST["x_notlar"];
$x_odemeyolu = @$_POST["x_odemeyolu"];
$x_makbuz = @$_POST["x_makbuz"];

// baglanti hazirlaniyor...
$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB);
switch ($a)
{
	case "I": // gosterilecek bir kayit  var
		$tkey = "" . $key . "";
		$strsql = "SELECT * FROM odemeler WHERE id=" . $tkey;
    if ($_SESSION["uy_status_UserLevel"] <> -1) { // yonetici degil!
			$strsql = $strsql . " AND (uye_id = " . @$_SESSION["uy_status_UserID"] . ")";
    }
		$rs = mysql_query($strsql) or die(mysql_error());
		if (!($row = mysql_fetch_array($rs))) {
     	ob_end_clean();
			header("Location: odemelerlist.php");
		}

		// degerleri ayir...
		$x_uye_id = @$row["uye_id"];
		$x_miktar = @$row["miktar"];
		$x_tur = @$row["tur"];
		$x_id = @$row["id"];
		$x_tarih = @$row["tarih"];
		$x_notlar = @$row["notlar"];
		$x_odemeyolu = @$row["odemeyolu"];
		$x_makbuz = @$row["makbuz"];
		mysql_free_result($rs);		
		break;
	case "U": // update
		$tkey = "" . $key . "";
    if (@$_SESSION["uy_status_UserLevel"] <> -1) { // yonetici degil!
			$strsql = $strsql . " AND (uye_id = " . @$_SESSION["uy_status_UserID"] . ")";
    }

		// form degerleri...
		$x_uye_id = @$_POST["x_uye_id"];
		$x_miktar = @$_POST["x_miktar"];
		$x_tur = @$_POST["x_tur"];
		$x_id = @$_POST["x_id"];
		$x_tarih = @$_POST["x_tarih"];
		$x_notlar = @$_POST["x_notlar"];
		$x_odemeyolu = @$_POST["x_odemeyolu"];

		// check file size
		$EW_MaxFileSize = @$_POST["EW_MaxFileSize"];
		if (!empty($_FILES["x_makbuz"]["size"])) {
			if (!empty($EW_MaxFileSize) && $_FILES["x_makbuz"]["size"] > $EW_MaxFileSize) {
				die("Max. file upload size exceeded");
			}
		}
		$a_x_makbuz = @$_POST["a_x_makbuz"];

		// degerleri array'e atalim

		// uye_id
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_uye_id) : $x_uye_id;
		$theValue = ($theValue != "") ? intval($theValue) : "NULL";
		$fieldList["uye_id"] = $theValue;

		// miktar
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_miktar) : $x_miktar;
		$theValue = ($theValue != "") ? intval($theValue) : "NULL";
		$fieldList["miktar"] = $theValue;

		// tur
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_tur) : $x_tur;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["tur"] = $theValue;

		// tarih
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_tarih) : $x_tarih;
		$theValue = ($theValue != "") ? " '" . ConvertDateToMysqlFormat($theValue) . "'" : "NULL";
		$fieldList["tarih"] = $theValue;

		// notlar
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_notlar) : $x_notlar;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["notlar"] = $theValue;

		// odemeyolu
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_odemeyolu) : $x_odemeyolu;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["odemeyolu"] = $theValue;

		// makbuz
		if ($a_x_makbuz == "2") { // remove
			$fieldList["makbuz"] = "NULL";
			$fieldList["makbuz"] = "NULL";
		} else if ($a_x_makbuz == "3") { // update
			if (is_uploaded_file($_FILES["x_makbuz"]["tmp_name"])) {
     		$destfile = addslashes(dirname($_SERVER["PATH_TRANSLATED"])) . "/$UyeResimlerDizin/" . $_FILES["x_makbuz"]["name"];
     		if (!move_uploaded_file($_FILES["x_makbuz"]["tmp_name"], $destfile)) // dosyayi yerine gonderelim...
     			die("Dosya gondermediniz veya dosya yerine yerlestirilemedi:" . $destfile);
				$theName = (!get_magic_quotes_gpc()) ? addslashes($_FILES["x_makbuz"]["name"]) : $_FILES["x_makbuz"]["name"];
				$fieldList["makbuz"] = " '" . $theName . "'";
				unlink($_FILES["x_makbuz"]["tmp_name"]);
			}
		}
		if ($_SESSION["uy_status_UserLevel"] <> -1) { // yonetici degil!
			$fieldList["uye_id"] = " '" . $_SESSION["uy_status_UserID"] . "'";
		}

		// update
		$updateSQL = "UPDATE odemeler SET ";
		foreach ($fieldList as $key=>$temp) {
			$updateSQL .= "$key = $temp, ";			
		}
		if (substr($updateSQL, -2) == ", ") {
			$updateSQL = substr($updateSQL, 0, strlen($updateSQL)-2);
		}
		$updateSQL .= " WHERE id=".$tkey;
  	$rs = mysql_query($updateSQL, $conn) or die(mysql_error());
		ob_end_clean();
		header("Location: odemelerlist.php");
}		
?>
<?php include ("header.php") ?>
<p><br><br><a href="odemelerlist.php">Listeye Dön</a></p>
<script language="JavaScript" src="ew.js"></script>
<script language="JavaScript" src="popcalendar.js"></script>
<script language="JavaScript">
<!-- start Javascript
function  EW_checkMyForm(EW_this) {
if (EW_this.x_uye_id && !EW_hasValue(EW_this.x_uye_id, "SELECT" )) {
            if (!EW_onError(EW_this, EW_this.x_uye_id, "SELECT", "Incorrect integer - uye id"))
                return false; 
        }
if (EW_this.x_miktar && !EW_hasValue(EW_this.x_miktar, "TEXT" )) {
            if (!EW_onError(EW_this, EW_this.x_miktar, "TEXT", "Miktar Girmediniz!"))
                return false; 
        }
if (EW_this.x_miktar && !EW_checkinteger(EW_this.x_miktar.value)) {
        if (!EW_onError(EW_this, EW_this.x_miktar, "TEXT", "Miktar Girmediniz!"))
            return false; 
        }
if (EW_this.x_tur && !EW_hasValue(EW_this.x_tur, "RADIO" )) {
            if (!EW_onError(EW_this, EW_this.x_tur, "RADIO", "Ödeme Türünü Seçiniz!"))
                return false; 
        }
if (EW_this.x_tarih && !EW_hasValue(EW_this.x_tarih, "TEXT" )) {
            if (!EW_onError(EW_this, EW_this.x_tarih, "TEXT", "Incorrect date (dd/mm/yyyy) - tarih"))
                return false; 
        }
if (EW_this.x_tarih && !EW_checkeurodate(EW_this.x_tarih.value)) {
        if (!EW_onError(EW_this, EW_this.x_tarih, "TEXT", "Incorrect date (dd/mm/yyyy) - tarih"))
            return false; 
        }
if (EW_this.x_odemeyolu && !EW_hasValue(EW_this.x_odemeyolu, "SELECT" )) {
            if (!EW_onError(EW_this, EW_this.x_odemeyolu, "SELECT", "Ödeme Ne Þekilde Yapýldý?"))
                return false; 
        }
return true;
}

// end JavaScript -->
</script>
<form onSubmit="return EW_checkMyForm(this);"  action="odemeleredit.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="EW_MaxFileSize" value="2000000">
<p>
<input type="hidden" name="a" value="U">
<input type="hidden" name="key" value="<?php echo $key; ?>">
<table width="60%" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">uye id&nbsp;</td>
<td bgcolor="#F5F5F5"><?php if (($ewCurSec & ewAllowAdmin) == ewAllowAdmin) { // system admin ?>
<?php
$x_uye_idList = "";
$sqlwrk = "SELECT uye_id, uye_ad, uye_soyad, eposta1 FROM uyeler";
$rswrk = mysql_query($sqlwrk);
if ($rswrk) {
	$rowcntwrk = 0;
	while ($datawrk = mysql_fetch_array($rswrk)) {
//	select'i kaldiriyoruz...
		if ($datawrk[0] == @$x_uye_id) {
			$x_uye_idList .= "<b>" . $datawrk[0] . "</b> &nbsp;" . $datawrk[1] . " " . $datawrk[2] . " -- " . $datawrk[3] . " " . htmlspecialchars($datawrk[4]);
		}
		$rowcntwrk++;
	}
}
@mysql_free_result($rswrk);
echo $x_uye_idList ;
?>
<?php } else { // yonetici degil! ?>
<?php $x_uye_id = $_SESSION["uy_status_UserID"]; ?>
<?php
if (!is_null($x_uye_id)) {
	$sqlwrk = "SELECT * FROM uyeler";
	$sqlwrk .= " WHERE uye_id = " . $x_uye_id;
	$rswrk = mysql_query($sqlwrk);
	if ($rswrk && $rowwrk = mysql_fetch_array($rswrk)) {
		echo $rowwrk["eposta1"];
	}
	@mysql_free_result($rswrk);
}
?>
<input type="hidden" name="x_uye_id" value="<?php echo htmlspecialchars(@$x_uye_id); ?>">
<?php } ?>
<input type="hidden" name="x_uye_id" value="<?php echo htmlspecialchars(@$x_uye_id); ?>">
&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">miktar&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_miktar" size="30" value="<?php echo htmlspecialchars(@$x_miktar); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">tur&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="radio" name="x_tur"<?php if ($x_tur == "aidat") { echo " checked"; } ?> value="<?php echo htmlspecialchars("aidat"); ?>"><?php echo "Üye Aidatý"; ?>
<input type="radio" name="x_tur"<?php if ($x_tur == "bagis") { echo " checked"; } ?> value="<?php echo htmlspecialchars("bagis"); ?>"><?php echo "Baðýþ"; ?>
<input type="radio" name="x_tur"<?php if ($x_tur == "diger") { echo " checked"; } ?> value="<?php echo htmlspecialchars("diger"); ?>"><?php echo "Diðer"; ?>
&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">id&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="hidden" name="x_id" value="<?php echo htmlspecialchars(@$x_id); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">tarih&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_tarih" value="<?php echo FormatDateTime(@$x_tarih,7); ?>">&nbsp;<input type="image" src="images/ew_calendar.gif" alt="Pick a Date" onClick="popUpCalendar(this, this.form.x_tarih,'dd/mm/yyyy');return false;">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">notlar&nbsp;</td>
<td bgcolor="#F5F5F5"><textarea name="x_notlar" cols="35" rows="4"><?php echo @$x_notlar ?></textarea>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">odemeyolu&nbsp;</td>
<td bgcolor="#F5F5F5"><?php
$x_odemeyoluList = "<select name=\"x_odemeyolu\"><option value=\"\">Lütfen Seçiniz</option>";
$x_odemeyoluList .= "<option value=\"" . htmlspecialchars("havale") . "\"";
if (@$x_odemeyolu == "havale") {
	$x_odemeyoluList .= " selected";
}
$x_odemeyoluList .= ">" . "Banka Havalesi" . "</option>";
$x_odemeyoluList .= "<option value=\"" . htmlspecialchars("e-islem") . "\"";
if (@$x_odemeyolu == "e-islem") {
	$x_odemeyoluList .= " selected";
}
$x_odemeyoluList .= ">" . "Elektronik Transfer" . "</option>";
$x_odemeyoluList .= "<option value=\"" . htmlspecialchars("posta") . "\"";
if (@$x_odemeyolu == "posta") {
	$x_odemeyoluList .= " selected";
}
$x_odemeyoluList .= ">" . "Posta Nakit" . "</option>";
$x_odemeyoluList .= "<option value=\"" . htmlspecialchars("elden") . "\"";
if (@$x_odemeyolu == "elden") {
	$x_odemeyoluList .= " selected";
}
$x_odemeyoluList .= ">" . "Elden Ödeme" . "</option>";
$x_odemeyoluList .= "<option value=\"" . htmlspecialchars("diðer") . "\"";
if (@$x_odemeyolu == "diðer") {
	$x_odemeyoluList .= " selected";
}
$x_odemeyoluList .= ">" . "Diðer - Notlar Kýsmýna Bakýnýz" . "</option>";
$x_odemeyoluList .= "</select>";
echo $x_odemeyoluList;
?>
&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">makbuz&nbsp;</td>
<td bgcolor="#F5F5F5"><?php if (!is_null($x_makbuz)) { ?>
<input type="radio" name="a_x_makbuz" value="1" checked>Olduðu gibi býrak&nbsp;<input type="radio" name="a_x_makbuz" value="2">Çýkar&nbsp;<input type="radio" name="a_x_makbuz" value="3">Deðiþtir<br>
<?php } else { ?>
<input type="hidden" name="a_x_makbuz" value="3">
<?php } ?>
<input type="file" name="x_makbuz" onChange="if (this.form.a_x_makbuz[2]) this.form.a_x_makbuz[2].checked=true;">&nbsp;</td>
</tr>
<tr>
  <td bgcolor="#466176">&nbsp;</td>
  <td align="right" bgcolor="#F5F5F5"><INPUT type="submit" name="Action" value="DÜZENLE"></td>
</tr>
</table>
<p>
</form>
<?php include ("footer.php") ?>
