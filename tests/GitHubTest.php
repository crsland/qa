<?php

class GitHubTest extends PHPUnit_extends_Framework_TestCase{

    /**
     * @var \RemoteWebDriver
     */
    protected $webDriver;
	
	protected $url = 'https://github.com';
	
	public function setUp(){
		
		$capabilities = array(\WebDriverCapabilityType::BROWSER_NAME => 'firefox');
		$this->webDriver = RemoteWebDriver::create('http://localhost:4444/wd/hub', $capabilities);
	
	}
	
	public function testGitHubHome(){
	
		$this->webDriver->get($this->url);
		// checking that page title contains word 'GitHub'
		$this->assertContains('GitHub', $this->webDriver->getTitle());
	}
	
	public function testSearch(){
		$this->webDriver->get($this->url);
		// find search field by its id
		$search = $this->webDriver->findElement(\WebDriverBy::id('js-command-bar-field'));
		var_dump(get_class($search));
		// Wait for user to press enter in console.
		$this->waitForUserInput(); 
		
		$search->click();
		
		// Typing into a field.
		$this->webDriver->getKeyboard()->sendKeys('php-webdriver');
		// Pressing enter.
		$this->webDriver->getKeyBoard()->pressKey(WebDriverKeys::ENTER);
		
		$firstResult = $this->webDriver->findElement(
			// Some CSS Selectors can be very long.
			\WebDriverBy::cssSelector('li.public:nth-child(1) > h3:nth-child(3) > a:nth-child(1) > em:nth-child(2)')
		);
		
		$firstResult->click();
		
		// we expect that facebook/php-webdriver was the first result
		$this->assertContains('php-webdriver',$this->webDriver->getTitle());
		
		// checking current url
		$this->assertEquals(
			'https://github.com/facebook/php-webdriver',
			$this->webDriver->getCurrentURL()
		);
		
		$this->assertElementNotFound(\WebDriverBy::className('avatar'));
		
	}
	
	protected function waitForUserInput(){
		if(trim(fgets(fopen("php://stdin","r"))) != chr(13)) return;
	}
	
	protected function assertElementNotFound($by){
		$els = $this->webDriver->findElement($by);
		if(count($els)){
			$this->fail('Unexpectedly element was found');
		}
		// increment assertion counter
		$this->assertTrue(true);
	}
	
	
	public function tearDown(){
		$this->webDriver->close();
	}
	

}