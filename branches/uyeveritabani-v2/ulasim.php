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
$displayRecs = 50;
$recRange = 10;
$dbwhere = "";
$masterdetailwhere = "";
$searchwhere = "";
$a_search = "";
$b_search = "";
$whereClause = "";

$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB);
?>
<?php include ("header.php") ?>
<?php
if(!($_POST["subj"] && $_POST["msg"])) {
?>
<form action="ulasim.php" method="post">
<table>
<?php if($_POST["subj"] || $_POST["msg"]) {?>
<tr><td colspan="2" align="center"><font color="red"><b>Butun alanlari girmelisiniz!</b></font></td></tr>
<?php } ?>
<tr><td><b>Konu : </b></td><td><input type="text" name="subj" size="50" value="<?php echo $_POST["subj"];?>"></td></tr>
<tr><td><b>Mesaj : </b></td><td><textarea name="msg" cols="42" rows="20"><?php echo $_POST["msg"];?></textarea></td></tr>
<tr><td></td><td align="right"><input type="submit" value="Gonder"></td></tr>
</table>
</form>
<?php } else { 
	$conn = mysql_connect(HOST, USER, PASS) or die("Veritabanına bağlanamadık");
	mysql_select_db(DB) or die("seçemedi");
	$rs = mysql_query("SELECT uye_ad,uye_soyad,eposta1 FROM uyeler WHERE uye_id='".$_SESSION["uy_status_UserID"]."'") or die(mysql_error());
	$content = $_POST["msg"];
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-9\r\n";
	$headers .= "From: ".$row[0]." ".$row[1]." <".$row[2].">\r\n";
	$headers .= "To: LKD Uyelik Sistemi <uye@lkd.org.tr>\r\n";
	$to = "uye@lkd.org.tr";
	if(time() > $_SESSION["Ulasim_Mail_Time"]+(5*60)) {
		echo "mail atacagim";
		$_SESSION["Ulasim_Mail_Time"] = time();
		//mail($to, "LKD Uyelik Sisteminden bir uye maili", $content, $headers);
	} else {
		echo "mail atmam 1 dakka deneme";
		$_SESSION["Ulasim_Mail_Time"] = time();
	}
	// acilacak
 }
?>
<?php include ("footer.php") ?>
