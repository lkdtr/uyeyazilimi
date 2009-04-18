<?php 
/* SVN FILE: $Id$ */
/* MembersController Test cases generated on: 2009-04-18 12:04:05 : 1240045625*/
App::import('Controller', 'Members');

class TestMembers extends MembersController {
	var $autoRender = false;
}

class MembersControllerTest extends CakeTestCase {
	var $Members = null;

	function setUp() {
		$this->Members = new TestMembers();
		$this->Members->constructClasses();
	}

	function testMembersControllerInstance() {
		$this->assertTrue(is_a($this->Members, 'MembersController'));
	}

	function tearDown() {
		unset($this->Members);
	}
}
?>