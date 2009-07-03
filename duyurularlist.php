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

// field "DuyuruBaslik"
$x_DuyuruBaslik = @$_GET["x_DuyuruBaslik"];
$z_DuyuruBaslik = @$_GET["z_DuyuruBaslik"];
$z_DuyuruBaslik = (get_magic_quotes_gpc()) ? stripslashes($z_DuyuruBaslik) : $z_DuyuruBaslik;
$arrfieldopr = explode(",", $z_DuyuruBaslik);
if ($x_DuyuruBaslik <> "" && count($arrfieldopr) >= 3) {
	$x_DuyuruBaslik = (!get_magic_quotes_gpc()) ? addslashes($x_DuyuruBaslik) : $x_DuyuruBaslik;
	$a_search = $a_search . "DuyuruBaslik " . $arrfieldopr[0] . " " . $arrfieldopr[1] . $x_DuyuruBaslik . $arrfieldopr[2] . " AND ";
}

// field "DuyuruText"
$x_DuyuruText = @$_GET["x_DuyuruText"];
$z_DuyuruText = @$_GET["z_DuyuruText"];
$z_DuyuruText = (get_magic_quotes_gpc()) ? stripslashes($z_DuyuruText) : $z_DuyuruText;
$arrfieldopr = explode(",", $z_DuyuruText);
if ($x_DuyuruText <> "" && count($arrfieldopr) >= 3) {
	$x_DuyuruText = (!get_magic_quotes_gpc()) ? addslashes($x_DuyuruText) : $x_DuyuruText;
	$a_search = $a_search . "DuyuruText " . $arrfieldopr[0] . " " . $arrfieldopr[1] . $x_DuyuruText . $arrfieldopr[2] . " AND ";
}

// field "DuyuruAktif"
$x_DuyuruAktif = @$_GET["x_DuyuruAktif"];
$z_DuyuruAktif = @$_GET["z_DuyuruAktif"];
$z_DuyuruAktif = (get_magic_quotes_gpc()) ? stripslashes($z_DuyuruAktif) : $z_DuyuruAktif;
$arrfieldopr = explode(",", $z_DuyuruAktif);
if ($x_DuyuruAktif <> "" && count($arrfieldopr) >= 3) {
	$x_DuyuruAktif = (!get_magic_quotes_gpc()) ? addslashes($x_DuyuruAktif) : $x_DuyuruAktif;
	$a_search = $a_search . "DuyuruAktif " . $arrfieldopr[0] . " " . $arrfieldopr[1] . $x_DuyuruAktif . $arrfieldopr[2] . " AND ";
}

// field "DuyuruTur"
$x_DuyuruTur = @$_GET["x_DuyuruTur"];
$z_DuyuruTur = @$_GET["z_DuyuruTur"];
$z_DuyuruTur = (get_magic_quotes_gpc()) ? stripslashes($z_DuyuruTur) : $z_DuyuruTur;
$arrfieldopr = explode(",", $z_DuyuruTur);
if ($x_DuyuruTur <> "" && count($arrfieldopr) >= 3) {
	$x_DuyuruTur = (!get_magic_quotes_gpc()) ? addslashes($x_DuyuruTur) : $x_DuyuruTur;
	$a_search = $a_search . "DuyuruTur " . $arrfieldopr[0] . " " . $arrfieldopr[1] . $x_DuyuruTur . $arrfieldopr[2] . " AND ";
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
			$b_search .= "DuyuruBaslik LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "DuyuruOzet LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "DuyuruText LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "DuyuruAktif LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "StatikSayfa LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "DuyuruTur LIKE '%" . trim($kw) . "%' OR ";
			if (substr($b_search, -4) == " OR ") {
				$b_search = substr($b_search, 0, strlen($b_search)-4);
			}
			$b_search .= ") " . $pSearchType . " ";
		}
	}	else {
		$b_search .= "DuyuruBaslik LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "DuyuruOzet LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "DuyuruText LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "DuyuruAktif LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "StatikSayfa LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "DuyuruTur LIKE '%" . $pSearch . "%' OR ";
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
	$_SESSION["duyurular_searchwhere"] = $searchwhere;
	$startRec = 1; //kayit sayaci sifirlaniyor (new search)
	$_SESSION["duyurular_REC"] = $startRec;
}	else {
	$searchwhere = @$_SESSION["duyurular_searchwhere"];
}

