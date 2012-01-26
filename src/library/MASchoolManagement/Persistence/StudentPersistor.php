<?php
namespace MASchoolManagement\Persistence;

use \MASchoolManagement\Student;

class StudentPersistor {
	/** @var \MongoDB */
	private $dbConnection;

	public function __construct(\MongoDB $dbConnection) {
		$this->dbConnection = $dbConnection;
	}

	public function create(Student $student) {
		$collection = $this->dbConnection->selectCollection('student');
		$collection->insert(array('_id' => $student->getStudentId(), 'FirstName' => $student->getFirstName(),
			'LastName' => $student->getLastName()));
	}

	public function load($studentId) {
		$collection = $this->dbConnection->selectCollection('student');
		$collection->find(array('_id' => $studentId));

	}
}