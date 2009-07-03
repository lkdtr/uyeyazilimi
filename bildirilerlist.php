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
$displayRecs = 50;
$recRange = 10;
$dbwhere = "";
$masterdetailwhere = "";
$searchwhere = "";
$a_search = "";
$b_search = "";
$whereClause = "";

// detayli arama kriterleri

// field "BildiriBaslik"
$x_BildiriBaslik = @$_GET["x_BildiriBaslik"];
$z_BildiriBaslik = @$_GET["z_BildiriBaslik"];
$z_BildiriBaslik = (get_magic_quotes_gpc()) ? stripslashes($z_BildiriBaslik) : $z_BildiriBaslik;
$arrfieldopr = explode(",", $z_BildiriBaslik);
if ($x_BildiriBaslik <> "" && count($arrfieldopr) >= 3) {
	$x_BildiriBaslik = (!get_magic_quotes_gpc()) ? addslashes($x_BildiriBaslik) : $x_BildiriBaslik;
	$a_search = $a_search . "BildiriBaslik " . $arrfieldopr[0] . " " . $arrfieldopr[1] . $x_BildiriBaslik . $arrfieldopr[2] . " AND ";
}

// field "BildiriText"
$x_BildiriText = @$_GET["x_BildiriText"];
$z_BildiriText = @$_GET["z_BildiriText"];
$z_BildiriText = (get_magic_quotes_gpc()) ? stripslashes($z_BildiriText) : $z_BildiriText;
$arrfieldopr = explode(",", $z_BildiriText);
if ($x_BildiriText <> "" && count($arrfieldopr) >= 3) {
	$x_BildiriText = (!get_magic_quotes_gpc()) ? addslashes($x_BildiriText) : $x_BildiriText;
	$a_search = $a_search . "BildiriText " . $arrfieldopr[0] . " " . $arrfieldopr[1] . $x_BildiriText . $arrfieldopr[2] . " AND ";
}

// field "BildiriAktif"
$x_BildiriAktif = @$_GET["x_BildiriAktif"];
$z_BildiriAktif = @$_GET["z_BildiriAktif"];
$z_BildiriAktif = (get_magic_quotes_gpc()) ? stripslashes($z_BildiriAktif) : $z_BildiriAktif;
$arrfieldopr = explode(",", $z_BildiriAktif);
if ($x_BildiriAktif <> "" && count($arrfieldopr) >= 3) {
	$x_BildiriAktif = (!get_magic_quotes_gpc()) ? addslashes($x_BildiriAktif) : $x_BildiriAktif;
	$a_search = $a_search . "BildiriAktif " . $arrfieldopr[0] . " " . $arrfieldopr[1] . $x_BildiriAktif . $arrfieldopr[2] . " AND ";
}

// field "BildiriTur"
$x_BildiriTur = @$_GET["x_BildiriTur"];
$z_BildiriTur = @$_GET["z_BildiriTur"];
$z_BildiriTur = (get_magic_quotes_gpc()) ? stripslashes($z_BildiriTur) : $z_BildiriTur;
$arrfieldopr = explode(",", $z_BildiriTur);
if ($x_BildiriTur <> "" && count($arrfieldopr) >= 3) {
	$x_BildiriTur = (!get_magic_quotes_gpc()) ? addslashes($x_BildiriTur) : $x_BildiriTur;
	$a_search = $a_search . "BildiriTur " . $arrfieldopr[0] . " " . $arrfieldopr[1] . $x_BildiriTur . $arrfieldopr[2] . " AND ";
}
if (strlen($a_search) > 4) {
	$a_search = substr($a_search, 0, strlen($a_search)-4);
}

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
			$b_search .= "BildiriBaslik LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "BildiriText LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "BildiriAktif LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "StatikSayfa LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "BildiriURL LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "BildiriTur LIKE '%" . trim($kw) . "%' OR ";
			if (substr($b_search, -4) == " OR ") {
				$b_search = substr($b_search, 0, strlen($b_search)-4);
			}
			$b_search .= ") " . $pSearchType . " ";
		}
	}	else {
		$b_search .= "BildiriBaslik LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "BildiriText LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "BildiriAktif LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "StatikSayfa LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "BildiriURL LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "BildiriTur LIKE '%" . $pSearch . "%' OR ";
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
	$_SESSION["bildiriler_searchwhere"] = $searchwhere;
	$startRec = 1; //kayit sayaci sifirlaniyor (new search)
	$_SESSION["bildiriler_REC"] = $startRec;
}	else {
	$searchwhere = @$_SESSION["bildiriler_searchwhere"];
}

