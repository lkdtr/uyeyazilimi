<?php
class MembershipFeesController extends AppController {

	var $name = 'MembershipFees';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->MembershipFee->recursive = 0;
		$this->set('membershipFees', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid MembershipFee.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('membershipFee', $this->MembershipFee->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->MembershipFee->create();
			if ($this->MembershipFee->save($this->data)) {
				$this->Session->setFlash(__('The MembershipFee has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The MembershipFee could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid MembershipFee', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->MembershipFee->save($this->data)) {
				$this->Session->setFlash(__('The MembershipFee has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The MembershipFee could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->MembershipFee->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for MembershipFee', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->MembershipFee->del($id)) {
			$this->Session->setFlash(__('MembershipFee deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>