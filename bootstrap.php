<?php

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/doctrine-bootstrap.php';

$app = new \API\Application\App(array('debug' => true));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/src/JRP/Views/',
));

$app->register(new \Silex\Provider\UrlGeneratorServiceProvider());

$app['messageService'] = function() use ($em, $app){
    $messageService = new \API\Message\Service\MessageService($em, new \API\Message\Entity\Message($app));

    return $messageService;
};

$app['messageSerializer'] = function() {
    return new \API\Message\Serializer\MessageSerializer(new \API\Message\Serializer\MessageTagSerializer());
};


$app['messageTagService'] = function() use($em){
    $tagService = new \API\Message\Service\MessageTagService($em, new \API\Message\Entity\Tag());

    return $tagService;
};

$app['messageTagSerializer'] = function(){
    return new \API\Message\Serializer\MessageTagSerializer();
};