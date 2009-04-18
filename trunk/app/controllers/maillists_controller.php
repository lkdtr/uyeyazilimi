<?php
class MaillistsController extends AppController {

	var $name = 'Maillists';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Maillist->recursive = 0;
		$this->set('maillists', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Maillist.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('maillist', $this->Maillist->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Maillist->create();
			if ($this->Maillist->save($this->data)) {
				$this->Session->setFlash(__('The Maillist has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Maillist could not be saved. Please, try again.', true));
			}
		}
		$members = $this->Maillist->Member->find('list');
		$this->set(compact('members'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Maillist', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Maillist->save($this->data)) {
				$this->Session->setFlash(__('The Maillist has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Maillist could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Maillist->read(null, $id);
		}
		$members = $this->Maillist->Member->find('list');
		$this->set(compact('members'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Maillist', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Maillist->del($id)) {
			$this->Session->setFlash(__('Maillist deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>