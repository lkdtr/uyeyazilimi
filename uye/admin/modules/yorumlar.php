<?php

switch ($_GET[islem]) {
	case "duzenle": {

			// parametreler
			$no = $_GET[no];

			// varsayilan yorum bilgileri
			$yorum = $db->get(array(
				'table' => 'yorumlar',
				'where' => array('no' => $no)
			));

			// kontrol
			if( !$yorum ) new error('Yorum bulunamadı!');

			// post bilgilerini alalim
			$bilgiler = XSS($_POST[yorum]);
			if($bilgiler) foreach ($bilgiler as $key => $value) $yorum[ $key ] = $value;

			// islem
			if( $_POST[action] ){
				utility('checkEmail');

				// kontroller
				if( empty($yorum[adi]) )          $error[adi]    = 'Adınız boş olamaz';
				if( empty($yorum[eposta]) )       $error[eposta] = 'E-posta adresiniz boş olamaz';
				if( !checkEmail($yorum[eposta]) ) $error[eposta] = 'E-posta adresinizi doğru formatta giriniz';
				if( empty($yorum[yorum]) )        $error[yorum]  = 'Yorum yazmadınız';

				// sorun yoksa
				if( !$error ){
					// veritabanıni guncelleyelim
					if( $db->update('yorumlar', $yorum, array('no'=>$no)) ){
						new redirect('Yorum güncellendi', '?modul=yorumlar&islem=duzenle&no='.$no, 3000, 'Devam');
					}else{
						new error('Yorum bilgileri güncellenemedi!');
					}
				}
			}

			// baslik
			print '
			<link rel="stylesheet" type="text/css" media="screen" href="../css/form.css" />
			<h2>Yorum '. ($no == 'yeni' ? 'Ekle':'Düzenle') .'</h2>
			<br>
			';

			// yorum formu
			$form = new form('?modul=yorumlar&islem=duzenle&no='.$no);
			$form->radio('Durum', array('1'=>'Aktif', '0'=>'Pasif'), 'yorum[aktif]', array('default'=>$yorum[aktif]));
			$form->text('Adınız', 'yorum[adi]', array('required'=>true, 'default'=>$yorum[adi], 'error'=>$error[adi]));
			$form->text('E-Posta Adresiniz', 'yorum[eposta]', array('required'=>true, 'default'=>$yorum[eposta], 'error'=>$error[eposta]));
			$form->textarea('Yorum', 'yorum[yorum]', array('required'=>true, 'default'=>$yorum[yorum], 'error'=>$error[yorum]));

			$form->html($yorum[tarih].'<br>IP : '.$yorum[ip].'<br><small>'. $yorum[browser] .'</small>', array('label'=>'Gönderen Bilgileri'));

			$form->submit('Düzenle', 'action');
			$form->render();

		break;
	}

	case "toggle": {
		// yorumu silelim
		if( $db->update('yorumlar', array('aktif'=>( $_GET[aktif] ? 1:0 )), array('no' => $_GET[no])) ){
			new redirect('Yorum güncellendi!', '?modul=yorumlar', 3000, 'Devam');
		}else{
			new error('Yorum güncellenemedi!');
		}
		break;
	}


	case "sil": {
		// yorumu silelim
		if( $db->del('yorumlar', array('no' => $_GET[no])) ){
			new redirect('Yorum silindi!', '?modul=yorumlar', 3000, 'Devam');
		}else{
			new error('Yorum silinemedi!');
		}
		break;
	}

	default: {

			// basligi basalim
			print '
			<link rel="stylesheet" type="text/css" media="screen" href="../css/table.css">
			<h2>Yorumlar</h2>
			<br>
			';

			// yorum listesini basalim
			$yorumlar = $db->all(array(
				'table'=>'yorumlar',
				'where'=>'yarisma = '.$db->quote->int($Y[no]),
				'order'=>'tarih desc'
			));
			if( $yorumlar ){
				print '<table class="Table">
				<tr class="head">
					<td>#</td>
					<td>Yazan</td>
					<td>IP</td>
					<td>Eklenme Tarihi</td>
					<td>İşlemler</td>
				</tr>';
				foreach ($yorumlar as $yorum){
					print '
					<tr>
						<td>'. $yorum[no] .'</td>
						<td><a href="?modul=yorumlar&islem=duzenle&no='. $yorum[no] .'">'. $yorum[adi] .' &lt;'. $yorum[eposta] .'&gt;</a></td>
						<td>'. $yorum[ip] .'</td>
						<td><small>'. $yorum[tarih] .'</small></td>
						<td valign="top">
							<a class="clean" style="color: '. ($yorum[aktif] ? 'gray':'green') .';" href="?modul=yorumlar&islem=toggle&no='. $yorum[no] .'&aktif='. ($yorum[aktif] ? '0">Pasif':'1">Aktif') .'leştir</a>
							<a class="clean" style="color: blue;" href="?modul=yorumlar&islem=duzenle&no='. $yorum[no] .'">Düzenle</a> 
							<a class="clean" style="color: red;" href="#sil" onClick="if( confirm(\'Bu yorumu silmek istediğinizden emin misiniz?\') ){ window.top.location = \'?modul=yorumlar&islem=sil&no='. $yorum[no] .'\'; }">Sil</a>
						</td>
					</tr>
					';
				}
				print '</table>';
			}else{
				print '<i>Yorum tablosu boş!</i><br>';
			}


		break;
	}
}

?>