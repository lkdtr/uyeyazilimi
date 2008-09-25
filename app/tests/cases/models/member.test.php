<?php 
/* SVN FILE: $Id$ */
/* Member Test cases generated on: 2008-09-25 23:09:16 : 1222376356*/
App::import('Model', 'Member');

class TestMember extends Member {
	var $cacheSources = false;
	var $useDbConfig  = 'test_suite';
}

class MemberTestCase extends CakeTestCase {
	var $Member = null;
	var $fixtures = array('app.member', 'app.personal_information', 'app.registration_information', 'app.payment', 'app.preference');

	function start() {
		parent::start();
		$this->Member = new TestMember();
	}

	function testMemberInstance() {
		$this->assertTrue(is_a($this->Member, 'Member'));
	}

	function testMemberFind() {
		$results = $this->Member->recursive = -1;
		$results = $this->Member->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Member' => array(
			'id'  => 1,
			'uye_no'  => 1,
			'tckimlikno'  => 'Lorem ips',
			'name'  => 'Lorem ipsum dolor sit amet',
			'lastname'  => 'Lorem ipsum dolor sit amet',
			'gender'  => 'Lorem ipsum dolor sit ame',
			'date_of_birth'  => '2008-09-25',
			'lotr_alias'  => 'Lorem ipsum dolor sit amet',
			'password'  => 1
			));
		$this->assertEqual($results, $expected);
	}
}
?>