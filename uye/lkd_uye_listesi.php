<?php

 if(!$_SERVER['PHP_AUTH_USER'])
  die("Sadece dernek üyeleri erişebilir");
 
 // veritabani baglantisi
 require('uye_bilgi_config.inc.php');
 $conn = mysql_connect(HOST, USER, PASS);
 mysql_select_db(DB) or die(mysql_error());
 mysql_query("SET NAMES 'utf8'");

 // uyenin kisisel bilgilerini alalim
 $query = 'SELECT uye_id,uye_ad,uye_soyad,sehir,kimlik_gizli,haber_alinamiyor FROM uyeler WHERE artik_uye_degil = 0 ORDER BY uye_id';
 $result = mysql_query($query);
 $rowno = mysql_num_rows($result);

 // veritabanindan alacagimizi aldik
 mysql_close($conn);
?>

<html>
 <head>
  <title>Linux Kullanıcıları Derneği Üyeleri</title>
  <link rel="StyleSheet" href="stil.css" type="text/css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
 </head>
 <body bgcolor="#d6dde7">
  <p>
   <table width="200">
    <tr><td align="left"><img src="/lkd_logo.png"></td><td width="20">&nbsp;</td><td><h1>Üyeler</h1></td></tr>
   </table>
  </p>
  <p>İsimleri mavi renkle yazılmış üyeler, kendilerinden bir yılı aşkın süredir haber alınamayan dernek üyeleridir. Eğer kendilerini tanıyorsanız, lütfen uye@lkd.org.tr adresiyle bağlantıya geçmelerini rica ediniz.</p>
  <p>Üyelerin yaşadıkları şehirler, kendilerinin son beyanlarıdır, güncelliğini yitirmiş olmaları mümkündür. Kendi yaşadığınız şehri <a href="uye_bilgi.php">üye bilgi sayfası</a>ndan düzenleyebilirsiniz.</p>
  <p>İsminin gizli kalmasını tercih eden üyeler; <a href="uye_bilgi.php">üye bilgi sayfası</a>nda "kimliğimin gizli kalmasını istiyorum" seçeneğini işaretleyebilirler.</p>
  <p><blockquote>
  <?php
    echo "Toplam üye sayımız $rowno";
    while($rowno--)
    {
     $user_info = mysql_fetch_array($result);
     echo $user_info['uye_id'] . '. ';
     if($user_info['kimlik_gizli'])
      echo 'Kimliğinin Gizli Kalmasını İstiyor';
     else
      {
       if($user_info['haber_alinamiyor'])
        echo '<font color="blue">';
       else
        echo '<font color="black">';
       echo $user_info['uye_ad'] . ' ' . $user_info['uye_soyad'];
       if($user_info['sehir'])
        echo ' (' . $user_info['sehir'] . ')';
       echo '</font>';
      }
     echo '<br>';
    }
  ?>
  </blockquote></p>
 </body>
</html>
