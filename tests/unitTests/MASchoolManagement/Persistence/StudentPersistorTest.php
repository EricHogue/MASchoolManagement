<?php
namespace MASchoolManagement\Persistence;


use \MASchoolManagement\Student;

class StudentPersistorTest extends \PHPUnit_Framework_TestCase {
	const STUDENT_FIRST_NAME = 'Eric';
	const STUDENT_LAST_NAME = 'Hogue';
	const STUDENT_ID = 123456;

	/** @var Student */
	private $student;

	public function setup() {
		$student = $this->getMock('\MASchoolManagement\Student', array(), array(), '', false);
		$student->expects($this->any())
				->method('getStudentId')
				->will($this->returnValue(self::STUDENT_ID));
		$student->expects($this->any())
				->method('getFirstName')
				->will($this->returnValue(self::STUDENT_FIRST_NAME));
		$student->expects($this->any())
				->method('getLastName')
				->will($this->returnValue(self::STUDENT_LAST_NAME));

		$this->student = $student;
	}

	public function testCreateNewStudentCallInsertOnDB() {
		$collection = $this->getMock('MongoCollection', array(), array(), '', false);
		$collection->expects($this->once())
				   ->method('insert');

		$db = $this->getMock('MongoDB', array(), array(), '', false);
		$db->expects($this->once())
			->method('selectCollection')
			->with('student')
			->will($this->returnValue($collection));

		$persistor = new StudentPersistor($db);
		$persistor->create($this->student);
	}

	public function testCreateSendTheIdToTheDB() {
		$collection = $this->getMock('MongoCollection', array(), array(), '', false);
		$collection->expects($this->once())
				   ->method('insert')
				   ->with($this->logicalAnd($this->arrayHasKey('_id'), $this->contains(self::STUDENT_ID)));

		$db = $this->getMock('MongoDB', array(), array(), '', false);
		$db->expects($this->any())
			->method('selectCollection')
			->with('student')
			->will($this->returnValue($collection));

		$persistor = new StudentPersistor($db);
		$persistor->create($this->student);
	}

	public function testCreateSendTheFirstNameToTheDB() {
		$collection = $this->getMock('MongoCollection', array(), array(), '', false);
		$collection->expects($this->once())
				   ->method('insert')
				   ->with($this->logicalAnd($this->arrayHasKey('FirstName'), $this->contains(self::STUDENT_FIRST_NAME)));

		$db = $this->getMock('MongoDB', array(), array(), '', false);
		$db->expects($this->any())
			->method('selectCollection')
			->with('student')
			->will($this->returnValue($collection));

		$persistor = new StudentPersistor($db);
		$persistor->create($this->student);
	}

	public function testCreateSendTheLastNameToTheDB() {
		$collection = $this->getMock('MongoCollection', array(), array(), '', false);
		$collection->expects($this->once())
				   ->method('insert')
				   ->with($this->logicalAnd($this->arrayHasKey('LastName'), $this->contains(self::STUDENT_LAST_NAME)));

		$db = $this->getMock('MongoDB', array(), array(), '', false);
		$db->expects($this->any())
			->method('selectCollection')
			->with('student')
			->will($this->returnValue($collection));

		$persistor = new StudentPersistor($db);
		$persistor->create($this->student);
	}

	public function testLoadCallFindWithTheID() {
		$collection = $this->getMock('MongoCollection', array(), array(), '', false);
		$collection->expects($this->once())
				   ->method('find')
				   ->with($this->logicalAnd($this->arrayHasKey('_id'), $this->contains(self::STUDENT_ID)))
				   ->will($this->returnValue(array()));

		$db = $this->getMock('MongoDB', array(), array(), '', false);
		$db->expects($this->any())
			->method('selectCollection')
			->with('student')
			->will($this->returnValue($collection));

		$persitor = new StudentPersistor($db);
		$persitor->load(self::STUDENT_ID);
	}
}