<?php 
/* SVN FILE: $Id$ */
/* AccountsController Test cases generated on: 2009-04-18 12:04:28 : 1240045588*/
App::import('Controller', 'Accounts');

class TestAccounts extends AccountsController {
	var $autoRender = false;
}

class AccountsControllerTest extends CakeTestCase {
	var $Accounts = null;

	function setUp() {
		$this->Accounts = new TestAccounts();
		$this->Accounts->constructClasses();
	}

	function testAccountsControllerInstance() {
		$this->assertTrue(is_a($this->Accounts, 'AccountsController'));
	}

	function tearDown() {
		unset($this->Accounts);
	}
}
?>