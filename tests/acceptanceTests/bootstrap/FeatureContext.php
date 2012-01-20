<?php

use MASchoolManagement\Subscriptions\SubscriptionFactory;
use MASchoolManagement\Subscriptions\UserSubscriptions;
use MASchoolManagement\Student;
use MASchoolManagement\Subscriptions\ClassesSubscription;
use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
	/** @var Student */
	private $student;

	/** @var boolean */
	private $canAttend;



    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param   array   $parameters     context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
    }

//
// Place your definition and hook methods here:


    /**
     * @Given /^I have a new student$/
     */
    public function iHaveANewStudent()
    {
        throw new PendingException();
    }

    /**
     * @When /^I create his profile$/
     */
    public function iCreateHisProfile()
    {
        throw new PendingException();
    }

    /**
     * @Then /^I can retrieve it back$/
     */
    public function iCanRetrieveItBack()
    {
        throw new PendingException();
    }

    /**
     * @Given /^I have a student With id: (\d+), firstname "([^"]*)", lastname: "([^"]*)" and rank: "([^"]*)"$/
     */
    public function iHaveAStudentWithIdFirstnameLastnameAndRank($argument1, $argument2, $argument3, $argument4)
    {
        throw new PendingException();
    }


    /**
     * @When /^I load his profile$/
     */
    public function iLoadHisProfile()
    {
        throw new PendingException();
    }

    /**
     * @Then /^his firstname should be "([^"]*)"$/
     */
    public function hisFirstnameShouldBe($argument1)
    {
        throw new PendingException();
    }

    /**
     * @Given /^his lastname should be "([^"]*)"$/
     */
    public function hisLastnameShouldBe($argument1)
    {
        throw new PendingException();
    }

    /**
     * @Given /^his rank should be "([^"]*)"$/
     */
    public function hisRankShouldBe($argument1)
    {
        throw new PendingException();
    }


    /**
     * @Given /^a student with no subscription$/
     */
    public function aStudentWithNoSubscription()
    {
    	$this->student = new Student('', '', new UserSubscriptions(new SubscriptionFactory()));
    }

    /**
     * @When /^he try to attend a class$/
     */
    public function heTryToAttendAClass()
    {
    	$this->canAttend = $this->student->attendClass();
    }

    /**
     * @Then /^he should be denied$/
     */
    public function heShouldBeDenied()
    {
    	assertFalse($this->canAttend);
    }

    /**
     * @Given /^(\d+) classes left$/
     */
    public function classesLeft($numberOfClassesLeft)
    {
    	$this->student->addClassesSubscription($numberOfClassesLeft);
    }


    /**
     * @Given /^I have a student with (\d+) months left on a monthly subscription$/
     */
    public function iHaveAStudentWithMonthsLeftOnAMonthlySubscription($numberOfMonths)
    {
    	$this->student = new Student('', '', new UserSubscriptions(new SubscriptionFactory()));
    	$this->student->addMonthlySubscription($numberOfMonths);
    }

    /**
     * @Then /^he should be accepted$/
     */
    public function heShouldBeAccepted()
    {
    	assertTrue($this->canAttend);
    }

    /**
     * @Given /^I have a student with (\d+) classes left$/
     */
    public function iHaveAStudentWithClassesLeft($numberOfClasses)
    {
    	$this->student = new Student('', '', new UserSubscriptions(new SubscriptionFactory()));
    	$this->student->addClassesSubscription($numberOfClasses);
    }

    /**
     * @Given /^I have a student with an expired monthly subscription$/
     */
    public function iHaveAStudentWithAnExpiredMonthlySubscription()
    {
    	$this->student = new Student('', '', new UserSubscriptions(new SubscriptionFactory()));
    	$startDate = new \Zend\Date\Date();
    	$startDate->addMonth(-2);
    	$this->student->addMonthlySubscriptionWithGivenStartDate($startDate, 1);
    }


    /**
     * @Given /^he should have (\d+) classes left$/
     */
    public function heShouldHaveClassesLeft($expectedRemainingClassesCount)
    {
    	assertSame((int) $expectedRemainingClassesCount, $this->student->getRemainingClasses());
    }

    /**
     * @Given /^I have a student without monthly subscription$/
     */
    public function iHaveAStudentWithoutMonthlySubscription()
    {
    	$this->student = new Student('', '', new UserSubscriptions(new SubscriptionFactory()));
    }

    /**
     * @When /^I sell him a (\d+) months subscription$/
     */
    public function iSellHimAMonthsSubscription($numberOfMonths)
    {
        $this->student->addMonthlySubscription($numberOfMonths);
    }

    /**
     * @Then /^his subscription should end in (\d+) months$/
     */
    public function hisSubscriptionShouldEndInMonths($numberOfMonths)
    {
    	$expectedEndDate = new \Zend\Date\Date();
    	$expectedEndDate->addMonth($numberOfMonths);
    	$expectedEndDate->addDay(-1);
    	$expectedEndDate->setTime('23:59:59', 'HH:mm:ss');

    	error_log($expectedEndDate);
    	error_log($this->student->getEndOfSubscriptionDate());

    	assertEquals($expectedEndDate, $this->student->getEndOfSubscriptionDate());
    }

    /**
     * @When /^I sell him (\d+) classes$/
     */
    public function iSellHimClasses($numberOfClasses)
    {
    	$this->student->addClassesSubscription($numberOfClasses);
    }

}
