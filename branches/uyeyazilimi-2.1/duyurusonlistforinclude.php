<?php
	/*
	 *  LKD Uye Veritabani
	 *  Copyright (C) 2004  R. Tolga KORKUNCKAYA (tolga@mavibilgisayar.com)
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

include ("ayar.php"); 
// baglanti hazirlaniyor...
$conn = mysql_connect(HOST, USER, PASS);
mysql_select_db(DB);
mysql_query("SET NAMES 'utf8'");

// enson duyurular çekiliyor
$x_Limit = 3;
$strsql = "SELECT * FROM duyurular ORDER BY DuyuruID DESC LIMIT 0,$x_Limit";
$rs = mysql_query($strsql,$conn) or die(mysql_error());

		// degerleri ayir...

		/*
<p><br><br><a href="duyurularlist.php">Listeye Dön</a></p>
*/
?>
<p>
<table width="96%" border="0" align="center" cellpadding="4" cellspacing="1">
<tr>
<?php
// while im başlangıcı
while($row = mysql_fetch_array($rs)) {
$x_DuyuruID = @$row["DuyuruID"];
$x_DuyuruBaslik = @$row["DuyuruBaslik"];
$x_DuyuruOzet = @$row["DuyuruOzet"];
$x_DuyuruText = @$row["DuyuruText"];
$x_DuyuruTarih = @$row["DuyuruTarih"];
$x_DuyuruSonTarih = @$row["DuyuruSonTarih"];
$x_DuyuruAktif = @$row["DuyuruAktif"];
$x_StatikSayfa = @$row["StatikSayfa"];
$x_DuyuruTur = @$row["DuyuruTur"];
?>
<td valign="top" width="33%">
	<table border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td bgcolor="#466176" height="35">
				<font color="white"><?php echo str_replace(chr(10), "<br>" ,@$x_DuyuruBaslik . "") ?></font>
			</td>
		<tr>
			<td>
<?php
switch ($x_DuyuruTur) {
case "LKD Genel Kurul Raporu":
		echo "LKD Genel Kurul Raporu";
		break;
case "LKD YK Çalışma Raporu":
		echo "LKD YK Çalışma Raporu";
		break;
case "Çalışma Grubu Raporu":
		echo "Çalışma Grubu Raporu";
		break;
case "LKD Genel Duyuru":
		echo "LKD Genel Duyuru";
		break;
case "Denetleme Kurulu Raporu":
		echo "Denetleme Kurulu Raporu";
		break;
case "Diğer Duyuru Konuları":
		echo "Diğer Duyuru Konuları";
		break;
}
?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo str_replace(chr(10), "<br>" ,@$x_DuyuruOzet . "") ?>
			</td>
		</tr>
	</table>
</td>
<?php
 }
 // while in bittiği biten yer
?>
</table>
<p>
