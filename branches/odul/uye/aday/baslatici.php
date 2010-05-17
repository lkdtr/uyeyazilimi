<?php

require('ayarlar.inc.php');

/***** BU NOKTADAN SONRASINA DOKUNMAYIN! *****/

session_start();

// congif
	$C[PATH] = $C[PATH_PREFIX].'lib/Congif/';
	require_once($C[PATH].'/start.php');
	// loading modules
	congif('error', 'db', 'category', 'form');
	utility('moduleLoader', 'XSS');


// hata sınıfı
	$Error = new error(array(
		'setupOnly' => true,
		'template'  => array(
			'label' => 'Hata'
		),
	));
	$C[errorObject] = $Error;


// database access
	$db = new db($dsn);
	$C[dbObject] = $db;


?>
