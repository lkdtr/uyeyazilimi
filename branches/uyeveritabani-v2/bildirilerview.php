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
if (($ewCurSec & ewAllowview) <> ewAllowview) header("Location: bildirilerlist.php");
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

// baglanti hazirlaniyor...
$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB);
switch ($a)
{
	case "I": // gosterilecek bir kayit  var
		$tkey = "" . $key . "";
		$strsql = "SELECT * FROM bildiriler WHERE BildiriID=" . $tkey;
		$rs = mysql_query($strsql,$conn) or die(mysql_error());
		if (mysql_num_rows($rs) == 0 ) {
			header("Location:bildirilerlist.php");
		}

		// degerleri ayir...
		$row = mysql_fetch_array($rs);
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
}
?>
<?php include ("header.php") ?>
<p><br><br><a href="bildirilerlist.php">Listeye Dön</a></p>
<TABLE width="80%"  border="1" align="center" cellpadding="10" cellspacing="0" bordercolor="#CCCCCC" bgcolor="#f4f4f4">
  <TR>
    <TD><TABLE width="100%"  border="0" align="center" cellpadding="5" cellspacing="0">
      <TR>
        <TD class="flyoutHeading"><?php echo trim($x_BildiriBaslik); ?></TD>
      </TR>
      <TR>
        <TD class="norm10pt" style="font-weight: bold">
<?php
// burayi asiri boktan yapma kabiliyetini gostermisim...
// elim degse de duzeltsem bu utanctan da kurtulsak...
// FIXME: Degerler sayisallastirilacak veritabaninda.
switch ($x_BildiriTur) {
case "LKD Bildirileri":
		echo "LKD Bildirileri";
		break;
case "Ortak Bildiriler":
		echo "Ortak Bildiriler";
		break;
case "Diðer STK Bildirileri":
		echo "Diðer STK Bildirileri";
		break;
}
?>
          : <?php echo FormatDateTime($x_BildiriTarih,7); ?><BR></TD>
      </TR>
      <TR>
        <TD class="norm10pt" style="text-align:justify"><BLOCKQUOTE><?php echo str_replace(chr(10), "<br>" ,@$x_BildiriText . "") ?><?php echo $x_StatikSayfa; ?></BLOCKQUOTE></TD>
      </TR>
      <TR>
        <TD><a href="<?php echo $x_BildiriURL; ?>"><?php echo $x_BildiriURL; ?></a></TD>
      </TR>
      <TR>
        <TD>&nbsp;</TD>
      </TR>
      <TR>
        <TD>&nbsp;</TD>
      </TR>
    </TABLE></TD>
  </TR>
</TABLE><BR>
<p>
<p>
<?php include ("footer.php") ?>