// temiz bir arama baslat
if (@$_GET["cmd"] <> "") {
	$cmd = $_GET["cmd"];
	if (strtoupper($cmd) == "RESET") {
		$searchwhere = ""; //ni resetle
		$_SESSION["duyurular_searchwhere"] = $searchwhere;
	}	elseif (strtoupper($cmd) == "RESETALL") {
		$searchwhere = ""; //ni resetle
		$_SESSION["duyurular_searchwhere"] = $searchwhere;
	}
	$startRec = 1; //kayit sayaci sifirlaniyor (reset command)
	$_SESSION["duyurular_REC"] = $startRec;
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
$DefaultOrder = "DuyuruTur";
$DefaultOrderType = "ASC";

// filtreleme
$DefaultFilter = "DuyuruAktif='Aktif'";

// order parametresi var mi kontrol et
$OrderBy = "";
if (@$_GET["order"] <> "") {
	$OrderBy = $_GET["order"];

	// ASC/DSC gerekiyormu bak
	if (@$_SESSION["duyurular_OB"] == $OrderBy) {
		if (@$_SESSION["duyurular_OT"] == "ASC") {
			$_SESSION["duyurular_OT"] = "DESC";
		} else {
			$_SESSION["duyurular_OT"] = "ASC";
		}
	} else {
		$_SESSION["duyurular_OT"] = "ASC";
	}
	$_SESSION["duyurular_OB"] = $OrderBy;
	$_SESSION["duyurular_REC"] = 1;
} else {
	$OrderBy = @$_SESSION["duyurular_OB"];
	if ($OrderBy == "") {
		$OrderBy = $DefaultOrder;
		$_SESSION["duyurular_OB"] = $OrderBy;
		$_SESSION["duyurular_OT"] = $DefaultOrderType;
	}
}
$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB);
        mysql_query("SET NAMES 'utf8'");

// build SQL
$strsql = "SELECT * FROM duyurular";
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
	$strsql .= " ORDER BY " . $OrderBy . " " . @$_SESSION["duyurular_OT"];
}

//echo $strsql; // SQL cumlesini debug etmek icin commenti kaldirin
$rs = mysql_query($strsql);
$totalRecs = intval(@mysql_num_rows($rs));

// check for a START parameter
if (@$_GET["start"] <> "") {
	$startRec = $_GET["start"];
	$_SESSION["duyurular_REC"] = $startRec;
}	elseif (@$_GET["pageno"] <> "") {
	$pageno = $_GET["pageno"];
	if (is_numeric($pageno)) {
		$startRec = ($pageno - 1)*$displayRecs + 1;
		if ($startRec <= 0) {
			$startRec = 1;
		} elseIf ($startRec >= (($totalRecs-1)/$displayRecs)*$displayRecs+1) {
			$startRec = (($totalRecs-1)/$displayRecs)*$displayRecs + 1;
		}
		$_SESSION["duyurular_REC"] = $startRec;
	} else {
		$startRec = @$_SESSION["duyurular_REC"];
		if (!is_numeric($startRec)) {
			$startRec = 1; // kayit sayaci sifirlaniyor
			$_SESSION["duyurular_REC"] = $startRec;
		}
	}
}	else {
	$startRec = @$_SESSION["duyurular_REC"];
	if (!is_numeric($startRec)) {
		$startRec = 1; // kayit sayaci sifirlaniyor
		$_SESSION["duyurular_REC"] = $startRec;
	}
}
?>
<?php include ("header.php") ?>
<p>&nbsp;</p>
<form action="duyurularlist.php">
<table border="0" cellspacing="0" cellpadding="4">
	<tr>
				<td>Hızlı Arama (*)</td>
		<td>
					<input type="text" name="psearch" size="20">
			<input type="Submit" name="Submit" value="Git">
		&nbsp;&nbsp;<a href="duyurularlist.php?cmd=reset">Tümünü Göster</a>
				&nbsp;&nbsp;<a href="duyurularsrch.php">Detaylı Arama</a>
		</td>
	</tr>
		<tr><td>&nbsp;</td><td><input type="radio" name="psearchtype" value="" checked>Tam Uyuşma&nbsp;&nbsp;<input type="radio" name="psearchtype" value="AND">Tüm Kelimeler&nbsp;&nbsp;<input type="radio" name="psearchtype" value="OR">Herhangi biri</td></tr>
