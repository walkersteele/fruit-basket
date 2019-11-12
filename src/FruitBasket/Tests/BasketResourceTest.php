<?php

require __DIR__ . '/../../../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

class BasketResourceTest extends TestCase {

    private $basketResource;

    public function setUp(){
        $this->basketResource =  new \FruitBasket\Resource\BasketResource();
    }

    public function testCreateBasket(){
        $name = "PHPUnit Basket";
        $capacity = 10;
        $basket = $this->basketResource->createBasket($name, $capacity);
        $this->assertEquals($basket['name'], $name);
        $this->assertEquals($basket['capacity'], $capacity);

        return $basket['id'];
    }

    /**
     * @depends testCreateBasket
     */
    public function testRenameBasket($id){
        $name = "PHPUnit Basket (Changed)";
        $basket = $this->basketResource->renameBasket($id, $name);
        $this->assertEquals($basket['name'], $name);
    }

    /**
     * @depends testCreateBasket
     */
    public function testAddItem($id){
        $type = "apple";
        $weight = 1;
        $basket = $this->basketResource->addItem($id, $type, $weight);
        $this->assertEquals(1, count($basket['contents']));
        $this->assertEquals($basket['contents'][0]['type'], $type);
        $this->assertEquals($basket['contents'][0]['weight'], $weight);
    }

    /**
     * @depends testCreateBasket
     */
    public function testAddItemFailure($id){
        $type = "apple";
        $weight = 100;
        $basket = $this->basketResource->addItem($id, $type, $weight);
        $this->assertEquals($basket, false);
    }
}