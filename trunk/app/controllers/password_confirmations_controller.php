<?php
class PasswordConfirmationsController extends AppController {

	var $name = 'PasswordConfirmations';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->PasswordConfirmation->recursive = 0;
		$this->set('passwordConfirmations', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid PasswordConfirmation.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('passwordConfirmation', $this->PasswordConfirmation->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->PasswordConfirmation->create();
			if ($this->PasswordConfirmation->save($this->data)) {
				$this->Session->setFlash(__('The PasswordConfirmation has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The PasswordConfirmation could not be saved. Please, try again.', true));
			}
		}
		$accounts = $this->PasswordConfirmation->Account->find('list');
		$this->set(compact('accounts'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid PasswordConfirmation', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->PasswordConfirmation->save($this->data)) {
				$this->Session->setFlash(__('The PasswordConfirmation has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The PasswordConfirmation could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->PasswordConfirmation->read(null, $id);
		}
		$accounts = $this->PasswordConfirmation->Account->find('list');
		$this->set(compact('accounts'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for PasswordConfirmation', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->PasswordConfirmation->del($id)) {
			$this->Session->setFlash(__('PasswordConfirmation deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>