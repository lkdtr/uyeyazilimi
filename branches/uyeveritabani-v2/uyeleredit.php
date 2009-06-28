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
<?php if (@$_SESSION["uy_status"] <> "login") header("Location: index.php") ?>
<?php
$UyeResimlerDizin="uye_resimler";
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
$ewCurSec = 0; // baslangic Sec degeri
$ewCurIdx = intval(@$_SESSION["uy_status_UserLevel"]);
if ($ewCurIdx == -1) { //
	$ewCurSec = 31;
} elseif ($ewCurIdx > 0 && $ewCurIdx <= 4) {
	$ewCurSec = $ew_SecTable[$ewCurIdx-1];
}
if (($ewCurSec & ewAllowedit) <> ewAllowedit) header("Location: uyelerlist.php");
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
ob_start();
$key = @intval($_GET["key"]);
if (empty($key)) {
	$key = @intval($_POST["key"]);
}
if (empty($key)) {
	header("Location: uyelerlist.php");
}

// get action
$a = @$_POST["a"];
if (empty($a)) {
	$a = "I";	//display with input box
}

// get fields from form
$x_id = @$_POST["x_id"];
$x_uye_id = @$_POST["x_uye_id"];
$x_uye_ad = @$_POST["x_uye_ad"];
$x_uye_soyad = @$_POST["x_uye_soyad"];
$x_eposta1 = @$_POST["x_eposta1"];
$x_eposta2 = @$_POST["x_eposta2"];
$x_alias = @$_POST["x_alias"];
$x_cinsiyet = @$_POST["x_cinsiyet"];
$x_kurum = @$_POST["x_kurum"];
$x_gorev = @$_POST["x_gorev"];
$x_mezuniyet = @$_POST["x_mezuniyet"];
$x_mezuniyet_yil = @$_POST["x_mezuniyet_yil"];
$x_mezuniyet_bolum = @$_POST["x_mezuniyet_bolum"];
$x_is_addr = @$_POST["x_is_addr"];
$x_semt = @$_POST["x_semt"];
$x_sehir = @$_POST["x_sehir"];
$x_pkod = @$_POST["x_pkod"];
$x_AuthLevel = @$_POST["x_AuthLevel"];
$x_PassWord = @$_POST["x_PassWord"];
$x_Resim = @$_POST["x_Resim"];
$x_Telefon1 = @$_POST["x_Telefon1"];
$x_Telefon2 = @$_POST["x_Telefon2"];
$x_TCKimlikNo = @$_POST["x_TCKimlikNo"];
$x_Uye_karar_no = @$_POST["x_Uye_karar_no"];
$x_Uye_karar_tarih = @$_POST["x_Uye_karar_tarih"];
$x_vesikalik_foto = @$_POST["x_vesikalik_foto"];
$x_Uye_formu = @$_POST["x_Uye_formu"];
$x_Notlar = @$_POST["x_Notlar"];
$x_kayit_tarihi = @$_POST["x_kayit_tarihi"];
$x_liste_uyeligi = @$_POST["x_liste_uyeligi"];
$x_gonullu = @$_POST["x_gonullu"];
$x_artik_uye_degil = @$_POST["x_artik_uye_degil"];
$x_oylama = @$_POST["x_oylama"];
$x_trac_listesi = @$_POST["x_trac_listesi"];
$x_haber_alinamiyor = @$_POST["x_haber_alinamiyor"];
$x_kimlik_gizli = @$_POST["x_kimlik_gizli"];
$x_kimlik_durumu = @$_POST["x_kimlik_durumu"];

// baglanti hazirlaniyor...
$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB, $conn);
mysql_query("SET NAMES 'utf8'", $conn);

