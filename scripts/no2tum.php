<?php
	/*
	 * LKD Uye Veritabani
	 *
	 * Her satira bir tane olacak sekilde numaralari altalta ver, tum bilgilerini al
	 *
         * Licensed under the GNU General Public License, version 3.
         * See the file http://www.gnu.org/licenses/gpl.txt
	 */
	 
	include("../db.php");

        $Baglanti = @mysql_connect(HOST, USER, PASS) or die("Baglanti kurulamadi");
        @mysql_select_db(DB) or die("Veritabani secilemedi");
        mysql_query("SET NAMES 'utf8'");

        $lines = file('verino.txt');
        $output = '';

        foreach ($lines as $line_num => $line)
         {
          $temiz = trim($line);
          $sonuc = mysql_query("SELECT * FROM uyeler WHERE uye_id = '$temiz'", $Baglanti);

          if (mysql_num_rows($sonuc)==0)
           $output .= "$temiz<br>";
          else
           {          
            $satir = mysql_fetch_row($sonuc);
            foreach ($satir as &$hane)
              echo "$hane;";
            echo '<br>';
           }
         }

        echo "Bulunamayanlar :<br>$output";

	mysql_free_result($sonuc);
	mysql_close($Baglanti);
?>
