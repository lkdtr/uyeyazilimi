<?php
class LeaveDetailsController extends AppController {

	var $name = 'LeaveDetails';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->LeaveDetail->recursive = 0;
		$this->set('leaveDetails', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid LeaveDetail.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('leaveDetail', $this->LeaveDetail->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->LeaveDetail->create();
			if ($this->LeaveDetail->save($this->data)) {
				$this->Session->setFlash(__('The LeaveDetail has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The LeaveDetail could not be saved. Please, try again.', true));
			}
		}
		$members = $this->LeaveDetail->Member->find('list');
		$this->set(compact('members'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid LeaveDetail', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->LeaveDetail->save($this->data)) {
				$this->Session->setFlash(__('The LeaveDetail has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The LeaveDetail could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->LeaveDetail->read(null, $id);
		}
		$members = $this->LeaveDetail->Member->find('list');
		$this->set(compact('members'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for LeaveDetail', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->LeaveDetail->del($id)) {
			$this->Session->setFlash(__('LeaveDetail deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>