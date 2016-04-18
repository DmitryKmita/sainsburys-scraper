<?php


namespace App\Tests;


use App\Model\Product;
use App\Model\Result;
use App\Service\ScraperFactory;

class ScrapeServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Testing that we will get proper unit prices
     */
    public function testUnitPrice()
    {
        $factory = new ScraperFactory();
        $service = $factory->init();
        self::assertEquals(3.20, $this->invokeMethod($service, 'processUnitPrice', array('3.20<p>test</p>')));
        self::assertEquals(3.20, $this->invokeMethod($service, 'processUnitPrice', array('3.20')));
        self::assertEquals(0.00, $this->invokeMethod($service, 'processUnitPrice', array('')));
    }

    /**
     * Testing that we will get proper title
     */
    public function testTitleGetter()
    {
        $factory = new ScraperFactory();
        $service = $factory->init();
        self::assertEquals('title', $this->invokeMethod($service, 'processTitle', array('title <img src="test.png">')));
        self::assertEquals('title', $this->invokeMethod($service, 'processTitle', array('title')));
    }

    /**
     * Testing that Result sets correct total
     */
    public function testResultSetTotal()
    {
        $items = [];
        $sumShouldBe = 0;
        for ($i=1; $i<5; $i++) {
            $item = new Product();
            $item->setSize(1);
            $item->setDescription('Test description');
            $item->setTitle('Test Title');
            $item->setUnitPrice(mt_rand(10,20));
            $sumShouldBe += $item->getUnitPrice();
            $items[] = $item;
        }
        $resultSet = new Result();
        $resultSet->setItems($items);
        self::assertEquals($sumShouldBe, $resultSet->toArray()['total']);
    }


    /**
     * Testing that we get a proper json
     */
    public function testResultSetJson()
    {
        $factory = new ScraperFactory();
        $service = $factory->init();

        $item = new Product();
        $item->setSize(1);
        $item->setDescription('Test description');
        $item->setTitle('Test Title');
        $item->setUnitPrice(2);
        $items[] = $item;

        $expectedJson = '{"results":[{"title":"Test Title","size":"1kb","unit_price":2,"description":"Test description"}],"total":"2.00"}';

        self::assertEquals($expectedJson, $this->invokeMethod($service, 'processResult', array($items)));
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}