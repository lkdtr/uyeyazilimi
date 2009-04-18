<?php
class RegistrationDetailsController extends AppController {

	var $name = 'RegistrationDetails';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->RegistrationDetail->recursive = 0;
		$this->set('registrationDetails', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid RegistrationDetail.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('registrationDetail', $this->RegistrationDetail->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->RegistrationDetail->create();
			if ($this->RegistrationDetail->save($this->data)) {
				$this->Session->setFlash(__('The RegistrationDetail has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The RegistrationDetail could not be saved. Please, try again.', true));
			}
		}
		$members = $this->RegistrationDetail->Member->find('list');
		$this->set(compact('members'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid RegistrationDetail', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->RegistrationDetail->save($this->data)) {
				$this->Session->setFlash(__('The RegistrationDetail has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The RegistrationDetail could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->RegistrationDetail->read(null, $id);
		}
		$members = $this->RegistrationDetail->Member->find('list');
		$this->set(compact('members'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for RegistrationDetail', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->RegistrationDetail->del($id)) {
			$this->Session->setFlash(__('RegistrationDetail deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>