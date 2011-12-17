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
		$date = new Date(self::START_DATE, 'yyyy-mm-dd');
		$this->assertFalse($this->subscription->canAttend($date->add(-1, Date::DAY)));
	}

	public function testCantAttendAfterEndDate() {
		$date = new Date(self::END_DATE, 'yyyy-mm-dd');
		$this->assertFalse($this->subscription->canAttend($date->add(1, Date::DAY)));
	}

	public function testCanAttendOnStartDate() {
		$date = new Date(self::START_DATE, 'yyyy-mm-dd');
		$this->assertTrue($this->subscription->canAttend($date));
	}

	public function testCanAttendOnEndDate() {
		$date = new Date(self::END_DATE, 'yyyy-mm-dd');
		$this->assertTrue($this->subscription->canAttend($date));
	}

	/**
	 * @expectedException \MASchoolManagement\Subscriptions\EndedSubscriptionException
	 */
	public function testThrowExceptionWhenAddingAttendanceOutsideRange() {
		$date = new Date(self::END_DATE, 'yyyy-mm-dd');
		$this->subscription->addAttendance($date->add(1, Date::DAY));
	}

	public function testCanAddAttendanceWhenInSubscriptionRange() {
		$date = new Date(self::START_DATE, 'yyyy-mm-dd');
		$this->assertTrue($this->subscription->addAttendance($date->add(10, Date::DAY)));
	}
}