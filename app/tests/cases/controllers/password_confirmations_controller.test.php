<?php 
/* SVN FILE: $Id$ */
/* PasswordConfirmationsController Test cases generated on: 2009-04-18 12:04:28 : 1240045648*/
App::import('Controller', 'PasswordConfirmations');

class TestPasswordConfirmations extends PasswordConfirmationsController {
	var $autoRender = false;
}

class PasswordConfirmationsControllerTest extends CakeTestCase {
	var $PasswordConfirmations = null;

	function setUp() {
		$this->PasswordConfirmations = new TestPasswordConfirmations();
		$this->PasswordConfirmations->constructClasses();
	}

	function testPasswordConfirmationsControllerInstance() {
		$this->assertTrue(is_a($this->PasswordConfirmations, 'PasswordConfirmationsController'));
	}

	function tearDown() {
		unset($this->PasswordConfirmations);
	}
}
?>