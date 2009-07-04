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

// Eger Tek kullaniciya bakilacaksa arama degerlerini sifirlayalim
// Yoksa tek uyeninkiler de cikmiyor
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
if (substr($whereClause, -5) == " AND ") {
	$whereClause = substr($whereClause, 0, strlen($whereClause)-5);
}
if ($whereClause <> "") {
	$strsql .= " WHERE " . $whereClause;
}
if ($_GET["x_uye_id"] <> "") {
// filtre
	$IsimFilter = $_GET["x_uye_id"];
	$strsql .= " WHERE uye_id = '$IsimFilter'";
}

if ($OrderBy <> "") {
	$strsql .= " ORDER BY " . $OrderBy . " " . @$_SESSION["odemeler_OT"];
}
// echo $strsql;//die(); // SQL cumlesini debug etmek icin commenti kaldirin
$rs = mysql_query($strsql);
$totalRecs = intval(@mysql_num_rows($rs));

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
<form action="odemelerlist.php">
<table border="0" cellspacing="0" cellpadding="4">
	<tr>
		<td>Hızlı Arama</td>
		<td>
			<input type="text" name="psearch" size="20">
			<input type="Submit" name="Submit" value="Git">
			&nbsp;&nbsp;<a href="odemelerlist.php?cmd=reset">Tümünü Göster</a>
		</td>
	</tr>
		<tr><td>&nbsp;</td>
		<td><input type="radio" name="psearchtype" value="" checked>Tam Uyuşma&nbsp;&nbsp;<input type="radio" name="psearchtype" value="AND">Tüm Kelimeler&nbsp;&nbsp;<input type="radio" name="psearchtype" value="OR">Herhangi biri</td>
	</tr>
</table>
</form>

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
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
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
<td><a href="<?php echo (!is_null(@$row["id"])) ? "odemelerview.php?key=".urlencode($row["id"]) : "javascript:alert('Invalid Record! Key is null');";	?>
"><img src='images/browse.gif' alt='Gör' width='16' height='16' border='0'></a></td>
<td><a href="<?php echo (!is_null(@$row["id"])) ? "odemeleredit.php?key=".urlencode($row["id"]) : "javascript:alert('Invalid Record! Key is null');";	?>
"><img src='images/edit.gif' alt='Düzenle' width='16' height='16' border='0'></a></td>
<td><a href="<?php echo (!is_null(@$row["id"])) ? "odemeleradd.php?key=".urlencode($row["id"]) : "javascript:alert('Invalid Record! Key is null');";	?>
"><img src='images/copy.gif' alt='Kopyala' width='16' height='16' border='0'></a></td>
<td><a href="<?php echo (!is_null(@$row["id"])) ? "odemelerdelete.php?key=".urlencode($row["id"]) : "javascript:alert('Invalid Record! Key is null');";	?>
"><img src='images/delete.gif' alt='Sil' width='16' height='16' border='0'></a></td>
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
	include ("odemeler_yapilmayan.inc.php");
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
	<td><a href="odemeleradd.php"><img src="images/addnew.gif" alt="Add new" width="20" height="15" border="0"></a></td>
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
	Eşleşen Kayıt Bulunamadı!
<p>
<a href="odemeleradd.php"><img src="images/addnew.gif" alt="Add new" width="20" height="15" border="0"></a>
</p>
<?php
}
?>
</td></tr></table>

<?php
// baglantiyi kes ve result bosalt
@mysql_free_result($rs);
mysql_close($conn);
include ("footer.php");
?>