</table>
</form>
<form method="post">
<table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
<tr bgcolor="#466176">
<td>
<a href="duyurularlist.php?order=<?php echo urlencode("DuyuruID"); ?>"><font color="#FFFFFF">Duyuru ID&nbsp;<?php if ($OrderBy == "DuyuruID") { ?><font face="Webdings"><?php echo (@$_SESSION["duyurular_OT"] == "ASC") ? 5 : ((@$_SESSION["duyurular_OT"] == "DESC") ? 6 : "") ?>
<?php } ?></a>
</td>
<td>
<a href="duyurularlist.php?order=<?php echo urlencode("DuyuruBaslik"); ?>"><font color="#FFFFFF">Duyuru Baslik&nbsp;(*)<?php if ($OrderBy == "DuyuruBaslik") { ?><font face="Webdings"><?php echo (@$_SESSION["duyurular_OT"] == "ASC") ? 5 : ((@$_SESSION["duyurular_OT"] == "DESC") ? 6 : "") ?>
<?php } ?></a>
</td>
<td>
<a href="duyurularlist.php?order=<?php echo urlencode("DuyuruTarih"); ?>"><font color="#FFFFFF">Duyuru Tarih&nbsp;<?php if ($OrderBy == "DuyuruTarih") { ?><font face="Webdings"><?php echo (@$_SESSION["duyurular_OT"] == "ASC") ? 5 : ((@$_SESSION["duyurular_OT"] == "DESC") ? 6 : "") ?>
<?php } ?></a>
</td>
<td>
<a href="duyurularlist.php?order=<?php echo urlencode("DuyuruSonTarih"); ?>"><font color="#FFFFFF">Duyuru Son Tarih&nbsp;<?php if ($OrderBy == "DuyuruSonTarih") { ?><font face="Webdings"><?php echo (@$_SESSION["duyurular_OT"] == "ASC") ? 5 : ((@$_SESSION["duyurular_OT"] == "DESC") ? 6 : "") ?>
<?php } ?></a>
</td>
<td>
<a href="duyurularlist.php?order=<?php echo urlencode("DuyuruAktif"); ?>"><font color="#FFFFFF">Duyuru Aktif&nbsp;<?php if ($OrderBy == "DuyuruAktif") { ?><font face="Webdings"><?php echo (@$_SESSION["duyurular_OT"] == "ASC") ? 5 : ((@$_SESSION["duyurular_OT"] == "DESC") ? 6 : "") ?>
<?php } ?></a>
</td>
<td>
<font color="#FFFFFF">Statik Sayfa&nbsp;<?php if ($OrderBy == "StatikSayfa") { ?><font face="Webdings"><?php echo (@$_SESSION["duyurular_OT"] == "ASC") ? 5 : ((@$_SESSION["duyurular_OT"] == "DESC") ? 6 : "") ?>
<?php } ?>
</td>
<td>
<a href="duyurularlist.php?order=<?php echo urlencode("DuyuruTur"); ?>"><font color="#FFFFFF">Duyuru Tur&nbsp;<?php if ($OrderBy == "DuyuruTur") { ?><font face="Webdings"><?php echo (@$_SESSION["duyurular_OT"] == "ASC") ? 5 : ((@$_SESSION["duyurular_OT"] == "DESC") ? 6 : "") ?>
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
		$key = @$row["DuyuruID"];
		$x_DuyuruID = @$row["DuyuruID"];
		$x_DuyuruBaslik = @$row["DuyuruBaslik"];
		$x_DuyuruOzet = @$row["DuyuruOzet"];
		$x_DuyuruText = @$row["DuyuruText"];
		$x_DuyuruTarih = @$row["DuyuruTarih"];
		$x_DuyuruSonTarih = @$row["DuyuruSonTarih"];
		$x_DuyuruAktif = @$row["DuyuruAktif"];
		$x_StatikSayfa = @$row["StatikSayfa"];
		$x_DuyuruTur = @$row["DuyuruTur"];
?>
<tr bgcolor="<?php echo $bgcolor; ?>">
<td><?php echo $x_DuyuruID; ?>&nbsp;</td>
<td><?php echo str_replace(chr(10), "<br>" ,@$x_DuyuruBaslik . "") ?>&nbsp;</td>
<td><?php echo FormatDateTime($x_DuyuruTarih,7); ?>&nbsp;</td>
<td><?php echo FormatDateTime($x_DuyuruSonTarih,7); ?>&nbsp;</td>
<td><?php
switch ($x_DuyuruAktif) {
	case "Aktif":
		echo "Aktif";
		break;
	case "Pasif":
		echo "Pasif";
		break;
}
?>
&nbsp;</td>
<td><?php if (!is_null($x_StatikSayfa)) { ?>
<a href="uye_resimleri/<?php echo @$x_StatikSayfa; ?>" target="blank"><?php echo @$x_StatikSayfa; ?></a>
<?php } ?>
&nbsp;</td>
<td><?php
switch ($x_DuyuruTur) {
case "LKD Uye Sistemi":
		echo "LKD Uye Sistemi";
		break;
case "LKD YK Çalışma Raporu":
		echo "LKD YK Çalışma Raporu";
		break;
case "Çalışma Grubu Raporu":
		echo "Çalışma Grubu Raporu";
		break;
case "LKD Genel Duyuru":
		echo "LKD Genel Duyuru";
		break;
case "Denetleme Kurulu Raporu":
		echo "Denetleme Kurulu Raporu";
		break;
case "Diğer Duyuru Konuları":
		echo "Diğer Duyuru Konuları";
		break;
}
?>
&nbsp;</td>
<?php If (($ewCurSec & ewAllowView) == ewAllowView) { ?>
<td><a href="<?php echo (!is_null(@$row["DuyuruID"])) ? "duyurularview.php?key=".urlencode($row["DuyuruID"]) : "javascript:alert('Invalid Record! Key is null');";	?>
"><img src='images/browse.gif' alt='Gör' width='16' height='16' border='0'></a></td>
<?php } ?>
<?php If (($ewCurSec & ewAllowEdit) == ewAllowEdit) { ?>
<td><a href="<?php echo (!is_null(@$row["DuyuruID"])) ? "duyurularedit.php?key=".urlencode($row["DuyuruID"]) : "javascript:alert('Invalid Record! Key is null');";	?>
"><img src='images/edit.gif' alt='Düzenle' width='16' height='16' border='0'></a></td>
<?php } ?>
<?php If (($ewCurSec & ewAllowAdd) == ewAllowAdd) { ?>
<td><a href="<?php echo (!is_null(@$row["DuyuruID"])) ? "duyurularadd.php?key=".urlencode($row["DuyuruID"]) : "javascript:alert('Invalid Record! Key is null');";	?>
"><img src='images/copy.gif' alt='Kopyala' width='16' height='16' border='0'></a></td>
<?php } ?>
<?php If (($ewCurSec & ewAllowDelete) == ewAllowDelete) { ?>
<td><a href="<?php echo (!is_null(@$row["DuyuruID"])) ? "duyurulardelete.php?key=".urlencode($row["DuyuruID"]) : "javascript:alert('Invalid Record! Key is null');";	?>
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
	<td><a href="duyurularlist.php?start=1"><img src="images/first.gif" alt="First" width="20" height="15" border="0"></a></td>
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
	<td><a href="duyurularlist.php?start=<?php echo $PrevStart; ?>"><img src="images/prev.gif" alt="Previous" width="20" height="15" border="0"></a></td>
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
	<td><a href="duyurularlist.php?start=<?php echo $NextStart; ?>"><img src="images/next.gif" alt="Next" width="20" height="15" border="0"></a></td>
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
	<td><a href="duyurularlist.php?start=<?php echo $LastStart; ?>"><img src="images/last.gif" alt="Last" width="20" height="15" border="0"></a></td>
<?php
	}
?>
<?php
	if (($ewCurSec & ewAllowAdd) == ewAllowAdd) {
?>
	<td><a href="duyurularadd.php"><img src="images/addnew.gif" alt="Add new" width="20" height="15" border="0"></a></td>
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
<a href="duyurularadd.php"><img src="images/addnew.gif" alt="Add new" width="20" height="15" border="0"></a>
<?php
	}
?>
</p>
<?php
}
?>
</td></tr></table>
<?php include ("footer.php") ?>