switch ($a)
{
	case "I": // gosterilecek bir kayit  var
		$tkey = "" . $key . "";
		$strsql = "SELECT * FROM uyeler WHERE id=" . $tkey;
    if ($_SESSION["uy_status_UserLevel"] <> -1) { // yonetici degil!
			$strsql = $strsql . " AND (uye_id = " . @$_SESSION["uy_status_UserID"] . ")";
    }
		$rs = mysql_query($strsql, $conn) or die(mysql_error());
		if (!($row = mysql_fetch_array($rs))) {
     	ob_end_clean();
			header("Location: uyelerlist.php");
		}

		// degerleri ayir...
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
		$x_Telefon1 = @$row["Telefon1"];
		$x_Telefon2 = @$row["Telefon2"];
		$x_TCKimlikNo = @$row["TCKimlikNo"];
		$x_Uye_karar_no = @$row["Uye_karar_no"];
		$x_Uye_karar_tarih = @$row["Uye_karar_tarih"];
		$x_vesikalik_foto = @$row["vesikalik_foto"];
		$x_Uye_formu = @$row["Uye_formu"];
		$x_Notlar = @$row["Notlar"];
		$x_kayit_tarihi = @$row["kayit_tarihi"];
		$x_liste_uyeligi = @$row["liste_uyeligi"];
		$x_gonullu = @$row["gonullu"];
		$x_artik_uye_degil = @$row["artik_uye_degil"];
		$x_oylama = @$row["oylama"];
		$x_trac_listesi = @$row["trac_listesi"];
		$x_haber_alinamiyor = @$row["haber_alinamiyor"];
		$x_kimlik_gizli = @$row["kimlik_gizli"];
		$x_kimlik_durumu = @$row["kimlik_durumu"];
		mysql_free_result($rs);
		break;
	case "U": // update

			$tkey = "" . $key . "";
    if (@$_SESSION["uy_status_UserLevel"] <> -1) { // yonetici degil!
			$strsql = $strsql . " AND (uye_id = " . @$_SESSION["uy_status_UserID"] . ")";
    }
	
		// Guncellemeden once bir eski kaydi saglama alalimk
		$strselectsql = "SELECT eposta1,alias FROM uyeler WHERE uye_id=$_POST[x_uye_id]";
		$rs = mysql_query($strselectsql, $conn) or die(mysql_error());
		$row_eski = mysql_fetch_array($rs);
	
		// form degerleri...
		$x_id = @strip_tags($_POST["x_id"]);
		$x_uye_id = @strip_tags($_POST["x_uye_id"]);
		$x_uye_ad = @strip_tags($_POST["x_uye_ad"]);
		$x_kimlikno = @strip_tags($_POST["kimlikno"]);
		$x_uye_soyad = @strip_tags($_POST["x_uye_soyad"]);
		$x_eposta1 = @strip_tags($_POST["x_eposta1"]);
		$x_eposta2 = @strip_tags($_POST["x_eposta2"]);
		$x_alias = @strip_tags($_POST["x_alias"]);
		$x_cinsiyet = @strip_tags($_POST["x_cinsiyet"]);
		$x_kurum = @strip_tags($_POST["x_kurum"]);
		$x_gorev = @strip_tags($_POST["x_gorev"]);
		$x_mezuniyet = @strip_tags($_POST["x_mezuniyet"]);
		$x_mezuniyet_yil = @strip_tags($_POST["x_mezuniyet_yil"]);
		$x_mezuniyet_bolum = @strip_tags($_POST["x_mezuniyet_bolum"]);
		$x_is_addr = @strip_tags($_POST["x_is_addr"]);
		$x_semt = @strip_tags($_POST["x_semt"]);
		$x_sehir = @strip_tags($_POST["x_sehir"]);
		$x_pkod = @strip_tags($_POST["x_pkod"]);
		$x_PassWord = @$_POST["x_PassWord"];
		$x_Telefon1 = @strip_tags($_POST["x_Telefon1"]);
		$x_Telefon2 = @strip_tags($_POST["x_Telefon2"]);
		$x_TCKimlikNo = @strip_tags($_POST["x_TCKimlikNo"]);
		$x_Uye_karar_no = @strip_tags($_POST["x_Uye_karar_no"]);
		$x_Uye_karar_tarih = @strip_tags($_POST["x_Uye_karar_tarih"]);
		$x_vesikalik_foto = @strip_tags($_POST["x_vesikalik_foto"]);
		$x_Uye_formu = @strip_tags($_POST["x_Uye_formu"]);
		$x_Notlar = @strip_tags($_POST["x_Notlar"]);
		$x_kayit_tarihi = @strip_tags($_POST["x_kayit_tarihi"]);
		$x_liste_uyeligi = @strip_tags($_POST["x_liste_uyeligi"]);
		$x_gonullu = @strip_tags($_POST["x_gonullu"]);
		$x_artik_uye_degil = @strip_tags($_POST["x_artik_uye_degil"]);
		$x_oylama = @strip_tags($_POST["x_oylama"]);
		$x_trac_listesi = @strip_tags($_POST["x_trac_listesi"]);
		$x_haber_alinamiyor = @strip_tags($_POST["x_haber_alinamiyor"]);
		$x_kimlik_gizli = @strip_tags($_POST["x_kimlik_gizli"]);
		$x_kimlik_durumu = @strip_tags($_POST["x_kimlik_durumu"]);

		// check file size
		$EW_MaxFileSize = @strip_tags($_POST["EW_MaxFileSize"]);
		if (!empty($_FILES["x_Resim"]["size"])) {
			if (!empty($EW_MaxFileSize) && $_FILES["x_Resim"]["size"] > $EW_MaxFileSize) {
				die("Max. file upload size exceeded");
			}
		}
		$a_x_Resim = @strip_tags($_POST["a_x_Resim"]);
		
		// degerleri array'e atalim

		// eposta1
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_eposta1) : $x_eposta1;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["eposta1"] = $theValue;

		// eposta2
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_eposta2) : $x_eposta2;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["eposta2"] = $theValue;
		

		// kurum
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_kurum) : $x_kurum;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["kurum"] = $theValue;

		// gorev
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_gorev) : $x_gorev;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["gorev"] = $theValue;


		// mezuniyet

		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_mezuniyet) : $x_mezuniyet;

		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";

		$fieldList["mezuniyet"] = $theValue;



		// mezuniyet_yil

		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_mezuniyet_yil) : $x_mezuniyet_yil;

		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";

		$fieldList["mezuniyet_yil"] = $theValue;



		// mezuniyet_bolum

		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_mezuniyet_bolum) : $x_mezuniyet_bolum;

		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";

		$fieldList["mezuniyet_bolum"] = $theValue;



		// is_addr

		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_is_addr) : $x_is_addr;

		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";

		$fieldList["is_addr"] = $theValue;



		// semt

		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_semt) : $x_semt;

		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";

		$fieldList["semt"] = $theValue;



		// sehir

		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_sehir) : $x_sehir;

		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";

		$fieldList["sehir"] = $theValue;



		// pkod

		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_pkod) : $x_pkod;

		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";

		$fieldList["pkod"] = $theValue;



		// PassWord
		if( $x_PassWord ) { // If new password is set

			//$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_PassWord) : $x_PassWord;
			$theValue = ($theValue != "") ? " '" . md5($x_PassWord) . "'" : "NULL";
			$fieldList["PassWord"] = $theValue;
		}

		// Telefon1
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_Telefon1) : $x_Telefon1;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["Telefon1"] = $theValue;
		
		// Telefon2
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_Telefon2) : $x_Telefon2;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["Telefon2"] = $theValue;

		// TCKimlikNo
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_TCKimlikNo) : $x_TCKimlikNo;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["TCKimlikNo"] = $theValue;

		// liste_uyeligi
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_liste_uyeligi) : $x_liste_uyeligi;
		$theValue = ($theValue != "") ? intval($theValue) : "NULL";
		$fieldList["liste_uyeligi"] = $theValue;

		// gonullu
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_gonullu) : $x_gonullu;
		$theValue = ($theValue != "") ? intval($theValue) : "NULL";
		$fieldList["gonullu"] = $theValue;

		// artik uye degil
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_artik_uye_degil) : $x_artik_uye_degil;
		$theValue = ($theValue != "") ? intval($theValue) : "NULL";
		$fieldList["artik_uye_degil"] = $theValue;

		// oylama
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_oylama) : $x_oylama;
		$theValue = ($theValue != "") ? intval($theValue) : "NULL";
		$fieldList["oylama"] = $theValue;
		
		if (@$_SESSION["uy_status_UserLevel"] == -1) { // Admin degilse asagidaki degerler eklenmesin!
		// cinsiyet
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_cinsiyet) : $x_cinsiyet;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["cinsiyet"] = $theValue;

		// alias
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_alias) : $x_alias;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["alias"] = $theValue;
		
		// uye_id
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_uye_id) : $x_uye_id;
		$theValue = ($theValue != "") ? intval($theValue) : "NULL";
		$fieldList["uye_id"] = $theValue;

		// uye_ad
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_uye_ad) : $x_uye_ad;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["uye_ad"] = $theValue;

		// uye_soyad
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_uye_soyad) : $x_uye_soyad;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["uye_soyad"] = $theValue;

		// karar_tarihi
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_kayit_tarihi) : $x_kayit_tarihi;
		$theValue = ($theValue != "") ? intval($theValue) : "NULL";
		$fieldList["kayit_tarihi"] = $theValue;

		// Uye_karar_no
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_Uye_karar_no) : $x_Uye_karar_no;
		$theValue = ($theValue != "") ? intval($theValue) : "NULL";
		$fieldList["Uye_karar_no"] = $theValue;

		// Uye_karar_tarih
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_Uye_karar_tarih) : $x_Uye_karar_tarih;
		$theValue = ($theValue != "") ? "'". $theValue . "'": "NULL";
		$fieldList["Uye_karar_tarih"] = $theValue;

		// vesikalik_foto
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_vesikalik_foto) : $x_vesikalik_foto;
		$theValue = ($theValue != "") ? intval($theValue) : "NULL";
		$fieldList["vesikalik_foto"] = $theValue;

		// Uye_formu
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_Uye_formu) : $x_Uye_formu;
		$theValue = ($theValue != "") ? intval($theValue) : "NULL";
		$fieldList["Uye_formu"] = $theValue;

		// Notlar
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_Notlar) : $x_Notlar;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["Notlar"] = $theValue;

                // trac_listesi
                $theValue = (!get_magic_quotes_gpc()) ? addslashes($x_trac_listesi) : $x_trac_listesi;
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                $fieldList["trac_listesi"] = $theValue;

                // haber_alinamiyor
                $theValue = (!get_magic_quotes_gpc()) ? addslashes($x_haber_alinamiyor) : $x_haber_alinamiyor;
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                $fieldList["haber_alinamiyor"] = $theValue;

                // kimlik_gizli
                $theValue = (!get_magic_quotes_gpc()) ? addslashes($x_kimlik_gizli) : $x_kimlik_gizli;
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                $fieldList["kimlik_gizli"] = $theValue;

                // kimlik_durumu
                $theValue = (!get_magic_quotes_gpc()) ? addslashes($x_kimlik_durumu) : $x_kimlik_durumu;
                $theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
                $fieldList["kimlik_durumu"] = $theValue;
		
		} // Adminlik kontrolunun sonu

		// Resim

		if ($a_x_Resim == "2") { // cikart

			$fieldList["Resim"] = "NULL";

			$fieldList["Resim"] = "NULL";

		} else if ($a_x_Resim == "3") { // guncelle

			if (is_uploaded_file($_FILES["x_Resim"]["tmp_name"])) {
			$Gecici = explode(".", $_FILES["x_Resim"]["name"]);
			$Uzanti = strtolower($Gecici[ count($Gecici)-1 ]);
			if( !eregi("jpg|jpeg", $Uzanti) )
				die("Dosyaniz jpg veya jpeg degil!");

			if( !$_SESSION["uy_status_UserID"] )
				$DosyaAdi = $x_uye_id;
			else
				$DosyaAdi = $_SESSION["uy_status_UserID"];


     		$destfile = './' . $UyeResimlerDizin . '/' . $DosyaAdi . ".$Uzanti";

     		if (!move_uploaded_file($_FILES["x_Resim"]["tmp_name"], $destfile)) // dosyayi yerine gonderemediysek...

     			die("Dosya gondermediniz veya dosya yerine yerlestirilemedi!" . $destfile);


				$fieldList["Resim"] = " '" . $DosyaAdi . ".$Uzanti" . "'";

				unlink($_FILES["x_Resim"]["tmp_name"]);

			}

		}

		if ($_SESSION["uy_status_UserLevel"] <> -1) { // yonetici degil!

			$fieldList["uye_id"] = " '" . $_SESSION["uy_status_UserID"] . "'";

		}



		// update

		$updateSQL = "UPDATE uyeler SET ";

		foreach ($fieldList as $key=>$temp) {

			$updateSQL .= "$key = $temp, ";

		}

		if (substr($updateSQL, -2) == ", ") {

			$updateSQL = substr($updateSQL, 0, strlen($updateSQL)-2);

		}
		
		$updateSQL .= " WHERE id=". $tkey ;
		
		if( $_SESSION["uy_status_UserLevel"] <> -1) // Mini bir guvenlik onlemi
			$updateSQL .= " AND (uye_id = " . @$_SESSION["uy_status_UserID"] . ")";

  		$rs = mysql_query($updateSQL, $conn) or die(mysql_error());
		
		// alias tablosunu da guncelleyelim - once birini sonra digerini guncellemeli, baska anahtar yok tabloda
                $conn_mail = mysql_connect(HOST_MAIL, USER_MAIL, PASS_MAIL);
		mysql_select_db(DB_MAIL, $conn_mail);
                mysql_query("SET NAMES 'utf8'", $conn_mail);
		if($row_eski[alias] != $x_alias)
		 {
		  $updateSQL = "UPDATE forwardings SET source='$x_alias' WHERE destination = '$row_eski[eposta1]'";
		  $rs = mysql_query($updateSQL, $conn_mail) or die(mysql_error());
		  
		  if($row_eski[eposta1] != $x_eposta1)		// eger hem alias hem eposta guncelleniyorsa, guncellenen alias'i anahtar almak gerek
		   {
		    $updateSQL = "UPDATE forwardings SET destination='$x_eposta1' WHERE source = '$x_alias'";
		    $rs = mysql_query($updateSQL, $conn_mail) or die(mysql_error());
		   }
		 }
		elseif($row_eski[eposta1] != $x_eposta1)	// sadece eposta guncelleniyorsa, eski alias'i anahtar almak gerek
		 {
		  $updateSQL = "UPDATE forwardings SET destination='$x_eposta1' WHERE source = '$row_eski[alias]'";
		  $rs = mysql_query($updateSQL, $conn_mail) or die(mysql_error());
		 }
                // Uye, uyelikten ayrildiysa e-postasi postfix veritabanindan kaldiralim -- artik kullanmasin
                if($x_artik_uye_degil)
                 {
                  $strsql = "DELETE FROM forwardings WHERE source='$x_alias'";
                  mysql_query($strsql, $conn_mail) or die(mysql_error());
                 }

                // isim / parola / alias bilgisini bir de yeni uye veritabanina yazalim
                mysql_select_db(DB_PWD,$conn);
                $slug = explode('@', $x_alias);
                $strsql = "SELECT id FROM members WHERE uye_no = $x_uye_id";
                $rs = mysql_query($strsql, $conn) or die(mysql_error());
                $id = mysql_fetch_row($rs);
                $strsql = "UPDATE members SET lotr_alias = \"$slug[0]\", uye_no = $x_uye_id, name = \"$x_uye_ad\", lastname = \"$x_uye_soyad\"";
                if ($x_PassWord)
                 $strsql .= ", password = $fieldList[PassWord]";
                $strsql .= ' WHERE id=' . $id[0];
                mysql_query($strsql, $conn) or die(mysql_error());
                // Uye, uyelikten ayrildiysa yeni uye veritabanindan kaldiralim -- parola dogrulamasi yapamasin
                if($x_artik_uye_degil)
                 {
                  $strsql = "DELETE FROM members WHERE uye_no = $x_uye_id";
                  mysql_query($strsql, $conn) or die(mysql_error());
                 }

                // isim bilgisini bir de Trac veritabaninda guncelleyelim -- alias (trac'daki login) degistirme destegi uzerinde ayrica ugrasilmasi gerek
                mysql_select_db(DB_TRAC,$conn);
                $strsql = "UPDATE session_attribute SET value = \"$x_uye_ad $x_uye_soyad\" WHERE sid = \"$slug[0]\" AND name = \"name\"";
                mysql_query($strsql, $conn) or die(mysql_error());
                // Uye, uyelikten ayrildiysa, oturum bilgilerini Trac veritabanindan kaldiralim -- Trac'tan e-posta bildirimi gitmesin
                if($x_artik_uye_degil)
                 {
                  $strsql = 'DELETE FROM session_attribute WHERE sid = "' . $slug[0] . '"';
                  mysql_query($strsql, $conn) or die(mysql_error());
                  $strsql = 'DELETE FROM session WHERE sid = "' . $slug[0] . '"';
                  mysql_query($strsql, $conn) or die(mysql_error());
                 }

		ob_end_clean();
		
		header("Location: uyelerview.php?key=$tkey");

}

