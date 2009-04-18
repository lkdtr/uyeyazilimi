<?php 
/* SVN FILE: $Id$ */
/* Account Test cases generated on: 2009-04-18 10:04:40 : 1240040500*/
App::import('Model', 'Account');

class AccountTestCase extends CakeTestCase {
	var $Account = null;
	var $fixtures = array('app.account', 'app.member', 'app.password_confirmation');

	function startTest() {
		$this->Account =& ClassRegistry::init('Account');
	}

	function testAccountInstance() {
		$this->assertTrue(is_a($this->Account, 'Account'));
	}

	function testAccountFind() {
		$this->Account->recursive = -1;
		$results = $this->Account->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Account' => array(
			'id'  => 1,
			'member_id'  => 1,
			'lotr_alias'  => 'Lorem ipsum dolor sit amet',
			'password'  => 'Lorem ipsum dolor sit amet',
			'active'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>