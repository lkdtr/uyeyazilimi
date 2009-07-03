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
$ewCurSec = 0; // baslangic Secim degeri
if( @$_SESSION["uy_status_UserLevel"] == "" )
	$ewCurIdx = 1;
else
	$ewCurIdx = intval(@$_SESSION["uy_status_UserLevel"]);

if ($ewCurIdx == -1) { // 
	$ewCurSec = 31;
} elseif ($ewCurIdx > 0 && $ewCurIdx <= 4) { 
	$ewCurSec = $ew_SecTable[$ewCurIdx-1];
}
?>
<?php if (@$_SESSION["uy_status_UserID"] == "" && @$_SESSION["uy_status_UserLevel"] <> -1 ) header("Location: index.php"); ?>
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

// field "uye_id"
$x_uye_id = @$_GET["x_uye_id"];
$z_uye_id = @$_GET["z_uye_id"];
$z_uye_id = (get_magic_quotes_gpc()) ? stripslashes($z_uye_id) : $z_uye_id;
$arrfieldopr = explode(",", $z_uye_id);
if ($x_uye_id <> "" && count($arrfieldopr) >= 3) {
	$x_uye_id = (!get_magic_quotes_gpc()) ? addslashes($x_uye_id) : $x_uye_id;
	$a_search = $a_search . "uye_id " . $arrfieldopr[0] . " " . $arrfieldopr[1] . $x_uye_id . $arrfieldopr[2] . " AND ";
}

// field "uye_ad"
$x_uye_ad = @$_GET["x_uye_ad"];
$z_uye_ad = @$_GET["z_uye_ad"];
$z_uye_ad = (get_magic_quotes_gpc()) ? stripslashes($z_uye_ad) : $z_uye_ad;
$arrfieldopr = explode(",", $z_uye_ad);
if ($x_uye_ad <> "" && count($arrfieldopr) >= 3) {
	$x_uye_ad = (!get_magic_quotes_gpc()) ? addslashes($x_uye_ad) : $x_uye_ad;
	$a_search = $a_search . "uye_ad " . $arrfieldopr[0] . " " . $arrfieldopr[1] . $x_uye_ad . $arrfieldopr[2] . " AND ";
}

// field "uye_soyad"
$x_uye_soyad = @$_GET["x_uye_soyad"];
$z_uye_soyad = @$_GET["z_uye_soyad"];
$z_uye_soyad = (get_magic_quotes_gpc()) ? stripslashes($z_uye_soyad) : $z_uye_soyad;
$arrfieldopr = explode(",", $z_uye_soyad);
if ($x_uye_soyad <> "" && count($arrfieldopr) >= 3) {
	$x_uye_soyad = (!get_magic_quotes_gpc()) ? addslashes($x_uye_soyad) : $x_uye_soyad;
	$a_search = $a_search . "uye_soyad " . $arrfieldopr[0] . " " . $arrfieldopr[1] . $x_uye_soyad . $arrfieldopr[2] . " AND ";
}

// field "eposta1"
$x_eposta1 = @$_GET["x_eposta1"];
$z_eposta1 = @$_GET["z_eposta1"];
$z_eposta1 = (get_magic_quotes_gpc()) ? stripslashes($z_eposta1) : $z_eposta1;
$arrfieldopr = explode(",", $z_eposta1);
if ($x_eposta1 <> "" && count($arrfieldopr) >= 3) {
	$x_eposta1 = (!get_magic_quotes_gpc()) ? addslashes($x_eposta1) : $x_eposta1;
	$a_search = $a_search . "eposta1 " . $arrfieldopr[0] . " " . $arrfieldopr[1] . $x_eposta1 . $arrfieldopr[2] . " AND ";
}

