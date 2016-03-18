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
use Symfony\Component\HttpFoundation\Response;

class MessageControllerProvider implements ControllerProviderInterface{
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
            $getMessages = $app['messageService']->read();
            $messages = $app['messageSerializer']->serializeAll($getMessages);


            $getTags = $app['messageTagService']->read();
            $tags = $app['messageTagSerializer']->serializeAll($getTags);

            foreach($messages as $k => $message)
            {
                $messageTags = $message['tags'];
                if(!empty($messageTags)) {
                    unset($messages[$k]['tags']);
                    if (!isset($messageTags['id']) && count($messageTags) > 1) {
                        foreach ($messageTags as $tag) {
                            $messages[$k]['tags'][] = [
                                'id' => $tag['id'],
                                'nome' => $tag['nome']
                            ];
                            $tagsInline[] = $tag['nome'];
                        }
                    } else {
                        $message[$k]['tags'][] = [
                            'id' => $messageTags['id'],
                            'nome' => $messageTags['nome']
                        ];
                        $tagsInline[] = $messageTags['nome'];
                    }
                    $messages[$k]['tagsInline'] = implode(', ', $tagsInline);
                } else {
                    $message[$k]['tagsInline'] = '';
                }
            }

            $data = [
                'totalResults' => $getMessages['totalResults'],
                'currentPage' => ($getMessages['currentPage'] + 1),
                'totalPages' => $getMessages['totalPages'],
                'messages' => $messages,
                'tags' => $tags
            ];

            return $app->json($data);
        })->bind('messages');

        $controllers->post('/', function(\Symfony\Component\HttpFoundation\Request $request) use ($app)
        {
            $dados = $request->request->all();

            $inserir = $app['messageService']->insert($dados);

            if($inserir['success'] === true)
            {
                return $app->redirect('/messages');
            }

            return $app->json($inserir);
        });

        $controllers->post('/atualizar', function(\Symfony\Component\HttpFoundation\Request $request) use ($app) {
            $dados = $request->request->all();

            return $app->json($app['messageService']->updateColumn($dados));
        });

        $controllers->get('/excluir/{id}', function($id) use ($app)
        {
            $id = (int) $id;
            if($app['messageService']->delete($id)) {
                return $app->redirect($app['url_generator']->generate('messages'));
            }
        })->bind('message-excluir');


        return $controllers;
    }

}