<?php 
/* SVN FILE: $Id$ */
/* LeaveDetailsController Test cases generated on: 2009-04-18 12:04:39 : 1240045599*/
App::import('Controller', 'LeaveDetails');

class TestLeaveDetails extends LeaveDetailsController {
	var $autoRender = false;
}

class LeaveDetailsControllerTest extends CakeTestCase {
	var $LeaveDetails = null;

	function setUp() {
		$this->LeaveDetails = new TestLeaveDetails();
		$this->LeaveDetails->constructClasses();
	}

	function testLeaveDetailsControllerInstance() {
		$this->assertTrue(is_a($this->LeaveDetails, 'LeaveDetailsController'));
	}

	function tearDown() {
		unset($this->LeaveDetails);
	}
}
?>