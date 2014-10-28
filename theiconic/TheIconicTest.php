<?php

class TheIconicTest extends PHPUnit_Framework_TestCase{
	
	protected $url = 'http://www.theiconic.com.au/';	
    /**
     * @var \RemoteWebDriver
     */
    protected $webDriver;
	
	public function setUp(){

		$capabilities = array(\WebDriverCapabilityType::BROWSER_NAME => 'chrome');
		$this->webDriver = RemoteWebDriver::create('http://localhost:4444/wd/hub', $capabilities);
	}
	
	public function testHome(){
		$this->webDriver->get($this->url);
		$this->assertContains('Clothes online',$this->webDriver->getTitle());
	}
	
}