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
$ewCurSec = 0; // baslat
$ewCurIdx = intval(@$_SESSION["uy_status_UserLevel"]);
if ($ewCurIdx == -1) { // system administrator
	$ewCurSec = 31;
} elseif ($ewCurIdx > 0 && $ewCurIdx <= 1) {
	$ewCurSec = $ew_SecTable[$ewCurIdx-1];
}
if (($ewCurSec & ewAllowsearch) <> ewAllowsearch) header("Location: odemelerlist.php");
?>
<?php if (@$_SESSION["uy_status_UserID"] == "" && @$_SESSION["uy_status_UserLevel"] <> -1 ) header("Location: login.php"); ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
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

	// build search criteria for advanced search, remove blank field
	$search_criteria = "";

	// field "uye_id"
//	$x_uye_id = @$_POST["x_uye_id"];
	$z_uye_id = @$_POST["z_uye_id"];
	if (is_array($x_uye_id)) $x_uye_id = implode(",", $x_uye_id);
	$x_uye_id = (get_magic_quotes_gpc() ? stripslashes($x_uye_id) : $x_uye_id);
	$z_uye_id = implode(",", $z_uye_id);
	$z_uye_id = (get_magic_quotes_gpc() ? stripslashes($z_uye_id) : $z_uye_id);
	if ($x_uye_id <> "") {
		$srchFld = $x_uye_id;
		$this_search_criteria = "x_uye_id=" . urlencode($srchFld);
//		$this_search_criteria .= "&z_uye_id=" . urlencode($z_uye_id);
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

	// field "miktar"
	$x_miktar = @$_POST["x_miktar"];
	$z_miktar = @$_POST["z_miktar"];
	if (is_array($x_miktar)) $x_miktar = implode(",", $x_miktar);
	$x_miktar = (get_magic_quotes_gpc() ? stripslashes($x_miktar) : $x_miktar);
	$z_miktar = implode(",", $z_miktar);
	$z_miktar = (get_magic_quotes_gpc() ? stripslashes($z_miktar) : $z_miktar);
	if ($x_miktar <> "") {
		$srchFld = $x_miktar;
		$this_search_criteria = "x_miktar=" . urlencode($srchFld);
		$this_search_criteria .= "&z_miktar=" . urlencode($z_miktar);
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

	// field "tur"
	$x_tur = @$_POST["x_tur"];
	$z_tur = @$_POST["z_tur"];
	if (is_array($x_tur)) $x_tur = implode(",", $x_tur);
	$x_tur = (get_magic_quotes_gpc() ? stripslashes($x_tur) : $x_tur);
	$z_tur = implode(",", $z_tur);
	$z_tur = (get_magic_quotes_gpc() ? stripslashes($z_tur) : $z_tur);
	if ($x_tur <> "") {
		$srchFld = $x_tur;
		$this_search_criteria = "x_tur=" . urlencode($srchFld);
		$this_search_criteria .= "&z_tur=" . urlencode($z_tur);
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

	// field "tarih"
	$x_tarih = @$_POST["x_tarih"];
	$z_tarih = @$_POST["z_tarih"];
	if (is_array($x_tarih)) $x_tarih = implode(",", $x_tarih);
	$x_tarih = (get_magic_quotes_gpc() ? stripslashes($x_tarih) : $x_tarih);
	$z_tarih = implode(",", $z_tarih);
	$z_tarih = (get_magic_quotes_gpc() ? stripslashes($z_tarih) : $z_tarih);
	if ($x_tarih <> "") {
		$srchFld = $x_tarih;
		$srchFld = ConvertDateToMysqlFormat($srchFld,7);
		$this_search_criteria = "x_tarih=" . urlencode($srchFld);
		$this_search_criteria .= "&z_tarih=" . urlencode($z_tarih);
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

	// field "notlar"
	$x_notlar = @$_POST["x_notlar"];
	$z_notlar = @$_POST["z_notlar"];
	if (is_array($x_notlar)) $x_notlar = implode(",", $x_notlar);
	$x_notlar = (get_magic_quotes_gpc() ? stripslashes($x_notlar) : $x_notlar);
	$z_notlar = implode(",", $z_notlar);
	$z_notlar = (get_magic_quotes_gpc() ? stripslashes($z_notlar) : $z_notlar);
	if ($x_notlar <> "") {
		$srchFld = $x_notlar;
		$this_search_criteria = "x_notlar=" . urlencode($srchFld);
		$this_search_criteria .= "&z_notlar=" . urlencode($z_notlar);
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

	// field "odemeyolu"
	$x_odemeyolu = @$_POST["x_odemeyolu"];
	$z_odemeyolu = @$_POST["z_odemeyolu"];
	if (is_array($x_odemeyolu)) $x_odemeyolu = implode(",", $x_odemeyolu);
	$x_odemeyolu = (get_magic_quotes_gpc() ? stripslashes($x_odemeyolu) : $x_odemeyolu);
	$z_odemeyolu = implode(",", $z_odemeyolu);
	$z_odemeyolu = (get_magic_quotes_gpc() ? stripslashes($z_odemeyolu) : $z_odemeyolu);
	if ($x_odemeyolu <> "") {
		$srchFld = $x_odemeyolu;
		$this_search_criteria = "x_odemeyolu=" . urlencode($srchFld);
		$this_search_criteria .= "&z_odemeyolu=" . urlencode($z_odemeyolu);
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
			header("Location: odemelerlist.php" . "?" . $search_criteria);
		}
		break;
}

// baglanti hazirlaniyor...
$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB);
?>
<?php include ("header.php") ?>
<p><br><br><a href="odemelerlist.php">Listeye Dön</a></font></a></p>
<script language="JavaScript" src="ew.js"></script>
<script language="JavaScript" src="popcalendar.js"></script>
<script language="JavaScript">
<!-- start Javascript
function  EW_checkMyForm(EW_this) {
if (EW_this.x_miktar && !EW_checkinteger(EW_this.x_miktar.value)) {
        if (!EW_onError(EW_this, EW_this.x_miktar, "TEXT", "Miktar Girmediniz!"))
            return false;
        }
if (EW_this.x_tarih && !EW_checkeurodate(EW_this.x_tarih.value)) {
        if (!EW_onError(EW_this, EW_this.x_tarih, "TEXT", "Incorrect date (dd/mm/yyyy) - tarih"))
            return false;
        }
return true;
}

// end JavaScript -->
</script>
<form onSubmit="return EW_checkMyForm(this);"  action="odemelersrch.php" method="post">
<p>
<input type="hidden" name="a" value="S">
<table width="60%" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
<tr>
<td bgcolor="#666666"><font color="#FFFFFF">uye id</font></font>&nbsp;</td>
<td bgcolor="#F5F5F5">
<input type="hidden" name="z_uye_id[]" value="=,,">
</font>&nbsp;</td>
<td bgcolor="#F5F5F5"><?php
$x_uye_idList = "<select name=\"x_uye_id\" size=10><option value=\"\">Lütfen Seçiniz</option>";
$sqlwrk = "SELECT uye_id, eposta1 FROM uyeler ORDER BY eposta1";
$rswrk = mysql_query($sqlwrk);
if ($rswrk) {
	$rowcntwrk = 0;
	while ($datawrk = mysql_fetch_array($rswrk)) {
		$x_uye_idList .= "<option value=\"" . htmlspecialchars($datawrk[0]) . "\"";
		if ($datawrk[0] == @$x_uye_id) {
			$x_uye_idList .= " selected";
		}
		$x_uye_idList .= ">" . $datawrk[1] . "</option>";
		$rowcntwrk++;
	}
}
@mysql_free_result($rswrk);
$x_uye_idList .= "</select>";
echo $x_uye_idList ;
?>
</font>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#666666"><font color="#FFFFFF">miktar</font></font>&nbsp;</td>
<td bgcolor="#F5F5F5">
<input type="hidden" name="z_miktar[]" value="=,,">
</font>&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_miktar" size="30" value="<?php echo htmlspecialchars(@$x_miktar); ?>"></font>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#666666"><font color="#FFFFFF">tur</font></font>&nbsp;</td>
<td bgcolor="#F5F5F5">
<input type="hidden" name="z_tur[]" value="LIKE,'%,%'"></font>&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="radio" name="x_tur" value="<?php echo htmlspecialchars("aidat"); ?>"><?php echo "Üye Aidatı"; ?>
<input type="radio" name="x_tur" value="<?php echo htmlspecialchars("bagis"); ?>"><?php echo "Bağış"; ?>
<input type="radio" name="x_tur" value="<?php echo htmlspecialchars("diger"); ?>"><?php echo "Diğer"; ?>
</font>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#666666"><font color="#FFFFFF">tarih</font></font>&nbsp;</td>
<td bgcolor="#F5F5F5">
<input type="hidden" name="z_tarih[]" value="=,','">
</font>&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_tarih" value="<?php echo FormatDateTime(@$x_tarih,7); ?>">&nbsp;<input type="image" src="images/ew_calendar.gif" alt="Pick a Date" onClick="popUpCalendar(this, this.form.x_tarih,'dd/mm/yyyy');return false;"></font>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#666666"><font color="#FFFFFF">notlar</font></font>&nbsp;</td>
<td bgcolor="#F5F5F5">
<input type="hidden" name="z_notlar[]" value="LIKE,'%,%'"></font>&nbsp;</td>
<td bgcolor="#F5F5F5"><textarea name="x_notlar" cols="35" rows="4"><?php echo @$x_notlar ?></textarea></font>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#666666"><font color="#FFFFFF">odemeyolu</font></font>&nbsp;</td>
<td bgcolor="#F5F5F5">
<input type="hidden" name="z_odemeyolu[]" value="LIKE,'%,%'"></font>&nbsp;</td>
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
$x_odemeyoluList .= "<option value=\"" . htmlspecialchars("diğer") . "\"";
if (@$x_odemeyolu == "diğer") {
	$x_odemeyoluList .= " selected";
}
$x_odemeyoluList .= ">" . "Diğer - Notlar Kısmına Bakınız" . "</option>";
$x_odemeyoluList .= "</select>";
echo $x_odemeyoluList;
?>
</font>&nbsp;</td>
</tr>
<tr>
  <td bgcolor="#666666">&nbsp;</td>
  <td bgcolor="#F5F5F5">&nbsp;</td>
  <td align="right" bgcolor="#F5F5F5"><INPUT type="submit" name="Action" value="Detaylı Arama"></td>
</tr>
</table>
<p>
</form>
<?php include ("footer.php") ?>
<?php mysql_close($conn); ?>