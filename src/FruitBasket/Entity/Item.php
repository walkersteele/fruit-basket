<?php

namespace FruitBasket\Entity;

use FruitBasket\Entity\Basket;
use Doctrine\ORM\Mapping;

/**
 * @Entity
 * @Table(name="items")
 */
class Item
{
    /**
     * @var integer
     * 
     * @Id
     * @Column(name="item_id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

     /**
     * @var string
     * @Column(name="item_type", type="string", length=255)
     */
    protected $type;

    /**
     * @var int
     * @Column(type="integer", length=10)
     */
    protected $weight;

    /**
     * @ManyToOne(targetEntity="Basket", fetch="EAGER")
     * @JoinColumn(name="basket_id", referencedColumnName="basket_id")
     */
    protected $basket;



    public function getId():int{
        return $this->id;
    }

    public function setId(int $id){
        $this->id = $id;
    }

    public function getType():string{
        return $this->type;
    }

    public function setType(string $type){
        $this->type = $type;
    }

    public function getWeight():int{
        return $this->weight;
    }

    public function setWeight(int $weight){
        $this->weight = $weight;
    }

    public function getBasket():Basket{
        return $this->basket;
    }

    public function setBasket(Basket $basket){
        $this->basket = $basket;
    }
}