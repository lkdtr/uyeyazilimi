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
$ewCurSec = 0; // baslangic guvenlik degeri
$ewCurIdx = intval(@$_SESSION["uy_status_UserLevel"]);
if ($ewCurIdx == -1) { //
	$ewCurSec = 31;
} elseif ($ewCurIdx > 0 && $ewCurIdx <= 1) {
	$ewCurSec = $ew_SecTable[$ewCurIdx-1];
}
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

// Eger Tek kullaniciya bakilacaksa arama degerlerini sifirlayalim
// Yoksa tek uyeninkiler de cikmiyor
// Ince ayrintiyi yakaladigi icin "Tesekkurler dfisek"
if( $_GET["x_uye_id"] )
	$_SESSION["odemeler_searchwhere"] = "";

$displayRecs = 50;
$recRange = 10;
$dbwhere = "";
$masterdetailwhere = "";
$searchwhere = "";
$a_search = "";
$b_search = "";
$whereClause = "";

// detayli arama kriterleri
/*
// field "miktar"
$x_miktar = @$_GET["x_miktar"];
$z_miktar = @$_GET["z_miktar"];
$z_miktar = (get_magic_quotes_gpc()) ? stripslashes($z_miktar) : $z_miktar;
$arrfieldopr = explode(",", $z_miktar);
if ($x_miktar <> "" && count($arrfieldopr) >= 3) {
	$x_miktar = (!get_magic_quotes_gpc()) ? addslashes($x_miktar) : $x_miktar;
	$a_search = $a_search . "miktar " . $arrfieldopr[0] . " " . $arrfieldopr[1] . $x_miktar . $arrfieldopr[2] . " AND ";
}

// field "tur"
$x_tur = @$_GET["x_tur"];
$z_tur = @$_GET["z_tur"];
$z_tur = (get_magic_quotes_gpc()) ? stripslashes($z_tur) : $z_tur;
$arrfieldopr = explode(",", $z_tur);
if ($x_tur <> "" && count($arrfieldopr) >= 3) {
	$x_tur = (!get_magic_quotes_gpc()) ? addslashes($x_tur) : $x_tur;
	$a_search = $a_search . "tur " . $arrfieldopr[0] . " " . $arrfieldopr[1] . $x_tur . $arrfieldopr[2] . " AND ";
}

// field "tarih"
$x_tarih = @$_GET["x_tarih"];
$z_tarih = @$_GET["z_tarih"];
$z_tarih = (get_magic_quotes_gpc()) ? stripslashes($z_tarih) : $z_tarih;
$arrfieldopr = explode(",", $z_tarih);
if ($x_tarih <> "" && count($arrfieldopr) >= 3) {
	$x_tarih = (!get_magic_quotes_gpc()) ? addslashes($x_tarih) : $x_tarih;
	$a_search = $a_search . "tarih " . $arrfieldopr[0] . " " . $arrfieldopr[1] . $x_tarih . $arrfieldopr[2] . " AND ";
}

// field "notlar"
$x_notlar = @$_GET["x_notlar"];
$z_notlar = @$_GET["z_notlar"];
$z_notlar = (get_magic_quotes_gpc()) ? stripslashes($z_notlar) : $z_notlar;
$arrfieldopr = explode(",", $z_notlar);
if ($x_notlar <> "" && count($arrfieldopr) >= 3) {
	$x_notlar = (!get_magic_quotes_gpc()) ? addslashes($x_notlar) : $x_notlar;
	$a_search = $a_search . "notlar " . $arrfieldopr[0] . " " . $arrfieldopr[1] . $x_notlar . $arrfieldopr[2] . " AND ";
}

// field "odemeyolu"
$x_odemeyolu = @$_GET["x_odemeyolu"];
$z_odemeyolu = @$_GET["z_odemeyolu"];
$z_odemeyolu = (get_magic_quotes_gpc()) ? stripslashes($z_odemeyolu) : $z_odemeyolu;
$arrfieldopr = explode(",", $z_odemeyolu);
if ($x_odemeyolu <> "" && count($arrfieldopr) >= 3) {
	$x_odemeyolu = (!get_magic_quotes_gpc()) ? addslashes($x_odemeyolu) : $x_odemeyolu;
	$a_search = $a_search . "odemeyolu " . $arrfieldopr[0] . " " . $arrfieldopr[1] . $x_odemeyolu . $arrfieldopr[2] . " AND ";
}
if (strlen($a_search) > 4) {
	$a_search = substr($a_search, 0, strlen($a_search)-4);
}
*/
// basit arama kriterleri
$pSearch = @$_GET["psearch"];
$pSearchType = @$_GET["psearchtype"];
if ($pSearch <> "") {
	
	$pSearch = str_replace("'", "\'", $pSearch);
	if ($pSearchType <> "")	{
		while (strpos($pSearch, "  ") > 0) {
			$pSearch = str_Replace("  ", " ",$pSearch);
		}
		$arpSearch = explode(" ", trim($pSearch));
		foreach ($arpSearch as $kw) {
			$b_search .= "(";
			$b_search .= "tur LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "notlar LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "tarih LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "miktar = " . intval($kw) . " OR ";
			$b_search .= "odemeyolu LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "makbuz LIKE '%" . trim($kw) . "%' OR ";
			if (substr($b_search, -4) == " OR ") {
				$b_search = substr($b_search, 0, strlen($b_search)-4);
			}
			$b_search .= ") " . $pSearchType . " ";
		}
	}	else {
		$b_search .= "tur LIKE '%" . trim($pSearch) . "%' OR ";
		$b_search .= "notlar LIKE '%" . trim($pSearch) . "%' OR ";
		$b_search .= "tarih LIKE '%" . trim($pSearch) . "%' OR ";
		$b_search .= "miktar = " . trim($pSearch) . " OR ";
		$b_search .= "odemeyolu LIKE '%" . trim($pSearch) . "%' OR ";
		$b_search .= "makbuz LIKE '%" . trim($pSearch) . "%' OR ";
	}
}
if (substr($b_search, -4) == " OR ") {
	$b_search = substr($b_search, 0, strlen($b_search)-4);
}
if (substr($b_search, -5) == " AND ") {
	$b_search = substr($b_search, 0, strlen($b_search)-5);
}

