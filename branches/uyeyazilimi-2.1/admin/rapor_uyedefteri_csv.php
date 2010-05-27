<?php
	require('ayarlar.inc.php');
	require('fonksiyonlar.inc.php');

	if( isset($_GET["x"]) && isset($_GET["y"]) ) { // Aralik verilmisse csv ciktisini bastir

                csv_dosya_http_baslik_bilgilerini_gonder('uyedefteri');

        	$Baglanti = @mysql_connect(HOST, USER, PASS) or die("Baglanti kurulamadi");
        	@mysql_select_db(DB) or die("Veritabani secilemedi");
		mysql_query("SET NAMES 'utf8'");

                foreach ($_GET as $key => $value)
                    $$key = intval($value);

      		$Sorgu = 'SELECT odemeler.uye_id,uyeler.uye_ad,uyeler.uye_soyad,odemeler.miktar,odemeler.tarih,odemeler.notlar FROM odemeler,uyeler WHERE odemeler.uye_id BETWEEN ' . $x . ' AND ' . $y . ' AND odemeler.tur = "aidat" AND uyeler.uye_id = odemeler.uye_id AND odemeler.tarih BETWEEN "' . $ilk_yil . '-' . $ilk_ay . '-' . $ilk_gun . '" AND "' . $son_yil . '-' . $son_ay . '-' . $son_gun . '" ORDER BY odemeler.uye_id,odemeler.tarih';
       	 	$Sonuc = @mysql_query($Sorgu) or die(mysql_error());
        	mysql_close($Baglanti); 
		while( $Bilgi = mysql_fetch_array($Sonuc) )
		    echo $Bilgi["uye_id"] . ';' . $Bilgi['uye_ad'] . ' ' . $Bilgi['uye_soyad'] . ';' . $Bilgi['miktar'] . ';' . $Bilgi['tarih'] . ';' . trim($Bilgi['notlar']) . "\n";
		mysql_free_result($Sonuc);

	} else {
		require('header.inc.php');
		echo "<table align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"10\">\n";
		echo " <tr bgcolor=\"#466176\">\n";
		echo " <td>&nbsp;</td>\n";
		echo " <td align=\"center\"><b><font color=\"#ffffff\">Baslangic</font></b></td>\n";
		echo " <td align=\"center\"><b><font color=\"#ffffff\">Bitis</font></b></td>\n";
		echo " </tr>\n";

		echo " <tr>\n";
		echo "  <form method=\"get\" action=\"$_SERVER[PHP_SELF]\">\n";
		echo " 	<td align=\"center\" bgcolor=\"#ffffff\">\n";
		echo "   Üye No <br>\n";
		echo "  </td>\n";
		echo " 	<td align=\"center\" bgcolor=\"#ffffff\">\n";
		echo "   <input name=\"x\" type=\"text\"  size=3> <br>\n";
		echo "  </td>\n";
		echo " 	<td align=\"center\" bgcolor=\"#ffffff\">\n";
		echo "   <input name=\"y\" type=\"text\" size=3> <br>\n";
		echo "  </td>\n";
		echo " </tr>\n";

		echo " <tr>\n";
		echo " 	<td align=\"center\" bgcolor=\"#ffffff\">\n";
		echo "   Tarih <br>\n";
		echo "  </td>\n";
		echo " 	<td align=\"center\" bgcolor=\"#ffffff\">\n";
		echo "   <input name=\"ilk_gun\" type=\"text\"  size=2>\n";
		echo "   <input name=\"ilk_ay\" type=\"text\"  size=2>\n";
		echo "   <input name=\"ilk_yil\" type=\"text\"  size=4>\n";
		echo "  </td>\n";
		echo " 	<td align=\"center\" bgcolor=\"#ffffff\">\n";
		echo "   <input name=\"son_gun\" type=\"text\"  size=2>\n";
		echo "   <input name=\"son_ay\" type=\"text\"  size=2>\n";
		echo "   <input name=\"son_yil\" type=\"text\"  size=4>\n";
		echo "  </td>\n";
		echo " </tr>\n";
		
		echo " <tr>\n";
		echo "  <td colspan=3 align=\"center\" bgcolor=\"#ffffff\">\n";
		echo "   <input type=\"submit\" value=\"Gonder\n";
		echo "  </td>\n";
		echo " </tr>\n";
		echo " </form>\n";
		echo "</table>\n";
	}
?>
