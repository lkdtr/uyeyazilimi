<?php
class Account extends AppModel {

	var $name = 'Account';
	var $validate = array(
		'active' => array('boolean')
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

	var $hasMany = array(
		'PasswordConfirmation' => array(
			'className' => 'PasswordConfirmation',
			'foreignKey' => 'account_id',
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
	
	function toggleAccount($id){
		//account disable edilmesi sırasında yapılması gereken başka işler varsa burda yapılabilir.
		return $this->toggleBoolean('active',$id);
	}

}
?>