<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 17/03/2016
 * Time: 03:31
 */

namespace API\Message\Service;

use API\Message\Entity\Tag;
use Doctrine\ORM\EntityManager;
use API\Message\Entity\Message;
use API\Util\PaginatorTrait;

class MessageService {

    use PaginatorTrait;

    public $app;
    private $message;

    public function __construct(EntityManager $em, Message $message)
    {
        $this->em = $em;
        $this->message = $message;
    }


    public function read($id = null)
    {
        $repo = $this->em->getRepository("API\Message\Entity\Message");

        if(!is_null($this->getSearchParam()))
        {
            return $repo->searchByWord($this->getSearchParam(), $this->getPage());
        }

        return is_null($id) ? $repo->getMessages($this->getPage()) : $repo->find($id);
    }

    public function insert(array $data = array())
    {
       $this->message->setMessage($data['message']);
       if(isset($data['tag']))
        {
            $post_tags = json_decode($data['tag']);
            foreach($post_tags as $tag)
            {
                if(is_numeric($tag)) {
                    $tagEntity = $this->em->getReference("API\Message\Entity\Tag", $tag);
                    $this->message->addTag($tagEntity);
                } else {
                    $new_tag = new Tag();
                    $new_tag->setNome($tag);
                    $this->em->persist($new_tag);
                    $this->em->flush();

                    $this->message->addTag($new_tag);
                }
            }
        }

        try {
            $this->em->persist($this->message);
            $this->em->flush();
        } catch(\Exception $error) {
            return [
                'success' => false,
                'msg' => 'Erro ao inserir produto! Erro: ' . $error->getMessage()
            ];
        }

        return [
            'success' => true,
            'msg' => 'Message inserido com sucesso!',
            'produto' => [
                'id' => $this->message->getId()
            ]
        ];
    }



    public function update(array $data = array())
    {
        $id = $data['id'];

        $entity = $this->em->getReference("API\Message\Entity\Message", $id);

        $this->message->setMessage($data['message']);

        $this->em->persist($entity);
        $this->em->flush();

        return [
            'success' => true,
            'msg' => 'Message atualizado com sucesso!'
        ];
    }


    public function delete($id)
    {
        $message = $this->em->getReference("API\Message\Entity\Message", $id);

        if(!$message)
        {
            throw new \Exception("Message ID: {$message->getId()} não encontrado");
        }

        $this->em->remove($message);
        $this->em->flush();

        return [
            'success' => true,
            'msg' => 'Message excluído com sucesso!'
        ];
    }

    public function getByTag($id){
        $repo = $this->em->getRepository("API\Message\Entity\Message");

        return $repo->searchByTag($id);


    }

}