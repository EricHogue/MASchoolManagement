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
	private $id;


	public function __construct($id, $lastName, $firstName, UserSubscriptions $userSubscriptions) {
		$this->userSubscriptions = $userSubscriptions;
		$this->id = $id;
		$this->lastName = $lastName;
		$this->firstName = $firstName;
	}

	public function getFirstName() {
		return $this->firstName;
	}

	public function getLastName() {
		return $this->lastName;
	}

	public function getId() {
		return $this->id;
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