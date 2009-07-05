<?php 
session_start();

define("DEFAULT_LOCALE", "tr_TR");
@setlocale(LC_ALL, DEFAULT_LOCALE);

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // gecmis zaman olurki
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // herdaim gunceliz
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php require ('ayarlar.inc.php') ?>
<?php require ('fonksiyonlar.inc.php') ?>
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
		$x_Ayrilma_karar_no = @$row["Ayrilma_karar_no"];
		$x_Ayrilma_karar_tarih = @$row["Ayrilma_karar_tarih"];
		$x_vesikalik_foto = @$row["vesikalik_foto"];
		$x_Uye_formu = @$row["Uye_formu"];
		$x_Notlar = @$row["Notlar"];
		$x_kayit_tarihi = @$row["kayit_tarihi"];
		$x_ayrilma_tarihi = @$row["ayrilma_tarihi"];
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
<?php require ('header.inc.php') ?>
<br>
<div align="center">
 <a href="uyelerlist.php"><img border=0 title="Listeye Dön" alt="Listeye Dön" src="images/ed_undo.gif"></a>
 <a href="uyeleredit.php?key=<?php echo $tkey;?>"><img border=0 title="Düzenle" alt="Düzenle" src="images/edit.gif"></a>
</div>

<?php if( $x_artik_uye_degil == 1 ) { ?>
<h1 align="center"><font color="red">ÜYE DERNEKTEN AYRILMIŞTIR</font></h1>
<?php } ?>

<?php if( $x_haber_alinamiyor == 1 ) { ?>
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
    if( $x_Uye_formu )
    	echo "<a target=\"_blank\" href=\"$UyeFormlarDizin/$x_uye_id.tif\">Var</a>";
    else
    	echo "Yok";

    echo "</td>";
  ?>
</tr>

<?php if($x_artik_uye_degil == 1) { ?>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Ayrılma tarihi&nbsp;</td>
 <td bgcolor="#F5F5F5"><?php echo "$x_ayrilma_tarihi"; ?>&nbsp;</td>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Ayrılma Karar No&nbsp;</td>
 <td bgcolor="#F5F5F5"><?php echo strip_tags(@$x_Ayrilma_karar_no)?>&nbsp;</td>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Ayrılma Karar Tarihi&nbsp;</td>
 <td bgcolor="#F5F5F5"><?php echo strip_tags(@$x_Ayrilma_karar_tarih)?>&nbsp;</td>
</tr>

<?php } ?>

 <tr>
  <td bgcolor="#466176"><font color="#FFFFFF">Notlar&nbsp;</td>
  <td bgcolor="#F5F5F5"><? echo strip_tags(@$x_Notlar); ?></td>
 </tr>

<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Resim&nbsp;</td>
<td bgcolor="#F5F5F5">
<?php if ($x_Resim != "") { ?>
<a target="_blank" href="<?php echo "$UyeResimlerDizin/$x_Resim"; ?>">
<img width="150" src="<?php echo "$UyeResimlerDizin/w150/$x_Resim"; ?>" border="0">
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
<?php require ('footer.inc.php') ?>
