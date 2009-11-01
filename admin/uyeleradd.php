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

// get action
$a = @$_POST["a"];
if (empty($a)) {
	$key = @$_GET["key"];
	if ($key <> "")	{
		$a = "C"; // kayit klonlama olayi
	} else{
		$a = "I"; // bos kayit goster
	}
}

// baglanti hazirlaniyor...
$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB, $conn);
mysql_query("SET NAMES 'utf8'", $conn);


switch ($a) {
	case "C": // gosterilecek bir kayit  var
		$tkey = "" . $key . "";
		$strsql = "SELECT * FROM uyeler WHERE id=" . $tkey;
		$rs = mysql_query($strsql, $conn);
		if (mysql_num_rows($rs) == 0) {
			ob_end_clean();
			header("Location: uyelerlist.php");
		} else {
			$row = mysql_fetch_array($rs);

		// degerleri ayir...
			$x_uye_id = @$row["uye_id"]; 
			$x_uye_ad = @$row["uye_ad"]; 
			$x_uye_soyad = @$row["uye_soyad"]; 
			$x_eposta1 = @$row["eposta1"]; 
			$x_eposta2 = @$row["eposta2"]; 
			$x_kayit_tarihi = @$row["kayit_tarihi"]; 
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
			$x_Resim = @$row["Resim"]; 
			$x_Telefon1 = @$row["Telefon1"];
			$x_Telefon2 = @$row["Telefon2"];
			$x_TCKimlikNo = @$row["TCKimlikNo"];
			$x_Uye_karar_no = @$row["Uye_karar_no"];
			$x_Uye_karar_tarih = @$row["Uye_karar_tarih"];
			$x_vesikalik_foto = @$row["vesikalik_foto"];
			$x_Uye_formu = @$row["Uye_formu"];
			$x_Notlar = @$row["Notlar"];
			$x_liste_uyeligi = @$row["liste_uyeligi"];
			$x_gonullu = @$row["gonullu"];
			$x_oylama = @$row["oylama"];
			$trac_listesi = @$row["trac_listesi"];
			$haber_alinamiyor = @$row["haber_alinamiyor"];
			$kimlik_gizli = @$row["kimlik_gizli"];
			$kimlik_durumu = @$row["kimlik_durumu"];
		}
		mysql_free_result($rs);
		break;
	case "A": // ekleme

		// form degerleri temizlik basliyorrr.
		$x_id = @strip_tags($_POST["x_id"]);
		$x_uye_id = @strip_tags($_POST["x_uye_id"]);
		$x_uye_ad = @strip_tags($_POST["x_uye_ad"]);
		$x_uye_soyad = @strip_tags($_POST["x_uye_soyad"]);
		$x_eposta1 = @strip_tags($_POST["x_eposta1"]);
		$x_eposta2 = @strip_tags($_POST["x_eposta2"]);
		$x_kayit_tarihi = @strip_tags($_POST["x_kayit_tarihi"]);
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
		$x_Telefon1 = @strip_tags($_POST["x_Telefon1"]);
		$x_Telefon2 = @strip_tags($_POST["x_Telefon2"]);
		$x_TCKimlikNo = @strip_tags($_POST["x_TCKimlikNo"]);
		$x_Uye_karar_no = @strip_tags($_POST["x_Uye_karar_no"]);
		$x_Uye_karar_tarih = @strip_tags($_POST["x_Uye_karar_tarih"]);
		$x_vesikalik_foto = @strip_tags($_POST["x_vesikalik_foto"]);
		$x_Uye_formu = @strip_tags($_POST["x_Uye_formu"]);
		$x_Notlar = @strip_tags($_POST["x_Notlar"]);
		$x_liste_uyeligi = @strip_tags($_POST["x_liste_uyeligi"]);
		$x_gonullu = @strip_tags($_POST["x_gonullu"]);
		$x_oylama = @strip_tags($_POST["x_oylama"]);
		$x_trac_listesi = @strip_tags($_POST["x_trac_listesi"]);
		$x_haber_alinamiyor = @strip_tags($_POST["x_haber_alinamiyor"]);
		$x_kimlik_gizli = @strip_tags($_POST["x_kimlik_gizli"]);
		$x_kimlik_durumu = @strip_tags($_POST["x_kimlik_durumu"]);


		// check file size
		$EW_MaxFileSize = @$_POST["EW_MaxFileSize"];
		if (!empty($_FILES["x_Resim"]["size"])) {
			if (!empty($EW_MaxFileSize) && $_FILES["x_Resim"]["size"] > $EW_MaxFileSize) {
				die("Max. file upload size exceeded");
			}
		}

		// check file size
		$EW_MaxFileSize = @$_POST["EW_MaxFileSize"];
		if (!empty($_FILES["x_Uye_formu"]["size"])) {
			if (!empty($EW_MaxFileSize) && $_FILES["x_Uye_formu"]["size"] > $EW_MaxFileSize) {
				die("Max. file upload size exceeded");
			}
		}

		// degerleri array'e atalim

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

		// eposta1
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_eposta1) : $x_eposta1;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["eposta1"] = $theValue;

		// eposta2
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_eposta2) : $x_eposta2;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["eposta2"] = $theValue;

		// kayit_tarihi
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_kayit_tarihi) : $x_kayit_tarihi;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["kayit_tarihi"] = $theValue;
		
		// alias
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_alias) : $x_alias;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["alias"] = $theValue;

                // liste_uyeligi
                $theValue = (!get_magic_quotes_gpc()) ? addslashes($x_liste_uyeligi) : $x_liste_uyeligi;
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                $fieldList["liste_uyeligi"] = $theValue;

                // gonullu
                $theValue = (!get_magic_quotes_gpc()) ? addslashes($x_gonullu) : $x_gonullu;
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                $fieldList["gonullu"] = $theValue;

                // oylama
                $theValue = (!get_magic_quotes_gpc()) ? addslashes($x_oylama) : $x_oylama;
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                $fieldList["oylama"] = $theValue;

		// cinsiyet
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($x_cinsiyet) : $x_cinsiyet;
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "null";
		$fieldList["cinsiyet"] = $theValue;

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

        $theValue = date("Y-m-d H:i:s");
        $theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
        $fieldList["kayit_acilis_tarih"] = $theValue;

		// Resim
			if (is_uploaded_file($_FILES["x_Resim"]["tmp_name"])) {
			$Gecici = explode(".", $_FILES["x_Resim"]["name"]);
            $Uzanti = strtolower($Gecici[ count($Gecici)-1 ]);
            if( !eregi("jpg|jpeg", $Uzanti) )
                die("Dosyaniz jpg veya jpeg degil!");

            $DosyaAdi = $x_uye_id;

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

            #$destfile = addslashes(dirname($_SERVER["PATH_TRANSLATED"])) . "/".  $UyeResimlerDizin . "/" . $DosyaAdi . ".$Uzanti";			
            $destfile = './' . $UyeResimlerDizin . '/' . $DosyaAdi . ".$Uzanti";
 
     		if (!move_uploaded_file($_FILES["x_Resim"]["tmp_name"], $destfile)) // dosyayi yerine gonderelim...
     			die("Dosya gondermediniz veya dosya yerine yerlestirilemedi!" . $destfile);
				$theName = (!get_magic_quotes_gpc()) ? addslashes($_FILES["x_Resim"]["name"]) : $_FILES["x_Resim"]["name"];
                $fieldList["Resim"] = " '" . $DosyaAdi . ".$Uzanti" . "'";
				#unlink($_FILES["x_Resim"]["tmp_name"]);
			}
            
        // Form
            
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

                #unlink($_FILES["x_Uye_formu"]["tmp_name"]);
            }
            
            
		// vt ye yazma zamani
		$strsql = "INSERT INTO uyeler (";
		$strsql .= implode(",", array_keys($fieldList));
		$strsql .= ") VALUES (";
		$strsql .= implode(",", array_values($fieldList));
		$strsql .= ")";
		mysql_query($strsql, $conn) or die(mysql_error());

		// bir de e-posta alias'ini bir de alias tablosuna yazalim
		mysql_select_db(DB_MAIL,$conn);
                $conn_mail = mysql_connect(HOST_MAIL, USER_MAIL, PASS_MAIL);
		mysql_select_db(DB_MAIL,$conn_mail);
                mysql_query("SET NAMES 'utf8'", $conn_mail);
		$strsql = "INSERT INTO forwardings VALUES('$_POST[x_alias]',$fieldList[eposta1])";
		mysql_query($strsql, $conn) or die(mysql_error());
		mysql_query($strsql, $conn_mail) or die(mysql_error());
		mysql_close($conn_mail);

                // isim / alias bilgisini bir de yeni uye veritabanina yazalim
                $slug = explode('@',$x_alias);
		mysql_select_db(DB_PWD,$conn);
		$strsql = "INSERT INTO members (uye_no,name,lastname,lotr_alias) VALUES($x_uye_id,\"$x_uye_ad\",\"$x_uye_soyad\",\"$slug[0]\")";
		mysql_query($strsql, $conn) or die(mysql_error());

                // isim / alias bilgisini bir de Trac veritabanina yazalim
                mysql_select_db(DB_TRAC,$conn);
                $strsql = 'INSERT INTO session VALUES ("' . $slug[0] . '", 1, 0)';
                mysql_query($strsql, $conn) or die(mysql_error());
                $strsql = 'INSERT INTO session_attribute VALUES ("' . $slug[0] . '", 1, "name", "' . $x_uye_ad . ' ' . $x_uye_soyad . '"),
                                                                ("' . $slug[0] . '", 1, "email", "' . $x_alias . '");';
                mysql_query($strsql, $conn) or die(mysql_error());

                mysql_close($conn);
		
		ob_end_clean();
		header("Location: uyelerlist.php");
		break;
}
?>
<?php require ('header.inc.php') ?>
<p><br><br><a href="uyelerlist.php">Listeye Dön</a></p>
<script language="JavaScript" src="js/ew.js"></script>
<script language="JavaScript">
<!-- start Javascript
function  EW_checkMyForm(EW_this) {
if (EW_this.x_uye_id && !EW_hasValue(EW_this.x_uye_id, "TEXT" )) {
            if (!EW_onError(EW_this, EW_this.x_uye_id, "TEXT", "Hatali- uye id"))
                return false; 
        }
if (EW_this.x_uye_ad && !EW_hasValue(EW_this.x_uye_ad, "TEXT" )) {
            if (!EW_onError(EW_this, EW_this.x_uye_ad, "TEXT", "Ad Girmediniz !"))
                return false; 
        }
if (EW_this.x_uye_soyad && !EW_hasValue(EW_this.x_uye_soyad, "TEXT" )) {
            if (!EW_onError(EW_this, EW_this.x_uye_soyad, "TEXT", "Soyadınız ?"))
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
<form onSubmit="return EW_checkMyForm(this);"  action="uyeleradd.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="EW_MaxFileSize" value="2000000">
<p>
<input type="hidden" name="a" value="A">
<table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Id&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="hidden" name="x_id" value="<?php echo htmlspecialchars(@$x_id); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Üye Numarası&nbsp;</td>
<td bgcolor="#F5F5F5">
<input type="text" name="x_uye_id" size="30" value="<?php echo htmlspecialchars(@$x_uye_id); ?>">
&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Ad&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_uye_ad" size="30" maxlength="99" value="<?php echo htmlspecialchars(@$x_uye_ad); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Soyad&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_uye_soyad" size="30" maxlength="99" value="<?php echo htmlspecialchars(@$x_uye_soyad); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">E-posta 1&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_eposta1" size="30" maxlength="255" value="<?php echo htmlspecialchars(@$x_eposta1); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">E-posta 2&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_eposta2" size="30" maxlength="255" value="<?php echo htmlspecialchars(@$x_eposta2); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Kayıt Tarihi&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_kayit_tarihi" size="30" maxlength="255" value="<?php echo htmlspecialchars(@$x_kayit_tarihi); ?>">&nbsp;</td>
</tr>

<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Alias&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_alias" size="30" maxlength="100" value="@linux.org.tr"&nbsp;</td>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">LKD Üye Listesi&nbsp;</td>
 <td bgcolor="#F5F5F5">
 <input type="radio" name="x_liste_uyeligi" value=1>Üye Ol&nbsp;
 <input type="radio" name="x_liste_uyeligi" checked value=0>Üye Olma&nbsp;
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Gönüllü Çalışmalar&nbsp;</td>
 <td bgcolor="#F5F5F5">
 <input type="radio" name="x_gonullu" checked value=1>Katıl&nbsp;
 <input type="radio" name="x_gonullu" value=0>Katılma&nbsp;
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Elektronik Oylamalar&nbsp;</td>
 <td bgcolor="#F5F5F5">
 <input type="radio" name="x_oylama" checked value=1>Katıl&nbsp;
 <input type="radio" name="x_oylama" value=0>Katılma&nbsp;
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Trac Listesi&nbsp;</td>
 <td bgcolor="#F5F5F5">
 <input type="radio" name="x_trac_listesi" value=1>Katıl&nbsp;
 <input type="radio" name="x_trac_listesi" checked value=0>Katılma&nbsp;
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Haber Alınamıyor&nbsp;</td>
 <td bgcolor="#F5F5F5">
 <input type="radio" name="x_haber_alinamiyor" value=1>Evet&nbsp;
 <input type="radio" name="x_haber_alinamiyor" checked value=0>Hayır&nbsp;
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Kimliği Gizli&nbsp;</td>
 <td bgcolor="#F5F5F5">
 <input type="radio" name="x_kimlik_gizli" value=1>Evet&nbsp;
 <input type="radio" name="x_kimlik_gizli" checked value=0>Hayır&nbsp;
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Kimlik Durumu&nbsp;</td>
 <td bgcolor="#F5F5F5">
 <input type="radio" name="x_kimlik_durumu" checked value="Var/İstemiyor">Var/İstemiyor&nbsp;
 <input type="radio" name="x_kimlik_durumu" value="İstiyor">İstiyor&nbsp;
 <input type="radio" name="x_kimlik_durumu" value="Dijital Fotoğraf Bekleniyor">Dijital Fotoğraf Bekleniyor&nbsp;
 <input type="radio" name="x_kimlik_durumu" value="Basılacak">Basılacak&nbsp;
 <input type="radio" name="x_kimlik_durumu" value="Basıldı">Basıldı&nbsp;
 <input type="radio" name="x_kimlik_durumu" value="Güncel Adres Bekleniyor">Güncel Adres Bekleniyor&nbsp;
 <input type="radio" name="x_kimlik_durumu" value="Postaya Verilecek">Postaya Verilecek&nbsp;
</tr>


<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Cinsiyet&nbsp;</td>
<td bgcolor="#F5F5F5"><?php if (empty($x_cinsiyet)) { $x_cinsiyet = "e"; } // varsayilan degeri belirle... ?><input type="radio" name="x_cinsiyet"<?php if ($x_cinsiyet == "e") { echo " checked"; } ?> value="<?php echo htmlspecialchars("e"); ?>">Erkek
<input type="radio" name="x_cinsiyet"<?php if ($x_cinsiyet == "m") { echo " checked"; } ?> value="<?php echo htmlspecialchars("m"); ?>">Kadın
&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Kurum&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_kurum" size="30" maxlength="255" value="<?php echo htmlspecialchars(@$x_kurum); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Görev&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_gorev" size="30" maxlength="255" value="<?php echo htmlspecialchars(@$x_gorev); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Mezuniyet&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_mezuniyet" size="30" maxlength="100" value="<?php echo htmlspecialchars(@$x_mezuniyet); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Mezuniyet yılı&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_mezuniyet_yil" size="30" maxlength="4" value="<?php echo htmlspecialchars(@$x_mezuniyet_yil); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Mezun olunan bölüm&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_mezuniyet_bolum" size="30" maxlength="100" value="<?php echo htmlspecialchars(@$x_mezuniyet_bolum); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">İletişim Adresi&nbsp;</td>
<td bgcolor="#F5F5F5"><textarea name="x_is_addr" cols="35" rows="4"><?php echo @$x_is_addr ?></textarea>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Semt&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_semt" size="30" maxlength="100" value="<?php echo htmlspecialchars(@$x_semt); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Şehir&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_sehir" size="30" maxlength="100" value="<?php echo htmlspecialchars(@$x_sehir); ?>">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Posta kodu&nbsp;</td>
<td bgcolor="#F5F5F5"><input type="text" name="x_pkod" size="30" maxlength="5" value="<?php echo htmlspecialchars(@$x_pkod); ?>">&nbsp;</td>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Telefon 1&nbsp;</td>
 <td bgcolor="#F5F5F5"><input type="text" name="x_Telefon1" value="<?php echo @$x_Telefon1 ?>" size=30 maxlength=100>&nbsp;</td>
</tr>


<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Telefon 2&nbsp;</td>
 <td bgcolor="#F5F5F5"><input type="text" name="x_Telefon2" value="<?php echo @$x_Telefon2 ?>" size=30 maxlength=100>&nbsp;</td>
</tr>


<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">TC Kimlik No&nbsp;</td>
 <td bgcolor="#F5F5F5"><input type="text" name="x_TCKimlikNo" value="<?php echo @$x_TCKimlikNo ?>" size=30 maxlength=100>&nbsp;</td>
</tr>


<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Üye Karar No&nbsp;</td>
 <td bgcolor="#F5F5F5"><input type="text" name="x_Uye_karar_no" value="<?php echo @$x_Uye_karar_no ?>" size=30 maxlength=100>&nbsp;</td>
</tr>


<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Üye Karar Tarihi&nbsp;</td>
 <td bgcolor="#F5F5F5"><input type="text" name="x_Uye_karar_tarih" value="<?php echo @$x_Uye_karar_tarih ?>" size=30 maxlength=100>&nbsp;<small>(Yıl-Ay-Gün)</small></td>
</tr>


<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Resmi Evraklar için Fotoğraf&nbsp;</td>
 <td bgcolor="#F5F5F5">
 <input type="radio" name="x_vesikalik_foto" value=1>Var&nbsp;
 <input type="radio" name="x_vesikalik_foto" checked value=0>Yok&nbsp;
</tr>


<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Üye Formu&nbsp;</td>
 <td bgcolor="#F5F5F5"><?php $x_Uye_formu = ""; // temizlik ?>
 <input type="file" name="x_Uye_formu">&nbsp;</td>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Notlar&nbsp;</td>
 <td bgcolor="#F5F5F5"><textarea name="x_Notlar" cols="35" rows="4"><?php echo @$x_Notlar ?></textarea>&nbsp;</td> 
</tr>

<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Resim&nbsp;</td>
<td bgcolor="#F5F5F5"><?php $x_Resim = ""; // temizlik ?>
<input type="file" name="x_Resim">&nbsp;</td>
</tr>
</table>
<p align=right>
<input type="submit" name="Action" value="EKLE">
</form>
<?php require ('footer.inc.php') ?>
