<?php
namespace MASchoolManagement\Persistence;

use MASchoolManagement\Subscriptions\SubscriptionFactory;

use MASchoolManagement\Subscriptions\UserSubscriptions;

use \MASchoolManagement\Student;

class StudentPersistor {
	/** @var \MongoDB */
	private $dbConnection;

	public function __construct(\MongoDB $dbConnection) {
		$this->dbConnection = $dbConnection;
	}

	public function create(Student $student) {
		$options = array( 'safe' => true );
		$collection = $this->dbConnection->selectCollection('student');
		$collection->insert(array('_id' => $student->getStudentId(), 'FirstName' => $student->getFirstName(),
			'LastName' => $student->getLastName(), 'Rank' => $student->getRank()), $options);
	}

	public function load($studentId) {
		$collection = $this->dbConnection->selectCollection('student');
		$info = $collection->findOne(array('_id' => $studentId));

		if (isset($info)) {
			return new Student((int) $info['_id'], $info['LastName'], $info['FirstName'], $info['Rank'],
				new UserSubscriptions(new SubscriptionFactory()));
		}

		return null;
	}
}