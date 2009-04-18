<?php 
/* SVN FILE: $Id$ */
/* MembershipFeesController Test cases generated on: 2009-04-18 12:04:17 : 1240045637*/
App::import('Controller', 'MembershipFees');

class TestMembershipFees extends MembershipFeesController {
	var $autoRender = false;
}

class MembershipFeesControllerTest extends CakeTestCase {
	var $MembershipFees = null;

	function setUp() {
		$this->MembershipFees = new TestMembershipFees();
		$this->MembershipFees->constructClasses();
	}

	function testMembershipFeesControllerInstance() {
		$this->assertTrue(is_a($this->MembershipFees, 'MembershipFeesController'));
	}

	function tearDown() {
		unset($this->MembershipFees);
	}
}
?>