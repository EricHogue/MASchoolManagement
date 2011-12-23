<?php
namespace MASchoolManagement;

class StudentTest extends \PHPUnit_Framework_TestCase {
	const FIRST_NAME = 'Eric';
	const LAST_NAME = 'Hogue';

	/** @var Student */
	private $student;

	public function setup() {
		$this->student = new Student(self::LAST_NAME, self::FIRST_NAME);
	}

	public function testHasAFirstName() {
		$this->assertSame('Eric', $this->student->getFirstName());
	}

	public function testHasLastName() {
		$this->assertSame('Hogue', $this->student->getLastName());
	}
}
