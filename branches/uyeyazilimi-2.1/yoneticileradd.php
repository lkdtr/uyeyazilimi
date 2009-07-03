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
$ew_SecTable[0] = 0;

// tablo haklari
$ewCurSec = 0; // baslangic Sec degeri
$ewCurIdx = intval(@$_SESSION["uy_status_UserLevel"]);
if ($ewCurIdx == -1) { // 
	$ewCurSec = 31;
} elseif ($ewCurIdx > 0 && $ewCurIdx <= 1) { 
	$ewCurSec = $ew_SecTable[$ewCurIdx-1];
}
if (($ewCurSec & ewAllowadd) <> ewAllowadd) header("Location: yoneticilerlist.php");
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
		$strsql = "SELECT * FROM yoneticiler WHERE AdminID=" . $tkey;
		$rs = mysql_query($strsql);
		if (mysql_num_rows($rs) == 0) {
			ob_end_clean();
			header("Location: yoneticilerlist.php");
		} else {
			$row = mysql_fetch_array($rs);

		// degerleri ayir...
			$x_AdminAd = @$row["AdminAd"]; 
			$x_AdminPass = @$row["AdminPass"]; 
			$x_AdminMail = @$row["AdminMail"]; 
		}
		mysql_free_result($rs);
		break;
	case "A": // ekleme

		// form degerleri...
		$x_AdminID = @$_POST["x_AdminID"];
		$x_AdminAd = @$_POST["x_AdminAd"];
		$x_AdminPass = @$_POST["x_AdminPass"];
		$x_AdminMail = @$_POST["x_AdminMail"];

		// degerleri array'e atalim

		// AdminAd
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_AdminAd) : $x_AdminAd;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["AdminAd"] = $theValue;

		// AdminPass
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_AdminPass) : $x_AdminPass;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["AdminPass"] = $theValue;

		// AdminMail
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_AdminMail) : $x_AdminMail;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["AdminMail"] = $theValue;

		// vt ye yazma zamani
		$strsql = "INSERT INTO yoneticiler (";
		$strsql .= implode(",", array_keys($fieldList));
		$strsql .= ") VALUES (";
		$strsql .= implode(",", array_values($fieldList));
		$strsql .= ")";
	 	mysql_query($strsql, $conn) or die(mysql_error());
		mysql_close($conn);
		ob_end_clean();
		header("Location: yoneticilerlist.php");
		break;
}
?>
<?php include ("header.php") ?>
<p><br><br><a href="yoneticilerlist.php">Listeye Dön</a></p>
<script language="JavaScript" src="ew.js"></script>
<script language="JavaScript">
<!-- start Javascript
function  EW_checkMyForm(EW_this) {
if (EW_this.x_AdminAd && !EW_hasValue(EW_this.x_AdminAd, "TEXT" )) {
            if (!EW_onError(EW_this, EW_this.x_AdminAd, "TEXT", "Invalid Field"))
                return false; 
        }
if (EW_this.x_AdminPass && !EW_hasValue(EW_this.x_AdminPass, "PASSWORD" )) {
            if (!EW_onError(EW_this, EW_this.x_AdminPass, "PASSWORD", "Şifre Gİriniz!"))
                return false; 
        }
if (EW_this.x_AdminMail && !EW_hasValue(EW_this.x_AdminMail, "TEXT" )) {
            if (!EW_onError(EW_this, EW_this.x_AdminMail, "TEXT", "Geçerli bir e-mail adresi giriniz!"))
                return false; 
        }
if (EW_this.x_AdminMail && !EW_checkemail(EW_this.x_AdminMail.value)) {
        if (!EW_onError(EW_this, EW_this.x_AdminMail, "TEXT", "Geçerli bir e-mail adresi giriniz!"))
            return false; 
        }
return true;
}

// end JavaScript -->
</script>
<form onSubmit="return EW_checkMyForm(this);"  action="yoneticileradd.php" method="post">
<p>
<input type="hidden" name="a" value="A">
<table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Admin ID&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="hidden" name="x_AdminID" value="<?php echo htmlspecialchars(@$x_AdminID); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Admin Ad&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_AdminAd" size="30" maxlength="100" value="<?php echo htmlspecialchars(@$x_AdminAd); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Admin Pass&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="password" name="x_AdminPass" value="<?php echo @$x_AdminPass ?>" size=30 maxlength=100>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Admin Mail&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_AdminMail" size="30" maxlength="255" value="<?php echo htmlspecialchars(@$x_AdminMail); ?>">&nbsp;</td>
</tr>
</table>
<p>
<input type="submit" name="Action" value="EKLE">
</form>
<?php include ("footer.php") ?>
