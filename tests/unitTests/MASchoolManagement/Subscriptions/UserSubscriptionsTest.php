<?php
namespace MASchoolManagement\Subscriptions;

class UserSubscriptionsTest extends \PHPUnit_Framework_TestCase {
	public function setup() {
	}

	public function testCreate() {
		$this->assertNotNull(new UserSubscriptions());
	}

	public function testCanAddSubscription() {
		$userSubscriptions = new UserSubscriptions();

		$this->assertTrue($userSubscriptions->addSubscription(new ClassesSubscription(3)));
	}
}