<?php
namespace MASchoolManagement\Subscriptions;

class ClassesSubscriptionTest extends \PHPUnit_Framework_TestCase {
	/** @var ClassesSubscription */
	private $subscription;

	public function setup() {
		$this->subscription = new ClassesSubscription(3);
	}

	public function testCannotAttendWhenCreatedWith0Classes() {
		$subscription = new ClassesSubscription(0);
		$this->assertFalse($subscription->canAttend());
	}

	public function testCanAttendWhenCreatedWithClasses() {
		$this->assertTrue($this->subscription->canAttend());
	}

	public function testCanStillAttendAfter2Classes() {
		$this->subscription->addAttendance();
		$this->subscription->addAttendance();

		$this->assertTrue($this->subscription->canAttend());
	}

	public function testCantAttendWhenNoClassesAreLeft() {
		$this->subscription->addAttendance();
		$this->subscription->addAttendance();
		$this->subscription->addAttendance();

		$this->assertFalse($this->subscription->canAttend());
	}

	/**
	 * @expectedException \MASchoolManagement\Subscriptions\EndedSubscriptionException
	 */
	public function testAttendingWhenNoClassesAreLeftThrowsAnException() {
		$this->subscription->addAttendance();
		$this->subscription->addAttendance();
		$this->subscription->addAttendance();
		$this->subscription->addAttendance();
	}

	public function testRemainingClasses() {
		$this->assertSame(3, $this->subscription->getRemainingClasses());
	}
}