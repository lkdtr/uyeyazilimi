<?php error_reporting(0); ?>
<html>
<head>
<title>LKD Üye Yazılımı Yönetim Arayüzü</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="StyleSheet" href="css/stil.css" type="text/css">
<link rel="StyleSheet" href="css/anylink.css" type="text/css">
<script type="text/javascript" src="js/anylink.js"></script>
</head>
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" style="border-collapse:collapse ">
  <tr>
   <td><table align="left" border="0" cellpadding="0" cellspacing="0" width="780">
	  <tr>
	   <td><a href="index.php"><img name="index_r1_c1" src="images/index_r1_c1.jpg" width="189" height="118" border="0" alt=""></a></td>
	   <td><a href="index.php"><img name="index_r1_c2" src="images/index_r1_c2.jpg" width="266" height="118" border="0" alt=""></a></td>
	   <td><a href="index.php"><img name="index_r1_c3" src="images/index_r1_c3.jpg" width="325" height="118" border="0" alt=""></a></td>
	  </tr>
	</table></td>
  </tr>
  <tr>
   <td height="1" bgcolor="#FFFFFF">

<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
   <td height="19" bgcolor="#466176">
	<table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0">
     <tr>
       <td width="120"><img src="images/navicon_truncu.gif" width="16" height="9"> <a href="uyelerlist.php?cmd=resetall" class="navbeyaz">Üye Listesi</a></td>
       <td width="160"><img src="images/navicon_truncu.gif" width="16" height="9"> <a href="odemelerlist.php?cmd=resetall" class="navbeyaz">Yapılan Ödemeler</a></td>
       <td width="100"><img src="images/navicon_truncu.gif" width="16" height="9"><a href="#" onMouseOver="dropdownmenu(this, event, 'anylinkmenu1')" class="navbeyaz">Raporlar</a></td>
       <td align="right"><font color="white"><?php echo $_SERVER['PHP_AUTH_USER']; ?></font></td>
     </tr>
   </table>
   <div class="anylinkcss" id="anylinkmenu1">
    <a href="rapor_aidat.php" target="_blank" class="navbeyaz">Aidat Tablosu</a>
    <a href="rapor_haber_alinamayanlar.php" class="navbeyaz">Haber Alınamayanlar</a>
    <a href="rapor_kimlik_fotoistenecek_csv.php" class="navbeyaz">Kimlik Fotoğrafı (Hiç Yok İstenecek) için CSV</a>
    <a href="rapor_kimlik_yenifotoistenecek_csv.php" class="navbeyaz">Kimlik Fotoğrafı (Yenisi İstenecek) için CSV</a>
    <a href="rapor_kimlik_baski_csv.php" class="navbeyaz">Kimlik Baskısı için CSV</a>
    <a href="rapor_kimlik_posta_csv.php" class="navbeyaz">Kimlik Postalanması için CSV</a>
    <a href="rapor_uyedefteri_csv.php" target="_blank" class="navbeyaz">Üye Defteri İçin Aidat Dökümü (CSV)</a>
    <a href="rapor_vpos_odemeleri.php" target="_blank" class="navbeyaz">Kredi Kartı (VPOS) Ödemeleri Dökümü</a>
  </div> 
   </td>
  </tr>
  <tr>
   <td bgcolor="#D6DDE7">
