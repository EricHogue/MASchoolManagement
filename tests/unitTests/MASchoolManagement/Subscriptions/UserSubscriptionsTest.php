<?php
namespace MASchoolManagement\Subscriptions;

class UserSubscriptionsTest extends \PHPUnit_Framework_TestCase {
	/** @var UserSubscriptions */
	private $userSubscriptions;

	public function setup() {
		$this->userSubscriptions = new UserSubscriptions($this->getMock('\MASchoolManagement\Subscriptions\SubscriptionFactory'));
	}

	public function testLastAllowedDateIsNullWhenNoSubscription() {
		$this->assertNull($this->userSubscriptions->getLastAllowedDate());
	}

	public function testLastAllowedDateIsEqualToEndOfSubscription() {
		$endDate = new \Zend\Date\Date();
		$endDate->addMonth(3);

		$monthlySubscription = $this->getMock('\MASchoolManagement\Subscriptions\MonthlySubscription', array('getEndDate'),
				array(), '', false);
		$monthlySubscription->expects($this->any())
							->method('getEndDate')
							->will($this->returnValue($endDate));

		$factory = $this->getMock('\MASchoolManagement\Subscriptions\SubscriptionFactory');
		$factory->expects($this->once())
				->method('createMonthlySubscription')
				->with($this->anything(), $this->equalTo(3))
				->will($this->returnValue($monthlySubscription));

		$userSubscriptions = new UserSubscriptions($factory);
		$userSubscriptions->addMonthlySubscription(3);

		$this->assertSame($endDate, $userSubscriptions->getLastAllowedDate());
	}


}