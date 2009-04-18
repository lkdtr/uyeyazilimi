<?php 
/* SVN FILE: $Id$ */
/* PersonalInformationsController Test cases generated on: 2009-04-18 12:04:35 : 1240045715*/
App::import('Controller', 'PersonalInformations');

class TestPersonalInformations extends PersonalInformationsController {
	var $autoRender = false;
}

class PersonalInformationsControllerTest extends CakeTestCase {
	var $PersonalInformations = null;

	function setUp() {
		$this->PersonalInformations = new TestPersonalInformations();
		$this->PersonalInformations->constructClasses();
	}

	function testPersonalInformationsControllerInstance() {
		$this->assertTrue(is_a($this->PersonalInformations, 'PersonalInformationsController'));
	}

	function tearDown() {
		unset($this->PersonalInformations);
	}
}
?>