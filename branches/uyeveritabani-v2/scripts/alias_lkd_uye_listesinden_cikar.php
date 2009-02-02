<?php
	/*
	 * LKD Uye Veritabani
	 *
	 * Her satira bir tane olacak sekilde altalta alias'lari ver, hepsi lkd-uye listesinden ciksin
	 *
         * Licensed under the GNU General Public License, version 3.
         * See the file http://www.gnu.org/licenses/gpl.txt
	 */
	 
	include("../db.php");

        $Baglanti = @mysql_connect(HOST, USER, PASS) or die("Baglanti kurulamadi");
        @mysql_select_db(DB) or die("Veritabani secilemedi");
        mysql_query("SET NAMES 'utf8'");

        $lines = file('aliascikar.txt');
        $output = '';

        foreach ($lines as $line_num => $line)
         {
          $temiz = trim($line);
          $sonuc = mysql_query("UPDATE uyeler SET liste_uyeligi = 0 WHERE alias = '$temiz'", $Baglanti);
         }
  
	mysql_free_result($sonuc);
	mysql_close($Baglanti);
?>