// temiz bir arama baslat
if (@$_GET["cmd"] <> "") {
	$cmd = $_GET["cmd"];
	if (strtoupper($cmd) == "RESET") {
		$searchwhere = ""; //ni resetle
		$_SESSION["bildiriler_searchwhere"] = $searchwhere;
	}	elseif (strtoupper($cmd) == "RESETALL") {
		$searchwhere = ""; //ni resetle
		$_SESSION["bildiriler_searchwhere"] = $searchwhere;
	}
	$startRec = 1; //kayit sayaci sifirlaniyor (reset command)
	$_SESSION["bildiriler_REC"] = $startRec;
}

// where kismisi
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
$DefaultOrder = "";
$DefaultOrderType = "";

// filtreleme
$DefaultFilter = "BildiriAktif='Aktif'";

// order parametresi var mi kontrol et
$OrderBy = "";
if (@$_GET["order"] <> "") {
	$OrderBy = $_GET["order"];

	// ASC/DSC gerekiyormu bak
	if (@$_SESSION["bildiriler_OB"] == $OrderBy) {
		if (@$_SESSION["bildiriler_OT"] == "ASC") {
			$_SESSION["bildiriler_OT"] = "DESC";
		} else {
			$_SESSION["bildiriler_OT"] = "ASC";
		}
	} else {
		$_SESSION["bildiriler_OT"] = "ASC";
	}
	$_SESSION["bildiriler_OB"] = $OrderBy;
	$_SESSION["bildiriler_REC"] = 1;
} else {
	$OrderBy = @$_SESSION["bildiriler_OB"];
	if ($OrderBy == "") {
		$OrderBy = $DefaultOrder;
		$_SESSION["bildiriler_OB"] = $OrderBy;
		$_SESSION["bildiriler_OT"] = $DefaultOrderType;
	}
}
$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB);

// build SQL
$strsql = "SELECT * FROM bildiriler";
if ($DefaultFilter <> "") {
	$whereClause .= "(" . $DefaultFilter . ") AND ";
}
if ($dbwhere <> "" ) {
	$whereClause .= "(" . $dbwhere . ") AND ";
}
if (($ewCurSec & ewAllowList) <> ewAllowList) {
	$whereClause .= "(0=1) AND ";
}
if (substr($whereClause, -5) == " AND ") {
	$whereClause = substr($whereClause, 0, strlen($whereClause)-5);
}
if ($whereClause <> "") {
	$strsql .= " WHERE " . $whereClause;
}
if ($OrderBy <> "") {
	$strsql .= " ORDER BY " . $OrderBy . " " . @$_SESSION["bildiriler_OT"];
}

//echo $strsql; // SQL cumlesini debug etmek icin commenti kaldirin
$rs = mysql_query($strsql);
$totalRecs = intval(@mysql_num_rows($rs));