// field "eposta2"
$x_eposta2 = @$_GET["x_eposta2"];
$z_eposta2 = @$_GET["z_eposta2"];
$z_eposta2 = (get_magic_quotes_gpc()) ? stripslashes($z_eposta2) : $z_eposta2;
$arrfieldopr = explode(",", $z_eposta2);
if ($x_eposta2 <> "" && count($arrfieldopr) >= 3) {
	$x_eposta2 = (!get_magic_quotes_gpc()) ? addslashes($x_eposta2) : $x_eposta2;
	$a_search = $a_search . "eposta2 " . $arrfieldopr[0] . " " . $arrfieldopr[1] . $x_eposta2 . $arrfieldopr[2] . " AND ";
}

// field "alias"
$x_alias = @$_GET["x_alias"];
$z_alias = @$_GET["z_alias"];
$z_alias = (get_magic_quotes_gpc()) ? stripslashes($z_alias) : $z_alias;
$arrfieldopr = explode(",", $z_alias);
if ($x_alias <> "" && count($arrfieldopr) >= 3) {
	$x_alias = (!get_magic_quotes_gpc()) ? addslashes($x_alias) : $x_alias;
	$a_search = $a_search . "alias " . $arrfieldopr[0] . " " . $arrfieldopr[1] . $x_alias . $arrfieldopr[2] . " AND ";
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
			$b_search .= "uye_ad LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "uye_soyad LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "eposta1 LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "eposta2 LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "alias LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "cinsiyet LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "kurum LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "gorev LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "mezuniyet LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "mezuniyet_yil LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "mezuniyet_bolum LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "is_addr LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "semt LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "sehir LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "pkod LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "PassWord LIKE '%" . trim($kw) . "%' OR ";
			$b_search .= "Resim LIKE '%" . trim($kw) . "%' OR ";
			if (substr($b_search, -4) == " OR ") {
				$b_search = substr($b_search, 0, strlen($b_search)-4);
			}
			$b_search .= ") " . $pSearchType . " ";
		}
	}	else {
		$b_search .= "uye_ad LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "uye_soyad LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "eposta1 LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "eposta2 LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "alias LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "cinsiyet LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "kurum LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "gorev LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "mezuniyet LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "mezuniyet_yil LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "mezuniyet_bolum LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "is_addr LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "semt LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "sehir LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "pkod LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "PassWord LIKE '%" . $pSearch . "%' OR ";
		$b_search .= "Resim LIKE '%" . $pSearch . "%' OR ";
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
	$_SESSION["uyeler_searchwhere"] = $searchwhere;	
	$startRec = 1; //kayit sayaci sifirlaniyor (new search)
	$_SESSION["uyeler_REC"] = $startRec;
}	else {
	$searchwhere = @$_SESSION["uyeler_searchwhere"];
}

// temiz bir arama baslat
if (@$_GET["cmd"] <> "") {
	$cmd = $_GET["cmd"];
	if (strtoupper($cmd) == "RESET") {
		$searchwhere = ""; //ni resetle
		$_SESSION["uyeler_searchwhere"] = $searchwhere;
	}	elseif (strtoupper($cmd) == "RESETALL") {		
		$searchwhere = ""; //ni resetle
		$_SESSION["uyeler_searchwhere"] = $searchwhere;
	}
	$startRec = 1; //kayit sayaci sifirlaniyor (reset command)
	$_SESSION["uyeler_REC"] = $startRec;
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
$DefaultFilter = "";

// order parametresi var mi kontrol et
$OrderBy = "";
if (@$_GET["order"] <> "") {
	$OrderBy = $_GET["order"];

	// ASC/DSC gerekiyormu bak
	if (@$_SESSION["uyeler_OB"] == $OrderBy) {
		if (@$_SESSION["uyeler_OT"] == "ASC") {
			$_SESSION["uyeler_OT"] = "DESC";
		} else {
			$_SESSION["uyeler_OT"] = "ASC";
		}
	} else {
		$_SESSION["uyeler_OT"] = "ASC";
	}
	$_SESSION["uyeler_OB"] = $OrderBy;
	$_SESSION["uyeler_REC"] = 1;
} else {
	$OrderBy = @$_SESSION["uyeler_OB"];
	if ($OrderBy == "") {
		$OrderBy = $DefaultOrder;
		$_SESSION["uyeler_OB"] = $OrderBy;
		$_SESSION["uyeler_OT"] = $DefaultOrderType;
	}
}
$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB);
        mysql_query("SET NAMES 'utf8'");

