<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 17/03/2016
 * Time: 03:31
 */

namespace API\Message\Serializer;


use API\Interfaces\EntityInterface;
use API\Interfaces\SerializerInterface;

class MessageTagSerializer implements SerializerInterface {

    public function serialize($entity)
    {
        $entity = $entity->getOwner();

        return [
            'id' => $entity->getId(),
            'nome' => $entity->getNome()
        ];
    }

    public function serializeAll($entities)
    {
        $entities = isset($entities['results']) ? $entities['results'] : $entities;

        if(count($entities) == 1)
        {
            return $this->serialize($entities);
        }

        $data = [];

        foreach($entities as $entity)
        {
            $data[$entity->getId()] = [
                'id' => $entity->getId(),
                'nome' => $entity->getNome()
            ];
        }

        return $data;
    }

}