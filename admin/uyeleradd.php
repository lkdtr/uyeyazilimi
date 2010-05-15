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
			$row = mysql_fetch_assoc($rs);

		// degerleri ayir...
            foreach ($row as $keys => $values) {
                eval('$x_' . $keys . ' = @$row["' . $keys . '"];');
            }

		}
		mysql_free_result($rs);
		break;
	case "A": // ekleme

		// form degerleri temizlik basliyorrr.
        foreach ($_POST as $keys => $values) {
            eval('$' . $keys .'= @strip_tags($_POST["' . $keys . '"]);');
        }

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

	mysql_free_result($presult);
	mysql_select_db(DB, $conn);



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

                eposta_yonlendirmesi_ac($x_alias, $x_eposta1);

                $lkd_login = eposta2login($x_alias);
                parola_veritabanina_ekle($x_uye_id, $lkd_login, $x_uye_ad, $x_uye_soyad, $x_alias, 0);

                trac_veritabanina_ekle($lkd_login, $x_uye_ad, $x_uye_soyad, $x_alias);

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


<?php

function tryap($label, $maxlength, $key, $var) {

    echo '
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">' . $label . '</font></td>
<td bgcolor="#F5F5F5"><input type="text" name="' . $key . '" size="30" maxlength="' . $maxlength . '" value="' . htmlspecialchars(@$var) . '"></td></tr>
';

}

function radyoyap($label, $name, $selected, $parameters) {

    echo '
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">' . $label . '</font></td>
<td bgcolor="#F5F5F5">';

$arraycount=0;
foreach ($parameters as $parameter => $value) {
    echo '
 <input type="radio" name="' . $name . '" '; if($arraycount == $selected) {echo 'checked ';}; echo 'value=' . $value . '>' . $parameter;
$arraycount++;
}
echo '
</td></tr>
';

}

?>

<form onSubmit="return EW_checkMyForm(this);"  action="uyeleradd.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="EW_MaxFileSize" value="2000000">
<p>
<input type="hidden" name="a" value="A">

<table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">

<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Id</td>
<td bgcolor="#F5F5F5"><input type="hidden" name="x_id" value="<?php echo htmlspecialchars(@$x_id); ?>"></td>
</tr>

<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Üye Numarası</td>
<td bgcolor="#F5F5F5">
<input type="text" name="x_uye_id" size="30" value="<?php echo htmlspecialchars(@$x_uye_id); ?>"></td>
</tr>

<?php
tryap("Ad", 99, "x_uye_ad", "$x_uye_ad");
tryap("Soyad", 99, "x_uye_soyad", "$x_uye_soyad");
tryap("E-posta 1", 255, "x_eposta1", "$x_eposta1");
tryap("E-posta 2", 255, "x_eposta2", "$x_eposta2");
tryap("Kayıt Tarihi", 255, "x_kayit_tarihi", "$x_kayit_tarihi");
tryap("Alias", 100, "x_alias", "@linux.org.tr");

radyoyap("LKD Üye Listesi", "x_liste_uyeligi", 1, array("Üye Ol" => 1, "Üye Olma" => 0));

radyoyap("Gönüllü Çalışmalar", "x_gonullu", 0, array("Katıl" => 1, "Katılma" => 0));
radyoyap("Elektronik Oylamalar", "x_oylama", 0, array("Katıl" => 1, "Katılma" => 0));
radyoyap("Trac Listesi", "x_trac_listesi", 1, array("Katıl" => 1, "Katılma" => 0));
radyoyap("Haber Alınamıyor", "x_haber_alinamiyor", 1, array("Evet" => 1, "Hayır" => 0));
radyoyap("Kimliği Gizli", "x_kimlik_gizli", 1, array("Evet" => 1, "Hayır" => 0));
radyoyap("Kimlik Durumu", "x_kimlik_durumu", 0, array("Var/İstemiyor" => "Var/İstemiyor",
                                                      "İstiyor" => "İstiyor",
                                                      "Dijital Fotoğraf Bekleniyor" => "Dijital Fotoğraf Bekleniyor",
                                                      "Basılacak" => "Basılacak",
                                                      "Basıldı" => "Basıldı",
                                                      "Güncel Adres Bekleniyor" => "Güncel Adres Bekleniyor",
                                                      "Postaya Verilecek" => "Postaya Verilecek"));?>


<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Cinsiyet</td>
<td bgcolor="#F5F5F5"><?php if (empty($x_cinsiyet)) { $x_cinsiyet = "e"; } // varsayilan degeri belirle... ?><input type="radio" name="x_cinsiyet"<?php if ($x_cinsiyet == "e") { echo " checked"; } ?> value="<?php echo htmlspecialchars("e"); ?>">Erkek
<input type="radio" name="x_cinsiyet"<?php if ($x_cinsiyet == "m") { echo " checked"; } ?> value="<?php echo htmlspecialchars("m"); ?>">Kadın
</td>
</tr>

<?php
tryap("Kurum", 255, "x_kurum", "$x_kurum");
tryap("Görev", 255, "x_gorev", "$x_gorev");
tryap("Mezuniyet", 100, "x_mezuniyet", "$x_mezuniyet");
tryap("Mezuniyet yılı", 4, "x_mezuniyet_yil", "$x_mezuniyet_yil");
tryap("Mezun olunan bölüm", 100, "x_mezuniyet_bolum", "$x_mezuniyet_bolum");?>

<td bgcolor="#466176"><font color="#FFFFFF">İletişim Adresi&nbsp;</td>
<td bgcolor="#F5F5F5">
<textarea name="x_is_addr" cols="35" rows="4"><?php echo @$x_is_addr ?></textarea></td>
</tr>

<?php
tryap("Semt", 100, "x_semt", "$x_semt");
tryap("Şehir", 100, "x_sehir", "$x_sehir");
tryap("Posta kodu", 5, "x_pkod", "$x_pkod");
tryap("Telefon 1", 100, "x_Telefon1", "$x_Telefon1");
tryap("Telefon 2", 100, "x_Telefon2", "$x_Telefon2");
tryap("TC Kimlik No", 11, "x_TCKimlikNo", "$x_TCKimlikNo");
tryap("Üye Karar No", 100, "x_Uye_karar_no", "$x_Uye_karar_no");?>

<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Üye Karar Tarihi&nbsp;</td>
<td bgcolor="#F5F5F5">
<input type="text" name="x_Uye_karar_tarih" value="<?php echo @$x_Uye_karar_tarih ?>" size=30 maxlength=100><small>(Yıl-Ay-Gün)</small></td>
</tr>

<?radyoyap("Resmi Evraklar için Fotoğraf", "x_vesikalik_foto", 1, array("Var" => 1, "Yok" => 0));?>

<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Üye Formu&nbsp;</td>
<td bgcolor="#F5F5F5">
<?$x_Uye_formu = ""; // temizlik ?>
 <input type="file" name="x_Uye_formu"></td>
</tr>

<tr>
 <td bgcolor="#466176"><font color="#FFFFFF">Notlar</td>
 <td bgcolor="#F5F5F5"><textarea name="x_Notlar" cols="35" rows="4"><?php echo @$x_Notlar ?></textarea></td> 
</tr>

<tr>
<td bgcolor="#466176"><font color="#FFFFFF">Resim&nbsp;</td>
<td bgcolor="#F5F5F5">
<?php $x_Resim = ""; // temizlik ?>
<input type="file" name="x_Resim"></td>
</tr>
</table>
<p align=right>
<input type="submit" name="Action" value="EKLE">
</form>
<?php require ('footer.inc.php') ?>
