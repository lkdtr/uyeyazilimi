<?php

 if(!$_SERVER['PHP_AUTH_USER'])
  die("Sadece dernek üyeleri erişebilir");
 
 // veritabani baglantisi
 require('uye_bilgi_config.inc.php');
 $conn = mysql_connect(HOST, USER, PASS);
 mysql_select_db(DB) or die(mysql_error());
 mysql_query("SET NAMES 'utf8'");

 // uyenin kisisel bilgilerini alalim
 $query = 'SELECT uye_id,uye_ad,uye_soyad,kayit_tarihi,ayrilma_tarihi FROM uyeler WHERE artik_uye_degil = 1 ORDER BY uye_id';
 $result = mysql_query($query);
 $rowno = mysql_num_rows($result);
?>

<html>
 <head>
  <title>Linux Kullanıcıları Derneği'den Ayrılan Üyeler</title>
  <link rel="StyleSheet" href="stil.css" type="text/css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
 </head>
 <body bgcolor="#d6dde7">
  <p>
   <table width="200">
    <tr><td align="left"><img src="/lkd_logo.png"></td><td width="20">&nbsp;</td><td><h1>Ayrılan Üyeler</h1></td></tr>
   </table>
  </p>
  <p>İsimleri kırmızı renkle yazılmış üyeler, dernek kayıtlarına göre aidat borcunu(n tamamını) ödemeden ayrılmış/üyeliği sonlandırılmış üyelerdir.</p>
  <p><blockquote>
  <?php
   while($rowno--)
    {
     $user_info = mysql_fetch_array($result);

     // uyenin toplam odemesi gereken aidat miktarini hesaplayalim
     $query_aidat = "SELECT SUM(miktar) FROM aidat_miktar WHERE yil BETWEEN '". $user_info['kayit_tarihi'] ."' AND '". $user_info['ayrilma_tarihi'] . "'";
     $result_aidat = mysql_query($query_aidat);
     $odenmesi_gereken_aidat = mysql_result($result_aidat,0);
     if ($user_info['kayit_tarihi'] <= 2002)    // 2002 ve oncesinde aidata ek olarak ilk yil dernege giris ucreti aliniyordu
      $odenmesi_gereken_aidat += 5;

     // uyenin aidat odeme toplamini alip, kalan odeme miktarini cikaralim
     $query_aidat = 'SELECT SUM(miktar) FROM odemeler WHERE tur="aidat" AND uye_id = ' . $user_info['uye_id'];
     $result_aidat = mysql_query($query_aidat);
     $odenen_aidat = mysql_result($result_aidat,0);
     $aidat_odemesi = $odenmesi_gereken_aidat - $odenen_aidat;

     if($aidat_odemesi > 0)
      echo "<font color='red'>";
     else
      echo "<font color='black'>";

     echo $user_info['uye_id'] . '. ' . $user_info['uye_ad'] . ' ' . $user_info['uye_soyad'] . ' (' . $user_info['kayit_tarihi'] . '-' . $user_info['ayrilma_tarihi'] . ')';
     echo '</font><br>';
    }
  ?>
  </blockquote></p>
 </body>
</html>
