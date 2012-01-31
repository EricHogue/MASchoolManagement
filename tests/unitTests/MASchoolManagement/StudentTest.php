<?php
namespace MASchoolManagement;

use MASchoolManagement\Subscriptions\SubscriptionFactory;

class StudentTest extends \PHPUnit_Framework_TestCase {
	const FIRST_NAME = 'Eric';
	const LAST_NAME = 'Hogue';
	const ID = 12345;
	const RANK = 'kyu3';

	/** @var Student */
	private $student;

	public function setup() {
		$userSubscriptions = $this->getMock('\MASchoolManagement\Subscriptions\UserSubscriptions', null, array(), '', false);
		$this->student = new Student(self::ID, self::LAST_NAME, self::FIRST_NAME, self::RANK, $userSubscriptions);
	}

	public function testHasAFirstName() {
		$this->assertSame(self::FIRST_NAME, $this->student->getFirstName());
	}

	public function testHasLastName() {
		$this->assertSame(self::LAST_NAME, $this->student->getLastName());
	}

	public function testHasID() {
		$this->assertSame(self::ID, $this->student->getStudentId());
	}

	public function testAddMonthlySubscription() {
		$userSubscriptions = $this->getMock('\MASchoolManagement\Subscriptions\UserSubscriptions',
			array('addMonthlySubscription'), array(), '', false);
		$userSubscriptions->expects($this->once())
						 ->method('addMonthlySubscription')
						 ->with($this->equalTo(3));

		$student = new Student(self::ID, self::LAST_NAME, self::FIRST_NAME, self::RANK, $userSubscriptions);
		$student->addMonthlySubscription(3);
	}

	public function testGetEndOfSubscriptionDate() {
		$userSubscriptions = $this->getMock('\MASchoolManagement\Subscriptions\UserSubscriptions',
			array(), array(), '', false);
		$userSubscriptions->expects($this->once())
						 ->method('getLastAllowedDate')
						 ->will($this->returnValue('LastDate'));

		$student = new Student(self::ID, self::LAST_NAME, self::FIRST_NAME, self::RANK, $userSubscriptions);
		$this->assertSame('LastDate', $student->getEndOfSubscriptionDate());
	}

	public function testAddClassesSubscription() {
		$userSubscriptions = $this->getMock('\MASchoolManagement\Subscriptions\UserSubscriptions',
			array(), array(), '', false);
		$userSubscriptions->expects($this->once())
						 ->method('addClassesSubscription')
						 ->with($this->equalTo(5));

		$student = new Student(self::ID, self::LAST_NAME, self::FIRST_NAME, self::RANK, $userSubscriptions);
		$student->addClassesSubscription(5);
	}

	public function testGetRemainingClassesGetThemFromUserSubscriptions() {
		$userSubscriptions = $this->getMock('\MASchoolManagement\Subscriptions\UserSubscriptions',
			array(), array(), '', false);
		$userSubscriptions->expects($this->once())
						  ->method('getRemainingClasses');

		$student = new Student(self::ID, self::LAST_NAME, self::FIRST_NAME, self::RANK, $userSubscriptions);
		$student->getRemainingClasses();
	}

	public function testAttendClassFailsWhenNoSubscriptions() {
		$userSubscriptions = $this->getMock('\MASchoolManagement\Subscriptions\UserSubscriptions',
			array(), array(), '', false);
		$userSubscriptions->expects($this->any())
						  ->method('canAttend')
						  ->will($this->returnValue(false));

		$student = new Student(self::ID, self::LAST_NAME, self::FIRST_NAME, self::RANK, $userSubscriptions);
		$this->assertFalse($student->attendClass());
	}

	public function testAttendClassPassWhenStudentCanAttend() {
		$userSubscriptions = $this->getMock('\MASchoolManagement\Subscriptions\UserSubscriptions',
			array(), array(), '', false);
		$userSubscriptions->expects($this->any())
						  ->method('canAttend')
						  ->will($this->returnValue(true));
		$userSubscriptions->expects($this->once())
						  ->method('attendClass')
						  ->will($this->returnValue(true));

		$student = new Student(self::ID, self::LAST_NAME, self::FIRST_NAME, self::RANK, $userSubscriptions);
		$this->assertTrue($student->attendClass());
	}

	public function testAddMonthlySubscriptionWithGivenStartDateCallsFunctionOnUserSubscriptions() {
		$startDate = new \Zend\Date\Date();
		$userSubscriptions = $this->getMock('\MASchoolManagement\Subscriptions\UserSubscriptions',
			array(), array(), '', false);
		$userSubscriptions->expects($this->once())
						  ->method('addMonthlySubscriptionWithGivenStartDate')
						  ->with($this->equalTo($startDate), $this->equalTo(3));

		$student = new Student(self::ID, self::LAST_NAME, self::FIRST_NAME, self::RANK, $userSubscriptions);
		$student->addMonthlySubscriptionWithGivenStartDate($startDate, 3);
	}

	public function testAttendClassCallsAttendOnUserSubscriptions() {
		$userSubscriptions = $this->getMock('\MASchoolManagement\Subscriptions\UserSubscriptions',
			array(), array(), '', false);
		$userSubscriptions->expects($this->any())
						  ->method('canAttend')
						  ->will($this->returnValue(true));
		$userSubscriptions->expects($this->once())
						  ->method('attendClass')
						  ->will($this->returnValue(true));

		$student = new Student(self::ID, self::LAST_NAME, self::FIRST_NAME, self::RANK, $userSubscriptions);
		$student->attendClass();
	}

	public function testHasRank() {
		$this->assertSame(self::RANK, $this->student->getRank());
	}
}