?>

<?php include ("header.php") ?>

<script language="JavaScript" src="ew.js"></script>

<script language="JavaScript">

<!-- start Javascript

function  EW_checkMyForm(EW_this) {

if (EW_this.x_uye_ad && !EW_hasValue(EW_this.x_uye_ad, "TEXT" )) {

            if (!EW_onError(EW_this, EW_this.x_uye_ad, "TEXT", "Ad Girmediniz !"))

                return false;

        }

if (EW_this.x_uye_soyad && !EW_hasValue(EW_this.x_uye_soyad, "TEXT" )) {

            if (!EW_onError(EW_this, EW_this.x_uye_soyad, "TEXT", "Soyadnz ?"))

                return false;

        }

if (EW_this.x_eposta1 && !EW_hasValue(EW_this.x_eposta1, "TEXT" )) {

            if (!EW_onError(EW_this, EW_this.x_eposta1, "TEXT", "Geçersiz e-posta adresi!"))

                return false;

        }

if (EW_this.x_eposta1 && !EW_checkemail(EW_this.x_eposta1.value)) {

        if (!EW_onError(EW_this, EW_this.x_eposta1, "TEXT", "Geçersiz e-posta adresi!"))

            return false;

        }

if (EW_this.x_eposta2 && !EW_checkemail(EW_this.x_eposta2.value)) {

        if (!EW_onError(EW_this, EW_this.x_eposta2, "TEXT", "Geçersiz e-posta adresi!"))

            return false;

        }

if (EW_this.x_cinsiyet && !EW_hasValue(EW_this.x_cinsiyet, "RADIO" )) {

            if (!EW_onError(EW_this, EW_this.x_cinsiyet, "RADIO", "Cinsiyet ?"))

                return false;

        }

return true;

}



