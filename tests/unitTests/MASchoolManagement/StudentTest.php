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

	public function testAddClassesSubscription() {
		$userSubscription = $this->getMock('\MASchoolManagement\Subscriptions\UserSubscriptions',
			array('addClassesSubscription'), array(), '', false);
		$userSubscription->expects($this->once())
						 ->method('addClassesSubscription')
						 ->with($this->equalTo(5));

		$student = new Student(self::LAST_NAME, self::FIRST_NAME, $userSubscription);
		$student->addClassesSubscription(5);
	}

	public function testGetRemainingClassesGetThemFromUserSubscriptions() {
		$userSubscriptions = $this->getMock('\MASchoolManagement\Subscriptions\UserSubscriptions',
			array('getRemainingClasses'), array(), '', false);
		$userSubscriptions->expects($this->once())
						  ->method('getRemainingClasses');

		$student = new Student(self::LAST_NAME, self::FIRST_NAME, $userSubscriptions);
		$student->getRemainingClasses();
	}

	public function testAttendClassFailsWhenNoSubscriptions() {
		$userSubscriptions = $this->getMock('\MASchoolManagement\Subscriptions\UserSubscriptions',
			array('canAttend'), array(), '', false);
		$userSubscriptions->expects($this->any())
						  ->method('canAttend')
						  ->will($this->returnValue(false));

		$student = new Student(self::LAST_NAME, self::FIRST_NAME, $userSubscriptions);
		$this->assertFalse($student->attendClass());
	}

	public function testAttendClassPassWhenStudentCanAttend() {
		$userSubscriptions = $this->getMock('\MASchoolManagement\Subscriptions\UserSubscriptions',
			array('canAttend'), array(), '', false);
		$userSubscriptions->expects($this->any())
						  ->method('canAttend')
						  ->will($this->returnValue(true));

		$student = new Student(self::LAST_NAME, self::FIRST_NAME, $userSubscriptions);
		$this->assertTrue($student->attendClass());
	}

	public function testAddMonthlySubscriptionWithGivenStartDateCallsFunctionOnUserSubscriptions() {
		$startDate = new \Zend\Date\Date();
		$userSubscriptions = $this->getMock('\MASchoolManagement\Subscriptions\UserSubscriptions',
			array('addMonthlySubscriptionWithGivenStartDate'), array(), '', false);
		$userSubscriptions->expects($this->once())
						  ->method('addMonthlySubscriptionWithGivenStartDate')
						  ->with($this->equalTo($startDate), $this->equalTo(3));

		$student = new Student(self::LAST_NAME, self::FIRST_NAME, $userSubscriptions);
		$student->addMonthlySubscriptionWithGivenStartDate($startDate, 3);
	}
}
