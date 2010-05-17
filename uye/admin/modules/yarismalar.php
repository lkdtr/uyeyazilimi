<?php

switch ($_GET[islem]) {
	case "duzenle": {

			// parametreler
			$no      = $_GET[no];
			$yarisma = XSS($_POST[yarisma]);

			// islem
			if( $_POST[action] ){
				if( empty($yarisma[anahtar]) ){
					$anahtarError = 'Yarışma anahtarı boş (Örnek: deneme-yarismasi)';
				}
				if( empty($yarisma[adi]) ){
					$adiError = 'Yarışma adı boş! (Örnek: Deneme Yarışması)';
				}
				// hatasizsa
				if( !$anahtarError && !$adiError ){
					// veri setini olusturalim
					$data = array(
						'anahtar'  => $yarisma[anahtar],
						'adi'      => $yarisma[adi],
						'adim'     => $yarisma[adim],
						'anasayfa' => $yarisma[anasayfa]
					);
					// veritabani
					if( $_GET[no] == 'yeni' ){
						// veri setine eklenme tarihini ekleyelim
						$data[eklenme_tarihi] = date('Y-m-d H:i:s');
						// ekleyelim
						if( $yarismalar->add($data) ){
							new redirect('Yarışma başarıyla eklendi', '?modul=yarismalar', 3000, 'Devam');
						}else{
							new error('Yarışma eklenemedi');
						}
					}else{
						// ekleyelim
						if( $db->update('yarismalar', $data, 'no = '. $db->quote->int($_GET[no])) ){
							new redirect('Yarışma bilgileri güncellendi', '?modul=yarismalar', 3000, 'Devam');
						}else{
							new error('Yarışma bilgileri güncellenemedi!');
						}
					}
				}
			}else{
				if( $no != 'yeni' ){
					$yarisma = $db->get(array('table'=>'yarismalar', 'where'=>'no = '.$db->quote->int($no)));
				}
			}

			// baslik
			print '
			<link rel="stylesheet" type="text/css" media="screen" href="../css/form.css" />
			<h2>Yarışma '. ($no == 'yeni' ? 'Ekle':'Düzenle') .'</h2>
			<br>
			';

			// formu basalim
			$form = new form('?modul=yarismalar&islem=duzenle&no='.$no);
			// alanlar
			$form->text('Anahtar', 'yarisma[anahtar]', array('required'=>true, 'default'=>$yarisma[anahtar], 'error'=>$anahtarError));
			$form->text('Uzun Adı', 'yarisma[adi]', array('required'=>true, 'default'=>$yarisma[adi], 'error'=>$adiError));
			$form->radio('Aşama', array(1=>'Aday Gösterim Süreci (1)', 2=>'Oylama Süreci (2)', 3=>'Son (3)'), 'yarisma[adim]', array('default'=>$yarisma[adim]));
			
			// sayfa listesini alalim
			$anasayfa[0] = '- Seçiniz -';
			foreach ($db->all('icerik') as $sayfa) $anasayfa[ $sayfa[no] ] = $sayfa[baslik];
			$form->select('Anasayfa', $anasayfa, 'yarisma[anasayfa]', array('default'=>$yarisma[anasayfa]));

			// son
			$form->submit(($no == 'yeni' ? 'Ekle':'Kaydet'), 'action');
			$form->render();

		break;
	}

	case "sil": {
		// yarisma bilgilerini alalim
		$yarisma = $yarismalar->get($_GET[no]);
		if( !$yarisma ) new error('Yarışma bulunamadı!');
		// yarışma bilgilerini silelim
		if( $yarismalar->del($yarisma[no]) ){
			// detaylari silelim
			$where = 'yarisma = '.$yarisma[no];
			$db->del('icerik', $where);
			$db->del('kategoriler', $where);
			$db->del('adaylar', $where);
			$db->del('yorumlar', $where);
			new redirect('Yarışma ve detayları başarıyla silindi!', '?modul=yarismalar', 3000, 'Devam');
		}else{
			new error('Yarışma silinemedi!');
		}
		break;
	}

	case "kopyala": { // yarışma içeriği kopyalama
		if( $_POST[action] ){
			$kopyala = $_POST[kopyala];
			$mesaj = "";
			if( $kopyala[anasayfa] ){
				$kaynakYarisma = $db->get(array('table'=>'yarismalar', 'where'=>array('no'=>$kopyala[kaynak])));
				$hedefYarisma  = $db->get(array('table'=>'yarismalar', 'where'=>array('no'=>$kopyala[hedef])));
				if( $kaynakYarisma[anasayfa] ){
					// anasayfa icerigi
					$anasayfa = $db->get(array('table'=>'icerik', 'where'=>array('no'=>$kaynakYarisma[anasayfa])));
					$anasayfa[baslik] .= ' Kopya '. $hedefYarisma[anahtar];
					unset($anasayfa[no]);
					if( $no = $db->insert('icerik', $anasayfa) ){
						$no = $no[insertId];
						$db->update('yarismalar', array('anasayfa'=>$no), array('no'=>$kopyala[hedef]));
						$mesaj .= "\nYarışma anasayfası başarıyla kopyalandı";
					}else{
						$mesaj .= "\nAnasayfa kopyalanamadı!";
					}
				}
			}
			if( $kopyala[kategoriler] ){
				if( $db->query('INSERT INTO kategoriler (adi, aciklama, yarisma) SELECT adi, aciklama, '. $db->quote->int($kopyala[hedef]) .' as yarisma FROM `kategoriler` WHERE yarisma = '. $db->quote->int($kopyala[kaynak])) ){
					$mesaj .= "\nKategoriler başarıyla kopyalandı";
				}else{
					$mesaj .= "\nKategoriler kopyalanamadı!";
				}
			}
			// bitti
			new redirect(trim($message), './?modul=yarismalar', 3000, 'Devam');
		}

		// ekrana basiyoruz
		print '<link rel="stylesheet" type="text/css" media="screen" href="../css/form.css" />
		<h3>İçerik Kopyalama</h3>
		<br />
		';

		// gerekli seçenekleri seçtirelim
		$form = new form(array(
			'action'        => './?modul=yarismalar&islem=kopyala&no='.$_GET[no],
			'labelAligment' => 'top'
		));
		foreach ($yarismalar->all() as $yarisma) $yarismaList[ $yarisma[no] ] = $yarisma[adi];

		$form->select('Kaynak Yarışma', $yarismaList, 'kopyala[kaynak]');

		$form->select('Hedef Yarışma', $yarismaList, 'kopyala[hedef]', array('default'=>$_GET[no]));

		$form->check('', array(
			'anasayfa'    => 'Anasayfa İçeriği',
			'kategoriler' => 'Kategoriler'
		), 'kopyala', array('optionLine'=>true));

		$form->submit('Kopyala', 'action');
		$form->render();
		break;
	}

	default: {

			// basligi basalim
			print '
			<link rel="stylesheet" type="text/css" media="screen" href="../css/table.css">
			<h2>Yarışmalar</h2>
			<br>
			';

			// yarisma listesini basalim
			$yarismaListe = $yarismalar->all();
			if( $yarismaListe ){
				print '<table class="Table">
				<tr class="head">
					<td>#</td>
					<td>Aşama</td>
					<td>Anahtar</td>
					<td>Adı</td>
					<td>Eklenme Tarihi</td>
					<td>İşlemler</td>
				</tr>';
				foreach ($yarismaListe as $yarisma){
					switch ($yarisma[adim]) {
						case 2:  { $renk = '#80FF80'; break; }
						case 3:  { $renk = '#FBFF80'; break; }
						default: { $renk = '#EEEEEE'; break; }
					}
					print '
					<tr>
						<td>'. $yarisma[no] .'</td>
						<td style="background-color: '. $renk .';" align="center">'. $yarisma[adim] .'</td>
						<td>'. $yarisma[anahtar] .'</td>
						<td>'. $yarisma[adi] .'</td>
						<td>'. $yarisma[eklenme_tarihi] .'</td>
						<td>
							<a class="clean" style="color: blue;" href="?modul=yarismalar&islem=duzenle&no='. $yarisma[no] .'">Düzenle</a> 
							<a class="clean" href="?modul=yarismalar&islem=kopyala&no='. $yarisma[no] .'">Kopyala</a>
							<a class="clean" style="color: red;" href="#sil" onClick="if( confirm(\'Bu yarışmayı kaldırmak istediğinizden emin misiniz?\n\nNot: Yarışmaya ait tüm kategoriler, içerik,\nadaylar ve yorumlar silinecektir\nve bu işlemin geri dönüşü yoktur!\') ){ window.top.location = \'?modul=yarismalar&islem=sil&no='. $yarisma[no] .'\'; }">Sil</a>
						</td>
					</tr>';
				}
				print '</table>';
			}else{
				print '<i>Yarışma Tanımlanmamış!</i><br>';
			}

			// ekleme linki
			print '<br>
			<a href="?modul=yarismalar&islem=duzenle&no=yeni">Yarışma Ekle</a>';


		break;
	}
}

?>