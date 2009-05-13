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
$ewCurSec = 0; // baslangic Sec degeri
$ewCurIdx = intval(@$_SESSION["uy_status_UserLevel"]);
if ($ewCurIdx == -1) { //
	$ewCurSec = 31;
} elseif ($ewCurIdx > 0 && $ewCurIdx <= 4) {
	$ewCurSec = $ew_SecTable[$ewCurIdx-1];
}
if (($ewCurSec & ewAllowview) <> ewAllowview) header("Location: uyelerlist.php");
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

// baglanti hazirlaniyor...
$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB);
        mysql_query("SET NAMES 'utf8'");

switch ($a)
{
	case "I": // gosterilecek bir kayit  var
		$tkey = "" . $key . "";
		$strsql = "SELECT * FROM uyeler WHERE id=" . $tkey;
    if ($_SESSION["uy_status_UserLevel"] <> -1) { //yonetici degil!
			$strsql .= " AND (uye_id = " . @$_SESSION["uy_status_UserID"] . ")";
    }
		$rs = mysql_query($strsql,$conn) or die(mysql_error());
		if (mysql_num_rows($rs) == 0 ) {
			header("Location:uyelerlist.php");
		}

		// degerleri ayir...
		$row = mysql_fetch_array($rs);
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
		$x_AuthLevel = @$row["AuthLevel"];
		$x_PassWord = @$row["PassWord"];
		$x_Resim = @$row["Resim"];
		$x_Telefon1 = @$row["Telefon1"];
		$x_Telefon2 = @$row["Telefon2"];
		$x_TCKimlikNo = @$row["TCKimlikNo"];
		$x_Uye_karar_no = @$row["Uye_karar_no"];
		$x_Uye_karar_tarih = @$row["Uye_karar_tarih"];
		$x_kimlik_basildi = @$row["kimlik_basildi"];
		$x_kimlik_iletildi = @$row["kimlik_iletildi"];
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
}
?>
<?php include ("header.php") ?>
<br>
<div align="center">
 <a href="uyelerlist.php"><img border=0 title="Listeye Dön" alt="Listeye Dön" src="images/ed_undo.gif"></a>
 <a href="uyeleredit.php?key=<?php echo $tkey;?>"><img border=0 title="Düzenle" alt="Düzenle" src="images/edit.gif"></a>
</div>

<?php if( $x_artik_uye_degil == 1 ) { ?>
<h1 align="center"><font color="red">ÜYE DERNEKTEN AYRILMIŞTIR</font></h1>
<?php } ?>

<?php if( $x_artik_uye_degil == 1 ) { ?>
<h1 align="center"><font color="blue">ÜYEDEN HABER ALINAMAMAKTADIR</font></h1>
<?php } ?>

<form>
<table align="center" width="60%" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">

<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Üye Numarası&nbsp;</td>
<td bgcolor="#F5F5F5"><?php echo $x_uye_id; ?>&nbsp;</td>
</tr>
<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">TC Kimlik No&nbsp;</td>
 <td bgcolor="#F5F5F5"><?php echo strip_tags(@$x_TCKimlikNo)?>&nbsp;</td>
</tr>

<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Ad&nbsp;</td>
<td bgcolor="#F5F5F5"><?php echo $x_uye_ad; ?>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Soyad&nbsp;</td>
<td bgcolor="#F5F5F5"><?php echo $x_uye_soyad; ?>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">E-posta 1&nbsp;</td>
<td bgcolor="#F5F5F5"><?php echo $x_eposta1; ?>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">E-posta 2&nbsp;</td>
<td bgcolor="#F5F5F5"><?php echo $x_eposta2; ?>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">LKD e-posta&nbsp;</td>
<td bgcolor="#F5F5F5"><?php echo "$x_alias"; ?>&nbsp;</td>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Kayıt tarihi&nbsp;</td>
 <td bgcolor="#F5F5F5"><?php echo "$x_kayit_tarihi"; ?>&nbsp;</td>
</tr>

<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Cinsiyet&nbsp;</td>
<td bgcolor="#F5F5F5"><?php
switch ($x_cinsiyet) {
	case "e":
		echo "erkek";
		break;
	case "m":
		echo "kadın";
		break;
}
?>
&nbsp;</td>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">LKD Üye Listesi&nbsp;</td>
  <?
    echo "<td bgcolor=\"#F5F5F5\">";
    if( $x_liste_uyeligi == 1 )
    	echo "Üye";
    else
    	echo "Üye Değil";

    echo "&nbsp;</td>";
  ?>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Gönüllü Çalışmalar&nbsp;</td>
  <?
    echo "<td bgcolor=\"#F5F5F5\">";
    if( $x_gonullu == 1 )
    	echo "Katıl";
    else
    	echo "Katılma";

    echo "&nbsp;</td>";
  ?>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Elektronik Oylamalar&nbsp;</td>
  <?
    echo "<td bgcolor=\"#F5F5F5\">";
    if( $x_oylama == 1 )
    	echo "Katıl";
    else
    	echo "Katılma";

    echo "&nbsp;</td>";
  ?>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Trac Listesi&nbsp;</td>
  <?
    echo "<td bgcolor=\"#F5F5F5\">";
    if( $x_trac_listesi == 1 )
    	echo "Üye";
    else
    	echo "Üye Değil";

    echo "&nbsp;</td>";
  ?>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Haber Alınamıyor&nbsp;</td>
  <?
    echo "<td bgcolor=\"#F5F5F5\">";
    if( $x_haber_alinamiyor == 1 )
    	echo "Evet";
    else
    	echo "Hayır";

    echo "&nbsp;</td>";
  ?>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Kimliğinin Gizlenmesini İstiyor&nbsp;</td>
  <?
    echo "<td bgcolor=\"#F5F5F5\">";
    if( $x_kimlik_gizli == 1 )
    	echo "Evet";
    else
    	echo "Hayır";

    echo "&nbsp;</td>";
  ?>
