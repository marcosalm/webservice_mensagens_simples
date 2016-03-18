<?php

namespace API\Interfaces;


interface SerializerInterface {

    public function serialize($entity);
    public function serializeAll($entities);

}