//
if ($a_search <> "") {
	$searchwhere = $a_search; //detayli arama
}	elseIf ($b_search <> "") {
	$searchwhere = $b_search; //basit arama
}

// --
if ($searchwhere <> "") {
	$_SESSION["odemeler_searchwhere"] = $searchwhere;
	$startRec = 1; //kayit sayaci sifirlaniyor (new search)
	$_SESSION["odemeler_REC"] = $startRec;
}	else {
	$searchwhere = @$_SESSION["odemeler_searchwhere"];
}

// temiz bir arama baslat
if (@$_GET["cmd"] <> "") {
	$cmd = $_GET["cmd"];
	if (strtoupper($cmd) == "RESET") {
		$searchwhere = ""; // resetle
		$_SESSION["odemeler_searchwhere"] = $searchwhere;
	}	elseif (strtoupper($cmd) == "RESETALL") {
		$searchwhere = ""; // resetle
		$_SESSION["odemeler_searchwhere"] = $searchwhere;
	}
	$startRec = 1; //kayit sayaci sifirlaniyor (reset command)
	$_SESSION["odemeler_REC"] = $startRec;
}

// where kismi
if ($masterdetailwhere <> "" ) {
	$dbwhere .= "(" . $masterdetailwhere . ") AND ";
}
if ($searchwhere <> "" ) {
	$dbwhere .= "(" . $searchwhere . ") AND ";
}
if (strlen($dbwhere) > 5) {
	$dbwhere = substr($dbwhere, 0, strlen($dbwhere)-5); // AND sag tarafini temizle
}

// siralama
$DefaultOrder = "tarih";
$DefaultOrderType = "DESC";

// filtreleme
$DefaultFilter = "";

// order parametresi var mi kontrol et
$OrderBy = "$tarih";
if (@$_GET["order"] <> "") {
	$OrderBy = $_GET["order"];

	// ASC/DSC gerekiyormu bak
	if (@$_SESSION["odemeler_OB"] == $OrderBy) {
		if (@$_SESSION["odemeler_OT"] == "ASC") {
			$_SESSION["odemeler_OT"] = "DESC";
		} else {
			$_SESSION["odemeler_OT"] = "ASC";
		}
	} else {
		$_SESSION["odemeler_OT"] = "ASC";
	}
	$_SESSION["odemeler_OB"] = $OrderBy;
	$_SESSION["odemeler_REC"] = 1;
} else {
	$OrderBy = @$_SESSION["odemeler_OB"];
	if ($OrderBy == "") {
		$OrderBy = $DefaultOrder;
		$_SESSION["odemeler_OB"] = $OrderBy;
		$_SESSION["odemeler_OT"] = $DefaultOrderType;
	}
}
$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB);
        mysql_query("SET NAMES 'utf8'");