// end JavaScript -->

</script>

<form onSubmit="return EW_checkMyForm(this);"  action="uyeleredit.php" method="post" enctype="multipart/form-data">

<input type="hidden" name="EW_MaxFileSize" value="2000000">

<p>

<input type="hidden" name="a" value="U">

<input type="hidden" name="key" value="<?php echo $key; ?>">

<table width="60%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#CCCCCC">

<tr>

<td height="30" colspan="2" bgcolor="#466176"><SPAN style="font-weight: bold"><font color="#FFFFFF">&nbsp;Üye Bilgileri (Lütfen Bilgilerinizin Güncel ve Doğru Olmasına Dikkat Ediniz!) </SPAN></td>

</tr>

<tr>

<td align="right" bgcolor="#666666"><font color="#FFFFFF">Üye numarası&nbsp;</td>

<td bgcolor="#F5F5F5"><?php echo $x_uye_id; ?><input type="hidden" name="x_uye_id" value="<?php echo strip_tags(@$x_uye_id); ?>">&nbsp;</td>

</tr>

<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">TC Kimlik No&nbsp;</td>
 <td bgcolor="#F5F5F5"><input type="text" name="x_TCKimlikNo" value="<?php echo strip_tags(@$x_TCKimlikNo); ?>">&nbsp;</td>
