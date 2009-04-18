<?php
class PersonalInformation extends AppModel {

	var $name = 'PersonalInformation';
	var $table="personal_information";
	var $useTable="personal_information";
	var $validate = array(
		'email' => array('email'),
		'lotr_fwd_email' => array('email')
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