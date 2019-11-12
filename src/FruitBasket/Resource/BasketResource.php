<?php

namespace FruitBasket\Resource;

use FruitBasket\AbstractResource;
use FruitBasket\Entity\Basket;
use FruitBasket\Entity\Item;

/**
 * Class Resource
 * @package FruitBasket
 */
class BasketResource extends AbstractResource
{

    public function getOne($id){
        $basket = $this->getEntityManager()->find('FruitBasket\Entity\Basket', $id);
        if(is_null($basket)){
            return false;
        }
        return $this->convertToArray($basket);
    }

    public function getAll(){
        $baskets = $this->getEntityManager()->getRepository('FruitBasket\Entity\Basket')->findAll();
        $baskets = array_map(function($basket) {
            return $this->convertToArray($basket); },
            $baskets);
        return $baskets;
    }

    public function renameBasket($id, $name){
        $basket = $this->getEntityManager()->find('FruitBasket\Entity\Basket', $id);
        if(is_null($basket)){
            return false;
        }
        $basket->setName($name);
        $this->getEntityManager()->persist($basket);
        $this->getEntityManager()->flush();
        return $this->getOne($id);
    }

    public function removeBasket($id){
        $em = $this->getEntityManager();
        $basket = $em->getReference('FruitBasket\Entity\Basket', $id);
        foreach($basket->getContents() as $item){
            $em->remove($item);
        }
        $em->remove($basket);
        $em->flush();
    }

    public function createBasket($name, $capacity){
        $basket = new Basket();
        $basket->setName($name);
        $basket->setCapacity($capacity);
        $em = $this->getEntityManager();
        $em->persist($basket);
        $em->flush();

        return $this->convertToArray($basket);
    }

    public function addItem($basketId, $type, $weight){
        $em = $this->getEntityManager();
        $basket = $em->getReference('FruitBasket\Entity\Basket', $basketId);
        $item = new Item();
        $item->setType($type);
        $item->setWeight($weight);
        if($basket->addItem($item) === false){
            return false;
        }
        $em->persist($item);
        $em->flush();

        return $this->getOne($basketId);
    }

    private function convertToArray(Basket $basket) {
        $basketArray = [
            'id' => $basket->getId(),
            'name' => $basket->getName(),
            'capacity' => $basket->getCapacity(),
            'contents' => []
        ];

        foreach($basket->getContents() as $item){
            $basketArray['contents'][] = [
                'id' => $item->getId(),
                'weight' => $item->getWeight(),
                'type' => $item->getType()
            ];
        }

        return $basketArray;
    }
}