</tr>

<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Kimlik Durumu&nbsp;</td>
<td bgcolor="#F5F5F5"><?php echo "$x_kimlik_durumu"; ?>&nbsp;</td>
</tr>

<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Kurum&nbsp;</td>
<td bgcolor="#F5F5F5"><?php echo $x_kurum; ?>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Görev&nbsp;</td>
<td bgcolor="#F5F5F5"><?php echo $x_gorev; ?>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Mezuniyet&nbsp;</td>
<td bgcolor="#F5F5F5"><?php echo $x_mezuniyet; ?>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Mezuniyet yılı&nbsp;</td>
<td bgcolor="#F5F5F5"><?php echo $x_mezuniyet_yil; ?>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Mezun olunan bölüm&nbsp;</td>
<td bgcolor="#F5F5F5"><?php echo $x_mezuniyet_bolum; ?>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">İletişim Adresi&nbsp;</td>
<td bgcolor="#F5F5F5"><?php echo str_replace(chr(10), "<br>" ,@$x_is_addr . "") ?>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Semt&nbsp;</td>
<td bgcolor="#F5F5F5"><?php echo $x_semt; ?>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Şehir&nbsp;</td>
<td bgcolor="#F5F5F5"><?php echo $x_sehir; ?>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Posta kodu&nbsp;</td>
<td bgcolor="#F5F5F5"><?php echo $x_pkod; ?>&nbsp;</td>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Telefon 1&nbsp;</td>
 <td bgcolor="#F5F5F5"><?php echo strip_tags(@$x_Telefon1)?>&nbsp;</td>
</tr>


<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Telefon 2&nbsp;</td>
 <td bgcolor="#F5F5F5"><?php echo strip_tags(@$x_Telefon2)?>&nbsp;</td>
</tr>


<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Üye Karar No&nbsp;</td>
 <td bgcolor="#F5F5F5"><?php echo strip_tags(@$x_Uye_karar_no)?>&nbsp;</td>
</tr>


<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Üye Karar Tarihi&nbsp;</td>
 <td bgcolor="#F5F5F5"><?php echo strip_tags(@$x_Uye_karar_tarih)?>&nbsp;</td>
</tr>


<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Kimlik Basıldı&nbsp;</td>
  <?
    echo "<td bgcolor=\"#F5F5F5\">&nbsp;";
    if( $x_kimlik_basildi == 1 )
    	echo "Evet";
    else
    	echo "Hayır";

    echo "</td>";
  ?>
</tr>


<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Kimlik iletildi&nbsp;</td>
  <?
    echo "<td bgcolor=\"#F5F5F5\">&nbsp;";
    if( $x_kimlik_iletildi == 1 )
    	echo "Evet";
    else
    	echo "Hayır";

    echo "</td>";
  ?>
</tr>


<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Resmi Evraklar için Fotoğraf&nbsp;</td>
  <?
    echo "<td bgcolor=\"#F5F5F5\">&nbsp;";
    if( $x_vesikalik_foto == 1 )
    	echo "Var";
    else
    	echo "Yok";

    echo "</td>";
  ?>
</tr>


<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Üye Formu&nbsp;</td>
  <?
    echo "<td bgcolor=\"#F5F5F5\">&nbsp;";
    if( $x_Uye_formu == 1 )
    	echo "<a target=\"_blank\" href=\"uye_formlar/$x_uye_id.tif\">Var</a>";
    else
    	echo "Yok";

    echo "</td>";
  ?>
</tr>


<tr>
<? if(@$_SESSION["uy_status_UserLevel"] == -1 ) { ?>
<?php
switch ($x_AuthLevel) {
case "1":
?>
<td bgcolor="#466176"><font color="#FFFFFF">Auth Level&nbsp;</td>
<td bgcolor="#F5F5F5"><?php if (($ewCurSec & ewAllowAdmin) == ewAllowAdmin) { //system admin ?>
<?
		echo "User";
		break;
}
}
}
?>
&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Parola&nbsp;</td>
<td bgcolor="#F5F5F5">********&nbsp;</td>
</tr>

<? if(@$_SESSION["uy_status_UserLevel"] == -1 ) { ?>
 <tr>
  <td bgcolor="#466176"><font color="#FFFFFF">Notlar&nbsp;</td>
  <td bgcolor="#F5F5F5"><? echo strip_tags(@$x_Notlar); ?></td>
 </tr>
<? } ?>

<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Resim&nbsp;</td>
<td bgcolor="#F5F5F5">
<?php if ($x_Resim != "") { ?>
<a target="_blank" href="uye_resimler/<?php echo "$x_Resim"; ?>">
<img width=200 src="uye_resimler/<?php echo "$x_Resim"; ?>" border="0">
</a>
<?php } else {
		echo "Resim Yüklenmedi";
	     }
?>


&nbsp;</td>
</tr>
</table>
</form>
<p>
<?php include ("footer.php") ?>
