<?php
namespace MASchoolManagement;

class AttendancesTest extends \PHPUnit_Framework_TestCase {
	public function setup() {
	}

	public function testCreate() {
		$this->assertNotNull(new Attendances());
	}

	public function testStartWith0Attendances() {
		$attendances = new Attendances();
		$this->assertSame(0, $attendances->count());
	}
}