// check for a START parameter
if (@$_GET["start"] <> "") {
	$startRec = $_GET["start"];
	$_SESSION["bildiriler_REC"] = $startRec;
}	elseif (@$_GET["pageno"] <> "") {
	$pageno = $_GET["pageno"];
	if (is_numeric($pageno)) {
		$startRec = ($pageno - 1)*$displayRecs + 1;
		if ($startRec <= 0) {
			$startRec = 1;
		} elseIf ($startRec >= (($totalRecs-1)/$displayRecs)*$displayRecs+1) {
			$startRec = (($totalRecs-1)/$displayRecs)*$displayRecs + 1;
		}
		$_SESSION["bildiriler_REC"] = $startRec;
	} else {
		$startRec = @$_SESSION["bildiriler_REC"];
		if (!is_numeric($startRec)) {
			$startRec = 1; // kayit sayaci sifirlaniyor
			$_SESSION["bildiriler_REC"] = $startRec;
		}
	}
}	else {
	$startRec = @$_SESSION["bildiriler_REC"];
	if (!is_numeric($startRec)) {
		$startRec = 1; // kayit sayaci sifirlaniyor
		$_SESSION["bildiriler_REC"] = $startRec;
	}
}
?>
<?php include ("header.php") ?>
<form action="bildirilerlist.php">
<table border="0" cellspacing="0" cellpadding="4">
	<tr>
				<td>Hızlı Arama (*)</td>
		<td>
					<input type="text" name="psearch" size="20">
			<input type="Submit" name="Submit" value="Git">
		&nbsp;&nbsp;<a href="bildirilerlist.php?cmd=reset">Tümünü Göster</a>
				&nbsp;&nbsp;<a href="bildirilersrch.php">Detaylı Arama</a>
		</td>
	</tr>
		<tr><td>&nbsp;</td><td><input type="radio" name="psearchtype" value="" checked>Tam Uyuşma&nbsp;&nbsp;<input type="radio" name="psearchtype" value="AND">Tüm Kelimeler&nbsp;&nbsp;<input type="radio" name="psearchtype" value="OR">Herhangi biri</td></tr>
