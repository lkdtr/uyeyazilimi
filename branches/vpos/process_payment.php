<?php
$hata_msg['02'] = "Kartla ilgili problem";
$hata_msg['69'] = "Eksik Parametre";                         
$hata_msg['68'] = "Hatalı İşlem Tipi";                       
$hata_msg['67'] = "Parametre uzunluklarında uyuşmazlık";
$hata_msg['66'] = "Numeric deger hatası";
$hata_msg['65'] = "Hatalı tutar / amount";
$hata_msg['64'] = "İşlem tipi taksit e uygun değil";
$hata_msg['63'] = "Request mesajinda illegal karakter var."; 
$hata_msg['62'] = "Yetkisiz ya da tanımsız kullanıcı";
$hata_msg['61'] = "Hatalı Tarih";
$hata_msg['60'] = "Hareket Bulunamadi";
$hata_msg['59'] = "Gunsonu yapilacak hareket yok";
$hata_msg['90'] = "Kayıt bulunamadı";
$hata_msg['91'] = "Begin Transaction error";
$hata_msg['92'] = "Insert Update Error";
$hata_msg['96'] = "DLL registration error";
$hata_msg['97'] = "IP Hatası";
$hata_msg['98'] = "H. Iletisim hatası";
$hata_msg['99'] = "DB Baglantı hatası";
$hata_msg['70'] = "XCIP hatalı";
$hata_msg['71'] = "Üye İşyeri blokeli ya da tanımsız";
$hata_msg['72'] = "Tanımsız POS";
$hata_msg['73'] = "POS table update error";
$hata_msg['76'] = "Taksit e kapalı";
$hata_msg['74'] = "Hatalı taksit sayısı";
$hata_msg['75'] = "Illegal State";
$hata_msg['85'] = "Kayit Reversal Durumda";
$hata_msg['86'] = "Kayit Degistirilemez";
$hata_msg['87'] = "Kayit Iade Durumda";
$hata_msg['88'] = "Kayit Iptal Durumda";
$hata_msg['89'] = "Geçersiz kayıt";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>LKD Bağış Sistemi</title>
</head>
<body>
<div id="container">
	<div id="top_content">
    	<p class="top">Bağlantı Adresiniz, <strong><?php echo $_SERVER['REMOTE_ADDR']?></strong></p>
    </div>
    <div id="info-logo">
    	<div id="logo-part">
    		<img src="images/resmilogo.png" align="left" />
        </div>
        <div id="info-part">
            <img src="images/part.png" align="left" />
            <p>
            <span class="subject">Derneğe banka yoluyla da bağış / aidat ödemesi yapabilirsiniz</span><br /><br />
            <span class="subject">Banka :</span> Garanti Bankası<br>
            <span class="subject">Şube :</span> Kızılay (Şube No: 082)<br>
            <span class="subject">Hesap Numarası :</span> 6298573<br>
            <span class="subject">IBAN :</span> TR51 0006 2000 0820 0006 2985 73<br>
            </p>
        </div>
    </div>
    <div id="content">

<?php
include('config.inc.php');
function check_email_address($email) {
  // First, we check that there's one @ symbol, 
  // and that the lengths are right.
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    // Email invalid because wrong number of characters 
    // in one section or wrong number of @ symbols.
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
    if
(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
↪'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
$local_array[$i])) {
      return false;
    }
  }
  // Check if domain is IP. If not, 
  // it should be valid domain name
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if
(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
↪([A-Za-z0-9]+))$",
$domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
}


// adres ya da telefon alani duruma gore zorunlu
// aciklama alani zorunlu degil
$fieldRequirements = array (	
	'nameText'=>true,
	'surnameText'=>true,
	'addressTextArea'=>false,
	'telephoneText'=>false,
	'descriptionTextArea'=>false,
	'paymentTypeRadio'=>true,
	'emailText'=>true,
	'cardNoText'=>true,
	'validityDateMonth'=>true,
	'validityDateYear'=>true,
	'cvcText'=>true,
	'tutarYTLText'=>true);
$fieldNames = array (
	'nameText'=>'Adı',
	'surnameText'=>'Soyadı',
	'addressTextArea'=>'Adres',
	'telephoneText'=>'Telefon',
	'descriptionTextArea'=>'Açıklama',
	'paymentTypeRadio'=>'Ödeme Türü',
	'emailText'=>'e-mail',
	'cardNoText'=>'Kart No',
	'validityDateMonth'=>'Geçerlilik Tarihi',
	'validityDateYear'=>'Geçerlilik Tarihi',
	'cvcText'=>'CVC',
	'tutarYTLText'=>'Tutar'
);

foreach ($_POST as $key =>$postVariable) {
    if (empty ($postVariable) && $fieldRequirements[$key]) {
        echo '<center>Zorunlu bir alanı doldurmadınız<br/>';
		  echo $fieldNames[$key].' Alanını doldurmadınız!<br/>';
        echo '<input type="button" value="Geri" onclick="javascript:history.go(-1)">';
        echo '</center></body></html>';
        exit;
    }
}
if (!check_email_address($_POST['emailText'])) {
        echo '<center>Geçersiz e-posta Adresi<br/>';
		  
        echo '<input type="button" value="Geri" onclick="javascript:history.go(-1)">';
        echo '</center></body></html>';
        exit;
}

