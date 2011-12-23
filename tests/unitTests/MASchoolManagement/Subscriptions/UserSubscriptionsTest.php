<?php
namespace MASchoolManagement\Subscriptions;

class UserSubscriptionsTest extends \PHPUnit_Framework_TestCase {
	/** @var UserSubscriptions */
	private $userSubscriptions;

	public function setup() {
		$this->userSubscriptions = new UserSubscriptions();
	}

	public function testUserCantAttendWhenNoSubscriptions() {
		$this->assertFalse($this->userSubscriptions->canAttendClass());
	}

	public function testUserCanAttendAfterAddingClassesSubscription() {
		$this->userSubscriptions->addClassesSubscription(1);
		$this->assertTrue($this->userSubscriptions->canAttendClass());
	}

	public function testUserCantAttendAfterUsingAllSubscribedClasses() {
		$this->userSubscriptions->addClassesSubscription(1);
		$this->userSubscriptions->attendClass();

		$this->assertFalse($this->userSubscriptions->canAttendClass());
	}


}