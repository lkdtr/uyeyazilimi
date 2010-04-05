<?php
class Member extends AppModel {

	var $name = 'Member';
	var $validate = array(
		'uye_no' => array('numeric'),
		'tckimlikno' => array('numeric'),
		'gender' => array('alphanumeric'),
		'date_of_birth' => array('date')
	);
}
?>
