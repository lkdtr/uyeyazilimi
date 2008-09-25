<?php 
/* SVN FILE: $Id$ */
/* RegistrationInformationsController Test cases generated on: 2008-09-26 00:09:59 : 1222376579*/
App::import('Controller', 'RegistrationInformations');

class TestRegistrationInformations extends RegistrationInformationsController {
	var $autoRender = false;
}

class RegistrationInformationsControllerTest extends CakeTestCase {
	var $RegistrationInformations = null;

	function setUp() {
		$this->RegistrationInformations = new TestRegistrationInformations();
	}

	function testRegistrationInformationsControllerInstance() {
		$this->assertTrue(is_a($this->RegistrationInformations, 'RegistrationInformationsController'));
	}

	function tearDown() {
		unset($this->RegistrationInformations);
	}
}
?>