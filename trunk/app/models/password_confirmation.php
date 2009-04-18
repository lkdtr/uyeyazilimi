<?php
class PasswordConfirmation extends AppModel {

	var $name = 'PasswordConfirmation';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Account' => array('className' => 'Account',
								'foreignKey' => 'account_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);
	
	/**
	 * password_confirmations tablosunda 48 saatten fazla süredir bekleyen verileri silme işlemi yapılır.
	 * 
	 */
	function cleanup(){
		$this->deleteAll(array('PasswordConfirmation.created <'=>date("Y-m-d h:i:s",strtotime("-2 day"))),false);
	}
	
	function newHash($account_id){
		$this->cleanup();
		$hash = md5(time().$account_id); //time ve id için hash oluştur.
		$newConfirmation['PasswordConfirmation']['hash'] = $hash;
		$newConfirmation['PasswordConfirmation']['account_id'] = $account_id;
		$this->create();
		$this->save($newConfirmation);
		return $hash;
	}
	
	function checkAndDelete($hash){
		$this->cleanup();
		$found=$this->find('first',array('conditions'=>array('PasswordConfirmation.hash'=>$hash,
														'PasswordConfirmation.created >='=>date("Y-m-d h:i:s",strtotime("-2 day"))
													)));
		if($found){
			$this->del($found['PasswordConfirmation']['id']);
			return $found['PasswordConfirmation']['account_id'];
		}
		else return false;
	}

}
?>