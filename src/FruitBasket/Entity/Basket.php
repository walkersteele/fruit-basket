<?php

namespace FruitBasket\Entity;

use Doctrine\ORM\Mapping;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * @Entity
 * @Table(name="baskets")
 */
class Basket
{
    /**
     * @var integer
     * 
     * @Id
     * @Column(name="basket_id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $name;

    /**
     * @var int
     * @Column(type="integer", length=10)
     */
    protected $capacity;

     /**
      * @var Collection|Item[]
     * @OneToMany(targetEntity="Item", mappedBy="basket", fetch="EAGER")
     * @JoinColumn(name="basket_id", referencedColumnName="basket_id")
     */
    protected $contents;

    public function __construct()
    {
        $this->contents = new ArrayCollection();
    }

    public function getId():int{
        return $this->id;
    }

    public function setId(int $id){
        $this->id = $id;
    }

    public function getName():string{
        return $this->name;
    }

    public function setName(string $name){
        $this->name = $name;
    }

    public function getCapacity():int{
        return $this->capacity;
    }

    public function setCapacity(int $capacity){
        $this->capacity = $capacity;
    }

    public function getContents():Collection{
        return $this->contents;
    }

    public function setContents($contents){
        $this->contents = $contents;
    }

    public function addItem(Item $item){
        if(!$this->contents->contains($item)){
            $currentCapacity = $this->getCapacity();
            foreach($this->getContents() as $content){
                $currentCapacity -= $content->getWeight();
            }
            if($item->getWeight() > $currentCapacity){
                return false;
            }
            $this->contents[] = $item;
            $item->setBasket($this);
        }
    }
}