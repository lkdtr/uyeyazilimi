<?php
	include("../db.php");

        $Baglanti = @mysql_connect(HOST, USER, PASS) or die("Baglanti kurulamadi");
        @mysql_select_db(DB) or die("Veritabani secilemedi");
        mysql_query("SET NAMES 'utf8'");

        $lines = file('uyeler_iletisilemeyen.csv');

        foreach ($lines as $line)
         {
          $parcalar = explode(',',$line);
          mysql_query("UPDATE uyeler SET haber_alinamiyor = 1 WHERE uye_id = $parcalar[0]", $Baglanti) or die(mysql_error());
         }
  
	mysql_close($Baglanti);

        echo 'Tamam';
?>
