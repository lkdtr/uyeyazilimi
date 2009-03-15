<?php 
	
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
		
	header('Content-type: image/png');	
	
	$secim = $_GET['secim'];
	$no = is_numeric($_GET['uyeno']) ? $_GET['uyeno'] :0;
	
	$len =strlen($no);
	
	switch($secim){
		case 0;
			yaz('lkd-00.png',(xpos(38,$len)+2),13,'#'.$no);
		break;
		case 1;
			yaz('lkd-01.png',(xpos(38,$len)+2),13,'#'.$no);
		break;
		case 2;
			yaz('lkd-02.png',xpos(38,$len-1),16,$no);
		break;
		case 3;
			yaz('lkd-03.png',xpos(38,$len-1),16,$no);
		break;
		case 4;
			yaz('lkd-04.png',(xpos(38,$len)+58),25,$no);
		break;				
	}


	
	function xpos($base, $len){
		return round(($base - ((8 * $len) + 8)) / 2,0); 	
	}
	
	function yaz($resim,$x,$y,$no){
		$im = imagecreatefrompng('img/'.$resim);
		
		imageantialias($im, true);
		
		//$font = "fonts/FreeMono.ttf";
		$font = 'fonts/DejaVuSansMono.ttf';

		$renk = imagecolorallocate($im, 72, 72, 72);
		
		imagettftext($im, 9, 0, $x, $y, $renk, $font, $no);

		imagepng($im);

		imagedestroy($im);
				
	}
	
	
?>