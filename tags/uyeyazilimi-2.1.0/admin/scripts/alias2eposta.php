<?php
	/*
	 * LKD Uye Veritabani
	 *
	 * Her satira bir tane olacak sekilde altalta alias'lari ver, e-posta karsiliklarini iceren csv al
	 *
         * Licensed under the GNU General Public License, version 3.
         * See the file http://www.gnu.org/licenses/gpl.txt
	 */
	 
	include("../db.php");

        $Baglanti = @mysql_connect(HOST, USER, PASS) or die("Baglanti kurulamadi");
        @mysql_select_db(DB) or die("Veritabani secilemedi");
        mysql_query("SET NAMES 'utf8'");

        $lines = file('verialias.txt');
        $output = '';

        foreach ($lines as $line_num => $line)
         {
          $temiz = trim($line);
          $sonuc = mysql_query("SELECT uye_id,uye_ad,uye_soyad,eposta1,eposta2,kayit_tarihi FROM uyeler WHERE alias = '$temiz'", $Baglanti);
          $satir = mysql_fetch_row($sonuc);

          if ($satir[4])
           echo "$satir[0],$satir[1],$satir[2],$satir[3],$satir[4],$satir[5]<br>";
         }
  
	mysql_free_result($sonuc);
	mysql_close($Baglanti);
?>
