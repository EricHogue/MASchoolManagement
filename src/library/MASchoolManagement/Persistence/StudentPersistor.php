<?php
namespace MASchoolManagement\Persistence;

use \MASchoolManagement\Student;

class StudentPersistor {
	/** @var \MongoDB */
	private $dbConnection;

	public function __construct(\MongoDB $dbConnection) {
		$this->dbConnection = $dbConnection;
	}

	public function save(Student $student) {
		$collection = $this->dbConnection->selectCollection('student');
		$collection->save(array('FirstName' => $student->getFirstName()));
	}
}