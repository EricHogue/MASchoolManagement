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

	public function getRemainingClasses() {
		if (count($this->classesSubscriptions) > 0) {
			return array_reduce($this->classesSubscriptions, function($count, $subscription) {
					return $count + $subscription->getRemainingClasses();
				}, 0);
		}
		return 0;
	}

	public function addClassesSubscription($numberOfClasses) {
		$this->classesSubscriptions[] = $this->subscriptionFactory->createClassesSubscription($numberOfClasses);
	}

	public function canAttend() {
		foreach ($this->monthlySubscriptions as $monthlySubscription) {
			if ($monthlySubscription->canAttend()) {
				return true;
			}
		}

		foreach ($this->classesSubscriptions as $classesSubscription) {
			if ($classesSubscription->canAttend()) {
				return true;
			}
		}

		return false;
	}


}