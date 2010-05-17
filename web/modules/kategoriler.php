<?php

// kategori listesini alalim
$kategoriler = $db->all(array('table'=>'kategoriler', 'where'=>'yarisma = '.$Y[no]));

// sayfa basligi
$GLOBALS[sayfaBasligi] = 'Ödül Kategorileri';

// ekrana basiyoruz
print '<link rel="stylesheet" type="text/css" media="screen" href="/css/kategoriler.css">';

// kategoril listesi
if( $kategoriler ){
	foreach ($kategoriler as $kategori){
		print '<div class="kategori">
			<h4><a href="/yarisma-'. $Y[anahtar] .'/kategori/'. $kategori[no] .'/">'. $kategori[adi] .'</a></h4>
			<div class="aciklama">
				'. nl2br($kategori[aciklama]) .'
			</div>
		</div>';
	}
}else{
	print 'Bu dönemki yarışma kategorileri henüz açıklanmadı!';
}

?>