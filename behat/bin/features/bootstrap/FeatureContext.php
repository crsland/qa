<?php
require("PhpAdder.php");
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

	private $Adder;
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

    /**
     * @Given /^I have the number (\d+) and the number (\d+)$/
     */
    public function iHaveTheNumberAndTheNumber($a, $b) {
        $this->Adder = new PhpAdder($a, $b);
    }	

    /**
     * @Given /^I have a third number of (\d+)$/
     */
    public function iHaveAThirdNumberOf($a) {
        $this->Adder = new PhpAdder($a, $this->Adder->sum);
    }
	
	/**
	 * @When /^I add them together$/
	 */
	public function iAddThemTogether() {
		$this->Adder->add();
	}
	
	/**
	* @Then /^I should get (\d+)$/
	*/
	public function iShouldGet($sum){
		if($this->Adder->sum !== $sum){
			throw new Exception("Actual sum: {$this->Adder->sum}");
		}
		$this->Adder->display();
	}
	
	/**
	* @Then /^I wait for the suggestion box to appear$/
	*/
	public function iWaitForTheSuggestionBoxToAppear(){
		$this->getSession->wait(5000, "$('.suggestions-results').children().length > 0");
	}
	
	
	
	
}