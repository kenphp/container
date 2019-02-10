<?php
namespace Test;

use DateTime;

use Ken\Container\Container;
use Ken\Container\NotFoundException;

class ContainerTest extends \Codeception\Test\Unit
{
    use \Codeception\Specify;

    /**
     * @var \Ken\Container\Container
     */
    protected $container;

    protected function _before()
    {
        $this->container = new Container([
            'title' => 'test',
        ]);
    }

    /**
     * Test **\Ken\Container\Container::set()** method
     */
    public function testSetMethod() {
        $this->specify('Test Set method - String', function () {
            $this->container->set('text', 'this is something');
            $this->assertEquals($this->container->get('text'), 'this is something', "Error asserting 'text' identifer");
        });

        $this->specify('Test Set method - Array', function () {
            $arr = [0, 1, 2, 3, 4, 5];
            $this->container->set('arr', $arr);
            $this->assertEquals($this->container->get('arr'), $arr, "Error asserting 'arr' identifer");
        });

        $this->specify('Test Set method - Object', function () {
            $json = json_encode(['name' => 'Object']);
            $this->container->set('obj', json_decode($json));
            $this->assertIsObject($this->container->get('obj'), "Identifier 'id' should be an object");
        });

        $this->specify('Test Set method - Closure', function () {
            $fn = function() {
                return 'Hello world!';
            };
            $this->container->set('fn', $fn);
            $this->assertEquals($this->container->get('fn'), 'Hello world!', "Error asserting 'fn' identifer");
        });
    }

    /**
     * Test **\Ken\Container\Container::get()** method
     */
    public function testGetMethod() {
        $this->specify('Test Get method - String', function () {
            $this->assertEquals($this->container->get('title'), 'test', "Error asserting 'title' identifer");
        });

        $this->specify('Test Get method - NotFoundException', function () {
            $this->expectException(NotFoundException::class);
            $this->container->get('nothing');
        });
    }

    /**
     * Test **\Ken\Container\Container::get()** method
     */
    public function testHasMethod() {
        $hasTitle = $this->container->has('title');
        $this->assertEquals(true, $hasTitle, 'Should be true');
        $hasNothing = $this->container->has('nothing');
        $this->assertEquals(false, $hasNothing, 'Should be fals');
    }

    /**
     * Test **\Ken\Container\Container::setFactory()** method
     */
    public function testSetFactoryMethod() {
        $this->specify('Test SetFactory', function () {
            $fn = function() {
                return new DateTime();
            };
            $this->container->set('fn', $fn);
            $this->assertInstanceOf(DateTime::class, $this->container->get('fn'), "Identifier 'id' should be an instance of 'DateTime' class");
        });
    }
}
