<?php

    # Toplu uye ilisigi kesmek icin betik, uye yazilim parcalarindan kopyala-yapistir metoduyla olusturuldu. Fonksiyonlara ayrilmis bir yazilim ne guzel olur ileride...
    # Haber alinamayan VE 3. aidat borcu binenlerin ilisigini kesiyor

    require '../ayarlar.inc.php';
 
    // Veritabanına bağlanalım
    $conn = mysql_connect(HOST, USER, PASS);
    mysql_query("SET NAMES 'utf8'", $conn);

    // Uyeleri alalim
    mysql_select_db(DB);
    $query = 'SELECT uye_id, uye_ad, uye_soyad, alias, kayit_tarihi FROM uyeler WHERE artik_uye_degil = 0 AND haber_alinamiyor = 1';
    $result = mysql_query($query);
    $rowno = mysql_num_rows($result);

    while($rowno--)
     {
      $row = mysql_fetch_array($result);
      $slug = explode('@', $row['alias']);

      // Odemesi gerekenler
      mysql_select_db(DB);
      $Sorgu = "SELECT SUM(miktar) FROM aidat_miktar WHERE yil >= '". $row['kayit_tarihi'] ."'";
      $Gecici = mysql_query($Sorgu) or die(mysql_error());
      $Gecici = mysql_fetch_row($Gecici);
      $OdemesiGereken = $Gecici[0];
      if( $row['kayit_tarihi'] <= 2002 )	// Ilk 3 yil giris aidati uygulaniyordu
          $OdemesiGereken += 5;

      // Odedigi
      $Sorgu = 'SELECT SUM(miktar) FROM odemeler WHERE uye_id = ' . $row['uye_id'];
      $Gecici = mysql_query($Sorgu) or die(mysql_error());
      $Gecici = mysql_fetch_row($Gecici);
      $Odedigi = $Gecici[0];

      if( $OdemesiGereken-$Odedigi > 40 )	        // Birikmis borcu varsa ilisigini keselim
       {
        $borc = $OdemesiGereken-$Odedigi;
        echo $row['uye_id'] . ",$slug[0],$borc<br>";

        // Uye veritabanina yilin son gununun kapanis zaman damgasi yazalim
        $Sorgu = "UPDATE uyeler SET artik_uye_degil=1,kayit_kapanis_tarih = '2009-12-31 23:59:59',ayrilma_tarihi = '2009' WHERE uye_id=". $row['uye_id'] ;
        mysql_query($Sorgu) or die(mysql_error());

        // E-posta veritabanindan silelim
        mysql_select_db(DB_MAIL);
        $Sorgu = 'DELETE FROM forwardings WHERE source="' . $row['alias'] . '"';
        mysql_query($Sorgu) or die(mysql_error());

        // Parola veritabanindan silelim
        mysql_select_db(DB_PWD);
        $Sorgu = 'DELETE FROM members WHERE uye_no = ' . $row['uye_id'];
        mysql_query($Sorgu) or die(mysql_error());

        # Trac veritabanindan silelim
        mysql_select_db(DB_TRAC,$conn);
        $Sorgu = 'DELETE FROM session_attribute WHERE sid = "' . $slug[0] . '"';
        mysql_query($Sorgu, $conn) or die(mysql_error());
        $Sorgu = 'DELETE FROM session WHERE sid = "' . $slug[0] . '"';
        mysql_query($Sorgu, $conn) or die(mysql_error());
       }
     }
?>
