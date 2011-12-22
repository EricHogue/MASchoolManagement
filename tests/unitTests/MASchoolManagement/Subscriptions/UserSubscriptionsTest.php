<?php
namespace MASchoolManagement\Subscriptions;

class UserSubscriptionsTest extends \PHPUnit_Framework_TestCase {
	/** @var UserSubscriptions */
	private $userSubscriptions;

	public function setup() {
		$this->userSubscriptions = new UserSubscriptions();
	}


	public function testCanAddSubscription() {
		$this->assertTrue($this->userSubscriptions->addSubscription(new ClassesSubscription(3)));
	}


}