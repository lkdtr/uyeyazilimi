<?php

function getMember($memberAlias) {

///////////////////////////////////////////////////////////////////

$dbhost = "localhost";
$dbuname = "cici_user";
$dbpass = "ZnHyvtmZfK2bcwCm";
$dbname = "lkd_uye";

mysql_connect("$dbhost", "$dbuname", "$dbpass");
mysql_select_db("$dbname");
mysql_query("SET NAMES 'utf8';");

///////////////////////////////////////////////////////////////////

$infoArray = mysql_fetch_array(mysql_query("SELECT `uye_no`, `name`, `lastname` FROM members 
WHERE lotr_alias = '$memberAlias' "));

$memberInfo['name'] = $infoArray['name']." ".$infoArray['lastname'];
$memberInfo['uye_no'] = $infoArray['uye_no'];

return $memberInfo;
}

?>
