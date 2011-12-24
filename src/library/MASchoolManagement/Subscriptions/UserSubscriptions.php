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
			$lastDateAllowed->setTime('23:59:59', 'HH:mm:ss');
		}

		$this->monthlySubscriptions[] = $this->subscriptionFactory->createMonthlySubscription($lastDateAllowed, $numberOfMonths);
	}

	public function getLastAllowedDate() {
		$subscriptionCount = count($this->monthlySubscriptions);
		if ($subscriptionCount > 0) {
			return $this->monthlySubscriptions[$subscriptionCount - 1]->getEndDate();
		}

		return null;
	}


}