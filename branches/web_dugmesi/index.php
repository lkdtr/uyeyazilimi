<?php
 // HTTP dogrulamasindan gelen login bilgisine gore uyenin numarasini bulalim
 require ('config.inc.php');
 $conn = mysql_connect(HOST, USER, PASS);
 mysql_select_db(DB_PWD) or die(mysql_error());

 $query = 'SELECT uye_no FROM members WHERE lotr_alias = "' . $_SERVER['PHP_AUTH_USER'] . '"';
 $result = mysql_query($query);
 $uye_id = mysql_result($result,0);

 mysql_close($conn);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="tr" lang="tr">
<head>
    <title><?php echo $uye_id; ?> Numarali LKD Uyesi icin Web Dugmeleri</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <style type="text/css" media="screen">@import "css/screen.css";</style>
    <style type="text/css" media="screen">
        p{
            padding:5px;
         }
    </style>
</head>
<body>

<div id="wrapper">
	<div id="header"><img src="img/lkd-header.jpg" width="860" height="100" alt="Lkd Header"></div>
	<div class="mleft">
<?php
        for ($i = 0; $i <= 4; $i++)
            echo '<p><img src="yaz.php?secim=' . $i . '&uyeno=' . $uye_id . '"></p>';
?>
	</div>
	<div id="footer">LKD 2009</div>
</div>
