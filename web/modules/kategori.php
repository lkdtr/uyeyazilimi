<?php

// kategori listesini alalim
$kategori = $db->get(array('table'=>'kategoriler', 'where'=>'no = '.$db->quote->int($_GET[no])));

// bu kategorideki adaylari alalim
$adaylar = $db->all(array('table'=>'adaylar', 'where'=>array('yarisma'=>$Y[no], 'kategori'=>$kategori[no], 'aktif'=>1)));

// ekrana basiyoruz
print '
<link rel="stylesheet" type="text/css" media="screen" href="/css/kategori.css">
<h3>'.$kategori[adi].'</h3>

<div class="kutu">
	'. nl2br($kategori[aciklama]) .'
</div>

<h4>Adaylar</h4>
<div class="kutu adaylar">';
	// adaylari listeleyelim
	if( $adaylar ){
		foreach ($adaylar as $aday){
			print '<div class="aday"><a href="/yarisma-'. $Y[anahtar] .'/aday/'. $aday[no] .'/">'. $aday[adi] .'</a></div>';
		}
	}else{
		print 'Bu kategoride henüz aday gösterilmedi';
	}
print '</div>
<br>

<h4>Önceki Yıllarda Kazananlar</h4>
<div class="kutu">
'; 

$kazananlar = nl2br($kategori[gecen_yillardaki_kazananlar]);
if( !$kazananlar ) $kazananlar = '<i>Önceki yıllarda kazananlar açıklanmadı!</i>';
print $kazananlar;

print '
</div>
<br>

<h4>Aday göstermek istediğiniz penguenler mi var?</h4>
<div class="kutu">
	Eğer aday göstermek istediğiniz penguenler varsa, Aday Ekleme prosedürü hakkındaki detaylı bilgiye <a href="/yarisma-'.$Y[anahtar].'/aday-goster/">buraya tıklayarak</a> ulaşabilirsiniz.
</div>
';


?>