<?php
	define("DEFAULT_LOCALE", "tr_TR");
	@setlocale(LC_ALL, DEFAULT_LOCALE);
	session_start();
	require('ayarlar.inc.php');
	require('fonksiyonlar.inc.php');
	require('header.inc.php');

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
	require('footer.inc.php');
?>
