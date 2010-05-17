<?php

switch ($_GET[islem]) {
	case "duzenle": {

			// parametreler
			$no   = $_GET[no];
			$aday = $db->get(array('table'=>'adaylar', 'where'=>array('no'=>$no)));
			// aday dizisinin üstüne yazalim
			$post_aday = XSS($_POST[aday]);
			if($post_aday) foreach ($post_aday as $key => $value) $aday[ $key ] = $value;


			// islem
			if( $_POST[action] ){
				unset($error);

				// kontrol
				utility('checkEmail');
				if( !$aday[ekleyen_uye] )                    $error[diger]              = 'Sistem Hatası (LKD Üye)';
				if( empty($aday[ekleyen_uye]) )              $error[ekleyen_uye]        = 'LKD no boş olamaz';
				if( empty($aday[ekleyen_uye_adi]) )          $error[ekleyen_uye_adi]    = 'Adınız boş olamaz';
				if( empty($aday[ekleyen_uye_eposta]) )       $error[ekleyen_uye_eposta] = 'E-posta adresiniz boş olamaz';
				if( !checkEmail($aday[ekleyen_uye_eposta]) ) $error[ekleyen_uye_eposta] = 'E-posta adresinizi doğru giriniz';
				if( empty($aday[adi]) )                      $error[adi]                = 'Adayın adı boş olamaz';
				if( empty($aday[eposta]) )                   $error[eposta]             = 'Adayın e-posta adresi boş olamaz';
				if( !checkEmail($aday[eposta]) )             $error[eposta]             = 'Adayın e-posta adresinizi doğru giriniz';
				if( empty($aday[kategori]) )                 $error[kategori]           = 'Kategori seçmediniz';
				if( empty($aday[aciklama]) )                 $error[aciklama]           = 'Tanım boş olamaz';

				if( !$error ){
					// veritabanina guncelleyelim
					if( $db->update('adaylar', $aday, array('no'=>$no)) ){
						new redirect(array(
							'message'     => 'Aday bilgileri başarıyla güncellendi!',
							'url'         => '?modul=adaylar',
							'auto'        => 3000,
							'buttonLabel' => 'Devam'
						));
					}else{
						new error('Aday bilgileri kaydedilemedi!');
					}
				}
			}


			// kategorileri alalim
			$sonuc = $db->all(array('table'=>'kategoriler', 'where'=>array('yarisma'=>$Y[no])));
			unset($kategoriler);
			foreach ($sonuc as $val) $kategoriler[ $val[no] ] = $val[adi];

			// baslik
			print '
			<link rel="stylesheet" type="text/css" media="screen" href="../css/form.css" />
			<style type="text/css" media="screen">
				.Form .kategoriler span.option { display: block; }
			</style>
			<h2>Aday Bilgileri</h2>
			<br>
			';

			$form = new form('?modul=adaylar&islem=duzenle&no='.$no);

			$form->radio('Aktif', array(
'1'=>'Aktif', 
'2'=>'Askıda', 
'0'=>'Pasif'), 'aday[aktif]', array('required'=>true, 'default'=>$aday[aktif], 'error'=>$error[aktif]));
			$form->html($aday[eklenme_tarihi], array('label'=>'Eklenme Tarihi'));
			$form->html($aday[ekleyen_ip], array('label'=>'Ekleyen IP'));

			$form->html('<br><h4>Öneren Kişi Bilgileri</h4>');
			$form->text('LKD No', 'aday[ekleyen_uye]', array('required'=>true, 'default'=>$aday[ekleyen_uye], 'error'=>$error[ekleyen_uye]));
			$form->text('Adınız', 'aday[ekleyen_uye_adi]', array('required'=>true, 'default'=>$aday[ekleyen_uye_adi], 'error'=>$error[ekleyen_uye_adi]));
			$form->text('E-Posta Adresiniz', 'aday[ekleyen_uye_eposta]', array('required'=>true, 'default'=>$aday[ekleyen_uye_eposta], 'error'=>$error[ekleyen_uye_eposta]));

			$form->html('<br><h4>Aday Bilgileri</h4>');
			$form->text('Adayın Adı', 'aday[adi]', array('required'=>true, 'default'=>$aday[adi], 'error'=>$error[adi]));
			$form->text('E-posta Adresi', 'aday[eposta]', array('required'=>true, 'default'=>$aday[eposta], 'error'=>$error[eposta]));
			$form->radio('Kategori', $kategoriler, 'aday[kategori]', array('required'=>true, 'default'=>$aday[kategori], 'liAttr'=>'class="kategoriler"', 'error'=>$error[kategori]));
			$form->textarea('Tanım', 'aday[aciklama]', array('required'=>true, 'default'=>$aday[aciklama], 'error'=>$error[aciklama]));

			$form->submit('Düzenle', 'action');
			$form->render();

		break;
	}

	case "toggle": {
		if( $db->update('adaylar', array('aktif'=> ( $_GET[aktif] ) ), 'no = 
'.$db->quote->int($_GET[aday])) ){
			new redirect('Aday bilgileri güncellendi!', '?modul=adaylar', 3000, 'Devam');
		}else{
			new error('Aday bilgileri güncellenemedi!');
		}
		break;
	}

	case "sil": {
		// aday bilgilerini alalim
		$aday = $db->get(array('table'=>'adaylar', 'where'=>'no = '.$db->quote->int($_GET[no])));
		if( !$aday ) new error('Aday bulunamadı!');
		// aday bilgilerini silelim
		if( $db->del('adaylar', 'no = '.$aday[no]) ){
			new redirect('Aday silindi!', '?modul=adaylar', 3000, 'Devam');
		}else{
			new error('Aday silinemedi!');
		}
		break;
	}

	default: {

			// basligi basalim
			print '
			<link rel="stylesheet" type="text/css" media="screen" href="../css/table.css">
			<h2>Kategorilere göre adaylar</h2>
			<br>
			';

			// yarisma listesini basalim
			$kategoriler = $db->all(array(
				'table'=>'kategoriler',
				'where'=>'yarisma = '.$db->quote->int($Y[no])
			));

			// adaylari alalim
			$sonuc = $db->all(array('table'=>'adaylar', 'where'=>array('yarisma'=>$Y[no])));

			// kategorilere gore gruplayalim
			$adaylar = array();
			if( $sonuc ) foreach ($sonuc as $aday) $adaylar[ $aday[kategori] ][] = $aday;


			if( $kategoriler ){
				print '<table class="Table">
				<tr class="head">
					<td>#</td>
					<td>Durum</td>
					<td width="500">Adı</td>
					<td>Eklenme Tarihi</td>
					<td>İşlemler</td>
				</tr>';
				foreach ($kategoriler as $kategori){
					print '<tr><td colspan="10"><i><b>'. $kategori[adi] .'</b></i></td></tr>';
					// adaylari listeleyelim
					if( $adaylar[ $kategori[no] ] ){
						foreach ($adaylar[ $kategori[no] ] as $aday){
							print '
							<tr>
								<td valign="top">'. 
$aday[no] .'</td>
								<td>';
if ($aday[aktif]==0) print 'Pasif';
else if ($aday[aktif]==1) print 'Aktif';
else if ($aday[aktif]==2) print 'Askıya çıkmış';
								print '</td>
								<td><b>'. $aday[adi] .'</b></td>
								<td><small>'. $aday[eklenme_tarihi] .'</small></td>
								<td valign="top">
									<a class="clean" 
style="color: '. ( $aday[aktif] ? 'gray':'green' ) .';" href="?modul=adaylar&islem=toggle&aday='. $aday[no] .'&aktif=';
if ($aday[aktif]==1) print '0">Pasifleştir';
if ($aday[aktif]==2) print '1">Aktifleştir';
if ($aday[aktif]==0) print '2">Askıya çıkart';

print '</a> 
									<a class="clean" style="color: blue;" href="?modul=adaylar&islem=duzenle&no='. $aday[no] .'">Düzenle</a> 
									<a class="clean" style="color: red;" href="#sil" onClick="if( confirm(\'Bu adayı silmek istediğinizden emin misiniz?\') ){ window.top.location = \'?modul=adaylar&islem=sil&no='. $aday[no] .'\'; }">Sil</a>
								</td>
							</tr>';
						}
					}
				}
				print '</table>';
			}else{
				print '<i>Kategori Tanımlanmamış!</i><br>';
			}


		break;
	}
}

?>
