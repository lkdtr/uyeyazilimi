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


// yarismalari alalim
	$yarismalar = new category(array(
		'table' => 'yarismalar',
		'id'    => 'anahtar',
		'name'  => 'adi'
	));

// yarismayi belirleyelim
	$YNo = trim($_GET[yarisma], '/');
	if( !$YNo ) $YNo = $_SESSION[yarismaNo];
	if( $YNo ){
		$Y   = $db->get(array('table'=>'yarismalar', 'where'=>array('no'=>$YNo)));
		$YNo = $Y[no];
	}
	// varsayilan yarismayi yukleyelim
	if( !$Y ){
		$YNo = $varsayilanYarismaNo;
		$Y   = $db->get(array('table'=>'yarismalar', 'where'=>array('no'=>$YNo)));
	}



?>