// build SQL
$strsql = "SELECT * FROM odemeler";
if ($DefaultFilter <> "") {
	$whereClause .= "(" . $DefaultFilter . ") AND ";
}
if ($dbwhere <> "" ) {
	$whereClause .= "(" . $dbwhere . ") AND ";
}
if (($ewCurSec & ewAllowList) <> ewAllowList) {
	$whereClause .= "(0=1) AND ";
}
if (@$_SESSION["uy_status_UserLevel"] <> -1) { // yonetici degil ise
	$whereClause .= "(uye_id = " . @$_SESSION["uy_status_UserID"] . ") AND ";
}
if (substr($whereClause, -5) == " AND ") {
	$whereClause = substr($whereClause, 0, strlen($whereClause)-5);
}
if ($whereClause <> "") {
	$strsql .= " WHERE " . $whereClause;
}
if ($_GET["x_uye_id"] <> "") {
// filtre
	$IsimFilter = $_GET["x_uye_id"];
	if (($ewCurSec & ewAllowAdd) == ewAllowAdd) {
		$strsql .= " WHERE uye_id = '$IsimFilter'";
	}
}
/*
// fixme: burasi sadece odeme detayli aramasini duzeltmek icin var, 
// anlayacagin bug duzeltmek icin kendimiz bug yazdik hehe :( 
// simdi basit arama calismiyor iyi mi?
if ($_GET["x_uye_id"] <> "") {
	$IsimFilter = $_GET["x_uye_id"];
		if (($ewCurSec & ewAllowAdd) == ewAllowAdd) {
			if (($_GET["x_miktar"] <> "") || ($_GET["x_tarih"] <> "") || ($_GET["x_notlar"] <> "") || ($_GET["x_odemeyolu"] <> "") || ($_GET["x_miktar"] <> "")) { 
				$strsql .= " AND uye_id = '$IsimFilter'";
			}
			else {
				$strsql .= " WHERE uye_id = '$IsimFilter'";
			}
	}
}
*/

if ($OrderBy <> "") {
	$strsql .= " ORDER BY " . $OrderBy . " " . @$_SESSION["odemeler_OT"];
}
// echo $strsql;//die(); // SQL cumlesini debug etmek icin commenti kaldirin
$rs = mysql_query($strsql);
$totalRecs = intval(@mysql_num_rows($rs));

//
if (@$_GET["start"] <> "") {
	$startRec = $_GET["start"];
	$_SESSION["odemeler_REC"] = $startRec;
}	elseif (@$_GET["pageno"] <> "") {
	$pageno = $_GET["pageno"];
	if (is_numeric($pageno)) {
		$startRec = ($pageno - 1)*$displayRecs + 1;
		if ($startRec <= 0) {
			$startRec = 1;
		} elseIf ($startRec >= (($totalRecs-1)/$displayRecs)*$displayRecs+1) {
			$startRec = (($totalRecs-1)/$displayRecs)*$displayRecs + 1;
		}
		$_SESSION["odemeler_REC"] = $startRec;
	} else {
		$startRec = @$_SESSION["odemeler_REC"];
		if (!is_numeric($startRec)) {
			$startRec = 1; // kayit sayaci sifirlaniyor
			$_SESSION["odemeler_REC"] = $startRec;
		}
	}
}	else {
	$startRec = @$_SESSION["odemeler_REC"];
	if (!is_numeric($startRec)) {
		$startRec = 1; // kayit sayaci sifirlaniyor
		$_SESSION["odemeler_REC"] = $startRec;
	}
}
?>
<?php include ("header.php") ?>
<? if ($_SESSION["uy_status_UserLevel"] <> 1) { /* ekleme izni varsa, admindir... kayit navigasyon bas */ ?>
<form action="odemelerlist.php">
<table border="0" cellspacing="0" cellpadding="4">
	<tr>
		<td>Hızlı Arama (*)</td>
		<td>
			<input type="text" name="psearch" size="20">
			<input type="Submit" name="Submit" value="Git">
			&nbsp;&nbsp;<a href="odemelerlist.php?cmd=reset">Tümünü Göster</a>
			<!--&nbsp;&nbsp;<a href="odemelersrch.php">Detaylı Arama</a>-->
		</td>
	</tr>
		<tr><td>&nbsp;</td>
		<td><input type="radio" name="psearchtype" value="" checked>Tam Uyuşma&nbsp;&nbsp;<input type="radio" name="psearchtype" value="AND">Tüm Kelimeler&nbsp;&nbsp;<input type="radio" name="psearchtype" value="OR">Herhangi biri</td>
	</tr>
</table>
</form>
<? 

} /* admin degilse odemelerde aramayi gostermeyelim... son */
 if ($_SESSION["uy_status_UserLevel"] <> -1) {
 	$_GET["key"] = $_GET["x_uye_id"];
 	if($_GET["cmd"] == "resetall")
 		$_GET["key"] = $_SESSION["uy_status_UserID"];
 }