</tr>


<tr>
<td align="right" bgcolor="#666666"><font color="#FFFFFF">Ad&nbsp;</td>
<td bgcolor="#F5F5F5">
<?php
 if (@$_SESSION["uy_status_UserLevel"] == -1) { // Eger Admin ise alias degistirebilsin...
?>
<input type="text" name="x_uye_ad" size="30" maxlength="99" value="<?php echo strip_tags(@$x_uye_ad); ?>">&nbsp;
<? } else {
	echo strip_tags(@$x_uye_ad); 
	}
?>
</td>
</tr>

<tr>
<td align="right" bgcolor="#666666"><font color="#FFFFFF">Soyad&nbsp;</td>
<td bgcolor="#F5F5F5">
<?php
 if (@$_SESSION["uy_status_UserLevel"] == -1) { // Eger Admin ise alias degistirebilsin...
?>
<input type="text" name="x_uye_soyad" size="30" maxlength="99" value="<?php echo strip_tags(@$x_uye_soyad); ?>">&nbsp;
<? } else {
	echo strip_tags(@$x_uye_soyad); 
	}
?>
</td>
</tr>

<tr>

<td align="right" bgcolor="#666666"><font color="#FFFFFF">E-posta 1&nbsp;</td>

<td bgcolor="#F5F5F5"><input type="text" name="x_eposta1" size="30" maxlength="255" value="<?php echo strip_tags(@$x_eposta1); ?>">&nbsp;

