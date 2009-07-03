<?php
 /*
  myhtpasswdgenerator.php
  Generates htpasswd, htgroup, htaccess files from MySQL tables
   - v0.6 - dfisek, 10/02/2006
   - v1.0 - dfisek, 20/02/2006

  CREATE TABLE `w3` (
   `w3_id` tinyint(3) unsigned NOT NULL auto_increment,
   `w3_isim` varchar(50) NOT NULL default '',
   `w3_www` varchar(40) NOT NULL default '',
   `w3_fs` varchar(40) NOT NULL default '',
   PRIMARY KEY  (`w3_id`)
  );

  CREATE TABLE `w3_erisim` (
   `w3_erisim_id` mediumint(8) unsigned NOT NULL auto_increment,
   `w3_id` tinyint(3) unsigned NOT NULL default '0',
   `uye_id` smallint(5) unsigned NOT NULL default '0',
   PRIMARY KEY  (`w3_erisim_id`),
   KEY `w3_id` (`w3_id`,`uye_id`)
  );
 */


 define('DBHOST', 'localhost');
 define('DBUSERNAME', '******');
 define('DBPASSWORD', '******');
 define('DBNAME', 'uyetakip');
 define('HTETC_DIR','/var/www/etc/');
 define('HTPASSWD_FILE', 'w3.passwd');
 define('HTGROUP_FILE', 'w3.group');
 define('HTACCESS_FILE', '.htaccess');
 define('AUTHNAME', 'LKD Intranet');


 function htpasswd($password) {
   $password = crypt(trim($password),base64_encode(CRYPT_STD_DES)); 
   return $password; 
  }


 // Connect to database
 $dblink = @mysql_pconnect(DBHOST,DBUSERNAME,DBPASSWORD);
 mysql_select_db(DBNAME,$dblink);  

 // Get the user/password list
 $query = "SELECT uyeler.alias,uyeler.password FROM w3_erisim,uyeler WHERE uyeler.uye_id=w3_erisim.uye_id GROUP BY w3_erisim.uye_id";
 $result = mysql_query($query,$dblink);
 $rowno = mysql_num_rows($result);

 // Generate htpasswd file
 $file = fopen(HTETC_DIR . HTPASSWD_FILE, "w");
 while($rowno--) {
   $row = mysql_fetch_assoc($result);
   $htpasswd = htpasswd($row['password']);
   fwrite($file,$row['alias'].":$htpasswd\n");
  }
 fclose($file);

 // Get the w3 list
 $query = "SELECT * FROM w3";
 $result = mysql_query($query,$dblink);
 $rowno = mysql_num_rows($result);

 // Open the htgroup file
 $file = fopen(HTETC_DIR . HTGROUP_FILE, "w");
 
 while($rowno--) {
   $row = mysql_fetch_array($result);
   $line = $row['w3_isim'] . ":";

   // Get the w3 access info for the specific w3
   $query2 = 'SELECT uyeler.alias FROM w3_erisim,uyeler WHERE uyeler.uye_id=w3_erisim.uye_id AND w3_erisim.w3_id=' . $row['w3_id'];
   $result2 = mysql_query($query2,$dblink);
   $rowno2 = mysql_num_rows($result2);

   while($rowno2--) {
     $row2 = mysql_fetch_assoc($result2);
     $line .= ' ' . $row2['alias'];
    }

   fwrite($file, "$line\n");

   // Generate the htaccess file for the specific w3
   $file2 = fopen($row['w3_fs'] . HTACCESS_FILE,"w");
   $line = "AuthType Basic\n";
   $line .= "AuthName \"" . AUTHNAME . " :: " . $row['w3_isim'] . "\"\n";
   $line .= "AuthUserFile " . HTETC_DIR . HTPASSWD_FILE . "\n";
   $line .= "AuthGroupFile " . HTETC_DIR . HTGROUP_FILE . "\n";
   $line .= "Require group " . $row['w3_isim'];
   fwrite($file2, $line);
   fclose($file2);
  }

 fclose($file);
?>
