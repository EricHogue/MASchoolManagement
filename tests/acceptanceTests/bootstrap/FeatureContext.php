<?php

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

    /** @var ClassesSubscription */
    private $subscription;

    /** @var bool */
    private $response;



    /**
     * @Given /^I have "([^"]*)" classes Left$/
     */
    public function iHaveClassesLeft($classesCount)
    {
        $this->subscription = new ClassesSubscription($classesCount);
    }

    /**
     * @When /^I check if I can attend$/
     */
    public function iCheckIfICanAttend()
    {
        $this->response = $this->subscription->canAttend();
    }

    /**
     * @Then /^I should get "([^"]*)"$/
     */
    public function iShouldGet($expectedAnswer)
    {
    	assertEquals((bool) $expectedAnswer, $this->response);
    }



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
        throw new PendingException();
    }

    /**
     * @When /^he try to attend a class$/
     */
    public function heTryToAttendAClass()
    {
        throw new PendingException();
    }

    /**
     * @Then /^he should be denied$/
     */
    public function heShouldBeDenied()
    {
        throw new PendingException();
    }

    /**
     * @Given /^I have a student with (\d+) months left on a monthly subscription$/
     */
    public function iHaveAStudentWithMonthsLeftOnAMonthlySubscription($argument1)
    {
        throw new PendingException();
    }

    /**
     * @Then /^he should be accepted$/
     */
    public function heShouldBeAccepted()
    {
        throw new PendingException();
    }

    /**
     * @Given /^I have a student with (\d+) classes left$/
     */
    public function iHaveAStudentWithClassesLeft($argument1)
    {
        throw new PendingException();
    }

    /**
     * @Given /^I have a student with an expired monthly subscription$/
     */
    public function iHaveAStudentWithAnExpiredMonthlySubscription()
    {
        throw new PendingException();
    }


    /**
     * @Given /^he should have (\d+) classes left$/
     */
    public function heShouldHaveClassesLeft($argument1)
    {
        throw new PendingException();
    }

    /**
     * @Given /^I have a student without monthly subscription$/
     */
    public function iHaveAStudentWithoutMonthlySubscription()
    {
        throw new PendingException();
    }

    /**
     * @When /^I sell him a (\d+) months subscription$/
     */
    public function iSellHimAMonthsSubscription($argument1)
    {
        throw new PendingException();
    }

    /**
     * @Then /^his subscription should end in (\d+) months$/
     */
    public function hisSubscriptionShouldEndInMonths($argument1)
    {
        throw new PendingException();
    }

    /**
     * @When /^I sell him (\d+) classes$/
     */
    public function iSellHimClasses($argument1)
    {
        throw new PendingException();
    }

}
