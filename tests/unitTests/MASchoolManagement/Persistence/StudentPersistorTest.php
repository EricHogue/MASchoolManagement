<?php
namespace MASchoolManagement\Persistence;


use \MASchoolManagement\Student;

class StudentPersistorTest extends \PHPUnit_Framework_TestCase {
	const STUDENT_FIRST_NAME = 'Eric';
	const STUDENT_LAST_NAME = 'Hogue';

	/** @var Student */
	private $student;

	public function setup() {
		$student = $this->getMock('\MASchoolManagement\Student', array(), array(), '', false);
		$student->expects($this->any())
				->method('getFirstName')
				->will($this->returnValue(self::STUDENT_FIRST_NAME));
		$student->expects($this->any())
				->method('getLastName')
				->will($this->returnValue(self::STUDENT_LAST_NAME));

		$this->student = $student;
	}

	public function testSaveNewStudentCallSaveOnDB() {
		$collection = $this->getMock('MongoCollection', array('save'), array(), '', false);
		$collection->expects($this->once())
				   ->method('save')
				   ->with($this->logicalAnd($this->arrayHasKey('FirstName'), $this->contains(self::STUDENT_FIRST_NAME)));

		$db = $this->getMock('MongoDB', array('selectCollection'), array(), '', false);
		$db->expects($this->once())
			->method('selectCollection')
			->with('student')
			->will($this->returnValue($collection));

		$persistor = new StudentPersistor($db);
		$persistor->save($this->student);
	}
}