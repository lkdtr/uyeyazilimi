<?php
class PersonalInformationsController extends AppController {

	var $name = 'PersonalInformations';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->PersonalInformation->recursive = 0;
		$this->set('personalInformations', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid PersonalInformation.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('personalInformation', $this->PersonalInformation->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->PersonalInformation->create();
			if ($this->PersonalInformation->save($this->data)) {
				$this->Session->setFlash(__('The PersonalInformation has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The PersonalInformation could not be saved. Please, try again.', true));
			}
		}
		$members = $this->PersonalInformation->Member->find('list');
		$this->set(compact('members'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid PersonalInformation', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->PersonalInformation->save($this->data)) {
				$this->Session->setFlash(__('The PersonalInformation has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The PersonalInformation could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->PersonalInformation->read(null, $id);
		}
		$members = $this->PersonalInformation->Member->find('list');
		$this->set(compact('members'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for PersonalInformation', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->PersonalInformation->del($id)) {
			$this->Session->setFlash(__('PersonalInformation deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>