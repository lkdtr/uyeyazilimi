<?php
class Payment extends AppModel {

	var $name = 'Payment';
	var $validate = array(
		'amount' => array('numeric'),
		'payment_date' => array('date')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Member' => array(
			'className' => 'Member',
			'foreignKey' => 'member_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>