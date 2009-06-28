<?php

header("Content-type: image/jpeg");

 $slug = $_SERVER['PHP_AUTH_USER'];    // kullanici adi
 
 // veritabani baglantisi
 require('uye_bilgi_config.inc.php');
 $conn = mysql_connect(HOST, USER, PASS);
 
 mysql_select_db(DB) or die(mysql_error());
 mysql_query("SET NAMES 'utf8'");

 // uyenin kisisel bilgilerini alalim
 $query = 'SELECT Resim FROM uyeler WHERE alias = "' . $slug . '@linux.org.tr"';
 $result = mysql_query($query);
 $img_result = mysql_fetch_row($result);

 // veritabanindan alacagimizi aldik
 mysql_close($conn);

 if( $img_result[0] == Null ) {
     $img_filename = "0.jpg";
 }
 else {
     $img_filename = $img_result[0];
 }

$im = file_get_contents(IMGDIR . '/' . $img_filename);
echo $im;
?>