?>
<form method="post">
<table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
<tr bgcolor="#466176">
<td>
<a href="odemelerlist.php?order=<?php echo urlencode("uye_id"); ?>"><font color="#FFFFFF">Ad Soyad&nbsp;<?php if ($OrderBy == "uye_id") { ?><font face="Webdings"><?php echo (@$_SESSION["odemeler_OT"] == "ASC") ? "(+)" : ((@$_SESSION["odemeler_OT"] == "DESC") ? "(-)" : "") ?>
<?php } ?></a>
</td>
<td align="right">
<a href="odemelerlist.php?order=<?php echo urlencode("miktar"); ?>"><font color="#FFFFFF">Miktar&nbsp;<?php if ($OrderBy == "miktar") { ?><font face="Webdings"><?php echo (@$_SESSION["odemeler_OT"] == "ASC") ? "(+)" : ((@$_SESSION["odemeler_OT"] == "DESC") ? "(-)" : "") ?>
<?php } ?></a>
</td>
<td>
<a href="odemelerlist.php?order=<?php echo urlencode("tur"); ?>"><font color="#FFFFFF">Tür&nbsp;<?php if ($OrderBy == "tur") { ?><font face="Webdings"><?php echo (@$_SESSION["odemeler_OT"] == "ASC") ? "(+)" : ((@$_SESSION["odemeler_OT"] == "DESC") ? "(-)" : "") ?>
<?php } ?></a>
</td>
<td>
<a href="odemelerlist.php?order=<?php echo urlencode("tarih"); ?>"><font color="#FFFFFF">Tarih&nbsp;<?php if ($OrderBy == "tarih") { ?><font face="Webdings"><?php echo (@$_SESSION["odemeler_OT"] == "ASC") ? "(+)" : ((@$_SESSION["odemeler_OT"] == "DESC") ? "(-)" : "") ?>
<?php } ?></a>
</td>
<?php If (($ewCurSec & ewAllowView) == ewAllowView) { ?>
<td>&nbsp;</td>
<?php } ?>
<?php If (($ewCurSec & ewAllowEdit) == ewAllowEdit) { ?>
<td>&nbsp;</td>
<?php } ?>
<?php If (($ewCurSec & ewAllowAdd) == ewAllowAdd) { ?>
<td>&nbsp;</td>
<?php } ?>
<?php If (($ewCurSec & ewAllowDelete) == ewAllowDelete) { ?>
<td>&nbsp;</td>
<?php } ?>
</tr>
<?php

// kayit baslangici toplamdan buyuk olmamali!
if ($startRec > $totalRecs) {
	$startRec = $totalRecs;
}

// son gosterilecek kaydi belirle
$stopRec = $startRec + $displayRecs - 1;
$recCount = $startRec - 1;

