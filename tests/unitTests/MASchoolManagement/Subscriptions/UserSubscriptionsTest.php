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

	public function testNewMonthlySubscriptionsAreCreatedAfterExistingOnes() {
		$startDate = new \Zend\Date\Date();
		$startDate->setTime('23:59:59', 'HH:mm:ss');

		$endDate = new \Zend\Date\Date();
		$endDate->setTime('23:59:59', 'HH:mm:ss');
		$endDate->addMonth(3);

		$monthlySubscription = $this->getMock('\MASchoolManagement\Subscriptions\MonthlySubscription', array('getEndDate'),
				array(), '', false);
		$monthlySubscription->expects($this->once())
							->method('getEndDate')
							->will($this->returnValue($endDate));

		$factory = $this->getMock('\MASchoolManagement\Subscriptions\SubscriptionFactory', array('createMonthlySubscription'));

		$factory->expects($this->at(0))
				->method('createMonthlySubscription')
				->with($this->equalTo($startDate), $this->equalTo(3))
				->will($this->returnValue($monthlySubscription));
		$factory->expects($this->at(1))
				->method('createMonthlySubscription')
				->with($this->equalTo($endDate), $this->equalTo(2));

		$userSubscriptions = new UserSubscriptions($factory);
		$userSubscriptions->addMonthlySubscription(3);
		$userSubscriptions->addMonthlySubscription(2);
	}

	public function testLastAllowedDateIsTheLatestEndDateWhenThereIsMoreThanOneSubscription() {
		$firstEndDate = new \Zend\Date\Date();
		$firstEndDate->setTime('23:59:59', 'HH:mm:ss')->addMonth(3);

		$firstMonthlySubscription = $this->getMock('\MASchoolManagement\Subscriptions\MonthlySubscription', array('getEndDate'),
				array(), '', false);
		$firstMonthlySubscription->expects($this->atLeastOnce())
							->method('getEndDate')
							->will($this->returnValue($firstEndDate));

		$secondEndDate = clone $firstEndDate;
		$secondEndDate->addMonth(2);
		$secondMonthlySubscription = $this->getMock('\MASchoolManagement\Subscriptions\MonthlySubscription', array('getEndDate'),
				array(), '', false);
		$secondMonthlySubscription->expects($this->atLeastOnce())
							->method('getEndDate')
							->will($this->returnValue($secondEndDate));

		$thirdEndDate = clone $secondEndDate;
		$thirdEndDate->addMonth(4);
		$thirdMonthlySubscription = $this->getMock('\MASchoolManagement\Subscriptions\MonthlySubscription', array('getEndDate'),
				array(), '', false);
		$thirdMonthlySubscription->expects($this->atLeastOnce())
							->method('getEndDate')
							->will($this->returnValue($thirdEndDate));

		$factory = $this->getMock('\MASchoolManagement\Subscriptions\SubscriptionFactory', array('createMonthlySubscription'));

		$factory->expects($this->at(0))
				->method('createMonthlySubscription')
				->will($this->returnValue($firstMonthlySubscription));

		$factory->expects($this->at(1))
				->method('createMonthlySubscription')
				->will($this->returnValue($secondMonthlySubscription));

		$factory->expects($this->at(2))
				->method('createMonthlySubscription')
				->will($this->returnValue($thirdMonthlySubscription));

		$userSubscription = new UserSubscriptions($factory);
		$userSubscription->addMonthlySubscription(3);
		$userSubscription->addMonthlySubscription(2);
		$userSubscription->addMonthlySubscription(4);

		$this->assertEquals($thirdEndDate, $userSubscription->getLastAllowedDate());
	}

	public function testHave0ClassesLeftWhenNoClassesSubscriptions() {
		$this->assertSame(0, $this->userSubscriptions->getRemainingClasses());
	}

	public function testHave5ClassesLeftAfterAdding5Classes() {
		$userSubscriptions = new UserSubscriptions(new SubscriptionFactory());
		$userSubscriptions->addClassesSubscription(5);
		$this->assertSame(5, $userSubscriptions->getRemainingClasses());
	}




}