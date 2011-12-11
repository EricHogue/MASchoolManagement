<?php
namespace MASchoolManagement;

class UserTest extends \PHPUnit_Framework_TestCase {
	const FIRST_NAME = 'Eric';
	const LAST_NAME = 'Hogue';

	/** @var User */
	private $user;

	public function setup() {
		$this->user = new User(self::LAST_NAME, self::FIRST_NAME);
	}

	public function testHasAFirstName() {
		$this->assertSame('Eric', $this->user->getFirstName());
	}

	public function testHasLastName() {
		$this->assertSame('Hogue', $this->user->getLastName());
	}
}