</table>
</form>
<form method="post">
<table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
<tr bgcolor="#466176">
<td>
<a href="bildirilerlist.php?order=<?php echo urlencode("BildiriBaslik"); ?>"><font color="#FFFFFF">Bildiri Baslik&nbsp;(*)<?php if ($OrderBy == "BildiriBaslik") { ?><font face="Webdings"><?php echo (@$_SESSION["bildiriler_OT"] == "ASC") ? 5 : ((@$_SESSION["bildiriler_OT"] == "DESC") ? 6 : "") ?>
<?php } ?></a>
</td>
<td>
<a href="bildirilerlist.php?order=<?php echo urlencode("BildiriTarih"); ?>"><font color="#FFFFFF">Bildiri Tarih&nbsp;<?php if ($OrderBy == "BildiriTarih") { ?><font face="Webdings"><?php echo (@$_SESSION["bildiriler_OT"] == "ASC") ? 5 : ((@$_SESSION["bildiriler_OT"] == "DESC") ? 6 : "") ?>
<?php } ?></a>
</td>
<td>
<a href="bildirilerlist.php?order=<?php echo urlencode("BildiriAktif"); ?>"><font color="#FFFFFF">Bildiri Aktif&nbsp;<?php if ($OrderBy == "BildiriAktif") { ?><font face="Webdings"><?php echo (@$_SESSION["bildiriler_OT"] == "ASC") ? 5 : ((@$_SESSION["bildiriler_OT"] == "DESC") ? 6 : "") ?>
<?php } ?></a>
</td>
<td>
<a href="bildirilerlist.php?order=<?php echo urlencode("BildiriTur"); ?>"><font color="#FFFFFF">Bildiri Tur&nbsp;<?php if ($OrderBy == "BildiriTur") { ?><font face="Webdings"><?php echo (@$_SESSION["bildiriler_OT"] == "ASC") ? 5 : ((@$_SESSION["bildiriler_OT"] == "DESC") ? 6 : "") ?>
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
while (($row = @mysql_fetch_array($rs)) && ($recCount < $stopRec)) {
	$recCount++;
	if ($recCount >= $startRec)	{
		$recActual++;
		$bgcolor = "#FFFFFF"; // tablolarin ilk row rengi
		if (($recCount % 2) <> 0)	{ // alternatif row rengi
			$bgcolor = "#F5F5F5";
		}

		// --
		$key = @$row["BildiriID"];
		$x_BildiriID = @$row["BildiriID"];
		$x_BildiriBaslik = @$row["BildiriBaslik"];
		$x_BildiriText = @$row["BildiriText"];
		$x_BildiriTarih = @$row["BildiriTarih"];
		$x_BildiriAktif = @$row["BildiriAktif"];
		$x_BildiriURL = @$row["BildiriURL"];
		$x_BildiriTur = @$row["BildiriTur"];
?>
<tr bgcolor="<?php echo $bgcolor; ?>">
<td><?php echo trim($x_BildiriBaslik); ?>&nbsp;</td>
<td><?php echo FormatDateTime($x_BildiriTarih,7); ?>&nbsp;</td>
<td><?php
switch ($x_BildiriAktif) {
	case "Aktif":
		echo "Aktif";
		break;
	case "Pasif":
		echo "Pasif";
		break;
}
?>
&nbsp;</td>
<td><?php
switch ($x_BildiriTur) {
case "LKD Bildirileri":
		echo "LKD Bildirileri";
		break;
case "Ortak Bildiriler":
		echo "Ortak Bildiriler";
		break;
case "Diğer STK Bildirileri":
		echo "Diğer STK Bildirileri";
		break;
}
?>
&nbsp;</td>
<?php If (($ewCurSec & ewAllowView) == ewAllowView) { ?>
<td><a href="<?php echo (!is_null(@$row["BildiriID"])) ? "bildirilerview.php?key=".urlencode($row["BildiriID"]) : "javascript:alert('Invalid Record! Key is null');";	?>
"><img src='images/browse.gif' alt='Gör' width='16' height='16' border='0'></a></td>
<?php } ?>
<?php If (($ewCurSec & ewAllowEdit) == ewAllowEdit) { ?>
<td><a href="<?php echo (!is_null(@$row["BildiriID"])) ? "bildirileredit.php?key=".urlencode($row["BildiriID"]) : "javascript:alert('Invalid Record! Key is null');";	?>
"><img src='images/edit.gif' alt='Düzenle' width='16' height='16' border='0'></a></td>
<?php } ?>
<?php If (($ewCurSec & ewAllowAdd) == ewAllowAdd) { ?>
<td><a href="<?php echo (!is_null(@$row["BildiriID"])) ? "bildirileradd.php?key=".urlencode($row["BildiriID"]) : "javascript:alert('Invalid Record! Key is null');";	?>
"><img src='images/copy.gif' alt='Kopyala' width='16' height='16' border='0'></a></td>
<?php } ?>
<?php If (($ewCurSec & ewAllowDelete) == ewAllowDelete) { ?>
<td><a href="<?php echo (!is_null(@$row["BildiriID"])) ? "bildirilerdelete.php?key=".urlencode($row["BildiriID"]) : "javascript:alert('Invalid Record! Key is null');";	?>
"><img src='images/delete.gif' alt='Sil' width='16' height='16' border='0'></a></td>
<?php } ?>
</tr>
<?php
	}
}
?>
</table>
</form>
<?php

// baglantiyi kes ve result bosalt
@mysql_free_result($rs);
mysql_close($conn);
?>
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
	<td><a href="bildirilerlist.php?start=1"><img src="images/first.gif" alt="First" width="20" height="15" border="0"></a></td>
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
	<td><a href="bildirilerlist.php?start=<?php echo $PrevStart; ?>"><img src="images/prev.gif" alt="Previous" width="20" height="15" border="0"></a></td>
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
	<td><a href="bildirilerlist.php?start=<?php echo $NextStart; ?>"><img src="images/next.gif" alt="Next" width="20" height="15" border="0"></a></td>
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
	<td><a href="bildirilerlist.php?start=<?php echo $LastStart; ?>"><img src="images/last.gif" alt="Last" width="20" height="15" border="0"></a></td>
<?php
	}
?>
<?php
	if (($ewCurSec & ewAllowAdd) == ewAllowAdd) {
?>
	<td><a href="bildirileradd.php"><img src="images/addnew.gif" alt="Add new" width="20" height="15" border="0"></a></td>
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
<a href="bildirileradd.php"><img src="images/addnew.gif" alt="Add new" width="20" height="15" border="0"></a>
<?php
	}
?>
</p>
<?php
}
?>
</td></tr></table>
<?php include ("footer.php") ?>