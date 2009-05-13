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

	header("Pragma: public"); // required
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private", false); // required for certain browsers 
	header("Content-Type: text/cvs");
	header("Content-Disposition: attachment; filename=". date("dmY"). ".csv;");
	header("Content-Transfer-Encoding: binary");
	//header("Content-Length: ".filesize($filename));	
	
	define("DEFAULT_LOCALE", "tr_TR");
	@setlocale(LC_ALL, DEFAULT_LOCALE);
	session_start();
	include("db.php");
	include("ayar.php");

        $Baglanti = @mysql_connect(HOST, USER, PASS) or die("Baglanti kurulamadi");
        @mysql_select_db(DB) or die("Veritabani secilemedi");
        $Sorgu = "SELECT uye_id,uye_ad,uye_soyad,alias FROM uyeler WHERE kimlik_basildi = 0 AND Resim != ''";
        $Sonuc = @mysql_query($Sorgu) or die(mysql_error());
        mysql_close($Baglanti); 
	while( $Bilgi = mysql_fetch_array($Sonuc) )
		echo $Bilgi["uye_id"].";".$Bilgi["uye_ad"].";".$Bilgi["uye_soyad"].";".$Bilgi["alias"] ."\n";
	mysql_free_result($Sonuc);

?>
