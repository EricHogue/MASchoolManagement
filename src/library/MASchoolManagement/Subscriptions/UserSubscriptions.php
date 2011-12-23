<?php
namespace MASchoolManagement\Subscriptions;

class UserSubscriptions {
	/** @var ClassesSubscription */
	private $classesSubscriptions;

	/** @var MonthlySubscription */
	private $monthlySubscriptions;


	/** @var SubscriptionFactory */
	private $subscriptionFactory;


	public function __construct(SubscriptionFactory $subscriptionFactory) {
		$this->subscriptionFactory = $subscriptionFactory;

		$this->monthlySubscriptions = array();
		$this->classesSubscriptions = array();
	}

	public function addMonthlySubscription($numberOfMonths) {
		$lastDateAllowed = $this->getLastAllowedDate();
		if (!isset($lastDateAllowed)) {
			$lastDateAllowed = new \Zend\Date\Date();
		}

		$this->monthlySubscriptions[] = $this->subscriptionFactory->createMonthlySubscription($lastDateAllowed, $numberOfMonths);
	}

	public function getLastAllowedDate() {
		if (count($this->monthlySubscriptions) > 0) {
			return $this->monthlySubscriptions[0]->getEndDate();
		}

		return null;
	}


}