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
if (($ewCurSec & ewAllowadd) <> ewAllowadd) header("Location: uyelerlist.php");
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
		$strsql = "SELECT * FROM uyeler WHERE id=" . $tkey;
    if ($_SESSION["uy_status_UserLevel"] <> -1) { //yonetici degil!
			$strsql .= " AND (uye_id = " . $_SESSION["uy_status_UserID"] . ")";
    }
		$rs = mysql_query($strsql);
		if (mysql_num_rows($rs) == 0) {
			ob_end_clean();
			header("Location: uyelerlist.php");
		} else {
			$row = mysql_fetch_array($rs);

		// degerleri ayir...
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
			$x_AuthLevel = @$row["AuthLevel"]; 
			$x_PassWord = @$row["PassWord"]; 
			$x_Resim = @$row["Resim"]; 
		}
		mysql_free_result($rs);
		break;
	case "A": // ekleme

		// form degerleri temizlik basliyorrr.
		$x_id = @strip_tags($_POST["x_id"]);
		$x_uye_id = @strip_tags($_POST["x_uye_id"]);
		$x_uye_ad = @strip_tags($_POST["x_uye_ad"]);
		$x_uye_soyad = @strip_tags($_POST["x_uye_soyad"]);
		$x_eposta1 = @strip_tags($_POST["x_eposta1"]);
		$x_eposta2 = @strip_tags($_POST["x_eposta2"]);
		$x_alias = @strip_tags($_POST["x_alias"]);
		$x_cinsiyet = @strip_tags($_POST["x_cinsiyet"]);
		$x_kurum = @strip_tags($_POST["x_kurum"]);
		$x_gorev = @strip_tags($_POST["x_gorev"]);
		$x_mezuniyet = @strip_tags($_POST["x_mezuniyet"]);
		$x_mezuniyet_yil = @strip_tags($_POST["x_mezuniyet_yil"]);
		$x_mezuniyet_bolum = @strip_tags($_POST["x_mezuniyet_bolum"]);
		$x_is_addr = @strip_tags($_POST["x_is_addr"]);
		$x_semt = @strip_tags($_POST["x_semt"]);
		$x_sehir = @strip_tags($_POST["x_sehir"]);
		$x_pkod = @strip_tags($_POST["x_pkod"]);
		$x_AuthLevel = @strip_tags($_POST["x_AuthLevel"]);
		$x_PassWord = @$_POST["x_PassWord"];

		// check file size
		$EW_MaxFileSize = @$_POST["EW_MaxFileSize"];
		if (!empty($_FILES["x_Resim"]["size"])) {
			if (!empty($EW_MaxFileSize) && $_FILES["x_Resim"]["size"] > $EW_MaxFileSize) {
				die("Max. file upload size exceeded");
			}
		}

		// degerleri array'e atalim

		// uye_id
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_uye_id) : $x_uye_id;
		$theValue = ($theValue != "") ? intval($theValue) : "NULL";
		$fieldList["uye_id"] = $theValue;

		// uye_ad
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_uye_ad) : $x_uye_ad;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["uye_ad"] = $theValue;

		// uye_soyad
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_uye_soyad) : $x_uye_soyad;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["uye_soyad"] = $theValue;

		// eposta1
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_eposta1) : $x_eposta1;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["eposta1"] = $theValue;

		// eposta2
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_eposta2) : $x_eposta2;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["eposta2"] = $theValue;

		// alias
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_alias) : $x_alias;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["alias"] = $theValue;

		// cinsiyet
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_cinsiyet) : $x_cinsiyet;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["cinsiyet"] = $theValue;

		// kurum
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_kurum) : $x_kurum;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["kurum"] = $theValue;

		// gorev
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_gorev) : $x_gorev;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["gorev"] = $theValue;

		// mezuniyet
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_mezuniyet) : $x_mezuniyet;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["mezuniyet"] = $theValue;

		// mezuniyet_yil
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_mezuniyet_yil) : $x_mezuniyet_yil;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["mezuniyet_yil"] = $theValue;

		// mezuniyet_bolum
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_mezuniyet_bolum) : $x_mezuniyet_bolum;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["mezuniyet_bolum"] = $theValue;

		// is_addr
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_is_addr) : $x_is_addr;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["is_addr"] = $theValue;

		// semt
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_semt) : $x_semt;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["semt"] = $theValue;

		// sehir
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_sehir) : $x_sehir;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["sehir"] = $theValue;

		// pkod
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_pkod) : $x_pkod;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["pkod"] = $theValue;

		// PassWord
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_PassWord) : $x_PassWord;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["PassWord"] = $theValue;

		// Resim
			if (is_uploaded_file($_FILES["x_Resim"]["tmp_name"])) {
     		$destfile = addslashes(dirname($_SERVER["PATH_TRANSLATED"])) . "/uye_resimleri/" . $_FILES["x_Resim"]["name"];
     		if (!move_uploaded_file($_FILES["x_Resim"]["tmp_name"], $destfile)) // dosyayi yerine gonderelim...
     			die("You didn't upload a file or the file couldn't be moved to" . $destfile);
				$theName = (!get_magic_quotes_gpc()) ? addslashes($_FILES["x_Resim"]["name"]) : $_FILES["x_Resim"]["name"];
				$fieldList["Resim"] = " '" . $theName . "'";
				unlink($_FILES["x_Resim"]["tmp_name"]);
			}
		if ($_SESSION["uy_status_UserLevel"] <> -1) { // yonetici degil!
			$fieldList["uye_id"] = " '" . $_SESSION["uy_status_UserID"] . "'";
		}

		// vt ye yazma zamani
		$strsql = "INSERT INTO uyeler (";
		$strsql .= implode(",", array_keys($fieldList));
		$strsql .= ") VALUES (";
		$strsql .= implode(",", array_values($fieldList));
		$strsql .= ")";
	 	mysql_query($strsql, $conn) or die(mysql_error());
		mysql_close($conn);
		ob_end_clean();
		header("Location: uyelerlist.php");
		break;
}
?>
<?php include ("header.php") ?>
<p><br><br><a href="uyelerlist.php">Listeye Dön</a></p>
<script language="JavaScript" src="ew.js"></script>
<script language="JavaScript">
<!-- start Javascript
function  EW_checkMyForm(EW_this) {
if (EW_this.x_uye_id && !EW_hasValue(EW_this.x_uye_id, "TEXT" )) {
            if (!EW_onError(EW_this, EW_this.x_uye_id, "TEXT", "Hatali- uye id"))
                return false; 
        }
if (EW_this.x_uye_ad && !EW_hasValue(EW_this.x_uye_ad, "TEXT" )) {
            if (!EW_onError(EW_this, EW_this.x_uye_ad, "TEXT", "Ad Girmediniz !"))
                return false; 
        }
if (EW_this.x_uye_soyad && !EW_hasValue(EW_this.x_uye_soyad, "TEXT" )) {
            if (!EW_onError(EW_this, EW_this.x_uye_soyad, "TEXT", "Soyadýnýz ?"))
                return false; 
        }
if (EW_this.x_eposta1 && !EW_hasValue(EW_this.x_eposta1, "TEXT" )) {
            if (!EW_onError(EW_this, EW_this.x_eposta1, "TEXT", "Geçersiz e-posta adresi!"))
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
if (EW_this.x_cinsiyet && !EW_hasValue(EW_this.x_cinsiyet, "RADIO" )) {
            if (!EW_onError(EW_this, EW_this.x_cinsiyet, "RADIO", "Cinsiyet ?"))
                return false; 
        }
if (EW_this.x_PassWord && !EW_hasValue(EW_this.x_PassWord, "PASSWORD" )) {
            if (!EW_onError(EW_this, EW_this.x_PassWord, "PASSWORD", "Invalid Field"))
                return false; 
        }
return true;
}

// end JavaScript -->
</script>
<form onSubmit="return EW_checkMyForm(this);"  action="uyeleradd.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="EW_MaxFileSize" value="2000000">
<p>
<input type="hidden" name="a" value="A">
<table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">id&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="hidden" name="x_id" value="<?php echo htmlspecialchars(@$x_id); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">uye id&nbsp;</td>
<td bgcolor="#F5F5F5"><?php if (($ewCurSec & ewAllowAdmin) == ewAllowAdmin) { // system admin ?>
<input type="text" name="x_uye_id" size="30" value="<?php echo htmlspecialchars(@$x_uye_id); ?>">
<?php } else { // yonetici degil! ?>
<?php $x_uye_id = $_SESSION["uy_status_UserID"]; ?><?php echo $x_uye_id; ?><input type="hidden" name="x_uye_id" value="<?php echo htmlspecialchars(@$x_uye_id); ?>">
<?php } ?>
&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">uye ad&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_uye_ad" size="30" maxlength="99" value="<?php echo htmlspecialchars(@$x_uye_ad); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">uye soyad&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_uye_soyad" size="30" maxlength="99" value="<?php echo htmlspecialchars(@$x_uye_soyad); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">eposta 1&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_eposta1" size="30" maxlength="255" value="<?php echo htmlspecialchars(@$x_eposta1); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">eposta 2&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_eposta2" size="30" maxlength="255" value="<?php echo htmlspecialchars(@$x_eposta2); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">alias&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_alias" size="30" maxlength="100" value="<?php echo htmlspecialchars(@$x_alias); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">cinsiyet&nbsp;</td>
<td bgcolor="#F5F5F5"><?php if (empty($x_cinsiyet)) { $x_cinsiyet = "e"; } // varsayilan degeri belirle... ?><input type="radio" name="x_cinsiyet"<?php if ($x_cinsiyet == "e") { echo " checked"; } ?> value="<?php echo htmlspecialchars("e"); ?>"><?php echo "e"; ?>
<input type="radio" name="x_cinsiyet"<?php if ($x_cinsiyet == "m") { echo " checked"; } ?> value="<?php echo htmlspecialchars("m"); ?>"><?php echo "m"; ?>
&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">kurum&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_kurum" size="30" maxlength="255" value="<?php echo htmlspecialchars(@$x_kurum); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">gorev&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_gorev" size="30" maxlength="255" value="<?php echo htmlspecialchars(@$x_gorev); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">mezuniyet&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_mezuniyet" size="30" maxlength="100" value="<?php echo htmlspecialchars(@$x_mezuniyet); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">mezuniyet yil&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_mezuniyet_yil" size="30" maxlength="4" value="<?php echo htmlspecialchars(@$x_mezuniyet_yil); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">mezuniyet bolum&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_mezuniyet_bolum" size="30" maxlength="100" value="<?php echo htmlspecialchars(@$x_mezuniyet_bolum); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">is addr&nbsp;</td>
<td bgcolor="#F5F5F5"><textarea name="x_is_addr" cols="35" rows="4"><?php echo @$x_is_addr ?></textarea>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">semt&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_semt" size="30" maxlength="100" value="<?php echo htmlspecialchars(@$x_semt); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">sehir&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_sehir" size="30" maxlength="100" value="<?php echo htmlspecialchars(@$x_sehir); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">pkod&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_pkod" size="30" maxlength="5" value="<?php echo htmlspecialchars(@$x_pkod); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Pass Word&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="password" name="x_PassWord" value="<?php echo @$x_PassWord ?>" size=30 maxlength=100>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Resim&nbsp;</td>
<td bgcolor="#F5F5F5"><?php $x_Resim = ""; // temizlik ?>
<input type="file" name="x_Resim">&nbsp;</td>
</tr>
</table>
<p>
<input type="submit" name="Action" value="EKLE">
</form>
<?php include ("footer.php") ?>
