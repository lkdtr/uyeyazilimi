<?php
class Member extends AppModel {

	var $name = 'Member';
	var $validate = array(
		'uye_no' => array('numeric'),
		'tckimlikno' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasOne = array(
		'Account' => array(
			'className' => 'Account',
			'foreignKey' => 'member_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'LeaveDetail' => array(
			'className' => 'LeaveDetail',
			'foreignKey' => 'member_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PersonalInformation' => array(
			'className' => 'PersonalInformation',
			'foreignKey' => 'member_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'RegistrationDetail' => array(
			'className' => 'RegistrationDetail',
			'foreignKey' => 'member_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Payment' => array(
			'className' => 'Payment',
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
		'Preference' => array(
			'className' => 'Preference',
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

	var $hasAndBelongsToMany = array(
		'Maillist' => array(
			'className' => 'Maillist',
			'joinTable' => 'maillists_members',
			'foreignKey' => 'member_id',
			'associationForeignKey' => 'maillist_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

}
?>