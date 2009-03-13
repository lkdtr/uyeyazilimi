<?php
 /*
  HTTP dogrulamasi kullanarak giris yapmis bir uyenin bilgilerini uye veritabanindan alarak kendisine gosteren basit bir bilgi sayfasi.
  uyelerview.php ve *odemeler*.php derlemesi.
 */

 function tarih_insancil($tarih)    // veritabanindan gelen tarihi insancil bir hale cevirelim
  {
   setlocale(LC_TIME, 'tr_TR.utf8');
   $tarih_parcalari = explode('-', $tarih);
   return strftime("%e %B %Y", mktime(0, 0, 0, $tarih_parcalari[1], $tarih_parcalari[2], $tarih_parcalari[0]));
  }


 $slug = $_SERVER['PHP_AUTH_USER'];    // kullanici adi
 
 // veritabani baglantisi
 require('db.php');
 $conn = mysql_connect(HOST, USER, PASS);
 mysql_select_db(DB) or die(mysql_error());
 mysql_query("SET NAMES 'utf8'");

 // uyenin kisisel bilgilerini alalim
 $query = 'SELECT * FROM uyeler WHERE alias = "' . $slug . '@linux.org.tr"';
 $result = mysql_query($query);
 $user_info = mysql_fetch_array($result);

 // uyenin toplam odemesi gereken aidat miktarini hesaplayalim
 $query = 'SELECT SUM(miktar) FROM aidat_miktar WHERE yil >= '. $user_info['kayit_tarihi'];
 $result = mysql_query($query);
 $odenmesi_gereken_aidat = mysql_result($result,0);
 if ($user_info['kayit_tarihi'] <= 2002)    // 2002 ve oncesinde aidata ek olarak ilk yil dernege giris ucreti aliniyordu
  $odenmesi_gereken_aidat += 5;

 // uyenin aidat odeme toplamini alip, kalan odeme miktarini cikaralim
 $query = 'SELECT SUM(miktar) FROM odemeler WHERE tur="aidat" AND uye_id = ' . $user_info['uye_id'];
 $result = mysql_query($query);
 $odenen_aidat = mysql_result($result,0);
 $aidat_odemesi = $odenmesi_gereken_aidat - $odenen_aidat;

 // uyenin yaptigi odemelerin listesini alalim
 $query = 'SELECT * FROM odemeler WHERE tur="aidat" AND uye_id = ' . $user_info['uye_id'] . ' ORDER BY tarih DESC';
 $odeme_tablosu = mysql_query($query);
 $odeme_sayisi = mysql_num_rows($odeme_tablosu);
?>

<html>
 <head>
  <title><?php echo $user_info['uye_ad'] . ' ' . $user_info['uye_soyad'] ?> .:. LKD Uye Bilgi Sayfasi</title>
  <link rel="StyleSheet" href="stil.css" type="text/css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
 </head>
 <body bgcolor="#d6dde7">
  <p><table><tr><td align="left"><img src="/lkd_logo.png"></td><td width="20">&nbsp;</td><td><h1>Uye Bilgi Sayfasi</h1></td></tr></table></p>
  <p>Dernek üyesi olarak bilgilerinizi asagida bulabilirsiniz. Bu bilgilerden degistirmek istedikleriniz olursa ya da hatali bir bilgi bulundugunu dusunuyorsaniz, lutfen <a href="mailto:uye@lkd.org.tr">uye@lkd.org.tr</a> adresinden dernek uye isleri ekibi ile baglantiya geciniz.</p>

  <!-- Uyenin Kendi Bilgilerini Gosterelim -->
  <table width="350">
   <tr>
    <td bgcolor="#466176"><font color="#FFFFFF">Uye Numarasi&nbsp;</td>
    <td bgcolor="#F5F5F5"><?php echo $user_info['uye_id']; ?>&nbsp;</td>
   </tr>
   <tr>
    <td bgcolor="#466176"><font color="#FFFFFF">Ad Soyad&nbsp;</td>
    <td bgcolor="#F5F5F5"><?php echo $user_info['uye_ad'] . ' ' . $user_info['uye_soyad']; ?>&nbsp;</td>
   </tr>
   <tr>
    <td bgcolor="#466176"><font color="#FFFFFF">E-posta Adresi&nbsp;</td>
    <td bgcolor="#F5F5F5"><?php echo $user_info['eposta1']; ?>&nbsp;</td>
   </tr>
   <tr>
    <td bgcolor="#466176"><font color="#FFFFFF">Uye Olma Yili&nbsp;</td>
    <td bgcolor="#F5F5F5"><?php echo $user_info['kayit_tarihi']; ?>&nbsp;</td>
   </tr>
   <tr>
    <td bgcolor="#466176"><font color="#FFFFFF">Gönüllü Çalışmalar&nbsp;</td>
    <?php
     echo "<td bgcolor=\"#F5F5F5\">";
     if( $user_info['gonullu'] == 1 )
      echo "Katıl";
     else
      echo "Katılma";
     echo "&nbsp;</td>";
    ?>
   </tr>
   <tr>
    <td bgcolor="#466176"><font color="#FFFFFF">Elektronik Oylamalar&nbsp;</td>
    <?php
     echo "<td bgcolor=\"#F5F5F5\">";
     if( $user_info['oylama'] == 1 )
      echo "Katıl";
     else
      echo "Katılma";
     echo "&nbsp;</td>";
    ?>
   </tr>
   <tr>
    <td bgcolor="#466176"><font color="#FFFFFF">LKD Üye E-posta Listesi&nbsp;</td>
    <?php
     echo "<td bgcolor=\"#F5F5F5\">";
     if( $user_info['liste_uyeligi'] == 1 )
      echo "Üye";
     else
      echo "Üye Değil";
     echo "&nbsp;</td>";
    ?>
   </tr>
   <tr>
    <td bgcolor="#466176"><font color="#FFFFFF">Aidat Odemesi&nbsp;</td>
    <?php
     echo "<td bgcolor=\"#F5F5F5\">";
     if( $aidat_odemesi > 0 )
      echo $aidat_odemesi . ' TL';
     else
      echo "Yok";
     echo "&nbsp;</td>";
    ?>
   </tr>
  </table>

  <p>&nbsp;</p>

  <!-- Uyenin Aidat Odeme Detaylarini Gosterelim -->
<?php
  if($odeme_sayisi > 0)
   {
?>
    <p><a href="#">Aidat Odeme Detaylariniz</a></p>
    <table width="120" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
     <tr bgcolor="#466176">
      <td><font color="#FFFFFF">Odeme Tarihi</font></td>
      <td><font color="#FFFFFF">Miktar</font></td>
     </tr>
<?php
     while($odeme_sayisi--)
      {
       $odeme = mysql_fetch_array($odeme_tablosu);
?>
       <tr bgcolor="#F5F5F5">
        <td><?php echo tarih_insancil($odeme['tarih']); ?></td>
        <td><?php echo $odeme['miktar'] . ' TL'; ?></td>
       </tr>
<?php
      }
?>
    </table>
<?php
   }

 mysql_close($conn);
?>
 </body>
</html>
