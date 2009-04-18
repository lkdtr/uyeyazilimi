<?php 
/* SVN FILE: $Id$ */
/* PaymentsController Test cases generated on: 2009-04-18 12:04:15 : 1240045695*/
App::import('Controller', 'Payments');

class TestPayments extends PaymentsController {
	var $autoRender = false;
}

class PaymentsControllerTest extends CakeTestCase {
	var $Payments = null;

	function setUp() {
		$this->Payments = new TestPayments();
		$this->Payments->constructClasses();
	}

	function testPaymentsControllerInstance() {
		$this->assertTrue(is_a($this->Payments, 'PaymentsController'));
	}

	function tearDown() {
		unset($this->Payments);
	}
}
?>