</td>

</tr>

<tr>

<td align="right" bgcolor="#666666"><font color="#FFFFFF">E-posta 2&nbsp;</td>

<td bgcolor="#F5F5F5"><input type="text" name="x_eposta2" size="30" maxlength="255" value="<?php echo strip_tags(@$x_eposta2); ?>">&nbsp;</td>


<tr>

<td align="right" bgcolor="#666666"><font color="#FFFFFF">E-posta LKD&nbsp;</td>

<td bgcolor="#F5F5F5">
<?php
 if (@$_SESSION["uy_status_UserLevel"] == -1) { // Eger Admin ise alias degistirebilsin...
?>
<input type="text" name="x_alias" value="<?php echo strip_tags(@$x_alias); ?>"><a href="mailto:<?php echo $x_alias; ?>"><?php echo $x_alias; ?></a>&nbsp;</td>
<?
} else { //Doruk Fisek'in Katkilari ile... 
?>
<input type="hidden" name="x_alias" value="<?php echo strip_tags(@$x_alias); ?>"><a href="mailto:<?php echo $x_alias; ?>"><?php echo $x_alias; ?></a>&nbsp;</td>
<?php
}
?>
</tr>

<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Kayıt tarihi&nbsp;</td>
 <td bgcolor="#F5F5F5">
 <?php
  if (@$_SESSION["uy_status_UserLevel"] == -1) { // Eger Admin ise alias degistirebilsin...
 ?>
 <input type="text" name="x_kayit_tarihi" value="<?php echo strip_tags(@$x_kayit_tarihi); ?>">
 <? } else {
 	echo strip_tags(@$x_kayit_tarihi);
	}
 ?>
 </td>
</tr>

<tr>

<td align="right" bgcolor="#666666"><font color="#FFFFFF">Cinsiyet&nbsp;</td>

 <?php if (@$_SESSION["uy_status_UserLevel"] == -1) {
  	echo "<td bgcolor=\"#F5F5F5\">";
	echo "<input type=\"radio\" name=\"x_cinsiyet\" ";
	if( $x_cinsiyet == "e" )
		echo "checked";
	echo " value=\"e\">erkek&nbsp;";
	echo "<input type=\"radio\" name=\"x_cinsiyet\" ";
	if( $x_cinsiyet == "m" )
		echo "checked";
	echo " value=\"m\">kadın&nbsp;</td>";
  
       } else {
 	   echo "<td bgcolor=\"#F5F5F5\">&nbsp;";
	   
	   if( $x_cinsiyet == "e" )
	   	echo "erkek";
	   else
	   	echo "kadın";
	   
	   echo "</td>";
	   }
  ?>

</tr>

<tr>

<td align="right" bgcolor="#666666"><font color="#FFFFFF">Kurum&nbsp;</td>

<td bgcolor="#F5F5F5"><input type="text" name="x_kurum" size="30" maxlength="255" value="<?php echo strip_tags(@$x_kurum); ?>">&nbsp;</td>

</tr>

<tr>

<td align="right" bgcolor="#666666"><font color="#FFFFFF">Görev&nbsp;</td>

<td bgcolor="#F5F5F5"><input type="text" name="x_gorev" size="30" maxlength="255" value="<?php echo strip_tags(@$x_gorev); ?>">&nbsp;</td>

</tr>

<tr>

<td align="right" bgcolor="#666666"><font color="#FFFFFF">Mezuniyet&nbsp;</td>

<td bgcolor="#F5F5F5"><input type="text" name="x_mezuniyet" size="30" maxlength="100" value="<?php echo strip_tags(@$x_mezuniyet); ?>">&nbsp;</td>

</tr>

<tr>

<td align="right" bgcolor="#666666"><font color="#FFFFFF">Mezuniyet yılı&nbsp;</td>

<td bgcolor="#F5F5F5"><input type="text" name="x_mezuniyet_yil" size="30" maxlength="4" value="<?php echo strip_tags(@$x_mezuniyet_yil); ?>">&nbsp;</td>

</tr>

<tr>

<td align="right" bgcolor="#666666"><font color="#FFFFFF">Mezun olunan bölüm&nbsp;</td>

<td bgcolor="#F5F5F5"><input type="text" name="x_mezuniyet_bolum" size="30" maxlength="100" value="<?php echo strip_tags(@$x_mezuniyet_bolum); ?>">&nbsp;</td>

</tr>

<tr>

<td align="right" bgcolor="#666666"><font color="#FFFFFF">İletişim Adresi&nbsp;</td>

<td bgcolor="#F5F5F5"><textarea name="x_is_addr" cols="35" rows="4"><?php echo @$x_is_addr ?></textarea>&nbsp;</td>

</tr>

<tr>

<td align="right" bgcolor="#666666"><font color="#FFFFFF">Semt&nbsp;</td>

