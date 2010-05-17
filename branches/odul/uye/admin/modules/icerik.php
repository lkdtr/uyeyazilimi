<?php

switch ($_GET[islem]) {
	case "duzenle": {

			// parametreler
			$no            = $_GET[no];
			$sayfa         = $_POST[sayfa];
			$sayfa[baslik] = XSS($sayfa[baslik]);

			// islem
			if( $_POST[action] ){
				// kontrol
				if( empty($sayfa[baslik]) ){
					$baslikError = 'Sayfa başlığı boş!';
				}
				if( empty($sayfa[kod]) ){
					$kodError = 'Sayfa içeriği boş!';	
				}
				// hatasizsa
				if( !$adiError && !$kodError ){
					// veri setini olusturalim
					$data = array(
						'baslik'  => $sayfa[baslik],
						'kod'     => $sayfa[kod]
					);
					// veritabani
					if( $_GET[no] == 'yeni' ){
						// ekleyelim
						if( $db->add('icerik', $data) ){
							new redirect('Sayfa başarıyla eklendi', '?modul=icerik', 3000, 'Devam');
						}else{
							new error('Sayfa eklenemedi');
						}
					}else{
						// ekleyelim
						if( $db->update('icerik', $data, 'no = '.$db->quote->int($_GET[no])) ){
							new redirect('Sayfa bilgileri güncellendi', '?modul=icerik', 3000, 'Devam');
						}else{
							new error('Sayfa bilgileri güncellenemedi!');
						}
					}
				}
			}else{
				if( $no != 'yeni' ){
					$sayfa = $db->get(array(
						'table' => 'icerik',
						'where' => 'no = '.$no
					));
				}
			}

			// baslik
			print '
			<link rel="stylesheet" type="text/css" media="screen" href="../css/form.css" />
			<style>
			.contentForm input[type=text], .contentForm textarea { width: 800px; }
			</style>
			<h2>Sayfa '. ($no == 'yeni' ? 'Ekle':'Düzenle') .'</h2>
			<br>
			';

			// formu basalim
			$form = new form(array(
								   'action'        => '?modul=icerik&islem=duzenle&no='.$no,
								   'class'         => 'contentForm',
								   'labelAligment' => 'top'
								   ));
			// alanlar
			$form->text('Sayfa Başlığı', 'sayfa[baslik]', array('required'=>true, 'default'=>$sayfa[baslik], 'error'=>$baslikError));
			$form->textarea('İçerik', 'sayfa[kod]', array('attr'=>'class="page_code"','required'=>true, 'default'=>$sayfa[kod], 'error'=>$kodError));

			// son
			$form->submit(($no == 'yeni' ? 'Ekle':'Kaydet'), 'action');

			// ekrana basalim
			print '
			<script src="../js/jquery-1.3.2.min.js" type="text/javascript" charset="utf-8"></script>
			<script src="../js/jquery.FCKEditor.js" type="text/javascript" charset="utf-8"></script>
			<script>
			$(function(){
				  $.fck.path = "../js/fckeditor/"
      
				  /* convert textarea to fck editor */
				  $(".page_code").fck({  width: 800, height: 300  });
			});
			</script>
			';
			$form->render();

		break;
	}

	case "sil": {
		// yarisma bilgilerini alalim
		$sayfa = $db->get(array('table'=>'icerik', 'where'=>'no = '.$db->quote->int($_GET[no])));
		if( !$sayfa ) new error('Sayfa bulunamadı!');
		// yarışma bilgilerini silelim
		if( $db->del('icerik', 'no = '.$sayfa[no]) ){
			new redirect('Sayfa silindi!', '?modul=icerik', 3000, 'Devam');
		}else{
			new error('Sayfa silinemedi!');
		}
		break;
	}

	default: {

			// basligi basalim
			print '
			<link rel="stylesheet" type="text/css" media="screen" href="../css/table.css">
			<h2>İçerik Yönetimi</h2>
			<br>
			';

			// sayfa listesini basalim
			$sayfalar = $db->all('icerik');
			if( $sayfalar ){
				print '<table class="Table">
				<tr class="head">
					<td>#</td>
					<td>Sayfa Başlığı</td>
					<td>İşlemler</td>
				</tr>';
				foreach ($sayfalar as $sayfa){
					print '
					<tr>
						<td valign="top">'. $sayfa[no] .'</td>
						<td>'. $sayfa[baslik] .'</td>
						<td valign="top">
							<a class="clean" style="color: blue;" href="?modul=icerik&islem=duzenle&no='. $sayfa[no] .'">Düzenle</a> 
							<a class="clean" style="color: red;" href="#sil" onClick="if( confirm(\'Bu sayfayı kaldırmak istediğinizden emin misiniz?\') ){ window.top.location = \'?modul=icerik&islem=sil&no='. $sayfa[no] .'\'; }">Sil</a>
						</td>
					</tr>';
				}
				print '</table>';
			}else{
				print '<i>Sayfa yok!</i><br>';
			}

			// ekleme linki
			print '<br>
			<a href="?modul=icerik&islem=duzenle&no=yeni">Sayfa Ekle</a>';


		break;
	}
}

?>