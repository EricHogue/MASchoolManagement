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
        $this->response = $this->subscription->canAttend(new \Zend\Date\Date());
    }

    /**
     * @Then /^I should get "([^"]*)"$/
     */
    public function iShouldGet($expectedAnswer)
    {
    	assertEquals((bool) $expectedAnswer, $this->response);
    }

}
