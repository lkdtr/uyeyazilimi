<?php


// kategori listesini alalim
$kategoriler = $db->all(array('table'=>'kategoriler', 'where'=>'yarisma = '.$Y[no]));

// adaylari alalim
$sonuc = $db->all(array('table'=>'adaylar', 'where'=>array('yarisma'=>$Y[no], 'aktif'=>2)));

// kategorilere gore gruplayalim
$adaylar = array();
if( $sonuc ) foreach ($sonuc as $aday) $adaylar[ $aday[kategori] ][] = $aday;

// sayfa basligi
$GLOBALS[sayfaBasligi] = 'Aday askı listesi';

// ekrana basiyoruz
print '<link rel="stylesheet" type="text/css" media="screen" href="/css/adaylar.css">';

// kategoril listesi
if( $kategoriler ){
	foreach ($kategoriler as $kategori){
		print '<div class="kategori">
			<h4>'. $kategori[adi] .'</h4>
			<div class="adaylar">
				';

				// adaylari listeleyelim
				if( $adaylar[ $kategori[no] ] ){
					foreach ($adaylar[ $kategori[no] ] as $aday){
						print '<div class="aday"><a href="/yarisma-'. $Y[anahtar] .'/aday/'. $aday[no] .'/">'. $aday[adi] .'</a></div>';
					}
				}else{
					print 'Bu kategoride henüz aday gösterilmedi';
				}

				print '
			</div>
		</div>';
	}
}

?>
