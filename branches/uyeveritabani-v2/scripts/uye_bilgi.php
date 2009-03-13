<?php
 /*
  HTTP dogrulamasi kullanarak giris yapmis bir uyenin bilgilerini uye veritabanindan alarak kendisine gosteren basit bir bilgi sayfasi.
  uyelerview.php ve *odemeler*.php derlemesi. toggleLayer javascript fonksiyonu netlobo.com'dan alinma.
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

 // uyenin yapmasi gereken odemelerin listesini alalim
 $query = 'SELECT * FROM aidat_miktar WHERE yil >= ' . $user_info['kayit_tarihi'] . ' ORDER BY yil DESC';
 $aidat_miktar_tablosu = mysql_query($query);
 $aidat_miktar_sayisi = mysql_num_rows($aidat_miktar_tablosu);

 // veritabanindan alacagimizi aldik
 mysql_close($conn);
?>

<html>
 <head>
  <title><?php echo $user_info['uye_ad'] . ' ' . $user_info['uye_soyad'] ?> .:. LKD Üye Bilgi Sayfası</title>
  <link rel="StyleSheet" href="stil.css" type="text/css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <script type="text/javascript">
   function toggleLayer( whichLayer )
    {
     var elem, vis;

     if( document.getElementById ) // this is the way the standards work
      elem = document.getElementById( whichLayer );
     else if( document.all ) // this is the way old msie versions work
      elem = document.all[whichLayer];
     else if( document.layers ) // this is the way nn4 works
      elem = document.layers[whichLayer];
     vis = elem.style;

     // if the style.display value is blank we try to figure it out here
     if(vis.display==''&&elem.offsetWidth!=undefined&&elem.offsetHeight!=undefined)
      vis.display = (elem.offsetWidth!=0&&elem.offsetHeight!=0)?'block':'none';
     vis.display = (vis.display==''||vis.display=='block')?'none':'block';
    }
  </script>
 </head>
 <body bgcolor="#d6dde7">
  <p><table><tr><td align="left"><img src="/lkd_logo.png"></td><td width="20">&nbsp;</td><td><h1>Üye Bilgi Sayfası</h1></td></tr></table></p>

  <!-- Uyenin Kendi Bilgilerini Gosterelim -->
  <table width="350">
   <tr><td colspan="2"><p align="justify">Dernek üyesi olarak bilgilerinizi aşağıda bulabilirsiniz. Bu bilgilerden değiştirmek istedikleriniz olursa ya da hatalı bir bilgi bulunduğunu düşünüyorsanız, lütfen <a href="mailto:uye@lkd.org.tr">uye@lkd.org.tr</a> adresinden dernek üye işleri ekibi ile bağlantıya geçiniz.<br>&nbsp;</p></td></tr>
   <tr>
    <td bgcolor="#466176"><font color="#FFFFFF">Üye Numarası&nbsp;</td>
    <td bgcolor="#F5F5F5"><?php echo $user_info['uye_id']; ?>&nbsp;</td>
   </tr>
   <tr>
    <td bgcolor="#466176"><font color="#FFFFFF">Adı Soyadı&nbsp;</td>
    <td bgcolor="#F5F5F5"><?php echo $user_info['uye_ad'] . ' ' . $user_info['uye_soyad']; ?>&nbsp;</td>
   </tr>
   <tr>
    <td bgcolor="#466176"><font color="#FFFFFF">E-posta Adresi&nbsp;</td>
    <td bgcolor="#F5F5F5"><?php echo $user_info['eposta1']; ?>&nbsp;</td>
   </tr>
   <tr>
    <td bgcolor="#466176"><font color="#FFFFFF">Üye Olma Yılı&nbsp;</td>
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
    <td bgcolor="#466176"><font color="#FFFFFF">Aidat Ödemesi&nbsp;</td>
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

  <p><a href="javascript:toggleLayer('OdemeDetaylari')">Aidat Ödeme Detaylarınız</a></p>
  <p>&nbsp;</p>
  <div style="display: none;" id="OdemeDetaylari">
  <!-- Uyenin Aidat Odeme Detaylarini Gosterelim -->
<?php
   if($odeme_sayisi > 0)
    {
?>
     <table width="120" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
      <tr bgcolor="#466176">
       <td><font color="#FFFFFF">Ödeme Tarihi</font></td>
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
   else
    {
?>
     <h2>Henüz hiç aidat ödemesi yapmamışsınız.</h2>
<?php
    }
?>

   <p>&nbsp;</p>

   <p><a href="javascript:toggleLayer('YillaraGoreAidatDagilimi')">Yıllara Göre Aidat Dağılımı</a></p>
   <p>&nbsp;</p>
   <div style="display: none;" id="YillaraGoreAidatDagilimi">
    <table width="120" border="0" cellspacing="1" cellpadding="4" bgcolor="#CCCCCC">
     <tr bgcolor="#466176">
      <td align="center"><font color="#FFFFFF">Yıl</font></td>
      <td><font color="#FFFFFF">Aidat</font></td>
     </tr>
<?php
     while($aidat_miktar_sayisi--)
      {
       $aidat_miktar = mysql_fetch_array($aidat_miktar_tablosu);
?>
       <tr bgcolor="#F5F5F5">
        <td align="center"><?php echo $aidat_miktar['yil']; ?></td>
        <td><?php echo $aidat_miktar['miktar'] . ' TL'; ?></td>
       </tr>
<?php
      }
     if($user_info['kayit_tarihi'] <= 2002)    // giris aidati da alinmali
      {
?>
       <tr bgcolor="#F5F5F5">
        <td align="center">Giriş Aidatı</td>
        <td>5 TL</td>
       </tr>
<?php
      }
?>
    </table>
   </div>
  </div>
 </body>
</html>
