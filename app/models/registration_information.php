<?php
class RegistrationInformation extends AppModel {

	var $name = 'RegistrationInformation';
	var $validate = array(
		'member_id' => array('numeric'),
		'registration_decision_date' => array('date')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Member' => array('className' => 'Member',
								'foreignKey' => 'member_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>