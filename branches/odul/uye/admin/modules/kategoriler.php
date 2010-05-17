<?php

switch ($_GET[islem]) {
	case "duzenle": {

			// parametreler
			$no      = $_GET[no];
			$kategori = XSS($_POST[kategori]);

			// islem
			if( $_POST[action] ){
				// kontrol
				if( empty($kategori[adi]) ){
					$adiError = 'Kategori adı boş!';
				}
				if( empty($kategori[aciklama]) ){
					$aciklamaError = 'Kategori açıklaması boş!';	
				}
				// hatasizsa
				if( !$adiError && !$aciklamaError ){
					// veri setini olusturalim
					$data = array(
						'adi'                         => $kategori[adi],
						'aciklama'                    => $kategori[aciklama],
						'gecen_yillardaki_kazananlar' => $kategori[gecen_yillardaki_kazananlar],
						'yarisma'                     => $Y[no]
					);
					// veritabani
					if( $_GET[no] == 'yeni' ){
						// ekleyelim
						if( $db->add('kategoriler', $data) ){
							new redirect('Kategori başarıyla eklendi', '?modul=kategoriler', 3000, 'Devam');
						}else{
							new error('Kategori eklenemedi');
						}
					}else{
						// ekleyelim
						if( $db->update('kategoriler', $data, 'no = '.$db->quote->int($_GET[no])) ){
							new redirect('Kategori bilgileri güncellendi', '?modul=kategoriler', 3000, 'Devam');
						}else{
							new error('Kategori bilgileri güncellenemedi!');
						}
					}
				}
			}else{
				if( $no != 'yeni' ){
					$kategori = $db->get(array(
						'table' => 'kategoriler',
						'where' => 'no = '.$no
					));
				}
			}

			// baslik
			print '
			<link rel="stylesheet" type="text/css" media="screen" href="../css/form.css" />
			<h2>Kategori '. ($no == 'yeni' ? 'Ekle':'Düzenle') .'</h2>
			<br>
			';

			// formu basalim
			$form = new form('?modul=kategoriler&islem=duzenle&no='.$no);
			// alanlar
			$form->text('Adı', 'kategori[adi]', array('required'=>true, 'default'=>$kategori[adi], 'error'=>$adiError));
			$form->textarea('Açıklama', 'kategori[aciklama]', array('required'=>true, 'default'=>$kategori[aciklama], 'error'=>$aciklamaError));
			$form->textarea('Geçen Yıllardaki Kazananlar', 'kategori[gecen_yillardaki_kazananlar]', array('required'=>true, 'default'=>$kategori[gecen_yillardaki_kazananlar]));
			// son
			$form->submit(($no == 'yeni' ? 'Ekle':'Kaydet'), 'action');
			$form->render();

		break;
	}

	case "sil": {
		// yarisma bilgilerini alalim
		$kategori = $db->get(array('table'=>'kategoriler', 'where'=>'no = '.$db->quote->int($_GET[no])));
		if( !$kategori ) new error('Kategori bulunamadı!');
		// yarışma bilgilerini silelim
		if( $db->del('kategoriler', 'no = '.$kategori[no]) ){
			new redirect('Kategori silindi!', '?modul=kategoriler', 3000, 'Devam');
		}else{
			new error('Kategori silinemedi!');
		}
		break;
	}

	default: {

			// basligi basalim
			print '
			<link rel="stylesheet" type="text/css" media="screen" href="../css/table.css">
			<h2>Kategoriler</h2>
			<br>
			';

			// yarisma listesini basalim
			$kategoriler = $db->all(array(
				'table'=>'kategoriler',
				'where'=>'yarisma = '.$db->quote->int($Y[no])
			));
			if( $kategoriler ){
				print '<table class="Table">
				<tr class="head">
					<td>#</td>
					<td width="500">Adı / Açıklama</td>
					<td>İşlemler</td>
				</tr>';
				foreach ($kategoriler as $kategori){
					print '
					<tr>
						<td valign="top">'. $kategori[no] .'</td>
						<td>
							<b>'. $kategori[adi] .'</b>
							'. ( $kategori[aciklama] ? '<br><small>'. nl2br($kategori[aciklama]) .'</small>':'' ) .'
						</td>
						<td valign="top">
							<a class="clean" style="color: blue;" href="?modul=kategoriler&islem=duzenle&no='. $kategori[no] .'">Düzenle</a> 
							<a class="clean" style="color: red;" href="#sil" onClick="if( confirm(\'Bu kategoriyi kaldırmak istediğinizden emin misiniz?\') ){ window.top.location = \'?modul=kategoriler&islem=sil&no='. $kategori[no] .'\'; }">Sil</a>
						</td>
					</tr>';
				}
				print '</table>';
			}else{
				print '<i>Kategori Tanımlanmamış!</i><br>';
			}

			// ekleme linki
			print '<br>
			<a href="?modul=kategoriler&islem=duzenle&no=yeni">Kategori Ekle</a>';


		break;
	}
}

?>