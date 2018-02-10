<?php

// php composer.phar require facebook/webdriver

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedConditions;
use PHPUnit\Framework\TestCase;

// composer global require phpunit/phpunit

class ToDoTest extends TestCase {

    protected $driver;

    public function setUp()
    {
        $capabilities = array("platform"=>"LINUX", "browserName" => "chrome", "version" => "64.0.3282.140");
        
        $host = "http://localhost:4444/wd/hub";
        $this->driver = RemoteWebDriver::create($host, $capabilities);
    }


    public function testToDos()
    {
        try {
            print "\nNavigating to URL\n";
            $this->driver->get("http://crossbrowsertesting.github.io/todo-app.html");
            sleep(3);
            print "Clicking Checkbox\n";
            $this->driver->findElement(WebDriverBy::name("todo-4"))->click();
            print "Clicking Checkbox\n";
            $this->driver->findElement(WebDriverBy::name("todo-5"))->click();
            $elems = $this->driver->findElements(WebDriverBy::className("done-true"));
            $this->assertEquals(2, count($elems));
            print "Entering Text\n";
            $this->driver->findElement(WebDriverBy::id("todotext"))->sendKeys("Run your first Selenium test");
            print "Adding todo to the list\n";
            $this->driver->findElement(WebDriverBy::id("addbutton"))->click();
            $spanText = $this->driver->findElement(WebDriverBy::xpath("/html/body/div/div/div/ul/li[6]/span"))->getText();
            $this->assertEquals("Run your first Selenium test", $spanText);
            print "Archiving old todos\n";
            $this->driver->findElement(WebDriverBy::linkText("archive"))->click();
            $elems = $this->driver->findElements(WebDriverBy::className("done-false"));
            $this->assertEquals(4, count($elems));
            // if we've made it this far, assertions have passed and we'll set the score to pass.
        } catch (Exception $ex) {
            // if we caught an exception along the way, an assertion failed and we'll set the score to fail.
            print "Caught Exception: " . $ex->getMessage();
        }
    }


    public function tearDown()
    {
        $this->driver->quit();
    }
}