// build SQL
$strsql = "SELECT * FROM uyeler";
if ($DefaultFilter <> "") {
	$whereClause .= "(" . $DefaultFilter . ") AND ";
}
if ($dbwhere <> "" ) {
	$whereClause .= "(" . $dbwhere . ") AND ";
}
if (($ewCurSec & ewAllowList) <> ewAllowList) {
	$whereClause .= "(0=1) AND ";
}
if (@$_SESSION["uy_status_UserLevel"] <> -1) { //yonetici degil!
	$whereClause .= "(uye_id = " . @$_SESSION["uy_status_UserID"] . ") AND ";
}
if (substr($whereClause, -5) == " AND ") {
	$whereClause = substr($whereClause, 0, strlen($whereClause)-5);
}
if ($whereClause <> "") {
	$strsql .= " WHERE " . $whereClause;
}
if ($OrderBy <> "") {
	$strsql .= " ORDER BY " . $OrderBy . " " . @$_SESSION["uyeler_OT"];
}
else 
	$strsql .= " ORDER BY uye_id"; // Ontanimli siralama

//echo $strsql; // SQL cumlesini debug etmek icin commenti kaldirin
$rs = mysql_query($strsql);
$totalRecs = intval(@mysql_num_rows($rs));

// check for a START parameter
if (@$_GET["start"] <> "") {
	$startRec = $_GET["start"];
	$_SESSION["uyeler_REC"] = $startRec;
}	elseif (@$_GET["pageno"] <> "") {
	$pageno = $_GET["pageno"];
	if (is_numeric($pageno)) {
		$startRec = ($pageno - 1)*$displayRecs + 1;
		if ($startRec <= 0) {
			$startRec = 1;
		} elseIf ($startRec >= (($totalRecs-1)/$displayRecs)*$displayRecs+1) {
			$startRec = (($totalRecs-1)/$displayRecs)*$displayRecs + 1;
		}
		$_SESSION["uyeler_REC"] = $startRec;
	} else {
		$startRec = @$_SESSION["uyeler_REC"];
		if (!is_numeric($startRec)) {			
			$startRec = 1; // kayit sayaci sifirlaniyor
			$_SESSION["uyeler_REC"] = $startRec;
		}
	}
}	else {
	$startRec = @$_SESSION["uyeler_REC"];
	if (!is_numeric($startRec)) {		
		$startRec = 1; // kayit sayaci sifirlaniyor
		$_SESSION["uyeler_REC"] = $startRec;
	}
}	
?>
<?php include ("header.php") ?>
<br>
<?php /*<table border=1 bordercolor="#666666" cellspacing="0" cellpadding="5" width="96%" bgcolor="#FFFFCC" align="center"><tr><td style="text-align:justify">
<b>Üye Bilgilerinizin Güncellenmesi Gerekmektedir.</b> Yeni Üye Veritabanı Programımıza üye bilgilerinin güncellenmesi için yardımınıza ihtiyacımız var. <img src="images/edit.gif" align="absmiddle"> simgesine tıklayarak bilgilerinizi güncelleyebilirsiniz.
<br>
<b>Aidat Ödemeleri ile ilgili...</b> Üye kayıt tarihleri (Derneğe üye olduğunuz tarih) ve ödeme bilgileriniz güncelleninceye kadar epey borçlu görünebilirsiniz. Bu konuda da yardıma ihtiyacımız var, veri girişi konusunda çalışabilecek gönüllü arkadaşlarımızın web-cg@linux.org.tr adresine mail atmalari yeterli olacaktır.</td></tr></table>*/?>
<br>
<? if ($_SESSION["uy_status_UserLevel"] <> 1) { /* Admin degil ise Aramayi gosterme */ ?>
<form action="uyelerlist.php">
<table border="0" cellspacing="0" cellpadding="4">
	<tr>
		<td>Hızlı Arama (*)</td>
		<td>
			<input type="text" name="psearch" size="20">
			<input type="Submit" name="Submit" value="Git">
			&nbsp;&nbsp;<a href="uyelerlist.php?cmd=reset">Tümünü Göster</a>
			&nbsp;&nbsp;<a href="uyelersrch.php">Detaylı Arama</a>
		</td>
		<?php
	if (($ewCurSec & ewAllowAdd) == ewAllowAdd) {
?>
<td rowspan="2" width="40%" align="center">
<a href="uyeleradd.php"><img src="images/uye.png" alt="Yeni Üye Ekle" border="0"><br>Yeni Üye Ekle</a>
</td>
<?php
	}
?>
	</tr>
		<tr><td>&nbsp;</td>
		<td><input type="radio" name="psearchtype" value="" checked>Tam Uyuşma&nbsp;&nbsp;<input type="radio" name="psearchtype" value="AND">Tüm Kelimeler&nbsp;&nbsp;<input type="radio" name="psearchtype" value="OR">Herhangi biri</td>
	</tr>
</table>
</form>
<? } ?>
<form method="post">
<table width="100%" align="center" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
<tr bgcolor="#455F76">
<td>
<a href="uyelerlist.php?order=<?php echo urlencode("uye_id"); ?>"><font color="#FFFFFF">Üye No<?php if ($OrderBy == "uye_id") { ?><font face="Webdings">&nbsp;<?php echo (@$_SESSION["uyeler_OT"] == "ASC") ? "(+)" : ((@$_SESSION["uyeler_OT"] == "DESC") ? "(-)" : "") ?>
<?php } ?></a>
</td>
<td>
<a href="uyelerlist.php?order=<?php echo urlencode("uye_ad"); ?>"><font color="#FFFFFF">Ad<?php if ($OrderBy == "uye_ad") { ?><font face="Webdings">&nbsp;<?php echo (@$_SESSION["uyeler_OT"] == "ASC") ? "(+)" : ((@$_SESSION["uyeler_OT"] == "DESC") ? "(-)" : "") ?>
<?php } ?></a>
</td>
<td>
<a href="uyelerlist.php?order=<?php echo urlencode("uye_soyad"); ?>"><font color="#FFFFFF">Soyad<?php if ($OrderBy == "uye_soyad") { ?><font face="Webdings">&nbsp;<?php echo (@$_SESSION["uyeler_OT"] == "ASC") ? "(+)" : ((@$_SESSION["uyeler_OT"] == "DESC") ? "(-)" : "") ?>
<?php } ?></a>
</td>
<td>
<a href="uyelerlist.php?order=<?php echo urlencode("eposta1"); ?>"><font color="#FFFFFF">E-posta<?php if ($OrderBy == "eposta1") { ?><font face="Webdings">&nbsp;<?php echo (@$_SESSION["uyeler_OT"] == "ASC") ? "(+)" : ((@$_SESSION["uyeler_OT"] == "DESC") ? "(-)" : "") ?>
<?php } ?></a>
</td>
<?php If (($ewCurSec & ewAllowView) == ewAllowView) { ?>
<td class="navbeyaz">Gör</td>
<?php } ?>
<?php If (($ewCurSec & ewAllowEdit) == ewAllowEdit) { ?>
<td class="navbeyaz">Düzenle</td>
<?php } ?>
<td class="navbeyaz">Aidat</td>
</tr>
<?php

