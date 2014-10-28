<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
    Behat\Context\Alice;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Class CatalogContext
 *
 * @package Behat\Context\Alice
 */
class CatalogContext extends BaseContext
{

    /**
     * @Then /^I should get (\d+) results?$/
     */
    public function iShouldGetResults($n)
    {
        $page = $this->getPage('Alice\Catalog');
        $page->assertCatalogResults($n);
    }

    /**
     * Asserts if there are products in catalog page
     *
     * @Then /^I should see products in catalog$/
     */
    public function iShouldSeeProductsInCatalog()
    {
        /** @var \Behat\Context\Page\Alice\Catalog $catalogPage */
        $catalogPage = $this->getPage('Alice\Catalog');

        if (!$catalogPage->hasProducts()) {
            throw new LogicException();
        }
    }

    /**
     * Asserts that there are no products in catalog page
     *
     * @Then /^I should not see products in catalog$/
     */
    public function iShouldNotSeeProductsInCatalog()
    {
        /** @var Catalog $catalogPage */
        $catalogPage = $this->getPage('Alice\Catalog');

        if ($catalogPage->hasProducts()) {
            throw new LogicException();
        }
    }
}
