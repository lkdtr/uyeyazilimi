<?php
session_start();

define("DEFAULT_LOCALE", "tr_TR");
@setlocale(LC_ALL, DEFAULT_LOCALE);

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // gecmis zaman olurki
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // herdaim gunceliz
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false); 
header("Pragma: no-cache"); // HTTP/1.0 

include ("db.php");
include ("ayar.php");

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
        mysql_query("SET NAMES 'utf8'");

switch ($a)
{
	case "I": // gosterilecek bir kayit  var
		$tkey = "" . $key . "";
		$strsql = "SELECT * FROM odemeler WHERE id=" . $tkey;
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
            if (!EW_onError(EW_this, EW_this.x_odemeyolu, "SELECT", "Ödeme Ne Şekilde Yapıldı?"))
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
<td bgcolor="#F5F5F5">
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
<input type="hidden" name="x_uye_id" value="<?php echo htmlspecialchars(@$x_uye_id); ?>">
&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">miktar&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_miktar" size="30" value="<?php echo htmlspecialchars(@$x_miktar); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">tur&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="radio" name="x_tur"<?php if ($x_tur == "aidat") { echo " checked"; } ?> value="<?php echo htmlspecialchars("aidat"); ?>"><?php echo "Üye Aidatı"; ?>
<input type="radio" name="x_tur"<?php if ($x_tur == "bagis") { echo " checked"; } ?> value="<?php echo htmlspecialchars("bagis"); ?>"><?php echo "Bağış"; ?>
<input type="radio" name="x_tur"<?php if ($x_tur == "diger") { echo " checked"; } ?> value="<?php echo htmlspecialchars("diger"); ?>"><?php echo "Diğer"; ?>
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
$x_odemeyoluList .= "<option value=\"" . htmlspecialchars("diğer") . "\"";
if (@$x_odemeyolu == "diğer") {
	$x_odemeyoluList .= " selected";
}
$x_odemeyoluList .= ">" . "Diğer - Notlar Kısmına Bakınız" . "</option>";
$x_odemeyoluList .= "</select>";
echo $x_odemeyoluList;
?>
&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">makbuz&nbsp;</td>
<td bgcolor="#F5F5F5"><?php if (!is_null($x_makbuz)) { ?>
<input type="radio" name="a_x_makbuz" value="1" checked>Olduğu gibi bırak&nbsp;<input type="radio" name="a_x_makbuz" value="2">Çıkar&nbsp;<input type="radio" name="a_x_makbuz" value="3">Değiştir<br>
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
