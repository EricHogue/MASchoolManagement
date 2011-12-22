<?php
namespace MASchoolManagement\Subscriptions;

use Zend\Date\Date;

class MonthlySubscriptionTest extends \PHPUnit_Framework_TestCase {
	const START_DATE = '2011-01-01';
	const END_DATE = '2011-12-31';

	/** @var MonthlySubscription */
	private $subscription;

	/** @var Date */
	private $startDate;

	/** @var Date */
	private $endDate;


	public function setup() {
		$this->startDate = new Date(self::START_DATE, 'yyyy-mm-dd');
		$this->endDate = new Date(self::END_DATE, 'yyyy-mm-dd');

		$this->subscription = new MonthlySubscription($this->startDate, $this->endDate);
	}

	public function testReturnTheStartDate() {
		$this->assertEquals($this->startDate, $this->subscription->getStartDate());
	}

	public function testReturnTheEndDate() {
		$this->assertEquals($this->endDate, $this->subscription->getEndDate());
	}

	public function testCantAttendBeforeStartDate() {
		$startDate = new Date();
		$startDate->addDay(1);
		$endDate = new Date();
		$endDate->addDay(2);
		$subscription = new MonthlySubscription($startDate, $endDate);

		$this->assertFalse($subscription->canAttend());
	}

	public function testCantAttendAfterEndDate() {
		$startDate = new Date();
		$startDate->addDay(-2);
		$endDate = new Date();
		$endDate->addDay(-1);
		$subscription = new MonthlySubscription($startDate, $endDate);

		$this->assertFalse($subscription->canAttend());
	}

	public function testCanAttendOnStartDate() {
		$startDate = new Date();
		$endDate = new Date();
		$endDate->addDay(1);
		$subscription = new MonthlySubscription($startDate, $endDate);


		$this->assertTrue($subscription->canAttend());
	}

	public function testCanAttendOnEndDate() {
		$startDate = new Date();
		$startDate->addDay(-1);
		$endDate = new Date();
		$subscription = new MonthlySubscription($startDate, $endDate);

		$this->assertTrue($subscription->canAttend());
	}

	/**
	 * @expectedException \MASchoolManagement\Subscriptions\EndedSubscriptionException
	 */
	public function testThrowExceptionWhenAddingAttendanceOutsideRange() {
		$startDate = new Date();
		$startDate->addDay(-2);
		$endDate = new Date();
		$endDate->addDay(-2);
		$subscription = new MonthlySubscription($startDate, $endDate);

		$subscription->addAttendance();
	}

	public function testCanAddAttendanceWhenInSubscriptionRange() {
		$startDate = new Date();
		$startDate->addDay(-1);
		$endDate = new Date();
		$endDate->addDay(1);
		$subscription = new MonthlySubscription($startDate, $endDate);

		$this->assertTrue($subscription->addAttendance());
	}
}