// ilk kayita git
@mysql_data_seek($rs, $recCount);
$recActual = 0;
$x_AidatToplam = $x_BagisToplam = $x_DigerToplam = 0;
while (($row = @mysql_fetch_array($rs)) && ($recCount < $stopRec)) {
	$recCount++;
	if ($recCount >= $startRec)	{
		$recActual++;
		$bgcolor = "#FFFFFF"; // tablolarin ilk row rengi
		if (($recCount % 2) <> 0)	{ // alternatif row rengi
			$bgcolor = "#F5F5F5";
		}

		// --
		$key = @$row["id"];
		$x_uye_id = @$row["uye_id"];
		$x_miktar = @$row["miktar"];
		$x_tur = @$row["tur"];
		$x_id = @$row["id"];
		$x_tarih = @$row["tarih"];
		$x_notlar = @$row["notlar"];
		$x_odemeyolu = @$row["odemeyolu"];
		$x_makbuz = @$row["makbuz"];
//		$x_miktar_toplam = $x_miktar++;
?>
<tr bgcolor="<?php echo $bgcolor; ?>">
<td><?php
if (!is_null($x_uye_id)) {
	$sqlwrk = "SELECT uye_id, uye_ad, uye_soyad, eposta1 FROM uyeler";
	$sqlwrk .= " WHERE uye_id = " . $x_uye_id;
	$rswrk = mysql_query($sqlwrk);
	if ($rswrk && $rowwrk = mysql_fetch_array($rswrk)) {
		$rowwrk = $rowwrk["uye_ad"] . " " . $rowwrk["uye_soyad"];
		$rowwrk_filter = $x_uye_id;
		echo "<a href=\"odemelerlist.php?x_uye_id=$rowwrk_filter\">$rowwrk</a>";
	}
	@mysql_free_result($rswrk);
}
?>
&nbsp;</td>
<td align="right"><?php echo (is_numeric($x_miktar)) ? FormatCurrency($x_miktar,0,-2,-2,-2) : $x_miktar; ?>&nbsp;</td>
<td><?php
switch ($x_tur) {
	case "aidat":
		echo "Üye Aidatı";
		$x_AidatToplam += $x_miktar;
		break;
	case "bagis":
		echo "Bağış";
		$x_BagisToplam += $x_miktar;
		break;
	case "diger":
		echo "Diğer";
		$x_DigerToplam += $x_miktar;
		break;
}
?>
&nbsp;</td>
<td><?php echo FormatDateTime($x_tarih,7); ?>&nbsp;</td>
<?php If (($ewCurSec & ewAllowView) == ewAllowView) { ?>
<td><a href="<?php echo (!is_null(@$row["id"])) ? "odemelerview.php?key=".urlencode($row["id"]) : "javascript:alert('Invalid Record! Key is null');";	?>
"><img src='images/browse.gif' alt='Gör' width='16' height='16' border='0'></a></td>
<?php } ?>
<?php If (($ewCurSec & ewAllowEdit) == ewAllowEdit) { ?>
<td><a href="<?php echo (!is_null(@$row["id"])) ? "odemeleredit.php?key=".urlencode($row["id"]) : "javascript:alert('Invalid Record! Key is null');";	?>
"><img src='images/edit.gif' alt='Düzenle' width='16' height='16' border='0'></a></td>
<?php } ?>
<?php If (($ewCurSec & ewAllowAdd) == ewAllowAdd) { ?>
<td><a href="<?php echo (!is_null(@$row["id"])) ? "odemeleradd.php?key=".urlencode($row["id"]) : "javascript:alert('Invalid Record! Key is null');";	?>
"><img src='images/copy.gif' alt='Kopyala' width='16' height='16' border='0'></a></td>
<?php } ?>
<?php If (($ewCurSec & ewAllowDelete) == ewAllowDelete) { ?>
<td><a href="<?php echo (!is_null(@$row["id"])) ? "odemelerdelete.php?key=".urlencode($row["id"]) : "javascript:alert('Invalid Record! Key is null');";	?>
"><img src='images/delete.gif' alt='Sil' width='16' height='16' border='0'></a></td>
<?php } ?>
</tr>
<?php
	}
}
?>
<tr><td colspan="5">
<table border=0 width="100%">
<?php if($x_AidatToplam) { ?>
<tr><td align="right" width="80%"><b>Bugüne Kadar Ödenen Toplam Aidat :</b></td><td align="right"><?php echo FormatCurrency($x_AidatToplam,0,-2,-2,-2);?></td></tr>
<?php }?>
<?php if($x_BagisToplam) { ?>
<tr><td align="right"><b>Toplam Bağış :</b></td><td align="right"><?php echo FormatCurrency($x_BagisToplam,0,-2,-2,-2);?></td></tr>
<?php }?>
<?php if($x_DigerToplam) { ?>
<tr><td align="right"><b>Toplam Diğer Ödemeler :</b></td><td align="right"><?php echo FormatCurrency($x_DigerToplam,0,-2,-2,-2);?></td></tr>
<?php }?>
</table>
</table>
</form>
<?php
	include ("yapilmayanodemelerlistforinclude.php");
