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
		$row = mysql_fetch_assoc($rs);
            foreach ($row as $key => $value) {
                eval('$x_' . $key . ' = @$row["' . $key . '"];');
            }
		mysql_free_result($rs);

		$sql2 = "SELECT privilege FROM members WHERE uye_no=" . $x_uye_id;
		$presult = mysql_query($sql2,$conn) or die(mysql_error());
		$row2 = mysql_fetch_row($presult);
		$privilege =  $row2[0];

		mysql_free_result($presult);

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
<td bgcolor="#466176"><font color="#FFFFFF">Üye Numarası</td>
<td bgcolor="#F5F5F5"><?php echo $x_uye_id; ?></td>
</tr>
<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">TC Kimlik No</td>
 <td bgcolor="#F5F5F5"><?php echo strip_tags(@$x_TCKimlikNo)?></td>
</tr>

<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Ad</td>
<td bgcolor="#F5F5F5"><?php echo $x_uye_ad; ?></td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Soyad</td>
<td bgcolor="#F5F5F5"><?php echo $x_uye_soyad; ?></td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">E-posta 1</td>
<td bgcolor="#F5F5F5"><?php echo $x_eposta1; ?></td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">E-posta 2</td>
<td bgcolor="#F5F5F5"><?php echo $x_eposta2; ?></td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">LKD e-posta</td>
<td bgcolor="#F5F5F5"><?php echo "$x_alias"; ?></td>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Kayıt tarihi</td>
 <td bgcolor="#F5F5F5"><?php echo "$x_kayit_tarihi"; ?></td>
</tr>

<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Cinsiyet</td>
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
</td>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">LKD Üye Listesi</td>
 <td bgcolor="#F5F5F5">
  <?
    if( $x_liste_uyeligi == 1 )
    	echo "Üye";
    else
    	echo "Üye Değil";
  ?>
 </td>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Yetki</td>
 <td bgcolor="#F5F5F5">
  <?
    if( $privilege == 10 )
    	echo "Web düzenleyebilir";
    elseif( $privilege == 0 )
    	echo "Normal";
  ?>
 </td>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Gönüllü Çalışmalar</td>
 <td bgcolor="#F5F5F5">
  <?
    if( $x_gonullu == 1 )
    	echo "Katıl";
    else
    	echo "Katılma";
  ?>
 </td>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Elektronik Oylamalar</td>
 <td bgcolor="#F5F5F5">
  <?
    if( $x_oylama == 1 )
    	echo "Katıl";
    else
    	echo "Katılma";
  ?>
 </td>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Trac Listesi</td>
 <td bgcolor="#F5F5F5">
  <?
    if( $x_trac_listesi == 1 )
    	echo "Üye";
    else
    	echo "Üye Değil";
  ?>
 </td>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Haber Alınamıyor</td>
 <td bgcolor="#F5F5F5">
  <?
    if( $x_haber_alinamiyor == 1 )
    	echo "Evet";
    else
    	echo "Hayır";
  ?>
 </td>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Kimliğinin Gizlenmesini İstiyor</td>
 <td bgcolor="#F5F5F5">
  <?
    if( $x_kimlik_gizli == 1 )
    	echo "Evet";
    else
    	echo "Hayır";
  ?>
 </td>
</tr>

<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Kimlik Durumu</td>
<td bgcolor="#F5F5F5"><?php echo "$x_kimlik_durumu"; ?></td>
</tr>

<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Kurum</td>
<td bgcolor="#F5F5F5"><?php echo $x_kurum; ?></td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Görev</td>
<td bgcolor="#F5F5F5"><?php echo $x_gorev; ?></td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Mezuniyet</td>
<td bgcolor="#F5F5F5"><?php echo $x_mezuniyet; ?></td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Mezuniyet yılı</td>
<td bgcolor="#F5F5F5"><?php echo $x_mezuniyet_yil; ?></td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Mezun olunan bölüm</td>
<td bgcolor="#F5F5F5"><?php echo $x_mezuniyet_bolum; ?></td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">İletişim Adresi</td>
<td bgcolor="#F5F5F5"><?php echo str_replace(chr(10), "<br>" ,@$x_is_addr . "") ?></td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Semt</td>
<td bgcolor="#F5F5F5"><?php echo $x_semt; ?></td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Şehir</td>
<td bgcolor="#F5F5F5"><?php echo $x_sehir; ?></td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Posta kodu</td>
<td bgcolor="#F5F5F5"><?php echo $x_pkod; ?></td>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Telefon 1</td>
 <td bgcolor="#F5F5F5"><?php echo strip_tags(@$x_Telefon1)?></td>
</tr>


<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Telefon 2</td>
 <td bgcolor="#F5F5F5"><?php echo strip_tags(@$x_Telefon2)?></td>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Üye Hesabı Açılış</td>
 <td bgcolor="#F5F5F5"><?php echo "$x_kayit_acilis_tarih"; ?></td>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Üye Karar No</td>
 <td bgcolor="#F5F5F5"><?php echo strip_tags(@$x_Uye_karar_no)?></td>
</tr>


<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Üye Karar Tarihi</td>
 <td bgcolor="#F5F5F5"><?php echo strip_tags(@$x_Uye_karar_tarih)?></td>
</tr>


<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Resmi Evraklar için Fotoğraf</td>
 <td bgcolor="#F5F5F5">
  <?
    if( $x_vesikalik_foto == 1 )
    	echo "Var";
    else
    	echo "Yok";
  ?>
 </td>
</tr>


<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Üye Formu</td>
 <td bgcolor="#F5F5F5">
  <?
    if( $x_Uye_formu )
    	echo "<a target=\"_blank\" href=\"$UyeFormlarDizin/$x_uye_id.tif\">Var</a>";
    else
    	echo "Yok";
  ?>
 </td>
</tr>

<?php if($x_artik_uye_degil == 1) { ?>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Üye Hesabı Kapanış</td>
 <td bgcolor="#F5F5F5"><?php echo "$x_kayit_kapanis_tarih"; ?></td>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Ayrılma tarihi</td>
 <td bgcolor="#F5F5F5"><?php echo "$x_ayrilma_tarihi"; ?></td>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Ayrılma Karar No</td>
 <td bgcolor="#F5F5F5"><?php echo strip_tags(@$x_Ayrilma_karar_no)?></td>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Ayrılma Karar Tarihi</td>
 <td bgcolor="#F5F5F5"><?php echo strip_tags(@$x_Ayrilma_karar_tarih)?></td>
</tr>

<?php } ?>

 <tr>
  <td bgcolor="#466176"><font color="#FFFFFF">Notlar</td>
  <td bgcolor="#F5F5F5"><? echo strip_tags(@$x_Notlar); ?></td>
 </tr>

<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Resim</td>
<td bgcolor="#F5F5F5">
<?php if ($x_Resim != "") { ?>
<a target="_blank" href="<?php echo "$UyeResimlerDizin/$x_Resim"; ?>">
<img width="150" src="<?php echo "$UyeResimlerDizin/w150/$x_Resim"; ?>" border="0">
</a>
<?php } else {
		echo "Resim Yüklenmedi";
	     }
?>


</td>
</tr>
</table>
</form>
<p>
<?php require ('footer.inc.php') ?>
