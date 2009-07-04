<?php
	header("Pragma: public"); // required
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private", false); // required for certain browsers 
	header("Content-Type: text/cvs");
	header("Content-Disposition: attachment; filename=". date("dmY"). ".csv;");
	header("Content-Transfer-Encoding: binary");
	//header("Content-Length: ".filesize($filename));	
	
	include("db.php");

        $Baglanti = @mysql_connect(HOST, USER, PASS) or die("Baglanti kurulamadi");
        @mysql_select_db(DB) or die("Veritabani secilemedi");
        mysql_query("SET NAMES 'utf8'");

        $Sorgu = "SELECT uye_id,uye_ad,uye_soyad,alias FROM uyeler WHERE kimlik_durumu = 'İstiyor' AND Resim = ''";
        $Sonuc = @mysql_query($Sorgu) or die(mysql_error());
        mysql_close($Baglanti); 
	while( $Bilgi = mysql_fetch_array($Sonuc) )
		echo $Bilgi["uye_id"].";".$Bilgi["uye_ad"].";".$Bilgi["uye_soyad"].";".$Bilgi["alias"] ."\n";
	mysql_free_result($Sonuc);

?>
