<?php
	/*
	 * LKD Uye Veritabani
	 *
	 * uye_resimler dizininde bulunan dosya isimlerini, dosya ismini uye numarasi kabul ederek veritabanindaki kaydina ekle
	 *
         * Licensed under the GNU General Public License, version 3.
         * See the file http://www.gnu.org/licenses/gpl.txt
	 */
	 
	include("../db.php");

        $Baglanti = @mysql_connect(HOST, USER, PASS) or die("Baglanti kurulamadi");
        @mysql_select_db(DB) or die("Veritabani secilemedi");

        if ($handle = opendir('../uye_resimler/'))
         while (false !== ($file = readdir($handle)))
          if ($file != "." && $file != "..")
            {
             $file_pieces = explode('.', $file);
             $query = "UPDATE uyeler SET Resim = '$file' WHERE uye_id = $file_pieces[0]";
             $result = mysql_query($query);
             if (!$result)
              die('Hatali sorgu: ' . mysql_error());
            }
        closedir($handle);

	mysql_free_result($sonuc);
	mysql_close($Baglanti);

        echo "Senkronizasyon tamamlandı";
?>
