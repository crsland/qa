<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Behat\MinkExtension\Context\MinkContext;
//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
    }

    /**
     * @Given /^I am on the homepage$/
     */
    public function iAmOnTheHomepage()
    {
        throw new PendingException();
    }

    /**
     * @When /^I fill on "([^"]*)" with the value "([^"]*)"$/
     */
    public function iFillOnWithTheValue($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @When /^I press enter$/
     */
    public function iPressEnter()
    {
        throw new PendingException();
    }

    /**
     * @Then /^I should see the word "([^"]*)"$/
     */
    public function iShouldSeeTheWord($arg1)
    {
        throw new PendingException();
    }

	
//
// Place your definition and hook methods here:
//
//    /**
//     * @Given /^I have done something with "([^"]*)"$/
//     */
//    public function iHaveDoneSomethingWith($argument)
//    {
//        doSomethingWith($argument);
//    }
//
}
