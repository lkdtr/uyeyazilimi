<?php 
/* SVN FILE: $Id$ */
/* RegistrationDetailsController Test cases generated on: 2009-04-18 12:04:58 : 1240045738*/
App::import('Controller', 'RegistrationDetails');

class TestRegistrationDetails extends RegistrationDetailsController {
	var $autoRender = false;
}

class RegistrationDetailsControllerTest extends CakeTestCase {
	var $RegistrationDetails = null;

	function setUp() {
		$this->RegistrationDetails = new TestRegistrationDetails();
		$this->RegistrationDetails->constructClasses();
	}

	function testRegistrationDetailsControllerInstance() {
		$this->assertTrue(is_a($this->RegistrationDetails, 'RegistrationDetailsController'));
	}

	function tearDown() {
		unset($this->RegistrationDetails);
	}
}
?>