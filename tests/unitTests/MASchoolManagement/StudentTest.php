<?php
namespace MASchoolManagement;

class StudentTest extends \PHPUnit_Framework_TestCase {
	const FIRST_NAME = 'Eric';
	const LAST_NAME = 'Hogue';

	/** @var Student */
	private $student;

	public function setup() {
		$userSubscriptions = $this->getMock('\MASchoolManagement\Subscriptions\UserSubscriptions', null, array(), '', false);
		$this->student = new Student(self::LAST_NAME, self::FIRST_NAME, $userSubscriptions);
	}

	public function testHasAFirstName() {
		$this->assertSame('Eric', $this->student->getFirstName());
	}

	public function testHasLastName() {
		$this->assertSame('Hogue', $this->student->getLastName());
	}

	public function testAddMonthlySubscription() {
		$userSubscription = $this->getMock('\MASchoolManagement\Subscriptions\UserSubscriptions',
			array('addMonthlySubscription'), array(), '', false);
		$userSubscription->expects($this->once())
						 ->method('addMonthlySubscription')
						 ->with($this->equalTo(3));

		$student = new Student(self::LAST_NAME, self::FIRST_NAME, $userSubscription);
		$student->addMonthlySubscription(3);
	}

	public function testGetEndOfSubscriptionDate() {
		$userSubscription = $this->getMock('\MASchoolManagement\Subscriptions\UserSubscriptions',
			array('getLastAllowedDate'), array(), '', false);
		$userSubscription->expects($this->once())
						 ->method('getLastAllowedDate')
						 ->will($this->returnValue('LastDate'));

		$student = new Student(self::LAST_NAME, self::FIRST_NAME, $userSubscription);
		$this->assertSame('LastDate', $student->getEndOfSubscriptionDate());

	}

}
