<?php
namespace MASchoolManagement\Subscriptions;

class UserSubscriptions {
	/** @var ClassesSubscription */
	private $classesSubscriptions;

	public function __construct() {
		$this->classesSubscriptions = array();
	}

	public function canAttendClass() {
		if (count($this->classesSubscriptions) > 0) {
			return $this->classesSubscriptions[0]->canAttend();
		}

		return false;
	}

	public function addClassesSubscription($classCount) {
		$this->classesSubscriptions[] = new ClassesSubscription($classCount);
	}

	public function attendClass() {
		$this->classesSubscriptions[0]->addAttendance();
	}

}