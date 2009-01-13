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
	
	define("DEFAULT_LOCALE", "tr_TR");
	@setlocale(LC_ALL, DEFAULT_LOCALE);
	session_start();
	include("db.php");
	include("ayar.php");
	include("header.php");

	$KayitTarihi = $_GET["tarih"] ? addslashes($_GET["tarih"]) : "2000";
	$KayitUcreti = 5; // YTL

	$Baglanti = @mysql_connect(HOST, USER, PASS) or die("Baglanti kurulamadi");
	@mysql_select_db(DB) or die("Veritabani secilemedi");
	$Sorgu = "SELECT yil, miktar FROM aidat_miktar WHERE yil >= '". $KayitTarihi ."'";
	$Sonuc = @mysql_query($Sorgu);
	mysql_close($Baglanti); // Kapat gozleriniiii, kimse gormesiiiin...
?>

<table align="center" border="0" cellspacing="1" cellpadding="10">
 <tr bgcolor="#466176">
  <td align="center"><b><font color="#ffffff">&nbsp;Yıl&nbsp;</font></b></td>
  <td align="center"><b><font color="#ffffff">&nbsp;Miktar&nbsp;</font></b></td>
  <td align="center"><b><font color="#ffffff">&nbsp;Açıklama&nbsp;</font></b></td>
 </tr>

<?php
	
	$Toplam = 0;

	if( $KayitTarihi <= 2002 ) { // Yururlukten kaldirilan kayit ucreti icin
		echo "<tr bgcolor=\"$bgcolor\">";
		echo " <td bgcolor=\"#ffffff\" align=\"center\"> * </td>";
		echo " <td bgcolor=\"#ffffff\" align=\"center\"> ". FormatCurrency($KayitUcreti,0,-2,-2,-2) . " </td>";
		echo " <td bgcolor=\"#ffffff\" align=\"center\"> Kayıt Ücreti </td>";
		echo "</tr>\n";
		$Toplam += $KayitUcreti;
	}
		
	while( $Bilgi = mysql_fetch_array($Sonuc) ) {
		echo "<tr bgcolor=\"$bgcolor\">";
		echo " <td bgcolor=\"#ffffff\" align=\"center\"> ". $Bilgi["yil"] . " </td>";
		echo " <td bgcolor=\"#ffffff\" align=\"center\"> ". FormatCurrency($Bilgi["miktar"],0,-2,-2,-2) . " </td>";
		echo " <td bgcolor=\"#ffffff\" align=\"center\"> Aidat </td>";
		echo "</tr>\n";
		$Toplam += $Bilgi["miktar"];
	}

	echo "<tr bgcolor=\"$bgcolor\">";
	echo " <td align=\"center\"><b> Toplam </b></td>";
	echo " <td colspan=2 bgcolor=\"#ffffff\" align=\"left\"> ". FormatCurrency($Toplam,0,-2,-2,-2) . " </td>";
	echo "</tr>";
	
	mysql_free_result($Sonuc);

	echo "</table>";
	include("footer.php");
?>
