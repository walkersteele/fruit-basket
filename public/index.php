<?php
require __DIR__ . '/../vendor/autoload.php';

use \Slim\Container;
use \FruitBasket\Controller\BasketsController;

$container = new Container(["settings"=>["displayErrorDetails"=>true]]);
$container['BasketsController'] = function ($container){
    return new BasketsController($container);
};

$app = new \Slim\App($container);

$app->get("/", function() {
    return "Hello World";
});

$app->group('/baskets', function () {
    $this->get('/', 'BasketsController:getBaskets');
    $this->get('/{id:[0-9]+}', 'BasketsController:getOneBasket');
    $this->put('/{id:[0-9]+}', 'BasketsController:renameBasket');
    $this->delete('/{id:[0-9]+}', 'BasketsController:removeBasket');
    $this->post('/', 'BasketsController:createBasket');
    $this->post('/{id:[0-9]+}/item', 'BasketsController:addItemToBasket');
});


$app->run();