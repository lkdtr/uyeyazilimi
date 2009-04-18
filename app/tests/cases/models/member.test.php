<?php 
/* SVN FILE: $Id$ */
/* Member Test cases generated on: 2009-04-18 10:04:29 : 1240041029*/
App::import('Model', 'Member');

class MemberTestCase extends CakeTestCase {
	var $Member = null;
	var $fixtures = array('app.member', 'app.account', 'app.leave_detail', 'app.personal_information', 'app.registration_detail', 'app.payment', 'app.preference');

	function startTest() {
		$this->Member =& ClassRegistry::init('Member');
	}

	function testMemberInstance() {
		$this->assertTrue(is_a($this->Member, 'Member'));
	}

	function testMemberFind() {
		$this->Member->recursive = -1;
		$results = $this->Member->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Member' => array(
			'id'  => 1,
			'uye_no'  => 1,
			'tckimlikno'  => 'Lorem ips',
			'name'  => 'Lorem ipsum dolor sit amet',
			'lastname'  => 'Lorem ipsum dolor sit amet',
			'gender'  => 'Lorem ipsum dolor sit ame',
			'date_of_birth'  => '2009-04-18'
		));
		$this->assertEqual($results, $expected);
	}
}
?>