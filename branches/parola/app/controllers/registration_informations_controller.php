<?php
class RegistrationInformationsController extends AppController {

	var $name = 'RegistrationInformations';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->RegistrationInformation->recursive = 0;
		$this->set('registrationInformations', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid RegistrationInformation.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('registrationInformation', $this->RegistrationInformation->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->RegistrationInformation->create();
			if ($this->RegistrationInformation->save($this->data)) {
				$this->Session->setFlash(__('The RegistrationInformation has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The RegistrationInformation could not be saved. Please, try again.', true));
			}
		}
		$members = $this->RegistrationInformation->Member->find('list');
		$this->set(compact('members'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid RegistrationInformation', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->RegistrationInformation->save($this->data)) {
				$this->Session->setFlash(__('The RegistrationInformation has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The RegistrationInformation could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->RegistrationInformation->read(null, $id);
		}
		$members = $this->RegistrationInformation->Member->find('list');
		$this->set(compact('members'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for RegistrationInformation', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->RegistrationInformation->del($id)) {
			$this->Session->setFlash(__('RegistrationInformation deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>