?>
<? if ($_SESSION["uy_status_UserLevel"] <> 1) { /* admin ise kayit navigasyon bas */ ?>
<table border="0" cellspacing="0" cellpadding="10"><tr><td>
<?php
if ($totalRecs > 0) {
	$rsEof = ($totalRecs < ($startRec + $displayRecs));
	$PrevStart = $startRec - $displayRecs;
	if ($PrevStart < 1) $PrevStart = 1;
	$NextStart = $startRec + $displayRecs;
	if ($NextStart > $totalRecs ) $NextStart = $startRec;
	$LastStart = intval(($totalRecs-1)/$displayRecs)*$displayRecs+1;
?>
<form>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td>Sayfa&nbsp;</td>
<!--first page button-->
<?php
	if ($startRec == 1) {
?>
	<td><img src="images/firstdisab.gif" alt="First" width="20" height="15" border="0"></td>
<?php
	} else {
?>
	<td><a href="odemelerlist.php?start=1"><img src="images/first.gif" alt="First" width="20" height="15" border="0"></a></td>
<?php
	}
?>
<!--onceki sayfa dugmesi-->
<?php
	if ($PrevStart == $startRec) {
?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="20" height="15" border="0"></td>
<?php
	} else {
?>
	<td><a href="odemelerlist.php?start=<?php echo $PrevStart; ?>"><img src="images/prev.gif" alt="Previous" width="20" height="15" border="0"></a></td>
<?php
	}
?>
<!--current page number-->
	<td><input type="text" name="pageno" value="<?php echo intval(($startRec-1)/$displayRecs) +1; ?>" size="4" style="font-size: 9pt;"></td>
<!--next page button-->
<?php
	if ($NextStart == $startRec) {
?>
	<td><img src="images/nextdisab.gif" alt="Next" width="20" height="15" border="0"></td>
<?php
	} else {
?>
	<td><a href="odemelerlist.php?start=<?php echo $NextStart; ?>"><img src="images/next.gif" alt="Next" width="20" height="15" border="0"></a></td>
<?php
	}
?>
<!--son sayfa dugmesi-->
<?php
	if ($LastStart == $startRec) {?>
	<td><img src="images/lastdisab.gif" alt="Last" width="20" height="15" border="0"></td>
<?php
	} else {
?>
	<td><a href="odemelerlist.php?start=<?php echo $LastStart; ?>"><img src="images/last.gif" alt="Last" width="20" height="15" border="0"></a></td>
<?php
	}
?>
<?php
	if (($ewCurSec & ewAllowAdd) == ewAllowAdd) {
?>
	<td><a href="odemeleradd.php"><img src="images/addnew.gif" alt="Add new" width="20" height="15" border="0"></a></td>
<?php
 	}
?>
	<td>&nbsp;of <?php echo intval(($totalRecs-1)/$displayRecs) + 1; ?></td>
	</td></tr></table>
</form>
<?php
	if ($startRec > $totalRecs) {
		$startRec = $totalRecs;
	}
	$stopRec = $startRec + $displayRecs - 1;
	$recCount = $totalRecs - 1;
	if ($rsEof) {
		$recCount = $totalRecs;
	}
	if ($stopRec > $recCount) {
		$stopRec = $recCount;
	}
?>
	Kayıtlar <?php echo $startRec; ?>-<?php echo $stopRec; ?> Toplam: <?php echo $totalRecs; ?>
<?php
} else {
?>
<?php
	if (($ewCurSec & ewAllowList) == ewAllowList) {
?>
	Eşleşen Kayıt Bulunamadı!
<?php
	} else {
?>
	İzniniz Yok
<?php
	}
?>
<p>
<?php
	if (($ewCurSec & ewAllowAdd) == ewAllowAdd) {
?>
<a href="odemeleradd.php"><img src="images/addnew.gif" alt="Add new" width="20" height="15" border="0"></a>
<?php
	}
?>
</p>
<?php
}
?>
</td></tr></table>
<? } /* Kayit navig son*/ 
// baglantiyi kes ve result bosalt
@mysql_free_result($rs);
mysql_close($conn);
include ("footer.php");
?>
