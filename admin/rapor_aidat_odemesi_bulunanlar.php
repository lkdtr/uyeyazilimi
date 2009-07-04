<?php
	include("db.php");

        $Baglanti = @mysql_connect(HOST, USER, PASS) or die("Bağlanti kurulamadı");
        @mysql_select_db(DB) or die("Veritabanı seçilemedi");
        mysql_query("SET NAMES 'utf8'", $Baglanti);
	$Sorgu = "SELECT alias,uye_id,uye_ad,uye_soyad,kayit_tarihi FROM uyeler WHERE artik_uye_degil=0 ORDER BY uye_ad"; //Uyeleri Toptan bir alalim
        $Sonuc = mysql_query($Sorgu) or die(mysql_error());
		
	header("Pragma: public"); // required
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private", false); // required for certain browsers 
	header("Content-Type: text/csv");
	header("Content-Disposition: attachment; filename=odemeyenler.". date("dmY"). ".csv;");
	header("Content-Transfer-Encoding: binary");

	echo "Ad Soyad;Alias;Üye Numarası;Kayıt Tarihi;Yaptığı Ödeme;Yapması Gereken Ödeme;\n";
	while( $Bilgi = mysql_fetch_array($Sonuc) ) { // Her uye icin hesaplamalar yapcaz
		$Renk = $Renkler[ ++$RenkSec%2 ];
		$Ad = $Bilgi["uye_ad"];
		$Soyad = $Bilgi["uye_soyad"];
		$Id = $Bilgi["uye_id"];
		$Alias = $Bilgi["alias"];
		$KayitTarihi = $Bilgi["kayit_tarihi"]; // Ben bu degiskene bayiliyorum!

		// Odemesi gerekenler
		$Sorgu = "SELECT SUM(miktar) FROM aidat_miktar WHERE yil >= '". $KayitTarihi ."'";
		$Gecici = mysql_query($Sorgu) or die(mysql_error());
		$Gecici = mysql_fetch_row($Gecici);
		$OdemesiGereken = $Gecici[0];
		if( $KayitTarihi <= 2002 )
			$OdemesiGereken += 5;

		// Odedigi
		$Sorgu = "SELECT SUM(miktar) FROM odemeler WHERE uye_id = $Id";
		$Gecici = mysql_query($Sorgu) or die(mysql_error());
		$Gecici = mysql_fetch_row($Gecici);
		$Odedigi = $Gecici[0];

		if( $OdemesiGereken-$Odedigi > 0 ) {
			// Neler ogrendik
			echo "$Ad $Soyad;";
			echo "$Alias;";
			echo "$Id;";
			echo "$KayitTarihi;";
			echo "$Odedigi;";
			echo ($OdemesiGereken-$Odedigi).";";
			echo "\n";
		
		}

	} // hoop basa

	mysql_free_result($Sonuc);
	mysql_close($Baglanti);


?>
