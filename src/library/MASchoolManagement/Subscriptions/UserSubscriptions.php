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
		if (isset($lastDateAllowed)) {
			$lastDateAllowed->addDay(1);
		}
		else {
			$lastDateAllowed = new \Zend\Date\Date();
		}

		$lastDateAllowed->setTime('00:00:00', 'HH:mm:ss');

		$this->addMonthlySubscriptionWithGivenStartDate($lastDateAllowed, $numberOfMonths);
	}

	public function addMonthlySubscriptionWithGivenStartDate(\Zend\Date\Date $startDate, $numberOfMonths) {
		$this->monthlySubscriptions[] = $this->subscriptionFactory->createMonthlySubscription($startDate, $numberOfMonths);
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
		$validSubscription = $this->getFirstValidSubscription();

		return isset($validSubscription);
	}

	public function attendClass() {
		$validSubscription = $this->getFirstValidSubscription();

		if (isset($validSubscription)) {
			$validSubscription->addAttendance();
		} else {
			throw new EndedSubscriptionException();
		}
	}

	/**
	 * Return the first subsciption that is valid
	 *
	 * @return Subscription
	 */
	protected function getFirstValidSubscription() {
		foreach ($this->monthlySubscriptions as $monthlySubscription) {
			if ($monthlySubscription->canAttend()) {
				return $monthlySubscription;
			}
		}

		foreach ($this->classesSubscriptions as $classesSubscription) {
			if ($classesSubscription->canAttend()) {
				return $classesSubscription;
			}
		}

		return null;
	}
}