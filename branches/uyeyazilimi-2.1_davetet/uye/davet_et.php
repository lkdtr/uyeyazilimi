<?php
 $slug = $_SERVER['PHP_AUTH_USER'];    // kullanici adi

 // e-posta gondermek icin sinifi cagir
 require 'class.simple_mail.php';
 $mailer = new Simple_Mail(TRUE);
 
 // veritabani baglantisi
 require('uye_bilgi_config.inc.php');
 $conn = mysql_connect(HOST, USER, PASS);
 mysql_select_db(DB) or die(mysql_error());
 mysql_query("SET NAMES 'utf8'");

 // uyenin kisisel bilgilerini alalim
 $query = 'SELECT * FROM uyeler WHERE alias = "' . $slug . '@linux.org.tr"';
 $result = mysql_query($query);
 $user_info = mysql_fetch_array($result);

 $uye_adi = $user_info['uye_ad'] . ' ' . $user_info['uye_soyad'];
 $uye_eposta = $slug . '@linux.org.tr';
 $uye_kayit_tarih = new DateTime($user_info['kayit_acilis_tarih']);
 $uye_telefon = $user_info['telefon1'];
 
 $davet_edilen = mysql_real_escape_string(@strip_tags($_POST['adi']));
 $davet_eposta = mysql_real_escape_string(@strip_tags($_POST['eposta']));

 $message = 'Merhaba <b>'.ucwords($davet_edilen).'</b>,<br><br>';
 $message .= 'Sana, '.$uye_kayit_tarih->format("d/m/Y").' tarihinden beri üye olduğum ';
 $message .= 'Linux Kullanıcıları Derneği\'nden sesleniyorum ve senin de ';
 $message .= 'Türkiye’de Linux ve özgür yazılıma gönül vermiş kişilerin ';
 $message .= 'oluşturduğu, bilgi ve deneyim paylaşımı  ile ortak hareket ';
 $message .= 'etmeyi amaçlayan bir sivil toplum örgütü olan bu derneğe üye olman ';
 $message .= 'gerektiğini düşünüyorum.<br><br>';
 $message .= 'Üye olmak istersen http://www.lkd.org.tr/uyelik/nasil-uye-olabilirim/ ';
 $message .= 'adresinden gerekli bilgi ve belgelere ulaşabilir ya da beni ';
 $message .= $uye_telefon.' numaralı telefondan arayabilirsin. Görüşmek üzere... <br><br>';
 $message .= $uye_adi .'<br>'. $uye_eposta;

 $send = $mailer->setTo($davet_eposta, $davet_edilen)
		  ->setSubject('Bence Sen De LKD Uyesi Olmalisin!')
		  ->setFrom($uye_eposta, $uye_adi)
		  ->addMailHeader('Reply-To', 'no-reply@domain.com', 'Domain.com')
		  ->addGenericHeader('X-Mailer', 'PHP/' . phpversion())
		  ->addGenericHeader('Content-Type', 'text/html; charset="utf-8"')
		  ->setMessage($message)
		  ->setWrap(100)
		  ->send();
				 
 if ($send) {
  echo '<h1>Teşekkürler</h1>';
  echo 'Davetiyeniz, arkadaşınız olduğunu düşündüğümüz,';
  echo '<b>'.$davet_edilen.'</b> kişisine ulaştırılmak üzere ';
  echo '<b>'.$davet_eposta.'</b> adresine gönderildi.<br>';
  echo 'Umarız, sayenizde bir kişi daha fazla oluruz.';
 }
 else {
  echo '<h1>Bir Hata Oluştu! Lütfen yöneticileri bilgilendirin</h1>';
 }

?>
