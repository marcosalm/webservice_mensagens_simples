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

class MessageSerializer implements SerializerInterface{

    public function __construct(MessageTagSerializer $tagSerializer)
    {
        $this->tagSerializer = $tagSerializer;
    }

    public function serialize($entity)
    {
        $tags = $this->tagSerializer->serializeAll($entity->getTags());

        return [
            'id' => $entity->getId(),
            'message' => $entity->getMessage(),
            'tags' => $tags
        ];
    }

    public function serializeAll($entities)
    {
        $entities = isset($entities['results']) ? $entities['results'] : $entities;

        $data = [];

        foreach($entities as $entity)
        {
            $tags = $this->tagSerializer->serializeAll($entity->getTags());

            array_push($data, [
                'id' => $entity->getId(),
                'message' => $entity->getMessage(),
                'tags' => $tags
            ]);
        }

        return $data;
    }

}