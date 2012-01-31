<?php
namespace MASchoolManagement;

use MASchoolManagement\Subscriptions\UserSubscriptions;

class Student {
	/** @var UserSubscriptions */
	private $userSubscriptions;


	/** @var string */
	private $lastName;

	/** @var string */
	private $firstName;

	/** @var int */
	private $studentId;

	/** @var string */
	private $rank;



	public function __construct($studentId, $lastName, $firstName, $rank, UserSubscriptions $userSubscriptions) {
		$this->userSubscriptions = $userSubscriptions;
		$this->studentId = $studentId;
		$this->lastName = $lastName;
		$this->firstName = $firstName;
		$this->rank = $rank;
	}

	public function getFirstName() {
		return $this->firstName;
	}

	public function getLastName() {
		return $this->lastName;
	}

	public function getStudentId() {
		return $this->studentId;
	}

	public function getRank() {
		return $this->rank;
	}

	public function addMonthlySubscription($numberOfMonths) {
		$this->userSubscriptions->addMonthlySubscription($numberOfMonths);
	}

	public function getEndOfSubscriptionDate() {
		return $this->userSubscriptions->getLastAllowedDate();
	}

	public function addClassesSubscription($numberOfClasses) {
		$this->userSubscriptions->addClassesSubscription($numberOfClasses);
	}

	public function getRemainingClasses() {
		return $this->userSubscriptions->getRemainingClasses();
	}

	public function attendClass() {
		if (!$this->userSubscriptions->canAttend()) {
			return false;
		}

		$this->userSubscriptions->attendClass();
		return true;
	}

	public function addMonthlySubscriptionWithGivenStartDate(\Zend\Date\Date $startDate, $numberOfMonths) {
		$this->userSubscriptions->addMonthlySubscriptionWithGivenStartDate($startDate, $numberOfMonths);
	}
}