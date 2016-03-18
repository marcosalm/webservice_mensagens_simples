<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 17/03/2016
 * Time: 03:32
 */

namespace API\Message\Service;

use Doctrine\ORM\EntityManager;
use API\Message\Entity\Tag;
use Symfony\Component\HttpFoundation\Request;

class MessageTagService {
    public function __construct(EntityManager $em, Tag $entity)
    {
        $this->em = $em;
        $this->entity = $entity;
    }

    public function create(Request $request)
    {
        try {
            $nome = $request->get('nome');
            $this->entity->setNome($nome);
            $this->em->persist($this->entity);
            $this->em->flush();

            return [
                'success' => true,
                'msg' => 'Tag criada com sucesso!',
                'tag' => [
                    'id' => $this->entity->getId()
                ]
            ];
        } catch(\Exception $e)
        {
            return [
                'success' => false,
                'msg' => $e->getMessage()
            ];
        }
    }

    public function read($id = null)
    {
        try {
            $repo = $this->em->getRepository("API\Message\Entity\Tag");

            return is_null($id) ? $repo->findAll() : $repo->find($id);
        } catch(\Exception $e)
        {
            return [
                'success' => false,
                'msg' => $e->getMessage()
            ];
        }
    }

    public function update(Request $request)
    {
        try {
            $id = $request->get("id");
            $nome = $request->get("nome");

            $repo = $this->em->getReference("API\Message\Entity\Tag", $id);
            $repo->setNome($nome);

            $this->em->persist($repo);
            $this->em->flush();

            return [
                'success' => true,
                'msg' => 'Tag atualizada com sucesso!'
            ];
        } catch(\Exception $e)
        {
            return [
                'success' => false,
                'msg' => $e->getMessage()
            ];
        }
    }

    public function delete($id)
    {
        try {
            $categoria = $this->em->getReference("API\Message\Entity\Tag", $id);
            $this->em->remove($categoria);

            return [
                'success' => true,
                'msg' => 'Tag removida com sucesso!'
            ];
        } catch(\Exception $e)
        {
            return [
                'success' => false,
                'msg' => $e->getMessage()
            ];
        }
    }

}