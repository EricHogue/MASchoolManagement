<?php
namespace MASchoolManagement\Subscriptions;

class SubscriptionFactoryTest extends \PHPUnit_Framework_TestCase {
	public function setup() {
	}

	public function testCreate() {
		$this->assertNotNull(new SubscriptionFactory());
	}

	public function testCreateClassesSubscription() {
		$factory = new SubscriptionFactory();
		$this->assertNotNull($factory->createClassesSubscription(1));
	}

	public function testCreateMonthlySubscription() {
		$factory = new SubscriptionFactory();
		$this->assertNotNull($factory->createMonthlySubscription(new \Zend\Date\Date(), 3));
	}

}