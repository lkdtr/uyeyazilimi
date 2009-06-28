<?php

header("Content-type: image/jpeg");

 $slug = $_SERVER['PHP_AUTH_USER'];    // kullanici adi
 
 // veritabani baglantisi
 require('uye_bilgi_config.inc.php');
 $conn = mysql_connect(HOST, USER, PASS);
 
 mysql_select_db(DB) or die(mysql_error());
 mysql_query("SET NAMES 'utf8'");

 // uyenin kisisel bilgilerini alalim
 $query = 'SELECT uye_id FROM uyeler WHERE alias = "' . $slug . '@linux.org.tr"';
 $result = mysql_query($query);
 $user_info = mysql_fetch_row($result);

 // veritabanindan alacagimizi aldik
 mysql_close($conn);

$im = file_get_contents(IMGDIR . '/' . $user_info[0]. '.jpg');
echo $im;
?>

