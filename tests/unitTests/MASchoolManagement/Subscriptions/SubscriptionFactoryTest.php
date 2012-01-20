<?php
namespace MASchoolManagement\Subscriptions;

class SubscriptionFactoryTest extends \PHPUnit_Framework_TestCase {
	/** @var SubscriptionFactory */
	private $factory;

	public function setup() {
		$this->factory = new SubscriptionFactory();
	}


	public function testCreateClassesSubscription() {
		$this->assertNotNull($this->factory->createClassesSubscription(1));
	}

	public function testCreateMonthlySubscription() {
		$this->assertNotNull($this->factory->createMonthlySubscription(new \Zend\Date\Date(), 3));
	}
}