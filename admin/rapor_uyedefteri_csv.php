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


	if( isset($_GET["x"]) && isset($_GET["y"]) ) { // Aralik verilmisse csv ciktisini bastir

		header("Pragma: public"); // required
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private", false); // required for certain browsers 
		header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=". date("dmY"). ".csv;");
		header("Content-Transfer-Encoding: binary");
		//header("Content-Length: ".filesize($filename));	
		

        	$Baglanti = @mysql_connect(HOST, USER, PASS) or die("Baglanti kurulamadi");
        	@mysql_select_db(DB) or die("Veritabani secilemedi");

		$x = intval($_GET["x"]);
		$y = intval($_GET["y"]);
	
       		$Sorgu = "SELECT odemeler.uye_id,uyeler.uye_ad,uyeler.uye_soyad,odemeler.miktar,odemeler.tarih,odemeler.notlar FROM odemeler,uyeler WHERE odemeler.uye_id BETWEEN ". $x ." AND ". $y ." AND odemeler.tur = 'aidat' AND uyeler.uye_id=odemeler.uye_id ORDER BY odemeler.uye_id,odemeler.tarih";
       	 	$Sonuc = @mysql_query($Sorgu) or die(mysql_error());
        	mysql_close($Baglanti); 
		while( $Bilgi = mysql_fetch_array($Sonuc) )
			echo $Bilgi["uye_id"].";".$Bilgi["uye_ad"].";".$Bilgi["uye_soyad"].";".$Bilgi["miktar"] .";".$Bilgi["tarih"].";".$Bilgi["notlar"]."\n";
		mysql_free_result($Sonuc);

		echo " </form>\n";
		echo "</table>\n";
	} else {
		include("header.php");
		echo "<table align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"10\">\n";
		echo " <tr bgcolor=\"#466176\">\n";
		echo " <td align=\"center\"><b><font color=\"#ffffff\">Baslangic</font></b></td>\n";
		echo " <td align=\"center\"><b><font color=\"#ffffff\">Bitis</font></b></td>\n";
		echo " </tr>\n";

		echo " <tr>\n";
		echo "  <form method=\"get\" action=\"$_PHP_SELF\">\n";
		echo " 	<td align=\"center\" bgcolor=\"#ffffff\">\n";
		echo "   <input name=\"x\" type=\"text\"  size=3> <br>\n";
		echo "  </td>\n";
		echo " 	<td align=\"center\" bgcolor=\"#ffffff\">\n";
		echo "   <input name=\"y\" type=\"text\" size=3> <br>\n";
		echo "  </td>\n";
		echo " </tr>\n";
		
		echo " <tr>\n";
		echo "  <td colspan=2 align=\"center\" bgcolor=\"#ffffff\">\n";
		echo "   <input type=\"submit\" value=\"Gonder\n";
		echo "  </td>\n";
		echo " </tr>\n";
		echo " </form>\n";
		echo "</table>\n";
	}
?>
