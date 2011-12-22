<?php
namespace MASchoolManagement\Subscriptions;

use \Zend\Date\Date;

class ClassesSubscriptionTest extends \PHPUnit_Framework_TestCase {
	/** @var ClassesSubscription */
	private $subscription;

	public function setup() {
		$this->subscription = new ClassesSubscription(3);
	}

	public function testCannotAttendWhenCreatedWith0Classes() {
		$subscription = new ClassesSubscription(0);
		$this->assertFalse($subscription->canAttend(new Date()));
	}

	public function testCanAttendWhenCreatedWithClasses() {
		$this->assertTrue($this->subscription->canAttend(new Date()));
	}

	public function testCanStillAttendAfter2Classes() {
		$this->subscription->addAttendance(new Date());
		$this->subscription->addAttendance(new Date());

		$this->assertTrue($this->subscription->canAttend(new Date()));
	}

	public function testCantAttendWhenNoClassesAreLeft() {
		$this->subscription->addAttendance(new Date());
		$this->subscription->addAttendance(new Date());
		$this->subscription->addAttendance(new Date());

		$this->assertFalse($this->subscription->canAttend(new Date()));
	}

	/**
	 * @expectedException \MASchoolManagement\Subscriptions\EndedSubscriptionException
	 */
	public function testAttendingWhenNoClassesAreLeftThrowsAnException() {
		$this->subscription->addAttendance(new Date());
		$this->subscription->addAttendance(new Date());
		$this->subscription->addAttendance(new Date());
		$this->subscription->addAttendance(new Date());
	}
}