<td bgcolor="#F5F5F5"><input type="text" name="x_semt" size="30" maxlength="100" value="<?php echo strip_tags(@$x_semt); ?>">&nbsp;</td>

</tr>

<tr>

<td align="right" bgcolor="#666666"><font color="#FFFFFF">Şehir&nbsp;</td>

<td bgcolor="#F5F5F5"><input type="text" name="x_sehir" size="30" maxlength="100" value="<?php echo strip_tags(@$x_sehir); ?>">&nbsp;</td>

</tr>

<tr>

<td align="right" bgcolor="#666666"><font color="#FFFFFF">Posta kodu&nbsp;</td>

<td bgcolor="#F5F5F5"><input type="text" name="x_pkod" size="30" maxlength="5" value="<?php echo strip_tags(@$x_pkod); ?>">&nbsp;</td>

</tr>

<tr>

<td align="right" bgcolor="#666666"><font color="#FFFFFF">Yeni Parola&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_PassWord" value="" size=20 maxlength=100>&nbsp;
<small>(Değiştirmek isterseniz)</small>
</td>
</tr>

<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">LKD Üye Listesi&nbsp;</td>
 <td bgcolor="#F5F5F5"><input type="radio" name="x_liste_uyeligi"<?php if ($x_liste_uyeligi == 1) { echo " checked"; } ?> value=1><?php echo "Üye Ol"; ?>
  <input type="radio" name="x_liste_uyeligi"<?php if ($x_liste_uyeligi == 0) { echo " checked"; } ?> value=0><?php echo "Üye Olma"; ?>
&nbsp;</td>
</tr>

<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Gönüllü Çalışmalar&nbsp;</td>
 <td bgcolor="#F5F5F5"><input type="radio" name="x_gonullu"<?php if ($x_gonullu == 1) { echo " checked"; } ?> value=1><?php echo "Katıl"; ?>
  <input type="radio" name="x_gonullu"<?php if ($x_gonullu == 0) { echo " checked"; } ?> value=0><?php echo "Katılma"; ?>
&nbsp;</td>
</tr>

<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Elektronik Oylamalar&nbsp;</td>
 <td bgcolor="#F5F5F5"><input type="radio" name="x_oylama"<?php if ($x_oylama == 1) { echo " checked"; } ?> value=1><?php echo "Katıl"; ?>
  <input type="radio" name="x_oylama"<?php if ($x_oylama == 0) { echo " checked"; } ?> value=0><?php echo "Katılma"; ?>
&nbsp;</td>
</tr>

<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Trac Listesi&nbsp;</td>
 <td bgcolor="#F5F5F5"><input type="radio" name="x_trac_listesi"<?php if ($x_trac_listesi == 1) { echo " checked"; } ?> value=1><?php echo "Üye"; ?>
  <input type="radio" name="x_trac_listesi"<?php if ($x_trac_listesi == 0) { echo " checked"; } ?> value=0><?php echo "Üye Değil"; ?>
&nbsp;</td>
</tr>

<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Haber Alınamıyor&nbsp;</td>
 <td bgcolor="#F5F5F5"><input type="radio" name="x_haber_alinamiyor"<?php if ($x_haber_alinamiyor == 1) { echo " checked"; } ?> value=1><?php echo "Evet"; ?>
  <input type="radio" name="x_haber_alinamiyor"<?php if ($x_haber_alinamiyor == 0) { echo " checked"; } ?> value=0><?php echo "Hayır"; ?>
&nbsp;</td>
</tr>

<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Kimliğinin Gizlenmesini İstiyor&nbsp;</td>
 <td bgcolor="#F5F5F5"><input type="radio" name="x_kimlik_gizli"<?php if ($x_kimlik_gizli == 1) { echo " checked"; } ?> value=1><?php echo "Evet"; ?>
  <input type="radio" name="x_kimlik_gizli"<?php if ($x_kimlik_gizli == 0) { echo " checked"; } ?> value=0><?php echo "Hayır"; ?>
&nbsp;</td>
</tr>

<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Kimlik Durumu&nbsp;</td>
 <td bgcolor="#F5F5F5">
  <?php
   $kimlik_durumu_dizisi = array("Var/İstemiyor", "İstiyor", "Dijital Fotoğraf Bekleniyor", "Basılacak", "Basıldı", "Güncel Adres Bekleniyor", "Postaya Verilecek");
   foreach ($kimlik_durumu_dizisi as $i) {
  ?>
  <input type="radio" name="x_kimlik_durumu"<?php if ($x_kimlik_durumu == $i) { echo " checked"; } ?> value="<?php echo $i; ?>"><?php echo $i; ?>&nbsp;
  <?php } ?>
 </td>
</tr>

<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Telefon 1&nbsp;</td>
 <td bgcolor="#F5F5F5"><input type="text" name="x_Telefon1" value="<?php echo strip_tags(@$x_Telefon1); ?>">&nbsp;</td>
</tr>


<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Telefon 2&nbsp;</td>
 <td bgcolor="#F5F5F5"><input type="text" name="x_Telefon2" value="<?php echo strip_tags(@$x_Telefon2); ?>">&nbsp;</td>
</tr>


