<?php

// aday bilgilerini alalim
$aday = $db->get(array('table'=>'adaylar', 'where'=>array('yarisma'=>$Y[no], 'no'=>$_GET[no])));

// var mi?
if( !$aday ) new error('Aday bulunamadı!');

// aktif mi?
if( !$aday[aktif] ) new error('Aday bulunamadı (B)!');

// sayfa adresi
$sayfaURL = '/yarisma-'. $Y[anahtar] .'/aday/'. $aday[no] .'/';


// kategori bilgileri
$kategori = $db->get(array('table'=>'kategoriler', 'where'=>array('no'=>$aday[kategori])));

// sayfa basligi
$GLOBALS[sayfaBasligi] = 'Aday Bilgileri';


// yorum islem
unset($yorum);
if( $_POST[action] ){
	utility('checkEmail');
	$yorum = XSS($_POST[yorum]);

	// kontroller
	if( empty($yorum[adi]) )          $error[adi]    = 'Adınız boş olamaz';
	if( empty($yorum[eposta]) )       $error[eposta] = 'E-posta adresiniz boş olamaz';
	if( !checkEmail($yorum[eposta]) ) $error[eposta] = 'E-posta adresinizi doğru formatta giriniz';
	if( empty($yorum[yorum]) )        $error[yorum]  = 'Yorum yazmadınız';

	// sorun yoksa
	if( !$error ){
		// ek alanlar
		$yorum[yarisma] = $Y[no];
		$yorum[aday]    = $aday[no];
		$yorum[tarih]   = date('Y-m-d H:i:s');
		$yorum[ip]      = $_SERVER[REMOTE_ADDR];
		$yorum[browser] = $_SERVER[HTTP_USER_AGENT];

		// veritabanına yazalım
		if( $db->insert('yorumlar', $yorum) ){
			new redirect('Yorum başarıyla eklendi<br><small><small>Yorumunuz incelendikten sonra eklenecektir.</small></small>', $sayfaURL, 3000, 'Devam');
		}else{
			new error('Yorumunuz kaydedilemedi!');
		}
	}
}


// yorumlar
$yorumlar = $db->all(array(
	'table' => 'yorumlar',
	'where' => array(
					'yarisma' => $Y[no],
					'aday'    => $aday[no],
					'aktif'   => 1
				),
	'order' => array('tarih'=>'desc')
));

// yorum formu
$form = new form(array(
	'action'        => $sayfaURL,
	'labelAligment' => 'top'
));
$form->text('Adınız', 'yorum[adi]', array('required'=>true, 'default'=>$yorum[adi], 'error'=>$error[adi]));
$form->text('E-Posta Adresiniz', 'yorum[eposta]', array('required'=>true, 'default'=>$yorum[eposta], 'desc'=>'Yayınlanmayacaktır', 'error'=>$error[eposta]));
$form->textarea('Yorum', 'yorum[yorum]', array('required'=>true, 'default'=>$yorum[yorum], 'error'=>$error[yorum]));

$form->submit('Gönder', 'action');


// ekrana basalim
print '
<link rel="stylesheet" type="text/css" media="screen" href="/css/aday.css">
<link rel="stylesheet" type="text/css" media="screen" href="/css/form.css">

<div id="aday">
	<h3>'. $aday[adi] .'</h3>
	<h4>'. $kategori[adi] .'</h4>

	<div class="aciklama">'. nl2br($aday[aciklama]) .'</div>
</div>

<div id="yorumlar">
	<h4>Yorumlar</h4>
	';

	if($yorumlar){
		foreach ($yorumlar as $yorum){
			print '
			<div class="yorum">
				<div class="info">
					<span class="isim">'. $yorum[adi] .'</span>
					<span class="tarih">'. $yorum[tarih] .'</span>
				</div>
				<div class="yazi">
					'. nl2br($yorum[yorum]) .'
				</div>
			</div>';
		}
	}else{
		print '<div class="yorum_yok">Bu aday hakkında henüz yorum yapılmamış.</div>';
	}

	print '
	<div class="yorumFormu">
		';

		$form->render();

		print '
	</div>
</div>

';

?>