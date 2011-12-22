<?php
namespace MASchoolManagement\Subscriptions;

use \Zend\Date\Date;

class MonthlySubscription implements Subscription {
	/** @var Date */
	private $startDate;

	/** @var Date */
	private $endDate;

	public function __construct(Date $startDate, Date $endDate) {
		$this->startDate = $startDate;
		$this->endDate = $endDate;
	}

	/**
	 * @return \Zend\Date\Date The start date
	 */
	public function getStartDate() {
		return $this->startDate;
	}

	/**
	 * @return \Zend\Date\Date The end date
	 */
	public function getEndDate() {
		return $this->endDate;
	}

	/**
	 * Check if the subscriber can attend
	 *
	 * @return boolean true if the user can attend
	 */
	public function canAttend() {
		$date = new Date();
		return ($date >= $this->startDate && $date <= $this->endDate);
	}

	/**
	 * Add an attendace for a date
	 */
	public function addAttendance() {
		if (!$this->canAttend()) {
			throw new EndedSubscriptionException();
		}

		return true;
	}

}