<?php
	/*
	 * LKD Uye Veritabani
	 *
	 * Her satira bir tane olacak sekilde altalta alias'lari ver, telefonlarini al
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
          $sonuc = mysql_query("SELECT uye_id,uye_ad,uye_soyad,alias,kayit_tarihi,Telefon1,Telefon2 FROM uyeler WHERE alias = '$temiz'", $Baglanti);

          if (mysql_num_rows($sonuc)==0)
           $output .= "$temiz<br>";
          else
           {          
            $satir = mysql_fetch_row($sonuc);
            if ($satir[5] || $satir[6])
             {
              for ($i = 0; $i <= 6; $i++)
               echo "$satir[$i];";
              echo '<br>';
             }
           }
         }

	mysql_free_result($sonuc);
	mysql_close($Baglanti);
?>
