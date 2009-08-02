<?php
 # Elde kart istedigini bildigimiz uyelerin bir metin dosyasinda her satir bir uyeye denk gelecek bicimde ad soyad listesi oldugunda, bunu veritabanindaki isimlerle esleyerek, veritabanina bu isteklerini isleyecek bir betik

	require("../db.php");

        $Baglanti = @mysql_connect(HOST, USER, PASS) or die("Baglanti kurulamadi");
        @mysql_select_db(DB) or die("Veritabani secilemedi");
        mysql_query("SET NAMES 'utf8'");

        $lines = file('hede.txt');

        foreach ($lines as $line)
         {
          $temiz = trim($line);
          if($temiz)
           {
            $parcalar = explode(" ",$temiz);
            if (count($parcalar) == 2)
             {
              $ad = $parcalar[0];
              $soyad = $parcalar[1];
             }
            else
             {
              $ad = $parcalar[0] . ' ' . $parcalar[1];
              $soyad = $parcalar[2];
             }
           }
            $sorgu = "UPDATE uyeler SET kimlik_durumu = 'İstiyor' WHERE uye_ad = \"$ad\" AND uye_soyad=\"$soyad\"";
            $sonuc = mysql_query($sorgu, $Baglanti);
         }
  
	mysql_free_result($sonuc);
	mysql_close($Baglanti);

        echo 'Tamam';
?>
