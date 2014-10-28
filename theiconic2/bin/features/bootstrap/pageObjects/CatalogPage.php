<?php

namespace Behat\Context\Page\Alice;

use Behat\Context\Page\BasePage;
use Behat\Mink\Element\NodeElement;
use Exception;
use LogicException;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\ElementNotFoundException;

/**
 * Class Catalog
 * @package Behat\Context\Page\Alice
 */
class Catalog extends BasePage
{

    /**
     * @var string
     */
    protected $path = '/{category}/';

    /**
     * @var array
     */
    protected $elements = array(
        'Catalog products' => ['css' => '#catalog-images-wrapper'],

        'Filter by Menu' => ['css' => '#filter-by-menu'],
        'Size Filter' => ['css' => '#facet-checkbox-facet_size'],
        'Universal Size Filter' => ['css' => '#facet-checkbox-facet_size_mapping_universal'],
        'Brand Filter' => ['css' => '#facet-checkbox-facet_brand'],
        'Colour Filter' => ['css' => '#facet-checkbox-facet_color_family'],
        '3hr Delivery Filter' => ['css' => '#facet-checkbox-facet_delivery'],
        'Price Filter' => ['css' => '#facet-radio-facet_price'],
        'Occasion Filter' => ['css' => '#facet-checkbox-facet_occasion'],
        'Sample Type Filter' => ['css' => '#facet-checkbox-facet_sample_type'],
        'Trend Filter' => ['css' => '#facet-checkbox-facet_trend'],

        'Category Tree' => ['css' => '#category-tree-facet'],
        'Subcategory Tree' => ['css' => '#subcategory-tree-facet'],
        'Menu' => ['css' => '#menu-container'],
        'Gender Back Link' => ['css' => '#gender-back'],

        'Catalog Results' => ['css' => '.items-count'],
    );

    protected $productsInWarehouses = [
        'Melbourne' => 'EZ832AA38XSN',
        'Sydney' => 'EZ832AA38XSN',
        'Dropshipment' => 'DV873SK22UAZ',
        'Both' => 'EZ832AA38XSN'
    ];

    protected $ribbonClasses = [
        'sale' => '.labels-sale-label'
    ];

    public function getProductSkuWithStockInWarehouse($warehouse)
    {
        try {
            return $this->productsInWarehouses[$warehouse];
        } catch (Exception $e) {
            return false;
        }
    }
    /**
     * @return bool
     */
    public function hasProducts()
    {
        try {
            $catalogProducts = $this->getElement('Catalog products');
        } catch (Exception $e) {
            return false;
        }

        $productsFound = $catalogProducts->findAll('css', 'figure');

        return count($productsFound) > 0;
    }

    /**
     * @param string $sku
     *
     * @return Product
     */
    public function clickOnProductWithSku($sku)
    {
        $catalogProducts = $this->waitForElement('Catalog products');
        $productFigure = $catalogProducts->find('css', '#' . $sku . ' .ti-catalog-product-image a.ti-catalog-product-link');
        $productFigure->click();

        return $this->getPage('Alice\Product');
    }


    /**
     * @return bool
     */
    public function hasFiltersOpened()
    {
        $filterBy = $this->getElement('Filter by Menu');

        $facets = $filterBy->findAll('css', '.facet ul');

        /** @var NodeElement $facet */
        foreach ($facets as $facet) {
            if ($facet->isVisible()) {
                return true;
            }
        }

        return false;
    }

    /**
     * checks if a filter is opened
     *
     * @param $filter
     * @return bool
     */
    public function isFilterOpened($filter)
    {
        $filter = $this->getElement(ucwords(strtolower($filter)) . ' Filter');

        $facetItems = $filter->find('css', 'ul');

        /** @var NodeElement $facet */
        if ($facetItems->isVisible()) {
            return true;
        }

        return false;
    }