function sanitize_sql_string($string, $min='', $max='')
{
      $pattern[0] = '/(\\\\)/';
      $pattern[1] = "/\"/";
      $pattern[2] = "/'/";
      $replacement[0] = '\\\\\\';
      $replacement[1] = '\"';
      $replacement[2] = "\\'";
      $len = strlen($string);
      if((($min != '') && ($len < $min)) || (($max != '') && ($len > $max)))
        return FALSE;
      return preg_replace($pattern, $replacement, $string);
}
function obfuscate_card_no($cardNo) {
    $cardStr = substr($cardNo, 0,5);
    $cardStr = str_pad($cardStr, strlen($cardNo)-4, '*');
    $cardStr .= substr($cardNo, strlen($cardNo)-4);
    return $cardStr;
}

?>
<?php if ($_POST["payment_accepted"]!= "true") {
echo <<<payment_info
    <div align="center">
    <form method="POST" action="process_payment.php">
    <input type="hidden" name="payment_accepted" value="true">
    <input type="hidden" name="nameText" value="{$_POST['nameText']}">
    <input type="hidden" name="surnameText" value="{$_POST['surnameText']}">
    <input type="hidden" name="addressTextArea" value="{$_POST['addressTextArea']}">
    <input type="hidden" name="telephoneText" value="{$_POST['telephoneText']}">
    <input type="hidden" name="descriptionTextArea" value="{$_POST['descriptionTextArea']}">
    <input type="hidden" name="emailText" value="{$_POST['emailText']}">
    <input type="hidden" name="cardNoText" value="{$_POST['cardNoText']}">
    <input type="hidden" name="validityDateMonth" value="{$_POST['validityDateMonth']}">
    <input type="hidden" name="validityDateYear" value="{$_POST['validityDateYear']}">
    <input type="hidden" name="cvcText" value="{$_POST['cvcText']}">
    <input type="hidden" name="tutarYTLText" value="{$_POST['tutarYTLText']}">
    <input type="hidden" name="tutarYKRText" value="{$_POST['tutarYKRText']}">
    <table>
            <tr><td>İsim</td><td>{$_POST['nameText']}</td></tr>
            <tr><td>Soyisim</td><td>{$_POST['surnameText']}</td></tr>

            <tr><td>Adres</td><td>{$_POST['addressTextArea']}</td></tr>
            <tr><td>Telefon</td><td>{$_POST['telephoneText']}</td></tr>
            <tr><td>E-Posta</td><td>{$_POST['emailText']}</td></tr>
            <tr><td>Kart No</td><td>{$_POST['cardNoText']}</td></tr>

            <tr><td>Son Kullanma Tarihi</td><td>{$_POST['validityDateMonth']} / {$_POST['validityDateYear']}</td></tr>

            <tr><td>CVC</td><td>{$_POST['cvcText']}</td></tr>
            <tr><td>Tutar</td><td>{$_POST['tutarYTLText']} YTL {$_POST['tutarYKRText']} Kuruş<br />&nbsp;</td></tr>
            <tr><td colspan="2">Yukarıdaki bilgilerin doğruluğunu onaylıyor musunuz?<br />&nbsp;</td></tr>
            <tr><td style="text-align:center"><input type="submit" value="Ödeme İşlemini Tamamla"></td></tr>


    </table>
    </form>
    </div>
payment_info;
}else {
    $success = true;
    $paymentId = uniqid(rand(), false);
    $nameText = sanitize_sql_string($_POST['nameText']);
    $surnameText = sanitize_sql_string($_POST['surnameText']);
    $addressTextArea = sanitize_sql_string($_POST['addressTextArea']);
    $telephoneText = sanitize_sql_string($_POST['telephoneText']);
    $descriptionTextArea = sanitize_sql_string($_POST['descriptionTextArea']);
    $emailText = sanitize_sql_string($_POST['emailText']);
    $cardNoText = sanitize_sql_string($_POST['cardNoText']);
    $validityDateMonth = sanitize_sql_string($_POST['validityDateMonth']);
    $validityDateYear = sanitize_sql_string($_POST['validityDateYear']);
    $cvcText = sanitize_sql_string($_POST['cvcText']);
    $tutarYTLText = sanitize_sql_string($_POST['tutarYTLText']);
    $tutarYKRText = sanitize_sql_string($_POST['tutarYKRText']);
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $dbCardNo = obfuscate_card_no($cardNoText);
    $paymentDate = date('c');

	$validityDate = substr($validityDateYear,2,2).str_pad($validityDateMonth,2,'0',STR_PAD_LEFT);
	
	$tutar=str_pad($tutarYTLText,10,'0',STR_PAD_LEFT).str_pad($tutarYKRText,2,'0',STR_PAD_LEFT);
    //odeme burda basliyor

	$userIP = $_SERVER['REMOTE_ADDR'];
	$getString = '/vpos724v3/?kullanici=' . BANKA_KULLANICI . '&sifre=' . BANKA_SIFRE . '&islem=PRO&uyeno=' . BANKA_UYENO . '&posno=' . BANKA_POSNO . "&kkno={$cardNoText}&gectar={$validityDate}&cvc={$cvcText}&tutar={$tutar}&provno=000000&taksits=00&islemyeri=I&uyeref={$paymentId}&vbref=0&khip={$userIP}&xcip=" . BANKA_XCIP;
	
	//echo $getString;
	if($cardNoText != "") {
	//CURL olmadan nasi https requesti yapicaz.. kesin yemez bu.. 
	//ama yedi... 
	
	$fp = fsockopen ("ssl://subesiz.vakifbank.com.tr",443,$errno, $errstr,30);
	if (!$fp) {
		echo "$errstr ($errno)\n";
	} else {
		$out = "GET {$getString} HTTP/1.1\r\n";
		$out.= "Host: subesiz.vakifbank.com.tr\r\n";
		$out.= "Connection: Close\r\n\r\n";
		//echo $out;
		fwrite ($fp, $out);
		$xmlString = '';
		while (!feof($fp)) {
			$xmlString .=fgets($fp);
		}
		fclose  ($fp);
	}
	
	}
	
	//burayi en kisa zamanda degistir.. cok kazma bir yontem oldu
	$xmlString = preg_replace ('/HTTP.?1.*/','',$xmlString);
	$xmlString = preg_replace ('/Server:\s.*/','',$xmlString);
	$xmlString = preg_replace ('/Date:\s.*/','',$xmlString);
	$xmlString = preg_replace ('/Content-type:\s.*/','',$xmlString);
	$xmlString = preg_replace ('/Content-Type:\s.*/','',$xmlString);
	$xmlString = preg_replace ('/Content-length:\s.*/','',$xmlString);
	$xmlString = preg_replace ('/Connection:\s.*/','',$xmlString);
	$xmlString = preg_replace ('/\s\s+/','',$xmlString);
	//echo $xmlString;
	
	$xml = new SimpleXMLElement($xmlString);
	if ((string)$xml->Msg->Kod == '00') {
		//odeme burada kaydediliyor
	    //aman ha kredi karti numarasinin tamamini ve cvc numarasini db ye yazmayalim.
    $query = "insert into payments values ('{$paymentId}','{$nameText}', '{$surnameText}', '{$addressTextArea}', '{$emailText}','{$dbCardNo}','{$tutarYTLText}.{$tutarYKRText}','{$ipAddress}','{$paymentDate}', '{$descriptionTextArea}','{$telephoneText}')";
    $link = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD)
            or die('Bağlantı Hatası: ' . mysql_error());
    mysql_select_db(MYSQL_DATABASE) or die('Veritabanı Bulunamadı');

    // Performing SQL query
    mysql_query($query) or die('Veritabanına Yazılamadı!: ' . mysql_error());

    mysql_close($link);
    if ($success) {
        echo <<<success
            <center>Ödeme işleminiz başarı ile tamamlanmıştır.<br/> Teşekkür Ederiz</center>

success;


	$ykto = "yk@linux.org.tr, uye@lkd.org.tr";
	$yksubject = "Odeme";
	$ykbody = "Yeni Ödeme Yapıldı\r\n";
	$ykbody .= "Ad - Soyad: ".$nameText.' '.$surnameText."\r\n";
	$ykbody .= "Açıklama: ".$descriptionTextArea."\r\n";
	$ykbody .= "Ödeme Miktarı: ".$tutarYTLText.','.$tutarYKRText."\r\n";
	$ykheaders = "From: yk@linux.org.tr\r\n" .
    "X-Mailer: php". "\r\n";
	$ykheaders .= 'Content-type: text/plain; charset=UTF-8' . "\r\n";
	$to = $emailText;


	$subject = "LKD Ödeme Sistemi";
	$body = "Sayın ".$nameText." ".$surnameText.",\r\nYaptığınız ödeme için teşekkür ederiz!,\r\n Ödeme Bilgileri Aşağıdadır.\r\n Linux Kullanıcıları Derneği\r\n";
	$body .= "Ad - Soyad: ".$nameText.' '.$surnameText."\r\n";
	$body .= "Açıklama: ".$descriptionTextArea."\r\n";
	$body .= "Ödeme Miktarı: ".$tutarYTLText.','.$tutarYKRText."\r\n";
	$headers = "From: yk@linux.org.tr\r\n" .
    "X-Mailer: php" . "\r\n";
	$headers .= 'Content-type: text/plain; charset=UTF-8' . "\r\n";
	mail($ykto, $yksubject, $ykbody,$ykheaders);
	if (check_email_address($to)) {
		mail($to, $subject, $body,$headers);
	}

    }
	} else {
	$hataKodu= (string)$xml->Msg->Kod;
	//echo $hataKodu;
	        echo <<<success
			<div style="color:red">
            <center>Ödeme işlemi başarısız oldu!
			<br />
			Hata Kodu $hataKodu: $hata_msg[$hataKodu]
			
			</center>
			</div>
success;
	
	}

	

}?>
<br />
<br />
<br />




    </div>
</div>
</body>
</html>