// kayit baslangici toplamdan buyuk olmamalidir!
if ($startRec > $totalRecs) {
	$startRec = $totalRecs;
}

// son gosterilecek kaydi belirleyelim
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
		$key = @$row["id"];
		$x_id = @$row["id"];
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
		$x_PassWord = @$row["PassWord"];
		$x_Resim = @$row["Resim"];
		$x_artik_uye_degil = @$row["artik_uye_degil"];
		$x_haber_alinamiyor = @$row["haber_alinamiyor"];
?>
<tr bgcolor="<?php echo $bgcolor; ?>">
<?php
 if ($x_artik_uye_degil)
  $renk = 'red';
 elseif ($x_haber_alinamiyor)
  $renk = 'blue';
 else
  $renk = 'black';

 echo '<td><font color=' . $renk . '>' . $x_uye_id . '</font></td>&nbsp;';
 echo '<td><font color=' . $renk . '>' . $x_uye_ad . '</font></td>&nbsp;';
 echo '<td><font color=' . $renk . '>' . $x_uye_soyad . '</font></td>&nbsp;';
 echo '<td><font color=' . $renk . '>' . $x_eposta1 . '</font></td>&nbsp;';
?>
<?php If (($ewCurSec & ewAllowView) == ewAllowView) { ?>
<td align="center"><a href="<?php echo (!is_null(@$row["id"])) ? "uyelerview.php?key=".urlencode($row["id"]) : "javascript:alert('Invalid Record! Key is null');";	?>
"><img src='images/browse.gif' alt='Gör' width='16' height='16' border='0'></a></td>
<?php } ?>
<?php If (($ewCurSec & ewAllowEdit) == ewAllowEdit) { ?>
<td align="center"><a href="<?php echo (!is_null(@$row["id"])) ? "uyeleredit.php?key=".urlencode($row["id"]) : "javascript:alert('Invalid Record! Key is null');";	?>
"><img src='images/edit.gif' alt='Düzenle' width='16' height='16' border='0'></a></td>
<?php } ?>
<td align="center"><a href="odemelerlist.php?x_uye_id=<?echo $x_uye_id;?>"><img border=0 src="./images/para.gif"></a></td>
</tr>
<?php
	}
}
?>
</table>
</form>
<?php
// baglantiyi kes ve bellek bosalt
@mysql_free_result($rs);
mysql_close($conn);
?>
<? if ($_SESSION["uy_status_UserLevel"] <> 1) { /* ekleme izni varsa, admindir... kayit navigasyon bas */ ?>
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
	<td><a href="uyelerlist.php?start=1"><img src="images/first.gif" alt="First" width="20" height="15" border="0"></a></td>
<?php 
	} // else kapat
