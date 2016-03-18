<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 17/03/2016
 * Time: 03:33
 */

namespace API\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class ApiControllerProvider implements ControllerProviderInterface {

    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
   
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/messages', function() use ($app)
        {
            $messages = $app['messageService']->read();

            return $app->json($app['messageSerializer']->serializeAll($messages));
        });

        $controllers->get('/messages/{id}', function($id) use ($app)
        {
            $message = $app['messageService']->read($id);

            return $app->json($app['messageSerializer']->serialize($message));
        });

        $controllers->get('/messages/tag/{id}', function($id) use ($app)
        {
            $message = $app['messageService']->getByTag($id);

            return $app->json($app['messageSerializer']->serializeAll($message));
        });

        $controllers->post('/messages', function(Request $request) use ($app){
            $dados = $request->request->all();

            return $app->json($app['messageService']->insert($dados));
        });

        $controllers->put('/messages', function(Request $request) use ($app){
            $dados = $request->request->all();

            return $app->json($app['messageService']->update($dados));
        });

        $controllers->delete('/messages/{id}', function ($id) use ($app)
        {
            return $app->json($app['messageService']->delete($id));
        });

        return $controllers;
    }

}