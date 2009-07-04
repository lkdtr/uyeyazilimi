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

// baglanti hazirlaniyor...
$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB);
        mysql_query("SET NAMES 'utf8'");

switch ($a)
{
	case "I": // gosterilecek bir kayit  var
		$tkey = "" . $key . "";
		$strsql = "SELECT * FROM odemeler WHERE id=" . $tkey;
		$rs = mysql_query($strsql,$conn) or die(mysql_error());
		if (mysql_num_rows($rs) == 0 ) {
			header("Location:odemelerlist.php");
		}	

		// degerleri ayir...
		$row = mysql_fetch_array($rs);
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
}
?>
<?php include ("header.php") ?>
<p></p><br><br><a href="odemelerlist.php">Listeye Dön</a></p>
<p>
<form>
<table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Üye (e-posta)</td>
<td bgcolor="#F5F5F5"><?php
if (!is_null($x_uye_id)) {
	$sqlwrk = "SELECT uye_id, uye_ad, uye_soyad, eposta1 FROM uyeler";
	$sqlwrk .= " WHERE uye_id = " . $x_uye_id;
	$rswrk = mysql_query($sqlwrk);
	if ($rswrk && $rowwrk = mysql_fetch_array($rswrk)) {
		echo $rowwrk["uye_id"] . " " . $rowwrk["uye_ad"] . " " . $rowwrk["uye_soyad"] . " -- " . $rowwrk["eposta1"];
	}
	@mysql_free_result($rswrk);
}
?>
&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Ödeme Miktarı</td>
<td bgcolor="#F5F5F5"><?php echo (is_numeric($x_miktar)) ? FormatCurrency($x_miktar,0,-2,-2,-2) : $x_miktar; ?>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Ödeme Türü</td>
<td bgcolor="#F5F5F5"><?php
switch ($x_tur) {
	case "aidat":
		echo "Üye Aidatı";
		break;
	case "bagis":
		echo "Bağış";
		break;
	case "diger":
		echo "Diğer";
		break;
}
?>
&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Ödeme Tarihi</td>
<td bgcolor="#F5F5F5"><?php echo FormatDateTime($x_tarih,7); ?>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Ödeme Şekli</td>
<td bgcolor="#F5F5F5"><?php
switch ($x_odemeyolu) {
case "havale":
		echo "Banka Havalesi";
		break;
case "e-islem":
		echo "Elektronik Transfer";
		break;
case "posta":
		echo "Posta Nakit";
		break;
case "elden":
		echo "Elden Ödeme";
		break;
case "diğer":
		echo "Diğer - Notlar Kısmına Bakınız";
		break;
}
?>
&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Makbuz</td>
<td bgcolor="#F5F5F5"><?php if (!is_null($x_makbuz)) { ?>
<a href="<?=$MakbuzDizin?>/<?php echo @$x_makbuz; ?>" target="blank"><?php echo @$x_makbuz; ?></a>
<?php } ?>
&nbsp;</td>
</tr>
</table>
</form>
<p>
<?php include ("footer.php") ?>
