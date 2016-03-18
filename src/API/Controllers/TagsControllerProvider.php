<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 17/03/2016
 * Time: 03:34
 */

namespace API\Controllers;


use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class TagsControllerProvider implements ControllerProviderInterface {

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

        $controllers->get('/', function() use ($app)
        {
            $categorias = $app['messageTagService']->read();
            $data =  $app['messageTagSerializer']->serializeAll($categorias);

            return $app->json($data);
        });

        $controllers->post('/', function(Request $request) use ($app){
            $create = $app['messageTagService']->create($request);

            return $app->json($create);
        });

        $controllers->get('/{id}', function($id) use($app){
            $categoria = $app['messageTagService']->read($id);
            $data = $app['messageTagSerializer']->serialize($categoria);

            return $app->json($data);
        });

        $controllers->put('/', function(Request $request) use($app){
            return $app->json($app['messageTagService']->update($request));
        });

        $controllers->delete('/{id}', function($id) use($app){
            return $app->json($app['messageTagService']->delete($id));
        });

        return $controllers;
    }

}