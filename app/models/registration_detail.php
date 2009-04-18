<?php
class RegistrationDetail extends AppModel {

	var $name = 'RegistrationDetail';
	var $validate = array(
		'registration_year' => array('rule'=>array('minLength',1))
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