?>
<!--onceki sayfa dugmesi-->
<?php 
	if ($PrevStart == $startRec) {
?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="20" height="15" border="0"></td>
<?php 
	} else {
?>
	<td><a href="uyelerlist.php?start=<?php echo $PrevStart; ?>"><img src="images/prev.gif" alt="Previous" width="20" height="15" border="0"></a></td>
<?php
	} // else kapa
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
	<td><a href="uyelerlist.php?start=<?php echo $NextStart; ?>"><img src="images/next.gif" alt="Next" width="20" height="15" border="0"></a></td>
<?php 
	} // else kapat
?>
<!--son sayfa dugmesi-->
<?php 
	if ($LastStart == $startRec) {?>
	<td><img src="images/lastdisab.gif" alt="Last" width="20" height="15" border="0"></td>
<?php
	} else {
?>
	<td><a href="uyelerlist.php?start=<?php echo $LastStart; ?>"><img src="images/last.gif" alt="Last" width="20" height="15" border="0"></a></td>
<?php
	} // else kapat
?>
<?php 
	if (($ewCurSec & ewAllowAdd) == ewAllowAdd) {
?>
	<td><a href="uyeleradd.php"><img src="images/addnew.gif" alt="Add new" width="20" height="15" border="0"></a></td>
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
	Burayi Gormeye İzniniz Yok! Bir hata oldugunu dusunuyorsaniz bilgi@lkd.org.tr adresine mail atiniz.
<?php
	}
?>
<p>
<?php
	if (($ewCurSec & ewAllowAdd) == ewAllowAdd) {
?>
<a href="uyeleradd.php"><img src="images/addnew.gif" alt="Add new" width="20" height="15" border="0"></a>
<?php
	}
?>
</p>
<?php 
}
?>
</td></tr></table>
<? } /* kayit navigasyon son */ ?>
<br>
<?php include ("footer.php") ?>
