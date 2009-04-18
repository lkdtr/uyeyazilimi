<?php 
/* SVN FILE: $Id$ */
/* MaillistsController Test cases generated on: 2009-04-18 12:04:51 : 1240045611*/
App::import('Controller', 'Maillists');

class TestMaillists extends MaillistsController {
	var $autoRender = false;
}

class MaillistsControllerTest extends CakeTestCase {
	var $Maillists = null;

	function setUp() {
		$this->Maillists = new TestMaillists();
		$this->Maillists->constructClasses();
	}

	function testMaillistsControllerInstance() {
		$this->assertTrue(is_a($this->Maillists, 'MaillistsController'));
	}

	function tearDown() {
		unset($this->Maillists);
	}
}
?>