<?php
namespace MASchoolManagement\Subscriptions;

use \Zend\Date\Date;

class ClassesSubscription implements Subscription {
	/** @var int */
	private $remainingClasses;


	public function __construct($availableClasses) {
		$this->remainingClasses = (int) $availableClasses;
	}

	/**
	 * Check if the subscriber can attend at the given date
	 *
	 * @param \Zend\Date\Date $date
	 * @return boolean true if the user can attend
	 */
	public function canAttend(Date $date) {
		$date;
		return $this->remainingClasses > 0;
	}

	/**
	 * Add an attendace for a date
	 *
	 * @param \Zend\Date\Date $date
	 */
	public function addAttendance(Date $date) {
		if (!$this->canAttend($date)) {
			throw new EndedSubscriptionException();
		}

		$this->remainingClasses--;
	}
}