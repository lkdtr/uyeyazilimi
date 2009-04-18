<?php
class MembersController extends AppController {

	var $name = 'Members';
	var $helpers = array('Html', 'Form','Javascript','Ajax');
	var $components = array('RequestHandler');

	function index() {
		$this->Member->recursive = 0;
		$this->set('members', $this->paginate());
	}

	function search() {
		if($this->RequestHandler->isAjax()){
			$this->Member->Behaviors->attach('Containable');
			$this->Member->contain();
			$this->set('members', $this->Member->find('all', array(
						'conditions' => array(
							'OR'=>array(
								'Member.name LIKE'=> "%{$this->data['Member']['search_detail']}%",
								'Member.lastname LIKE'=> "%{$this->data['Member']['search_detail']}%",
								//'Member.email LIKE'=> $this->data['Member']['search_detail'],
								//'Account.lotr_alias LIKE'=> "%{$this->data['Member']['search_detail']}%",
								'Member.uye_no'=> $this->data['Member']['search_detail'],
							)
						)
			)));
			$this->layout = 'ajax';
		}
		else{
			if(!empty($this->data)){
				$this->Member->find('first',array('conditions'=>array('Member.id'=>$this->data['Member']['search_detail'])));
			}
		}
	}
	
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Member.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('member', $this->Member->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Member->create();
			$this->data['Account']['password']=md5($this->__generatePassword());
			$this->data['Account']['active']=true;
			$this->data['RegistrationDetail']['registration_year']=$this->data['RegistrationDetail']['registration_year']['year'];
			$this->data['PersonalInformation']['latest_year_graduated']=$this->data['PersonalInformation']['latest_year_graduated']['year'];
			if ($this->Member->saveAll($this->data,array('validate'=>'first'))) {
				$this->Session->setFlash(__('The Member has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Member could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Member', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Member->save($this->data)) {
				$this->Session->setFlash(__('The Member has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Member could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->Member->recursive=-1;
			$this->data = $this->Member->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Member', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Member->del($id)) {
			$this->Session->setFlash(__('Member deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	
	function __generatePassword($length=9, $strength=4) {
	    $vowels = 'aeuy';
	    $consonants = 'bdghjmnpqrstvz';
	    if ($strength & 1) {
		    $consonants .= 'BDGHJLMNPQRSTVWXZ';
	    }
	    if ($strength & 2) {
		    $vowels .= "AEUY";
	    }
	    if ($strength & 4) {
		    $consonants .= '23456789';
	    }
	    if ($strength & 8) {
		    $consonants .= '@#$%';
	    }
	
	    $password = '';
	    $alt = time() % 2;
	    for ($i = 0; $i < $length; $i++) {
		    if ($alt == 1) {
		        $password .= $consonants[(rand() % strlen($consonants))];
		        $alt = 0;
		    } else {
		        $password .= $vowels[(rand() % strlen($vowels))];
		        $alt = 1;
		    }
	    }
	    return $password;
	}
}
?>