<?php

namespace FruitBasket\Controller;

use \Psr\Http\Message\ResponseInterface;
use \Psr\Http\Message\ServerRequestInterface;

class BasketsController
{

    protected $container;

    public function __construct(\Slim\Container $container){
        $this->container = $container;
        $this->basketResource =  new \FruitBasket\Resource\BasketResource();
    }

    public function getBaskets(ServerRequestInterface $request, ResponseInterface $response, $args) {
        $baskets = $this->basketResource->getAll();

        return $response->withJson($baskets, 200);
    }

    public function getOneBasket(ServerRequestInterface $request, ResponseInterface $response, $args) {
        $basket = $this->basketResource->getOne($args['id']);

        return $response->withJson($basket, 200);
    }

    public function renameBasket(ServerRequestInterface $request, ResponseInterface $response, $args) {
        $json = $request->getParsedBody();
        if(!isset($json['name']) || !is_string($json['name'])){
            return $response->withJson(["Message" => "Invalid Name"], 400);
        }
        $basket = $this->basketResource->renameBasket($args['id'],$json['name']);
        if($basket === false){
            return $response->withStatus(400);
        }

        return $response->withJson($basket, 200);
    }

    public function removeBasket(ServerRequestInterface $request, ResponseInterface $response, $args){
        $this->basketResource->removeBasket($args['id']);

        return $response->withStatus(204);
    }

    public function createBasket(ServerRequestInterface $request, ResponseInterface $response, $args){
        $json = $request->getParsedBody();
        if(isset($json['contents'])){
            return $response->withJson(["Message" => "Contents prohibited at creation."], 400);
        }
        if(!isset($json['name']) || !isset($json['capacity'])){
            return $response->withJson(["Message"=>"Name and Capacity are required to create a basket"]);
        }

        $basket = $this->basketResource->createBasket($json['name'], $json['capacity']);

        return $response->withJson($basket, 200);
    }

    public function addItemToBasket(ServerRequestInterface $request, ResponseInterface $response, $args){
        $json = $request->getParsedBody();
        if(!in_array(strtolower($json['type']), ['orange', 'watermelon', 'apple'])){
            return $response->withJson(["Message" => "Type must be one of ['orange', 'watermelon', 'apple']"], 400);
        }

        $basket = $this->basketResource->addItem($args['id'], $json['type'], $json['weight']);
        if($basket === false){
            return $response->withJson(["Message"=> "Unable to add item.  Basket over capacity."], 400);
        }

        return $response->withJson($basket, 200);

    }

}