<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Üye Karar No&nbsp;</td>
 <?php if (@$_SESSION["uy_status_UserLevel"] == -1) { ?>
  <td bgcolor="#F5F5F5"><input type="text" name="x_Uye_karar_no" value="<?php echo strip_tags(@$x_Uye_karar_no); ?>">&nbsp;</td>
 <?} else { ?>
  <td bgcolor="#F5F5F5">&nbsp;<?php echo strip_tags(@$x_Uye_karar_no); ?>&nbsp;</td>
 <? } ?>
</tr>


<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Üye Karar Tarihi&nbsp;</td>
 <?php if (@$_SESSION["uy_status_UserLevel"] == -1) { ?>
  <td bgcolor="#F5F5F5"><input type="text" name="x_Uye_karar_tarih" value="<?php echo strip_tags(@$x_Uye_karar_tarih); ?>">&nbsp; <small>(Yıl-Ay-Gün)</small></td>
 <?} else { ?>
  <td bgcolor="#F5F5F5"><?php echo strip_tags(@$x_Uye_karar_tarih); ?></td>
 <? } ?>
</tr>

<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Artık Üye Değil&nbsp;</td>
 <td bgcolor="#F5F5F5">
  <input type="radio" name="x_artik_uye_degil"<?php if ($x_artik_uye_degil == 0) { echo " checked"; } ?> value=0><?php echo "Hayır"; ?>
  <input type="radio" name="x_artik_uye_degil"<?php if ($x_artik_uye_degil == 1) { echo " checked"; } ?> value=1><?php echo "<font color=red>EVET</font> (Dikkat! Arayüzden Geri Dönülemez!)"; ?>
 </td>
</tr>

<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Resmi Evraklar için  Fotoğraf&nbsp;</td>
 <?php if (@$_SESSION["uy_status_UserLevel"] == -1) { 
  	echo "<td bgcolor=\"#F5F5F5\">";
	echo "<input type=\"radio\" name=\"x_vesikalik_foto\" ";
	if( $x_vesikalik_foto == 1 )
		echo "checked";
	echo " value=1>Var&nbsp;";
	echo "<input type=\"radio\" name=\"x_vesikalik_foto\" ";
	if( $x_vesikalik_foto == 0 )
		echo "checked";
	echo " value=0>Yok&nbsp;</td>";
  
 } else {
 	   echo "<td bgcolor=\"#F5F5F5\">&nbsp;";
	   
	   if( $x_vesikalik_foto == 1 )
	   	echo "Evet";
	   else
	   	echo "Hayır";
	   
	   echo "</td>";
	   }
  ?>
</tr>


<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Üye Formu&nbsp;</td>
 <?php if (@$_SESSION["uy_status_UserLevel"] == -1) { 
  	echo "<td bgcolor=\"#F5F5F5\">";
	echo "<input type=\"radio\" name=\"x_Uye_formu\" ";
	if( $x_Uye_formu == 1 )
		echo "checked";
	echo " value=1>Var&nbsp;";
	echo "<input type=\"radio\" name=\"x_Uye_formu\" ";
	if( $x_Uye_formu == 0 )
		echo "checked";
	echo " value=0>Yok&nbsp;</td>";
  
 } else {
 	   echo "<td bgcolor=\"#F5F5F5\">&nbsp;";
	   
	   if( $x_Uye_formu == 1 )
	   	echo "Evet";
	   else
	   	echo "Hayır";
	   
	   echo "</td>";
	   }
  ?>
</tr>


<?php
if (@$_SESSION["uy_status_UserLevel"] == -1) {
?>
<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Notlar&nbsp;</td>
 <td bgcolor="#F5F5F5"><textarea name="x_Notlar" rows="4" cols="34"><?php echo strip_tags(@$x_Notlar); ?></textarea></td>
</tr>
<?php } ?>

<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Resim&nbsp;</td>
 <td bgcolor="#F5F5F5"><?php if (!is_null($x_Resim)) { ?>
<input type="radio" name="a_x_Resim" value="1" checked>Olduğu gibi bırak&nbsp;<input type="radio" name="a_x_Resim" value="2">Sil&nbsp;<input type="radio" name="a_x_Resim" value="3">Değiştir<br>
<input type="file" name="x_Resim" onChange="if (this.form.a_x_Resim[2]) this.form.a_x_Resim[2].checked=true;">&nbsp;(jpg/jpeg)</td>

</tr>

<tr>
 <td align="right" bgcolor="#666666">&nbsp;</td>
 <td bgcolor="#F5F5F5">
  <?php if ($x_Resim != "") { ?>
  <a target="_blank" href="uye_resimler/<?php echo "$x_Resim"; ?>">
   <img width=200 src="uye_resimler/<?php echo "$x_Resim"; ?>" border="0">
  </a>
  <?php } else {
                echo "Daha önce resim yüklenmedi";
               }
  ?>
 </td>
</tr>

<? } ?>

<tr>

  <td colspan="2" align="right" bgcolor="#466176"><INPUT type="submit" name="Action" value="DÜZENLE"></td>

  </tr>

</table>

<p>

</form>

<?php include ("footer.php") ?>