    /**
     * checks if a filter is visible
     *
     * @param $filter
     * @return bool
     */
    public function hasFilter($filterName)
    {
        try {
            $this->waitUntilElementVisible(ucwords(strtolower($filterName)) . ' Filter');
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function isFilterAfter($filterName, $previousName)
    {
        $filter = $this->waitForElement(ucwords(strtolower($filterName)) . ' Filter');
        $previous = $this->waitForElement(ucwords(strtolower($previousName)) . ' Filter');

        $testPath = $filter->getXPath() . '/preceding-sibling::section/' . $previous->getXPath();

        return (null !== $this->find('xpath', $testPath));
    }

    /**
     * @param $sku
     * @param $ribbon
     * @throws LogicException
     * @internal param string $ribbonClass
     * @return bool
     */
    public function productHasRibbon($sku, $ribbon)
    {
        $ribbonClass = $this->ribbonClasses[$ribbon];

        $catalogProducts = $this->getElement('Catalog products');
        $product = $catalogProducts->find('css', '[data-sku="' . $sku . '"]');

        if (!$product->find('css', $ribbonClass)) {
            throw new LogicException;
        }
        return true;
    }

    /**
     * Checks if there's products of a specific brand visible in catalog
     *
     * @param string $brand
     *
     * @return bool
     */
    public function hasOnlyBrandProducts($brand)
    {
        /** @var NodeElement $catalogFound */
        $catalogFound = $this->waitForElement('Catalog products')->findAll('css', '.brand');

        if (count($catalogFound) < 1) {
            throw new Exception("No catalog products found");
        }

        foreach ($catalogFound as $item) {
            /** @var NodeElement $item */
            if ($item->getText() !== $brand) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param $categoryName
     * @return bool
     */
    public function hasCategory($categoryName)
    {
        $categoryMenuElement = $this->getCategoryMenuElement($categoryName);

        if (!is_null($categoryMenuElement)) {
            return true;
        }
    }

    /**
     * @param $categoryName
     * @return bool
     */
    public function hasSubcategory($categoryName)
    {
        $subcategoryTree = $this->getElement('Subcategory Tree');

        $input = $subcategoryTree->findById(str_replace(' ', '-', strtolower($categoryName)));
        if (!is_null($input)) {
            return true;
        }
    }

    /**
     * @param $categoryName
     * @return NodeElement|null
     * @throws \Exception
     */
    public function getCategoryMenuElement($categoryName)
    {
        try {
            $categoryTree = $this->waitForElement('Category Tree');
        } catch (ElementNotFoundException $e) {
            throw new Exception('Category Tree not found');
        }

        try {
            return $this->waitUntilElementVisible('xpath', sprintf('//a[text()="%s"]', $categoryName), $categoryTree);
        } catch (ElementNotFoundException $e) {
            throw new Exception(sprintf('Category "%s" not found', $categoryName));
        }
    }

    public function getGenderBackLinkElement()
    {
        try {
            $element = $this->waitForElement('Gender Back Link');
        } catch (ElementNotFoundException $e) {
            return null;
        }

        return $element;
    }

    public function getSidebar()
    {
        $menuContainer = $this->getElement('Menu');

        return $menuContainer;
    }

    public function getMenLink()
    {
        $sidebar = $this->getSidebar();

        return $sidebar->find('xpath', "//a[contains(text(),'Men')]");
    }

    public function addFirstProductToWishlist()
    {
        $firstProduct = $this->find('xpath', '//*[@id="catalog-images-wrapper"]/div/div/div[1]');

        if (!$firstProduct) {
            throw new LogicException("First product not found");
        }

        $wishlistLink = $firstProduct->find('css', '.icon-wishlist');

        if (!$wishlistLink) {
            throw new LogicException("Wishlist link not found");
        }

        $wishlistLink->click();
        $wishlistLink->blur();

        sleep(2); //give some time to the ajax request
    }

    /**
     * check the number of catalog results
     *
     * @param int $expected
     * @return bool
     * @throws \LogicException
     */
    public function assertCatalogResults($expected)
    {
        $element = $this->waitUntilElementVisible('Catalog Results');
        if ($expected != $actual = trim(preg_replace('/items?/', '', $element->getText()))) {
            throw new LogicException(sprintf('Unexpected number of catalog results: %d - expected: %d', $actual, $expected));
        }

        return true;
    }

}