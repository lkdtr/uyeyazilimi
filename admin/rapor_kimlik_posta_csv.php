<?php
	header("Pragma: public"); // required
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private", false); // required for certain browsers 
	header("Content-Type: text/cvs");
	header("Content-Disposition: attachment; filename=". date("dmY"). ".csv;");
	header("Content-Transfer-Encoding: binary");
	//header("Content-Length: ".filesize($filename));	
	
	require('ayarlar.inc.php');

        $Baglanti = @mysql_connect(HOST, USER, PASS) or die("Baglanti kurulamadi");
        @mysql_select_db(DB) or die("Veritabani secilemedi");
        mysql_query("SET NAMES 'utf8'");

        $Sorgu = "SELECT uye_id,uye_ad,uye_soyad,is_addr,semt,sehir,pkod FROM uyeler WHERE kimlik_durumu = 'Postaya Verilecek'";
        $Sonuc = @mysql_query($Sorgu) or die(mysql_error());
        mysql_close($Baglanti); 
	while( $Bilgi = mysql_fetch_array($Sonuc) )
            {
		$Bilgi["is_addr"] = preg_replace("/(\r\n)+|(\n|\r)+/", " ", $Bilgi["is_addr"]); // birden fazla satirdan olusan adresleri tek satirda toplayalim
		$Bilgi["is_addr"] = str_replace(";", ",", $Bilgi["is_addr"]); // noktali virgulle ayrilmis csv uretiyoruz, noktali virgulleri virgule cevirelim de karismasin
		echo $Bilgi["uye_id"].";".$Bilgi["uye_ad"]." ".$Bilgi["uye_soyad"].";".$Bilgi["is_addr"]." ".$Bilgi["pkod"]." ".$Bilgi["semt"]." ".$Bilgi["sehir"] ."\n";
            }
	mysql_free_result($Sonuc);

?>
