<?php
// @ilk baslangic icin ..
@rename('_.htaccess','.htaccess');
@rename('./app/_.htaccess','./app/.htaccess');
@rename('./app/webroot/_.htaccess','./app/webroot/.htaccess');
@rename('./cake/console/libs/templates/skel/_.htaccess','./cake/console/libs/templates/skel/.htaccess');
@rename('./cake/console/libs/templates/skel/webroot/_.htaccess','./cake/console/libs/templates/skel/webroot/.htaccess');
echo "<h2>Islemler yapilmistir!</h2>";
?>