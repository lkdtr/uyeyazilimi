<?php
 require ('idarialias_config.inc.php');
 
 $dblink = mysql_connect(HOST, USERNAME, PASSWORD) or die('Veritabanına bağlanamadım');
 mysql_select_db(DATABASE) or die('Veritabanını seçemedim');

 if($_POST[destination] && $_POST[source])
  {
   $query = "UPDATE forwardings SET destination = \"$_POST[destination]\" WHERE source = \"$_POST[source]\"";
   $result = mysql_query($query);
  }

 header("Location: idarialias.php");
?>
