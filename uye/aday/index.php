<?php


include('yama.inc.php');
$member = getMember($_SERVER['PHP_AUTH_USER']);

// params
$LKDNo     = $member['uye_no'];
$LKDAdi    = $member['name'];
$LKDEposta = $_SERVER['PHP_AUTH_USER']."@linux.org.tr";

// baslatiyoruz
include('baslatici.php');


// islem
if( $_POST[action] ){
	unset($error, $aday);

	// bilgiler
	$aday = XSS($_POST[aday]);

	// kontrol
	utility('checkEmail');
	if( !$aday[ekleyen_uye] )                    $error[diger]          = 'Sistem Hatası (LKD Üye)';

	$aday[ekleyen_uye_adi] = $member['name'];
	$aday[ekleyen_uye_eposta] = $_SERVER['PHP_AUTH_USER']."@linux.org.tr";

/*
	if( empty($aday[ekleyen_uye_adi]) )          $error[ekleyen_uye_adi]    = 'Adınız boş olamaz';
	if( empty($aday[ekleyen_uye_eposta]) )       $error[ekleyen_uye_eposta] = 'E-posta adresiniz boş olamaz';
	if( !checkEmail($aday[ekleyen_uye_eposta]) ) $error[ekleyen_uye_eposta] = 'E-posta adresinizi doğru giriniz';
*/

	if( empty($aday[adi]) )                      $error[adi]            = 'Adayın adı boş olamaz';
	if( empty($aday[eposta]) )                   $error[eposta]         = 'Adayın e-posta adresi boş olamaz';
	if( !checkEmail($aday[eposta]) )             $error[eposta]         = 'Adayın e-posta adresinizi doğru giriniz';
	if( empty($aday[kategori]) )                 $error[kategori]       = 'Kategori seçmediniz';
	if( empty($aday[aciklama]) )                 $error[aciklama]       = 'Tanım boş olamaz';

	if( !$error ){
		// ek alanlari diziye ekleyelim
		$aday[yarisma]        = $YarismaNo;
		$aday[eklenme_tarihi] = date('Y-m-d H:i:s');
		$aday[ekleyen_ip]     = $_SERVER[REMOTE_ADDR];

		// veritabanina ekleyelim
		if( $db->insert('adaylar', $aday) ){
			new redirect(array(
				'message'     => 'Aday başarıyla eklendi!<br><small>En kısa sürede onaylanıp siteye eklenecektir</small>',
				'url'         => '/aday/',
				'auto'        => 3000,
				'buttonLabel' => 'Devam'
			));
		}else{
			new error('Aday bilgileri kaydedilemedi!');
		}
	}
}else{
	$aday[ekleyen_uye_adi]    = $LKDAdi;
	$aday[ekleyen_uye_eposta] = $LKDEposta;
}

// kategorileri alalim
$sonuc = $db->all(array('table'=>'kategoriler', 'where'=>array('yarisma'=>$YarismaNo)));
foreach ($sonuc as $val) $kategoriler[ $val[no] ] = $val[adi];


// form
$form = new form('./');
$form->html('<br><h4>Önce Okuyun</h4><br>Yılın penguenleri yarışmasına aday gösterirken dikkat etmeniz gereken basit öz birkaç kuralımız var. Sizden istediğimiz bilgiler 2 bölümden oluşuyor. Birincisi aday gösteren kişiyi bilmemiz için sizin bilgilerinizi kaydedeceğiz. İkinci kısım aday ile ilgili bilgiler. Burada belirteceğiniz bilgilerde tarafsız ve çok abartıya kaçmadan aday gösterdiğiniz kişi hakkında bilgi vermeye çalışın.<br><br>Adaylar moderatörlerimizin onayından sonra siteye eklenecektir. Vereceğiniz bilgilerin doğruluğuna dikkat etmelisiniz.<br><br>', array('liAttr'=>'class="aciklama"'));

$form->html('<br><h4>Öneren Kişi Bilgileri (Siz)</h4>');
$form->hidden('aday[ekleyen_uye]', $LKDNo);
// $form->text('Adınız', 'aday[ekleyen_uye_adi]', array('required'=>true, 'default'=>$aday[ekleyen_uye_adi], 'error'=>$error[ekleyen_uye_adi]));
// $form->text('E-Posta Adresiniz', 'aday[ekleyen_uye_eposta]', array('required'=>true, 'default'=>$aday[ekleyen_uye_eposta], 'error'=>$error[ekleyen_uye_eposta]));

$form->html('<br><h4>Aday Bilgileri</h4>');
$form->text('Adayın Adı', 'aday[adi]', array('required'=>true, 'default'=>$aday[adi], 'error'=>$error[adi]));
$form->text('E-posta Adresi', 'aday[eposta]', array('required'=>true, 'default'=>$aday[eposta], 'error'=>$error[eposta]));
$form->radio('Kategori', $kategoriler, 'aday[kategori]', array('required'=>true, 'default'=>$aday[kategori], 'liAttr'=>'class="kategoriler"', 'error'=>$error[kategori]));
$form->textarea('Tanım', 'aday[aciklama]', array('required'=>true, 'default'=>$aday[aciklama], 'error'=>$error[aciklama]));

$form->submit('Kaydet', 'action');


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Aday Gösterim</title>
	<link rel="stylesheet" type="text/css" media="screen" href="stil.css">
	<link rel="stylesheet" type="text/css" media="screen" href="form.css">
</head>
<body>
	<div id="arayuz">
		<h2>Yılın Penguenleri Aday Gösterimi</h2>
		<br>

		<?
			$form->render();
		?>

	</div>
</body>
</html>
