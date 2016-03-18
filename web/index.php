<?php

require_once '../bootstrap.php';

use API\Controllers\MessageControllerProvider;
use API\Controllers\ApiControllerProvider;

$app->get('/', function() use ($app)
{
    return $app->redirect($app['url_generator']->generate('api'));
});

//$app->mount('/messages', new MessageControllerProvider());
$app->mount('/api', new ApiControllerProvider());
$app->mount('/api/tags', new \API\Controllers\TagsControllerProvider());
$app->run();