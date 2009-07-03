<?php
	/*
	 *  LKD Uye Veritabani
	 *  Copyright (C) 2004  Arman Aksoy (arman.aksoy@linux.org.tr)
	 *
	 *  This program is free software; you can redistribute it and/or modify
	 *  it under the terms of the GNU General Public License as published by
	 *  the Free Software Foundation; either version 2 of the License, or
	 *  (at your option) any later version.
	 *
	 *  This program is distributed in the hope that it will be useful,
	 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
	 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 *  GNU Library General Public License for more details.
	 *
	 *  You should have received a copy of the GNU General Public License
	 *  along with this program; if not, write to the Free Software
	 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
	 */
	 
	session_start();
	if( $_SESSION["uy_status_UserLevel"] != -1 )
		header("Location: index.php");

	define("DEFAULT_LOCALE", "tr_TR");
	@setlocale(LC_ALL, DEFAULT_LOCALE);
	session_start();
	include("db.php");
	include("ayar.php");

        $Baglanti = @mysql_connect(HOST, USER, PASS) or die("Bağlanti kurulamadı");
        @mysql_select_db(DB) or die("Veritabanı seçilemedi");
               mysql_query("SET NAMES 'utf8'");

	$Sorgu = "SELECT uye_id,uye_ad,uye_soyad FROM uyeler WHERE artik_uye_degil = 1 ORDER BY uye_id"; //Uyeleri Toptan bir alalim
        $Sonuc = mysql_query($Sorgu) or die(mysql_error());
        $Sayi = mysql_num_rows($Sonuc);

	echo "<html>\n";
	echo " <head><title>LKD - Ayrılan Üyelerin Listesi</title>\n";
	echo "  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>\n";
	echo " </head>\n";
	echo "<body>\n";

        echo '<p>Toplam Ayrılan Üye Sayısı : ' . $Sayi . '</p>';
	echo "<table bgcolor=\"#D6DDE7\" border=0 bgcolor=\"white\" cellpadding=3 cellspacing=1>\n";
	echo " <tr bgcolor=\"#466176\">\n";
	echo "  <td align=\"left\"><font color=\"#ffffff\">Ad Soyad</font></td>\n";
	echo "  <td align=\"center\"><font color=\"#ffffff\">Üye Numarası</font></td>\n";
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
		echo " </tr>";

	} // hoop basa

	mysql_free_result($Sonuc);
	mysql_close($Baglanti);

	echo "</table>\n";
	echo "</body>\n";
	echo "</html>\n";

?>
