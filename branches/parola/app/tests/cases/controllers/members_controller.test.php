<?php 
/* SVN FILE: $Id$ */
/* MembersController Test cases generated on: 2008-09-26 00:09:32 : 1222376552*/
App::import('Controller', 'Members');

class TestMembers extends MembersController {
	var $autoRender = false;
}

class MembersControllerTest extends CakeTestCase {
	var $Members = null;

	function setUp() {
		$this->Members = new TestMembers();
	}

	function testMembersControllerInstance() {
		$this->assertTrue(is_a($this->Members, 'MembersController'));
	}

	function tearDown() {
		unset($this->Members);
	}
}
?>