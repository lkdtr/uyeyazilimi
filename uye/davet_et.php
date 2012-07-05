<?php
 $slug = $_SERVER['PHP_AUTH_USER'];    // kullanici adi
 
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
 
 $davet_edilen = mysql_real_escape_string(@strip_tags($_POST['adi']));
 $davet_eposta = mysql_real_escape_string(@strip_tags($_POST['eposta']));

 $headers = 'From: ' .$uye_eposta. '\r\n';
 $headers .= 'Content-type: text/html; charset=utf-8 \r\n'; 
 
 $message = 'Merhaba '.$davet_edilen.'<br>';
 $message .= 'Bence, benim de üye olduğum Linux Kullanıcıları Derneği\'ne ';
 $message .= 'sen de üye olmalısın. <br>Dernek Türkiye’de Linux ve özgür ';
 $message .= 'yazılıma gönül vermiş kişilerin oluşturduğu, bilgi ve deneyim ';
 $message .= 'paylaşımı  ile ortak hareket etmeyi amaçlayan bir sivil toplum ';
 $message .= 'örgütüdür ve bizler açık kaynak kodu ve özgür yazılım felsefesini ';
 $message .= 'kucaklıyor ve bu felsefeye uyan tüm ürün, teknoloji, oluşum ';
 $message .= 've platformlara destek olmayı hedefliyoruz. Ağırlıklı olarak ';
 $message .= 'GNU/Linux etrafında örgütlensek de, diğer özgür yazılım ürünü ';
 $message .= 'işletim sistemleri ile tüm özgür yazılımları ve özgür yazılım ';
 $message .= 'lisanslarının kullanımını destekliyoruz. <br>Umarım beni kırmaz ';
 $message .= 've sen de derneğin bir üyesi olursun. Üye olmak istersen ';
 $message .= 'http://www.lkd.org.tr/uyelik/nasil-uye-olabilirim/ adresinden ';
 $message .= 'gerekli bilgilere ulaşabilirsin.<br>Görüşmek üzere...<br><br>';
 $message .= $uye_adi .'<br>'. $uye_eposta;

 mail($davet_eposta, $uye_adi .' Sizi LKD\'ye Davet Ediyor!',
 $message, $headers);
?>
