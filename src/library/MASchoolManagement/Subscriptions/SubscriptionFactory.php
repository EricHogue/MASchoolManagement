<?php
namespace MASchoolManagement\Subscriptions;

use \Zend\Date\Date;

class SubscriptionFactory {
	public function __construct() {
	}

	public function createClassesSubscription($availableClasses) {
		return new ClassesSubscription($availableClasses);
	}

	public function createMonthlySubscription(Date $startDate, $numberOfMonths) {
		$endDate = clone $startDate;
		$endDate->addMonth($numberOfMonths);

		return new MonthlySubscription($startDate, $endDate);
	}
}