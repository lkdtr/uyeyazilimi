<?php 
/* SVN FILE: $Id$ */
/* PersonalInformationsController Test cases generated on: 2008-09-26 00:09:05 : 1222376765*/
App::import('Controller', 'PersonalInformations');

class TestPersonalInformations extends PersonalInformationsController {
	var $autoRender = false;
}

class PersonalInformationsControllerTest extends CakeTestCase {
	var $PersonalInformations = null;

	function setUp() {
		$this->PersonalInformations = new TestPersonalInformations();
	}

	function testPersonalInformationsControllerInstance() {
		$this->assertTrue(is_a($this->PersonalInformations, 'PersonalInformationsController'));
	}

	function tearDown() {
		unset($this->PersonalInformations);
	}
}
?>