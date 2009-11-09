<?php
session_start();

define("DEFAULT_LOCALE", "tr_TR");
@setlocale(LC_ALL, DEFAULT_LOCALE);

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // gecmis zaman olurki
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // herdaim gunceliz
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0

require ('ayarlar.inc.php');
require ('fonksiyonlar.inc.php');

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
foreach ($_POST as $keys => $value) {
        eval('$' . $keys . ' = @$_POST["' . $keys . '"];');
}

// baglanti hazirlaniyor...
$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB, $conn);
mysql_query("SET NAMES 'utf8'", $conn);

switch ($a)
{
	case "I": // gosterilecek bir kayit  var
		$tkey = "" . $key . "";
		$strsql = "SELECT * FROM uyeler WHERE id=" . $tkey;
		$rs = mysql_query($strsql, $conn) or die(mysql_error());
		if (!($row = mysql_fetch_assoc($rs))) {
     	ob_end_clean();
			header("Location: uyelerlist.php");
		}

		// degerleri ayir...
        foreach ($row as $keys => $value) {
            eval('$x_' . $keys . ' = @$row["' . $keys . '"];');
        }

		mysql_free_result($rs);
		break;
	case "U": // update

			$tkey = "" . $key . "";
	
		// Guncellemeden once bir eski kaydi saglama alalimk
		$strselectsql = "SELECT eposta1,alias,artik_uye_degil FROM uyeler WHERE uye_id=$_POST[x_uye_id]";
		$rs = mysql_query($strselectsql, $conn) or die(mysql_error());
		$row_eski = mysql_fetch_array($rs);
	
		// form degerleri...
        foreach ($_POST as $keys => $value) {
            eval('$' . $keys . ' = @$_POST["' . $keys . '"];');
        }

		// check file size
		$EW_MaxFileSize = @strip_tags($_POST["EW_MaxFileSize"]);
		if (!empty($_FILES["x_Resim"]["size"])) {
			if (!empty($EW_MaxFileSize) && $_FILES["x_Resim"]["size"] > $EW_MaxFileSize) {
				die("Max. file upload size exceeded");
			}
		}
		$a_x_Resim = @strip_tags($_POST["a_x_Resim"]);

		// check file size
		$EW_MaxFileSize = @strip_tags($_POST["EW_MaxFileSize"]);
		if (!empty($_FILES["x_Uye_formu"]["size"])) {
			if (!empty($EW_MaxFileSize) && $_FILES["x_Uye_formu"]["size"] > $EW_MaxFileSize) {
				die("Max. file upload size exceeded");
			}
		}
		$a_x_Uye_formu= @strip_tags($_POST["a_x_Uye_formu"]);
		
		// degerleri array'e atalim

		// degerleri array'e atalim
        foreach ($_POST as $key => $value) {
            if (substr($key, 0, 2) == "x_") {

                eval('$theValue = (!get_magic_quotes_gpc()) ? addslashes($' . $key . ') : $' . $key . ';');

                switch ($key)
                {
                    case "uye_id";
                    case "liste_uyeligi";
                    case "gonullu";
                    case "oylama";
                    case "Uye_karar_no";
                    case "vesikalik_foto";
                    case "Uye_formu";
                    case "trac_listesi";
                    case "haber_alinamiyor";
                    case "kimlik_gizli";
                        $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                    break;

                    default;
                        $theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
                    break;
                }

                eval('$fieldList["' . substr($key,2) . '"] = $theValue;');
            }
        }

		// PassWord
		if( $x_PassWord ) { // If new password is set

			//$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_PassWord) : $x_PassWord;
			$theValue = ($theValue != "") ? " '" . md5($x_PassWord) . "'" : "NULL";
			$fieldList["PassWord"] = $theValue;
		}

		
		// Resim

		if ($a_x_Resim == "2") { // cikart

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

			$uploadedfile = $_FILES["x_Resim"]["tmp_name"];

			$src = imagecreatefromjpeg($uploadedfile);

			// Capture the original size of the uploaded image
			list($width,$height)=getimagesize($uploadedfile);
			
			$newwidth=150;
			$newheight=($height/$width)*$newwidth;
			$tmp=imagecreatetruecolor($newwidth,$newheight);
			
			// this line actually does the image resizing, copying from the original
			// image into the $tmp image
			imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
			
			// now write the resized image to disk.
			$filename = $UyeResimlerDizin . "/w150/". $DosyaAdi . ".$Uzanti";
			imagejpeg($tmp,$filename,100);

     		$destfile = './' . $UyeResimlerDizin . '/' . $DosyaAdi . ".$Uzanti";

     		if (!move_uploaded_file($_FILES["x_Resim"]["tmp_name"], $destfile)) // dosyayi yerine gonderemediysek...

     			die("Dosya gondermediniz veya dosya yerine yerlestirilemedi!" . $destfile);


				$fieldList["Resim"] = " '" . $DosyaAdi . ".$Uzanti" . "'";

				unlink($_FILES["x_Resim"]["tmp_name"]);

			}

		}


		// Form

		if ($a_x_Uye_formu == "2") { // cikart

			unlink("$UyeFormlarDizin/$x_uye_id.tif");

			$fieldList["Uye_formu"] = "NULL";

		} else if ($a_x_Uye_formu== "3") { // guncelle

			if (is_uploaded_file($_FILES["x_Uye_formu"]["tmp_name"])) {
			$Gecici = explode(".", $_FILES["x_Uye_formu"]["name"]);
			$Uzanti = strtolower($Gecici[ count($Gecici)-1 ]);
			if( !eregi("tif|tiff", $Uzanti) )
				die("Dosyaniz tif degil!");

				$DosyaAdi = $x_uye_id;

     		$destfile = './' . $UyeFormlarDizin . '/' . $DosyaAdi . ".$Uzanti";

     		if (!move_uploaded_file($_FILES["x_Uye_formu"]["tmp_name"], $destfile)) // dosyayi yerine gonderemediysek...

     			die("Dosya gondermediniz veya dosya yerine yerlestirilemedi!" . $destfile);

				$fieldList["Uye_formu"] = " '" . $DosyaAdi . ".$Uzanti" . "'";

				unlink($_FILES["x_Uye_formu"]["tmp_name"]);

			}

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
		
  		$rs = mysql_query($updateSQL, $conn) or die(mysql_error());

              if(!$row_eski['artik_uye_degil']) // eger artik uye olmayan birinin kaydi duzenleniyorsa, diger veritabaninda zaten kaydi kalmamistir, bu kismi atla
               {		
		// alias tablosunu da guncelleyelim - once birini sonra digerini guncellemeli, baska anahtar yok tabloda
                mysql_select_db(DB_MAIL, $conn);
                $conn_mail = mysql_connect(HOST_MAIL, USER_MAIL, PASS_MAIL);
		mysql_select_db(DB_MAIL, $conn_mail);
                mysql_query("SET NAMES 'utf8'", $conn_mail);
		if($row_eski[alias] != $x_alias)
		 {
		  $updateSQL = "UPDATE forwardings SET source='$x_alias' WHERE destination = '$row_eski[eposta1]'";
		  $rs = mysql_query($updateSQL, $conn) or die(mysql_error());
		  $rs = mysql_query($updateSQL, $conn_mail) or die(mysql_error());
		  
		  if($row_eski[eposta1] != $x_eposta1)		// eger hem alias hem eposta guncelleniyorsa, guncellenen alias'i anahtar almak gerek
		   {
		    $updateSQL = "UPDATE forwardings SET destination='$x_eposta1' WHERE source = '$x_alias'";
		    $rs = mysql_query($updateSQL, $conn) or die(mysql_error());
		    $rs = mysql_query($updateSQL, $conn_mail) or die(mysql_error());
		   }
		 }
		elseif($row_eski[eposta1] != $x_eposta1)	// sadece eposta guncelleniyorsa, eski alias'i anahtar almak gerek
		 {
		  $updateSQL = "UPDATE forwardings SET destination='$x_eposta1' WHERE source = '$row_eski[alias]'";
		  $rs = mysql_query($updateSQL, $conn) or die(mysql_error());
		  $rs = mysql_query($updateSQL, $conn_mail) or die(mysql_error());
		 }
                // Uye, uyelikten ayrildiysa e-postasi postfix veritabanindan kaldiralim -- artik kullanmasin
                if($x_artik_uye_degil)
                 {
                  // Uye, uyelikten ayrildiysa, kayit kapanis zaman damgasi yazalim
                  $stampSQL = "UPDATE uyeler SET kayit_kapanis_tarih = '" . date("Y-m-d H:i:s") . "' WHERE id=". $tkey ;
                  $rs = mysql_query($stampSQL, $conn) or die(mysql_error());

                  $strsql = "DELETE FROM forwardings WHERE source='$x_alias'";
                  mysql_query($strsql, $conn) or die(mysql_error());
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
               }
		ob_end_clean();
		
		header("Location: uyelerview.php?key=$tkey");

}

?>

<?php require ('header.inc.php') ?>

<script language="JavaScript" src="js/ew.js"></script>

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
<input type="text" name="x_uye_ad" size="30" maxlength="99" value="<?php echo strip_tags(@$x_uye_ad); ?>">&nbsp;
</td>
</tr>

<tr>
<td align="right" bgcolor="#666666"><font color="#FFFFFF">Soyad&nbsp;</td>
<td bgcolor="#F5F5F5">
<input type="text" name="x_uye_soyad" size="30" maxlength="99" value="<?php echo strip_tags(@$x_uye_soyad); ?>">&nbsp;
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
<input type="text" name="x_alias" value="<?php echo strip_tags(@$x_alias); ?>"><a href="mailto:<?php echo $x_alias; ?>"><?php echo $x_alias; ?></a>&nbsp;</td>
</tr>

<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Kayıt tarihi&nbsp;</td>
 <td bgcolor="#F5F5F5">
 <input type="text" name="x_kayit_tarihi" value="<?php echo strip_tags(@$x_kayit_tarihi); ?>">
 </td>
</tr>

<tr>

<td align="right" bgcolor="#666666"><font color="#FFFFFF">Cinsiyet&nbsp;</td>

   <?php
  	echo "<td bgcolor=\"#F5F5F5\">";
	echo "<input type=\"radio\" name=\"x_cinsiyet\" ";
	if( $x_cinsiyet == "e" )
		echo "checked";
	echo " value=\"e\">erkek&nbsp;";
	echo "<input type=\"radio\" name=\"x_cinsiyet\" ";
	if( $x_cinsiyet == "m" )
		echo "checked";
	echo " value=\"m\">kadın&nbsp;</td>";
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
  <td bgcolor="#F5F5F5"><input type="text" name="x_Uye_karar_no" value="<?php echo strip_tags(@$x_Uye_karar_no); ?>">&nbsp;</td>
</tr>


<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Üye Karar Tarihi&nbsp;</td>
  <td bgcolor="#F5F5F5"><input type="text" name="x_Uye_karar_tarih" value="<?php echo strip_tags(@$x_Uye_karar_tarih); ?>">&nbsp; <small>(Yıl-Ay-Gün)</small></td>
</tr>

<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Artık Üye Değil&nbsp;</td>
 <td bgcolor="#F5F5F5">
  <input type="radio" name="x_artik_uye_degil"<?php if ($x_artik_uye_degil == 0) { echo " checked"; } ?> value=0><?php echo "Hayır"; ?>
  <input type="radio" name="x_artik_uye_degil"<?php if ($x_artik_uye_degil == 1) { echo " checked"; } ?> value=1><?php echo "<font color=red>EVET</font> (Dikkat! Arayüzden Geri Dönülemez!)"; ?>
 </td>
</tr>

<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Ayrılma tarihi&nbsp;</td>
 <td bgcolor="#F5F5F5">
 <input type="text" name="x_ayrilma_tarihi" value="<?php echo strip_tags(@$x_ayrilma_tarihi); ?>">
 </td>
</tr>

<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Ayrılma Karar No&nbsp;</td>
  <td bgcolor="#F5F5F5"><input type="text" name="x_Ayrilma_karar_no" value="<?php echo strip_tags(@$x_Ayrilma_karar_no); ?>">&nbsp;</td>
</tr>


<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Ayrılma Karar Tarihi&nbsp;</td>
  <td bgcolor="#F5F5F5"><input type="text" name="x_Ayrilma_karar_tarih" value="<?php echo strip_tags(@$x_Ayrilma_karar_tarih); ?>">&nbsp; <small>(Yıl-Ay-Gün)</small></td>
</tr>

<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Resmi Evraklar için Fotoğraf&nbsp;</td>
  <?php
  	echo "<td bgcolor=\"#F5F5F5\">";
	echo "<input type=\"radio\" name=\"x_vesikalik_foto\" ";
	if( $x_vesikalik_foto == 1 )
		echo "checked";
	echo " value=1>Var&nbsp;";
	echo "<input type=\"radio\" name=\"x_vesikalik_foto\" ";
	if( $x_vesikalik_foto == 0 )
		echo "checked";
	echo " value=0>Yok&nbsp;</td>";
  ?>
</tr>


<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Üye Formu&nbsp;</td>
 <td bgcolor="#F5F5F5">
<input type="radio" name="a_x_Uye_formu" value="1" checked>Olduğu gibi bırak&nbsp;<input type="radio" name="a_x_Uye_formu" value="2">Sil&nbsp;<input type="radio" name="a_x_Uye_formu" value="3">Değiştir<br>
<input type="file" name="x_Uye_formu" onChange="if (this.form.a_x_Uye_formu[2]) this.form.a_x_Uye_formu[2].checked=true;">&nbsp;(tif)</td>

</tr>

<tr>
 <td align="right" bgcolor="#666666">&nbsp;</td>
 <td bgcolor="#F5F5F5">
  <?php if ($x_Uye_formu != "") { ?>
  <a target="_blank" href="<?php echo "$UyeFormlarDizin/$x_Uye_formu"; ?>">Formu İndir</a>
  <?php } else {
                echo "Daha önce form yüklenmedi";
               }
  ?>
 </td>
</tr>


<tr>
 <td align="right" bgcolor="#666666"><font color="#FFFFFF">Notlar&nbsp;</td>
 <td bgcolor="#F5F5F5"><textarea name="x_Notlar" rows="4" cols="34"><?php echo strip_tags(@$x_Notlar); ?></textarea></td>
</tr>

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
   <img width="150" src="uye_resimler/w150/<?php echo "$x_Resim"; ?>" border="0">
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

<?php require ('footer.inc.php') ?>
