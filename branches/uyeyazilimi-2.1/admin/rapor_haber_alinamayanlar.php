<?php
	include("db.php");

        $Baglanti = @mysql_connect(HOST, USER, PASS) or die("Bağlanti kurulamadı");
        @mysql_select_db(DB) or die("Veritabanı seçilemedi");
               mysql_query("SET NAMES 'utf8'");

	$Sorgu = "SELECT uye_id,uye_ad,uye_soyad,eposta1,eposta2,kayit_tarihi FROM uyeler WHERE haber_alinamiyor = 1 ORDER BY uye_id"; //Uyeleri Toptan bir alalim
        $Sonuc = mysql_query($Sorgu) or die(mysql_error());
        $Sayi = mysql_num_rows($Sonuc);

	echo "<html>\n";
	echo " <head><title>LKD - Haber Alınamayan Üye Listesi</title>\n";
	echo "  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>\n";
	echo " </head>\n";
	echo "<body>\n";
        echo '<p>Toplam Haber Alınamayan Üye Sayısı : ' . $Sayi . '</p>';

	echo "<table bgcolor=\"#D6DDE7\" border=0 bgcolor=\"white\" cellpadding=3 cellspacing=1>\n";
	echo " <tr bgcolor=\"#466176\">\n";
	echo "  <td align=\"left\"><font color=\"#ffffff\">Ad Soyad</font></td>\n";
	echo "  <td align=\"center\"><font color=\"#ffffff\">Üye Numarası</font></td>\n";
	echo "  <td align=\"center\"><font color=\"#ffffff\">Kayıt Tarihi</font></td>\n";
	echo "  <td align=\"center\"><font color=\"#ffffff\">E-posta 1</font></td>\n";
	echo "  <td align=\"center\"><font color=\"#ffffff\">E-posta 2</font></td>\n";
	echo " </tr>\n";

	$Renkler = array("#ffffff", "#f5f5f5"); // Okunmasi kolaylassin
	$RenkSec = 0;
	
	while( $Bilgi = mysql_fetch_array($Sonuc) ) { // Her uye icin hesaplamalar yapcaz
		$Renk = $Renkler[ ++$RenkSec%2 ];
		$Ad = $Bilgi["uye_ad"];
		$Soyad = $Bilgi["uye_soyad"];
		$Id = $Bilgi["uye_id"];
		$KayitTarihi = $Bilgi["kayit_tarihi"]; // Ben bu degiskene bayiliyorum!

		// Neler ogrendik
		echo " <tr bgcolor=\"$Renk\">\n";
		echo "  <td>$Ad $Soyad</td>\n";
		echo "  <td>$Id</td>\n";
		echo "  <td>$KayitTarihi</td>\n";
		echo "  <td>". $Bilgi["eposta1"] . "</td>\n";
		echo "  <td>". $Bilgi ["eposta2"] ."</td>\n";
		echo " </tr>";

	} // hoop basa

	mysql_free_result($Sonuc);
	mysql_close($Baglanti);

	echo "</table>\n";
	echo "</body>\n";
	echo "</html>\n";

?>
