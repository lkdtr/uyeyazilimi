<?php
class Member extends AppModel {

	var $name = 'Member';
	var $validate = array(
		'uye_no' => array('numeric'),
		'tckimlikno' => array('numeric'),
		'gender' => array('alphanumeric'),
		'date_of_birth' => array('date')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasOne = array(
			'PersonalInformation' => array('className' => 'PersonalInformation',
								'foreignKey' => 'member_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'RegistrationInformation' => array('className' => 'RegistrationInformation',
								'foreignKey' => 'member_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

	var $hasMany = array(
			'Payment' => array('className' => 'Payment',
								'foreignKey' => 'member_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			),
			'Preference' => array('className' => 'Preference',
								'foreignKey' => 'member_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			)
	);

}
?>