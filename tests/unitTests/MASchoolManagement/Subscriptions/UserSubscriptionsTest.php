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

		$monthlySubscription = $this->getMock('\MASchoolManagement\Subscriptions\MonthlySubscription', array(),
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
		$startDate->setTime('00:00:00', 'HH:mm:ss');

		$endDate = new \Zend\Date\Date();
		$endDate->setTime('23:59:59', 'HH:mm:ss');
		$endDate->addMonth(3);

		$monthlySubscription = $this->getMock('\MASchoolManagement\Subscriptions\MonthlySubscription', array(),
				array(), '', false);
		$monthlySubscription->expects($this->once())
							->method('getEndDate')
							->will($this->returnValue($endDate));

		$factory = $this->getMock('\MASchoolManagement\Subscriptions\SubscriptionFactory', array());

		$factory->expects($this->at(0))
				->method('createMonthlySubscription')
				->with($this->equalTo($startDate), $this->equalTo(3))
				->will($this->returnValue($monthlySubscription));

		$newStartDate = clone $endDate;
		$newStartDate->setTime('00:00:00', 'HH:mm:ss');
		$newStartDate->addDay(1);

		$factory->expects($this->at(1))
				->method('createMonthlySubscription')
				->with($this->equalTo($newStartDate), $this->equalTo(2));

		$userSubscriptions = new UserSubscriptions($factory);
		$userSubscriptions->addMonthlySubscription(3);
		$userSubscriptions->addMonthlySubscription(2);
	}

	public function testLastAllowedDateIsTheLatestEndDateWhenThereIsMoreThanOneSubscription() {
		$firstEndDate = new \Zend\Date\Date();
		$firstEndDate->setTime('23:59:59', 'HH:mm:ss')->addMonth(3);

		$firstMonthlySubscription = $this->getMock('\MASchoolManagement\Subscriptions\MonthlySubscription', array(),
				array(), '', false);
		$firstMonthlySubscription->expects($this->atLeastOnce())
							->method('getEndDate')
							->will($this->returnValue($firstEndDate));

		$secondEndDate = clone $firstEndDate;
		$secondEndDate->addMonth(2);
		$secondMonthlySubscription = $this->getMock('\MASchoolManagement\Subscriptions\MonthlySubscription', array(),
				array(), '', false);
		$secondMonthlySubscription->expects($this->atLeastOnce())
							->method('getEndDate')
							->will($this->returnValue($secondEndDate));

		$thirdEndDate = clone $secondEndDate;
		$thirdEndDate->addMonth(4);
		$thirdMonthlySubscription = $this->getMock('\MASchoolManagement\Subscriptions\MonthlySubscription', array(),
				array(), '', false);
		$thirdMonthlySubscription->expects($this->atLeastOnce())
							->method('getEndDate')
							->will($this->returnValue($thirdEndDate));

		$factory = $this->getMock('\MASchoolManagement\Subscriptions\SubscriptionFactory', array());

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

	public function testCanAttendCheckMonthlySubscription() {
		$monthlySubscription = $this->getMock('\MASchoolManagement\Subscriptions\MonthlySubscription', array(),
				array(), '', false);
		$monthlySubscription->expects($this->once())
							->method('canAttend')
							->will($this->returnValue(false));

		$factory = $this->getMock('\MASchoolManagement\Subscriptions\SubscriptionFactory', array());

		$factory->expects($this->any())
				->method('createMonthlySubscription')
				->will($this->returnValue($monthlySubscription));

		$userSubscriptions = new UserSubscriptions($factory);
		$userSubscriptions->addMonthlySubscription(3);

		$userSubscriptions->canAttend();
	}

	public function testCanAttendCheckClassesSubscription() {
		$classesSubscription = $this->getMock('\MASchoolManagement\Subscriptions\ClassesSubscription', array(),
				array(), '', false);
		$classesSubscription->expects($this->once())
							->method('canAttend')
							->will($this->returnValue(false));

		$factory = $this->getMock('\MASchoolManagement\Subscriptions\SubscriptionFactory', array());

		$factory->expects($this->any())
				->method('createClassesSubscription')
				->will($this->returnValue($classesSubscription));

		$userSubscriptions = new UserSubscriptions($factory);
		$userSubscriptions->addClassesSubscription(3);

		$userSubscriptions->canAttend();
	}

	public function testCanAttendCheckForMonthlySubscriptionFirst() {
		$monthlySubscription = $this->getMock('\MASchoolManagement\Subscriptions\MonthlySubscription', array(),
				array(), '', false);
		$monthlySubscription->expects($this->once())
							->method('canAttend')
							->will($this->returnValue(true));

		$classesSubscription = $this->getMock('\MASchoolManagement\Subscriptions\ClassesSubscription', array(),
				array(), '', false);
		$classesSubscription->expects($this->never())
							->method('canAttend');

		$factory = $this->getMock('\MASchoolManagement\Subscriptions\SubscriptionFactory',
			array());
		$factory->expects($this->any())
				->method('createMonthlySubscription')
				->will($this->returnValue($monthlySubscription));
		$factory->expects($this->any())
				->method('createClassesSubscription')
				->will($this->returnValue($classesSubscription));

		$userSubscriptions = new UserSubscriptions($factory);
		$userSubscriptions->addClassesSubscription(3);
		$userSubscriptions->addMonthlySubscription(5);

		$userSubscriptions->canAttend();
	}

	public function testCanAttendWhenMonthlySubscriptionSaysSo() {
		$monthlySubscription = $this->getMock('\MASchoolManagement\Subscriptions\MonthlySubscription', array(),
				array(), '', false);
		$monthlySubscription->expects($this->any())
							->method('canAttend')
							->will($this->returnValue(true));

		$factory = $this->getMock('\MASchoolManagement\Subscriptions\SubscriptionFactory',
			array());
		$factory->expects($this->any())
				->method('createMonthlySubscription')
				->will($this->returnValue($monthlySubscription));

		$userSubscriptions = new UserSubscriptions($factory);
		$userSubscriptions->addMonthlySubscription(5);

		$this->assertTrue($userSubscriptions->canAttend());
	}

	public function testCanAttendWhenClassesSubscriptionSaysSo() {
		$classesSubscription = $this->getMock('\MASchoolManagement\Subscriptions\ClassesSubscription', array(),
				array(), '', false);
		$classesSubscription->expects($this->any())
							->method('canAttend')
							->will($this->returnValue(true));

		$factory = $this->getMock('\MASchoolManagement\Subscriptions\SubscriptionFactory', array());
		$factory->expects($this->any())
				->method('createClassesSubscription')
				->will($this->returnValue($classesSubscription));

		$userSubscriptions = new UserSubscriptions($factory);
		$userSubscriptions->addClassesSubscription(3);

		$this->assertTrue($userSubscriptions->canAttend());
	}

	public function testCantAttendWhenMonthlyAndClassesSubscriptionSaysNo() {
		$monthlySubscription = $this->getMock('\MASchoolManagement\Subscriptions\MonthlySubscription', array(),
				array(), '', false);
		$monthlySubscription->expects($this->any())
							->method('canAttend')
							->will($this->returnValue(false));

		$classesSubscription = $this->getMock('\MASchoolManagement\Subscriptions\ClassesSubscription', array(),
				array(), '', false);
		$classesSubscription->expects($this->any())
							->method('canAttend')
							->will($this->returnValue(false));

		$factory = $this->getMock('\MASchoolManagement\Subscriptions\SubscriptionFactory', array());
		$factory->expects($this->any())
				->method('createMonthlySubscription', '')
				->will($this->returnValue($monthlySubscription));
		$factory->expects($this->any())
				->method('createClassesSubscription')
				->will($this->returnValue($classesSubscription));

		$userSubscriptions = new UserSubscriptions($factory);
		$userSubscriptions->addMonthlySubscription(5);
		$userSubscriptions->addClassesSubscription(3);

		$this->assertFalse($userSubscriptions->canAttend());
	}

	public function testAddMonthlySubscriptionWithGivenStartDate() {
		$startDate = new \Zend\Date\Date();
		$startDate->addMonth(-4);

		$factory = $this->getMock('\MASchoolManagement\Subscriptions\SubscriptionFactory', array());
		$factory->expects($this->any())
				->method('createMonthlySubscription', '')
				->with($this->equalTo($startDate));

		$userSubscriptions = new UserSubscriptions($factory);
		$userSubscriptions->addMonthlySubscriptionWithGivenStartDate($startDate, 2);
	}

	public function testAttendClassCallAttendOnMonthlySubscription() {
		$monthlySubscription = $this->getMock('\MASchoolManagement\Subscriptions\MonthlySubscription', array(),
				array(), '', false);
		$monthlySubscription->expects($this->any())
							->method('canAttend')
							->will($this->returnValue(true));
		$monthlySubscription->expects($this->once())
							->method('addAttendance')
							->will($this->returnValue(true));

		$factory = $this->getMock('\MASchoolManagement\Subscriptions\SubscriptionFactory', array());
		$factory->expects($this->any())
				->method('createMonthlySubscription', '')
				->will($this->returnValue($monthlySubscription));

		$userSubscriptions = new UserSubscriptions($factory);
		$userSubscriptions->addMonthlySubscription(5);

		$userSubscriptions->attendClass();
	}

	public function testAttendClassCallAttendOnClassesSubscription() {
		$classesSubscription = $this->getMock('\MASchoolManagement\Subscriptions\ClassesSubscription', array(),
				array(), '', false);
		$classesSubscription->expects($this->any())
							->method('canAttend')
							->will($this->returnValue(true));
		$classesSubscription->expects($this->once())
							->method('addAttendance')
							->will($this->returnValue(true));

		$factory = $this->getMock('\MASchoolManagement\Subscriptions\SubscriptionFactory', array());
		$factory->expects($this->any())
				->method('createClassesSubscription', '')
				->will($this->returnValue($classesSubscription));

		$userSubscriptions = new UserSubscriptions($factory);
		$userSubscriptions->addClassesSubscription(2);

		$userSubscriptions->attendClass();
	}

	/**
	 * @expectedException MASchoolManagement\Subscriptions\EndedSubscriptionException
	 */
	public function testCallingAttendClassesWhenNoSubscriptionThrowsAnException() {
		$factory = $this->getMock('\MASchoolManagement\Subscriptions\SubscriptionFactory');

		$userSubscriptions = new UserSubscriptions($factory);
		$userSubscriptions->attendClass();
	}

}