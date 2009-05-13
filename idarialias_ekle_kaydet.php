<?php
 require ('idarialias_config.inc.php');
 
 $dblink = mysql_connect(HOST, USERNAME, PASSWORD) or die('Veritabanına bağlanamadım');
 mysql_select_db(DATABASE) or die('Veritabanını seçemedim');

 if($_POST[destination] && $_POST[source])
  {
   $query = 'INSERT INTO forwardings VALUES("' . $_POST[source] . '","' . $_POST[destination] . '")';
   $result = mysql_query($query) or die($query);
  }

 header("Location: idarialias.php");
?>
