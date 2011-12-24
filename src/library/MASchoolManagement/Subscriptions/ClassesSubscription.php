<?php
namespace MASchoolManagement\Subscriptions;


class ClassesSubscription implements Subscription {
	/** @var int */
	private $remainingClasses;


	public function __construct($availableClasses) {
		$this->remainingClasses = (int) $availableClasses;
	}

	/**
	 * Check if the subscriber can attend
	 *
	 * @return boolean true if the user can attend
	 */
	public function canAttend() {
		return $this->remainingClasses > 0;
	}

	/**
	 * Add an attendace
	 */
	public function addAttendance() {
		if (!$this->canAttend()) {
			throw new EndedSubscriptionException();
		}

		$this->remainingClasses--;
	}

	public function getRemainingClasses() {
		return $this->remainingClasses;
	}
}